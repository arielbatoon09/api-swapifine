<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PersonalInfo;
use Illuminate\Http\Request;
use Throwable;

class PersonalInfoController extends Controller
{
    public function addVerification(Request $request){
        try {
            $verify = PersonalInfo::all();
        
            if (!$verify->isEmpty()) {
                PersonalInfo::create([
                    'user_id' => $request->input('user_id'),
                    'legalname' => $request->input('legalname'),
                    'birthdate' => $request->input('birthdate'),
                    'card_id_img' => $request->input('card_id_img'),
                    'verification_status' => $request->input('verification_status'),
                ]);
        
                return response([
                    'status' => 'success',
                    'message' => 'Verification created.',
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'Data already exists.',
                ]);
            }
        } catch (Throwable $error) {
            return response([
                'status' => 'error',
                'message' => 'ERROR: ' . $error->getMessage(),
            ]);
        }
    }
    
    public function verificationList(){
        try {
            $info = PersonalInfo::all();
            if($info->isEmpty()){
                return response([
                    'source' => 'CategoryNotFound',
                    'status' => 'error',
                    'message' => 'Unknown Category'
                ]);
            } else {
                return $info;
            }
        } catch (Throwable $error){
            return response([
                'source' => 'error',
                'message' => 'ERROR' . $error
            ]);
        }
    }
}
