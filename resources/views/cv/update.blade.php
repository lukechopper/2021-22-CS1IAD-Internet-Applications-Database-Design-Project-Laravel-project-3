@extends('partials.header')

@section('css')
<link rel="stylesheet" href="{{asset('public/css/create-cv.css')}}">
@endsection

@section('title')
<title>Update CV</title>
@endsection


@section('body')

<body>
<div class="container container--create_cv">
        <form action="{{route('put.update.cv')}}" method="post" class="form">
            @csrf
            @method('PUT')
            <div class="form__container form__container--full form__container--top">
                <h1 class="form__header">Update CV</h1>
                @if(session('error'))
                    <div class="error_msg">{{session('error')}}</div>
                @elseif(session('success'))
                    <div class="success_msg">{{session('success')}}</div>
                @endif
                @if(session('error') || session('success'))
                <!-- SCRIPT TAG -->
                <script type="text/javascript">
                    localStorage.setItem('edit_cv_done_yet', 'no');
                </script>
                @endif
            </div>
            <input type="hidden" name="delete_cv" id="delete_cv_hidden_input" value="no" >
            <div class="form__container form__container--full">
                <div class="form__delete_cv" id="form__delete_cv"><i class="fa-solid fa-circle-minus"></i>Click Here To Delete CV</div>
            </div>
            <div class="form__container">
                <label for="form_first_name">First Name:</label>
                @if (count($errors->get('last_name')) && !count($errors->get('first_name')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('first_name')))
                <div class="error_msg">{{$errors->get('first_name')[0]}}</div>
                @endif
                <input type="text" name="first_name" id="form_first_name" class="form__input" value="@if(!empty($formattedCVStaticInfo['first_name'])){{$formattedCVStaticInfo['first_name']}} @endif">
            </div>
            <div class="form__container">
                <label for="form_last_name">Last Name:</label>
                @if (count($errors->get('first_name')) && !count($errors->get('last_name')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('last_name')))
                <div class="error_msg">{{$errors->get('last_name')[0]}}</div>
                @endif
                <input type="text" name="last_name" id="form_last_name" class="form__input" value="@if(!empty($formattedCVStaticInfo['last_name'])){{$formattedCVStaticInfo['last_name']}} @endif">
            </div>
            <div class="form__container form__container--full">
                <label for="form_profile">Profile:</label>
                @error('profile')
                <div class="error_msg">{{$message}}</div>
                @enderror
            </div>
            <textarea name="profile" id="form_profile" class="form__input form__input--textarea">@if(!empty($formattedCVStaticInfo['profile'])){{$formattedCVStaticInfo['profile']}} @endif</textarea>
            <!-- OPEN EDUCATION SECTION -->
            <div class="form__container form__container--full">
                <label class="bold">Education</label>
            </div>
            <div class="form__container form__container--full form__container--5px_top_margin">
                <div class="form__add_new_item" id="form__add_new_education_item"><i class="fa-solid fa-circle-plus"></i>Add New Item</div>
            </div>
            @for($i=0; $i < count($formattedEducationInfo); $i++)
            <div class="form__container form__container--less_top_margin" delete_info="{{'form_education_'.$i}}" open_info="{{'form_education_'.$i}}" >
                <label for="{{'form_education_'.$i.'_name'}}">Name:</label>
                @if(preg_match("/.*contain letters, numbers, dashes and underscores.*/i",count($errors->get('education_'.$i.'_duration')) ? $errors->get('education_'.$i.'_duration')[0] : ''))
                <div class="error_padding" ></div>
                @endif
                @if (count($errors->get('education_'.$i.'_duration')) && !count($errors->get('education_'.$i.'_name')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('education_'.$i.'_name')))
                <div class="error_msg">{{preg_replace("/The education [0-9]+ name/i",'This education name',$errors->get('education_'.$i.'_name')[0])}}</div>
                @endif
                <input type="text" name="{{'education_'.$i.'_name'}}" id="{{'form_education_'.$i.'_name'}}" class="form__input" value="@if(!empty($formattedEducationInfo[$i][0])){{$formattedEducationInfo[$i][0]}} @endif">
            </div>
            <div class="form__container form__container--less_top_margin" delete_info="{{'form_education_'.$i}}">
                <label for="{{'form_education_'.$i.'_duration'}}">Duration:</label>
                @if (count($errors->get('education_'.$i.'_name')) && !count($errors->get('education_'.$i.'_duration')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('education_'.$i.'_duration')))
                <div class="error_msg">{{preg_replace("/The education [0-9]+ duration/i",'This education duration',$errors->get('education_'.$i.'_duration')[0])}}</div>
                @endif
                <input type="text" name="{{'education_'.$i.'_duration'}}" id="{{'form_education_'.$i.'_duration'}}" class="form__input" value="@if(!empty($formattedEducationInfo[$i][1])){{$formattedEducationInfo[$i][1]}} @endif">
            </div>
            <div class="form__container form__container--full form__container--less_top_margin" delete_info="{{'form_education_'.$i}}">
                <label for="{{'form_education_'.$i.'_description'}}">Description:</label>
                <div class="form__text_box_then_delete_icon">
                    <div class="form__textarea_container">
                    @if (count($errors->get('education_'.$i.'_description')))
                    <div class="error_msg">{{preg_replace("/The education [0-9]+ description/i",'This education description',$errors->get('education_'.$i.'_description')[0])}}</div>
                    @endif
                    <textarea name="{{'education_'.$i.'_description'}}" id="{{'form_education_'.$i.'_description'}}" class="form__input form__input--smaller_textarea">@if(!empty($formattedEducationInfo[$i][2])){{$formattedEducationInfo[$i][2]}} @endif</textarea>
                    </div>
                    <div class="form__spacing_between_text_box_and_delete_icon"></div>
                    <i class="fa-solid fa-trash-can" delete_info="{{'form_education_'.$i}}"></i>
                </div>
            </div>
            @endfor
            <!-- END EDUCATION SECTION -->
            <!-- OPEN KEY PROGRAMMING LANGUAGES SECTION -->
            <div class="form__container form__container--full" id="form__begin_key_programming_languages_section">
                <label class="bold">Key Programming Languages</label>
            </div>
            <div class="form__container form__container--full form__container--5px_top_margin">
                <div class="form__add_new_item" id="form__add_new_programming_language"><i class="fa-solid fa-circle-plus"></i>Add New Item</div>
            </div>
            @for($i=0; $i < count($formattedProgrammingInfo); $i++)
            <div class="form__container form__container--less_top_margin" delete_info="{{'form_key_programming_language_'.$i}}" open_info="{{'form_key_programming_language_'.$i}}">
                <label for="{{'form_key_programming_language_'.$i.'_name'}}">Name:</label>
                @if(preg_match("/.*contain letters, numbers, dashes and underscores.*/i",count($errors->get('key_programming_language_'.$i.'_duration')) ? $errors->get('key_programming_language_'.$i.'_duration')[0] : ''))
                <div class="error_padding" ></div>
                @endif
                @if (count($errors->get('key_programming_language_'.$i.'_duration')) && !count($errors->get('key_programming_language_'.$i.'_name')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('key_programming_language_'.$i.'_name')))
                <div class="error_msg">{{preg_replace("/The key programming language [0-9]+/i",'This language',$errors->get('key_programming_language_'.$i.'_name')[0])}}</div>
                @endif
                <input type="text" name="{{'key_programming_language_'.$i.'_name'}}" id="{{'form_key_programming_language_'.$i.'_name'}}" class="form__input" value="@if(!empty($formattedProgrammingInfo[$i][0])){{$formattedProgrammingInfo[$i][0]}} @endif">
            </div>
            <div class="form__container form__container--less_top_margin" delete_info="{{'form_key_programming_language_'.$i}}">
                <label for="{{'form_key_programming_language_'.$i.'_duration'}}">Duration:</label>
                @if (count($errors->get('key_programming_language_'.$i.'_name')) && !count($errors->get('key_programming_language_'.$i.'_duration')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('key_programming_language_'.$i.'_duration')))
                <div class="error_msg">{{preg_replace("/The key programming language [0-9]+/i",'This language',$errors->get('key_programming_language_'.$i.'_duration')[0])}}</div>
                @endif
                <input type="text" name="{{'key_programming_language_'.$i.'_duration'}}" id="{{'form_key_programming_language_'.$i.'_duration'}}" class="form__input" value="@if(!empty($formattedProgrammingInfo[$i][1])){{$formattedProgrammingInfo[$i][1]}} @endif">
            </div>
            <div class="form__container form__container--full form__container--less_top_margin" delete_info="{{'form_key_programming_language_'.$i}}">
                <label for="{{'form_key_programming_language_'.$i.'_description'}}">Description:</label>
                <div class="form__text_box_then_delete_icon">
                    <div class="form__textarea_container">
                    @if (count($errors->get('key_programming_language_'.$i.'_description')))
                    <div class="error_msg">{{preg_replace("/The key programming language [0-9]+/i",'This language',$errors->get('key_programming_language_'.$i.'_description')[0])}}</div>
                    @endif
                    <textarea name="{{'key_programming_language_'.$i.'_description'}}" id="{{'form_key_programming_language_'.$i.'_description'}}" class="form__input form__input--smaller_textarea">@if(!empty($formattedProgrammingInfo[$i][2])){{$formattedProgrammingInfo[$i][2]}} @endif</textarea>
                    </div>
                    <div class="form__spacing_between_text_box_and_delete_icon"></div>
                    <i class="fa-solid fa-trash-can" delete_info="{{'form_key_programming_language_'.$i}}"></i>
                </div>
            </div>
            @endfor
            <!-- END KEY PROGRAMMING LANGUAGES SECTION -->
            <!-- OPEN URL LINKS SECTION -->
            <div class="form__container form__container--full" id="form__begin_url_links_section">
                <label class="bold">URL Links</label>
            </div>
            <div class="form__container form__container--full form__container--5px_top_margin">
                <div class="form__add_new_item" id="form__add_new_url_link"><i class="fa-solid fa-circle-plus"></i>Add New Item</div>
            </div>
            @for($i=0; $i < count($formattedUrlLinksInfo); $i++)
            <div class="form__container form__container--less_top_margin" delete_info="{{'form_url_link_'.$i}}" open_info="{{'form_url_link_'.$i}}">
                <label for="{{'form_url_link_'.$i.'_title'}}">Title:</label>
                @if (count($errors->get('url_link_'.$i.'_url')) && !count($errors->get('url_link_'.$i.'_title')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('url_link_'.$i.'_title')))
                <div class="error_msg">{{preg_replace("/The url link [0-9]+/i",'This url link',$errors->get('url_link_'.$i.'_title')[0])}}</div>
                @endif
                <input type="text" name="{{'url_link_'.$i.'_title'}}" id="{{'form_url_link_'.$i.'_title'}}" class="form__input" value="@if(!empty($formattedUrlLinksInfo[$i][0])){{$formattedUrlLinksInfo[$i][0]}} @endif">
            </div>
            <div class="form__container form__container--less_top_margin" delete_info="{{'form_url_link_'.$i}}">
                <label for="{{'form_url_link_'.$i.'_url'}}">URL:</label>
                @if (count($errors->get('url_link_'.$i.'_title')) && !count($errors->get('url_link_'.$i.'_url')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('url_link_'.$i.'_url')))
                <div class="error_msg">{{preg_replace("/The url link [0-9]+/i",'This url link',$errors->get('url_link_'.$i.'_url')[0])}}</div>
                @endif
                <div class="form__text_box_then_delete_icon">
                    <input type="text" name="{{'url_link_'.$i.'_url'}}" id="{{'form_url_link_'.$i.'_url'}}" class="form__input" value="@if(!empty($formattedUrlLinksInfo[$i][1])){{$formattedUrlLinksInfo[$i][1]}} @endif">
                    <div class="form__spacing_between_text_box_and_delete_icon"></div>
                    <i class="fa-solid fa-trash-can" delete_info="{{'form_url_link_'.$i}}"></i>
                </div>
            </div>
            @endfor
            <!-- END URL LINKS SECTION -->
            <div class="form__container form__container--full" id="form__submit_section">
                <input type="submit" class="form__submit" value="Submit">
            </div>
        </form>
    </div>
    <!-- LARAVEL SCRIPT -->
    <script type="text/javascript">
        let errorObj = { };
        @if (count($errors->get('first_name')))
        errorObj["first_name"] = "{{$errors->get('first_name')[0]}}";
        @endif

        @for($i=0;$i<count($errors->all());$i++)
        errorObj["{{$errors->keys()[$i]}}"] = "{{$errors->all()[$i]}}";
        @endfor

        let phpEducationItems = {{!empty($formattedEducationInfo[0][0]) ? count($formattedEducationInfo)-1 : 0}};
        let phpProgrammingLanguagesItems = {{!empty($formattedProgrammingInfo[0][0]) ? count($formattedProgrammingInfo)-1 : 0}};
        let phpUrlLinksItems = {{!empty($formattedUrlLinksInfo[0][0]) ? count($formattedUrlLinksInfo)-1 : 0}};

    </script>
    <!-- Create CV SCRIPT -->
    <script src="{{asset('public/js/update_cv.js')}}"></script>
</body>

</html>
@endsection
