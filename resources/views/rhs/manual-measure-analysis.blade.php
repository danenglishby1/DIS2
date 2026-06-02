<?php
use App\H20Custom\libraries\HTMLHelper;
?>
@extends('layouts.app')

@section('pageTitle', 'Manual Measure')
@section('pageName', 'Manual Measure 1DIM')
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
        <div class="filter-left">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filterModal">
                Filters
            </button>
        </div>

        <div class="filter-right">

            <div id="daterange" class="daterangeControl pull-right"
                 style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="fa fa-calendar dateRangeIcon"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
            </div>
        </div>
    </div>

    <div class="mb-3"></div> <!-- add space -->


<?php

echo HTMLHelper::StartSimpleFlexBoxWrapper();

    echo HTMLHelper::StartFlexBox500();

        echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Convex/Concav", "convexConcavLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

        echo HTMLHelper::LineViewFinderChartCardPlaceHolder("CC CV Of Long Side", "convexConcavLongSideLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

        echo HTMLHelper::LineViewFinderChartCardPlaceHolder("CC CV Of Short Side", "convexConcavShortSideLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

        echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Length Of Side", "lengthOfSideLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

        echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Length Of Long Side", "lengthOfLongSideLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

        echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Length Of Short Side", "lengthOfShortSideLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

        echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Scale Depth", "scaleDepthLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

        echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Scale Thickness", "scaleThicknessLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

    echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Thickness", "thicknessLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

    echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Twist", "twistLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

    echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Radius", "radiusLineChart");

    echo HTMLHelper::EndFlexBox500();

echo HTMLHelper::EndSimpleFlexBoxWrapper();

?>
    <!-- Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Size 1</label>
                    <select id="size1">
                        <option value="none"></option>
                    </select>

                    <label>Size 2</label>
                    <select id="size2">
                        <option value="none"></option>
                    </select>

                    <label>Thick</label>
                    <select id="thick">
                        <option value="none"></option>
                    </select>
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
    <script src="{{ asset('public/libraries/lodash/lodash.js')}}"></script>
    <script src="{{ asset('public/js/classes/ProductionDataFilter.js')}}"></script>
    <script src="{{ asset('public/js/filter-change-listeners.js')}}"></script>
    <script src="{{ asset('public/libraries/date-range-picker/moment.min.js')}}"></script>
    <script src="{{ asset('public/libraries/date-range-picker/daterangepicker.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/tooltip.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>
    <script src="{{ asset('public/js/saveSvgAsPng.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var dtFrom = "";
        var dtTo = "";
        var data = "";
        var originalData = "";

        // Get intial data,
        $( document ).ready(function() {
            $.ajax({
                type: "POST",
                data: {"dateRangeCommand": ""},
                url: rootUrl + "/api/GetManualMeasureDataInRange",
                dataType: "json",
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css("display", "block");
                },
                success: function (d) {
                    originalData = d; // Make a copy of data for filter.
                    var productionDataFilter = new ProductionDataFilter(d, '', '', ''); // Initialize filters.
                    FillChartArraysAndRenderCharts(d);
                },
                complete: function () {
                    $('.ajax-loader').css("display", "none");
                }
            });

        });


        function FillChartArraysAndRenderCharts(d) {

            /**
             * Fill local arrays with data from data object.
             */
            var variableData = d;
            console.log(variableData);
            var convexConcavMeas1Array = [];
            var convexConcavMeas2Array = [];
            var convexConcavMeas3Array = [];
            var convexConcavMeas4Array = [];
            var convexConcavUCLArray = [];
            var convexConcavLCLArray = [];
            var ccCVOfLongSideMeas1Array = [];
            var ccCVOfLongSideMeas2Array = [];
            var ccCVOfLongSideUCLArray = [];
            var ccCVOfLongSideLCLArray = [];
            var ccCVOfShortSideMeas1Array = [];
            var ccCVOfShortSideMeas2Array = [];
            var ccCVOfShortSideUCLArray = [];
            var ccCVOfShortSideLCLArray = [];
            var lengthOfSideMeas1Array = [];
            var lengthOfSideMeas2Array = [];
            var lengthOfSideMeas3Array = [];
            var lengthOfSideMeas4Array = [];
            var lengthOfSideUCLArray = [];
            var lengthOfSideLCLArray = [];
            var lengthOfLongSideMeas1Array = [];
            var lengthOfLongSideMeas2Array = [];
            var lengthOfLongSideUCLArray = [];
            var lengthOfLongSideLCLArray = [];
            var lengthOfShortSideMeas1Array = [];
            var lengthOfShortSideMeas2Array = [];
            var lengthOfShortSideUCLArray = [];
            var lengthOfShortSideLCLArray = [];
            var radiusMeas1Array = [];
            var radiusMeas2Array = [];
            var radiusMeas3Array = [];
            var radiusMeas4Array = [];
            var radiueUCLArray = [];
            var radiusLCLArray = [];
            var scaleDepthArray = [];
            var scaleDepthUCLArray = [];
            var scaleDepthLCLArray = [];
            var scaleThicknessMeas1Array = [];
            var scaleThicknessMeas2Array = [];
            var scaleThicknessMeas3Array = [];
            var scaleThicknessMeas4Array = [];
            var scaleThicknessUCLArray = [];
            var scaleThicknessLCLArray = [];
            var thicknessArray = [];
            var thicknessUCLArray = [];
            var thicknessLCLArray = [];
            var twistArray = [];
            var twistUCLArray = [];
            var twistLCLArray = [];
            var size1 = [];
            var size2 = [];
            var thick = [];

            var xAxis1Labels = {};
            var xAxis2Labels = {};
            for (var i = 0; i < variableData.length; i++) {
                xAxis1Labels[i] = variableData[i].TRACK_CODE;
                var dt = new Date(variableData[i].DATETIME_TANDEM);
                xAxis2Labels[i] =  dt.getDate()  + "-" + (dt.getMonth()+1) + "-" + dt.getFullYear() + " " +
                    dt.getHours() + ":" + dt.getMinutes();

                // Length Of Side
                if (variableData[i].VARIABLE == "DIA ") {
                    lengthOfSideMeas1Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_1});
                    lengthOfSideMeas2Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_2});
                    lengthOfSideMeas3Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_3});
                    lengthOfSideMeas4Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_4});
                    lengthOfSideLCLArray.push({x: i, y: variableData[i].LOWER_CONTROL_LIMIT});
                    lengthOfSideUCLArray.push({x: i, y: variableData[i].UPPER_CONTROL_LIMIT});
                }

                // Length Of Long Side
                if (variableData[i].VARIABLE == "DIA1") {
                    lengthOfLongSideMeas1Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_1});
                    lengthOfLongSideMeas2Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_2});
                    lengthOfLongSideLCLArray.push({x: i, y: variableData[i].LOWER_CONTROL_LIMIT});
                    lengthOfLongSideUCLArray.push({x: i, y: variableData[i].UPPER_CONTROL_LIMIT});
                }

                // Length Of Short Side
                if (variableData[i].VARIABLE == "DIA2") {
                    lengthOfShortSideMeas1Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_1});
                    lengthOfShortSideMeas2Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_2});
                    lengthOfShortSideLCLArray.push({x: i, y: variableData[i].LOWER_CONTROL_LIMIT});
                    lengthOfShortSideUCLArray.push({x: i, y: variableData[i].UPPER_CONTROL_LIMIT});
                }

                // Convex Concav
                if (variableData[i].VARIABLE == "CON ") {
                    convexConcavMeas1Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_1});
                    convexConcavMeas2Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_2});
                    convexConcavMeas3Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_3});
                    convexConcavMeas4Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_4});
                    convexConcavLCLArray.push({x: i, y: variableData[i].LOWER_CONTROL_LIMIT});
                    convexConcavUCLArray.push({x: i, y: variableData[i].UPPER_CONTROL_LIMIT});
                }

                // CC CV Of Long Side
                if (variableData[i].VARIABL == "CON1") {
                    ccCVOfLongSideMeas1Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_1});
                    ccCVOfLongSideMeas2Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_2});
                    ccCVOfLongSideLCLArray.push({x: i, y: variableData[i].LOWER_CONTROL_LIMIT});
                    ccCVOfLongSideUCLArray.push({x: i, y: variableData[i].UPPER_CONTROL_LIMIT});
                }

                // CC CV Of Short Side
                if (variableData[i].VARIABL == "CON2") {
                    ccCVOfShortSideMeas1Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_1});
                    ccCVOfShortSideMeas2Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_2});
                    ccCVOfShortSideLCLArray.push({x: i, y: variableData[i].LOWER_CONTROL_LIMIT});
                    ccCVOfShortSideUCLArray.push({x: i, y: variableData[i].UPPER_CONTROL_LIMIT});
                }

                // Twist
                if (variableData[i].VARIABL == "TWT ") {
                    twistArray.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_1});
                    twistLCLArray.push({x: i, y: variableData[i].LOWER_CONTROL_LIMIT});
                    twistUCLArray.push({x: i, y: variableData[i].UPPER_CONTROL_LIMIT});
                }

                // Thickness Reading
                if (variableData[i].VARIABL == "THK ") {
                    thicknessArray.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_1});
                    thicknessLCLArray.push({x: i, y: variableData[i].LOWER_CONTROL_LIMIT});
                    thicknessUCLArray.push({x: i, y: variableData[i].UPPER_CONTROL_LIMIT});
                }

                // CRAD Radius
                if (variableData[i].VARIABL == "CRAD") {
                    radiusMeas1Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_1});
                    radiusMeas2Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_2});
                    radiusMeas3Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_3});
                    radiusMeas4Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_4});
                    radiusLCLArray.push({x: i, y: variableData[i].LOWER_CONTROL_LIMIT});
                    radiueUCLArray.push({x: i, y: variableData[i].UPPER_CONTROL_LIMIT});
                }

                // CRAD Radius
                if (variableData[i].VARIABL == "SCTH") {
                    scaleThicknessMeas1Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_1});
                    scaleThicknessMeas2Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_2});
                    scaleThicknessMeas3Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_3});
                    scaleThicknessMeas4Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_4});
                    scaleThicknessLCLArray.push({x: i, y: variableData[i].LOWER_CONTROL_LIMIT});
                    scaleThicknessUCLArray.push({x: i, y: variableData[i].UPPER_CONTROL_LIMIT});
                }

                // Scale Depth
                if (variableData[i].VARIABL == "SCAL") {
                    scaleDepthArray.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_1});
                    scaleDepthLCLArray.push({x: i, y: variableData[i].LOWER_CONTROL_LIMIT});
                    scaleDepthUCLArray.push({x: i, y: variableData[i].UPPER_CONTROL_LIMIT});
                }

                size1.push(variableData[i].PIPE_SIZE1)
                size2.push(variableData[i].PIPE_SIZE2)
                thick.push(variableData[i].BLOCK_THICK)

            }
