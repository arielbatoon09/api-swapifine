<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\AdminDashboard\TopUsersByPostsService;
use App\Http\Services\AdminDashboard\TotalNumbersService;

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
}