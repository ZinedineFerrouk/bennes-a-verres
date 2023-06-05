// Variables
var hamburger = document.querySelector('#js_hamburger');
var reponsiveList = document.querySelector('#js_reponsive-list');
var overlay = document.querySelector('#js_overlay');
var body = document.body;
var hasSubmenuLink = document.querySelectorAll('.has-submenu > a');

// Open menu
function openMenu() {
    hamburger.classList.add('is-active');
    reponsiveList.setAttribute('aria-expanded', 'true');
    overlay.setAttribute('aria-hidden', 'false');
    body.style.overflow = 'hidden';
    // ScrollTop for Safari
    body.scrollTop = 0;
    // ScrollTop for Chrome, Firefox, Edge and Other...
    document.documentElement.scrollTop = 0;
}
// Close menu
function closeMenu() {
    hamburger.classList.remove('is-active');
    reponsiveList.setAttribute('aria-expanded', 'false');
    overlay.setAttribute('aria-hidden', 'true');
    body.style.overflow = 'auto';
}
// If I click on hamburger button, toggle menu
hamburger.addEventListener('click', function(e) {
    if(reponsiveList.getAttribute('aria-expanded') == 'false') {
        openMenu();
    } else {
        closeMenu();
    }
});

hasSubmenuLink.forEach(function(item) {
    item.addEventListener('click', function(e) {
        e.preventDefault();
    });
});