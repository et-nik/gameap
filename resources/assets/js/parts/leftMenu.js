function toggleLeftMenuScroll() {
    const topMenu = document.querySelector('#top-menu');
    const leftMenu = document.querySelector('#left-menu');
    const leftMenuCont = document.querySelector('#left-menu-content');

    if (leftMenuCont.offsetHeight + topMenu.offsetHeight > window.innerHeight) {
        leftMenu.classList.add('left-menu-scrolled');
    } else {
        leftMenu.classList.remove('left-menu-scrolled');
    }
}

function setMiniIconLeft() {
    const miniIcon = document.querySelector('#left-menu-mini-icon');

    miniIcon.classList.remove('fa-chevron-right');
    miniIcon.classList.add('fa-chevron-left');
}

function setMiniIconRight() {
    const miniIcon = document.querySelector('#left-menu-mini-icon');

    miniIcon.classList.remove('fa-chevron-left');
    miniIcon.classList.add('fa-chevron-right');
}

function setLogoMini() {
    const brandLink = document.querySelector('#brand-link');
    brandLink.classList.remove('navbar-brand');

    const brandLogo = document.querySelector('#brand-logo');
    brandLogo.setAttribute('src', '/images/gap_logo_white_mini.png');

    brandLogo.classList.add('logo-mini');
    brandLogo.classList.remove('logo');
}

function setLogoNormal() {
    const brandLink = document.querySelector('#brand-link');
    brandLink.classList.add('navbar-brand');

    const brandLogo = document.querySelector('#brand-logo');
    brandLogo.setAttribute('src', '/images/gap_logo_white.png');

    brandLogo.classList.remove('logo-mini');
    brandLogo.classList.add('logo');
}

function toggleMiniIcon() {
    const miniIcon = document.querySelector('#left-menu-mini-icon');

    if (miniIcon.classList.contains('fa-chevron-right')) {
        setMiniIconLeft();
    } else {
        setMiniIconRight();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleLeftMenuScroll();

    window.addEventListener('resize', function() {
        toggleLeftMenuScroll();
    });

    if (localStorage.getItem('leftMenuState') === 'small') {
        setMiniIconRight();
        setLogoMini();
    } else {
        setMiniIconLeft();
        setLogoNormal();
        document.querySelector('#main-section').classList.remove('small-menu');
    }

    document.addEventListener('click', function(event) {
        if (event.target.id === 'left-menu-mini-icon' || event.target.id === 'left-menu-mini-btn') {
            const mainSection = document.querySelector('#main-section');
            toggleMiniIcon();

            if (mainSection.classList.contains('small-menu')) {
                localStorage.setItem('leftMenuState', 'big');
                mainSection.classList.remove('small-menu');

                setLogoNormal();
            } else {
                localStorage.setItem('leftMenuState', 'small');
                mainSection.classList.add('small-menu');

                setLogoMini();
            }
        }
    });
});
