<?php

namespace App\Exceptions;
use function Couchbase\defaultDecoder;
use Illuminate\Support\Arr;
use App\Http\Libraries\ResponseBuilder;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
    public function render($request, Exception $exception)
    {

        if ($this->isHttpException($exception))
        {
            if ($exception->getStatusCode() == 404)
                return redirect()->guest('/404');

            if ($exception->getStatusCode() == 500)
                return redirect()->guest('/');
        }

        return parent::render($request, $exception);

        // findOrFail Exception handler
        if ($request->expectsJson() && $exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
          
            return (new ResponseBuilder(400, __('Bad request')))->build();
        }
        // Validator validation fail Exception handling
        if ($request->expectsJson() && $exception instanceof \Illuminate\Validation\ValidationException) {
            $errors = $exception->validator->errors()->getMessages();
            $firstErrorMessage = arr::first($errors);
            $response = ['success' => false, 'message' => $firstErrorMessage[0], 'data' => [
                'collection' => [],
                'pagination' => new \stdClass()
            ], 'errors' => []];
            foreach ($errors as $inputName => $messages) {
                $response['errors'][$inputName] = [
                    'hasError' => true,
                    'message' => arr::first($messages)
                ];
            }
            return response($response);
        }
//         convert remainging all Exception into JSON formate
        if ($request->expectsJson()) {
            return (new ResponseBuilder(422, (($exception->getMessage()) ? $exception->getMessage() : __('Something Went Wrong'))))->build();
        }
        return parent::render($request, $exception);
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
            return (new ResponseBuilder(401, __('Unauthenticated')))->build();
        }
        $guard = arr::get($exception->guards(), 0);
        switch ($guard) {
            case 'admin':
                $login = 'admin.auth.login.show-login-form';
                break;
            default:
                $login = 'front.auth.login';
                break;
        }
        return redirect()->guest(route($login));
    }
}
