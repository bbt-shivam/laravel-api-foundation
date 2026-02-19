<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function success(
        mixed $data = null,
        string $message = 'Request completed successfully',
        int $status = 200,
        ?string $code = null
    ): JsonResponse {
        return response()->json([
            'error' => false,
            'status' => $status,
            'message' => $message,
            'code' => $code,
            'data' => $data,
        ], $status);
    }

    protected function error(
        string $message = 'Something went wrong!',
        int $status = 200,
        mixed $errors = null,
        ?string $code = null
    ): JsonResponse {
        return response()->json([
            'error' => [
                'status' => $status,
                'message' => $message,
                'code' => $code,
                'errors' => $errors,
            ],
        ], $status);
    }
}
