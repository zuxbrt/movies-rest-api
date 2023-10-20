<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('');
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
        dd('login', $request->all());
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
