<?php

namespace App\Http\Services\Credits;

use Throwable;
use App\Models\PurchaseCredits;
use Illuminate\Http\Request;

class GetCreditsByIDService
{
    public static function GetCreditsByID(Request $request)
    {
        try {
            $credits = PurchaseCredits::with('user')->where("id", $request->id)->first();

            $creditsData[] = [
                'id' => $credits->id,
                'product_name' => $credits->purchase_name,
                'user_fullname' => $credits->user->fullname,
                'transaction_date' => date('Y-m-d H:i:s', strtotime($credits->created_at)),
            ];

            return response([
                'status' => 'success',
                'data' => $creditsData,
            ]);

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}