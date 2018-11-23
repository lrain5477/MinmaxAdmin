/***** AmCharts *****/
/* google analytics 年齡層*/
var chart = AmCharts.makeChart("analyticsAge", {
    "theme": "light",
    "type": "serial",
    "theme": "light",
    "dataLoader": {
        "url": "data/demo-order-total.json",
        "format": "json",
        "showErrors": true,
        "noStyles": true,
        "async": true,

    },

    "valueAxes": [{
        "gridColor": "#878787",
        "gridAlpha": 0.2,
        "dashLength": 0,
        "color": "#878787"
    }],
    "gridAboveGraphs": true,
    "startDuration": 1,
    "graphs": [{
        "balloonText": "[[category]]: <b>[[value]]</b>",
        "fillAlphas": 0.8,
        "lineAlpha": 0.2,
        "type": "column",
        "valueField": "visits",
        "color": "#878787"
    }],
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    },
    "categoryField": "age",
    "categoryAxis": {
        "gridPosition": "start",
        "gridAlpha": 0,
        "tickPosition": "start",
        "tickLength": 20,
        "color": "#878787"
    },
    "export": {
        "enabled": false
    }
});