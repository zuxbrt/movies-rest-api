<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\JWTService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $jwtService;

    public function __construct()
    {
        // $this->middleware('');
        $this->jwtService = new JWTService();
    }


    /**
     * Register user and return JWT.
     * @param Request $request.
     */
    public function register(Request $request)
    {
        // register logic
        dd('register', $request->all());
    }



    /**
     * Send credentials in order to retrieve JWT to access the API.
     * @param Request $request
     */
    public function login(Request $request)
    {
        // login logic
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
                'token' => $this->jwtService->getEncodedTokenForUser($user),
                'user'  => $user->email
           ]);

        } else {
            return response()->json('The password you typed was not correct.', 401);
        }
    }

    

    /**
     * Remove JWT credentials.
     */
    public function logout(Request $request)
    {
        // logout logic
        dd('logout', $request->all());
    }
}
