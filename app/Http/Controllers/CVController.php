<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\CV;

class CVController extends Controller
{
    //
    private $delimeter = '----------';

    function removeDelimeter($stringToRemoveDelimeterFrom)
    {
        $returnString = '';
        $returnString = preg_replace("/" . $this->delimeter . "/i", '', $stringToRemoveDelimeterFrom);
        return $returnString;
    }

    public function createUsername($firstName, $lastName)
    {
        $fullName = ucfirst($firstName) . ' ' . ucfirst($lastName);
        return $fullName;
    }

    public function createUrlLinks($request, $titleArray, $urlArray)
    {
        $returnString = '';
        for ($i = 0; $i < count($titleArray); $i++) {
            if ($i > 0) {
                $returnString .= "\n";
                $returnString .= $this->delimeter;
                $returnString .= "\n";
            }
            $returnString .= $request[array_keys($titleArray)[$i]];
            $returnString .= "\n";
            $returnString .= $this->removeDelimeter($request[array_keys($urlArray)[$i]]);
        }
        return $returnString;
    }

    public function createKeyProgrammingAndEducation($request, $nameArray, $durationArray, $descriptionArray)
    {
        $returnString = '';
        for ($i = 0; $i < count($nameArray); $i++) {
            if ($i > 0) {
                $returnString .= "\n";
                $returnString .= $this->delimeter;
                $returnString .= "\n";
            }
            $returnString .= $this->removeDelimeter($request[array_keys($nameArray)[$i]]);
            $returnString .= "\n";
            $returnString .= $request[array_keys($durationArray)[$i]];
            $returnString .= "\n";
            $returnString .= $this->removeDelimeter($request[array_keys($descriptionArray)[$i]]);
        }
        return $returnString;
    }

    public function translateStoredUrlLinksIntoProperArray($storedUrlString)
    {
        $returnArray = array();
        if (empty($storedUrlString)) {
            return $returnArray;
        }
        $splitStringUpOnDelimiter = explode($this->delimeter, $storedUrlString);
        foreach ($splitStringUpOnDelimiter as $value) {
            $eachSeperateLineArray = explode("\n", $value);
            $aSubArrayWithinTheReturnArray = array();
            //If the first line of the array is empty, then remove it.
            if (empty($eachSeperateLineArray[0])) {
                array_splice($eachSeperateLineArray, 0, 1);
            }
            $aSubArrayWithinTheReturnArray[0] = $eachSeperateLineArray[0];
            $aSubArrayWithinTheReturnArray[1] = $eachSeperateLineArray[1];

            $returnArray[] = $aSubArrayWithinTheReturnArray;
        }
        return $returnArray;
    }

    public function translateStoredEducationAndProgrammingStringIntoProperArray($storedString)
    {
        $returnArray = array();
        if (empty($storedString)) {
            return $returnArray;
        }
        $splitStringUpOnDelimiter = explode($this->delimeter, $storedString);
        foreach ($splitStringUpOnDelimiter as $value) {
            $eachSeperateLineArray = explode("\n", $value);
            $aSubArrayWithinTheReturnArray = array();
            //If the first line of the array is empty, then remove it.
            if (empty($eachSeperateLineArray[0])) {
                array_splice($eachSeperateLineArray, 0, 1);
            }
            $aSubArrayWithinTheReturnArray[0] = $eachSeperateLineArray[0];
            $aSubArrayWithinTheReturnArray[1] = $eachSeperateLineArray[1];
            $lastValueOfSubArray = $value;
            $lastValueOfSubArray = preg_replace("/" . $eachSeperateLineArray[0] . "/i", '', $lastValueOfSubArray, 1);
            $lastValueOfSubArray = preg_replace("/" . $eachSeperateLineArray[1] . "/i", '', $lastValueOfSubArray, 1);
            $aSubArrayWithinTheReturnArray[2] = trim($lastValueOfSubArray);

            $returnArray[] = $aSubArrayWithinTheReturnArray;
        }
        return $returnArray;
    }

