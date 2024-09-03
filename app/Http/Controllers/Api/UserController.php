<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user(Request $request)
    {
        return response()->json([
            'success'=> true,
            'data' => $request->user(),
            'errors' => null,
            'message' => null,
            ], 400
        );
    }
}
