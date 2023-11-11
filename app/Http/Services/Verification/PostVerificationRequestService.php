<?php

namespace App\Http\Services\Verification;

use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Verification;

class PostVerificationRequestService
{
    public static function PostVerificationRequest(Request $request)
    {
        try {
            $verification = new Verification();

            $checkUser = $verification::where('user_id', Auth::user()->id)->first();

            if (filter_var($request->zip_code, FILTER_VALIDATE_INT) === false) {
                return response([
                    'status' => 'error',
                    'message' => "Invalid Zip Code",
                ]);
            }

            if (!$checkUser) {
                if (
                    !empty($request->legal_name) && !empty($request->address) && !empty($request->city) && !empty($request->zip_code) && !empty($request->dob)
                    && !empty($request->img_file_path) && !empty($request->status)
                ) {

                    $verification->create([
                        'user_id' => Auth::user()->id,
                        'legal_name' => $request->legal_name,
                        'address' => $request->address,
                        'city' => $request->city,
                        'zip_code' => $request->zip_code,
                        'dob' => $request->dob,
                        'img_file_path' => $request->img_file_path,
                        'status' => $request->status,
                    ]);

                    return response([
                        'status' => 'success',
                        'message' => "Sent verification successfully!",
                    ]);
                } else {
                    return response([
                        'status' => 'error',
                        'source' => 'isEmpty',
                        'message' => "Please fill out this field.",
                    ]);
                }
            } else {
                return response([
                    'status' => 'error',
                    'source' => 'existRequest',
                    'message' => "You already requested for a verification.",
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