//#FF6384
            var lengthOfSideLineChart = RenderLineWithFocusChartDualAxisLabels('lengthOfSideLineChart',
                'lineWithFocus',
                xAxis1Labels, xAxis2Labels, [
                    {values: lengthOfSideMeas1Array, key: 'DIA Meas 1'},
                    {values: lengthOfSideMeas2Array, key: 'DIA Meas 2'},
                    {values: lengthOfSideMeas3Array, key: 'DIA Meas 3'},
                    {values: lengthOfSideMeas4Array, key: 'DIA Meas 4'},
                    {values: lengthOfSideLCLArray, key: 'LCL', color: '#FF6384'},
                    {values: lengthOfSideUCLArray, key: 'UCL', color: '#FF6384'}
                ],
                'Date/Section',
                true,
                'MM',
                true,
                true,
                []);


            var lengthOfLongSideLineChart = RenderLineWithFocusChartDualAxisLabels('lengthOfLongSideLineChart',
                'lineWithFocus',
                xAxis1Labels, xAxis2Labels, [
                    {values: lengthOfLongSideMeas1Array, key: 'DIA1 Meas 1'},
                    {values: lengthOfLongSideMeas2Array, key: 'DIA1 Meas 2'},
                    {values: lengthOfLongSideLCLArray, key: 'LCL', color: '#FF6384'},
                    {values: lengthOfLongSideUCLArray, key: 'UCL', color: '#FF6384'}
                ],
                'Date/Section',
                true,
                'MM',
                true,
                true,
                []);

            var lengthOfShortSideLineChart = RenderLineWithFocusChartDualAxisLabels('lengthOfShortSideLineChart',
                'lineWithFocus',
                xAxis1Labels, xAxis2Labels, [
                    {values: lengthOfShortSideMeas1Array, key: 'DIA2 Meas 1'},
                    {values: lengthOfShortSideMeas2Array, key: 'DIA2 Meas 2'},
                    {values: lengthOfShortSideLCLArray, key: 'LCL', color: '#FF6384'},
                    {values: lengthOfShortSideUCLArray, key: 'UCL', color: '#FF6384'}
                ],
                'Date/Section',
                true,
                'MM',
                true,
                true,
                []);

            var convexConcavLineChart = RenderLineWithFocusChartDualAxisLabels('convexConcavLineChart',
                'lineWithFocus',
                xAxis1Labels, xAxis2Labels, [
                    {values: convexConcavMeas1Array, key: 'CON Meas 1'},
                    {values: convexConcavMeas2Array, key: 'CON Meas 2'},
                    {values: convexConcavMeas3Array, key: 'CON Meas 3'},
                    {values: convexConcavMeas4Array, key: 'CON Meas 4'},
                    {values: convexConcavLCLArray, key: 'LCL', color: '#FF6384'},
                    {values: convexConcavUCLArray, key: 'UCL', color: '#FF6384'}
                ],
                'Date/Section',
                true,
                'MM',
                true,
                true,
                []);

            var convexConcavShortSideLineChart = RenderLineWithFocusChartDualAxisLabels('convexConcavShortSideLineChart',
                'lineWithFocus',
                xAxis1Labels, xAxis2Labels, [
                    {values: ccCVOfShortSideMeas1Array, key: 'CON2 Meas 1'},
                    {values: ccCVOfShortSideMeas2Array, key: 'CON2 Meas 2'},
                    {values: ccCVOfShortSideLCLArray, key: 'LCL', color: '#FF6384'},
                    {values: ccCVOfShortSideUCLArray, key: 'UCL', color: '#FF6384'}
                ],
                'Date/Section',
                true,
                'MM',
                true,
                true,
                []);

            var convexConcavLongSideLineChart = RenderLineWithFocusChartDualAxisLabels('convexConcavLongSideLineChart',
                'lineWithFocus',
                xAxis1Labels, xAxis2Labels, [
                    {values: ccCVOfLongSideMeas1Array, key: 'CON1 Meas 1'},
                    {values: ccCVOfLongSideMeas2Array, key: 'CON1 Meas 2'},
                    {values: ccCVOfLongSideLCLArray, key: 'LCL', color: '#FF6384'},
                    {values: ccCVOfLongSideUCLArray, key: 'UCL', color: '#FF6384'}
                ],
                'Date/Section',
                true,
                'MM',
                true,
                true,
                []);

            var scaleDepthLineChart = RenderLineWithFocusChartDualAxisLabels('scaleDepthLineChart',
                'lineWithFocus',
                xAxis1Labels, xAxis2Labels, [
                    {values: scaleDepthArray, key: 'SCAL Meas 1'},
                    {values: scaleDepthLCLArray, key: 'LCL', color: '#FF6384'},
                    {values: scaleDepthUCLArray, key: 'UCL', color: '#FF6384'}
                ],
                'Date/Section',
                true,
                'MM',
                true,
                true,
                []);


        var scaleThicknessLineChart = RenderLineWithFocusChartDualAxisLabels('scaleThicknessLineChart',
            'lineWithFocus',
            xAxis1Labels, xAxis2Labels, [
                {values: scaleThicknessMeas1Array, key: 'SCTH Meas 1'},
                {values: scaleThicknessMeas2Array, key: 'SCTH Meas 2'},
                {values: scaleThicknessMeas3Array, key: 'SCTH Meas 3'},
                {values: scaleThicknessMeas4Array, key: 'SCTH Meas 4'},
                {values: scaleThicknessLCLArray, key: 'LCL', color: '#FF6384'},
                {values: scaleThicknessUCLArray, key: 'UCL', color: '#FF6384'}
            ],
            'Date/Section',
            true,
            'MM',
            true,
            true,
            []);


        var thicknessLineChart = RenderLineWithFocusChartDualAxisLabels('thicknessLineChart',
            'lineWithFocus',
            xAxis1Labels, xAxis2Labels, [
                {values: thicknessArray, key: 'THK Meas 1'},
                {values: thicknessLCLArray, key: 'LCL', color: '#FF6384'},
                {values: thicknessUCLArray, key: 'UCL', color: '#FF6384'}
            ],
            'Date/Section',
            true,
            'MM',
            true,
            true,
            []);

            var twistLineChart = RenderLineWithFocusChartDualAxisLabels('twistLineChart',
                'lineWithFocus',
                xAxis1Labels, xAxis2Labels, [
                    {values: twistArray, key: 'TWT Meas 1'},
                    {values: twistLCLArray, key: 'LCL', color: '#FF6384'},
                    {values: twistUCLArray, key: 'UCL', color: '#FF6384'}
                ],
                'Date/Section',
                true,
                'MM',
                true,
                true,
                []);

            var radiusLineChart = RenderLineWithFocusChartDualAxisLabels('radiusLineChart',
                'lineWithFocus',
                xAxis1Labels, xAxis2Labels, [
                    {values: radiusMeas1Array, key: 'CRAD Meas 1'},
                    {values: radiusMeas2Array, key: 'CRAD Meas 2'},
                    {values: radiusMeas3Array, key: 'CRAD Meas 3'},
                    {values: radiusMeas4Array, key: 'CRAD Meas 4'},
                    {values: radiusLCLArray, key: 'LCL', color: '#FF6384'},
                    {values: radiueUCLArray, key: 'UCL', color: '#FF6384'}
                ],
                'Date/Section',
                true,
                'MM',
                true,
                true,
                []);
        }


        /**
         * Initialize the date range picker.
         */
        $(function() {

            var start = moment().subtract(1, 'days');
            var end = moment();

            function cb(start, end) {
                $('#daterange span').html(start.format('DD-MM-Y 00:00:01') + ' - ' + end.format('DD-MM-Y 23:59:59'));
            }

            $('#daterange').daterangepicker({
                startDate: start,
                endDate: end,
                timePicker: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    format: 'M/DD hh:mm A'
                }
            }, cb);

            cb(start, end);
        });
        /**
         * Listen for apply being clicked on the date range picker and pass dtfrom and dtto to the GetDataAndBuildCharts function which makes a json call to the api and builds new chart and filter.
         */
        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            if (picker.chosenLabel == "Yesterday") {
                var dtFrom = picker.startDate.format('YYYY-MM-DD 00:00:00');
                var dtTo = picker.endDate.format('YYYY-MM-DD 23:59:59');
            }
            else if (picker.chosenLabel == "Today") {
                var dtFrom = picker.startDate.format('YYYY-MM-DD 00:00:00');
                var dtTo = picker.endDate.format('YYYY-MM-DD 23:59:59');
            }
            else {
                var dtFrom = picker.startDate.format('YYYY-MM-DD H:mm:ss');
                var dtTo = picker.endDate.format('YYYY-MM-DD H:mm:ss');
            }
            console.log(picker.startDate.format('YYYY-MM-DD H:mm:ss'));
            console.log(picker.endDate.format('YYYY-MM-DD H:mm:ss'));

            // Ajax call to api using dt from and dt to from date range picker, get data and update charts + filters.
            $.ajax({
                type: "POST",
                data: {"dtFrom": dtFrom, "dtTo": dtTo},
                url: rootUrl+"/api/GetManualMeasureDataInRange",
                dataType: "json",
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css("display", "block");
                },
                success: function (data) {
                    originalData = data;
                    var productionDataFilter = new ProductionDataFilter(data, '', '' , '');
                    FillChartArraysAndRenderCharts(data);
                },
                complete: function () {
                    $('.ajax-loader').css("display", "none");
                }
            });
            // END Ajax call to api using dt from and dt to from date range picker, get data and update charts + filters.

        });




        $('.svgToPngExportLink').on('click', function(e) {

            var id = e.target.hash;
            var idWithoutHashtag = e.target.hash.replace('#', '');
            var svg = document.getElementById(idWithoutHashtag).getElementsByTagName('svg')[0];

            saveSvgAsPng(svg, idWithoutHashtag+"Export.png", {backgroundColor: '#FFFFFF'});
        });


    </script>

@endsection
