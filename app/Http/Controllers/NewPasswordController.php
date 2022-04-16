<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    //
    public function forgotPassword(Request $request)
    {
        if (!$request->isMethod('post')) {
            return redirect()->route('home');
        }
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status === Password::RESET_LINK_SENT){
            return back()->with('success', __($status));
        }

        return back()->with('error', __($status));

    }
}
