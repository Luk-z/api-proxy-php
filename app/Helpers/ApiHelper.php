<?php

namespace App\Helpers;

class ApiHelper
{
    public static function jsonResponse($options = []) {
        $benchInfo = isset($options["benchInfo"]) ? $options["benchInfo"] : false;
        $success = isset($options["success"]) ? $options["success"] : false;
        $data = isset($options["data"]) ? $options["data"] : [];
        $additionalData = isset($options["additionalData"]) ? $options["additionalData"] : false;

        $baseResponse = [
            'success' => $success,
            'data' => $data,
        ];

        if ($additionalData) {
            $baseResponse = array_merge($baseResponse, $additionalData);
        }

        if ($benchInfo) {
            $includedFiles = get_included_files();
            $requestStartTime = $_SERVER['REQUEST_TIME_FLOAT'] ?? microtime(true);
            $time_REQUEST_TIME_FLOAT = number_format(microtime(true) - $requestStartTime, 5);
            $baseResponse["time"] = $time_REQUEST_TIME_FLOAT;
            $baseResponse["includedFiles"] = count($includedFiles);
        }

        return $baseResponse;
    }

    public static function errorResponse($options = []) {
        $responseCode = $options["responseCode"] ?? 400;
        if (! isset($options["benchInfo"])) {
            $options["benchInfo"] = true;
        }
        $options["success"] = false;

        return response()->json(
            self::jsonResponse($options),
            $responseCode,
            //['X-Header-One' => 'Header Value']
        );
    }

    public static function loginErrorResponse() {
        $options = [
            "additionalData" => [
                "message" => "Authentication failed",
                "code" => APP_ERROR_AUTH_ERROR,
            ],
            "responseCode" => 401,
        ];

        return self::errorResponse($options);
    }

    public static function successResponse($options = []) {
        if (! isset($options["benchInfo"])) {
            $options["benchInfo"] = true;
        }
        $options["success"] = true;
        $responseCode = $options["responseCode"] ?? 200;

        return response()->json(
            self::jsonResponse($options),
            $responseCode
        );
    }

    public static function loginApp($options = []) {
        $request = isset($options["request"]) ? $options["request"] : [];
        $token = $request->input('token') ?? $request->header('token');
        if ($token === null || trim($token) === '') {
            return ["result" => false];
        }
        $res = app('db')->table(APP_TABLE_APPS)->where("token", $token)->limit(1)->get();
        if ($res->count() === 0) {
            return ["result" => false];
        }

        return ["result" => true];
    }
}
