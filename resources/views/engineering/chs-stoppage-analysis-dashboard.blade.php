@extends('layouts.app')

@section('pageTitle', 'CHS Stoppage Analysis Dashboard')
@section('pageName', 'CHS Stoppage Analysis Dashboard')
@section('engineeringActiveLink', 'active activeUnderline')
@section('content')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
    <style>
        h5.notification-title {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 0px;
            font-size: 14px;
        }

        .upperNotificationContent {
            display: flex;
            flex-wrap: wrap;
            padding: 7px;
            background: #d8d8d8;
            border-radius: 3px;
            margin-bottom: 10px;
        }

        .upperNotificationContent > div {
            flex: 1 0 120px;
            margin-bottom: 10px;

        }

        .lowerNotificationContent {
            background: #d8d8d8;
            border-radius: 3px;
            margin-bottom: 10px;
            padding: 7px;
            display: flex;
            flex-wrap: wrap;
        }

        .lowerNotificationContent > div {
            flex: 1 0 180px;
            margin-bottom: 10px;
        }

        table.customAnalysisTable {
            border: 1px solid #333;
            margin: 2em auto;
        }

        table.customAnalysisTable td {
            border: 1px solid #333;
            padding: 5px;
        }

        table.customAnalysisTable th {
            border: 1px solid #333;
            padding: 8px;
        }

    </style>
@endsection
@section('overrideStartEndDate')
    start = moment().startOf('day');
    end = moment().endOf('day');

    window.dtFrom = start.format('Y-MM-DD 00:00:01');
    window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.
@endsection
@section('dateRangePickerOnApplyCallback')
    /***
    * Get initial chart data
    */
    $.ajax({
    type: "POST",
    data: {'dtFrom': dtFrom, 'dtTo': dtTo, 'machineNo' : 400},
    url: rootUrl + "/api/getStopfMachineStoppageAnalysisDashboardData",
    dataType: "json",
    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
    $('.ajax-loader').css('display', 'block');
    },
    // async: false,
    success: function (response) {
    console.log(response);
    globalStoppageData = response;
    window.dtFrom = dtFrom;
    window.dtTo = dtTo;

    $('.tableContainer.stoppageByArea').css('display','none');
    $('.tableContainer.stoppageByReason').css('display','none');
    BuildStoppageTypeSummaryTableRows(response.stoppageSummaryByType);
    BuildStoppageTypeJsonAndGenerateChart();
    BuildStoppageBarChartsByReasonMonth("electricalStopsByReasonCountMonth", response.electricalStoppageReasonsByMonthCountData);
    BuildStoppageBarChartsByReasonMonth("electricalStopsByReasonMinsMonth", response.electricalStoppageReasonByMonthMinsData);
    BuildStoppageBarChartsByReasonMonth("electricalStopsByAreaCountMonth", response.electricalStoppageAreaByMonthCountData);
    BuildStoppageBarChartsByReasonMonth("electricalStopsByAreaMinsMonth", response.electricalStoppageAreaByMonthMinsData);
    BuildStoppageBarChartsByReasonMonth("mechanicalStopsByReasonCountMonth", response.mechanicalStoppageReasonsByMonthCountData);
    BuildStoppageBarChartsByReasonMonth("mechanicalStopsByReasonMinsMonth", response.mechanicalStoppageReasonByMonthMinsData);
    BuildStoppageBarChartsByReasonMonth("mechanicalStopsByAreaMinsMonth", response.mechanicalStoppageAreaByMonthMinsData);
    BuildStoppageBarChartsByReasonMonth("mechanicalStopsByAreaCountMonth", response.mechanicalStoppageAreaByMonthCountData);
    BuildStoppageBarChartsByReasonMonth("productionStopsByReasonCountMonth", response.productionStoppageReasonsByMonthCountData);
    BuildStoppageBarChartsByReasonMonth("productionStopsByAreaCountMonth", response.productionStoppageAreaByMonthCountData);
    BuildStoppageBarChartsByReasonMonth("productionStopsByReasonMinsMonth", response.productionStoppageReasonByMonthMinsData);
    BuildStoppageBarChartsByReasonMonth("productionStopsByAreaMinsMonth", response.productionStoppageAreaByMonthMinsData);
    BuildStoppageBarChartsByReasonMonth("changingStopsByReasonCountMonth", response.changingStoppageReasonsByMonthCountData);
    BuildStoppageBarChartsByReasonMonth("changingStopsByAreaCountMonth", response.changingStoppageAreaByMonthCountData);
    BuildStoppageBarChartsByReasonMonth("changingStopsByReasonMinsMonth", response.changingStoppageReasonByMonthMinsData);
    BuildStoppageBarChartsByReasonMonth("changingStopsByAreaMinsMonth", response.changingStoppageAreaByMonthMinsData);
    BuildStoppageBarChartsByReasonMonth("activityStopsByReasonCountMonth", response.activityStoppageReasonsByMonthCountData);
    BuildStoppageBarChartsByReasonMonth("activityStopsByAreaCountMonth", response.activityStoppageAreaByMonthCountData);
    BuildStoppageBarChartsByReasonMonth("activityStopsByReasonMinsMonth", response.activityStoppageReasonByMonthMinsData);
    BuildStoppageBarChartsByReasonMonth("activityStopsByAreaMinsMonth", response.activityStoppageAreaByMonthMinsData);
    BuildStoppageMonthlyAnalysisTable();
    },
    complete: function () {
    $('.ajax-loader').css('display', 'none');
    }
    });
