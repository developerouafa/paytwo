<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\GeneralTraitt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use GeneralTraitt;

    public function login(Request $request){
        // validation
        try{
            $rules = [
                "email" => "required",
                "password" => "required"
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
        }catch(\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

        // login
            $credentials = $request->only(['email', 'password']);

            $token = Auth::guard('api')->attempt($credentials);

            if (!$token)
                return $this->returnError('E001', 'No exist');

            $admin = Auth::guard('api')->user();
            $admin->api_token = $token;

        // return token
            return $this->returnData('admin', $admin);
    }

    public function logout(Request $request)
    {
        $token = $request -> header('auth-token');
        if($token){
            try {
                JWTAuth::setToken($token)->invalidate(); //logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return  $this -> returnError('','some thing went wrongs');
            }
            return $this->returnSuccessMessage('Logged out successfully');
        }else{
            $this -> returnError('','some thing went wrongs');
        }
    }
}
