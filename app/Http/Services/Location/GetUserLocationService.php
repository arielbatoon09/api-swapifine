<?php

namespace App\Http\Services\Location;

use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;

class GetUserLocationService
{
    private static $getUserID;
    private static $userLocation;

    private static function initialize()
    {
        self::$getUserID = Auth::user()->id;
        self::$userLocation = new Location();
    }

    public static function GetUserLocation()
    {
        try {
            GetUserLocationService::initialize();

            $userLocation = self::$userLocation::where('user_id', self::$getUserID)->first();

            if ($userLocation) {
                return response([
                    'status' => 'success',
                    'data' => $userLocation,
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'data' => "No Data Found",
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
