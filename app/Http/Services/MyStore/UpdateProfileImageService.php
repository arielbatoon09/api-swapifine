<?php

namespace App\Http\Services\MyStore;

use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic;

class UpdateProfileImageService
{
    public static function UpdateProfileImage(Request $request)
    {
        try {
            $user = User::findOrFail(Auth::user()->id);

            if (!$user) {
                return response([
                    'status' => 'error',
                    'message' => "Not found record!",
                ]);
            }

            if (!$request->img_file_path) {
                return response([
                    'status' => 'error',
                    'message' => "No image uploaded.",
                ]);
            }

            // Upload Image Path
            $imageDataArray = $request->input('img_file_path');
            $uploadPath = public_path('uploads/profile/user-' . Auth::user()->id);

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

            $user->update([
                'profile_img' => env('BACKEND_URL') . '/uploads/profile/user-' . $user->id . '/' . $randomFileName,
            ]);

            return response([
                'status' => 'success',
                'message' => "Updated profile image successfully!",
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
