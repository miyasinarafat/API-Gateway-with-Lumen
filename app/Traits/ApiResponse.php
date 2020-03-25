<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\ResponseFactory;

trait ApiResponse
{
    /**
     * @param $data
     * @param int $code
     * @return Response|ResponseFactory
     */
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response($data, $code)->header('Content-Type', 'application/json');
    }

    /**
     * @param $data
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    public function validResponse($data, $message, $code = Response::HTTP_OK)
    {
        return new JsonResponse([
            'data' => $data,
            'status' => [
                'message' => $message,
                'code' => $code
            ]
        ], $code);
    }

    /**
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    public function
    errorResponse($message, $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return new JsonResponse([
            'error' => $message,
            'code' => $code
        ], $code);
    }

    /**
     * @param $message
     * @param int $code
     * @return Response|ResponseFactory
     */
    public function errorMessage($message, $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return response($message, $code)->header('Content-Type', 'application/json');
    }
}
