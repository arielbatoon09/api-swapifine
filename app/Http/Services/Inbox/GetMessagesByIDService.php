<?php

namespace App\Http\Services\Inbox;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Inbox;
use App\Models\Message;

class GetMessagesByIDService
{
    public static function GetMessagesByID(Request $request)
    {
        try {
            $inboxKey = Inbox::findOrFail($request->inbox_id)->inbox_key;

            $messageData = Message::with(['post', 'from_user', 'to_user'])
            ->where('msg_inbox_key', $inboxKey)
            ->orderBy('id', 'desc')
            ->get();
    
            $formattedMessageData = $messageData->map(function ($message) {
                return [
                    'id' => $message->id,
                    'msg_inbox_key' => $message->msg_inbox_key,
                    'post_item_id' => $message->inbox->post->id,
                    'post_item_key' => $message->inbox->post->item_key,
                    'post_item_title' => $message->inbox->post->item_name,
                    'from_user_fullname' => $message->from_user->fullname,
                    'from_user_id' => $message->from_user->id,
                    'to_user_fullname' => $message->to_user->fullname,
                    'to_user_id' => $message->to_user->id,
                    'message' => $message->message,
                    'from_user_profile' => $message->from_user->profile_img ? $message->from_user->profile_img : asset("uploads/default_profile.png"),
                    'to_user_profile' => $message->to_user->profile_img ? $message->to_user->profile_img : asset("uploads/default_profile.png"),
                    'created_at' => $message->created_at,
                ];
            });

            return response([
                'status' => 'success',
                'data' => $formattedMessageData,
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
