<?php

// app/Exceptions/UnauthenticatedException.php
namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class UnauthenticatedException extends Exception
{
    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login')); // Only for web routes
    }
}