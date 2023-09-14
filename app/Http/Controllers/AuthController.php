<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if( auth()->attempt($request->only('email', 'password')) ){
            return to_route('notes.index');
        }

        return redirect()->back()->with(["error" => "Credenciales incorrectas"]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        auth()->login($user);


        return to_route('notes.index');
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->regenerate();

        return to_route('login');
    }
}
