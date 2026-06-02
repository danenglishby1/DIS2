@extends('layouts.app')

@section('pageTitle', 'Furnace Summary')
@section('pageName', 'Furnace Summary')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
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
@section('overrideStartEndDate')
    start = moment().day('Sunday');
    end = moment().day('Saturday');

    window.dtFrom = start.format('Y-MM-DD 00:00:01');
    window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.


@endsection
@section('dateRangePickerOnApplyCallback')
    window.dtFrom = dtFrom;
    window.dtTo = dtTo;
    $.ajax({
    type: 'POST',
    data: {'dtFrom': dtFrom, 'dtTo': dtTo},
    url: rootUrl+'/api/GetFurnaceSummaryJSONWithDateTime',
    dataType: 'json',
    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
    $('.ajax-loader').css('display', 'block');
    },
    success: function (data) {
    console.log(data);
    FormatDataAndBuildCharts(data.furnaceChartData);
    globalTable.destroy();
    var rows = BuildTableRows(data.furnaceStatRawData);
    InjectTableRows(rows);
    InitiateTable();

    },
    complete: function () {
    $('.ajax-loader').css('display', 'none');
    }
    });
@endsection
<div class="filters" style="justify-content: normal;">
    @include('layouts.templates.daterangepicker')


</div>
<div class="row">


    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Min Max Temps</h6>
            </div>
            <!-- Visual Content -->
            <!-- Card Body -->
            <div class="card-body">
                <div id="rhsFurnaceMinMaxTempsLineChart" style="height:500px;"
                     class='with-3d-shadow with-transitions'>
                    <svg></svg>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Mean Temp</h6>
            </div>
            <!-- Visual Content -->
            <!-- Card Body -->
            <div class="card-body">
                <div id="rhsFurnaceMeanLineChart" style="height:500px;" class='with-3d-shadow with-transitions'>
                    <svg></svg>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-xl-12 col-lg-12">

        <table id="furnace-summary-tbl" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <th>CON_NO</th>
                <th>READINGS</th>
                <th>MIN</th>
                <th>MAX</th>
                <th>MEAN</th>
                <th>DATETIME</th>
                <th>Mean Seg 1</th>
                <th>Mean Seg 2</th>
                <th>Mean Seg 3</th>
                <th>Mean Seg 4</th>
                <th>Mean Seg 5</th>
                <th>View Chart</th>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <th>CON_NO</th>
                <th>READINGS</th>
                <th>MIN</th>
                <th>MAX</th>
                <th>MEAN</th>
                <th>DATETIME</th>
                <th>Mean Seg 1</th>
                <th>Mean Seg 2</th>
                <th>Mean Seg 3</th>
                <th>Mean Seg 4</th>
                <th>Mean Seg 5</th>
                <th>View Chart</th>
            </tfoot>
        </table>
    </div>

    <div class="download-button">
        <a class="btn btn-primary" href="<?php echo $rootUrl; ?>/export/ExportFurnaceSummaryDataInRange">Download
            Data</a>
    </div>
</div>


