define(['jquery', 'Config'], function ($, Config) {

'use strict';
var MAP = {
    init: function (selector) {
        var
        $map = $(selector),
        $items = $($map.data('source')).find('[data-latlng]'),
        map = this.embedMap(selector),
        bounds = [];
        $items.each(function () {
            var $self = $(this);
            if ($self.data('latlng') != "") {
                var
                point = eval('[' + $self.data('latlng') + ']'),
                marker = L.marker(point).addTo(map).bindPopup('<a href="'+$self.attr('href')+'">'+$self.text()+'</a>');
                $self.on('click', function (event) {
                    event.preventDefault();
                    marker.openPopup();
                    map.panTo(point);
                });
                bounds.push(point);
            }
        });

        // Workaround for a leaflet bug (https://github.com/Leaflet/Leaflet/issues/2021)
        window.setTimeout(function() {
            if (bounds.length > 0) {
                map.fitBounds(bounds);
            }
        }, 0);
    },

    adjustMapPosition : function () {
        if($('.projects-map-render').size()>0) {
            if ($('.projects-map-render').hasClass('leaflet-fullscreen-on')) {
                $('.projects-map-render').css('top', '0px');
            } else {
                $('.projects-map-render').css('top', $('#f1_container').position().top+$('#f1_container').height()+'px');
            }
            $('.result-container').css('top', $('#f1_container').position().top+$('#f1_container').height()+15+'px');
            $('.legendas').css('top', $('#f1_container').position().top+$('#f1_container').height()+15+'px');
        }
    },

    navigation : function (map) {

        $('body.projetos .filtrar-todas-as-metas select').on('change',function(e,o) {

            var el = $(this).find(':selected');
            var latLong = [el.data('gps-lat'), el.data('gps-long')];
            map.setView(latLong, 14);

        });


    },

    getURLParameter : function (name) {
        return decodeURI(
            (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
        );
    },

    embedMap : function (selector) {
        var url_sub = this.getURLParameter('subprefeitura');

        if (url_sub === "null") {
            var latLong = [-23.546628, -46.637787];
        } else {
            var el = $('body.projetos .filtrar-todas-as-metas select');
            el.val(url_sub);
            el = el.find(':selected');
            latLong = [el.data('gps-lat'), el.data('gps-long')];
        }

        var
            tiles = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                maxZoom: 16,
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors, Points &copy 2012 LINZ'
            }),
            map = L.map($(selector).get(0), {center: new L.latLng(latLong), zoom: 14, layers: [tiles]});
        return map;
    },

    stringToSlug : function(str) {
        str = str.replace(/^\s+|\s+$/g, ''); // trim
        str = str.toLowerCase();

        // remove accents, swap ñ for n, etc
        var from = "àáäâãèéëêìíïîòóöôùúüûñç·/_,:;";
        var to   = "aaaaaeeeeiiiioooouuuunc------";
        for (var i=0, l=from.length ; i<l ; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

        return str;
    },

    statusType : {
        'local-def' : 'Local definido',
        'local-em-def' : 'Local em definição',
        'abrange-sub' : 'Abrange a subprefeitura',
        'abrange-cidade' : 'Abrange toda a cidade'
    },

    plotProjects : function (selector) {
        var map = this.embedMap(selector);

        this.navigation(map);
        var hash = L.hash(map);
        var markers = L.markerClusterGroup({showCoverageOnHover:false, spiderfyOnMaxZoom: false, spiderfyDistanceMultiplier: 1.5});
        $.ajax({
            dataType: "jsonp",
            url: 'http://planejasampa.prefeitura.sp.gov.br/metas/api/projects.geojson',
            success: function (addressPoints) {
                // if (Config.isMapBoxEnabled) {

                // Since featureLayer is an asynchronous method, we use the `.on('ready'`
                // call to only use its marker data once we know it is actually loaded.
                var popup = L.popup({className: 'result-container', offset: new L.Point(120, -25)});

                for (var i = 0; i < addressPoints.features.length; i++) {
                    var a = addressPoints.features[i];
                    var gpsLat = a.geometry.coordinates[0];
                    var gpsLong = a.geometry.coordinates[1]

                    if (a.properties.location_type == 'abrange-cidade') {
                        var gpsLat = -23.546628;
                        var gpsLong = -46.637787;
                    } else if (a.properties.location_type == 'abrange-sub') {
                        var gpsLat = a.properties.prefectures[0].gps_lat;
                        var gpsLong = a.properties.prefectures[0].gps_long;
                    } else if (a.properties.location_type == 'local-def') {
                        //var gpsLat = a.geometry.prefecture;
                        //var gpsLong = a.geometry.prefecture;
                    } else if (a.properties.location_type == 'local-em-def') {
                        // var gpsLat = a.geometry.prefecture;
                        // var gpsLong = a.geometry.prefecture;
                    } else {
                        //
                    }


                    //if (a.properties['location-type'] == 'local-def') {
                    var title = a.properties.name;
                    var objectiveSlug = 'icon-projects_' + MAP.stringToSlug(a.properties.objective);
                    var marker = new L.marker(new L.LatLng(gpsLat, gpsLong), {
                            icon: new L.divIcon({
                                // Specify a class name we can refer to in CSS.
                                className: 'icon-marker '+a.properties.location_type,
                                // Define what HTML goes in each marker.
                                html: '<i class="' + objectiveSlug + '"></i>',
                                // Set a markers width and height.
                                iconSize: [76, 72]
                            }),
                            title: title,
                            properties: a.properties
                        });
                    marker.on('click', function (e) {
                        popup
                            .setLatLng(e.latlng)
                            .setContent(
                            '<p class="local">'+MAP.statusType[e.target.options.properties.location_type]+'</p>'+
                            '    <i id="project-icon" class="'+objectiveSlug+'"></i>'+
                            '    <div class="details">'+
                            '        <h1><a href="'+SITE_URL+'/projeto/'+e.target.options.properties.id+'">'+e.target.options.properties.name+'</a></h1>'+
                            '        <p class="secretaria">'+e.target.options.properties.secretary[0].name+'</p>'+
                            '        <p class="assunto">'+e.target.options.properties.objective+'</p>'+
                            '        <p class="endereco">'+e.target.options.properties.address+'</p>'+
                            '        <p class="meta"><a href="'+SITE_URL+'/meta/'+e.target.options.properties.goal_id+'">META '+e.target.options.properties.goal_id+'</a></p>'+
                            '    </div>')
                            .openOn(map);
                    });
                    markers.addLayer(marker);
                }

                markers.on('clusterclick', function (a) {
                    var clusterPoints = a.layer.getAllChildMarkers();
                    var popupContent =
                    '<p class="total-projetos bar-title">'+clusterPoints.length+' projetos</p>'+
                    '<div class="popup-box">';
                    var popupContentAbrangeCidade = '',
                        popupContentAbrangeSub = '';

                    for (var i = clusterPoints.length - 1; i >= 0; i--) {
                        var currentPoint = clusterPoints[i];
                        var localOptions = currentPoint.options.properties;
                        var objectiveSlug = 'icon-projects_' + MAP.stringToSlug(localOptions.objective);


                        if (localOptions.location_type == "abrange-cidade") {
                            popupContentAbrangeCidade +=
                            '    <div class="card-projeto">'+
                            '        <i id="project-icon" class="'+objectiveSlug+'"></i>'+
                            '        <div class="details">'+
                            '            <h1><a href="'+SITE_URL+'/projeto/'+localOptions.id+'">'+localOptions.name+'</a></h1>'+
                            '            <p class="secretaria">'+localOptions.secretary[0].name+'</p>'+
                            '            <p class="assunto">'+localOptions.objective+'</p>'+
                            '            <p class="meta"><a href="'+SITE_URL+'/meta/'+localOptions.goal_id+'">META '+localOptions.goal_id+'</a></p>'+
                            '        </div>'+
                            '    </div>';
                        }

                        if ((localOptions.location_type == "abrange-sub") || (localOptions.location_type == "local-em-def")){
                            popupContentAbrangeSub +=
                            '    <div class="card-projeto">'+
                            '        <i id="project-icon" class="'+objectiveSlug+'"></i>'+
                            '        <div class="details">'+
                            '            <h1><a href="'+SITE_URL+'/projeto/'+localOptions.id+'">'+localOptions.name+'</a></h1>'+
                            '            <p class="secretaria">'+localOptions.secretary[0].name+'</p>'+
                            '            <p class="assunto">'+localOptions.objective+'</p>'+
                            '            <p class="meta"><a href="'+SITE_URL+'/meta/'+localOptions.goal_id+'">META '+localOptions.goal_id+'</a></p>'+
                            '        </div>'+
                            '    </div>';
                        }
                    }

                    if (popupContentAbrangeCidade != "") {
                        popupContent += '    <p class="toda-cidade-projetos bar-title">abrange toda a cidade</p>';
                        popupContent += popupContentAbrangeCidade;
                    }
                    if (popupContentAbrangeSub != "") {
                        popupContent += '    <p class="subprefeitura-projetos bar-title">abrange a subprefeitura</p>';
                        popupContent += popupContentAbrangeSub;
                    }
                    popupContent += '</div>';


                    popup
                        .setLatLng(currentPoint._latlng)
                        .setContent(popupContent)
                        .openOn(map);
                });

                // you can also provide a full url to a TileJSON resource
                var subs = L.mapbox.tileLayer('lpirola.2bqyf1or');
                map.addLayer(subs);
                map.addLayer(markers);
            }
        });
    }
};

    return MAP;

});
