define(['jquery', 'list', 'foundation'], function ($,List) {
    //Do setup work here

    'use strict';
    var docElem = document.documentElement,

        _animateHeader = function () {
            var shrinkHeader2 = $('.fixed.header').height()+$('.filter-bar').height()-$('#f1_container').height();

            $('.filter-bar').css('padding-top', $('.header.fixed').height())

            $(window).scroll(_onScroll);
        },

        _onScroll = function () {
            var shrinkHeader = $('.fixed.header').height(),
                scroll = getCurrentScroll(),
                bottom = getFullHeight();

            if (scroll >= (bottom-100)) {
                $('.filter-bar, #filter-options').css('visibility','hidden')
            } else {
                $('.filter-bar, #filter-options').css('visibility','visible')
            }

            if ( scroll >= shrinkHeader) {
                $('.title-bar').addClass('shrink');
            } else {
                $('.title-bar').removeClass('shrink');
            }

            if ( scroll > $('.filter-bar').height()+$('.fixed.header').height()-$('#f1_container').height() || scroll >= (bottom-100)) {
                $('#f1_container').addClass('shrink2');
                $('#f1_container').css('top', $('.header.fixed').height());
                //$('.summary-results').css('margin-top', $('#f1_container').height()+40);
            } else {
                $('#f1_container').css('top', 0);
                $('#f1_container').removeClass('shrink2');
                //$('.summary-results').css('margin-top', 0);
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
        _metaFilter = function () {

            var options = {valueNames: [ 'project', 'subprefecture', 'status' ] };
            var projectsList = new List('list-filter',options);

            $('#list-filter select').on('change',function(){
                $('#list-filter select').not(this).val('');
                projectsList.search(this.value);

                $('#list-filter select').removeClass('active');
                if (this.value.length) $(this).addClass('active');

                // if (!$('#list-projects li:visible').length) {

                // }
            })

            // projectsList.on('search',function(){
            //     console.log('oioioi');
            // })

        },
        openSelect = function(selector){
             var element = $(selector)[0], worked = false;
            if (document.createEvent) { // all browsers
                var e = document.createEvent("MouseEvents");
                e.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
                worked = element.dispatchEvent(e);
            } else if (element.fireEvent) { // ie
                worked = element.fireEvent("onmousedown");
            }
            if (!worked) { // unknown browser / error
                alert("It didn't worked in your browser.");
            }
        },
        getFullHeight = function () {
            return $(document).height() - $(window).height();
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

            $('.topo a','#footer').on('click',function(){
                var body = $("html, body");
                body.animate({scrollTop:0}, 2000, 'swing');
            })

            $('.clear-form').on('click',function(){
                window.location = SITE_URL + '/#resultado';
            })

            $(function () {
                $('#js-news').ticker({
                    titleText: 'Últimas notícias'
                });
            });

            $('.advanced-toggle').on('click',function(){
                $('#f1_container').toggleClass('advanced');
            })

            $('body.projetos .filtrar-todas-as-metas select').on({

                mouseenter :  function() {
                    openSelect(this);
                    // var count = $(this).children().length;
                    // $(this).attr('size', count);
                },
                mouseleave : function() {
                    // $(this).removeAttr('size');
                }

            });


            // $('button','.mobile-disclaimer').on('click', function (event) {
            //     $('.mobile-disclaimer').hide();
            // });
        },
        _init = function() {
            $(document).ready(function () {
                $(document).foundation();
            });

            _userAgentInit();

            //$('html,body').scrollTop(0);

            _events();
            _animateHeader();

            if (matchMedia(Foundation.media_queries.small).matches) {
                return false;
            }

            if (document.body.className.indexOf('meta') > -1) {
                _metaFilter();
            }

            _onScroll();

        };

    return {
        init: _init
    };
});