    public function searchForCVByUserId($userId)
    {
        $foundCV = CV::where('user_id', $userId)->get();

        return $foundCV;
    }

    public function createValidationArray($requestArray, $regex, $validationValue)
    {
        $validationArray = array();
        foreach ($requestArray as $key => $value) {
            if (preg_match($regex, $key)) {
                $validationArray[$key] = $validationValue;
            }
        }
        return $validationArray;
    }

    public function createCV(Request $request)
    {
        if (!$request->isMethod('post')) {
            return redirect()->route('home');
        }
        $endValidationArray = [
            'first_name' => 'required|alpha|max:30',
            'last_name' => 'required|alpha|max:30',
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

        try {
            $alreadyExistingCV = $this->searchForCVByUserId(auth()->id());
            if ($alreadyExistingCV->count()) {
                return back()->with('error', 'Error. You already have a CV.');
            }
            CV::create([
                'user_id' => auth()->id(),
                'name' => $this->createUsername($request['first_name'], $request['last_name']),
                'email' => auth()->user()->email,
                'password' => auth()->user()->password,
                'keyprogramming' => $this->createKeyProgrammingAndEducation($request, $keyProgrammingLanguageNameArray, $keyProgrammingLanguageDurationArray, $keyProgrammingLanguageDescriptionValidationArray),
                'profile' => $this->removeDelimeter($request['profile']),
                'education' => $this->createKeyProgrammingAndEducation($request, $educationNameValidationArray, $educationDurationValidationArray, $educationDescriptionValidationArray),
                'URLlinks' => $this->createUrlLinks($request, $urlLinkTitleValidationArray, $urlLinkUrlValidationArray)
            ]);
        } catch (QueryException $exception) {
            return back()->with('error', 'Sorry. There was a problem creating the CV – try again.');
        }

        return back()->with('success', 'Success! The CV has been created.');
    }

    public function tryToAccessCreateCV()
    {

        if (!empty(session('error')) ||  !empty(session('success'))) {
            return view('cv.create');
        }

        $alreadyExistingCV = $this->searchForCVByUserId(auth()->id());
        if ($alreadyExistingCV->count()) {
            return redirect()->route('update.cv');
        }
        return view('cv.create');
    }

    public function accessUpdateCV()
    {
        $alreadyExistingCV = $this->searchForCVByUserId(auth()->id());
        if (!$alreadyExistingCV->count()) {
            return redirect()->route('create.cv');
        }

        $foundCV = $alreadyExistingCV[0];

        $formattedCVStaticInfo = array();
        $formattedCVStaticInfo['first_name'] = explode(" ", $foundCV->name)[0];
        $formattedCVStaticInfo['last_name'] = explode(" ", $foundCV->name)[1];
        $formattedCVStaticInfo['profile'] = $foundCV->profile;

        $formattedEducationInfo = $this->translateStoredEducationAndProgrammingStringIntoProperArray($foundCV->education);
        $formattedProgrammingInfo = $this->translateStoredEducationAndProgrammingStringIntoProperArray($foundCV->keyprogramming);
        $formattedUrlLinksInfo = $this->translateStoredUrlLinksIntoProperArray($foundCV->URLlinks);

        return view('cv.update', ['formattedCVStaticInfo' => $formattedCVStaticInfo, 'formattedEducationInfo' => $formattedEducationInfo, 'formattedProgrammingInfo' => $formattedProgrammingInfo, 'formattedUrlLinksInfo' => $formattedUrlLinksInfo]);
    }

    public function updateCV(Request $request)
    {
        if (!$request->isMethod('put')) {
            return redirect()->route('home');
        }

        if ($request['delete_cv'] === 'yes') {
            try {
                $alreadyExistingCV = $this->searchForCVByUserId(auth()->id());
                if (!$alreadyExistingCV->count()) {
                    return back()->with('error', 'Error. We could not find a CV linked to your user account.');
                }
                $foundCV = $alreadyExistingCV[0];

                $foundCV->delete();

                return redirect()->route('create.cv')->with('success', 'Success! The CV has been deleted.');
            } catch (QueryException $exception) {
                return back()->with('error', 'Sorry. There was a problem deleting the CV – try again.');
            }
        }

        $endValidationArray = [
            'first_name' => 'required|alpha|max:30',
            'last_name' => 'required|alpha|max:30',
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

        try {
            $alreadyExistingCV = $this->searchForCVByUserId(auth()->id());
            if (!$alreadyExistingCV->count()) {
                return back()->with('error', 'Error. We could not find a CV linked to your user account.');
            }
            $foundCV = $alreadyExistingCV[0];
            $foundCV['name'] = $this->createUsername($request['first_name'], $request['last_name']);
            $foundCV['keyprogramming'] = $this->createKeyProgrammingAndEducation($request, $keyProgrammingLanguageNameArray, $keyProgrammingLanguageDurationArray, $keyProgrammingLanguageDescriptionValidationArray);
            $foundCV['profile'] = $this->removeDelimeter($request['profile']);
            $foundCV['education'] = $this->createKeyProgrammingAndEducation($request, $educationNameValidationArray, $educationDurationValidationArray, $educationDescriptionValidationArray);
            $foundCV['URLlinks'] = $this->createUrlLinks($request, $urlLinkTitleValidationArray, $urlLinkUrlValidationArray);

            $foundCV->save();
        } catch (QueryException $exception) {
            return back()->with('error', 'Sorry. There was a problem updating the CV – try again.');
        }


        return redirect()->route('update.cv')->with('success', 'Success! The CV has been updated.');
    }


    public function viewCV($id)
    {
        $cvById = CV::find($id);
        if (!$cvById) {
            return redirect()->route('home');
        }

        $formattedEducationInfo = $this->translateStoredEducationAndProgrammingStringIntoProperArray($cvById->education);
        $formattedProgrammingInfo = $this->translateStoredEducationAndProgrammingStringIntoProperArray($cvById->keyprogramming);
        $formattedUrlLinksInfo = $this->translateStoredUrlLinksIntoProperArray($cvById->URLlinks);

        return view('cv.view', ['name' => $cvById['name'], 'profile' => $cvById['profile'], 'email' => $cvById['email'], 'formattedEducationInfo' => $formattedEducationInfo, 'formattedProgrammingInfo' => $formattedProgrammingInfo, 'formattedUrlLinksInfo' => $formattedUrlLinksInfo]);
    }

    public function returnHomeView()
    {
        return view('welcome', ['cvs' => CV::all()]);
    }

    public function searchCV(Request $request)
    {

        if (!$request->ajax()) {
            return redirect()->route('home');
        }

        $allCVS = CV::all();
        $foundCVS = array();

        $requestSearchConfigOption = $request->get('searchConfigOption');
        $requestSearch = $request->get('search');

        //Search on name
        if ($requestSearchConfigOption === 'Name') {
            foreach ($allCVS as $cv) {
                $nameWithoutSpaces = preg_replace("/\s+/i", '', $cv->name);
                if (preg_match("/^(.*" . $requestSearch . ".*)$/i", $nameWithoutSpaces)) {
                    $foundCVS[] = $cv;
                }
            }
        } else {
            //Search on programming language
            foreach ($allCVS as $cv) {
                $formattedProgrammingInfo = $this->translateStoredEducationAndProgrammingStringIntoProperArray($cv->keyprogramming);
                $alreadyMatchedThisCV = false;
                foreach ($formattedProgrammingInfo as $formattedProgrammingInfoSection) {
                    if($alreadyMatchedThisCV){
                        continue;
                    }
                    $programmingNameWithoutSpaces = preg_replace("/\s+/i", '', $formattedProgrammingInfoSection[0]);
                    if (preg_match("/^(.*" . $requestSearch . ".*)$/i", $programmingNameWithoutSpaces)) {
                        $foundCVS[] = $cv;
                        $alreadyMatchedThisCV = true;
                    }
                }
            }
        }

        return response()->json([
            'search' => $requestSearch,
            'foundCVS' => $foundCVS
        ]);
    }
}
