<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\PostItem;
use App\Models\User\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Throwable;


class PostItemController extends Controller
{
    private $randomNumber;
    private $stringPrefix;
    private $secretKey;
    private $test;

    public function postItem(Request $request)
    {
        // Auth::user();
        try {
            // Check if the data is not empty
            if (
                !empty($request->category_id) && !empty($request->location_id) && !empty($request->item_name) && !empty($request->item_description)
                && !empty($request->item_price) && !empty($request->item_quantity) && !empty($request->condition) && !empty($request->item_for_type)
                && !empty($request->delivery_type) && !empty($request->payment_type)
            ) {
                // Validate the integer data
                if (
                    filter_var($request->category_id, FILTER_VALIDATE_INT) !== false && filter_var($request->location_id, FILTER_VALIDATE_INT) !== false
                    && filter_var($request->item_price, FILTER_VALIDATE_FLOAT) !== false && filter_var($request->item_quantity, FILTER_VALIDATE_INT) !== false
                ) {
                    // Post Secret Key Generator
                    $this->randomNumber = mt_rand(1000, 9999);
                    $this->stringPrefix = 'ITEM';
                    $this->secretKey = 'REF_' . $this->stringPrefix . $this->randomNumber;

                    // Post Item
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




                    // Validator::make($request->all(), [
                    //     'img_file_path' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048']
                    // ])->validate();



                    // $destinationPath = 'post';
                    // $image = $this->secretKey . '-' . $request->img_file_path->getClientOriginalName();
                    // $request->img_file_path->move(public_path($destinationPath), $image);

                    // $imgFilePaths = $request->input('img_file_path');

                    // foreach ($imgFilePaths as $imgFilePath) {
                    //     $image = new PostImage();
                    //     $image->post_item_key = $this->secretKey;
                    //     $image->img_file_path = $imgFilePath;
                    //     $destinationPath = 'post';
                    //     // $getClientOriginalName = $this->secretKey . '-' . $request->img_file_path->getClientOriginalName();
                    //     // $request->img_file_path->move(public_path($destinationPath), $image);

                    //     $image->save();
                    //     return $image->img_file_path;
                    // }

                    // Get the array of image data from the request
                    $imageDataArray = $request->input('img_file_path');

                    // Define the directory where you want to save the uploaded images
                    $uploadPath = public_path('post'); // Change this path as needed

                    // Create the directory if it doesn't exist
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }

                    foreach ($imageDataArray as $imageDataObject) {
                        // Generate a random filename
                        $randomFileName = Str::random(50) . '.jpg';

                        // Decoding the upcoming images
                        $base64Data = $imageDataObject['data'];
                        $utf8EncodedData = mb_convert_encoding($base64Data, 'UTF-8');
                        $encoded = base64_encode($utf8EncodedData);
                        $this->test = base64_decode($encoded);
                        $image = Image::make($this->test);
                        $image->save($uploadPath . '/' . $randomFileName);
                    }

                    if ($post) {
                        return response([
                            'status' => 'success',
                            'message' => "Posted item successfully!",
                            'images' => $this->test,
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
