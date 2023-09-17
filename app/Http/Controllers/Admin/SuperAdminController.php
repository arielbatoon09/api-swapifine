<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;

class SuperAdminController extends Controller
{
    public function EmailUpdate(Request $request) {
        try {

        } catch (Throwable $error) {
            return response([
                'source' => 'error',
                'status' => 'ERROR',
                'message' => ''
            ]);
        }
    }

    public function PasswordUpdate(Request $request) {
        
    }
}
