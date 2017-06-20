/*----------------------------------------------------*/
/* Global Variables
 ------------------------------------------------------*/
var mobile_screen = 1001;


/* User Functions
 ------------------------------------------------------*/
function update_panel() {
    if ($(window).width() < mobile_screen) {
        $(".header_li_user a").text(user_nick);
        $('.header_li_room').prependTo('#nav');
        $('.header_li_tower').prependTo('#nav');
        $('.header_li_messages').prependTo('#nav');
        $('.header_li_user:not(.footer)').prependTo('#nav');
        $('.header_li_feedback').appendTo('#nav');
    } else {
        $(".header_li_user a").text(user_nick);
        $('.header_li_user').appendTo('#nav');
        $('.header_li_messages').appendTo('#nav');
        $('.header_li_room').appendTo('#nav');
    }
}
function update_header() {
    $("a:has(.messages_count:not(.empty):not(.room))").addClass("color_blue");
    $("a:has(.room.messages_count:not(.empty))").addClass("color_red");
}
(function ($) {


    update_header();//fix colors
    user_nick = $(".header_li_user a").text();
    update_panel();//if mobile
    $(window).resize(function () {
        update_panel();
    });


    /*----------------------------------------------------*/
    /* User jQuery Functions
     ------------------------------------------------------*/
    /*
     * USAGE:
     * $('.selector').switchPosition('.selector2');
     * */
    $.fn.switchPosition = function (selector) {
        var other = $(selector);
        this.after(other.clone());
        other.after(this).remove();
    };

    $('.header_li_messages a').mouseover(function(){
        $('.header_li_messages a span').css({color: '#fff'})
        $('.header_li_messages a').css({color: '#fff'})
    });

    $('.header_li_messages a').mouseout(function(){
        $('.header_li_messages a span').css({color: '#009dff'})
        $('.header_li_messages a').css({color: '#009dff'})
    });


    $('.header_li_room a').mouseover(function(){
        $('.header_li_room a span').css({color: '#fff'})
        $('.header_li_room a').css({color: '#fff'})
    });

    $('.header_li_room a').mouseout(function(){
        $('.header_li_room a span').css({color: '#f00'})
        $('.header_li_room a').css({color: '#f00'})
    });


    /*----------------------------------------------------*/
    /* Adjust Primary Navigation Background Opacity
     ------------------------------------------------------*/
    $(window).on('scroll', function () {

        var h = $('header').height();
        var y = $(window).scrollTop();
        var header = $('#header');

        if ((y > h + 30 ) && ($(window).outerWidth() > mobile_screen )) {
            header.addClass('opaque');
        }
        else {
            if (y < h + 30) {
                header.removeClass('opaque');
            }
            else {
                header.addClass('opaque');
            }
        }

    });


    /*----------------------------------------------------*/
    /* Highlight the current section in the navigation bar
     ------------------------------------------------------*/
    var sections = $("section"),
        navigation_links = $("#nav-wrap a");

    sections.waypoint({

        handler: function (direction) {

            var active_section;
            var current_section;
            active_section = $('section#' + this.element.id);

            if (direction === "up") active_section = active_section.prev();

            //console.log(active_section.attr("id"));
            if (active_section.attr("id") == "feedback")
                current_section = 'contact';
            else
                current_section = active_section.attr("id");

            var active_link = $('#nav-wrap a[href="#' + current_section + '"]');

            navigation_links.parent().removeClass("current");
            active_link.parent().addClass("current");

        },

        offset: '25%'

    });


    /*----------------------------------------------------*/
    /* FitText Settings
     ------------------------------------------------------ */
    setTimeout(function () {

        $('#main_slider-slider h1').fitText(1, {minFontSize: '30px', maxFontSize: '49px'});

    }, 100);


    /*-----------------------------------------------------*/
    /* Mobile Menu
     ------------------------------------------------------ */
    var menu_icon = $("<span class='menu-icon'>Menu</span>");
    var toggle_button = $("<a>", {
            id: "toggle-btn",
            html: "",
            title: "Menu",
            href: "#"
        }
    );
    var nav_wrap = $('nav#nav-wrap')
    var nav = $("ul#nav");

    /* if JS is enabled, remove the two a.mobile-btns
     and dynamically prepend a.toggle-btn to #nav-wrap */
    nav_wrap.find('a.mobile-btn').remove();
    toggle_button.append(menu_icon);
    nav_wrap.prepend(toggle_button);

    toggle_button.on("click", function (e) {
        e.preventDefault();
        nav.slideToggle("fast");
        menu_icon.hasClass('opened') ? menu_icon.removeClass('opened') : menu_icon.addClass('opened');
    });

    if (toggle_button.is(':visible')) nav.addClass('mobile');
    $(window).resize(function () {
        if (toggle_button.is(':visible')) nav.addClass('mobile');
        else nav.removeClass('mobile');
    });

    $('ul#nav li a').on("click", function () {
        if (nav.hasClass('mobile')) nav.fadeOut('fast');
    });

    /*----------------------------------------------------*/
    /*	Modal Popup
     ------------------------------------------------------*/
    $('.item-wrap a').magnificPopup({

        type: 'inline',
        fixedContentPos: false,
        removalDelay: 300,
        showCloseBtn: false,
        mainClass: 'mfp-fade'

    });

    $(document).on('click', '.popup-modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });


})(jQuery);
