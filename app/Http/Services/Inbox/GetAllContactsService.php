<?php

namespace App\Http\Services\Inbox;

use Throwable;
use App\Models\Inbox;

class GetAllContactsService
{
    public static function GetAllContacts()
    {
        try {
            $userID = auth()->user();

            $getAllContacts = Inbox::with(['post', 'from_user', 'to_user'])
                ->where('from_id', $userID->id)
                ->orWhere('to_id', $userID->id)
                ->get();
            $inboxData = [];

            foreach ($getAllContacts as $contact) {
                $latestMessage = $contact->message()->latest('created_at')->first();
                $imgThumbnail = $contact->images()->first();

                $inboxData[] = [
                    'id' => $contact->id,
                    'msg_inbox_key' => $contact->inbox_key,
                    'from_user_fullname' => $contact->from_user->fullname,
                    'to_user_fullname' => $contact->to_user->fullname,
                    'item_name' => $contact->post->item_name,
                    'latest_message' => $latestMessage->message,
                    'img_thumbnail' => $imgThumbnail->img_file_path,
                    'read_by_sender' => $contact->read_by_sender,
                    'read_by_receiver' => $contact->read_by_receiver,
                ];
            }

            if ($inboxData) {
                return response([
                    'status' => 'success',
                    'data' => $inboxData,
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'data' => "No Data Found",
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
