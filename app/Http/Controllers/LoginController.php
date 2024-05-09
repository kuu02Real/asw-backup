<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;


use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(){
        return view('login');
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
    public function login_google(){
        return Socialite::driver('google')->redirect();
    }
    public function google_callback(){
        $user = Socialite::driver('google')->user();

        $userExists = User::where('external_id', $user->id)->where('external_auth', 'google')->first();

        if($userExists){
            Auth::login($userExists);
        } else {
            $pathav = 'images/user/placeholder/avatar.png';
            $pathba = 'images/user/placeholder/banner.jpg';
            $userNew = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $pathav,
                'external_id' => $user->id,
                'external_auth' => 'google',
                'banner' => $pathba,
                'bio' => 'Tinc molta gana.',
                'data_reg' => date("d/m/y"),
                'api_token' => null,
            ]);

            Auth::login($userNew);
            $token = auth()->user()->createToken('token-name')->plainTextToken;
            $user = auth()->user();
            $user->update(['api_token' => $token]);

        }

        return redirect()->intended();
    }
}
