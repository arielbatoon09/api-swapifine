<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Throwable;

class UserAuthController extends Controller
{
    public function user()
    {
        return Auth::user();
    }

    // Register User
    public function register(Request $request)
    {
        try {
            User::create([
                'fullname' => $request->input('fullname'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'is_verified' => $request->input('is_verified', 0),
                'credits_amount' => $request->input('credits_amount', 0),
                'flag' => $request->input('flag', 0),
            ]);

            return response([
                'status' => 'success',
                'message' => "Successfuly Registered!"
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
    public function login(Request $request)
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response([
                    'status' => 'error',
                    'message' => "Invalid Credentials!"
                ]);
            }
     
            $token = $request->user()->createToken('pDE6g70A=ZE7medrby5O3V$S22%3=R&9h')->plainTextToken;
            $cookie = cookie('jwt', $token, 60 * 24); // 1 Day Cookie Expiration
    
            return response([
                'status' => 'success',
                'message' => 'Logged in successfully!',
            ])->withCookie($cookie);
    
        } catch (Throwable $e) {
            return response([
                'status' => 'error',
                'message' => 'An error occurred while trying to log in.',
            ], 500);
        }
    }

    // Logout User
    public function logout()
    {
        try {
            $cookie = Cookie::forget('jwt');

            return response([
                'status' => 'success',
                'message' => 'Logout successfully!'
            ])->withCookie($cookie);

        } catch (Throwable $e) {
            return 'Error Catch: '. $e->getMessage();
        }
    }
}
