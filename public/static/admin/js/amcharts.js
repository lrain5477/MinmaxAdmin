/*--------------------------------------------
            訂單統計
---------------------------------------------*/
var chart1 = AmCharts.makeChart("orderTotal", {
    "type": "serial",
    "theme": "light",
    "titles": [{
        "text": "訂單統計",
        "bold": true,
        "size": 20,
      }],
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
        "balloonText": "銷售總額: <b>[[value]]</b>",
        "fillAlphas": 0.8,
        "lineAlpha": 0.2,
        "type": "column",
        "valueField": "orderTotla",
        "columnWidth":0.5,
        "color": "#878787"
    },{
        "balloonText": "退貨總額: <b>[[value]]</b>",
        "fillAlphas": 0.8,
        "lineAlpha": 0.2,
        "type": "column",
        "valueField": "returnTotla",
        "columnWidth":0.5,
        "clustered":false,
        "color": "#000"
    }],
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    },
    "categoryField": "month",
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
/*--------------------------------------------
           訂單評價
---------------------------------------------*/
var chart3 = AmCharts.makeChart("statisticsReview", {
    "type": "serial",
    "theme": "light",
    "titles": [{
        "text": "訂單評價",
        "bold": true,
        "size": 20,
    }],
    "autoMarginOffset": 20,
    "dataDateFormat": "YYYY-MM-DD",
    "valueAxes": [{
        "id": "v1",
        "axisAlpha": 0,
    }],
    "graphs": [{
        "id": "g1",
        "balloon":{
            "drop":true,
            "adjustBorderColor":false,
            "color":"#ffffff"
        },
        "bullet": "round",
        "bulletBorderAlpha": 1,
        "bulletColor": "#FFFFFF",
        "bulletSize": 5,
        "hideBulletsCount": 50,
        "lineThickness": 2,
        "title": "red line",
        "useLineColorForBulletBorder": true,
        "valueField": "value",
        "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
    }],
    "chartCursor": {
        "pan": true,
        "valueLineEnabled": true,
        "valueLineBalloonEnabled": true,
        "cursorAlpha":1,
        "cursorColor":"#258cbb",
        "limitToGraph":"g1",
        "valueLineAlpha":0.2,

    },
    "categoryField": "date",
    "categoryAxis": {
        "parseDates": true,
        "dashLength": 1,
        "minorGridEnabled": true
    },
    "dataLoader": {
        "url": "data/demo-order-review.json",
        "format": "json",
        "showErrors": true,
        "noStyles": true,
        "async": true,
    }
});
/*--------------------------------------------
            客服統計
---------------------------------------------*/
var chart = AmCharts.makeChart("statisticsContact", {
    "type": "serial",
    "theme": "light",
    "titles": [{
        "text": "客服統計",
        "bold": true,
        "size": 20,
    }],
    "dataLoader": {
        "url": "data/demo-statistics-contact.json",
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
        "balloonText": "訂單詢問: <b>[[value]]</b>",
        "fillAlphas": 0.8,
        "lineAlpha": 0.2,
        "type": "column",
        "valueField": "orderTotla",
        "columnWidth":0.5,
        "color": "#878787"
    },{
        "balloonText": "客服詢問: <b>[[value]]</b>",
        "fillAlphas": 0.8,
        "lineAlpha": 0.2,
        "type": "column",
        "valueField": "serviceTotla",
        "columnWidth":0.5,
        "clustered":false,
        "color": "#000"
    }],
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    },
    "categoryField": "month",
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
// /*--------------------------------------------
//              產品類別銷售表
//  ---------------------------------------------*/
// var chart2 = AmCharts.makeChart("productCategoryTotal", {
//     "theme": "light",
//     "type": "serial",
//     "startDuration": 2,
//     "titles": [{
//         "text": "產品別銷售量分析",
//         "bold": true,
//         "size": 20,
//     }],
//     "dataLoader": {
//         "url": "data/productCategoryTotal.json",
//         "format": "json",
//         "showErrors": true,
//         "noStyles": true,
//         "async": true,
//     },
//     "valueAxes": [{
//         "position": "left",
//         "title": "銷售量"
//     }],
//     "graphs": [{
//         "balloonText": "[[category]]: <b>[[value]]</b>",
//         "fillColorsField": "color",
//         "fillAlphas": 0.5,
//         "lineAlpha": 0.1,
//         "type": "column",
//         "valueField": "sales",
//         "labelText": "[[value]]",
//     }],
//     "depth3D": 20,
//     "angle": 30,
//     "chartCursor": {
//         "categoryBalloonEnabled": false,
//         "cursorAlpha": 0,
//         "zoomable": false
//     },
//     "categoryField": "category",
//     "categoryAxis": {
//         "gridPosition": "start",
//         "labelRotation": 0
//     },
//     "export": {
//         "enabled": true
//     }
// });


