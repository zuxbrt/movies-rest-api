<?php

namespace App\Http\Controllers;

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
    }



    /**
     * Send credentials in order to retrieve JWT to access the API.
     * @param Request $request
     */
    public function login(Request $request)
    {
        // login logic
    }

    

    /**
     * Remove JWT credentials.
     */
    public function logout(Request $request)
    {
        // logout logic
    }
}
