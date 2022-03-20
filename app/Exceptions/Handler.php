<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

//    public function render($request, Throwable $exception)
//    {
//        $code = 422;
//
//        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
//            return response()->json(['status' => false, 'message' => 'Not Found!'], 404, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
//        }
//
//        if ($exception instanceof AuthenticationException) {
//            $code = 401;
//        }
//
//        $message = $this->convert_from_latin1_to_utf8_recursively($exception->getMessage());
//
//        if ($exception instanceof ValidationException) {
//            return response()->json(['status' => false, 'message' => $message, 'errors' => $exception->validator->errors()],422, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
//        }
//
////        return response()->json([
////            'status' => false,
////            'message' => $message,
////            'file' => $exception->getFile(),
////            'line' => $exception->getLine(),
////            'trace' => $exception->getTrace()],
////            $code, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
//        return parent::prepareJsonResponse($request, $exception);
//    }

//    public function convert_from_latin1_to_utf8_recursively($dat)
//    {
//        if (is_string($dat)) {
//            return utf8_encode($dat);
//        } elseif (is_array($dat)) {
//            $ret = [];
//            foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);
//
//            return $ret;
//        } elseif (is_object($dat)) {
//            foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);
//
//            return $dat;
//        } else {
//            return $dat;
//        }
//    }
}
