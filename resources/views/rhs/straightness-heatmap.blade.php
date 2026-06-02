<?php

use App\H20Custom\libraries\HTMLHelper;

?>
@extends('layouts.app')

@section('pageTitle', 'Straightness Bend Pos Analysis')
@section('pageName', 'Straightness Bend Pos Analysis')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')

    <style>
        rect.bordered {
            stroke: #E6E6E6;
            stroke-width: 2px;
        }

        text.mono {
            font-size: 9pt;
            font-family: Consolas, courier;
            fill: #aaa;
        }

        text.axis-workweek {
            fill: #000;
        }

        text.axis-worktime {
            fill: #000;
        }

    </style>

    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
@endsection
@section('content')

@section('overrideStartEndDate')
    start = moment().startOf('month');
    end = moment().endOf('month');

    window.dtFrom = start.format('Y-MM-DD 00:00:01');
    window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.
@endsection
@section('dateRangePickerOnApplyCallback')
    window.dtFrom = dtFrom;
    window.dtTo = dtTo;
    $.ajax({
    type: 'POST',
    data: {'dtFrom': dtFrom, 'dtTo': dtTo},
    url: rootUrl+'/api/getStraightnessHeatMapData',
    dataType: 'json',
    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
    $('.ajax-loader').css('display', 'block');
    },
    success: function (data) {
    console.log(data);
    originalStraightnessData = data.rawPositionOfBendData;
    FillSelectOptions(data.rawPositionOfBendData, false);
    StripBendPositionValuesBuildArraysAndBuildCharts(data.rawPositionOfBendData);

    },
    complete: function () {
    $('.ajax-loader').css('display', 'none');
    }
    });
@endsection
<div class="filters">
    @include('layouts.templates.daterangepicker')
</div>
<div class="mt-3"></div>


<div class="simpleflex">
    <div>
        <h5> Bend Per Metre Position Heatmap </h5>
        <div id="chart"></div>
    </div>

    <div style="margin: auto;text-align: center;border: 1px solid #ccc; border-radius: 10px;padding: 30px;">
        <h5>Filters</h5>
        <div class="mb-4"></div>
        <div class="simpleflex" style="justify-content: center;">

            {{--    <div class="form-group">--}}
            {{--        <label>Roll Week</label>--}}
            {{--        <select class="form-control" id="rollWeek">--}}
            {{--            <option></option>--}}
            {{--        </select>--}}
            {{--    </div>--}}

            <div class="form-group">
                <label><b>S1xS2xTHICK</b></label>
                <select class="form-control" id="size">
                    <option></option>
                </select>
            </div>


        </div>
        <div class="mb-4"></div>
        <a href="#" style="display:block;text-align: center;" id="clearFilters">Clear Filters</a>
        <div class="mb-4"></div>


        <h5>Sections Being Analysed <span id="sectionCount"></span></h5>

    </div>

</div>


<div>
    <h5> Bend Per Metre Position STN1 Distribution </h5>

    <div id="stn1BarDistributionChart" style="width: 100%; height:350px;">
        <svg></svg>
    </div>
    <h5> Bend Per Metre Position STN2 Distribution </h5>
    <div id="stn2BarDistributionChart" style="width: 100%; height:350px;">
        <svg></svg>
    </div>

</div>




@endsection

