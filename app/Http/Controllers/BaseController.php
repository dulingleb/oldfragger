<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Info (
 *     title="Andrey Vorobey",
 *     version="1.0.0"
 * )
 */
class BaseController extends Controller
{
    public function sendResponse($result, $message = null): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => false,
            'error' => $error
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
