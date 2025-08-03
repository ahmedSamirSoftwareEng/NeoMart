<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $provider_user = Socialite::driver($provider)->user();

            $user = User::where([
                'provider_id' => $provider_user->id,
                'provider' => $provider
            ])->first();

            if (!$user) {
                $user = User::create([
                    'name' => $provider_user->name,
                    'email' => $provider_user->email,
                    'provider_id' => $provider_user->id,
                    'provider' => $provider,
                    'password' => Hash::make(Str::random(8)),
                    'provider_token' => $provider_user->token,
                ]);
            }

            Auth::login($user);
            return redirect()->route('home');
        } catch (\Throwable $e) {
            return redirect()->route('login')->withErrors([
                'email' => $e->getMessage()
            ]);
        }
    }
}
