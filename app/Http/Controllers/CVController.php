<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CV;

class CVController extends Controller
{
    //
    public function createCV(Request $request){
        if(!$request->isMethod('post')){
            return redirect()->route('home');
        }
        dd($request['education_0_name']);
    }
}
