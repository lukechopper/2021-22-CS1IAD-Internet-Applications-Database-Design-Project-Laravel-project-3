$(function(){

    let searchConfigOption = 'Name';
    let originalCVContainerHTML = $('#cv_container').html();

    $('#cv_configure_search_category').on('input', function(){
        if($(this).val() !== 'Name'){
            $(this).addClass('search__configure_search_category--large_width');
            searchConfigOption = 'Programming Language';
        }else{
            $(this).removeClass('search__configure_search_category--large_width');
            searchConfigOption = 'Name';
        }

        searchInputEventListener();
    });

    function sortCVListItemClass(id){
        let baseClass = 'cv__list_item_container';
        if(id % 3 === 0){
            baseClass += ' cv__list_item_container--left';
        }else if(id % 3 === 1){
            baseClass += ' cv__list_item_container--middle';
        }else if(id % 3 === 2){
            baseClass += ' cv__list_item_container--right';
        }

       if(id % 2 === 0){
            baseClass += ' cv__list_item_container--medium_left';
       }else if(id % 2 === 1){
            baseClass += ' cv__list_item_container--medium_right';
       }
        return baseClass;
    }

    function printFoundCVSToDocument(arrayOfCVS){
        $('#cv_container').html('');
        let htmlString = '';
        $.each(arrayOfCVS, function(index, cv){
            let linkForItem = normalViewCVRoute.replace(/([0-9]+)$/i, cv.id);
            htmlString += '<div class="'+sortCVListItemClass(index)+'"> \
            <div class="cv__list_item"> \
                <h2 class="cv__name">'+cv.name+'</h2> \
                <a href="'+linkForItem+'" class="cv__view_cv_btn">View CV</a> \
            </div> \
        </div>';
        });
        $('#cv_container').html(htmlString);
    }

    let justRecordedBlankSearch = false;
    function searchInputEventListener(){

        if(areNoCVs) return;

        let searchString =$('#cv_search_input').val();

        let regularExpressionForNameSearch = new RegExp(/[!"`'#%£&,:;<>=@{}~\$\(\)\*\+\/\\\?\[\]\^\|]|[0-9]|\s+/, 'g');
        let regularExpressionLanguageSearch = new RegExp(/\s+/, 'g');
        if(searchConfigOption === 'Name'){
            searchString = searchString.replace(regularExpressionForNameSearch, '');
        }else{
            searchString = searchString.replace(regularExpressionLanguageSearch, '');
        }

        if(!searchString){
            //Search is completely empty so don't send an ajax request
            $('#cv_container').html(originalCVContainerHTML);
            justRecordedBlankSearch = true;
            return;
        }

        justRecordedBlankSearch = false;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csfrToken
            }
        });
        $.ajax({
            url: searchCVRoute,
            type: 'GET',
            dataType : 'json',
            data:{
                searchConfigOption: searchConfigOption,
                search: searchString
            },
            success: function(response){
                //Found CVS, so print them to the HTML document
                if(justRecordedBlankSearch) return;
                if(response.foundCVS.length){
                    printFoundCVSToDocument(response.foundCVS);
                    return;
                }
                $('#cv_container').html('<div class="cv__sorry_no_matches_msg">Sorry. Nothing matched your search.</div>');
            },
            error: function(err){
                setTimeout(function(){
                    searchInputEventListener();
                }, 250);
            }
        });
    }

    $('#cv_search_input').on('keyup', searchInputEventListener);


});
