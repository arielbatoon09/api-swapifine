<?php

namespace App\Http\Services\Location;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;

class PostLocationService
{
    private static $getUserID;
    private static $postLocation;
    private static $isEmpty;
    private static function initialize()
    {
        self::$getUserID = Auth::user()->id;
        self::$postLocation = new Location();
    }
    public static function PostLocation(Request $request)
    {
        try {
            // Function Init
            PostLocationService::initialize();
            PostLocationService::PostLocationValidation($request);

            if (!self::$isEmpty) {
                // Check if a PostLocation exists for the user
                $postLocation = self::$postLocation::where('user_id', self::$getUserID)->first();

                $setLoc = null;

                if (!$postLocation) {
                    $setLoc = PostLocationService::StorePostLocation($request);
                } else {
                    $setLoc = PostLocationService::UpdatePostLocation($request);
                }

                if ($setLoc) {
                    return response([
                        'status' => 'success',
                        'message' => "Successfully set the location!",
                    ]);
                } else {
                    return response([
                        'status' => 'error',
                        'message' => "Failed to set the location!",
                    ]);
                }
            } else {
                return response([
                    'data' => $request,
                    'status' => 'error',
                    'source' => 'isEmpty',
                    'message' => "Please fill out this field.",
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
    private static function StorePostLocation(Request $request)
    {
        try {
            self::$postLocation->create([
                'user_id' => self::$getUserID,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            return true;
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
    private static function UpdatePostLocation(Request $request)
    {
        try {
            $postLocation = self::$postLocation::where('user_id', self::$getUserID)->first();

            if ($postLocation) {
                $postLocation->update([
                    'user_id' => self::$getUserID,
                    'address' => $request->address,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]);

                return true;
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
    private static function PostLocationValidation(Request $request)
    {
        try {

            if (!empty($request->address) && !empty($request->latitude) && !empty($request->longitude)) {
                self::$isEmpty = false;
            } else {
                self::$isEmpty = true;
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
