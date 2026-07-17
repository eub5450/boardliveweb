<?php

namespace App\Http\Controllers\Api\V4;

use Illuminate\Http\Request;

class AgoraController extends \App\Http\Controllers\Api\AgoraController
{
    public function generateToken(Request $request)
    {
        return parent::generateToken($request);
    }
}
