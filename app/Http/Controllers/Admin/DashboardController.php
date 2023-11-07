<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function totalUser(){
        try {
            $totalUser = User::count();
            if($totalUser === 0){ // Check if $totalUser is 0
                return response()->json([
                    'source' => 'NotFound',
                    'status' => 'error',
                    'message' => 'Unknown User'
                ], 404); // Return a 404 response
            } else {
                return response()->json([
                    'total_users' => $totalUser // Wrap in an array and provide a key for the count
                ]);
            }
        } catch (Throwable $error) {
            return response()->json([
                'source' => 'error',
                'message' => 'ERROR ' . $error
            ], 500); // Return a 500 response for internal server error
        }
    }

    public function topUser(){
        try{
            $TopUsers = Post::orderBy('user_id', 'desc')->first();
            if ($TopUsers) {
                return response()->json(['top_user' => $TopUsers]);
            } else {
                return response()->json(['message' => 'No top user found'], 404);
            }
        } catch (Throwable $error){
            response([
                'source' => 'error',
                'message' => 'ERROR' . $error
            ]);
        }
    }
}
