<?php

namespace App\Http\Services\ReportedUser;

use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ReportedUser;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;

class PostReportUserService
{
    public static function PostReportUser(Request $request)
    {
        try {

            $reportedUser = new ReportedUser();

            if (empty($request->user_id) && empty($request->message) && empty($request->img_file_path)) {
                return response([
                    'status' => 'error',
                    'message' => "Please fill out this field.",
                ]);
            }

            // Upload Image Path
            $imageDataArray = $request->input('img_file_path');
            $uploadPath = public_path('uploads/report/user-' . Auth::user()->id);

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

            $reportedUser->create([
                'user_id' => $request->user_id,
                'reported_by' => Auth::user()->fullname,
                'message' => $request->message,
                'proof_img_path' => env('BACKEND_URL') . '/uploads/report/user-' . Auth::user()->id . '/' . $randomFileName,
            ]);

            return response([
                'status' => 'success',
                'message' => "Reported user successfully!",
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
