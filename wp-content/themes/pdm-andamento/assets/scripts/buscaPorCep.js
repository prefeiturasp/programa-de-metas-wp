define(['jquery'], function ($, ignore) {

    'use strict';

    var buscaPorCep = {

        mask : function (inputName, mask, evt) {
            try {
              var text = document.getElementById(inputName);
              var value = text.value;

                // If user pressed DEL or BACK SPACE, clean the value
                try {
                    var e = (evt.which) ? evt.which : event.keyCode;
                    if ( e == 46 || e == 8 ) {
                        text.value = "";
                        return;
                    }
                } catch (e1) {}

                var literalPattern=/[0\*]/;
                var numberPattern=/[0-9]/;
                var newValue = "";

                for (var vId = 0, mId = 0 ; mId < mask.length ; ) {
                    if (mId >= value.length)
                      break;

                    // Number expected but got a different value, store only the valid portion
                    if (mask[mId] == '0' && value[vId].match(numberPattern) == null) {
                      break;
                    }

                    // Found a literal
                    while (mask[mId].match(literalPattern) == null) {
                      if (value[vId] == mask[mId])
                        break;

                    newValue += mask[mId++];
                    }

                    newValue += value[vId++];
                    mId++;
                }
            text.value = newValue;
            } catch(e) {}
        },

        init : function () {
            //var json = {"status":"OK","results":[{"types":["postal_code"],"formatted_address":"Sobradinho, Brasília - DF, 73050-140, Brasil","address_components":[{"long_name":"73050-140","short_name":"73050-140","types":["postal_code"]},{"long_name":"Sobradinho","short_name":"Sobradinho","types":["sublocality","political"]},{"long_name":"Brasília","short_name":"Brasília","types":["locality","political"]},{"long_name":"Distrito Federal","short_name":"DF","types":["administrative_area_level_1","political"]},{"long_name":"Brasil","short_name":"BR","types":["country","political"]}],"geometry":{"location":{"lat":-15.6499302,"lng":-47.7810219},"location_type":"APPROXIMATE","viewport":{"southwest":{"lat":-15.6532916,"lng":-47.7842486},"northeast":{"lat":-15.6469963,"lng":-47.7779534}},"bounds":{"southwest":{"lat":-15.6524980,"lng":-47.7831935},"northeast":{"lat":-15.6477899,"lng":-47.7790085}}}}]};

            $('#input_cep').keyup(function (evt) {
                return buscaPorCep.mask('input_cep', '00000-000', evt);
            });

            $('#input_cep').keypress(function (e) {


                if (e.which == 13) {
                    e.preventDefault();
                    $('#button_cep').trigger('click');
                }
            });

            $('#button_cep').on('click', function () {
                $('#button_cep').html('Carregando...');
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
            $('#button_cep').html('Procurar');
            window.location = SITE_URL + '/projetos/?subprefeitura=' + data;
        }

    };
    return buscaPorCep;

});
