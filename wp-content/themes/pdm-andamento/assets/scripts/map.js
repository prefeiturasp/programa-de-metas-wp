define(['jquery', 'leaflet'], function ($, L) {

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

    };

    return {
        init: _init
    };

});
