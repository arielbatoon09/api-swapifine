<?php

namespace App\Http\Services\AdminDashboard;

use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class DeleteAdminAccountService
{
    public static function DeleteAdminAccount()
    {
        try {
            // Find the admin user by ID
            $admin = Admin::findOrFail(Auth::user()->id);

            $admin->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully deleted the admin.',
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
