<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class BaseApiController extends Controller
{
    public function success(JsonResource $resource)
    {
        return $this->sendResponse([
            'success' => true,
            'data' => $resource,
        ]);
    }

    public function error(string $message, int $code = Response::HTTP_BAD_REQUEST)
    {
        return $this->sendResponse([
            'success' => false,
            'message' => $message,
        ], $code);
    }

    public function notFound(string $message = 'Not found')
    {
        return $this->error($message, Response::HTTP_NOT_FOUND);
    }

    public function unauthorized(string $message = 'Unauthorized')
    {
        return $this->error($message, Response::HTTP_UNAUTHORIZED);
    }

    public function created(JsonResource $resource)
    {
        return $this->sendResponse([
            'success' => true,
            'data' => $resource,
        ], Response::HTTP_CREATED);
    }

    private function sendResponse(array $data, int $code = Response::HTTP_OK)
    {
        return response()->json($data, $code);
    }
}
