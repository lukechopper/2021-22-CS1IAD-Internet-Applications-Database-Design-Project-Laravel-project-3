$(function(){

    /**
     * CV Form template names, both for the static parts of the form and the dynamic parts of the form. The ones relating to the dynamic parts of the form will have 'NUM' written in them.
     * @type {Array<strings>}
     */
    let basicFormItemNames = ['form_first_name', 'form_last_name', 'form_profile'];
    let formEducationNames = ['form_education_NUM_name', 'form_education_NUM_duration', 'form_education_NUM_description'];
    let keyProgrammingLanguagesNames = ['form_key_programming_language_NUM_name', 'form_key_programming_language_NUM_duration', 'form_key_programming_language_NUM_description'];
    let urlLinksNames = ['form_url_link_NUM_title', 'form_url_link_NUM_url'];

    /**
     * The regex to identify which part of the form a dynamic input is pertaining to.
     */
    let educationRegex = new RegExp('form_education_[0-9]+', 'i');
    let keyProgrammingLanguageRegex = new RegExp('form_key_programming_language_[0-9]+', 'i');

    /**
     * Will add a new dynamic education item to the CV form in the relevant place
     * @param {string|num} deleteInfoNum used to number the dynamic input. So, if this is the first dynamic input of its kind, then this number should be 0, but it should be 1 if it is the second one being added, and so on.
     */
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
    /**
     * Will add a new dynamic key programming language item to the CV form in the relevant place
     * @param {string|num} deleteInfoNum used to number the dynamic input. So, if this is the first dynamic input of its kind, then this number should be 0, but it should be 1 if it is the second one being added, and so on.
     */
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
    /**
     * Will add a new URL link item to the CV form in the relevant place
     * @param {string|num} deleteInfoNum used to number the dynamic input. So, if this is the first dynamic input of its kind, then this number should be 0, but it should be 1 if it is the second one being added, and so on.
     */
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
    /**
     * Used in the 'isBrowserDataNotEmpty' function to do just that except that this function is for checking the dynamic parts of the form, in particular.
     * @param {boolean} isAlreadyNotEmpty if we have already found out the truth – that the form is already not empty, so does contain content, then the rest of the function does not need to be executed.
     * @param {Array<string>} namesArray the CV template names that this function will check, so it specifies which dynamic part of the form this function call will deal with in particular.
     * @param {int} storedLength the number of input sections that exist within the particular dynamic part of the form that is being checked on a specific function call of this function – used to ensure a comprehensive check.
     * @returns {boolean}
     */
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

    /**
     * Will delete a dynamic form input given a first argument to specify the type that should be deleted and a second argument to specify the number of the type to be deleted.
     * @param {Array<string>} namesArray the CV template names that this function will check, so it specifies which dynamic part of the form this function call will deal with in particular.
     * @param {int|string} number the exact number of the given type of dynamic form input that this function should remove from the DOM.
     * @returns void
     */
    function deleteDynamicFormInput(namesArray, number){
        if(!Array.isArray(namesArray)) return;
        namesArray.forEach(function(name){
            let dynamicName = name.replace('NUM', number);
            $('#'+dynamicName).closest('.form__container.form__container--less_top_margin').remove();
            localStorage.setItem(dynamicName, '');
        });
    }

    /**
     * used in the 'displayDynamicFormDataOnLoad' to do exactly that. Depending on the number of the given type of dynamic inputs that a particular call of this function is set to generate, as specified by the 'storedLength' parameter, this function will either add the input and then retrive its data from localStorage before setting it to be the value of the input that it just added, if the input is more than the first input of its kind in the DOM, or, if it is the first input of its kind in the DOM, then it will simply retrive this inputs value from localStorage and then set this retrived value to be its value as this input is already hard coded into the DOM.
     * @param {Array<string>} namesArray the CV template names that this function will check, so it specifies which dynamic part of the form this function call will deal with in particular.
     * @param {int} storedLength the number of a particular type of dynamic input that this function should add to the CV form
     * @param {string} addDynamicItemFunctionName the function name of the function that this function will use to add its type of dynamic inputs to the DOM when needs be.
     * @returns void
     */
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

    /**
     * Used in the 'saveFormData' function because it does exactly that except for a particular type of dynamic inputs only.
     * @param {Array<string>} namesArray the CV template names that this function will check, so it specifies which dynamic part of the form this function call will deal with in particular.
     * @param {int|string} number the number of the dynamic form input section that this function is responsible for storing the values of within localStorage.
     * @returns void
     */
    function saveDynamicFormInput(namesArray, number){
        if(!Array.isArray(namesArray)) return;
        namesArray.forEach(function(name){
            let dynamicName = name.replace('NUM', number);
            let goingToBeSavedValue = $('#'+dynamicName).val();
            if(!goingToBeSavedValue) goingToBeSavedValue = '';
            localStorage.setItem(dynamicName, goingToBeSavedValue);
        });
    }
    /**
     * Used on document load. If it finds out that the relevant localStorage items do exist, then it will start to do the necessary work to retrive them and add them to the dynamic form.
     * @returns {boolean}
     */
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
    /**
     * Save the form data but only for the static form inputs at the top of the CV form.
     */
    function browserSaveFormData(){
        basicFormItemNames.forEach(function(item){
            localStorage.setItem(item, $('#'+item).val());
        });
    }
    /**
     * Retrive the form data from localStorage and then make them the values of the relevant form inputs, but this is only applicable to the static form inputs at the top of the CV form.
     */
    function browserGetFormData(){
        basicFormItemNames.forEach(function(item){
            let savedData = localStorage.getItem(item);
            if(savedData){
                $('#'+item).val(savedData);
            }
        });
    }
    /**
     * Save the form data within localStorage – used whenever the form is changed in some way so that its new form can be saved within localStorage.
     */
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
    /**
     * Modifies the form on form load so that its form reflects how it is represented in the data from localStorage.
     * @param {string} numOfDynamicFormItems the number of a particular form input type, as determined by the following parameter, 'correctNamesArray', that this function should add.
     * @param {Array<string>} correctNamesArray the CV template names that this function will check, so it specifies which dynamic part of the form this function call will deal with in particular.
     * @param {string} addDynamicItemFunctionName used so that it can be passed into the 'transferStoredDataIntoDynamicFormInput' function. Read its description there for more info.
     * @returns void
     */
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

    function whichTypeOfDynamicInputIsBeingDeleted(deleteInfo){

    }

    /**
     * The delete event listener that is added to the relevant delete icon of every dynamic form input within the form.
     */
    function deleteEventListener(){
        let deleteInfo = $(this).attr('delete_info');
        // let numOfDeleteInfo = deleteInfo.match(/[0-9]+/i)[0];
        // if(educationRegex.test(deleteInfo)){

        // }
        $('.form__container.form__container--less_top_margin').each(function(){
            if(deleteInfo === $(this).attr('delete_info')){
                $(this).remove();
                saveFormData();
            }
        });
    }
    /**
     * Actually adds the delete event listener to the relevant delete icon of every dynamic form input within the form. Is called whenever a new input is added but also on document load as well.
     */
    function addDeleteEventListeners(){
        $('.fa-solid.fa-trash-can').each(function(){
            $(this).click(deleteEventListener);
        });
    } addDeleteEventListeners();

    /*
    The next 3 callback functions are all 'click' event handlers that allow a new dynamic form input to be added to their particular section when the relevant icon is clicked on – hence why there are 3 of them.
    */

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

    /* Via JQuery, will automatically save the form data whenever an input box is typed in. */
    $('.form').on('input', function(){
        saveFormData();
    });
});
