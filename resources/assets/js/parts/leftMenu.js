
$(function() {

    if(localStorage.getItem('leftMenuState') === 'small'){
        $('.left-menu [data-toggle="tooltip"]').tooltip('enable');
    }else{
        $('#main-section').removeClass('small-menu');
    }

    $(document).on('click', '#left-menu-mini-btn', function () {
        $mainsection = $('#main-section');
        if($mainsection.hasClass('small-menu')){
            $mainsection.removeClass('small-menu');
            $('.left-menu [data-toggle="tooltip"]').tooltip('disable');
            localStorage.setItem('leftMenuState', 'big');
        }else{
            $mainsection.addClass('small-menu');
            $('.left-menu [data-toggle="tooltip"]').tooltip('enable');
            localStorage.setItem('leftMenuState', 'small');
        }
    });

});