/*--------------------------------------------
           訂單評價
---------------------------------------------*/
var chart4 = AmCharts.makeChart("statisticsNewMembers", {
    "type": "serial",
    "theme": "light",
    "titles": [{
        "text": "當年度新會員/首購統計",
        "bold": true,
        "size": 20,
    }],
    "autoMarginOffset": 20,
    "dataDateFormat": "YYYY-MM-DD",
    "valueAxes": [{
        "id": "v1",
        "axisAlpha": 0,
    }],
    "graphs": [{
        "balloonText": "新增：[[value]]",
        "bullet": "round",
        "bulletBorderAlpha": 1,
        "useLineColorForBulletBorder": true,
        "bulletColor": "#FFFFFF",
        "bulletSizeField": "townSize",
        "dashLengthField": "dashLength",
        "descriptionField": "townName",
        "labelPosition": "right",
        "labelText": "[[townName2]]",
        "legendValueText": "新增：[[value]]",
        "title": "latitude/city",
        "fillAlphas": 0,
        "valueField": "orderTotla",
        "valueAxis": "latitudeAxis"
    },{
        "id": "g2",
        "balloonText": "首購：[[value]]",
        "bullet": "round",
        "bulletBorderAlpha": 1,
        "useLineColorForBulletBorder": true,
        "bulletColor": "#FFFFFF",
        "bulletSizeField": "townSize",
        "dashLengthField": "dashLength",
        "descriptionField": "townName",
        "labelPosition": "right",
        "labelText": "[[townName2]]",
        "legendValueText": "首購：[[value]]",
        "title": "latitude/city",
        "fillAlphas": 0,
        "valueField": "returnTotla",
        "valueAxis": "latitudeAxis"
    }],
    "chartCursor": {
        "pan": true,
        "valueLineEnabled": true,
        "valueLineBalloonEnabled": true,
        "cursorAlpha":1,
        "cursorColor":"#258cbb",
        "limitToGraph":"g1",
        "valueLineAlpha":0.2,

    },
    "categoryField": "month",
    "categoryAxis": {
        "gridPosition": "start",
        "gridAlpha": 0,
        "tickPosition": "start",
        "tickLength": 20,
        "color": "#878787"
    },
    "dataLoader": {
        "url": "data/demo-statistics-members.json",
        "format": "json",
        "showErrors": true,
        "noStyles": true,
        "async": true,
    }
});

