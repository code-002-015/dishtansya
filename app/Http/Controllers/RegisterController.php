<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Validator;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\User;

use App\Jobs\SendEmailRegistrationJob;

class RegisterController extends ResponseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Email already taken', $validator->errors(), 400);       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        if($user){
            dispatch(new SendEmailRegistrationJob($input['email']));
        }
        
    

        return $this->sendResponse($user, 'User successfully registered.');
    }


    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {   

        $credentials = request(['email', 'password']);

        if (! $token = JWTAuth::attempt($credentials)) {

            return $this->sendError('Invalid credentials.', ['error'=>'Invalid credentials']);

        } else {

            return $this->loginResponse($token);
        }

    }
}
