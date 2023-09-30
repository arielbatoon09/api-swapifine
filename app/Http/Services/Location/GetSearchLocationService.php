<?php

namespace App\Http\Services\Location;

use Throwable;

class GetSearchLocationService
{
    public static function GetSearchLocation($location)
    {
        try {
            $apiKey = env('MAP_TILER_API_KEY');
            $url = "https://api.maptiler.com/geocoding/{$location}.json?key={$apiKey}";

            $response = file_get_contents($url);
            $data = json_decode($response);
            return response()->json($data);

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
