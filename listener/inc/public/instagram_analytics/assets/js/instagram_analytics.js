"use strict";
function Instagram_analytics(){
    var self= this;
    var chart_color = ["rgba(255,0,94,0.7)", "rgba(255,117,136, 0.7)", "rgba(255,168,125,0.7)", "rgba(156,39,176,0.7)", "rgba(28,188,216,0.7)", "rgba(64,78,103,0.7)"];
    this.init= function(){
        if($(".instagram_analytics-app").length > 0){
        }
    };

    this.lineChart = function(element, label, data, name, type, colors){
        if(colors != undefined){
            chart_color = colors;
        }else{
            chart_color = ["rgba(255,0,94,0.7)", "rgba(255,117,136, 0.7)", "rgba(255,168,125,0.7)", "rgba(156,39,176,0.7)", "rgba(28,188,216,0.7)", "rgba(64,78,103,0.7)"];
        }

        var ctx2 = document.getElementById(element).getContext("2d");

        // Chart Options
        var userPageVisitOptions = {
            responsive: true,
            maintainAspectRatio: false,
            pointDotStrokeWidth : 2,
            legend: {
                display: true,
                labels: {
                    fontColor: '#404e67',
                    boxWidth: 10,
                },
                position: 'bottom',
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                xAxes: [{
                    display: true,
                    ticks: {
                        display: true,
                    },
                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        drawTicks: true,
                        drawBorder: true,
                        drawOnChartArea: true
                    },
                    ticks: {
                        display: true,
                        maxTicksLimit: 5,
                        beginAtZero: true,
                        userCallback: function(label, index, labels) {
                            // when the floored value is the same as the value we have a whole number
                            if (Math.floor(label) === label) {
                                return label;
                            }

                        },
                    },
                }]
            },
            title: {
                display: false,
                text: ''
            },
        };

        data_set = [];
        var count_data = data.length;

        for (var i = 0; i < count_data; i++) {
            if(type =="line"){
                data_set.push({
                    label: name[i],
                    data: data[i],
                    backgroundColor: "transparent",
                    borderColor: chart_color[i],
                    pointBorderColor: chart_color[i],
                    pointRadius: 2,
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                });
            }else{
                data_set.push({
                    label: name[i],
                    data: data[i],
                    backgroundColor: chart_color[i],
                    borderColor: "transparent",
                    pointBorderColor: "transparent",
                    pointRadius: 2,
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                });
            }
        }

        // Chart Data
        var userPageVisitData = {
            labels: label,
            datasets: data_set
        };

        var userPageVisitConfig = {
            type: 'line',
            // Chart Options
            options : userPageVisitOptions,
            // Chart Data
            data : userPageVisitData,
        };

        // Create the chart
        var stackedAreaChart = new Chart(ctx2, userPageVisitConfig);
    };

}

Instagram_analytics= new Instagram_analytics();
$(function(){
    Instagram_analytics.init();
});
