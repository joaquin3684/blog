<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Intervention\Image\Exception\NotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if (config('app.debug')) {
            return parent::render($request, $e);
        }
        return $this->handle($request, $e);
    }

    /**
     * @param $request
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function handle($request, Exception $e)
    {

        if ($e instanceOf MasPlataCobradaQueElTotalException) {
            $data = array_merge([
                'id'     => 'exceso_de_plata',
                'status' => '404'
            ], config('errors.exceso_de_plata'));

            $status = 404;
        } else if ($e instanceOf UsuarioOPasswordErroneosException) {
            $data = array_merge([
                'id'     => 'login_incorrecto',
                'status' => '404'
            ], config('errors.login_incorrecto'));

            $status = 404;
        } else if ($e instanceOf MethodNotAllowedHttpException) {
            $data = array_merge([
                'id' => 'method_not_allowed',
                'status' => '405'
            ], config('errors.method_not_allowed'));

            $status = 405;
        } else if($e instanceof NoSePuedeModificarElUsuarioException) {
            $data = array_merge([
                'id' => 'modificacion_incorrecta',
                'status' => '405'
            ], config('errors.modificacion_incorrecta'));

            $status = 405;
        } else if($e instanceof NotFoundException){
            $data = array_merge([
                'id' => 'not_found',
                'status' => '405'
            ], config('errors.not_found'));

            $status = 405;
        } else if($e instanceof LaFechaContablaYaEstaCerradaException){
            $data = array_merge([
                'id' => 'fecha_contable_cerrada',
                'status' => '405'
            ], config('errors.fecha_contable_cerrada'));

            $status = 405;
        }else if($e instanceof FechaContableElejidaEnEjercicioCerradoException){
            $data = array_merge([
                'id' => 'fecha_contable_ejercicio_cerrado',
                'status' => '405'
            ], config('errors.fecha_contable_ejercicio_cerrado'));

            $status = 405;
        } else if($e instanceof EjercicioCerradoException){
            $data = array_merge([
                'id' => 'ejercicio_cerrado',
                'status' => '405'
            ], config('errors.ejercicio_cerrado'));

            $status = 405;
        } else {
            $data = array_merge([
                'id'     => 'error_sistema',
                'status' => '404'
            ], config('errors.error_sistema'));

            $status = 405;
        }

        return response()->json($data, $status);
    }
    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
