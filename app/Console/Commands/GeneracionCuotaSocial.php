<?php

namespace App\Console\Commands;

use App\Cuotas;
use App\Socios;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GeneracionCuotaSocial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cuota_social:crear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'crear una cuota social';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $hoy =  Carbon::today()->toDateString();
       $socios = Socios::with(['cuotasSociales' => function ($q) use($hoy) {
            $q->where('fecha_vencimiento', $hoy);
       }], 'organismo')->whereHas('cuotasSociales', function($q) use ($hoy) {
           $q->where('fecha_vencimiento', $hoy);
       })->get();

        $fechaInicioCuota = Carbon::today()->addDay()->toDateString();
        $fechaVencimientoCuota = Carbon::today()->addMonth()->toDateString();
        $socios->each(function($socio) use ($fechaInicioCuota, $fechaVencimientoCuota){
            $cuota = Cuotas::create([
                'fecha_inicio' => $fechaInicioCuota,
                'fecha_vencimiento' => $fechaVencimientoCuota,
                'importe' => $socio->organismo->cuota_social,
                'nro_cuota' => 2,
                ]);
            $socio->cuotasSociales()->save($cuota);
        });

        Log::info("holaaa");
    }
}
