define(['jquery', 'leaflet', 'leaflet.ajax', 'leaflet.markercluster'], function ($, L) {

    'use strict';
    var
    _init = function _init(selector) {
        var
        $map = $(selector),
        $items = $($map.data('source')).find('[data-latlng]'),
        map = L.map($map.get(0)).setView([-23.5475, -46.63611111], 10),
        bounds = [];
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);
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

    _plotProjects = function mapProjects(selector) {
        var tiles = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            maxZoom: 16,
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors, Points &copy 2012 LINZ'
        }),
        latlng = L.latLng(-23.546628, -46.637787);

        if (this.isMapBoxEnabled) {

        } else {
            var map = L.map($(selector).get(0), {center: latlng, zoom: 13, layers: [tiles]});
        }


        var markers = L.markerClusterGroup();
        $.ajax({
          dataType: "jsonp",
          url: 'http://planejasampa.prefeitura.sp.gov.br/metas-qa/api/projects.geojson',
            success: function (addressPoints) {
                for (var i = 0; i < addressPoints.features.length; i++) {
                    var a = addressPoints.features[i];
                    if (a.properties['location-type'] == 'local-def') {
                        var title = a.properties.name;
                        var marker = L.marker(new L.LatLng(a.geometry.coordinates[0], a.geometry.coordinates[1]), { title: title });

                        marker.bindPopup(title);
                        markers.addLayer(marker);
                    } else {

                    }
                }
                /*L.geoJson(addressPoints, {
                    style: function(feature) {
                        switch (feature.properties.party) {
                            case 'Republican': return {color: "#ff0000"};
                            case 'Democrat':   return {color: "#0000ff"};
                        }
                    }
                }).addTo(map);*/
            }
        });
        map.addLayer(markers);
    };

    return {
        init: _init,
        plotProjects: _plotProjects
    };

});
