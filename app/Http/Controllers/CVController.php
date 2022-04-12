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
        $educationNameValidationArray = array();
        foreach($request->request as $key => $value){
            if(preg_match("/education_[0-9]+_name/i", $key)){
                $educationNameValidationArray[$key] = $value;
            }
        }
        dd($educationNameValidationArray);
    }
}
