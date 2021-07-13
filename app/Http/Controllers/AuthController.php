<?php

namespace App\Http\Controllers;

use App\Helpers\FormatResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator =  $request->validate([
            'name' => 'required|string|max:255',
            'account' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
        ]);

        $user = User::create([
            'name' => $validator['name'],
            'email' => $validator['email'],
            'account' => $validator['account'],
            'password' => Hash::make($validator['password']),
        ]);

        return response()->json($user);
    }

    public function login(Request $request) {
        if (!(
            Auth::attempt($request->only('email', 'password')) ||
            Auth::attempt($request->only('account', 'password'))
        )) {
            return response()->json(FormatResponse::error(403,'credentials'), 403);
        }

        $user = User::where('email', $request['email'])->orWhere('account', $request['account'])->first();

        $token = $user->createToken('auth_token');
        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }

    /*
    public function change_password(Request $request) {
        $validator =  $request->validate([
            'new_password' => 'required|string|min:8',
        ]);
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'error',
                'error' => [
                    'code' => 401,
                    'message' => 'Invalid authentication credentials.',
                    'localizedMessage' => '帳號資訊錯誤。',
                    'status' => 'UNAUTHENTICATED',
                    'details' => []
                ]
            ],401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $user->password = $validator['new_password'];
        $user->save();
        $token = $user->tokens()->delete();

        return response()->json([
            'status'=>'success'
        ]);
    }
    */

    public function me(Request $request) {
        $user = Auth::guard('sanctum')->user();
        return $user;
    }
}
