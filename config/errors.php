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
        'title'  => 'The requested resource could not be found but may be available again in the future. Subsequent requests by the client are permissible.',
        'detail' => 'The resource you were looking for was not found.'
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
    ]

];