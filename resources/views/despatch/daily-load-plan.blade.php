@extends('layouts.app')

@section('pageTitle', 'Daily Load Plan')
@section('pageName', 'Daily Load Plan')

@section('content')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
<style>
    table.dailyPlanTable {

        white-space: nowrap;

    }
</style>
@endsection


<div style="text-align: center;
    margin-top: -50px;">
    <h2>Daily Load Plan</h2>
</div>

@section('dateRangePickerOnApplyCallback')
    window.dtFrom = dtFrom;
    window.dtTo = dtTo;
    $.ajax({
    type: 'POST',
    data: {'dtFrom': dtFrom, 'dtTo': dtTo},
    url: rootUrl+'/api/getDailyLoadPlanData',
    dataType: 'json',
    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
    $('.ajax-loader').css('display', 'block');
    },
    success: function (data) {
    console.log(data);
    BuildDailyPlanTable(data.tdgLoadDataArray);

    },
    complete: function () {
    $('.ajax-loader').css('display', 'none');
    }
    });
@endsection
<div class="filters" style="justify-content: normal;">
    @include('layouts.templates.daterangepicker')
</div>
<div class="mb-3"></div>

<div class="dashboardContainer" style="display: flex;">

    <div id="daily-load-plan" class="d-flex" style="overflow: scroll">


    </div>

</div>
@endsection

@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js?v=1.21')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js?v=1.12')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function BuildDailyPlanTable(data) {

            var objectKeys = Object.keys(data);
            var biggestRecordCount = GetBiggestPlanRecordCount(data); // Get the biggest record count so that we can append empty rows to align all tables.

            var tables = "";

            tables += BuildLoadNumberTable(biggestRecordCount);

            for (var i = 0; i < objectKeys.length; i++) {
                tables += BuildTableHtml(data[objectKeys[i]].RECORDS, objectKeys[i], biggestRecordCount);
            }
            $('#daily-load-plan').html(tables);
        }

        function BuildTableHtml(tableData, key, biggestRecordCount) {
            var tbl = "<table class='table dailyPlanTable'     style='border-right: 5px solid grey;'>";
            tbl += "<thead>";
            tbl += "<tr><th colspan='5'>Collection Date : " + key + "</th></tr>";
            tbl += "<tr>";
            tbl += "<th>Customer</th>";
            tbl += "<th>Destination</th>";
            tbl += "<th>Trailer Type</th>";
            tbl += "<th>Area</th>";
            tbl += "<th>Load Ref</th>";
            tbl += "</tr>";
            tbl += "</thead>";

            tbl += "<tbody>";
            for (var i = 0; i < (biggestRecordCount + 1); i++) {
                tbl += "<tr>";
                tbl += "<td>" + "" + "</td>";
                tbl += "<td>" + "" + "</td>";
                tbl += "<td>" + (tableData[i] !== undefined ? tableData[i].ORDER_ITEMS : " &nbsp; ") + "</td>";
                tbl += "<td>" + (tableData[i] !== undefined ? tableData[i].LOCATION : " &nbsp; ") + "</td>";
                tbl += "<td>" + (tableData[i] !== undefined ? tableData[i].LOAD_REF : " &nbsp; ") + "</td>";
                tbl += "</tr>";
            }


            tbl += "</tbody>";
            tbl += "</table>";

            tbl += "<thead>";
            return tbl;
        }

        function BuildLoadNumberTable(biggestRecordCount) {
            var tbl = "<table class='table dailyPlanTable'     style='border-right: 3px solid grey;'>";
            tbl += "<thead>";
            tbl += "<tr><th>&nbsp;</th></tr>"
            tbl += "<tr><th>Load</th></tr>";
            tbl += "</thead>";

            tbl += "<tbody>";
            for (var i = 0; i < (biggestRecordCount + 1); i++) {
                tbl += "<tr>";
                tbl += "<td>" + "Load_" + (i + 1) + "</td>";
                tbl += "</tr>";

            }
            tbl += "</tbody>";
            tbl += "</table>";

            tbl += "<thead>";
            return tbl;
        }

        function GetBiggestPlanRecordCount(data) {
            var recordCountArray = [];
            for (var [key, value] of Object.entries(data)) {
                recordCountArray.push(data[key].RECORDS.length);
            }

            return Math.max.apply(Math, recordCountArray);
        }

    </script>

@endsection
