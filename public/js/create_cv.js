$(function(){

    let basicFormItemNames = ['form_first_name', 'form_last_name', 'form_profile'];
    let formEducationNames = ['form_education_NUM_name', 'form_education_NUM_duration', 'form_education_NUM_description'];

    function isBrowserDataEmpty(){
        let isNotEmpty = false;
        basicFormItemNames.forEach(function(item){
            if(localStorage.getItem(item)){
                isNotEmpty = true;
            }
        });
        return isNotEmpty;
    }

    function browserSaveFormData(){
        basicFormItemNames.forEach(function(item){
            localStorage.setItem(item, $('#'+item).val());
        });
    }

    function browserGetFormData(){
        basicFormItemNames.forEach(function(item){
            let savedData = localStorage.getItem(item);
            $('#'+item).val(savedData);
        });
    }

    function saveFormData(){
        //ToDo: leave the forms hidden input alone
        let numOfFormEducation = 0;
        $('.form__container.form__container--less_top_margin').each(function(){
            let typeOfContainer = $(this).attr('open_info');
            let educationRegex = new RegExp('form_education_[0-9]+', 'i');
            if(educationRegex.test(typeOfContainer)){
                numOfFormEducation++;
                localStorage.setItem('num_of_form_education', numOfFormEducation);
            }
        });
        if(!numOfFormEducation){
            localStorage.setItem('num_of_form_education', 'NAN');
        }
        browserSaveFormData();
    }

    if(isBrowserDataEmpty()){
        browserGetFormData();
    }

    function deleteEventListener(){
        let deleteInfo = $(this).attr('delete_info');
        $('.form__container.form__container--less_top_margin').each(function(){
            if(deleteInfo === $(this).attr('delete_info')){
                $(this).remove();
                saveFormData();
            }
        });
    }

    function addDeleteEventListeners(){
        $('.fa-solid.fa-trash-can').each(function(){
            $(this).click(deleteEventListener);
        });
    } addDeleteEventListeners();

    let numOfEducationItems = 0;
    $('#form__add_new_education_item').click(function(){
        numOfEducationItems++;
        $('#form__begin_key_programming_languages_section').before('<div class="form__container form__container--less_top_margin" delete_info="form_education_'+numOfEducationItems+'" open_info="form_education_'+numOfEducationItems+'"> \
        <label for="form_education_'+numOfEducationItems+'_name">Name:</label> \
        <input type="text" name="education_'+numOfEducationItems+'_name" id="form_education_'+numOfEducationItems+'_name" class="form__input"> \
    </div> \
    <div class="form__container form__container--less_top_margin" delete_info="form_education_'+numOfEducationItems+'"> \
        <label for="form_education_'+numOfEducationItems+'_duration">Duration:</label> \
        <input type="text" name="education_'+numOfEducationItems+'_duration" id="form_education_'+numOfEducationItems+'_duration" class="form__input"> \
    </div> \
    <div class="form__container form__container--full form__container--less_top_margin" delete_info="form_education_'+numOfEducationItems+'"> \
        <label for="form_education_'+numOfEducationItems+'_description">Description:</label> \
        <div class="form__text_box_then_delete_icon"> \
            <div class="form__textarea_container"> \
            <textarea name="education_'+numOfEducationItems+'_description" id="form_education_'+numOfEducationItems+'_description" class="form__input form__input--smaller_textarea"></textarea> \
            </div> \
            <div class="form__spacing_between_text_box_and_delete_icon"></div> \
            <i class="fa-solid fa-trash-can" delete_info="form_education_'+numOfEducationItems+'"></i> \
        </div> \
    </div>');
        addDeleteEventListeners();
        saveFormData();
    });

    let numOfKeyProgrammingLanguages = 0;
    $('#form__add_new_programming_language').click(function(){
        numOfKeyProgrammingLanguages++;
        $('#form__begin_url_links_section').before('<div class="form__container form__container--less_top_margin" delete_info="form_key_programming_language_'+numOfKeyProgrammingLanguages+'"> \
        <label for="form_key_programming_language_'+numOfKeyProgrammingLanguages+'_name">Name:</label> \
        <input type="text" name="key_programming_language_'+numOfKeyProgrammingLanguages+'_name" id="form_key_programming_language_'+numOfKeyProgrammingLanguages+'_name" class="form__input"> \
    </div> \
    <div class="form__container form__container--less_top_margin" delete_info="form_key_programming_language_'+numOfKeyProgrammingLanguages+'"> \
        <label for="form_key_programming_language_'+numOfKeyProgrammingLanguages+'_duration">Duration:</label> \
        <input type="text" name="key_programming_language_'+numOfKeyProgrammingLanguages+'_duration" id="form_key_programming_language_'+numOfKeyProgrammingLanguages+'_duration" class="form__input"> \
    </div> \
    <div class="form__container form__container--full form__container--less_top_margin" delete_info="form_key_programming_language_'+numOfKeyProgrammingLanguages+'"> \
        <label for="form_key_programming_language_'+numOfKeyProgrammingLanguages+'_description">Description:</label> \
        <div class="form__text_box_then_delete_icon"> \
            <div class="form__textarea_container"> \
            <textarea name="key_programming_language_'+numOfKeyProgrammingLanguages+'_description" id="form_key_programming_language_'+numOfKeyProgrammingLanguages+'_description" class="form__input form__input--smaller_textarea"></textarea> \
            </div> \
            <div class="form__spacing_between_text_box_and_delete_icon"></div> \
            <i class="fa-solid fa-trash-can" delete_info="form_key_programming_language_'+numOfKeyProgrammingLanguages+'"></i> \
        </div> \
    </div>');
        addDeleteEventListeners();
        saveFormData();
    });

    let numOfUrlLinks = 0;
    $('#form__add_new_url_link').click(function(){
        numOfUrlLinks++;
        $('#form__submit_section').before('<div class="form__container form__container--less_top_margin" delete_info="form_url_link_'+numOfUrlLinks+'"> \
        <label for="form_url_link_'+numOfUrlLinks+'_title">Title:</label> \
        <input type="text" name="url_link_'+numOfUrlLinks+'_title" id="form_url_link_'+numOfUrlLinks+'_title" class="form__input"> \
    </div> \
    <div class="form__container form__container--less_top_margin" delete_info="form_url_link_'+numOfUrlLinks+'"> \
        <label for="form_url_link_'+numOfUrlLinks+'_url">URL:</label> \
        <div class="form__text_box_then_delete_icon"> \
            <input type="text" name="url_link_'+numOfUrlLinks+'_url" id="form_url_link_'+numOfUrlLinks+'_url" class="form__input"> \
            <div class="form__spacing_between_text_box_and_delete_icon"></div> \
            <i class="fa-solid fa-trash-can" delete_info="form_url_link_'+numOfUrlLinks+'"></i> \
        </div> \
    </div>');
        addDeleteEventListeners();
        saveFormData();
    });

    $('.form').on('input', function(){
        saveFormData();
    });
});
