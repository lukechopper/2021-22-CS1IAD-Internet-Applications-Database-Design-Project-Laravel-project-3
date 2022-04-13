<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CV;

class CVController extends Controller
{
    //

    public function createValidationArray($requestArray, $regex, $validationStr){
        $validationArray = array();
        foreach($requestArray as $key => $value){
            if(preg_match($regex, $key)){
                $validationArray[$key] = $validationStr;
            }
        }
        return $validationArray;
    }

    public function createCV(Request $request){
        if(!$request->isMethod('post')){
            return redirect()->route('home');
        }
        $endValidationArray = [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'profile' => 'required|min:25'
        ];
        $educationNameValidationArray = $this->createValidationArray($request->request, "/education_[0-9]+_name/i", 'required|alpha');
        $endValidationArray = array_merge($endValidationArray, $educationNameValidationArray);
        $educationDurationValidationArray = $this->createValidationArray($request->request, "/education_[0-9]+_duration/i", 'required|alpha_dash');
        $endValidationArray = array_merge($endValidationArray, $educationDurationValidationArray);
        $educationDescriptionValidationArray = $this->createValidationArray($request->request, "/education_[0-9]+_description/i", 'required|min:13');
        $endValidationArray = array_merge($endValidationArray, $educationDescriptionValidationArray);

        $keyProgrammingLanguageNameArray = $this->createValidationArray($request->request, "/key_programming_language_[0-9]+_name/i", 'required|alpha_num');
        $endValidationArray = array_merge($endValidationArray, $keyProgrammingLanguageNameArray);
        $keyProgrammingLanguageDurationArray = $this->createValidationArray($request->request, "/key_programming_language_[0-9]+_duration/i", 'required|alpha_dash');
        $endValidationArray = array_merge($endValidationArray, $keyProgrammingLanguageDurationArray);
        $keyProgrammingLanguageDescriptionValidationArray = $this->createValidationArray($request->request, "/key_programming_language_[0-9]+_description/i", 'required|min:13');
        $endValidationArray = array_merge($endValidationArray, $keyProgrammingLanguageDescriptionValidationArray);

        $urlLinkTitleValidationArray = $this->createValidationArray($request->request, "/url_link_[0-9]+_title/i", 'required|alpha');
        $endValidationArray = array_merge($endValidationArray, $urlLinkTitleValidationArray);
        $urlLinkUrlValidationArray = $this->createValidationArray($request->request, "/url_link_[0-9]+_url/i", 'required|url');
        $endValidationArray = array_merge($endValidationArray, $urlLinkUrlValidationArray);

        $request->validate($endValidationArray);
        dd('Success');
    }
}
