<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\AdminDashboard\TopUsersByPostsService;
use App\Http\Services\AdminDashboard\TotalNumbersService;
use App\Http\Services\AdminDashboard\UserManagementService;

class UserController extends Controller
{
    public function TopUsersByPosts()
    {
        return TopUsersByPostsService::TopUsersByPosts();
    }
    public function TotalNumbers()
    {
        return TotalNumbersService::TotalNumbers();
    }
    public function GetAllUserList()
    {
        return UserManagementService::GetAllUserList();
    }
    public function UpdateUserByID(Request $request)
    {
        return UserManagementService::UpdateUserByID($request);
    }
    public function DeleteUserByID($id)
    {
        return UserManagementService::DeleteUserByID($id);
    }
}