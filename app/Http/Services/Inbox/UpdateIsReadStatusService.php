<?php

namespace App\Http\Services\Inbox;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Inbox;

class UpdateIsReadStatusService
{

    public static function UpdateIsReadStatus(Request $request)
    {
        try {
            $inbox = Inbox::where('id', $request->id)
                ->where(function ($query) use ($request) {
                    $query->where('from_id', $request->auth_id)
                        ->orWhere('to_id', $request->auth_id);
                })
                ->first();

            if ($inbox) {
                if ($inbox->from_id == $request->auth_id) {
                    $inbox->update([
                        'read_by_sender' => 1,
                    ]);
                } elseif ($inbox->to_id == $request->auth_id) {
                    $inbox->update([
                        'read_by_receiver' => 1,
                    ]);
                }

                return response([
                    'status' => 'success',
                    'message' => 'Updated is read status!',
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'No data found or unauthorized!',
                ], 403); // Return a 403 Forbidden status code for unauthorized access
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
