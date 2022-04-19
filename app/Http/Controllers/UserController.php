<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use App\Models\User;

class UserController extends Controller
{
    //

    public function preventUnLoggedInUserFromReachingTheRouteUnlessTheyHaveJustBeenFlashedTheRelevantSessionVariables($viewName){
        if (!empty(session('error')) ||  !empty(session('success'))) {
            return view($viewName);
        }
        if(auth()->user()){
            return redirect()->route('home');
        }
        return view($viewName);
    }

    public function accessLogin(){
        $returnVal = $this->preventUnLoggedInUserFromReachingTheRouteUnlessTheyHaveJustBeenFlashedTheRelevantSessionVariables('login');
        return $returnVal;
    }

    public function accessSignup(){
        $returnVal = $this->preventUnLoggedInUserFromReachingTheRouteUnlessTheyHaveJustBeenFlashedTheRelevantSessionVariables('signup');
        return $returnVal;
    }

    public function signup(Request $request){
        if(!$request->isMethod('post')){
            return redirect()->route('home');
        }
        $request->validate([
            'username' => 'required|unique:users|max:255|alpha_dash',
            'email' => 'required|email|unique:users|max:255',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ]
        ]);
        try{
            User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        }catch(QueryException $exception){
            return back()->with('error', 'true');
        }

        return back()->with('success', 'true');
    }

    public function login(Request $request){
        if(!$request->isMethod('post')){
            return redirect()->route('home');
        }
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(!auth()->attempt($request->only('email', 'password'), $request->remember)){
            return back()->with('error', 'true')->with('email', $request->email);
        }
        return back()->with('success', 'true');
    }

    public function logout(){
        if(!auth()->user()){
            return redirect()->route('home');
        }
        auth()->logout();
        return view('logout');
    }
}
