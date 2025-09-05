<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{

    /**
     * successResponse
     *
     * @param  string $msg
     * @param  array|string|null $data
     * @param int $code
     * @return Response
     */
    public function successResponse(string $msg, array|string|null $data, int $code = 200): JsonResponse
    {
        $response = [
            'status' => true,
            'code' => $code,
            'msg' => $msg,
        ];

         if (!empty($data))
            $response['data'] = $data;

        return response()->json($response, $code);
    } //-- end of success response


    /**
     * errorResponse
     *
     * @param  string $message
     * @param  array|string|null $errorMessages
     * @param  int $code
     * @return Response
     */
    public function errorResponse(string $message, array|string|null $errorMessages, int $code = 404): JsonResponse
    {
        $response = [
            'status' => false,
            'code' => $code,
            'msg' => $message
        ];

        if (!empty($errorMessages))
            $response['errors'] = $errorMessages;

        return response()->json($response, $code);
    } //-- end of error response
}//-- end of class ResponseTrait
