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

        _metaFollow = function (e,o) {

            var form = $(o).parents('.meta-follow'),
                name = form.find('input.name').val(),
                email = form.find('input.email').val(),
                meta = form.find('input.meta').val(),
                url = form.find('input.url').val();

            if (!name.length || !email.length || !meta.length) {
                alert('Verifique o preenchimento dos campos');
                return;
            }

            $.ajax({
                type: "POST",
                url: SITE_URL + '/metaFollow/' + meta,
                data: {'name':name, 'email':email}
            }).done(function(data){
                form.find('.box').html(data);
            });

            return false;

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

            $('.meta-follow input').on('keypress',function (e,o) {

                o = this;

                if (e.which == 13) {
                    e.preventDefault();
                    _metaFollow(e,o);
                }
            });
            $('.meta-follow .button').on('click',function (e,o) {
                o = this;
                _metaFollow(e,o);
            });

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
