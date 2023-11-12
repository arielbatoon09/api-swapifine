<?php

namespace App\Http\Services\AdminDashboard;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementService
{
    public static function GetAllUserList()
    {
        try {
            $users = User::withCount('report')
                ->orderByDesc('report_count')
                ->get();

            $usersData = $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'fullname' => $user->fullname,
                    'email' => $user->email,
                    'total_report' => $user->report_count,
                    'profile_img' => $user->profile_img,
                    'created_date' => date('Y-m-d H:i:s', strtotime($user->created_at)),
                    'updated_date' => date('Y-m-d H:i:s', strtotime($user->updated_at)),
                ];
            });

            return response([
                'status' => 'success',
                'data' => $usersData,
            ]);
        } catch (Throwable $error) {
            response([
                'source' => 'error',
                'message' => 'ERROR' . $error
            ]);
        }
    }

    public static function UpdateUserByID(Request $request)
    {
        try {
            if (!empty($request->email)) {
                $updateUser = User::where('email', $request->email)->first();
                if (!$updateUser) {
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
        } catch (Throwable $error) {
            response([
                'source' => 'error',
                'message' => 'ERROR' . $error
            ]);
        }
    }

    public static function DeleteUserByID($id)
    {
        try {
            $deleteUser = User::find($id)->delete();
            if ($deleteUser) {
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
        } catch (Throwable $error) {
            return response([
                'source' => 'error',
                'status' => 'ERROR',
                'message' => 'ERROR' . $error->getMessage(),
            ]);
        }
    }
}
