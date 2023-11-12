<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\AdminDashboard\TopUsersByPostsService;

class UserController extends Controller
{
    public function TopUsersByPosts()
    {
        return TopUsersByPostsService::TopUsersByPosts();
    }
}