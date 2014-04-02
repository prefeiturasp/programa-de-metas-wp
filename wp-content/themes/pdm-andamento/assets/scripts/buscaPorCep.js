define(['jquery'], function ($, ignore) {

    'use strict';

    var buscaPorCep = {

        init : function () {
            //var json = {"status":"OK","results":[{"types":["postal_code"],"formatted_address":"Sobradinho, Brasília - DF, 73050-140, Brasil","address_components":[{"long_name":"73050-140","short_name":"73050-140","types":["postal_code"]},{"long_name":"Sobradinho","short_name":"Sobradinho","types":["sublocality","political"]},{"long_name":"Brasília","short_name":"Brasília","types":["locality","political"]},{"long_name":"Distrito Federal","short_name":"DF","types":["administrative_area_level_1","political"]},{"long_name":"Brasil","short_name":"BR","types":["country","political"]}],"geometry":{"location":{"lat":-15.6499302,"lng":-47.7810219},"location_type":"APPROXIMATE","viewport":{"southwest":{"lat":-15.6532916,"lng":-47.7842486},"northeast":{"lat":-15.6469963,"lng":-47.7779534}},"bounds":{"southwest":{"lat":-15.6524980,"lng":-47.7831935},"northeast":{"lat":-15.6477899,"lng":-47.7790085}}}}]};

            $('#input_cep').keypress(function (e) {


                if (e.which == 13) {
                    e.preventDefault();
                    $('#button_cep').trigger('click');
                }
            });

            $('#button_cep').on('click', function () {
                var json = $.ajax({url:"http://maps.google.com/maps/api/geocode/json?address="+input_cep.value+",são+paulo&sensor=false"})
                            .done(buscaPorCep.procuraSubPrefeitura)
            });
        },

        procuraSubPrefeitura : function (data) {
            $( data ).each(function( i, obj ){

                var latitude = obj.results[0].geometry.location.lat;
                var longitude = obj.results[0].geometry.location.lng;

                var json = $.ajax({url:SITE_URL + '/buscaPorCep/?lat='+latitude+'&long='+longitude})
                            .done(buscaPorCep.redirecionaParaSubPrefeitura);
            });
        },

        redirecionaParaSubPrefeitura : function (data) {
            window.location = SITE_URL + '/?subprefeitura=' + data + '#resultado';
        }

    };
    return buscaPorCep;

});
