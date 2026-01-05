<?php

namespace App\Helpers;

use PATA\PATA;

class AuthHelper
{
    public static function getAccessTokenFromRequest($options = []) {
        $request = $options["request"] ?? false;
        if (! $request) {
            return "";
        }

        return $request->header(PATA::$accessTokenName) ?? $request->input(PATA::$accessTokenName);
    }
}
