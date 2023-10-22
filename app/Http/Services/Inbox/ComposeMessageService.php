<?php

namespace App\Http\Services\Inbox;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Inbox;
use App\Models\Message;

class ComposeMessageService
{
    private static $inboxModel;
    private static $messageModel;
    private static $isEmpty;

    private static function initialize()
    {
        // Model
        self::$inboxModel = new Inbox();
        self::$messageModel = new Message();
    }
    public static function ComposeMessage(Request $request)
    {
        try {
            ComposeMessageService::initialize();
            ComposeMessageService::ComposeMessageValidation($request);

            if (!self::$isEmpty) {
                // Store the new message
                $result = ComposeMessageService::StoreComposedMessage($request);

                return response([
                    'status' => 'success',
                    'message' => "Sent a new message!",
                    'data' => $result,
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => "Cannot process an empty message.",
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
    private static function StoreComposedMessage(Request $request)
    {
        try {
            $inbox = self::$inboxModel::where('inbox_key', $request->msg_inbox_key)->first();
            $inboxId = $inbox->id;
            $findInboxID = self::$inboxModel::find($inboxId);

            // Store data to Message model
            self::$messageModel::create([
                'msg_inbox_key' => $request->msg_inbox_key,
                'from_id' => $request->from_id,
                'to_id' => $request->to_id,
                'message' => $request->message,
            ]);

            // Update is_read status upon sending new message
            $findInboxID->update([
                'read_by_sender' => $request->input('read_by_sender', 0),
                'read_by_receiver' => $request->input('read_by_receiver', 0),
            ]);

            return true;
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
    private static function ComposeMessageValidation(Request $request)
    {
        try {
            if (!empty($request->msg_inbox_key) && !empty($request->from_id) && !empty($request->to_id) && !empty($request->message)) {
                self::$isEmpty = false;
            } else {
                self::$isEmpty = true;
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
