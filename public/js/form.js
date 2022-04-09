$(function(){
    $('.form__sub_label.form__sub_label--show_hide').each(function(index){
        let isShow = false;
        $(this).click(function(){
            isShow = !isShow;
            let inputId = $(this).prev().attr('for');
            let inputJEle = $('#'+inputId);
            if(isShow){
                $(this).html('<i class="fa-solid fa-eye-slash"></i>Hide');
                inputJEle.attr('type','text');
                return;
            }
            $(this).html('<i class="fa-solid fa-eye"></i>Show');
            inputJEle.attr('type','password');
        });
    });
});
