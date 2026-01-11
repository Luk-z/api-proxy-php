<?php

namespace App\Http\Controllers;

use Tests\CustomIncludes\Helpers\CustomIncludesHelpers;

class CustomIncludesController extends Controller
{
    public function index() {
        return response()->json([
            'message' => CustomIncludesHelpers::test().' Custom Includes Controller!',
        ]);
    }
}
