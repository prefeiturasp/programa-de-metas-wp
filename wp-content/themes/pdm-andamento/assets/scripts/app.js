define(['jquery', 'foundation'], function ($) {
    //Do setup work here

    'use strict';
    var docElem = document.documentElement,

        _animateHeader = function () {
            //var shrinkHeader2 = $('.fixed.header').height()+$('.filter-bar').height()-$('#f1_container').height();

            $('.filter-bar').css('margin-top', $('.header.fixed').height())

            $(window).scroll(_onScroll);
        },

        _onScroll = function () {
            var shrinkHeader = $('.fixed.header').height(),
                scroll = getCurrentScroll();
            if ( scroll >= shrinkHeader ) {
                $('.title-bar').addClass('shrink');
            } else {
                $('.title-bar').removeClass('shrink');
            }

            if ( scroll > $('.filter-bar').height()+$('.fixed.header').height()-$('#f1_container').height() ) {
                $('#f1_container').addClass('shrink2');
                $('#f1_container').css('top', $('.header.fixed').height());
                $('.summary-results').css('margin-top', $('#f1_container').height()+40);
            } else {
                $('#f1_container').css('top', 0);
                $('#f1_container').removeClass('shrink2');
                $('.summary-results').css('margin-top', 0);
            }
        },

        // _metaFollow = function () {


        //     $.post


            
        // },

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

            $('.meta-follow form').on('submit',_metaFollow)

            // $('button','.mobile-disclaimer').on('click', function (event) {
            //     $('.mobile-disclaimer').hide();
            // });
        },
        _init = function() {
            $(document).foundation();
            _userAgentInit();
            _events();
            _onScroll();
            _animateHeader();
        };

    return {
        init: _init
    };
});
