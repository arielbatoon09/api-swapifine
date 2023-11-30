<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\MyStore\GetRatingsByUserIDService;

class RatingsController extends Controller
{
    public function GetRatingsByUserID()
    {
        return GetRatingsByUserIDService::GetRatingsByUserID();
    }
}
