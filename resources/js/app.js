import './bootstrap';

$(function() {
    $('.has-child a.sidebar__link').on("click", function(event) {
        event.preventDefault();
        $(this).siblings('.siderbar__submenu').slideToggle();
        $(this).siblings('.arrow').toggleClass('up-arrow')
    });
});