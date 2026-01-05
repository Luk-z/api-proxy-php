<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Helpers\AuthHelper;
use Illuminate\Http\Request;
use PATA\PATA;

class HelloController extends Controller
{
    /**
     * Return a simple "Hello World" message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        return response()->json([
            'message' => 'Hello World!',
        ]);
    }

    /**
     * Return a simple "Hello World" with authentication
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withAuth(Request $request) {
        $accessToken = AuthHelper::getAccessTokenFromRequest(["request" => $request]);
        $response = PATA::authenticate(["accessToken" => $accessToken]);

        if (! $response["result"]) {
            return ApiHelper::errorResponse([
                "responseCode" => 401,
                "additionalData" => $response["error"],
            ]);
        }

        return ApiHelper::successResponse([
            "data" => [
                'message' => 'Hello World withAuth!',
            ],
        ]);
    }

    /**
     * Return a simple "Hello World" with app login
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withLoginApp(Request $request) {
        $loginAppRes = ApiHelper::loginApp(["request" => $request]);

        if (! $loginAppRes["result"]) {
            return ApiHelper::loginErrorResponse();
        }

        return ApiHelper::successResponse([
            "data" => [
                'message' => 'Hello World withLoginApp!',
            ],
        ]);
    }
}
