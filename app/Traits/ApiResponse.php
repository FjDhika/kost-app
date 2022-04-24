<?php

namespace App\Traits;

trait ApiResponse
{

    public static function SuccessResponse(string $message, $data)
    {
        $responseData = [
            'status_code' => 200,
            'messsage' => $message,
            'data' => (object)$data,
        ];

        return response()->json($responseData);
    }

    protected function NotFoundError(string $message)
    {
        $responseData = [
            'status_code' => 404,
            'errMessage' => 'not_found',
            'messsage' => $message,
        ];

        return response()->json($responseData);
    }

    protected function BadRequestError($message)
    {
        $responseData = [
            'status_code' => 400,
            'errMessage' => 'bad_request',
            'messsage' => $message,
        ];

        return response()->json($responseData);
    }

    protected function UnauthorizeError($message)
    {
        $responseData = [
            'status_code' => 401,
            'errMessage' => 'Unauthorize',
            'messsage' => $message,
        ];

        return response()->json($responseData);
    }

    protected function InternalServerError($message)
    {
        $responseData = [
            'status_code' => 500,
            'errMessage' => 'internal_server_error',
            'messsage' => $message,
        ];

        return response()->json($responseData);
    }
}
