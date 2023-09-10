<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminManagementController extends Controller
{
    public function AdminList()
    {
        try{
            $admins = Admin::all();
            if($admins->isEmpty()){
                return response([
                    'source' => 'AdminsNotFound',
                    'status' => 'error',
                    'message' => 'Unkown Admins',
                ]);
            }else{
                return $admins;
            }
        } catch (Throwable $error){
            response([
                'source' => 'error',
                'message' => 'ERROR' . $error
            ]);
        }
    }
}
