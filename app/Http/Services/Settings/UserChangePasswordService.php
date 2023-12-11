<?php

namespace App\Http\Services\Settings;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserChangePasswordService
{
    public static function UserChangePassword(Request $request)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail(Auth::user()->id);

            // Check if the admin user exists
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Record not found!',
                ], 404);
            }

            // Check if the current password is correct
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Current password is incorrect.',
                ]);
            }

            // Check if the new password is different from the current password
            if ($request->current_password === $request->new_password) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'New password must be different from the current password.',
                ]);
            }

            // Check if the new password and confirm password match
            if ($request->new_password !== $request->confirm_password) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'New password and confirm password do not match.',
                ]);
            }

            // Update the password
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Password updated successfully.',
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
