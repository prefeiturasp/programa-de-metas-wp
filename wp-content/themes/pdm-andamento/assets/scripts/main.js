require.config({
    paths: {
        jquery: '../bower_components/jquery/dist/jquery',
        d3: '../bower_components/d3js/build/d3.v3',
        //leaflet: '../bower_components/leaflet/src/Leaflet',
        leaflet: "//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.2/leaflet",
        foundation: '../bower_components/foundation/js/foundation'
    },
    shim: {
        d3: {
            exports: 'd3'
        },
        jQuery: {
            exports: 'jquery'
        },
        foundation: {
            deps: ['jquery']
        }
    }
});

require(['chart', 'map', 'app', 'jquery'], function (chart, map, app, $) {
    'use strict';
    // use app here
    app.init();

    // startup map
    $('.map-render').each(function () {
        map.init(this);
    });

    // startup chart
    $('.chart-render').each(function () {
        var data = $(this).data('chart');
        switch (data.type) {
           case 'pie':
              switch (data.size) {
                  case 'small':
                      chart.pieSmall(this, data.values);
                      break;
                  case 'large':
                      chart.pieLarge(this, data.values);
                      break;
              }
              break;
           case 'line':
              chart.line(this, data.values[0], data.values[1]);
              break;
        }
    });

    jQuery('form[name="projetos-por-perto"] input[name="cep"]');

    jQuery('form[name="projetos-por-perto"] select#subprefeitura-topo').on('change', function (evt) {
      window.location = SITE_URL + '/?subprefeitura=' + jQuery(evt.currentTarget).val();
    });


    jQuery('form[name="projetos-relacionados"] select#projetos-topo').on('change', function (evt) {
      window.location = SITE_URL + '/projeto/' + jQuery(evt.currentTarget).val();
    });

    //.filtrar-todas-as-metas.button
});
