<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait Responses {

    public function generalResponse(mixed $data, mixed $message = null, int $status = 200) : JsonResponse {
        return response()->json([
            'message' => __('responses.' . $message),
            'data' => $data,
        ], $status);
    }
}
