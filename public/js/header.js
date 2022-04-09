$(function(){
    let headerOptionsMenuOpen = false;
    let headerOptionsExpandClass = 'header__options--expand_big';
    function closeHeaderOptionsMenu(iconEle){
        $(iconEle).removeClass('fa-caret-up');
        $(iconEle).addClass('fa-caret-down');
        gsap.to('.header__options', {duration: 0.25, height: '0px', onComplete: function(){
            $('.header__options').css('height', '');
            $('.header__options').removeClass(headerOptionsExpandClass);
        }});
    }
    $('#open_header_submenu').click(function(){
        headerOptionsMenuOpen = !headerOptionsMenuOpen;
        let iconEle = $(this).children('i')[0];
        if(headerOptionsMenuOpen){
            $(iconEle).removeClass('fa-caret-down');
            $(iconEle).addClass('fa-caret-up');
            let headerOptionsHeight = '170px';
            if($('.header__options').hasClass('header__options--no_auth')){
                headerOptionsHeight = '120px';
                headerOptionsExpandClass = 'header__options--expand_small';
            }
            gsap.to('.header__options', {duration: 0.25, height: headerOptionsHeight, onComplete: function(){
                $('.header__options').css('height', '');
                $('.header__options').addClass(headerOptionsExpandClass);
            }});
            return;
        }
        closeHeaderOptionsMenu(iconEle);
    });
    $('.header__options i.fa-solid').click(function(){
        headerOptionsMenuOpen = false;
        closeHeaderOptionsMenu($('#open_header_submenu').children('i')[0]);
    });
});
