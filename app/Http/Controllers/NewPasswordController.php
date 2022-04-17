<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordVal;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

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

    public function resetPassword(Request $request)
    {
        if (!$request->isMethod('post')) {
            return redirect()->route('home');
        }

        $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                PasswordVal::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ]
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if($status === Password::PASSWORD_RESET){
            return back()->with('success', 'true');
        }

        return back()->with('error', 'true');
    }

    public function resetPasswordView(Request $request)
    {
        if(empty($request->token)){
            return redirect()->route('home');
        }

        return view('resetPassword', ['token' => $request->token]);
    }
}
