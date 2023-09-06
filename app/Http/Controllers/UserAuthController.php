<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
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
            if (!empty($request->fullname) && !empty($request->email) && !empty($request->password) && !empty($request->confirmPassword)) {
                if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    // Get Email
                    $getEmail = User::where('email', $request->email)->first();
                    if (!$getEmail) {
                        if (strlen($request->password) >= 6) {
                            if ($request->password == $request->confirmPassword) {

                                $user = User::create([
                                    'fullname' => $request->input('fullname'),
                                    'email' => $request->input('email'),
                                    'password' => $request->input('password'),
                                    'credits_amount' => $request->input('credits_amount', 0),
                                    'flag' => $request->input('flag', 0),
                                ]);

                                $token = $user->createToken('pDE6g70A=ZE7medrby5O3V$S22%3=R&9h')->plainTextToken;
                                $cookie = cookie('jwt', $token, 60 * 24); // 1 Day Cookie Expiration

                                event(new Registered($user));

                                return response([
                                    'status' => 'success',
                                    'message' => "Successfuly Registered!",
                                ])->withCookie($cookie);
                                
                            } else {
                                return response([
                                    'source' => 'passwordMatch',
                                    'status' => 'error',
                                    'message' => "Password does not match."
                                ]);
                            }
                        } else {
                            return response([
                                'source' => 'passwordShort',
                                'status' => 'error',
                                'message' => "Password is too short or below 6 characters."
                            ]);
                        }
                    } else {
                        return response([
                            'source' => 'emailExist',
                            'status' => 'error',
                            'message' => "This email address is already in use."
                        ]);
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
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
    public function login(Request $request)
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
                    $token = $request->user()->createToken('pDE6g70A=ZE7medrby5O3V$S22%3=R&9h')->plainTextToken;
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
