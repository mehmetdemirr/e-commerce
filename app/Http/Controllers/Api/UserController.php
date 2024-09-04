<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $logService;
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function user(Request $request)
    {
        // Bir uyarı logu
        $this->logService->logWarning('Kullanıcı bilgisi', 'Disk space is below 10%');
        return response()->json([
            'success'=> true,
            'data' => $request->user(),
            'errors' => null,
            'message' => null,
            ], 200
        );
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $request->user();
        // Güncelleme
        $user->update($request->only(['name', 'email', 'password']));

        // Şifreyi hash'le
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Kullanıcı bilgileri güncellendi.',
            'errors' => null,
        ], 200);
    }
}
