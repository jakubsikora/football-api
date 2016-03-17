<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\ApiResponse;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * [authenticate description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->respondUnauthorized('Invalid Credentials!');
            }
        } catch (JWTException $e) {
            // something went wrong
            return $this->respondInternalError('Could Not Create Token!');
        }

        // if no errors are encountered we can return a JWT
        return $this->respond(compact('token'));
    }

    /**
     * [refresh description]
     * @return [type] [description]
     */
    public function refresh(Request $request)
    {
        $current_token = $request->only('token');
        $token = JWTAuth::refresh($current_token['token']);

        return response()->json(compact('token'));
    }
}
