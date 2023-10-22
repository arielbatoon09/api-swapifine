<?php

namespace App\Http\Services\Location;
use Illuminate\Support\Facades\Cache;

use Throwable;

class GetSearchLocationService
{
    public static function GetSearchLocation($location)
    {
        $rateLimitKey = 'geocoding_request_' . md5($location);

        if (Cache::has($rateLimitKey)) {
            return response()->json(['message' => 'Rate limit exceeded. Please try again later.'], 429);
        }

        try {
            $apiKey = env('MAP_TILER_API_KEY');
            $url = "https://api.maptiler.com/geocoding/{$location}.json?key={$apiKey}";

            $response = file_get_contents($url);
            $data = json_decode($response);

            // Set a cache entry to limit requests for 2 seconds
            Cache::put($rateLimitKey, true, 2); // Cache the key for 2 seconds

            return response()->json($data);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