/*--------------------------------------------
           訂單統計2 - 柱體狀
---------------------------------------------*/
// var chart = AmCharts.makeChart("orderTotal", {
//         "type": "serial",
//         "theme": "light",
//         "titles": [{
//             "text": "銷售金額統計",
//             "bold": true,
//             "size": 20,
//             }],
//         "dataLoader": {
//             "url": "data/demo-order-total2.json",
//             "format": "json",
//             "showErrors": true,
//             "noStyles": true,
//             "async": true,
//         },
//         "legend": {
//             "autoMargins": false,
//             "borderAlpha": 0.2,
//             "equalWidths": false,
//             "horizontalGap": 10,
//             "markerSize": 10,
//             "useGraphSettings": true,
//             "valueAlign": "center",
//             "valueWidth": 0
//         },
//         "valueAxes": [{
//             "stackType": "regular",
//             "axisAlpha": 0.3,
//             "gridAlpha": 0,
//             "gridColor": "#878787",
//             "color": "#878787"
//         }],
//         "graphs": [{
//             "fillAlphas": 0.8,
//             "labelText": "[[value]]",
//             "lineAlpha": 0.3,
//             "title": "生活家電",
//             "type": "column",
//             "color": "#000000",
//             "valueField": "class1"
//         }, {
//             "fillAlphas": 0.8,
//             "labelText": "[[value]]",
//             "lineAlpha": 0.3,
//             "title": "居家照明",
//             "type": "column",
//             "color": "#000000",
//             "valueField": "class2"
//         }, {
//             "fillAlphas": 0.8,
//             "labelText": "[[value]]",
//             "lineAlpha": 0.3,
//             "title": "廚房調理",
//             "type": "column",
//             "color": "#000000",
//             "valueField": "class3"
//         }, {
//             "fillAlphas": 0.8,
//             "labelText": "[[value]]",
//             "lineAlpha": 0.3,
//             "title": "季節空調",
//             "type": "column",
//             "color": "#000000",
//             "valueField": "class4"
//         }],
//         "categoryField": "month",
//         "categoryAxis": {
//             "gridPosition": "start",
//             "axisAlpha": 0.2,
//             "gridAlpha": 0,
//             "position": "left",
//             "tickLength": 20,
//             "color": "#878787"
//         },
//         "export": {
//             "enabled": true
//          }
// });
/*--------------------------------------------
            訂單統計 - 分類直條
---------------------------------------------*/
// var chart = AmCharts.makeChart("orderTotal", {
//     "theme": "light",
//     "type": "serial",
//     "theme": "light",
//     "titles": [{
//         "text": "銷售金額統計",
//         "bold": true,
//         "size": 20,
//     }],
//     "dataLoader": {
//         "url": "data/demo-order-total2.json",
//         "format": "json",
//         "showErrors": true,
//         "noStyles": true,
//         "async": true,
//     },
//     "legend": {
//         "autoMargins": false,
//         "borderAlpha": 0.2,
//         "equalWidths": false,
//         "horizontalGap": 10,
//         "markerSize": 10,
//         "useGraphSettings": true,
//         "valueAlign": "center",
//         "valueWidth": 0
//     },
//     "valueAxes": [{
//         "gridColor": "#878787",
//         "gridAlpha": 0.2,
//         "dashLength": 0,
//         "color": "#878787"
//     }],
//     "gridAboveGraphs": true,
//     "startDuration": 1,
//     "graphs": [{
//         "balloonText": "金額: <b>[[value]]</b>",
//         "fillAlphas": 0.8,
//         "lineAlpha": 0.2,
//         "type": "column",
//         "valueField": "class1",
//         "columnWidth":0.5,
//         "title": "生活家電",
//         "color": "#878787"
//     },{
//         "balloonText": "金額: <b>[[value]]</b>",
//         "fillAlphas": 0.8,
//         "lineAlpha": 0.2,
//         "type": "column",
//         "valueField": "class2",
//         "columnWidth":0.5,
//         "clustered":true,
//         "title": "居家照明",
//         "color": "#000"
//     },{
//         "balloonText": "金額: <b>[[value]]</b>",
//         "fillAlphas": 0.8,
//         "lineAlpha": 0.2,
//         "type": "column",
//         "valueField": "class3",
//         "columnWidth":0.5,
//         "clustered":true,
//         "title": "廚房調理",
//         "color": "#000"
//     },{
//         "balloonText": "金額: <b>[[value]]</b>",
//         "fillAlphas": 0.8,
//         "lineAlpha": 0.2,
//         "type": "column",
//         "valueField": "class4",
//         "columnWidth":0.5,
//         "clustered":true,
//         "title": "季節空調",
//         "color": "#000"
//     }],
//     "chartCursor": {
//         "categoryBalloonEnabled": false,
//         "cursorAlpha": 0,
//         "zoomable": false
//     },
//     "categoryField": "month",
//     "categoryAxis": {
//         "gridPosition": "start",
//         "gridAlpha": 0,
//         "tickPosition": "start",
//         "tickLength": 20,
//         "color": "#878787"
//     },
//     "export": {
//         "enabled": false
//     }
// });