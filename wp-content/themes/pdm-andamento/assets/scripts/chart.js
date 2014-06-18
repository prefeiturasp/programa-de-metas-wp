define(['jquery', 'd3'], function ($, d3) {

    'use strict';
    var

    // _months = [
    //     'Janeiro',
    //     'Fevereiro',
    //     'Março',
    //     'Abril',
    //     'Maio',
    //     'Junho',
    //     'Julho',
    //     'Agosto',
    //     'Setembro',
    //     'Outubro',
    //     'Novembro',
    //     'Dezembro'
    // ],

    // Pie chart
    _pie = function _pie(selector, data, config) {
        var
        w = config.width,
        h = config.height,
        r = config.radius,
        s = config.stroke,
        color = config.color;

        var vis = d3.select(selector)
            .append('svg:svg')
            .attr('class', 'chart-pie')
            .attr('viewBox', '0 0 ' + w + ' ' + h)
            .attr('preserveAspectRatio', 'xMinYMin meet')
            .data([data])
                .attr('width', w)
                .attr('height', h)
            .append('svg:g')
                .attr('transform', 'translate(' + r + ',' + r + ')');

        var arc = d3.svg.arc()
            .outerRadius(r);

        var pie = d3.layout.pie()
            .sort(null)
            .value(function(d) { return d; });

        var arcs = vis.selectAll('g.slice')
            .data(pie)
            .enter()
                .append('svg:g')
                    .attr('class', 'slice');

        arcs.append('svg:path')
            .attr('fill', function(d, i) { return color(i); } )
            .attr('class', function(d, i) { return color(i) === '#ccc' ? 'colored' : ''; } )
            .attr('d', arc);

        d3.select(selector).select('svg')
            .append('circle')
                .attr('r', r - (s / 2))
                .attr('stroke-width', s)
                .attr('transform', 'translate(' + r + ',' + r + ')')
                .attr('fill', 'transparent');
    },

    // Large pie chart
    _pieLarge = function _pieLarge(selector, data) {
        var config = {
            width : 226,
            height : 226,
            radius : 113,
            stroke : 3,
            color : d3.scale.ordinal().range(['#ccc', '#ffffff']) // Green, white
        };
        _pie(selector, data, config);
    },

    // Small pie chart
    _pieSmall = function _pieSmall(selector, data) {
        var config = {
            width : 72,
            height : 72,
            radius : 36,
            stroke : 2,
            color : d3.scale.ordinal().range(['#ccc', '#dee0e1', '#ffffff']) // Green, gray, white
        };
        _pie(selector, data, config);
    },


    // Line chart
    _line = function _line(selector, labels, dataA) {
        var
        m = 40,
        w = 900,
        h = 200 - m,
        max_value = 0;

        $(dataA).each(function(k,v){
            if (v >max_value) {
                max_value = v;
            }
        });

        var x = d3.scale.ordinal().domain(labels).rangeRoundBands([0, w]);
        var y = d3.scale.linear().domain([0, max_value*1.2]).range([h, 0]);

        var line = d3.svg.line()
            .x(function(d, i) { return x(labels[i]); })
            .y(function(d) { return y(d); });

        $(selector).html('');

        var graph = d3.select(selector).append('svg:svg')
                .attr('class', 'chart-line')
                .attr('width', w)
                .attr('height', h + m)
                .attr('viewBox', '0 0 ' + w + ' ' + (h + m))
                .attr('preserveAspectRatio', 'xMinYMin meet')
            .append('svg:g')
                .attr('transform', 'translate(40,0)');

        var xAxis = d3.svg.axis().scale(x).orient('bottom');
        graph.append('svg:g')
            .attr('class', 'axis axis-x')
            .attr('transform', 'translate(-40,' + (h + 15) + ')')
            .call(xAxis);

        var _draw = function _draw(classNameSufix, data) {
            graph.append('svg:path')
                .attr('d', line(data))
                .attr('class', 'line line-' + classNameSufix);

            var dot = graph.selectAll('dot')
                    .data(data)
                .enter().append('g')
                    .attr('class', 'dot dot-' + classNameSufix);

            dot.append('circle')
                .attr('r', function (d,i) { if (d != 0) { return 25; } else { return 0; } })
                .attr('cx', function(d, i) { return x(labels[i]); })
                .attr('cy', function(d) { return y(d); });

                // .on('mouseover', function() {
                //     d3.select(this).transition().attr('r', 20);
                //     d3.select(this.parentNode).select('text').transition().style('opacity', 1);
                // })
                // .on('mouseout', function() {
                //     d3.select(this).transition().attr('r', 5);
                //     d3.select(this.parentNode).select('text').transition().style('opacity', 0);
                // });

            dot.append('text')
                .attr('transform', function(d, i) { return 'translate(' + x(labels[i]) + ',' + (y(d) + 4) + ')'; })
                .attr('pointer-events', 'none')
                .text(function(d) { return d; })
                .style('text-anchor', 'middle')
                .style('opacity', 1)
                .attr('fill', 'white');
        };

        _draw('a', dataA);
        //_draw('b', dataB);
    };

    return {
        pieSmall: _pieSmall,
        pieLarge: _pieLarge,
        line: _line
    };

});
