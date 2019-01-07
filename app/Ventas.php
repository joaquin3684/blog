<?php

namespace App;

use App\Repositories\Eloquent\Cuota;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Generadores\GeneradorCuotas;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Ventas extends Model
{
	use SoftDeletes;

	protected $fillable = [
        'id_asociado', 'id_producto', 'descripcion', 'nro_cuotas', 'importe_total', 'nro_credito', 'fecha_vencimiento', 'importe_cuota', 'importe_otorgado', 'id_comercializador'
    ];

    protected $dates = ['deleted_at'];


    public function cuotas()
    {
    	return $this->morphMany(Cuotas::class, 'cuotable');
    }

    public function socio()
    {
    	return $this->belongsTo('App\Socios', 'id_asociado', 'id');
    }

    public function producto()
    {
    	return $this->belongsTo('App\Productos', 'id_producto', 'id');
    }

    public function movimientos()
    {
        return $this->hasManyThrough('App\Movimientos', 'App\Cuotas', 'cuotable_id', 'identificadores_id', 'id');
    }

    public function estados()
    {
        return $this->hasMany('App\EstadoVenta', 'id_venta', 'id');
    }

    public function crear()
    {
        $this->save();
        $cuotas = GeneradorCuotas::generarCuotasVenta($this);
        $this->cuotas()->createMany($cuotas->toArray());
        $this->contabilizar();

    }

    public function modificar($ventaModificada)
    {
        $this->cancelarContabilizacion();
        $this->fill($ventaModificada);
        $this->save();
        GeneradorCuotas::borrarCuotasVenta($this);
        $cuotas = GeneradorCuotas::generarCuotasVenta($this);
        $this->cuotas()->createMany($cuotas->toArray());
        $this->contabilizar();
    }

    public function cancelarContabilizacion()
    {
        if($this->producto->proovedor->id == 1)
        {
            $impuDebe = ImputacionGateway::buscarPorCodigo('131010001');
            $impuHaber = ImputacionGateway::buscarPorCodigo('111010201'); //TODO hay que ver la seleccion del banco aca
            GeneradorDeAsientos::crear($impuDebe,  0, $this->importe_otorgado);
            GeneradorDeAsientos::crear($impuHaber, $this->importe_otorgado, 0);

            $interes = $this->importe_total - $this->importe_otorgado;
            $impuDebe = ImputacionGateway::buscarPorCodigo('131010004');
            $impuHaber = ImputacionGateway::buscarPorCodigo('131020403'); //TODO hay que ver la seleccion del banco aca
            GeneradorDeAsientos::crear($impuDebe, 0, $interes);
            GeneradorDeAsientos::crear($impuHaber, $interes, 0);

        } else {
            $impuDebe = ImputacionGateway::buscarPorCodigo('131010002');
            $impuHaber = ImputacionGateway::buscarPorCodigo('131020402');

            $importe = $this->importe_total * $this->getComision() / 100;
            GeneradorDeAsientos::crear($impuDebe, 0, $importe);
            GeneradorDeAsientos::crear($impuHaber, $importe, 0);
        }
    }

    public function contabilizar()
    {
        if($this->producto->proovedor->id == 1)
        {
            $impuDebe = ImputacionGateway::buscarPorCodigo('131010001');
            $impuHaber = ImputacionGateway::buscarPorCodigo('111010201'); //TODO hay que ver la seleccion del banco aca
            GeneradorDeAsientos::crear($impuDebe, $this->importe_otorgado, 0);
            GeneradorDeAsientos::crear($impuHaber, 0, $this->importe_otorgado);

            $interes = $this->importe_total - $this->importe_otorgado;
            $impuDebe = ImputacionGateway::buscarPorCodigo('131010004');
            $impuHaber = ImputacionGateway::buscarPorCodigo('131020403'); //TODO hay que ver la seleccion del banco aca
            GeneradorDeAsientos::crear($impuDebe, $interes, 0);
            GeneradorDeAsientos::crear($impuHaber, 0, $interes);

        } else {
            $impuDebe = ImputacionGateway::buscarPorCodigo('131010002');
            $impuHaber = ImputacionGateway::buscarPorCodigo('131020402');

            $importe = $this->importe_total * $this->getComision() / 100;
            GeneradorDeAsientos::crear($impuDebe, $importe, 0);
            GeneradorDeAsientos::crear($impuHaber, 0, $importe);
        }
    }


    public function cobrar($monto)
    {
        $montoContable = $monto;
        $this->cuotas->each(function(Cuotas $cuota) use (&$monto){
            if ($monto == 0)
                return false;
            $cobrado = $cuota->cobrar($monto);
            $monto -= $cobrado;
        });

        $montoContableReal = $montoContable - $monto;
        $this->contabilizarCobro($montoContableReal);

        return $monto;
    }

    public function contabilizarCobro($montoContableReal)
    {
        if($this->producto->proovedor->id == 1)
        {
            $impuBanco = ImputacionGateway::buscarPorCodigo('111010201');
            $impuComisionPagadaOrganismo = ImputacionGateway::buscarPorCodigo('521020218');
            $impuPrestamosACobrar = ImputacionGateway::buscarPorCodigo('131010001');
            $impuInteresesACobrar = ImputacionGateway::buscarPorCodigo('131010004');

            $comisionPagada = 0; // TODO aca hay que calcular la comision del organismo

            $totalBanco = $montoContableReal - $comisionPagada;
            $interesesACobrar = $montoContableReal * $this->getInteres() / 100;
            $prestamosACobrar = $montoContableReal - $interesesACobrar;

            GeneradorDeAsientos::crear($impuComisionPagadaOrganismo, $comisionPagada, 0);
            GeneradorDeAsientos::crear($impuBanco, $totalBanco, 0);

            GeneradorDeAsientos::crear($impuPrestamosACobrar, 0, $interesesACobrar);
            GeneradorDeAsientos::crear($impuInteresesACobrar, 0, $prestamosACobrar);

        } else {
            $impuBanco = ImputacionGateway::buscarPorCodigo('111010201');
            $impuComisionPagadaOrganismo = ImputacionGateway::buscarPorCodigo('521020218');
            $impuFondoTerceroAPagar = ImputacionGateway::buscarPorCodigo('131010003');
            $impuComisionesACobrar = ImputacionGateway::buscarPorCodigo('131010002');
            $impuInteresesAPagar = ImputacionGateway::buscarPorCodigo('311020001');


            $comisionPagada = 0; // TODO aca hay que calcular la comision del organismo
            $totalBanco = $montoContableReal - $comisionPagada;
            $comisionGanada = $montoContableReal * $this->getComision() / 100;
            $interesAPagar = $montoContableReal * $this->getInteres() / 100;
            $capital = $montoContableReal - $comisionGanada - $interesAPagar;

            GeneradorDeAsientos::crear($impuBanco, $totalBanco, 0);
            GeneradorDeAsientos::crear($impuComisionPagadaOrganismo, $comisionPagada, 0);


            GeneradorDeAsientos::crear($impuFondoTerceroAPagar, 0, $capital);
            GeneradorDeAsientos::crear($impuComisionesACobrar, 0, $comisionGanada);
            GeneradorDeAsientos::crear($impuInteresesAPagar, 0, $interesAPagar);
        }
    }

    public function pagarProveedor()
    {

        $totalCuotas = $this->cuotas->sum(function( Cuotas $cuota){ return $cuota->totalCobrado();});

        $ganancia = $this->getComision();
        $totalPagado = $this->cuotas->sum(function (Cuotas $cuota) use ($ganancia) {
            return $cuota->pagarProveedor($ganancia);
        });

        $interesAPagar = $totalCuotas * $this->getInteres() /100;
        $capital = $totalPagado - $interesAPagar;


        $impuInteresesAPagar = ImputacionGateway::buscarPorCodigo('311020001');
        $impuFondoTerceroAPagar = ImputacionGateway::buscarPorCodigo('311020003');
        $impuBanco = ImputacionGateway::buscarPorCodigo('111010201');


        GeneradorDeAsientos::crear($impuBanco, 0, $totalPagado);
        GeneradorDeAsientos::crear($impuInteresesAPagar, $interesAPagar, 0);
        GeneradorDeAsientos::crear($impuFondoTerceroAPagar, $capital, 0);

    }

    public function getComision()
    {
        return $this->producto->ganancia;
    }

    public function getInteres()
    {
        return $this->producto->tasa;
    }

}
