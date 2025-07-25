<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class InvalidOrderException extends Exception
{
    public function report()
    {
        return false;
    }
    public function render(Request $request)
    {
        return redirect()->route('home')->withInput()->with('info', 'Invalid order');
    }
}
