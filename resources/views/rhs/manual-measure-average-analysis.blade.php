<?php
use App\H20Custom\libraries\HTMLHelper;
?>
@extends('layouts.app')

@section('pageTitle', 'Manual Measure Historical Average Analysis')
@section('pageName', 'Manual Measure Historical Average Analysis')
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
        <div class="filter-middle">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#customQueryModal">
                Custom Query
            </button>
        </div>
    </div>

    <div class="mb-3"></div> <!-- add space -->




    <?php

    echo HTMLHelper::StartSimpleFlexBoxWrapper();

    echo HTMLHelper::StartFlexBox500();


    echo '<div class="card shadow pb-2">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Historical Average By Roll Week</h6>
                    <span class="filter-on-info">
                        <span id="size1"></span>
                        <span id="size2"></span>
                        <span id="thick"></span>
                        <span id="variable"></span>
                    </span>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                             aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Functions:</div>
                            <a class="dropdown-item svgToPngExportLink" href="#historicalAverageBarChart">Export As PNG</a>

                        </div>
                    </div>
                </div>
                <!-- Visual Content -->
                <!-- Update buttons -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="historicalAverageBarChart" class=\'with-3d-shadow with-transitions\'>
                        <svg></svg>
                    </div>
                </div>
            </div>';


    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::EndSimpleFlexBoxWrapper();

    ?>
    <!-- Modal -->
    <div class="modal fade" id="customQueryModal" tabindex="-1" role="dialog" aria-labelledby="customQueryModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customQueryLabel">Enter Query</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="custom-query-form">
                        <div class="form-group">
                            <label for="dateFrom">Date From</label>
                            <input type="date" name="dateFrom" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="dateTo">Date To</label>
                            <input type="date" name="dateTo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="variable">Variable</label>
                            <select name="variable" class="form-control">
                                <option value="CON">CON1 (CONVEX CONCAV)</option>
                                <option value="CON1">CON1 (CC CV OF LNG SIDE)</option>
                                <option value="CON2">CON1 (CC CV OF SHT SIDE)</option>
                                <option value="CRAD">CRAD (RADII TN TS BN BS)</option>
                                <option value="DIA">DIA (LENGTH OF SIDE)</option>
                                <option value="DIA1">DIA1 (LENGTH OF LONG SIDE)</option>
                                <option value="DIA2">DIA2 (LENGTH OF SHORT SIDE)</option>
                                <option value="SCAL">SCAL (SCALE DEPTH)</option>
                                <option value="SCTH">SCTH (SCALE THICKNESS)</option>
                                <option value="THK">THK (THICKNESS)</option>
                                <option value="TWT">TWT (TWIST)</option>
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="size1">Size 1</label>
                            <input type="number" name="size1" step="any" class="form-control">

                            <label for="size2">Size 2</label>
                            <input type="number" name="size2" step="any" class="form-control">

                            <label for="thick">Thickness</label>
                            <input type="number" name="thick" step="any" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--                    <button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/stream_layers.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>
    <script src="{{ asset('public/js/saveSvgAsPng.js')}}"></script>
    <script src="{{ asset('public/js/FormValueObjectMap.js')}}"></script>
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
