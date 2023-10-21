<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\JWTService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct() {}


    /**
     * Register user and return JWT.
     * @param Request $request.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8']
        ]);

        if($validator->fails()){
            return response()->json($validator->messages()->all(), 400);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);
    
        return response()->json([
            'token' => JWTService::getTokenForUser($user),
            'user'  => $user->toArray()
        ]);
    
    }



    /**
     * Send credentials in order to retrieve JWT to access the API.
     * @param Request $request
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->messages()->all(), 400);
        }

        $user = User::where('email', $request->email)->first();
        if(!$user) return response()->json('Invalid credentials', 404);

        if(Hash::check($request->password, $user->password)){
            
           return response()->json([
                'token' => JWTService::getTokenForUser($user),
                'user'  => $user->toArray()
           ]);

        } else {
            return response()->json('The password you typed was not correct.', 401);
        }
    }

    /**
     * Refresh JWT in case of expiry.
     */
    public function refreshToken(Request $request)
    {
        //
    }
}
