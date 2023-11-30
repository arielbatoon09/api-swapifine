<?php

namespace App\Http\Services\Verification;

use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Http\Request;
use App\Models\Verification;

class PostVerificationRequestService
{
    public static function PostVerificationRequest(Request $request)
    {
        try {
            $verification = new Verification();

            $checkUser = $verification::where('user_id', auth()->user()->id)
                ->whereIn('status', ['Pending', 'Approved'])
                ->first();

            if (filter_var($request->zip_code, FILTER_VALIDATE_INT) === false) {
                return response([
                    'status' => 'error',
                    'message' => "Invalid Zip Code",
                ]);
            }

            if (!$checkUser) {
                if (
                    !empty($request->legal_name) && !empty($request->address) && !empty($request->city) && !empty($request->zip_code) && !empty($request->dob)
                    && !empty($request->img_file_path)
                ) {

                    // Upload Image Path
                    $imageDataArray = $request->input('img_file_path');
                    $uploadPath = public_path('uploads/verification/user-' . Auth::user()->id);

                    // Create the directory if it doesn't exist
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }

                    foreach ($imageDataArray as $imageDataObject) {
                        // Generate a random filename
                        $randomFileName = Str::random(50) . '.jpg';

                        // Decoding the upcoming images
                        $base64Data = $imageDataObject['data'];
                        $utf8EncodedData = mb_convert_encoding($base64Data, 'UTF-8');
                        $encoded = base64_encode($utf8EncodedData);
                        $decoded = base64_decode($encoded);
                        $image = ImageManagerStatic::make($decoded);
                        $image->save($uploadPath . '/' . $randomFileName);
                    }

                    $verification->create([
                        'user_id' => Auth::user()->id,
                        'legal_name' => $request->legal_name,
                        'address' => $request->address,
                        'city' => $request->city,
                        'zip_code' => $request->zip_code,
                        'dob' => $request->dob,
                        'img_file_path' => env('BACKEND_URL') . '/uploads/verification/user-' . Auth::user()->id . '/' . $randomFileName,
                        'status' => 'Pending',
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
