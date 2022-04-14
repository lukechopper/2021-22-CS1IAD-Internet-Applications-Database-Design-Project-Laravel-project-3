@extends('partials.header')

@section('css')
<link rel="stylesheet" href="{{asset('public/css/create-cv.css')}}">
@endsection

@section('title')
<title>Create CV</title>
@endsection


@section('body')

<body>
    <div class="container container--create_cv">
        <form action="{{route('post.create.cv')}}" method="post" class="form">
            @csrf
            <div class="form__container form__container--full form__container--top">
                <h1 class="form__header">Create CV</h1>
                @if(session('error'))
                    <div class="error_msg">{{session('error')}}</div>
                @elseif(session('success'))
                    <div class="success_msg">{{session('success')}}</div>
                @endif
            </div>
            <div class="form__container">
                <label for="form_first_name">First Name:</label>
                @if (count($errors->get('last_name')) && !count($errors->get('first_name')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('first_name')))
                <div class="error_msg">{{$errors->get('first_name')[0]}}</div>
                @endif
                <input type="text" name="first_name" id="form_first_name" class="form__input">
            </div>
            <div class="form__container">
                <label for="form_last_name">Last Name:</label>
                @if (count($errors->get('first_name')) && !count($errors->get('last_name')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('last_name')))
                <div class="error_msg">{{$errors->get('last_name')[0]}}</div>
                @endif
                <input type="text" name="last_name" id="form_last_name" class="form__input">
            </div>
            <div class="form__container form__container--full">
                <label for="form_profile">Profile:</label>
                @error('profile')
                <div class="error_msg">{{$message}}</div>
                @enderror
            </div>
            <textarea name="profile" id="form_profile" class="form__input form__input--textarea"></textarea>
            <!-- OPEN EDUCATION SECTION -->
            <div class="form__container form__container--full">
                <label class="bold">Education</label>
            </div>
            <div class="form__container form__container--full form__container--5px_top_margin">
                <div class="form__add_new_item" id="form__add_new_education_item"><i class="fa-solid fa-circle-plus"></i>Add New Item</div>
            </div>
            <div class="form__container form__container--less_top_margin" delete_info="form_education_0" open_info="form_education_0" >
                <label for="form_education_0_name">Name:</label>
                @if(preg_match("/.*contain letters, numbers, dashes and underscores.*/i",count($errors->get('education_0_duration')) ? $errors->get('education_0_duration')[0] : ''))
                <div class="error_padding" ></div>
                @endif
                @if (count($errors->get('education_0_duration')) && !count($errors->get('education_0_name')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('education_0_name')))
                <div class="error_msg">{{preg_replace("/The education [0-9]+ name/i",'This education name',$errors->get('education_0_name')[0])}}</div>
                @endif
                <input type="text" name="education_0_name" id="form_education_0_name" class="form__input">
            </div>
            <div class="form__container form__container--less_top_margin" delete_info="form_education_0">
                <label for="form_education_0_duration">Duration:</label>
                @if (count($errors->get('education_0_name')) && !count($errors->get('education_0_duration')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('education_0_duration')))
                <div class="error_msg">{{preg_replace("/The education [0-9]+ duration/i",'This education duration',$errors->get('education_0_duration')[0])}}</div>
                @endif
                <input type="text" name="education_0_duration" id="form_education_0_duration" class="form__input">
            </div>
            <div class="form__container form__container--full form__container--less_top_margin" delete_info="form_education_0">
                <label for="form_education_0_description">Description:</label>
                <div class="form__text_box_then_delete_icon">
                    <div class="form__textarea_container">
                    @if (count($errors->get('education_0_description')))
                    <div class="error_msg">{{preg_replace("/The education [0-9]+ description/i",'This education description',$errors->get('education_0_description')[0])}}</div>
                    @endif
                    <textarea name="education_0_description" id="form_education_0_description" class="form__input form__input--smaller_textarea"></textarea>
                    </div>
                    <div class="form__spacing_between_text_box_and_delete_icon"></div>
                    <i class="fa-solid fa-trash-can" delete_info="form_education_0"></i>
                </div>
            </div>
            <!-- END EDUCATION SECTION -->
            <!-- OPEN KEY PROGRAMMING LANGUAGES SECTION -->
            <div class="form__container form__container--full" id="form__begin_key_programming_languages_section">
                <label class="bold">Key Programming Languages</label>
            </div>
            <div class="form__container form__container--full form__container--5px_top_margin">
                <div class="form__add_new_item" id="form__add_new_programming_language"><i class="fa-solid fa-circle-plus"></i>Add New Item</div>
            </div>
            <div class="form__container form__container--less_top_margin" delete_info="form_key_programming_language_0" open_info="form_key_programming_language_0">
                <label for="form_key_programming_language_0_name">Name:</label>
                @if(preg_match("/.*contain letters, numbers, dashes and underscores.*/i",count($errors->get('key_programming_language_0_duration')) ? $errors->get('key_programming_language_0_duration')[0] : ''))
                <div class="error_padding" ></div>
                @endif
                @if (count($errors->get('key_programming_language_0_duration')) && !count($errors->get('key_programming_language_0_name')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('key_programming_language_0_name')))
                <div class="error_msg">{{preg_replace("/The key programming language [0-9]+/i",'This language',$errors->get('key_programming_language_0_name')[0])}}</div>
                @endif
                <input type="text" name="key_programming_language_0_name" id="form_key_programming_language_0_name" class="form__input">
            </div>
            <div class="form__container form__container--less_top_margin" delete_info="form_key_programming_language_0">
                <label for="form_key_programming_language_0_duration">Duration:</label>
                @if (count($errors->get('key_programming_language_0_name')) && !count($errors->get('key_programming_language_0_duration')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('key_programming_language_0_duration')))
                <div class="error_msg">{{preg_replace("/The key programming language [0-9]+/i",'This language',$errors->get('key_programming_language_0_duration')[0])}}</div>
                @endif
                <input type="text" name="key_programming_language_0_duration" id="form_key_programming_language_0_duration" class="form__input">
            </div>
            <div class="form__container form__container--full form__container--less_top_margin" delete_info="form_key_programming_language_0">
                <label for="form_key_programming_language_0_description">Description:</label>
                <div class="form__text_box_then_delete_icon">
                    <div class="form__textarea_container">
                    @if (count($errors->get('key_programming_language_0_description')))
                    <div class="error_msg">{{preg_replace("/The key programming language [0-9]+/i",'This language',$errors->get('key_programming_language_0_description')[0])}}</div>
                    @endif
                    <textarea name="key_programming_language_0_description" id="form_key_programming_language_0_description" class="form__input form__input--smaller_textarea"></textarea>
                    </div>
                    <div class="form__spacing_between_text_box_and_delete_icon"></div>
                    <i class="fa-solid fa-trash-can" delete_info="form_key_programming_language_0"></i>
                </div>
            </div>
            <!-- END KEY PROGRAMMING LANGUAGES SECTION -->
            <!-- OPEN URL LINKS SECTION -->
            <div class="form__container form__container--full" id="form__begin_url_links_section">
                <label class="bold">URL Links</label>
            </div>
            <div class="form__container form__container--full form__container--5px_top_margin">
                <div class="form__add_new_item" id="form__add_new_url_link"><i class="fa-solid fa-circle-plus"></i>Add New Item</div>
            </div>
            <div class="form__container form__container--less_top_margin" delete_info="form_url_link_0" open_info="form_url_link_0">
                <label for="form_url_link_0_title">Title:</label>
                @if (count($errors->get('url_link_0_url')) && !count($errors->get('url_link_0_title')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('url_link_0_title')))
                <div class="error_msg">{{preg_replace("/The url link [0-9]+/i",'This url link',$errors->get('url_link_0_title')[0])}}</div>
                @endif
                <input type="text" name="url_link_0_title" id="form_url_link_0_title" class="form__input">
            </div>
            <div class="form__container form__container--less_top_margin" delete_info="form_url_link_0">
                <label for="form_url_link_0_url">URL:</label>
                @if (count($errors->get('url_link_0_title')) && !count($errors->get('url_link_0_url')))
                <div class="error_padding" ></div>
                @elseif (count($errors->get('url_link_0_url')))
                <div class="error_msg">{{preg_replace("/The url link [0-9]+/i",'This url link',$errors->get('url_link_0_url')[0])}}</div>
                @endif
                <div class="form__text_box_then_delete_icon">
                    <input type="text" name="url_link_0_url" id="form_url_link_0_url" class="form__input">
                    <div class="form__spacing_between_text_box_and_delete_icon"></div>
                    <i class="fa-solid fa-trash-can" delete_info="form_url_link_0"></i>
                </div>
            </div>
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

    </script>
    <!-- Create CV SCRIPT -->
    <script src="{{asset('public/js/create_cv.js')}}"></script>
</body>

</html>
@endsection