@section('functionalScripts')
    <script src="{{ asset('public/js/filter-change-listeners.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/FormValueObjectMap.js')}}"></script>
    <script src="{{ asset('public/js/custom-query-submitter.js')}}"></script>
    <script src="{{ asset('public/libraries/lodash/lodash.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        /**
         * Heatmap JS / FUNCTION
         **/

        var margin = {top: 50, right: 0, bottom: 100, left: 40},
            width = 960 - margin.left - margin.right,
            height = 430 - margin.top - margin.bottom,
            gridSize = Math.floor(width / 15),
            legendElementWidth = gridSize * 2,
            buckets = 15,
            colors = ["#ffffd9", "#edf8b1", "#c7e9b4", "#7fcdbb", "#41b6c4", "#1d91c0", "#225ea8", "#253494", "#081d58"], // alternatively colorbrewer.YlGnBu[9]
            //days = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
            days = ["STN1", "STN2"],
            //times = ["1a", "2a", "3a", "4a", "5a", "6a", "7a", "8a", "9a", "10a", "11a", "12a", "1p", "2p", "3p", "4p", "5p", "6p", "7p", "8p", "9p", "10p", "11p", "12p"];
            times = ["0-1 M", "1-2 M", "2-3 M", "3-4 M", "4-5 M", "5-6 M", "6-7 M", "7-8 M", "8-9 M", "9-10 M", "10-11 M", "11-12 M", "12-13 M", "13-14 M", "14-15 M"];


        var dataHandler = function (error, data) {
            console.log("data=", data);
            var colorScale = d3.scale.quantile()
                .domain([0, buckets - 1, d3.max(data, function (d) {
                    return d.value;
                })])
                .range(colors);
            d3.select("#chart svg").remove();
            var svg = d3.select("#chart").append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
                .append("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

            var dayLabels = svg.selectAll(".dayLabel")
                .data(days)
                .enter().append("text")
                .text(function (d) {
                    return d;
                })
                .attr("x", 0)
                .attr("y", function (d, i) {
                    return i * gridSize;
                })
                .style("text-anchor", "end")
                .attr("transform", "translate(-6," + gridSize / 1.5 + ")")
                .attr("class", function (d, i) {
                    return ((i >= 0 && i <= 4) ? "dayLabel mono axis axis-workweek" : "dayLabel mono axis");
                });

            var timeLabels = svg.selectAll(".timeLabel")
                .data(times)
                .enter().append("text")
                .text(function (d) {
                    return d;
                })
                .attr("x", function (d, i) {
                    return i * gridSize;
                })
                .attr("y", 0)
                .style("text-anchor", "middle")
                .attr("transform", "translate(" + gridSize / 2 + ", -6)")
                .attr("class", function (d, i) {
                    return ((i >= 7 && i <= 16) ? "timeLabel mono axis axis-worktime" : "timeLabel mono axis");
                });

            var heatMap = svg.selectAll(".hour")
                .data(data)
                .enter().append("rect")
                .attr("x", function (d) {
                    return (d.hour - 1) * gridSize;
                })
                .attr("y", function (d) {
                    return (d.day - 1) * gridSize;
                })
                .attr("rx", 4)
                .attr("ry", 4)
                .attr("class", "hour bordered")
                .attr("width", gridSize)
                .attr("height", gridSize)
                .style("fill", colors[0]);

            heatMap.transition().duration(3000)
                .style("fill", function (d) {
                    return colorScale(d.value);
                });

            heatMap.append("title").text(function (d) {
                return d.value;
            });

            var legend = svg.selectAll(".legend")
                .data([0].concat(colorScale.quantiles()), function (d) {
                    return d;
                })
                .enter().append("g")
                .attr("class", "legend");

            legend.append("rect")
                .attr("x", function (d, i) {
                    return legendElementWidth * i;
                })
                .attr("y", height)
                .attr("width", legendElementWidth)
                .attr("height", gridSize / 2)
                .style("fill", function (d, i) {
                    return colors[i];
                });

            legend.append("text")
                .attr("class", "mono")
                .text(function (d) {
                    return "= " + Math.round(d);
                })
                .attr("x", function (d, i) {
                    return legendElementWidth * i;
                })
                .attr("y", height + gridSize);
        }

        /**
         * end Heatmap JS / FUNCTION
         **/



        function StripBendPositionValuesBuildArraysAndBuildCharts(data) {
            var stn1TotalBendData = [];
            var stn2TotalBendData = [];

            for (var i = 0; i < data.length; i++) {
                stn1TotalBendData.push(data[i].POSITION_OF_BEND1_MM);
                stn2TotalBendData.push(data[i].POSITION_OF_BEND2_MM);
            }

            BuildCharts(stn1TotalBendData, stn2TotalBendData);
        }


        function BuildCharts(stn1TotalBendData, stn2TotalBendData) {
            var heatmapDistributionGenerator = d3.layout.histogram()
                .range([0, 15000])    // Set the domain to cover the entire interval [0;]
                .bins(15);  // number of thresholds; this will create 19+1 bins

            var stn1Bins = heatmapDistributionGenerator(stn1TotalBendData);
            var stn2Bins = heatmapDistributionGenerator(stn2TotalBendData);

            // data
            var heatmapChartDistributionData = [];
            var stn1BarChartDistribution = [];
            var stn1BinsArray = [];
            var stn2BarChartDistribution = [];
            var stn2BinsArray = [];

            for (var i = 0; i < stn1Bins.length; i++) {
                heatmapChartDistributionData.push({
                    "day": 1,
                    "hour": (((stn1Bins[i].x + 1) / 1000) + 1).toString(),
                    "value": stn1Bins[i].y
                });

                stn1BarChartDistribution.push({
                    "label": stn1Bins[i].x + " - " + (stn1Bins[i].x + stn1Bins[i].dx),
                    "value": stn1Bins[i].y,
                    color: '#4573ff'
                });
                stn1BinsArray.push(stn1Bins[i].x);
            }

            for (var i = 0; i < stn2Bins.length; i++) {
                heatmapChartDistributionData.push({
                    "day": 2,
                    "hour": (((stn2Bins[i].x + 1) / 1000) + 1).toString(),
                    "value": stn2Bins[i].y
                });

                stn2BarChartDistribution.push({
                    "label": stn2Bins[i].x + " - " + (stn2Bins[i].x + stn2Bins[i].dx),
                    "value": stn2Bins[i].y,
                    color: '#4573ff'
                });
                stn2BinsArray.push(stn2Bins[i].x);
            }


            dataHandler(null, heatmapChartDistributionData);

            /**
             * Distribution Bar charts
             */

            var stn1ChartData = [
                {
                    key: "DistributionData",
                    values: stn1BarChartDistribution
                }
            ]

            BuildDistributionBarChart('stn1BarDistributionChart', stn1ChartData);

            var stn2ChartData = [
                {
                    key: "DistributionData",
                    values: stn2BarChartDistribution
                }
            ]
            console.log(stn2ChartData);
            BuildDistributionBarChart('stn2BarDistributionChart', stn2ChartData);

            UpdateSectionsAnalysedCount(stn1TotalBendData.length);

            function BuildDistributionBarChart(id, data) {
                nv.addGraph(function () {
                    var chart = nv.models.discreteBarChart()
                        .x(function (d) {
                            return d.label
                        })
                        .y(function (d) {
                            return d.value
                        })
                        .margin({
                            top: 20,
                            right: 20,
                            bottom: 100,
                            left: 80,
                        })
                        .staggerLabels(true)
                        .wrapLabels(true)
                        .showValues(true);
                    // .rotateLabels(90);

                    chart.valueFormat(d3.format(",0f"));// Or whatever format you'd like
                    chart.yAxis
                        .tickFormat(d3.format(",0f"))
                        .axisLabel("No Of Sections");

                    chart.xAxis     //Chart x-axis settings
                        .axisLabel('Bin Size')


                    d3.select('#' + id + ' svg')
                        .datum(data)
                        .transition().duration(500)
                        .call(chart);
                    nv.utils.windowResize(chart.update);

                    return chart;
                });
            }
        }

        function UpdateSectionsAnalysedCount(count) {
            $('#sectionCount').html(count);
        }

        var originalStraightnessData;
        var filteredStraightnessData;


        $(document).ready(function () {
            // When page loads, request current weeks data and populate dashboard.
            $.ajax({
                type: 'POST',
                data: {
                    'dtFrom': moment().startOf('month').format('YYYY-MM-DD 00:00:00'),
                    'dtTo': moment().endOf('month').format('YYYY-MM-DD 23:59:59')
                },
                url: rootUrl + '/api/getStraightnessHeatMapData',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {
                    console.log(data);
                    originalStraightnessData = data.rawPositionOfBendData;
                    FillSelectOptions(data.rawPositionOfBendData, false);
                    StripBendPositionValuesBuildArraysAndBuildCharts(data.rawPositionOfBendData);
                },
                complete: function () {
                    $('.ajax-loader').css('display', 'none');
                }
            });
        });

        function FillSelectOptions(data, sizeSelectActive) {
            console.log("filtering");

            $('.ajax-loader').css("display", "block");
            $('#size').find('option').remove();
            // $('#rollWeek').find('option').remove();


            var size = [];
            var rollWeek = [];
            for (var i = 0; i < data.length; i++) {
                size.push(data[i].SIZE_THICK);
                //  rollWeek.push(data[i].ROLL_WEEK);

            }
            size = _.uniq(size);
            size = _.sortBy(size);

            var option = (sizeSelectActive == false ? '<option value="">Please Select..</option>' : '');
            for (var i = 0; i < size.length; i++) {
                option += '<option value="' + size[i] + '">' + size[i] + '</option>';
            }
            $('#size').append(option);

            // option = (blockThickSelectActive == false ? '<option value="">Please Select..</option>' : '');
            // for (var i=0;i< blockThick.length;i++){
            //     option += '<option value="'+ blockThick[i] + '">' + blockThick[i] + '</option>';
            // }
            // $('#blockThick').append(option);
            //
            // option = (gradeSelectActive == false ? '<option value="">Please Select..</option>' : '');
            // for (var i=0;i< grade.length;i++){
            //     option += '<option value="'+ grade[i] + '">' + grade[i] + '</option>';
            // }
            // $('#grade').append(option);
            //
            // option = (prSelectActive == false ? '<option value="">Please Select..</option>' : '');
            // for (var i=0;i< pr.length;i++){
            //     option += '<option value="'+ pr[i] + '">' + pr[i] + '</option>';
            // }
            // $('#pr').append(option);
            //
            // option = (castNoActive == false ? '<option value="">Please Select..</option>' : '');
            // for (var i=0;i< castNo.length;i++){
            //     option += '<option value="'+ castNo[i] + '">' + castNo[i] + '</option>';
            // }
            // $('#castNo').append(option);
            //
            // option = (rollWeekActive == false ? '<option value="">Please Select..</option>' : '');
            // for (var i=0;i< rollWeek.length;i++){
            //     option += '<option value="'+ rollWeek[i] + '">' + rollWeek[i] + '</option>';
            // }
            // $('#rollWeek').append(option);

            $('.ajax-loader').css("display", "none");
        }


        $('#size').on('change', function () {
            var sizeSelectActive = false;


            var filterObj = {};
            if ($('#size').val() !== "") {
                filterObj.SIZE_THICK = $('#size').val();
                sizeSelectActive = true;
            }

            console.log(filterObj);
            var filtered = _.filter(originalStraightnessData, filterObj);
            console.log(filtered);
            FillSelectOptions(filtered, sizeSelectActive);
            StripBendPositionValuesBuildArraysAndBuildCharts(filtered);
        });

        $('#clearFilters').on('click', function () {
            FillSelectOptions(originalStraightnessData, false, false, false, false, false, false);
            StripBendPositionValuesBuildArraysAndBuildCharts(originalStraightnessData);

        });


    </script>

@endsection
