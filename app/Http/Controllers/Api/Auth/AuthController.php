<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $loginUser = User::where('email', $credentials['email'])->first();
        if ($loginUser) {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $loginUser->createToken('token')->plainTextToken;
                return response()->json([
                    'success'=> true,
                    'data' => [
                        "token"=> $token,
                        "user"=> $user,
                    ],
                    'errors' => null,
                    'message' => "Login başarılı",
                    ],200,
                );
            }
        }
        return response()->json([
            'success'=> false,
            'data' => null,
            'errors' => 'Unauthorized',
            'message' => "Login başarısız .Lütfen mail veya password kontrol edin !",
            ], 400
        );
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $role = $validated['role'] ?? 'user';
        $user->assignRole($role);




        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'success'=> true,
            'data' => [
                "token"=> $token,
                "user" => $user,
            ],
            'errors' => null,
            'message' => "Login başarılı",
            ],200,
        );
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();

        // Kullanıcının tüm tokenlarını geçersiz kıl
        PersonalAccessToken::where('tokenable_id', $user->id)->delete();

        return response()->json([
            'success'=> true,
            'data' => null,
            'errors' => null,
            'message' => "Logout başarılı",
            ],200,
        );
    }
}
