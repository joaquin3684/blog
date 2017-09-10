<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 16/08/17
 * Time: 14:28
 */

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class FileManager
{

    public static function uploadImage($imagen, $ruta, $nombre)
    {
        $imagen->storeAs($ruta, $nombre, 'public');
    }

    public static function buscarImagenesSolicitud($id)
    {
        $imagenes = collect();

        $path1 = storage_path('app/public/solicitudes/solicitud'.$id.'/doc_domicilio.png');
        $path2 = storage_path('app/public/solicitudes/solicitud'.$id.'/doc_cbu.png');
        $path3 = storage_path('app/public/solicitudes/solicitud'.$id.'/doc_recibo.png');
        $path4 = storage_path('app/public/solicitudes/solicitud'.$id.'/doc_documento.png');
        $path5 = storage_path('app/public/solicitudes/solicitud'.$id.'/doc_endeudamiento.png');

        $domicilio = Image::make($path1)->encode('data-url');
        $recibo = Image::make($path2)->encode('data-url');
        $cbu = Image::make($path3)->encode('data-url');
        $documento = Image::make($path4)->encode('data-url');

        $j = Storage::disk('public')->exists('solicitudes/solicitud'.$id.'/doc_endeudamiento.png');

        $solGate = new SolicitudGateway();
        $endeudamiento =  $j == true ? Image::make($path5)->encode('data-url') : $solGate->find($id)->doc_endeudamiento;

        $imagenes->put('doc_domicilio', $domicilio);
        $imagenes->put('doc_recibo', $recibo);
        $imagenes->put('doc_documento', $documento);
        $imagenes->put('doc_cbu', $cbu);
        $imagenes->put('doc_endeudamiento', $endeudamiento);

        return $imagenes;


    }
}