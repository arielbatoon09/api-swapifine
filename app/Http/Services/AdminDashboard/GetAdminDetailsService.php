<?php

namespace App\Http\Services\AdminDashboard;

use Throwable;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class GetAdminDetailsService
{
    public static function GetAdminDetails()
    {
        try {
            $admin = Admin::findOrFail(Auth::user()->id);
            return $admin;
            
        } catch (Throwable $e) {
            return 'Error catch: ' . $e->getMessage();
        }
    }
}