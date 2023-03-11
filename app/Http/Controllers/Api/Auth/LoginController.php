<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email'     => ['required', 'email'],
            'password'  => ['required', 'min:8']
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'validation error, please try again',
                'errors'    => $validation->errors()
            ], 401);
        }

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status'    => false,
                'message'   => 'Email or Password not Valid',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'status'    => true,
            'message'   => 'User Has Been Logged In Successfully',
            'token'     => $user->createToken("api-token")->plainTextToken
        ], 200);
    }
}
