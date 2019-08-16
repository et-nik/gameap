function toggleLeftMenuScroll(){
    var topMenu = $('#top-menu');
    var leftMenu = $('#left-menu');
    var leftMenuCont = $('#left-menu-content');
    if(leftMenuCont.outerHeight() + topMenu.outerHeight() > window.innerHeight){
        leftMenu.addClass('left-menu-scrolled');
    }else{
        leftMenu.removeClass('left-menu-scrolled');
    }
}

$(function() {

    toggleLeftMenuScroll();
    $(window).resize(function() {
        toggleLeftMenuScroll();
    });

    if(localStorage.getItem('leftMenuState') === 'small'){
        $('.left-menu [data-toggle="tooltip"]').tooltip('enable');
    }else{
        $('#main-section').removeClass('small-menu');
    }

    $(document).on('click', '#left-menu-mini-btn', function () {
        $mainsection = $('#main-section');
        if($mainsection.hasClass('small-menu')){
            localStorage.setItem('leftMenuState', 'big');
            $('.left-menu [data-toggle="tooltip"]').tooltip('disable');
            $mainsection.removeClass('small-menu');
        }else{
            localStorage.setItem('leftMenuState', 'small');
            $('.left-menu [data-toggle="tooltip"]').tooltip('enable');
            $mainsection.addClass('small-menu');

        }
    });

});
