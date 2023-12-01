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
            return 'asdasdas';
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