@endsection
@section('functionalScripts')

    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    {{--            <!-- Extension scripts for datatables print functionality -->--}}
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const labelObject = [];
        var globalTable;
        // Strip values and build arrays
        function FormatDataAndBuildCharts(json) {
            const minArray = [];
            const maxArray = [];
            const meanArray = [];
            const avgArray = [];
            const lowerLimitArray = [];
            const upperLimitArray = [];
            let i = 0;
            // strip labels from json to array
            Object.keys(json).forEach(function (k) {
                labelObject[i] = json[k].SECTION_NO;
                minArray.push({x: i, y: json[k].MIN_TEMP});
                maxArray.push({x: i, y: json[k].MAX_TEMP});
                meanArray.push({x: i, y: json[k].MEAN_TEMP})
                avgArray.push({x: i, y: json[k].AVG_TEMP})
                lowerLimitArray.push({x: i, y: 800});
                upperLimitArray.push({x: i, y: 1025});
                i++;
            });

            var minMaxLineChart = RenderLineWithFocusChart('rhsFurnaceMinMaxTempsLineChart',
                'lineWithFocus',
                labelObject, [
                    {values: minArray, key: 'MIN', color: '#FFCD56'},
                    {values: maxArray, key: 'MAX', color: '#FF9F40'},
                    {values: lowerLimitArray, key: 'LOWER_LIMIT', color: '#FF6384'},
                    {values: upperLimitArray, key: 'UPPER_LIMIT', color: '#FF6384'}
                ],
                'Degrees',
                true,
                'Date',
                true,
                true);

            var meanLineChart = RenderLineWithFocusChart('rhsFurnaceMeanLineChart',
                'lineWithFocus',
                labelObject, [
                    {values: meanArray, key: 'MEAN', color: '#FF9F40'},
                    {values: lowerLimitArray, key: 'LOWER_LIMIT', color: '#FF6384'},
                    {values: upperLimitArray, key: 'UPPER_LIMIT', color: '#FF6384'}
                ],
                'Degrees',
                true,
                'Date',
                true,
                true);
        }

        function BuildTable(data) {

        }


        $(document).ready(function () {
            // When page loads, request current weeks data and populate dashboard.
            $.ajax({
                type: 'POST',
                data: {
                    'dtFrom': moment().day('Sunday').format('YYYY-MM-DD 00:00:00'),
                    'dtTo': moment().day('Saturday').format('YYYY-MM-DD 23:59:59')
                },
                url: rootUrl + '/api/GetFurnaceSummaryJSONWithDateTime',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {

                    FormatDataAndBuildCharts(data.furnaceChartData);
                    var rows = BuildTableRows(data.furnaceStatRawData);
                    InjectTableRows(rows);
                    InitiateTable();
                },
                complete: function () {
                    $('.ajax-loader').css('display', 'none');
                }
            });
        });


        function BuildTableRows(data) {
            var tablesRows = "";
            for (const [key, value] of Object.entries(data)) {
                // console.log(key, value);
                tablesRows += "<tr>" +

                    "<td>" + data[key].CON_NO + "</td>" +
                    "<td>" + data[key].READINGS + "</td>" +
                    "<td>" + data[key].MIN_FILTER + "</td>" +
                    "<td>" + data[key].MAX_FILTER + "</td>" +
                    "<td>" + data[key].MEAN_FILTER + "</td>" +
                    "<td>" + data[key].TIME_STAMP + "</td>" +

                    "<td " + (data[key].MEAN_FILTER_SEG_1 !== undefined ? (Math.round(data[key].MEAN_FILTER_SEG_1) < 800 || Math.round(data[key].MEAN_FILTER_SEG_1) > 1025 ? 'style="background:#e3342f;color:#ffffff !important;"' : '') : '') + ">" + (data[key].MEAN_FILTER_SEG_1 !== undefined ? Math.round(data[key].MEAN_FILTER_SEG_1 ) : 0) + "</td>" +
                    "<td " + (data[key].MEAN_FILTER_SEG_2 !== undefined ? (Math.round(data[key].MEAN_FILTER_SEG_2) < 800 || Math.round(data[key].MEAN_FILTER_SEG_2) > 1025 ? 'style="background:#e3342f;color:#ffffff !important;"' : '') : '') + ">" + (data[key].MEAN_FILTER_SEG_2 !== undefined ? Math.round(data[key].MEAN_FILTER_SEG_2 ) : 0) + "</td>" +
                    "<td " + (data[key].MEAN_FILTER_SEG_3 !== undefined ? (Math.round(data[key].MEAN_FILTER_SEG_3) < 800 || Math.round(data[key].MEAN_FILTER_SEG_3) > 1025 ? 'style="background:#e3342f;color:#ffffff !important;"' : '') : '') + ">" + (data[key].MEAN_FILTER_SEG_3 !== undefined ? Math.round(data[key].MEAN_FILTER_SEG_3 ) : 0) + "</td>" +
                    "<td " + (data[key].MEAN_FILTER_SEG_4 !== undefined ? (Math.round(data[key].MEAN_FILTER_SEG_4) < 800 || Math.round(data[key].MEAN_FILTER_SEG_4) > 1025 ? 'style="background:#e3342f;color:#ffffff !important;"' : '') : '') + ">" + (data[key].MEAN_FILTER_SEG_4 !== undefined ? Math.round(data[key].MEAN_FILTER_SEG_4 ) : 0) + "</td>" +
                    "<td " + (data[key].MEAN_FILTER_SEG_5 !== undefined ? (Math.round(data[key].MEAN_FILTER_SEG_5) < 800 || Math.round(data[key].MEAN_FILTER_SEG_5) > 1025 ? 'style="background:#e3342f;color:#ffffff !important;"' : '') : '') + ">" + (data[key].MEAN_FILTER_SEG_5 !== undefined ? Math.round(data[key].MEAN_FILTER_SEG_5 ) : 0) + "</td>" +

                     "<td> <a href='" + rootUrl + "/rhs/section-furnace-trace?sectionNo=" + data[key].CON_NO + "&weekNo=" + data[key].WEEK_NO + "&yearNo=" + data[key].YEAR_NO + "'>View ></a></td>" +

                    "</tr>";

            }

            return tablesRows;
        }

        function InjectTableRows(rows) {
            $('#furnace-summary-tbl').find('tbody').empty();
            $('#furnace-summary-tbl').find('tbody').append(rows);
        }

        function InitiateTable() {
          globalTable = $('#furnace-summary-tbl').DataTable({
              dom: 'Bfrtip',
               buttons: ['print', 'excel'],
                 "order": [[5, "desc"]]
            });
        }


    </script>
@endsection
