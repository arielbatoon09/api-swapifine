<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Support\Facades\Mail;

class AdminAuthController extends Controller
{
    
    public function invite(Request $request)
    {
        try {
            if (!empty($request->fullname) && !empty($request->email)) {
                if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    $getEmail = Admin::where('email', $request->email)->first();
                    if (!$getEmail) {
                        $randomPassword = Str::random(16);
                        // To create temporary account
                        Admin::create([
                            'fullname' => $request->input('fullname'),
                            'email' => $request->input('email'),
                            'password' => Hash::make($randomPassword), // Hash the random password
                        ]);

                        $data['email'] = $request->email;
                        $data['title'] = "Admin Invite Credentials";
                        $data['body'] = "Hi {$request->fullname}," . PHP_EOL .
                        "Your Admin Password: {$randomPassword}";        

                        Mail::send('AdminInvite', ['data' => $data], function($message) use ($data) {
                            $message->to($data['email'])->subject($data['title']);
                        });

                        return response([
                            'status' => 'success',
                            'message' => "Admin invite is now sent to the email.",
                            'password' => $randomPassword,
                        ]);
                    } else {
                        return response([
                            'source' => 'emailExist',
                            'status' => 'error',
                            'message' => "This email address is already in use."
                        ]);;
                    }
                } else {
                    return response([
                        'source' => 'emailNotValid',
                        'status' => 'error',
                        'message' => "Please enter a valid email address."
                    ]);
                }
            } else {
                return response([
                    'source' => 'emptyField',
                    'status' => 'error',
                    'message' => "Please fill out this field."
                ]);
            }
        } catch (Throwable $error) {
            return response([
                'status' => 'error',
                'message' => 'ERROR: ' . $error,
            ]);
        }
    }

    public function login(Request $request)
    {
        try {
            if (!empty($request->email) && !empty($request->password)) {

                $admin = Admin::where('email', $request->email)->first();

                if ($admin && Hash::check($request->password, $admin->password)) {

                    $token = $admin->createToken('pDE6g70A=ZE7medrby5O3V$S22%3=R&9h')->plainTextToken;
                    $cookie = cookie('jwt', $token, 60 * 24); // 1 Day Cookie Expiration

                    return response([
                        'status' => 'success',
                        'message' => 'Logged in successfully!',
                    ])->withCookie($cookie);
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
                'message' => 'ERROR: ' . $error,
            ]);
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
