<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Location\GetUserLocationService;
use App\Http\Services\Location\GetSearchLocationService;
use App\Http\Services\Location\PostLocationService;


class LocationController extends Controller
{
    public function GetUserLocation()
    {
        return GetUserLocationService::GetUserLocation();
    }
    public function GetSearchLocation($location)
    {
        return GetSearchLocationService::GetSearchLocation($location);
    }
    public function PostLocation(Request $request)
    {
        return PostLocationService::PostLocation($request);
    }
}
