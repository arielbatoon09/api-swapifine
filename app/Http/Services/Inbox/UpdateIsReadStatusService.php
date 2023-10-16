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
            $checkInboxID = Inbox::findOrFail($request->id);
            
            if ($checkInboxID) {
                $checkInboxID->update([
                    'is_read' => 1,
                ]);

                return response([
                    'status' => 'success',
                    'message' => "Updated is read status!",
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'No data found!',
                ]);
            }

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}