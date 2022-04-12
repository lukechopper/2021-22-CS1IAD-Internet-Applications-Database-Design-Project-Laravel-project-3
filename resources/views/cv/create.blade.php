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
            </div>
            <div class="form__container">
                <label for="form_first_name">First Name:</label>
                <input type="text" name="first_name" id="form_first_name" class="form__input">
            </div>
            <div class="form__container">
                <label for="form_last_name">Last Name:</label>
                <input type="text" name="last_name" id="form_last_name" class="form__input">
            </div>
            <div class="form__container form__container--full">
                <label for="form_profile">Profile:</label>
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
                <input type="text" name="education_0_name" id="form_education_0_name" class="form__input">
            </div>
            <div class="form__container form__container--less_top_margin" delete_info="form_education_0">
                <label for="form_education_0_duration">Duration:</label>
                <input type="text" name="education_0_duration" id="form_education_0_duration" class="form__input">
            </div>
            <div class="form__container form__container--full form__container--less_top_margin" delete_info="form_education_0">
                <label for="form_education_0_description">Description:</label>
                <div class="form__text_box_then_delete_icon">
                    <div class="form__textarea_container">
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
                <input type="text" name="key_programming_language_0_name" id="form_key_programming_language_0_name" class="form__input">
            </div>
            <div class="form__container form__container--less_top_margin" delete_info="form_key_programming_language_0">
                <label for="form_key_programming_language_0_duration">Duration:</label>
                <input type="text" name="key_programming_language_0_duration" id="form_key_programming_language_0_duration" class="form__input">
            </div>
            <div class="form__container form__container--full form__container--less_top_margin" delete_info="form_key_programming_language_0">
                <label for="form_key_programming_language_0_description">Description:</label>
                <div class="form__text_box_then_delete_icon">
                    <div class="form__textarea_container">
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
                <input type="text" name="url_link_0_title" id="form_url_link_0_title" class="form__input">
            </div>
            <div class="form__container form__container--less_top_margin" delete_info="form_url_link_0">
                <label for="form_url_link_0_url">URL:</label>
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
    <!-- Create CV SCRIPT -->
    <script src="{{asset('public/js/create_cv.js')}}"></script>
</body>

</html>
@endsection
