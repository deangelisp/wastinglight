jQuery(document).ready(function(jQuery) {
    
    //MENU HEADER
    function menu_header_scroll(){
        var sticky = jQuery('#main-header'),
            scroll = jQuery(window).scrollTop();

        if (scroll >= 260) sticky.addClass('fixed');
        else sticky.removeClass('fixed');
    }

    menu_header_scroll();

    jQuery(window).scroll(menu_header_scroll);
    
    //SCROLLS
    var down = jQuery('#scroll-to-top');
    var up = jQuery('#scroll-to-down');

    jQuery(window).scroll(function() {
        if (jQuery(window).scrollTop() > 600) {
            down.fadeIn();
        } else {
            down.fadeOut();
        }
    });

    down.on('click', function(e) {
        e.preventDefault();
        jQuery('html, body').animate({scrollTop:0}, '300');
    });

    up.on('click', function(e) {
        e.preventDefault();
        jQuery('html, body').animate({scrollTop: jQuery(window).height()}, '300');
    });
});