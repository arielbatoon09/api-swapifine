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

    public function update(Request $request){
        try {
            if(!empty($request->email)){
                $updateAdmin = Admin::where('email', $request->id)->first();
                if(!$updateAdmin){
                    $resource = Admin::findOrFail($request->input('id'));
                    $resource->update([
                        'fullname' => $request->input('fullname'),
                        'email' => $request->input('email'),
                    ]);
                    return response([
                        'status' => 'success',
                        'message' => "email updated.",
                    ]);
                } else {
                    return response([
                        'source' => 'adminExists',
                        'status' => 'error',
                        'message' => 'admin already in use.',
                    ]);
                }
            } else {
                return response([
                    'source' => 'email not valid',
                    'status' => 'error',
                    'message' => 'Enter valid email.',
                ]);
            }
        } catch (Throwable $error){
            return response([
                'source' => 'error',
                'message' => 'ERROR' . $error
            ]);
        }
    }

    public function delete($id){
        try {
            $deleteAdmin = Admin::find($id)->delete();
            if($deleteAdmin){
                return response([
                    'status' => 'success',
                    'message' => "Admin deleted.",
                ]);
            } else {
                return response([
                    'source' => 'error',
                    'status' => 'error',
                    'message' => 'Admin could not be deleted.',
            ]);
            }
        } catch (Throwable $error){
            return response([
                'source' => 'error',
                'status' => 'ERROR',
                'message' => 'ERROR' . $error->getMessage(),
            ]);
        }
    }
}
