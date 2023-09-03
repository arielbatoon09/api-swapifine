<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Throwable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminAuthController;

class AdminAuthController extends Controller
{
    public function admin()
    {
        return Auth::admin();
    }

    public function adminLogin(Request $request)
    {
        try {
            if (!empty($request->email) && !empty($request->password)) {

                if (!Auth::attempt($request->only('email', 'password'))) {
                    return response([
                        'source' => 'invalidCredentials',
                        'status' => 'error',
                        'message' => "Invalid Email or Password"
                    ]);
                } else {
                    $token = $request->admin()->createToken('pDE6g70A=ZE7medrby5O3V$S22%3=R&9h')->plainTextToken;
                    $cookie = cookie('jwt', $token, 60 * 24); // 1 Day Cookie Expiration
        
                    return response([
                        'status' => 'success',
                        'message' => 'Logged in successfully!',
                    ])->withCookie($cookie);
                }
                
            } else {
                return response([
                    'source' => 'emptyField',
                    'status' => 'error',
                    'message' => "Please fill out this field."
                ]);
            }

        } catch (Throwable $e) {
            return response([
                'status' => 'error',
                'message' => 'An error occurred while trying to log in.',
            ], 500);
        }
    }

    // Logout User
    // public function logout()
    // {
    //     try {
    //         $cookie = Cookie::forget('jwt');

    //         return response([
    //             'status' => 'success',
    //             'message' => 'Logout successfully!'
    //         ])->withCookie($cookie);
    //     } catch (Throwable $e) {
    //         return 'Error Catch: ' . $e->getMessage();
    //     }
    // }
}
