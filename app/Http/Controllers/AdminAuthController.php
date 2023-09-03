<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class AdminAuthController extends Controller
{

    public function adminLogin(Request $request)
    {
        try {
            if (!empty($request->email) && !empty($request->password)) {
                
                // $randomPassword = Str::random(16);
                // // To create temporary account
                // $admin = Admin::create([
                //     'fullname' => $request->input('fullname'),
                //     'email' => $request->input('email'),
                //     'password' => Hash::make($randomPassword), // Hash the random password
                //     'is_superadmin' => $request->input('is_superadmin', 0),
                // ]);

                // return response([
                //     'password' => $randomPassword,
                // ]);
                
                $admin = Admin::where('email', $request->email)->first();

                if ($admin && Hash::check($request->password, $admin->password)) {

                    $token = $admin->createToken('pDE6g70A=ZE7medrby5O3V$S22%3=R&9h')->plainTextToken;
                    $cookie = cookie('jwt', $token, 60 * 24); // 1 Day Cookie Expiration

                    return response([
                        'status' => 'success',
                        'message' => 'Logged in successfully!',
                    ])->withCookie($cookie);;

                } else {
                    return response([
                        'status' => 'error',
                        'message' => 'Invalid Credentials',
                    ]);
                }
                
            } else {
                return response([
                    'source' => 'emptyField',
                    'status' => 'error',
                    'message' => "Please fill out this field.",
                ]);
            }

        } catch (Throwable $error) {
            return response([
                'status' => 'error',
                'message' => 'An error occurred while trying to log in.'.$error,
            ], 500);
        }
    }

    public function logout()
    {
        try {
            $cookie = Cookie::forget('jwt');
            
            return response([
                'status' => 'success',
                'message' => 'Logout successfully!'
            ])->withCookie($cookie);

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
