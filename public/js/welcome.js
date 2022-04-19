$(function(){

    let searchConfigOption = 'Name';
    let originalCVContainerHTML = $('#cv_container').html();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csfrToken
        }
    });

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

    let justRecordedBlankSearch = true;
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
            resetIntersectionObserver();
            justRecordedBlankSearch = true;
            return;
        }

        justRecordedBlankSearch = false;

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

    let isIntersecting = false;
    let numOfCVsRendered = 12;
    function setNumberOfCVsRendered(){
        if(numOfOriginalCVS > 12){
            numOfCVsRendered = 12;
            return;
        }
        numOfCVsRendered = numOfOriginalCVS;
    }setNumberOfCVsRendered();

    let intersectionObserverOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    function addMoreCVsBecauseReachedIntersectionObserver(){
        if(removeIntersectionObserverWhenNeeded()){
            return;
        }

        isIntersecting = true;

        function addMoreBlankCVs(){
            $.ajax({
                url: getMoreBlankCVRoute,
                type: 'GET',
                dataType : 'json',
                data:{
                    skip: numOfCVsRendered
                },
                success: function(response){
                    //Found CVS, so print them to the HTML document
                    $.each(response.newCVs, function(index, newCV){
                        let linkForItem = normalViewCVRoute.replace(/([0-9]+)$/i, newCV.id);
                $('#cv__list_item_bottom_container').before('<div class="'+sortCVListItemClass(numOfCVsRendered)+'"> \
                    <div class="cv__list_item"> \
                        <h2 class="cv__name">'+newCV.name+'</h2> \
                        <a href="'+linkForItem+'" class="cv__view_cv_btn">View CV</a> \
                    </div> \
                </div>');
                numOfCVsRendered++;
                    });
                    isIntersecting = false;
                },
                error: function(err){
                    setTimeout(function(){
                        addMoreBlankCVs();
                    }, 250);
                }
            });
        }
        addMoreBlankCVs();
    }

    let intersectionObserverCallback = function(entries, observer){
        if(numOfOriginalCVS <= 12) return;
        $.each(entries, function(index, entry){
            if(entry.target.id === 'cv__list_item_bottom_container'){
                if(entry.isIntersecting && !isIntersecting){
                    setTimeout(function(){
                        if(justRecordedBlankSearch){
                            addMoreCVsBecauseReachedIntersectionObserver();
                        }

                    }, 500);
                }
            }
        });
    }
    let observer = new IntersectionObserver(intersectionObserverCallback, intersectionObserverOptions);
    observer.observe($('#cv__list_item_bottom_container')[0]);

    function removeIntersectionObserverWhenNeeded(){
        let didRemove = false;
        if(numOfCVsRendered >= numOfOriginalCVS && $('#cv__list_item_bottom_container').length){
            $('#cv__list_item_bottom_container').remove();
            didRemove = true;
        }
        return didRemove;
    }

    setTimeout(function(){
        removeIntersectionObserverWhenNeeded();
    }, 1000);


    function resetIntersectionObserver(){
        $('#cv_container').html(originalCVContainerHTML);
        observer.observe($('#cv__list_item_bottom_container')[0]);
        setNumberOfCVsRendered();
        setTimeout(function(){
            removeIntersectionObserverWhenNeeded();
        }, 1000);
    }

});
