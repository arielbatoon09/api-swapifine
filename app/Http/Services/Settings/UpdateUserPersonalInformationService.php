<?php

namespace App\Http\Services\Settings;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UpdateUserPersonalInformationService
{
    public static function UpdateUserPersonalInformation(Request $request)
    {
        try {
            $user = User::findOrFail(Auth::user()->id);

            if (!$user || !$request->fullname) {
                return response([
                    'status' => 'error',
                    'message' => 'Not found record!',
                ]);
            }

            $user->update([
                'fullname' => $request->fullname,
            ]);

            return response([
                'status' => 'success',
                'message' => 'Updated successfully personal information.',
            ]);

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}