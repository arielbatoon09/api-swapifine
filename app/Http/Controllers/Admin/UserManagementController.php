<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserManagementController extends Controller
{
    public function userList() {
        try {
            $allusers = User::all();
            if($allusers->isEmpty()) {
                return response([
                    'source' => 'UserListNotFound',
                    'status' => 'error',
                    'message' => 'Unknown Users',
                ]);
            } else {
                return $allusers;
            }

        } catch (Throwable $error) {
            response([
                'source' => 'error',
                'message' => 'ERROR' . $error
            ]);
        }
    }

    public function update(Request $request){
        try {
            if(!empty($request->email)){
                $updateUser = User::where('email', $request->email)->first();
                if(!$updateUser){
                    $resource = User::findorFail($request->input('id'));
                    $resource->update([
                        'fullname' => $request->input('fullname'),
                        'email' => $request->input('email'),
                    ]);
                    return response([
                        'status' => 'success',
                        'message' => "User updated.",
                    ]);
                } else {
                    return response([
                        'source' => 'userExists',
                        'status' => 'error',
                        'message' => 'user already in use.',
                    ]);
                }
            } else {
                return response([
                    'source' => 'category not valid',
                    'status' => 'error',
                    'message' => 'Enter valid email.',
                ]);
            }
        } catch (Throwable $error){
            response([
                'source' => 'error',
                'message' => 'ERROR' . $error
            ]);
        }
    }

    public function delete($id){
        try {
            $deleteUser = User::find($id)->delete();
            if($deleteUser){
                return response([
                    'status' => 'success',
                    'message' => "User deleted.",
                ]);
            } else {
                return response([
                    'source' => 'error',
                    'status' => 'error',
                    'message' => 'User could not be deleted.',
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
