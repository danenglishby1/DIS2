<?php
use App\H20Custom\libraries\HTMLHelper;
?>
@extends('layouts.app')

@section('pageTitle', 'Zumbach Averages Analysis')
@section('pageName', 'Zumbach Averages Analysis')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
@endsection
@section('content')
    <!-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
        <div class="alert alert-success" role="alert">
{{ session('status') }}
            </div>
@endif
        You are logged in!
    </div>
</div>
</div>
</div> -->

    <div class="btn-flex-wrapper mt-2 text-center">



    </div>

    <div class="mb-3"></div> <!-- add space -->




@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
{{--    <script src="{{ asset('public/js/saveSvgAsPng.js')}}"></script>--}}
{{--    <script src="{{ asset('public/js/FormValueObjectMap.js')}}"></script>--}}
    <script src="{{ asset('public/js/custom-query-submitter.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var globalChart;

        function FillChartArraysAndRenderCharts(d) {
            var svg = d3.select("svg");
            svg.selectAll("*").remove();
            /**
             * Fill local arrays with data from data object.
             */
            var variableData = d;
            console.log(variableData);
            var size1 = [];
            var size2 = [];
            var thick = [];
            var xAxis1Labels = {};
            var xAxis2Labels = {};

            var dataArrayOfObjects = [];
            var meas1DataObj = {key: "AVG_MEAS_1", originalKey: "AVG_MEAS_1", type: "bar", yAxis: 1, color: "#009688"};
            var meas2DataObj = {key: "AVG_MEAS_2", originalKey: "AVG_MEAS_2", type: "bar", yAxis: 1, color: "#00ab9b"};
            var meas3DataObj = {key: "AVG_MEAS_3", originalKey: "AVG_MEAS_3", type: "bar", yAxis: 1, color: "#01c3b1"};
            var meas4DataObj = {key: "AVG_MEAS_4", originalKey: "AVG_MEAS_4", type: "bar", yAxis: 1, color: "#00dac6"};
            var lowerLimitDataObj = {key: "LCL", originalKey: "LCL", type: "line", yAxis: 1, color: "#FF0000"};
            var upperLimitDataObj = {key: "UCL", originalKey: "UCL", type: "line", yAxis: 1, color: "#FF0000"};

            var meas1Values = [];
            var meas2Values = [];
            var meas3Values = [];
            var meas4Values = [];
            var lclValues = [];
            var uclValues = [];

            for (var i = 0; i < variableData.length; i++) {
                xAxis1Labels[i] = variableData[i].ROLL_WEEK;
                lclValues.push({x: i, y: variableData[i].LOWER_CONTROL_LIMIT});
                uclValues.push({x: i, y: variableData[i].UPPER_CONTROL_LIMIT});
                meas1Values.push({x: i, y: variableData[i].AVG_MEAS_1});
                meas2Values.push({x: i, y: variableData[i].AVG_MEAS_2});
                meas3Values.push({x: i, y: variableData[i].AVG_MEAS_3});
                meas4Values.push({x: i, y: variableData[i].AVG_MEAS_4});
            }
            lowerLimitDataObj.values = lclValues;
            upperLimitDataObj.values = uclValues;
            meas1DataObj.values = meas1Values;
            meas2DataObj.values = meas2Values;
            meas3DataObj.values = meas3Values;
            meas4DataObj.values = meas4Values;

            dataArrayOfObjects.push(lowerLimitDataObj);
            dataArrayOfObjects.push(upperLimitDataObj);
            dataArrayOfObjects.push(meas1DataObj);
            dataArrayOfObjects.push(meas2DataObj);
            dataArrayOfObjects.push(meas3DataObj);
            dataArrayOfObjects.push(meas4DataObj);

            console.log(dataArrayOfObjects);
            console.log(xAxis1Labels);

            nv.addGraph(function () {
                globalChart = nv.models.multiChart()
                    .margin({top: 30, right: 60, bottom: 50, left: 70})
                    .color(d3.scale.category10().range());

                //  chart.xAxis.tickFormat(d3.format(',f'));

                globalChart.xAxis
                    .tickFormat(function (d) {
                        return xAxis1Labels[d];
                    })
                    .axisLabel('Roll Week');


                globalChart.yAxis1.tickFormat(d3.format(',.1f')).axisLabel('MM');
                ;

                d3.select('#historicalAverageBarChart svg')
                    .datum(dataArrayOfObjects)
                    .transition().duration(500).call(globalChart);
                return globalChart;
            });


        }

        $('.svgToPngExportLink').on('click', function (e) {

            var id = e.target.hash;
            var idWithoutHashtag = e.target.hash.replace('#', '');
            var svg = document.getElementById(idWithoutHashtag).getElementsByTagName('svg')[0];

            saveSvgAsPng(svg, idWithoutHashtag + "Export.png", {backgroundColor: '#FFFFFF'});
        });


        /**
         Listen for custom query submit, parse form values and submit to api, then rerun the FillChartArraysAndRenderCharts function.
         */

        $('.custom-query-form').on('submit', function (e) {
            e.preventDefault(); // stop submit
            // parse name values from form
            var formValuesObject = $(this).serializeObject();

            // Update header chart values to indicate criteria picked.
            $('#size1').html("Size1: " + formValuesObject.size1);
            $('#size2').html("Size2: " + formValuesObject.size2);
            $('#thick').html("Thick: " + formValuesObject.thick);
            $('#variable').html("Variable: " + formValuesObject.variable);


            //Submit values to api.

            // Ajax call to api using dt from and dt to from date range picker, get data and update charts + filters.
            $('.ajax-loader').css("display", "block");
            $.ajax({
                type: "POST",
                data: formValuesObject,
                url: rootUrl + "/api/GetManMeasureHistoricalAverageData",
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data.length == 0) {
                        alert("No data found for query criteria");
                    }
                    if (data.message == "rejected, all post values not set.") {
                        alert("Please fill out all Query Inputs and submit again.")
                    }
                    if (data.length > 0) {
                        FillChartArraysAndRenderCharts(data);
                    }
                },
                complete: function () {
                    $('.ajax-loader').css("display", "none");
                }
            });
            // END Ajax call to api using dt from and dt to from date range picker, get data and update charts + filters.
        });


        // key: "Stream0"
        // originalKey: "Stream0"
        // type: "bar"
        // values: (32) [{…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}]
        // yAxis: 1


        var testdata = stream_layers(9, 10 + Math.random() * 100, .1).map(function (data, i) {
            return {
                key: 'Stream' + i,
                values: data.map(function (a) {
                    a.y = a.y * (i <= 1 ? -1 : 1);
                    return a
                })
            };
        });
        console.log(testdata);


    </script>

@endsection
