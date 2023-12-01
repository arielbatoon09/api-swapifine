<?php

namespace App\Http\Services\AdminDashboard;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class UpdateAdminPasswordService
{
    public static function UpdateAdminPassword(Request $request)
    {
        try {
            // Find the admin user by ID
            $admin = Admin::findOrFail(Auth::user()->id);

            // Check if the admin user exists
            if (!$admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Record not found!',
                ], 404);
            }

            // Check if the current password is correct
            if (!Hash::check($request->current_password, $admin->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Current password is incorrect.',
                ], 422);
            }

            // Check if the new password is different from the current password
            if ($request->current_password === $request->new_password) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'New password must be different from the current password.',
                ], 422);
            }

            // Check if the new password and confirm password match
            if ($request->new_password !== $request->confirm_password) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'New password and confirm password do not match.',
                ], 422);
            }

            // Update the password
            $admin->password = Hash::make($request->new_password);
            $admin->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Password updated successfully.',
            ]);
        } catch (Throwable $e) {
            return 'Error catch: ' . $e->getMessage();
        }
    }
}
