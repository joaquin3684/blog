<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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

        return $this->handle($request, $e);
        if (config('app.debug')) {
            return parent::render($request, $e);
        }
    }

    private function handle($request, Exception $e)
    {

        if ($e instanceOf MiExceptionClass) {
            $data   = $e->toArray();
            $status = $e->getStatus();
        }

        if ($e instanceOf MasPlataCobradaQueElTotalException) {
            $data = array_merge([
                'id'     => 'exceso_de_plata',
                'status' => '404'
            ], config('errors.exceso_de_plata'));

            $status = 404;
        }

        if ($e instanceOf MethodNotAllowedHttpException) {
            $data = array_merge([
                'id'     => 'method_not_allowed',
            'status' => '405'
        ], config('errors.method_not_allowed'));

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
