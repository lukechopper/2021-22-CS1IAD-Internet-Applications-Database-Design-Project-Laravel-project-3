$(function(){

    let basicFormItemNames = ['form_first_name', 'form_last_name', 'form_profile'];
    let formEducationNames = ['form_education_NUM_name', 'form_education_NUM_duration', 'form_education_NUM_description'];
    let keyProgrammingLanguagesNames = ['form_key_programming_language_NUM_name', 'form_key_programming_language_NUM_duration', 'form_key_programming_language_NUM_description'];
    let urlLinksNames = ['form_url_link_NUM_title', 'form_url_link_NUM_url'];

    let educationRegex = new RegExp('form_education_[0-9]+', 'i');
    let keyProgrammingLanguageRegex = new RegExp('form_key_programming_language_[0-9]+', 'i');

    function addDynamicEducationItem(deleteInfoNum){
        $('#form__begin_key_programming_languages_section').before('<div class="form__container form__container--less_top_margin" delete_info="form_education_'+deleteInfoNum+'" open_info="form_education_'+deleteInfoNum+'"> \
        <label for="form_education_'+deleteInfoNum+'_name">Name:</label> \
        <input type="text" name="education_'+deleteInfoNum+'_name" id="form_education_'+deleteInfoNum+'_name" class="form__input"> \
    </div> \
    <div class="form__container form__container--less_top_margin" delete_info="form_education_'+deleteInfoNum+'"> \
        <label for="form_education_'+deleteInfoNum+'_duration">Duration:</label> \
        <input type="text" name="education_'+deleteInfoNum+'_duration" id="form_education_'+deleteInfoNum+'_duration" class="form__input"> \
    </div> \
    <div class="form__container form__container--full form__container--less_top_margin" delete_info="form_education_'+deleteInfoNum+'"> \
        <label for="form_education_'+deleteInfoNum+'_description">Description:</label> \
        <div class="form__text_box_then_delete_icon"> \
            <div class="form__textarea_container"> \
            <textarea name="education_'+deleteInfoNum+'_description" id="form_education_'+deleteInfoNum+'_description" class="form__input form__input--smaller_textarea"></textarea> \
            </div> \
            <div class="form__spacing_between_text_box_and_delete_icon"></div> \
            <i class="fa-solid fa-trash-can" delete_info="form_education_'+deleteInfoNum+'"></i> \
        </div> \
    </div>');
    }

    function addDynamicKeyProgrammingLanguage(deleteInfoNum){
        $('#form__begin_url_links_section').before('<div class="form__container form__container--less_top_margin" delete_info="form_key_programming_language_'+deleteInfoNum+'" open_info="form_key_programming_language_'+deleteInfoNum+'"> \
        <label for="form_key_programming_language_'+deleteInfoNum+'_name">Name:</label> \
        <input type="text" name="key_programming_language_'+deleteInfoNum+'_name" id="form_key_programming_language_'+deleteInfoNum+'_name" class="form__input"> \
    </div> \
    <div class="form__container form__container--less_top_margin" delete_info="form_key_programming_language_'+deleteInfoNum+'"> \
        <label for="form_key_programming_language_'+deleteInfoNum+'_duration">Duration:</label> \
        <input type="text" name="key_programming_language_'+deleteInfoNum+'_duration" id="form_key_programming_language_'+deleteInfoNum+'_duration" class="form__input"> \
    </div> \
    <div class="form__container form__container--full form__container--less_top_margin" delete_info="form_key_programming_language_'+deleteInfoNum+'"> \
        <label for="form_key_programming_language_'+deleteInfoNum+'_description">Description:</label> \
        <div class="form__text_box_then_delete_icon"> \
            <div class="form__textarea_container"> \
            <textarea name="key_programming_language_'+deleteInfoNum+'_description" id="form_key_programming_language_'+deleteInfoNum+'_description" class="form__input form__input--smaller_textarea"></textarea> \
            </div> \
            <div class="form__spacing_between_text_box_and_delete_icon"></div> \
            <i class="fa-solid fa-trash-can" delete_info="form_key_programming_language_'+deleteInfoNum+'"></i> \
        </div> \
    </div>');
    }

    function addDynamicUrlLink(deleteInfoNum){
        $('#form__submit_section').before('<div class="form__container form__container--less_top_margin" delete_info="form_url_link_'+deleteInfoNum+'" open_info="form_url_link_'+deleteInfoNum+'"> \
        <label for="form_url_link_'+deleteInfoNum+'_title">Title:</label> \
        <input type="text" name="url_link_'+deleteInfoNum+'_title" id="form_url_link_'+deleteInfoNum+'_title" class="form__input"> \
    </div> \
    <div class="form__container form__container--less_top_margin" delete_info="form_url_link_'+deleteInfoNum+'"> \
        <label for="form_url_link_'+deleteInfoNum+'_url">URL:</label> \
        <div class="form__text_box_then_delete_icon"> \
            <input type="text" name="url_link_'+deleteInfoNum+'_url" id="form_url_link_'+deleteInfoNum+'_url" class="form__input"> \
            <div class="form__spacing_between_text_box_and_delete_icon"></div> \
            <i class="fa-solid fa-trash-can" delete_info="form_url_link_'+deleteInfoNum+'"></i> \
        </div> \
    </div>');
    }

    function isBrowserDataNotEmptyForDynamic(isAlreadyNotEmpty, namesArray, storedLength){
        if(isAlreadyNotEmpty) return true;
        let isDynamicNotEmpty = false;
        if(!Array.isArray(namesArray)) return;
        for(let i = 0; i <= storedLength; i++){
            namesArray.forEach(function(name){
                if(isDynamicNotEmpty) return;
                let dynamicName = name.replace('NUM', i);
                let storedVal = localStorage.getItem(dynamicName);
                if(storedVal){
                    isDynamicNotEmpty = true;
                }
            });
        }
        return isDynamicNotEmpty;
    }

    function deleteDynamicFormInput(namesArray, number){
        if(!Array.isArray(namesArray)) return;
        namesArray.forEach(function(name){
            let dynamicName = name.replace('NUM', number);
            $('#'+dynamicName).closest('.form__container.form__container--less_top_margin').remove();
            localStorage.setItem(dynamicName, '');
        });
    }

    function transferStoredDataIntoDynamicFormInput(namesArray, storedLength, addDynamicItemFunctionName){
        if(!Array.isArray(namesArray)) return;
        for(let i = 0; i <= storedLength; i++){
            //TODO: Insert Actual Dynamic Form Elements Here
            if(i > 0){
                if(addDynamicItemFunctionName === 'addDynamicEducationItem'){
                    addDynamicEducationItem(i);
                }else if(addDynamicItemFunctionName === 'addDynamicKeyProgrammingLanguage'){
                    addDynamicKeyProgrammingLanguage(i);
                }
            }
            namesArray.forEach(function(name){
                let dynamicName = name.replace('NUM', i);
                let storedVal = localStorage.getItem(dynamicName);
                $('#'+dynamicName).val(storedVal);
            });
        }
    }

    function saveDynamicFormInput(namesArray, number){
        if(!Array.isArray(namesArray)) return;
        namesArray.forEach(function(name){
            let dynamicName = name.replace('NUM', number);
            let goingToBeSavedValue = $('#'+dynamicName).val();
            if(!goingToBeSavedValue) goingToBeSavedValue = '';
            localStorage.setItem(dynamicName, goingToBeSavedValue);
        });
    }

    function isBrowserDataNotEmpty(){
        let isNotEmpty = false;
        basicFormItemNames.forEach(function(item){
            if(localStorage.getItem(item)){
                isNotEmpty = true;
            }
        });
        let storedNumOfFormEducation = localStorage.getItem('num_of_form_education');
        if(storedNumOfFormEducation){
            isNotEmpty = isBrowserDataNotEmptyForDynamic(isNotEmpty, formEducationNames, parseInt(storedNumOfFormEducation));
        }
        let storedNumOfKeyProgrammingLanguages = localStorage.getItem('num_of_key_programming_language');
        if(storedNumOfKeyProgrammingLanguages){
            isNotEmpty = isBrowserDataNotEmptyForDynamic(isNotEmpty, keyProgrammingLanguagesNames, parseInt(storedNumOfKeyProgrammingLanguages));
        }
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
            if(savedData){
                $('#'+item).val(savedData);
            }
        });
    }

    function saveFormData(){
        let numOfFormEducation = 0;
        let numOfKeyProgrammingLanguages = 0;
        $('.form__container.form__container--less_top_margin').each(function(){
            let typeOfContainer = $(this).attr('open_info');
            if(educationRegex.test(typeOfContainer)){
                localStorage.setItem('num_of_form_education', numOfFormEducation);
                saveDynamicFormInput(formEducationNames, numOfFormEducation);
                numOfFormEducation++;
            }else if(keyProgrammingLanguageRegex.test(typeOfContainer)){
                localStorage.setItem('num_of_key_programming_language', numOfKeyProgrammingLanguages);
                saveDynamicFormInput(keyProgrammingLanguagesNames, numOfKeyProgrammingLanguages);
                numOfKeyProgrammingLanguages++;
            }
        });
        if(!numOfFormEducation){
            localStorage.setItem('num_of_form_education', 'NAN');
        }
        if(!numOfKeyProgrammingLanguages){
            localStorage.setItem('num_of_key_programming_language', 'NAN');
        }
        browserSaveFormData();
    }

    function displayDynamicFormDataOnLoad(numOfDynamicFormItems, correctNamesArray, addDynamicItemFunctionName){
        if(!Array.isArray(correctNamesArray)) return;
        if(numOfDynamicFormItems){
            if(numOfDynamicFormItems === 'NAN'){
                deleteDynamicFormInput(correctNamesArray, '0');
            }else{
                transferStoredDataIntoDynamicFormInput(correctNamesArray, parseInt(numOfDynamicFormItems), addDynamicItemFunctionName)
            }
        }
    }

    //Load form data on webpage load
    if(isBrowserDataNotEmpty()){
        let storedNumOfFormEducation = localStorage.getItem('num_of_form_education');
        let storedNumOfKeyProgrammingLanguages = localStorage.getItem('num_of_key_programming_language');
        displayDynamicFormDataOnLoad(storedNumOfFormEducation, formEducationNames, 'addDynamicEducationItem');
        displayDynamicFormDataOnLoad(storedNumOfKeyProgrammingLanguages, keyProgrammingLanguagesNames, 'addDynamicKeyProgrammingLanguage');

        browserGetFormData();
    }

    function deleteEventListener(){
        let deleteInfo = $(this).attr('delete_info');
        let numOfDeleteInfo = deleteInfo.match(/[0-9]+/i)[0];
        $('.form__container.form__container--less_top_margin').each(function(){
            if(educationRegex.test(deleteInfo)){

            }
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
        addDynamicEducationItem(numOfEducationItems);
        addDeleteEventListeners();
        saveFormData();
    });

    let numOfKeyProgrammingLanguages = 0;
    $('#form__add_new_programming_language').click(function(){
        numOfKeyProgrammingLanguages++;
        addDynamicKeyProgrammingLanguage(numOfKeyProgrammingLanguages);
        addDeleteEventListeners();
        saveFormData();
    });

    let numOfUrlLinks = 0;
    $('#form__add_new_url_link').click(function(){
        numOfUrlLinks++;
        addDynamicUrlLink(numOfUrlLinks);
        addDeleteEventListeners();
        saveFormData();
    });

    $('.form').on('input', function(){
        saveFormData();
    });
});
