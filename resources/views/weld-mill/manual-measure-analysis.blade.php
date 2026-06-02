<?php
use App\H20Custom\libraries\HTMLHelper;
?>
@extends('layouts.app')

@section('pageTitle', 'Manual Measure')
@section('pageName', 'Manual Measure LAB1')
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

    echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Thickness", "thicknessLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

    echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Straightness", "straightnessLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

    echo HTMLHelper::LineViewFinderChartCardPlaceHolder("DIAM Axial Dims", "diamLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

    echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Convex/Concav", "convexConcavLineChart");

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

    echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Twist", "twistLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

    echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Radius", "radiusLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::StartFlexBox500();

    echo HTMLHelper::LineViewFinderChartCardPlaceHolder("SideSquareness", "sideSquarenessLineChart");

    echo HTMLHelper::EndFlexBox500();

    echo HTMLHelper::EndSimpleFlexBoxWrapper();

    ?>
    <!-- Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 720px;">
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

                    <label>Grade</label>
                    <select id="grade">
                        <option value="none"></option>
                    </select>
                </div>
                <a id="clearFilters" style="margin-left: 10px;font-size: 16px;" href="#">Clear Filters</a>
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
    <script src="{{ asset('public/libraries/date-range-picker/moment.min.js')}}"></script>
    <script src="{{ asset('public/libraries/date-range-picker/daterangepicker.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/tooltip.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>
    <script src="{{ asset('public/js/saveSvgAsPng.js')}}"></script>
    <script src="{{ asset('public/libraries/lodash/lodash.js')}}"></script>
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
        var filteredData = "";

        function FillSelectOptions(data, blockThickSelectActive, gradeSelectActive, size1SelectActive, size2SelectActive) {
            console.log("filtering");

            $('.ajax-loader').css("display", "block");
            $('#thick').find('option').remove();
            $('#grade').find('option').remove();
            $('#size1').find('option').remove();
            $('#size2').find('option').remove();

            var blockThick = [];
            var grade = [];
            var size1 = [];
            var size2 = [];
            for (var i = 0; i < data.length; i++) {
                blockThick.push(data[i].BLOCK_THICK);
                size1.push(data[i].PIPE_SIZE1);
                size2.push(data[i].PIPE_SIZE2);
                grade.push(data[i].BLOCK_GRADE);

            }
            blockThick = _.uniq(blockThick);
            grade = _.uniq(grade);
            size1 = _.uniq(size1);
            size2 = _.uniq(size2);

            option = (blockThickSelectActive == false ? '<option value="">Please Select..</option>' : '');
            for (var i = 0; i < blockThick.length; i++) {
                option += '<option value="' + blockThick[i] + '">' + blockThick[i] + '</option>';
            }
            $('#thick').append(option);

            option = (gradeSelectActive == false ? '<option value="">Please Select..</option>' : '');
            for (var i = 0; i < grade.length; i++) {
                option += '<option value="' + grade[i] + '">' + grade[i] + '</option>';
            }
            $('#grade').append(option);

            option = (size1SelectActive == false ? '<option value="">Please Select..</option>' : '');
            for (var i = 0; i < size1.length; i++) {
                option += '<option value="' + size1[i] + '">' + size1[i] + '</option>';
            }
            $('#size1').append(option);

            option = (size2SelectActive == false ? '<option value="">Please Select..</option>' : '');
            for (var i = 0; i < size2.length; i++) {
                option += '<option value="' + size2[i] + '">' + size2[i] + '</option>';
            }
            $('#size2').append(option);

            $('.ajax-loader').css("display", "none");
        }

        $('#size1, #thick, #size2, #grade').on('change', function () {
            var blockThickSelectActive = false;
            var gradeSelectActive = false;
            var size1SelectActive = false;
            var size2SelectActive = false;

            var filterObj = {};
            if ($('#thick').val() !== "") {
                filterObj.BLOCK_THICK = parseFloat($('#thick').val());
                blockThickSelectActive = true;
            }
            if ($('#grade').val() !== "") {
                filterObj.BLOCK_GRADE = $('#grade').val();
                gradeSelectActive = true;
            }
            if ($('#size1').val() !== "") {
                filterObj.PIPE_SIZE1 = parseFloat($('#size1').val());
                size1SelectActive = true;
            }
            if ($('#size2').val() !== "") {
                filterObj.CAST_NO = parseFloat($('#size2').val());
                size2SelectActive = true;
            }

            console.log(filterObj);
            console.log(originalData);
            var filtered = _.filter(originalData, filterObj);
            console.log(filtered);
            FillSelectOptions(filtered, blockThickSelectActive, gradeSelectActive, size1SelectActive, size2SelectActive);
            FillChartArraysAndRenderCharts(filtered);
        });

        $('#clearFilters').on('click', function() {
            FillSelectOptions(originalData, false, false, false, false, false, false);
            FillChartArraysAndRenderCharts(originalData);
        });


        // Get intial data,
        $(document).ready(function () {
            $.ajax({
                type: "POST",
                data: {"dateRangeCommand": ""},
                url: rootUrl + "/api/GetLab1ManualMeasureDataInRange",
                dataType: "json",
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css("display", "block");
                },
                success: function (d) {
                    originalData = d; // Make a copy of data for filter.
                    ///   var productionDataFilter = new ProductionDataFilter(d, '', '', ''); // Initialize filters.
                    FillSelectOptions(originalData, false, false, false, false);

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

            var variables = _.groupBy(variableData, "VARIABL");
            console.log(variables);
            var variableDataObject = {};
            for (var key in variables) {
                variableDataObject[key + "Measure1"] = [];
                variableDataObject[key + "Measure2"] = [];
                variableDataObject[key + "Measure3"] = [];
                variableDataObject[key + "Measure4"] = [];
                variableDataObject[key + "LowerControlLimit"] = [];
                variableDataObject[key + "UpperControlLimit"] = [];
                variableDataObject[key + "StandardMeasurement"] = [];
            }

            console.info(variableDataObject);

            var thicknessArray = [];
            var thicknessUCLArray = [];
            var thicknessLCLArray = [];

            var size1 = [];
            var size2 = [];
            var thick = [];

            var xAxis1Labels = {};
            var xAxis2Labels = {};
            for (var i = 0; i < variableData.length; i++) {
                xAxis1Labels[i] = variableData[i].COIL_COIL_WEEK + " " + variableData[i].COIL_COIL_SEQ_NO;
                var dt = new Date(variableData[i].DATETIME_TANDEM);
                xAxis2Labels[i] = dt.getDate() + "-" + (dt.getMonth() + 1) + "-" + dt.getFullYear() + " " +
                    dt.getHours() + ":" + dt.getMinutes();

                variableDataObject[variableData[i].VARIABL + "Measure1"].push({
                    x: i,
                    y: variableData[i].VARIABLE_MEASUREMENT_1
                });

                variableDataObject[variableData[i].VARIABL + "Measure2"].push({
                    x: i,
                    y: variableData[i].VARIABLE_MEASUREMENT_2
                });

                variableDataObject[variableData[i].VARIABL + "Measure3"].push({
                    x: i,
                    y: variableData[i].VARIABLE_MEASUREMENT_3
                });

                variableDataObject[variableData[i].VARIABL + "Measure4"].push({
                    x: i,
                    y: variableData[i].VARIABLE_MEASUREMENT_4
                });

                variableDataObject[variableData[i].VARIABL + "LowerControlLimit"].push({
                    x: i,
                    y: variableData[i].LOWER_CONTROL_LIMIT
                });

                variableDataObject[variableData[i].VARIABL + "UpperControlLimit"].push({
                    x: i,
                    y: variableData[i].UPPER_CONTROL_LIMIT
                });

                variableDataObject[variableData[i].VARIABL + "StandardMeasurement"].push({
                    x: i,
                    y: variableData[i].STANDARD_MEASUREMENT
                });

                size1.push(variableData[i].PIPE_SIZE1);
                size2.push(variableData[i].PIPE_SIZE2);
                thick.push(variableData[i].BLOCK_THICK);
            }
            console.log(variableDataObject);
            console.log(xAxis1Labels);
            console.log(xAxis2Labels);

            if (variableDataObject["THK Measure1"] !== undefined) {
                var thicknessLineChart = RenderLineWithFocusChartDualAxisLabels('thicknessLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [
                        {values: variableDataObject["THK Measure1"], key: 'THK Meas 1'},
                        {values: variableDataObject["THK Measure2"], key: 'THK Meas 2'},
                        {values: variableDataObject["THK Measure3"], key: 'THK Meas 3'},
                        {values: variableDataObject["THK LowerControlLimit"], key: 'LCL', color: '#FF6384'},
                        {values: variableDataObject["THK UpperControlLimit"], key: 'UCL', color: '#FF6384'},
                        {values: variableDataObject["THK StandardMeasurement"], key: 'Nominal', color: '#00a035'},
                    ],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            } else {
                var thicknessLineChart = RenderLineWithFocusChartDualAxisLabels('thicknessLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            }
//convexConcavLineChart
            if (variableDataObject["CON Measure1"] !== undefined) {
                var convexConcavLineChart = RenderLineWithFocusChartDualAxisLabels('convexConcavLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [
                        {values: variableDataObject["CON Measure1"], key: 'CON Meas 1'},
                        {values: variableDataObject["CON Measure2"], key: 'CON Meas 2'},
                        {values: variableDataObject["CON Measure3"], key: 'CON Meas 3'},
                        {values: variableDataObject["CON Measure4"], key: 'CON Meas 4'},
                        {values: variableDataObject["CON LowerControlLimit"], key: 'LCL', color: '#FF6384'},
                        {values: variableDataObject["CON UpperControlLimit"], key: 'UCL', color: '#FF6384'},
                        {values: variableDataObject["CON StandardMeasurement"], key: 'Nominal', color: '#00a035'},
                    ],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            } else {
                var convexConcavLineChart = RenderLineWithFocusChartDualAxisLabels('convexConcavLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            }

//radiusLineChart
            if (variableDataObject["CRADMeasure1"] !== undefined) {
                var radiusLineChart = RenderLineWithFocusChartDualAxisLabels('radiusLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [
                        {values: variableDataObject["CRADMeasure1"], key: 'CRAD Meas 1'},
                        {values: variableDataObject["CRADMeasure2"], key: 'CRAD Meas 2'},
                        {values: variableDataObject["CRADMeasure3"], key: 'CRAD Meas 3'},
                        {values: variableDataObject["CRADMeasure4"], key: 'CRAD Meas 4'},
                        {values: variableDataObject["CRADLowerControlLimit"], key: 'LCL', color: '#FF6384'},
                        {values: variableDataObject["CRADUpperControlLimit"], key: 'UCL', color: '#FF6384'},
                        {values: variableDataObject["CRADStandardMeasurement"], key: 'Nominal', color: '#00a035'},
                    ],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            } else {
                var radiusLineChart = RenderLineWithFocusChartDualAxisLabels('radiusLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            }

            if (variableDataObject["DIA Measure1"] !== undefined) {
                var lengthOfSideLineChart = RenderLineWithFocusChartDualAxisLabels('lengthOfSideLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [
                        {values: variableDataObject["DIA Measure1"], key: 'DIA Meas 1'},
                        {values: variableDataObject["DIA Measure2"], key: 'DIA Meas 2'},
                        {values: variableDataObject["DIA Measure3"], key: 'DIA Meas 3'},
                        {values: variableDataObject["DIA Measure4"], key: 'DIA Meas 4'},
                        {values: variableDataObject["DIA LowerControlLimit"], key: 'LCL', color: '#FF6384'},
                        {values: variableDataObject["DIA UpperControlLimit"], key: 'UCL', color: '#FF6384'},
                        {values: variableDataObject["DIA StandardMeasurement"], key: 'Nominal', color: '#00a035'},
                    ],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            } else {
                var lengthOfSideLineChart = RenderLineWithFocusChartDualAxisLabels('lengthOfSideLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            }

            if (variableDataObject["DIA1Measure1"] !== undefined) {
                var lengthOfLongSideLineChart = RenderLineWithFocusChartDualAxisLabels('lengthOfLongSideLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [
                        {values: variableDataObject["DIA1Measure1"], key: 'DIA1 Meas 1'},
                        {values: variableDataObject["DIA1Measure2"], key: 'DIA1 Meas 2'},
                        // {values: variableDataObject["DIA1Measure3"], key: 'DIA1 Meas 3'},
                        // {values: variableDataObject["DIA1Measure4"], key: 'DIA1 Meas 4'},
                        {values: variableDataObject["DIA1LowerControlLimit"], key: 'LCL', color: '#FF6384'},
                        {values: variableDataObject["DIA1UpperControlLimit"], key: 'UCL', color: '#FF6384'},
                        {values: variableDataObject["DIA1StandardMeasurement"], key: 'Nominal', color: '#00a035'},
                    ],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            } else {
                var lengthOfLongSideLineChart = RenderLineWithFocusChartDualAxisLabels('lengthOfLongSideLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            }


            if (variableDataObject["DIA2Measure1"] !== undefined) {
                var lengthOfShortSideLineChart = RenderLineWithFocusChartDualAxisLabels('lengthOfShortSideLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [
                        {values: variableDataObject["DIA2Measure1"], key: 'DIA2 Meas 1'},
                        {values: variableDataObject["DIA2Measure2"], key: 'DIA2 Meas 2'},
                        // {values: variableDataObject["DIA2Measure3"], key: 'DIA2 Meas 3'},
                        // {values: variableDataObject["DIA2Measure4"], key: 'DIA2 Meas 4'},
                        {values: variableDataObject["DIA2LowerControlLimit"], key: 'LCL', color: '#FF6384'},
                        {values: variableDataObject["DIA2UpperControlLimit"], key: 'UCL', color: '#FF6384'},
                        {values: variableDataObject["DIA2StandardMeasurement"], key: 'Nominal', color: '#00a035'},
                    ],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            } else {
                var lengthOfShortSideLineChart = RenderLineWithFocusChartDualAxisLabels('lengthOfShortSideLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            }


            if (variableDataObject["DSQRMeasure1"] !== undefined) {
                var sideSquarenessLineChart = RenderLineWithFocusChartDualAxisLabels('sideSquarenessLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [
                        {values: variableDataObject["DSQRMeasure1"], key: 'DSQR Meas 1'},
                        {values: variableDataObject["DSQRMeasure2"], key: 'DSQR Meas 2'},
                        {values: variableDataObject["DSQRMeasure3"], key: 'DSQR Meas 3'},
                        {values: variableDataObject["DSQRMeasure4"], key: 'DSQR Meas 4'},
                        {values: variableDataObject["DSQRLowerControlLimit"], key: 'LCL', color: '#FF6384'},
                        {values: variableDataObject["DSQRUpperControlLimit"], key: 'UCL', color: '#FF6384'},
                        {values: variableDataObject["DSQRStandardMeasurement"], key: 'Nominal', color: '#00a035'},
                    ],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            } else {
                var sideSquarenessLineChart = RenderLineWithFocusChartDualAxisLabels('sideSquarenessLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            }
            if (variableDataObject["STR Measure1"] !== undefined) {
                var straightnessLineChart = RenderLineWithFocusChartDualAxisLabels('straightnessLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [
                        {values: variableDataObject["STR Measure1"], key: 'STR Meas 1'},
                        {values: variableDataObject["STR Measure2"], key: 'STR Meas 2'},
                        {values: variableDataObject["STR Measure3"], key: 'STR Meas 3'},
                        {values: variableDataObject["STR Measure4"], key: 'STR Meas 4'},
                        {values: variableDataObject["STR LowerControlLimit"], key: 'LCL', color: '#FF6384'},
                        {values: variableDataObject["STR UpperControlLimit"], key: 'UCL', color: '#FF6384'},
                        {values: variableDataObject["STR StandardMeasurement"], key: 'Nominal', color: '#00a035'},
                    ],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            } else {
                var straightnessLineChart = RenderLineWithFocusChartDualAxisLabels('straightnessLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            }

            if (variableDataObject["TWSTMeasure1"] !== undefined) {
                ////  //twistLineChart
                var straightnessLineChart = RenderLineWithFocusChartDualAxisLabels('twistLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [
                        {values: variableDataObject["TWSTMeasure1"], key: 'TWST Meas 1'},
                        {values: variableDataObject["TWSTMeasure2"], key: 'TWST Meas 2'},
                        {values: variableDataObject["TWSTMeasure3"], key: 'TWST Meas 3'},
                        {values: variableDataObject["TWSTMeasure4"], key: 'TWST Meas 4'},
                        {values: variableDataObject["TWSTLowerControlLimit"], key: 'LCL', color: '#FF6384'},
                        {values: variableDataObject["TWSTUpperControlLimit"], key: 'UCL', color: '#FF6384'},
                        {values: variableDataObject["TWSTStandardMeasurement"], key: 'Nominal', color: '#00a035'},
                    ],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            } else {
                var straightnessLineChart = RenderLineWithFocusChartDualAxisLabels('twistLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            }

            if (variableDataObject["DIAMMeasure1"] !== undefined) {
                ////  //twistLineChart
                var straightnessLineChart = RenderLineWithFocusChartDualAxisLabels('diamLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [
                        {values: variableDataObject["DIAMMeasure1"], key: 'DIAM Meas 1'},
                        {values: variableDataObject["DIAMMeasure2"], key: 'DIAM Meas 2'},
                        {values: variableDataObject["DIAMMeasure3"], key: 'DIAM Meas 3'},
                        {values: variableDataObject["DIAMMeasure4"], key: 'DIAM Meas 4'},
                        {values: variableDataObject["DIAMLowerControlLimit"], key: 'LCL', color: '#FF6384'},
                        {values: variableDataObject["DIAMUpperControlLimit"], key: 'UCL', color: '#FF6384'},
                        {values: variableDataObject["DIAMStandardMeasurement"], key: 'Nominal', color: '#00a035'},
                    ],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            } else {
                var straightnessLineChart = RenderLineWithFocusChartDualAxisLabels('diamLineChart',
                    'lineWithFocus',
                    xAxis1Labels, xAxis2Labels, [],
                    'Date/Coil',
                    true,
                    'MM',
                    true,
                    true,
                    []);
            }
        }


        /**
         * Initialize the date range picker.
         */
        $(function () {

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
        $('#daterange').on('apply.daterangepicker', function (ev, picker) {
            if (picker.chosenLabel == "Yesterday") {
                var dtFrom = picker.startDate.format('YYYY-MM-DD 00:00:00');
                var dtTo = picker.endDate.format('YYYY-MM-DD 23:59:59');
            } else if (picker.chosenLabel == "Today") {
                var dtFrom = picker.startDate.format('YYYY-MM-DD 00:00:00');
                var dtTo = picker.endDate.format('YYYY-MM-DD 23:59:59');
            }
            else {
                var dtFrom = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
                var dtTo = picker.endDate.format('YYYY-MM-DD HH:mm:ss');
            }
            console.log(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
            console.log(picker.endDate.format('YYYY-MM-DD H:mm:ss'));

            // Ajax call to api using dt from and dt to from date range picker, get data and update charts + filters.
            $.ajax({
                type: "POST",
                data: {"dtFrom": dtFrom, "dtTo": dtTo},
                url: rootUrl + "/api/GetLab1ManualMeasureDataInRange",
                dataType: "json",
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css("display", "block");
                },
                success: function (data) {
                    originalData = data;
                    //    var productionDataFilter = new ProductionDataFilter(data, '', '', '');
                    FillSelectOptions(originalData, false, false, false, false);
                    FillChartArraysAndRenderCharts(data);
                },
                complete: function () {
                    $('.ajax-loader').css("display", "none");
                }
            });
            // END Ajax call to api using dt from and dt to from date range picker, get data and update charts + filters.

        });


        $('.svgToPngExportLink').on('click', function (e) {

            var id = e.target.hash;
            var idWithoutHashtag = e.target.hash.replace('#', '');
            var svg = document.getElementById(idWithoutHashtag).getElementsByTagName('svg')[0];

            saveSvgAsPng(svg, idWithoutHashtag + "Export.png", {backgroundColor: '#FFFFFF'});
        });


    </script>

@endsection