@endsection
@section('dateRangePickerAdditionalRanges')
    'Last 3 Months': [moment().subtract(3, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
    'This Year': [moment().startOf('year'), moment().endOf('year')],
    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
@endsection

<div style="text-align: center;
    margin-top: -50px;">
    <h2>CHS Mill (Casing Furnace) Availability</h2>
</div>


<div class="filters" style="justify-content: normal;">
    @include('layouts.templates.daterangepicker')


    <a class='exportStoppageDataLink' href='#' style="margin-left: 10px; margin-top: 6px;">Export CSV (Date Level & ALL
        Types)</a>
</div>
<div class="mb-3"></div>
<div class="dashboardContainer" style="display: flex;">

    <div class="tableScroller"
         style="position:relative; width: 545px;height:700px; display:flex;    overflow: scroll;">
        <div class="tableContainer stoppageByType" style="width: 520px;flex:1;margin:2em;">
            <table id="stoppageAnalysisSummaryTable" class="table">
                <thead>
                <th>Stoppage Type</th>
                <th>Time Lost</th>
                <th>Stops</th>
                <th>Avg Time Per Stop</th>
                <th>Avg Stops Per Shift</th>
                <th>Avg Mins Lost Shift</th>
                <th>Export</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="tableContainer stoppageByArea" style="width: 520px;display: none;flex:1;margin:2em;">
            <table id="stoppageAreaAnalysisSummaryTable" class="table table-custom-padding-1">
                <thead>
                <th>Stoppage Area</th>
                <th>Total Time Lost</th>
                <th>Total Stops</th>
                <th>Avg Time Per Stop</th>
                <th>Avg Stops Per Shift</th>
                <th>Avg Mins Lost Shift</th>
                <th>Export</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="tableContainer stoppageByReason" style="width: 520px;display: none;flex:1;margin:2em;">
            <table id="stoppageReasonAnalysisSummaryTable" class="table table-custom-padding-1">
                <thead>
                <th>Stoppage Reason</th>
                <th>Total Time Lost</th>
                <th>Total Stops</th>
                <th>Avg Time Per Stop</th>
                <th>Avg Stops Per Shift</th>
                <th>Avg Mins Lost Shift</th>
                <th>Export</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="tableContainer stoppageNotifications" style="width: 520px;display: none;flex:1;margin:2em;">
            <table id="stoppageNotificationsSummaryTable" class="table table-custom-padding-1">
                <thead>
                <th>Notification</th>
                <th>View</th>
                <th>Created At</th>
                <th>Updated At</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="chartsContainer" style="flex:3; margin: 0px 30px 30px 30px">
        <h5>Stop Types</h5>
        <hr style="margin-top: -0.5em;"/>
        <div id="wmStopsByType" style="height: 250px; width:100%;   margin-top: -0.5em;margin-bottom: -60px;">
            <svg></svg>
        </div>

        <h5>Stop Areas By Type</h5>
        <hr style="margin-top: -0.5em;"/>
        <div id="wmStopsByArea" style="height: 250px; width:100%;   margin-top: -0.5em;margin-bottom: -30px;">
            <svg></svg>
        </div>
        <h5>Stop Reasons By Area</h5>
        <hr style="margin-top: -0.5em;"/>

        <div id="wmStopsByReason" style="height: 250px; width:100%;   margin-top: -0.5em;">
            <svg></svg>
        </div>
    </div>
</div>


<!-- TOP 20 Charts -->

<?php
$stopTypeDescriptionLookup = ["E" => "electrical", "M" => "mechanical", "P" => "production", "C" => "changing", "Z" => "activity"];
$stopDescriptionTypeLookup = ["changing" => "C", "electrical" => "E", "production" => "P", "activity" => "Z", "mechanical" => "M"];
$stopTypeColours = ["E" => "#cfffb1", "M" => "#b1c5ff", "P" => "#b9b1ff", "C" => "#ffc3b1", "Z" => "#ffb1f9"];
?>

@foreach ($stopTypeDescriptionLookup as $key => $value)

    <div class="simpleflex">
        <div style="width: 100%; flex:1;">
            <h5 style="text-decoration: underline; margin-top: 10px; margin-bottom: -5px;">
            <span
                style="width: 25px; height: 25px;display: block;background: {{$stopTypeColours[$key]}};border-radius: 15px;display: inline-block; margin: 1px 6px -5px 3px;"></span>
                Top 20 - {{ucfirst($value)}} Stop Count By Reason
            </h5>
            <div style="height: 600px" id="{{$value}}StopsByReasonCountMonth">
                <svg></svg>
            </div>
        </div>

        <div style="width: 100%; flex:1;">
            <h5 style="text-decoration: underline; margin-top: 10px; margin-bottom: -5px;">
            <span
                style="width: 25px; height: 25px;display: block;background: {{$stopTypeColours[$key]}};border-radius: 15px;display: inline-block; margin: 1px 6px -5px 3px;"></span>
                Top 20 - {{ucfirst($value)}} Stop Mins By Reason
            </h5>
            <div style="height: 600px" id="{{$value}}StopsByReasonMinsMonth">
                <svg></svg>
            </div>
        </div>
    </div>


    <div class="simpleflex">
        <div style="width: 100%; flex:1;">
            <h5 style="text-decoration: underline; margin-top: 10px; margin-bottom: -5px;">
            <span
                style="width: 25px; height: 25px;display: block;background: {{$stopTypeColours[$key]}};border-radius: 15px;display: inline-block; margin: 1px 6px -5px 3px;"></span>
                Top 20 - {{ucfirst($value)}} Stop Count By Area
            </h5>
            <div style="height: 600px" id="{{$value}}StopsByAreaCountMonth">
                <svg></svg>
            </div>
        </div>

        <div style="width: 100%; flex:1;">
            <h5 style="text-decoration: underline; margin-top: 10px; margin-bottom: -5px;">
            <span
                style="width: 25px; height: 25px;display: block;background: {{$stopTypeColours[$key]}};border-radius: 15px;display: inline-block; margin: 1px 6px -5px 3px;"></span>
                Top 20 - {{ucfirst($value)}} Stop Mins By Area
            </h5>
            <div style="height: 600px" id="{{$value}}StopsByAreaMinsMonth">
                <svg></svg>
            </div>
        </div>

    </div>

@endforeach


<div id="analysisTable" style="overflow-x: scroll;">

</div>

<!-- Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 650px">
        <div class="modal-content" style="height:825px;">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Tandem Stoppage / Sap Notification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body notificationModalBody">
                <div class="upperNotificationContent">
                    <div>
                        <h5 class="notification-title">Coil No.</h5>
                        <div class="notification-content" id="stopageCoilNo">

                        </div>
                    </div>
                    <div>
                        <h5 class="notification-title">Diameter</h5>
                        <div class="notification-content" id="stoppageDiameter">

                        </div>
                    </div>
                    <div>
                        <h5 class="notification-title">Thickness</h5>
                        <div class="notification-content" id="stoppageThickness">

                        </div>
                    </div>

                    <div>
                        <h5 class="notification-title">StartTime</h5>
                        <div class="notification-content" id="stoppageStartTime">

                        </div>
                    </div>

                    <div>
                        <h5 class="notification-title">Duration (min)</h5>
                        <div class="notification-content" id="stoppageDuration">

                        </div>
                    </div>

                    <div>
                        <h5 class="notification-title">Type/Desc</h5>
                        <div class="notification-content" id="stoppageTypeDesc">

                        </div>
                    </div>

                    <div>
                        <h5 class="notification-title">Area/Desc</h5>
                        <div class="notification-content" id="stoppageAreaDesc">

                        </div>
                    </div>


                    <div>
                        <h5 class="notification-title">Code/Desc</h5>
                        <div class="notification-content" id="stoppageCodeDesc">

                        </div>
                    </div>


                    <div>
                        <h5 class="notification-title">Comments</h5>
                        <div class="notification-content" id="stoppageComments">

                        </div>
                    </div>
                </div>

                <div class="lowerNotificationContent">
                    <div style="flex: 1 0 375px">
                        <h5 class="notification-title">FLOC / Desc</h5>
                        <div class="notification-content" id="notificationFLocDesc">
                        </div>
                    </div>

                    <div>
                        <h5 class="notification-title">Notification No.</h5>
                        <div class="notification-content" id="notificationNo">
                        </div>
                    </div>

                    <div>
                        <h5 class="notification-title">Type / Desc</h5>
                        <div class="notification-content" id="notificationTypeDesc">
                        </div>
                    </div>

                    <div>
                        <h5 class="notification-title">Status / Desc</h5>
                        <div class="notification-content" id="notificationStatusDesc">
                        </div>
                    </div>

                    <div>
                        <h5 class="notification-title">Priority</h5>
                        <div class="notification-content" id="notificationPriority">
                        </div>
                    </div>

                    <div>
                        <h5 class="notification-title">Main WorkCtr / Description</h5>
                        <div class="notification-content" id="notificationWorkCtrDescription">
                        </div>
                    </div>

                    <div>
                        <h5 class="notification-title">Description</h5>
                        <div class="notification-content" id="notificationDescription">
                        </div>
                    </div>

                    <div>
                        <h5 class="notification-title">Linked To PM Order</h5>
                        <div class="notification-content" id="notificationPmOrder">

                        </div>
                    </div>
                </div>

                <div style="flex:1; width: 100%;" style="padding: 7px">
                    <h5 class="notification-title">Long Text</h5>
                    <div class="notification-content" id="notificationText"
                         style="background:#fff;height: 300px;overflow-y: scroll; border: 1px solid #8a8a8acc;padding: 5px; border-radius: 3px; margin-top: 5px">
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    @endsection

    @section('functionalScripts')
        <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
        <script src="{{ asset('public/libraries/NVD3/nv.d3.js?v=1.2')}}"></script>
        <script src="{{ asset('public/js/engineering-stoppage-analysis/functions.js?v=1.28')}}"></script>
        <script src="{{ asset('public/js/engineering-stoppage-analysis/listeners.js')}}"></script>
        {{--        <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.20/lodash.min.js"></script>--}}

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var globalStoppageData = "";
            var globalUserSelection = ""; // Will be M OR E

            // fix if no dtfrom dtto set
            if (dtFrom == undefined) {
                var dtFrom = "X";
                var dtTo = "X";
            }
            /***
             * Get initial chart data
             */
            $.ajax({
                type: "POST",
                url: rootUrl + "/api/getStopfMachineStoppageAnalysisDashboardData",
                data: {'dtFrom': dtFrom, 'dtTo': dtTo, 'machineNo' : 400},
                dataType: "json",
                async: false,
                success: function (response) {
                    console.log(response);
                    globalStoppageData = response;
                    BuildStoppageTypeSummaryTableRows(response.stoppageSummaryByType);
                    BuildStoppageTypeJsonAndGenerateChart();

                    BuildStoppageBarChartsByReasonMonth("electricalStopsByReasonCountMonth", response.electricalStoppageReasonsByMonthCountData);
                    BuildStoppageBarChartsByReasonMonth("electricalStopsByReasonMinsMonth", response.electricalStoppageReasonByMonthMinsData);
                    BuildStoppageBarChartsByReasonMonth("electricalStopsByAreaCountMonth", response.electricalStoppageAreaByMonthCountData);
                    BuildStoppageBarChartsByReasonMonth("electricalStopsByAreaMinsMonth", response.electricalStoppageAreaByMonthMinsData);
                    BuildStoppageBarChartsByReasonMonth("mechanicalStopsByReasonCountMonth", response.mechanicalStoppageReasonsByMonthCountData);
                    BuildStoppageBarChartsByReasonMonth("mechanicalStopsByReasonMinsMonth", response.mechanicalStoppageReasonByMonthMinsData);
                    BuildStoppageBarChartsByReasonMonth("mechanicalStopsByAreaMinsMonth", response.mechanicalStoppageAreaByMonthMinsData);
                    BuildStoppageBarChartsByReasonMonth("mechanicalStopsByAreaCountMonth", response.mechanicalStoppageAreaByMonthCountData);
                    BuildStoppageBarChartsByReasonMonth("productionStopsByReasonCountMonth", response.productionStoppageReasonsByMonthCountData);
                    BuildStoppageBarChartsByReasonMonth("productionStopsByAreaCountMonth", response.productionStoppageAreaByMonthCountData);
                    BuildStoppageBarChartsByReasonMonth("productionStopsByReasonMinsMonth", response.productionStoppageReasonByMonthMinsData);
                    BuildStoppageBarChartsByReasonMonth("productionStopsByAreaMinsMonth", response.productionStoppageAreaByMonthMinsData);
                    BuildStoppageBarChartsByReasonMonth("changingStopsByReasonCountMonth", response.changingStoppageReasonsByMonthCountData);
                    BuildStoppageBarChartsByReasonMonth("changingStopsByAreaCountMonth", response.changingStoppageAreaByMonthCountData);
                    BuildStoppageBarChartsByReasonMonth("changingStopsByReasonMinsMonth", response.changingStoppageReasonByMonthMinsData);
                    BuildStoppageBarChartsByReasonMonth("changingStopsByAreaMinsMonth", response.changingStoppageAreaByMonthMinsData);
                    BuildStoppageBarChartsByReasonMonth("activityStopsByReasonCountMonth", response.activityStoppageReasonsByMonthCountData);
                    BuildStoppageBarChartsByReasonMonth("activityStopsByAreaCountMonth", response.activityStoppageAreaByMonthCountData);
                    BuildStoppageBarChartsByReasonMonth("activityStopsByReasonMinsMonth", response.activityStoppageReasonByMonthMinsData);
                    BuildStoppageBarChartsByReasonMonth("activityStopsByAreaMinsMonth", response.activityStoppageAreaByMonthMinsData);
                    console.log("tblkeys");
                    console.log(response.monthYearKeysBetweenDateRange);
                    BuildStoppageMonthlyAnalysisTable();
                }
            });


            $('#content').delegate("a.exportStoppageDataLink", "click", function (e) {
                e.preventDefault();
                var stopType = ($(this).data('type') === undefined ? "" : $(this).data('type'));
                var stopAreaCode = ($(this).data('areacode') === undefined ? "" : $(this).data('areacode'));
                var stopReason = ($(this).data('reason') === undefined ? "" : $(this).data('reason'));

                window.location.href = rootUrl + "/api/exportStopfStoppageDataByMachineNo?dtFrom=" + dtFrom + "&dtTo=" + dtTo + "&stopType=" + stopType + "&stopArea=" + stopAreaCode + "&stopReason=" + stopReason + "&machineNo=400";

                $('.ajax-loader').css('display', 'none');
            });

        </script>

@endsection
