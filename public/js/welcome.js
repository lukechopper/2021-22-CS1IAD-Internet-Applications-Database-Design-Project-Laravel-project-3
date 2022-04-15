$(function(){

    let searchConfigOption = 'Name';

    $('#cv_configure_search_category').on('input', function(){
        if($(this).val() !== 'Name'){
            $(this).addClass('search__configure_search_category--large_width');
            searchConfigOption = 'Programming Language';
            return;
        }
        $(this).removeClass('search__configure_search_category--large_width');
        searchConfigOption = 'Name';
    });

    $('#cv_search_input').on('input', function(){

        let searchString =$(this).val();

        let regularExpressionForNameSearch = new RegExp(/[!"`'#%£&,:;<>=@{}~\$\(\)\*\+\/\\\?\[\]\^\|]|[0-9]|\s+/, 'g');

        if(searchConfigOption === 'Name'){
            searchString = searchString.replace(regularExpressionForNameSearch, '');
        }


        if(!searchString){
            return;
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csfrToken
            }
        });
        $.ajax({
            url: searchCVRoute,
            type: 'POST',
            dataType : 'json',
            data:{
                searchConfigOption: searchConfigOption,
                search: searchString
            },
            success: function(response){
                console.log(response);
            },
            error: function(err){
                console.log(err);
            }
        });
    });
});
