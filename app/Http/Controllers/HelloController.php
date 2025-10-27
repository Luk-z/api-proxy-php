<?php

namespace App\Http\Controllers;

class HelloController extends Controller
{
    /**
     * Return a simple "Hello World" message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'message' => 'Hello World!'
        ]);
    }
}
