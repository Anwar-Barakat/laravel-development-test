<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'      => ['required', 'between:2,10'],
            'surname'   => ['required', 'between:2,10'],
            'email'     => ['required', 'email', 'unique:users,email', 'max:100'],
            'password'  => ['required', 'min:6']
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'validation error, please try again',
                'errors'    => $validation->errors()
            ], 401);
        }

        $user = User::create([
            'name'      => $request->name,
            'surname'   => $request->surname,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);

        return response()->json([
            'status'    => true,
            'message'   => 'User Has Been Created Successfully',
            'token'     => $user->createToken("api-token")->plainTextToken
        ], 200);
    }
}
