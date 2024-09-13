<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($data, $message = '', $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message
        ], $statusCode);
    }

    public static function error($message, $statusCode = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null
        ], $statusCode);
    }
}
