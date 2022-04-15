$(function(){
    $('#cv_configure_search_category').on('input', function(){
        if($(this).val() !== 'Name'){
            $(this).addClass('search__configure_search_category--large_width');
            return;
        }
        $(this).removeClass('search__configure_search_category--large_width');
    });
});
