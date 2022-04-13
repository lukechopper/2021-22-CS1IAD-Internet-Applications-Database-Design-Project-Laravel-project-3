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
    let urlLinksRegex = new RegExp('form_url_link_[0-9]+', 'i');

    /*
    * These 3 variables count the number of dynamic input types that there is on the form for each individual type, hence why their is a variable for each type of dynamic input to make 3 in total. They are used for the numbering of the inputs.
    */
    let numOfEducationItems = 0;
    let numOfKeyProgrammingLanguages = 0;
    let numOfUrlLinks = 0;
    /**
     * Acompanying each of these global variables are their own functions to set their value to something new.
     * @param {int} newVal
     */
    function setNumOfEducationItems(newVal){
        numOfEducationItems = newVal;
    }
    function setNumOfKeyProgrammingLanguages(newVal){
        numOfKeyProgrammingLanguages = newVal;
    }
    function setNumOfUrlLinks(newVal){
        numOfUrlLinks = newVal;
    }

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

    console.log(errorObj);

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
                }else if(addDynamicItemFunctionName === 'addDynamicUrlLink'){
                    addDynamicUrlLink(i);
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
        let numOfFormProgrammingLanguages = 0;
        let numOfFormUrlLinks = 0;
        $('.form__container.form__container--less_top_margin').each(function(){
            let typeOfContainer = $(this).attr('open_info');
            if(educationRegex.test(typeOfContainer)){
                localStorage.setItem('num_of_form_education', numOfFormEducation);
                saveDynamicFormInput(formEducationNames, numOfFormEducation);
                numOfFormEducation++;
            }else if(keyProgrammingLanguageRegex.test(typeOfContainer)){
                localStorage.setItem('num_of_key_programming_language', numOfFormProgrammingLanguages);
                saveDynamicFormInput(keyProgrammingLanguagesNames, numOfFormProgrammingLanguages);
                numOfFormProgrammingLanguages++;
            }else if(urlLinksRegex.test(typeOfContainer)){
                localStorage.setItem('num_of_url_links', numOfFormUrlLinks);
                saveDynamicFormInput(urlLinksNames, numOfFormUrlLinks);
                numOfFormUrlLinks++;
            }
        });
        if(!numOfFormEducation){
            localStorage.setItem('num_of_form_education', 'NAN');
            setNumOfEducationItems(-1);
        }
        if(!numOfFormProgrammingLanguages){
            localStorage.setItem('num_of_key_programming_language', 'NAN');
            setNumOfKeyProgrammingLanguages(-1);
        }
        if(!numOfFormUrlLinks){
            localStorage.setItem('num_of_url_links', 'NAN');
            setNumOfUrlLinks(-1);
        }
        browserSaveFormData();
    }
    /**
     * Modifies the form on form load so that its form reflects how it is represented in the data from localStorage.
     * @param {string} numOfDynamicFormItems the number of a particular form input type, as determined by the following parameter, 'correctNamesArray', that this function should add.
     * @param {Array<string>} correctNamesArray the CV template names that this function will check, so it specifies which dynamic part of the form this function call will deal with in particular.
     * @param {string} addDynamicItemFunctionName used so that it can be passed into the 'transferStoredDataIntoDynamicFormInput' function. Read its description there for more info.
     * @param {function} setNewNumOfItemsCallbackFunction the callback function that will set the relevant number of items to be -1 if it is the case that the data in localStorage is informing us that there are none of the current dynamic input type should be on the form at the moment.
     * @returns void
     */
    function displayDynamicFormDataOnLoad(numOfDynamicFormItems, correctNamesArray, addDynamicItemFunctionName, setNewNumOfItemsCallbackFunction){
        if(!Array.isArray(correctNamesArray)) return;
        if(numOfDynamicFormItems){
            if(numOfDynamicFormItems === 'NAN'){
                deleteDynamicFormInput(correctNamesArray, '0');
                setNewNumOfItemsCallbackFunction(-1);
            }else{
                transferStoredDataIntoDynamicFormInput(correctNamesArray, parseInt(numOfDynamicFormItems), addDynamicItemFunctionName)
            }
        }
    }

    //Load form data on webpage load
    //BEGIN OF SECTION THAT SHOULD HAPPEN ON DOCUMENT LOAD
        let storedNumOfFormEducation = localStorage.getItem('num_of_form_education');
        let storedNumOfKeyProgrammingLanguages = localStorage.getItem('num_of_key_programming_language');
        let storedNumOfUrlLinks = localStorage.getItem('num_of_url_links');
        displayDynamicFormDataOnLoad(storedNumOfFormEducation, formEducationNames, 'addDynamicEducationItem', setNumOfEducationItems);
        displayDynamicFormDataOnLoad(storedNumOfKeyProgrammingLanguages, keyProgrammingLanguagesNames, 'addDynamicKeyProgrammingLanguage', setNumOfKeyProgrammingLanguages);
        displayDynamicFormDataOnLoad(storedNumOfUrlLinks, urlLinksNames, 'addDynamicUrlLink', setNumOfUrlLinks);

        browserGetFormData();
    //END OF SECTION THAT SHOULD HAPPEN ON DOCUMENT LOAD
    /**
     * Returns the regex relevant to the dynamic input that is currently being deleted from where this function is being called – the 'deleteEventListener'. In addition to this, also sort out the numbering of the current number of the relevant dynamic input types since this is the function, in particular, where we will be aware of the specific type of dynamic input that is being deleted. But note however, not all of this is covered here, the numbering in relation to a special scenario where no dynamic form inputs are present on the CV form is covered in the 'saveFormData' function as well as the 'displayDynamicFormDataOnLoad' function.
     * @param {string} deleteInfo the 'delete_info' attribute of the dynamic input that is currently being deleted from where this function is being called – the 'deleteEventListener'.
     * @returns {RegExp}
     */
    function whichTypeOfDynamicInputIsBeingDeleted(deleteInfo){
        if(educationRegex.test(deleteInfo)){
            if(numOfEducationItems > 0){
                numOfEducationItems--;
            }
            return educationRegex;
        }else if(keyProgrammingLanguageRegex.test(deleteInfo)){
            if(numOfKeyProgrammingLanguages > 0){
                numOfKeyProgrammingLanguages--;
            }
            return keyProgrammingLanguageRegex;
        }else if(urlLinksRegex.test(deleteInfo)){
            if(numOfUrlLinks > 0){
                numOfUrlLinks--;
            }
            return urlLinksRegex;
        }
    }
    /**
     * The function that will take an attribute from an element related to a dynamic form input, pick out the number from this attribute, and then replace it with the number supplied as this functions third parameter.
     * @param {JQuery} jQueryFormInput The actual element, in JQuery form, that will have one of its attributes changed in this function.
     * @param {string} attributeToChange The attribute name that will be changed.
     * @param {int} newNumber The new number that will replace the old number in the former attribute value.
     */
    function updateTheRelevantNumberInAttributesOfDynamicFormInput(jQueryFormInput, attributeToChange, newNumber){
        let newAttributeValue = jQueryFormInput.attr(attributeToChange).replace(/[0-9]+/i, newNumber);
        jQueryFormInput.attr(attributeToChange, newAttributeValue);
    }

    /**
     * The delete event listener that is added to the relevant delete icon of every dynamic form input within the form.
     */
    function deleteEventListener(){
        let deleteInfo = $(this).attr('delete_info');
        let numOfDeleteInfo = parseInt(deleteInfo.match(/[0-9]+/i)[0]);
        let regexOfDynamicInputBeingDeleted = whichTypeOfDynamicInputIsBeingDeleted(deleteInfo);

        $('.form__container.form__container--less_top_margin').each(function(){
            let thisDeleteInfo = $(this).attr('delete_info');

            if(deleteInfo === thisDeleteInfo){
                $(this).remove();
            }
        });
        //If the 'delete_info' of the dynamic input container that is being looped through here is not matching the dynamic input that should be deleted but it is of the same type of that input and it has a higher number than that input, then we need to decrease its value to reflect the fact that the dynamic input below it has been deleted.
        $('.form__container.form__container--less_top_margin').each(function(){
            let thisDeleteInfo = $(this).attr('delete_info');
            let numOfThisDeleteInfo = parseInt(thisDeleteInfo.match(/[0-9]+/i)[0]);

            if(regexOfDynamicInputBeingDeleted.test(thisDeleteInfo) && numOfThisDeleteInfo > numOfDeleteInfo){
                if($(this).attr('open_info')){
                    updateTheRelevantNumberInAttributesOfDynamicFormInput($(this), 'open_info', numOfThisDeleteInfo - 1);
                }
                updateTheRelevantNumberInAttributesOfDynamicFormInput($(this), 'delete_info', numOfThisDeleteInfo - 1);

                let currentJQueryFormInput = $(this).find('.form__input');
                updateTheRelevantNumberInAttributesOfDynamicFormInput(currentJQueryFormInput, 'name', numOfThisDeleteInfo - 1);
                updateTheRelevantNumberInAttributesOfDynamicFormInput(currentJQueryFormInput, 'id', numOfThisDeleteInfo - 1);

                let possibleJQueryDeleteIconEle = $(this).find('.fa-solid.fa-trash-can');
                if(possibleJQueryDeleteIconEle.length){
                    updateTheRelevantNumberInAttributesOfDynamicFormInput(possibleJQueryDeleteIconEle, 'delete_info', numOfThisDeleteInfo - 1);
                }

                let jQueryLabelIconEle = $(this).find('label');
                updateTheRelevantNumberInAttributesOfDynamicFormInput(jQueryLabelIconEle, 'for', numOfThisDeleteInfo - 1);
            }
        });

        saveFormData();
    }
    /**
     * Actually adds the delete event listener to the relevant delete icon of every dynamic form input within the form. Is called whenever a new input is added but also on document load as well.
     */
    function addDeleteEventListeners(){
        $('.fa-solid.fa-trash-can').each(function(){
            $(this).off().click(deleteEventListener);
        });
    } addDeleteEventListeners();

    /*
    The next 3 callback functions are all 'click' event handlers that allow a new dynamic form input to be added to their particular section when the relevant icon is clicked on – hence why there are 3 of them.
    */
    /**
     * @var {int} numOfEducationItems The number of dynamic education inputs that there is on the CV form – used for numbering the dynamic inputs so that they can be stored properly.
     */
    $('#form__add_new_education_item').click(function(){
        numOfEducationItems++;
        addDynamicEducationItem(numOfEducationItems);
        addDeleteEventListeners();
        saveFormData();
    });

    /**
     * @var {int} numOfKeyProgrammingLanguages The number of dynamic key programming language inputs that there is on the CV form – used for numbering the dynamic inputs so that they can be stored properly.
     */
    $('#form__add_new_programming_language').click(function(){
        numOfKeyProgrammingLanguages++;
        addDynamicKeyProgrammingLanguage(numOfKeyProgrammingLanguages);
        addDeleteEventListeners();
        saveFormData();
    });


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
