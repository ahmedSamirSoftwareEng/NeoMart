<?php

namespace App\Actions\Fortify;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthenticateUser
{

    public function authenticate($request)
    {
        $userName = $request->post(Config('fortify.username'));
        $password = $request->post('password');

        $user = Admin::where('email', $userName)
            ->orWhere('username', $userName)
            ->orWhere('phone_number', $userName)
            ->firstOrFail();

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        return false;
    }
}
