<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB, Auth, Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $tokenName = 'Archidev_user';

            $token = Auth::user()->createToken($tokenName);

            return response()->json([
                'message' => 'User berhasil masuk',
                'token' => $token->plainTextToken,
                'type' => 'Bearer'
            ]);
        }
        else {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 401);
        }
    }

    public function register(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        DB::beginTransaction();

        try {
            if(!$user) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password)
                ]);

                DB::commit();

                $tokenName = 'Archidev_user';

                $token = $user->createToken($tokenName);

                return response([
                    'message' => 'User berhasil dibuat',
                    'token' => $token->plainTextToken,
                    'status' => 200
                ]);

            }
            else {
                DB::rollback();

                return response([
                    'message' => 'User sudah ada'
                ], 404);
            }
        }
        catch(\Exception $e) {
            Log::info($e);
            DB::rollback();

            return response([
                'message' => $e
            ], 500);
        }

    }

    public function logout(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();

        return response([
            'message' => 'User berhasil logout'
        ], 200);
    }
}
