<?php

namespace App\Http\Services\Transactions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transactions;

class OpenTransactionsService
{
    private $status;

    private function __construct()
    {
        // Default Status
        $this->status = 'In Progress';
    }
    public static function OpenTransactions(Request $request)
    {
        try {
            $instance = new self();
            $transactions = new Transactions();

            if ($request->vendor_id != Auth::user()->id) {

                $checkExist = $transactions->where('msg_inbox_key', $request->msg_inbox_key)->get();

                if ($checkExist->count() == 0) {

                    $transactions->create([
                        'user_id' => Auth::user()->id,
                        'vendor_id' => $request->vendor_id,
                        'msg_inbox_key' => $request->msg_inbox_key,
                        'status' => $instance->status,
                    ]);
        
                    return response([
                        "status" => "success",
                        "message" => "Successfully open a transaction."
                    ]);
                } else {
                    return response([
                        "status" => "error",
                        "message" => "Already have an open transaction."
                    ]);
                }
            } else {

                return response([
                    "status"=> "error",
                    "message" => "Vendor can't open a transactions."
                ]);

            }

        } catch (Throwable $e) {
            return 'Error Catch. '. $e->getMessage();
        }
    }
}