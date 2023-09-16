<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        if( auth()->attempt($request->only(['email', 'password'])) ){
            $user = User::findByEmail($request->input('email'));
            return response()->json([
                'access_token' => $user->createToken("API TOKEN")->plainTextToken
            ]);
        }

        return response()->json(null, 401);
    }
}
