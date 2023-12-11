<?php

namespace App\Http\Services\Inbox;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Inbox;
use App\Models\Message;


class TapToInquireService
{
    private static $inquireMsg;
    private static $getUserID;
    private static $postModel;
    private static $inboxModel;
    private static $messageModel;
    private static $randomNumber;
    private static $stringPrefix;
    private static $secretKey;

    private static function initialize()
    {
        // Inbox Secret Key Generator
        self::$randomNumber = mt_rand(1000, 9999);
        self::$stringPrefix = 'INBOX';
        self::$secretKey = 'REF_' . self::$stringPrefix . self::$randomNumber;

        // Authenticated ID
        self::$getUserID = Auth::user()->id;

        // Model
        self::$postModel = new Post();
        self::$inboxModel = new Inbox();
        self::$messageModel = new Message();

        // Inquire Message
        self::$inquireMsg = 'Start a conversation with the vendor now! 🤝';
    }

    public static function TapToInquire(Request $request)
    {
        try {
            TapToInquireService::initialize();

            $postItemID = self::$postModel::find($request->id);

            if ($postItemID) {
                $postItemKey = $postItemID->item_key;

                if ($request->post_user_id != self::$getUserID) {
                    $checkInboxKey = self::$inboxModel
                        ->where('from_id', self::$getUserID)
                        ->where('post_item_key', $postItemKey)
                        ->first();

                    if (!$checkInboxKey) {
                        // Store to Inbox
                        self::$inboxModel->create([
                            'inbox_key' => self::$secretKey,
                            'from_id' => self::$getUserID,
                            'to_id' => $request->post_user_id,
                            'post_item_key' => $postItemKey,
                            'read_by_sender' => 0,
                            'read_by_receiver' => 0,
                        ]);

                        // Open a conversation/message
                        self::$messageModel->create([
                            'msg_inbox_key' => self::$secretKey,
                            'from_id' => self::$getUserID,
                            'to_id' => $request->post_user_id,
                            'message' => self::$inquireMsg,
                        ]);

                        return response([
                            'status' => 'success',
                            'message' => "Sent an inquiry!",
                        ]);
                    } else {
                        return response([
                            'status' => 'error',
                            'message' => "You have already inquired about this item!",
                        ]);
                    }
                } else {
                    return response([
                        'status' => 'error',
                        'message' => "You can't inquire with your own listing!",
                    ]);
                }
            } else {
                return response([
                    'status' => 'error',
                    'message' => "No Data Found",
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
