function toggleLeftMenuScroll() {
    const topMenu = $('#top-menu');
    const leftMenu = $('#left-menu');
    const leftMenuCont = $('#left-menu-content');

    if (leftMenuCont.outerHeight() + topMenu.outerHeight() > window.innerHeight) {
        leftMenu.addClass('left-menu-scrolled');
    } else {
        leftMenu.removeClass('left-menu-scrolled');
    }
}

function setMiniIconLeft() {
    const $miniIcon = $('#left-menu-mini-icon');

    $miniIcon.removeClass('fa-chevron-right');
    $miniIcon.addClass('fa-chevron-left');
}

function setMiniIconRight() {
    const $miniIcon = $('#left-menu-mini-icon');

    $miniIcon.removeClass('fa-chevron-left');
    $miniIcon.addClass('fa-chevron-right');
}

function setLogoMini() {
    $('#brand-link').removeClass('navbar-brand');

    const $brandLogo = $('#brand-logo');
    $brandLogo.attr('src', '/images/gap_logo_white_mini.png');

    $brandLogo.addClass('logo-mini');
    $brandLogo.removeClass('logo');
}

function setLogoNormal() {
    $('#brand-link').addClass('navbar-brand');

    const $brandLogo = $('#brand-logo');
    $brandLogo.attr('src', '/images/gap_logo_white.png');

    $brandLogo.removeClass('logo-mini');
    $brandLogo.addClass('logo');
}

function toggleMiniIcon() {
    const $miniIcon = $('#left-menu-mini-icon');

    if ($miniIcon.hasClass('fa-chevron-right')) {
        setMiniIconLeft();
    } else {
        setMiniIconRight();
    }
}

$(function() {
    const TOOLTIP_SHOW_DELAY = 1000;
    const TOOLTIP_HIDE_DELAY = 100;

    toggleLeftMenuScroll();

    $(window).resize(function() {
        toggleLeftMenuScroll();
    });

    const $leftMenuTooltip = $('.left-menu [data-toggle="tooltip"]');
    $leftMenuTooltip.data('delay', { "show": TOOLTIP_SHOW_DELAY, "hide": TOOLTIP_HIDE_DELAY });

    if (localStorage.getItem('leftMenuState') === 'small') {
        setMiniIconRight();
        setLogoMini();
        $leftMenuTooltip.tooltip('enable');
    } else {
        setMiniIconLeft();
        setLogoNormal();
        $('#main-section').removeClass('small-menu');
    }

    $(document).on('click', '#left-menu-mini-btn', function () {
        $mainSection = $('#main-section');
        toggleMiniIcon();

        if ($mainSection.hasClass('small-menu')) {
            localStorage.setItem('leftMenuState', 'big');
            $leftMenuTooltip.tooltip('disable');
            $mainSection.removeClass('small-menu');

            setLogoNormal();
        } else {
            localStorage.setItem('leftMenuState', 'small');
            $leftMenuTooltip.tooltip('enable');
            $mainSection.addClass('small-menu');

            setLogoMini();
        }
    });
});