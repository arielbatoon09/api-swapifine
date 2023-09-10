<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use App\Models\User\PostItem;
use App\Models\User\PostImage;


class PostItemController extends Controller
{
    private $randomNumber;
    private $stringPrefix;
    private $secretKey;

    public function postItem(Request $request) 
    {
        // Auth::user();
        try {
            // Check if the data is not empty
            if(!empty($request->category_id) && !empty($request->location_id) && !empty($request->item_name) && !empty($request->item_description)
            && !empty($request->item_price) && !empty($request->item_quantity) && !empty($request->condition) && !empty($request->item_for_type) 
            && !empty($request->delivery_type) && !empty($request->payment_type)) {
                // Validate the integer data
                if(filter_var($request->category_id, FILTER_VALIDATE_INT) !== false && filter_var($request->location_id, FILTER_VALIDATE_INT) !== false
                && filter_var($request->item_price, FILTER_VALIDATE_FLOAT) !== false && filter_var($request->item_quantity, FILTER_VALIDATE_INT) !== false) {
                    // Post Secret Key Generator
                    $this->randomNumber = mt_rand(1000, 9999);
                    $this->stringPrefix = 'ITEM';
                    $this->secretKey = 'REF_'.$this->stringPrefix . $this->randomNumber;

                    $post = new PostItem();
                    $userID = Auth::user();

                    $post->create([
                        'item_key' => $this->secretKey,
                        'user_id' => $userID->id,
                        'category_id' => $request->input('category_id'),
                        'location_id' => $request->input('location_id'),
                        'item_name' => $request->input('item_name'),
                        'item_description' => $request->input('item_description'),
                        'item_price' => $request->input('item_price'),
                        'item_quantity' => $request->input('item_quantity'),
                        'condition' => $request->input('condition'),
                        'item_for_type' => $request->input('item_for_type'),
                        'delivery_type' => $request->input('delivery_type'),
                        'payment_type' => $request->input('payment_type'),
                    ]);
                    
                    // Insert to Image Table
                    $image = new PostImage();

                    $image->create([
                        'post_item_key' => $this->secretKey,
                        'img_file_path' => $request->input('img_file_path', 'default.png'),
                    ]);


                    if ($post && $image) {
                        return response([
                            'status' => 'success',
                            'message' => "Posted item successfully!",
                        ]);
                    } else {
                        return response([
                            'source' => 'errorPost',
                            'status' => 'error',
                            'message' => "There was an issue with posting the item."
                        ]);
                    }

                } else {
                    return response([
                        'source' => 'notValidNumber',
                        'status' => 'error',
                        'message' => "Not a valid number value."
                    ]);
                }
                    

            } else {
                return response([
                    'source' => 'emptyField',
                    'status' => 'error',
                    'message' => "Please fill out this field."
                ]);
            }

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }

    }
}
