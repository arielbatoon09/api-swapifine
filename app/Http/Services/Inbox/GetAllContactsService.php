<?php

namespace App\Http\Services\Inbox;

use Throwable;
use App\Models\Inbox;

class GetAllContactsService
{
    public static function GetAllContacts()
    {
        try {
            $getAllContacts = Inbox::with(['post'])->get();
            $inboxData = [];
    
            foreach ($getAllContacts as $contact) {
                $latestMessage = $contact->message()->latest('created_at')->first();
                $imgThumbnail = $contact->images()->first();
    
                $inboxData[] = [
                    'id' => $contact->id,
                    'fullname' => $contact->user->fullname,
                    'item_name' => $contact->post->item_name,
                    'latest_message' => $latestMessage->message,
                    'img_thumbnail' => $imgThumbnail->img_file_path,
                    'is_read' => $contact->is_read,
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