<?php

namespace App\Http\Services\AdminDashboard;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class UpdateAdminBasicInformationService
{
    public static function UpdateAdminBasicInformation(Request $request)
    {
        try {
            $admin = Admin::findOrFail(Auth::user()->id);

            if (!$admin || !$request->fullname) {
                return response([
                    'status' => 'error',
                    'data' => 'Not found record!',
                ]);
            }

            $admin->update([
                'fullname' => $request->fullname,
            ]);

            return response([
                'status' => 'success',
                'data' => 'Updated successfully basic information.',
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
