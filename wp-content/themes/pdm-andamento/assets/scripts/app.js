define(['jquery', 'foundation'], function ($) {
    //Do setup work here

    'use strict';
    var docElem = document.documentElement,

        _animateHeader = function () {
            var shrinkHeader = $('.fixed.header').height();
            //var shrinkHeader2 = $('.fixed.header').height()+$('.filter-bar').height()-$('#f1_container').height();

            $('.filter-bar').css('margin-top', $('.header.fixed').height())

            $(window).scroll(function() {
                var scroll = getCurrentScroll();
                if ( scroll >= shrinkHeader ) {
                    $('.title-bar').addClass('shrink');
                } else {
                    $('.title-bar').removeClass('shrink');
                }

                // var o1 = $('#f1_container').offset();
                // var o2 = $('.fixed.header').offset();
                // var dx = o1.left - o2.left;
                // var dy = o1.top - o2.top;
                // var distance = Math.sqrt(dx * dx + dy * dy);

                // if ( $('.header.fixed').height() < distance ) {

                if ( scroll > $('.filter-bar').height()+$('.fixed.header').height()-$('#f1_container').height() ) {
                    $('#f1_container').addClass('shrink2');
                    $('#f1_container').css('top', $('.header.fixed').height());
                    $('.summary-results').css('margin-top', $('#f1_container .filtrar-todas-as-metas').height());
                } else {
                    $('#f1_container').css('top', 0);
                    $('#f1_container').removeClass('shrink2');
                    $('.summary-results').css('margin-top', 0);
                }
            });
        },

        getCurrentScroll = function () {
            return window.pageYOffset || document.documentElement.scrollTop;
        },
        _userAgentInit = function() {
            docElem.setAttribute('data-useragent', navigator.userAgent);
        },
        _events = function () {
            $(document).on('click', '.follow a', function (event) {
                event.preventDefault();
                $('.follow-form').fadeToggle();
            });
        },
        _init = function() {
            $(document).foundation();
            _userAgentInit();
            _events();
            _animateHeader();
        };

    return {
        init: _init
    };
});
