<?php

namespace App\Http\Services\PostItem;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic;
use App\Models\Post;
use App\Models\Image;
use App\Models\Location;
use App\Models\Verification;

class PostItemService
{
    private static $getUserID;
    private static $postItem;
    private static $randomNumber;
    private static $stringPrefix;
    private static $secretKey;
    private static $isEmpty;
    private static $invalidInput;
    private static $location;
    private static $checkUserLocation;

    private static function initialize()
    {
        // Post Secret Key Generator
        self::$randomNumber = mt_rand(1000, 9999);
        self::$stringPrefix = 'ITEM';
        self::$secretKey = 'REF_' . self::$stringPrefix . self::$randomNumber;

        self::$postItem = new Post();
        self::$getUserID = Auth::user()->id;
        self::$location = new Location();
    }

    public static function Postitem(Request $request)
    {
        try {
            // Function Init
            PostItemService::initialize();
            PostItemService::PostItemValidation($request);

            if (!self::$isEmpty) {
                if (self::$checkUserLocation) {
                    if (!self::$invalidInput) {
                        if (strlen($request->item_name) <= 60) {
                            if (strlen($request->item_description) <= 300) {
                                // Init Verification check
                                $verification = Verification::where('user_id', auth()->user()->id)
                                    ->where('status', 'Approved')
                                    ->first();

                                // If not verified, return error
                                if (!$verification) {
                                    return response([
                                        'status' => 'error',
                                        'source' => 'notEligible',
                                        'message' => "Please verify your account!"
                                    ]);
                                }

                                // Call and save the Item data into StorePostItem function
                                $response = PostItemService::StorePostItem($request);

                                // Upload Image
                                $imageDataArray = $request->input('img_file_path');
                                $uploadPath = public_path('uploads/post/user-' . self::$getUserID);

                                // Create the directory if it doesn't exist
                                if (!file_exists($uploadPath)) {
                                    mkdir($uploadPath, 0755, true);
                                }

                                foreach ($imageDataArray as $imageDataObject) {
                                    // Init Image
                                    $postImage = new Image();

                                    // Generate a random filename
                                    $randomFileName = Str::random(50) . '.jpg';

                                    // Decoding the upcoming images
                                    $base64Data = $imageDataObject['data'];
                                    $utf8EncodedData = mb_convert_encoding($base64Data, 'UTF-8');
                                    $encoded = base64_encode($utf8EncodedData);
                                    $decoded = base64_decode($encoded);
                                    $image = ImageManagerStatic::make($decoded);
                                    $image->save($uploadPath . '/' . $randomFileName);

                                    // Save to Database
                                    $postImage->create([
                                        'post_item_key' => self::$secretKey,
                                        'img_file_path' => env('BACKEND_URL') . '/uploads/post/user-' . self::$getUserID . '/' . $randomFileName,
                                    ]);
                                }

                                if ($response && $postImage) {
                                    return response([
                                        'status' => 'success',
                                        'message' => "Posted item successfully!",
                                    ]);
                                } else {
                                    return response([
                                        'status' => 'error',
                                        'message' => "Failed to post item!",
                                    ]);
                                }
                            } else {
                                return response([
                                    'status' => 'error',
                                    'source' => 'tooLong',
                                    'message' => "Too long Item Description characters."
                                ]);
                            }
                        } else {
                            return response([
                                'status' => 'error',
                                'source' => 'tooLong',
                                'message' => "Too long Item Name characters."
                            ]);
                        }
                    } else {
                        return response([
                            'status' => 'error',
                            'source' => 'invalidInput',
                            'message' => "Not a valid number value."
                        ]);
                    }
                } else {
                    return response([
                        'status' => 'error',
                        'source' => 'noLocation',
                        'message' => "Please set your location before posting!",
                    ]);
                }
            } else {
                return response([
                    'status' => 'error',
                    'source' => 'isEmpty',
                    'message' => "Please fill out this field.",
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }

    private static function StorePostItem(Request $request)
    {
        try {
            self::$postItem->create([
                'item_key' => self::$secretKey,
                'user_id' => self::$getUserID,
                'category_id' => $request->input('category_id'),
                'location_id' => $request->input('location_id'),
                'item_name' => $request->input('item_name'),
                'item_description' => $request->input('item_description'),
                'item_stocks' => $request->input('item_stocks'),
                'condition' => $request->input('condition'),
                'item_for_type' => $request->input('item_for_type'),
                'item_cash_value' => $request->input('item_cash_value'),
            ]);

            return true;
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }

    private static function PostItemValidation(Request $request)
    {
        try {
            // isEmpty Validation
            if (
                !empty($request->category_id) && !empty($request->item_name) && !empty($request->item_description)
                && !empty($request->item_cash_value) && !empty($request->item_stocks) && !empty($request->condition) && !empty($request->item_for_type)
                && !empty($request->img_file_path)
            ) {
                self::$checkUserLocation = self::$location::where('user_id', self::$getUserID)->first();
                if (self::$checkUserLocation) {
                    // Number Validation
                    if (
                        filter_var($request->category_id, FILTER_VALIDATE_INT) !== false && filter_var($request->location_id, FILTER_VALIDATE_INT) !== false
                        && filter_var($request->item_cash_value, FILTER_VALIDATE_FLOAT) !== false && filter_var($request->item_stocks, FILTER_VALIDATE_INT) !== false
                    ) {
                        self::$invalidInput = false;
                    } else {
                        self::$invalidInput = true;
                    }
                } else {
                    self::$checkUserLocation = false;
                }

                self::$isEmpty = false;
            } else {
                self::$isEmpty = true;
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
