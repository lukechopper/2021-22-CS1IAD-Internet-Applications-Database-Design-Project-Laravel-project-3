<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\CV;

class CVController extends Controller
{
    //
    private $delimeter = '----------';

    public function createUsername($firstName, $lastName){
        $fullName = ucfirst($firstName) . ' ' . ucfirst($lastName);
        return $fullName;
    }

    public function createUrlLinks($request, $titleArray, $urlArray){
        $returnString = '';
        for($i = 0; $i < count($titleArray); $i++){
            if($i > 0){
                $returnString .= "\n";
                $returnString .= $this->delimeter;
                $returnString .= "\n";
            }
            $returnString .= $request[array_keys($titleArray)[$i]];
            $returnString .= "\n";
            $returnString .= $request[array_keys($urlArray)[$i]];
        }
        return $returnString;
    }

    public function createKeyProgrammingAndEducation($request, $nameArray, $durationArray, $descriptionArray){
        $returnString = '';
        for($i = 0; $i < count($nameArray); $i++){
            if($i > 0){
                $returnString .= "\n";
                $returnString .= $this->delimeter;
                $returnString .= "\n";
            }
            $returnString .= $request[array_keys($nameArray)[$i]];
            $returnString .= "\n";
            $returnString .= $request[array_keys($durationArray)[$i]];
            $returnString .= "\n";
            $returnString .= $request[array_keys($descriptionArray)[$i]];
        }
        return $returnString;
    }

    public function searchForCVByUserId($userId){
        try{
            $foundCV = CV::where('user_id', $userId)->get();
        }catch(QueryException $exception){
            return back()->with('error', 'Sorry. There was a problem creating the CV – try again.');
        }
        return $foundCV;
    }

    public function createValidationArray($requestArray, $regex, $validationValue){
        $validationArray = array();
        foreach($requestArray as $key => $value){
            if(preg_match($regex, $key)){
                $validationArray[$key] = $validationValue;
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
        $educationNameValidationArray = $this->createValidationArray($request->request, "/education_[0-9]+_name/i", 'required|regex:/(^[a-zA-Z0-9 ]+$)+/i');
        $endValidationArray = array_merge($endValidationArray, $educationNameValidationArray);
        $educationDurationValidationArray = $this->createValidationArray($request->request, "/education_[0-9]+_duration/i", ['required', 'regex:/^([a-z]|[A-Z])+ [0-9]{4}(( [-–—] (([a-z]|[A-Z])+ [0-9]{4}))| [-–—] Present)?$/i']);
        $endValidationArray = array_merge($endValidationArray, $educationDurationValidationArray);
        $educationDescriptionValidationArray = $this->createValidationArray($request->request, "/education_[0-9]+_description/i", 'required|min:13');
        $endValidationArray = array_merge($endValidationArray, $educationDescriptionValidationArray);

        $keyProgrammingLanguageNameArray = $this->createValidationArray($request->request, "/key_programming_language_[0-9]+_name/i", 'required');
        $endValidationArray = array_merge($endValidationArray, $keyProgrammingLanguageNameArray);
        $keyProgrammingLanguageDurationArray = $this->createValidationArray($request->request, "/key_programming_language_[0-9]+_duration/i", ['required', 'regex:/^([a-z]|[A-Z])+ [0-9]{4}(( [-–—] (([a-z]|[A-Z])+ [0-9]{4}))| [-–—] Present)?$/']);
        $endValidationArray = array_merge($endValidationArray, $keyProgrammingLanguageDurationArray);
        $keyProgrammingLanguageDescriptionValidationArray = $this->createValidationArray($request->request, "/key_programming_language_[0-9]+_description/i", 'required|min:13');
        $endValidationArray = array_merge($endValidationArray, $keyProgrammingLanguageDescriptionValidationArray);

        $urlLinkTitleValidationArray = $this->createValidationArray($request->request, "/url_link_[0-9]+_title/i", 'required|regex:/(^[a-zA-Z0-9 ]+$)+/i');
        $endValidationArray = array_merge($endValidationArray, $urlLinkTitleValidationArray);
        $urlLinkUrlValidationArray = $this->createValidationArray($request->request, "/url_link_[0-9]+_url/i", 'required|url');
        $endValidationArray = array_merge($endValidationArray, $urlLinkUrlValidationArray);

        $request->validate($endValidationArray);

        try{
            $alreadyExistingCV = $this->searchForCVByUserId(auth()->id());
            if($alreadyExistingCV->count()){
                return back()->with('error', 'Error. You already have a CV.');
            }
            CV::create([
                'user_id' => auth()->id(),
                'name' => $this->createUsername($request['first_name'], $request['last_name']),
                'email' => auth()->user()->email,
                'password' => auth()->user()->password,
                'keyprogramming' => $this->createKeyProgrammingAndEducation($request, $keyProgrammingLanguageNameArray, $keyProgrammingLanguageDurationArray, $keyProgrammingLanguageDescriptionValidationArray),
                'profile' => $request['profile'],
                'education' => $this->createKeyProgrammingAndEducation($request, $educationNameValidationArray, $educationDurationValidationArray, $educationDescriptionValidationArray),
                'URLlinks' => $this->createUrlLinks($request, $urlLinkTitleValidationArray, $urlLinkUrlValidationArray)
            ]);
        }catch(QueryException $exception){
            dd($exception);
            return back()->with('error', 'Sorry. There was a problem creating the CV – try again.');
        }

        return back()->with('success', 'Success! The CV has been created.');

    }

    public function tryToAccessCreateCV(){
        $alreadyExistingCV = $this->searchForCVByUserId(auth()->id());
        if($alreadyExistingCV->count()){
            return redirect()->route('update.cv');
        }
        return view('cv.create');
    }

    public function accessUpdateCV(){
        return view('cv.update');
    }
}
