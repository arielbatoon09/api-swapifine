<?php

namespace App\Http\Services\Credits;

use Throwable;
use App\Models\PurchaseCredits;


class GetEveryCreditsHistoryService
{
    public static function GetEveryCreditsHistory()
    {
        try {

            $credits = PurchaseCredits::orderBy("created_at","desc")->get();

            return response([
                'status' => 'success',
                'data' => $credits,
            ]);

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}