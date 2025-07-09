<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function successResponse($message = 'Thành công', $statusCode = 200, $data = null)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'code' => $statusCode
        ]);
    }

    /**
     * Return a JSON error response.
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message = 'Thất bại', $statusCode = 400, $errors = null)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
            'code' => $statusCode
        ]);
    }
}
