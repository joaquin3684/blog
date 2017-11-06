<?php

return [

    /*
    |—————————————————————————————————————
    | Default Errors
    |—————————————————————————————————————
    */

    'bad_request' => [
        'title'  => 'The server cannot or will not process the request due to something that is perceived to be a client error.',
        'detail' => 'Your request had an error. Please try again.'
    ],

    'forbidden' => [
        'title'  => 'The request was a valid request, but the server is refusing to respond to it.',
        'detail' => 'Your request was valid, but you are not authorised to perform that action.'
    ],

    'not_found' => [

        'title'  => 'El recurso buscado no se encontro.',
        'detail' => 'El recurso requerido no pudo ser encontrado pero puede estar disponible en un futuro.'
    ],

    'error_sistema' => [
        'title'  => 'Hay un error en el sistema.',
        'detail' => 'Por favor contactase con el personal de sistemas para solucionar estos problemas.'
    ],

    'exceso_de_plata' => [
    'title'  => 'Cantidad de dinero ingresada erronea.',
    'detail' => 'La cantidad de dinero ingresada es superior al monto que se puede cobrar.'
    ],

    'login_incorrecto' => [
        'title'  => 'El usuario/contraseña ingresados incorrectos.',
        'detail' => 'Por favor ingresar un usuario y contraseña validos.'
    ],

    'modificacion_incorrecta' => [
        'title' => 'Los campos unicos erroneos.',
        'detail' => 'Los campos unicos ingresados ya existen porfavor ingrese valores unicos.'
    ],

    'fecha_contable_cerrada' => [
        'title' => 'Fecha contable cerrada.',
        'detail' => 'La fecha contable ya esta en el dia actual.'
    ],

    'fecha_contable_ejercicio_cerrado' => [
        'title' => 'Fecha elejida erronea.',
        'detail' => 'La fecha elejida pertenece a un ejercicio cerrado.'
    ],

    'ejercicio_cerrado' => [
        'title' => 'Ejercicio cerrado.',
        'detail' => 'No se puede imputar en esta fecha el ejercicio ya esta cerrado.'
    ],

];