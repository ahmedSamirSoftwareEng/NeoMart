<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TwoFactorAuthentication extends Controller
{
    public function index()
    {
        $user= auth()->user();
        return view('front.auth.two-factor-authentication' , compact('user'));
    }
}
