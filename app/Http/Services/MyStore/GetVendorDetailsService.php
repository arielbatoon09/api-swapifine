<?php

namespace App\Http\Services\MyStore;

use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\Ratings;

class GetVendorDetailsService
{
    public static function GetVendorDetails()
    {
        try {

            return 'details';

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}