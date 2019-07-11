$(".show-hide-password").on('click',function() {
    var $pwd = $(".password");
    if ($pwd.attr('type') === 'password') {
        $pwd.attr('type', 'text');
        $('.show-hide-password i').addClass( "fa-eye-slash" );
        $('.show-hide-password i').removeClass( "fa-eye" );
    } else {
        $pwd.attr('type', 'password');
        $('.show-hide-password i').addClass( "fa-eye" );
        $('.show-hide-password i').removeClass( "fa-eye-slash" );
    }
});