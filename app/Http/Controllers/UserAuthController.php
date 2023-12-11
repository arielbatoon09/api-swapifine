<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\PasswordResetModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Throwable;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

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
                        'token' => $token,
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
            return 'Error Catch: ' . $e->getMessage();
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

    // Forgot Password
    public function ForgotPassword(Request $request)
    {
        try {

            $user = User::where('email', $request->email)->get();

            if (count($user) > 0) {
                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'/reset-password?token='.$token;

                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = "Password Reset Notification";
                $data['body'] = "Kindly click on below link to reset your password.";

                Mail::send('ForgetPasswordMail', ['data' => $data], function($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });

                $dateTime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordResetModel::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => $dateTime,
                    ]
                );

                return response([
                    'status' => 'success',
                    'message' => 'Please check your mail to reset your password.',
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'User not found!'
                ]);
            }

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
    // Reset Password View Load
    public function ResetPasswordLoad(Request $request)
    {
        try {
            $resetData = PasswordResetModel::where('token', $request->token)->get();

            if (isset($request->token) && count($resetData) > 0) {
                $user = User::where('email', $resetData[0]['email'])->get();
                return view('resetPassword', compact('user'));
            }

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
    // Reset Password
    public function ResetPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string|min:6'
            ]);

            $user = User::find($request->id);
            $user->password = $request->password;
            $user->save();

            PasswordResetModel::where('email', $user->email)->delete();
            return "<h1>Your password has been reset successfully.</h1>";

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
