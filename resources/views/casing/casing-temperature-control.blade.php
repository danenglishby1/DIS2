@extends('layouts.app')

@section('pageTitle', 'Furnace Temperature Control')
@section('pageName', 'Furnace Temperature Control')
@section('casingActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}" />
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <style>
        .failureByProcessRouteStatsDetail {
            display: flex;
        }
        .failureByProcessRouteStatsDetail>div {
             flex:1;
             margin:1em;
         }


    </style>
@endsection

@section('content')

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
    url: rootUrl+'/api/GetFurnaceTempControlData',
    dataType: 'json',
    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
    $('.ajax-loader').css('display', 'block');
    },
    success: function (data) {
    console.log(data);

    globalTable.destroy();
    var rows = BuildTableRows(data.casingFurnaceData);
    InjectTableRows(rows);
    InitiateTable();
    BuildFailureByPRPieChart(data.casingFurnaceStats);
    BuildFailureByPRStatsWidget(data.casingFurnaceStats);
    BuildFailureByPRIndividualPieCharts(data.casingFurnaceStats);
    },
    complete: function () {
    $('.ajax-loader').css('display', 'none');
    }
    });
@endsection
<div class="filters" style="justify-content: normal;">
    @include('layouts.templates.daterangepicker')


</div>
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
    <!-- Content Row -->

    <div class="row">
        <div class="col-xl-12 col-lg-12">

            <table id="furnace-summary-tbl" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>CON_NO</th>
                    <th>SECTION</th>
                    <th>READINGS</th>
                    <th>MEAN</th>
                    <th>ENTERED</th>
                    <th>S1</th>
                    <th>THICK</th>
                    <th>GRADE</th>
                    <th>PR</th>
                    <th>Mean Seg 1</th>
                    <th>Mean Seg 2</th>
                    <th>Mean Seg 3</th>
                    <th>Mean Seg 4</th>
                    <th>Mean Seg 5</th>
                    <th>View Chart</th>
                </tr>
                </thead>
                <tbody>
{{--                @foreach($casingFurnaceStats as $key => $value)--}}

{{--                    <tr>--}}
{{--                        <td>{{$value["CON_NO"]}}</td>--}}
{{--                        <td>{{$value["SECTION_NO"]}}</td>--}}
{{--                        <td>{{$value["READINGS"]}}</td>--}}
{{--                        <td>{{$value["MEAN_FILTER"]}}</td>--}}
{{--                        <td>{{$value["TIME_STAMP"]}}</td>--}}
{{--                        <td>{{$value["PIPE_SIZE1"]}}</td>--}}
{{--                        <td>{{$value["PIPE_THICK"]}}</td>--}}
{{--                        <td>{{$value["PIPE_GRADE"]}}</td>--}}
{{--                        <td>{{$value["PROCESS_ROUTE"]}}</td>--}}
{{--                        <!----}}
{{--                        Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours.--}}
{{--                        -->--}}
{{--                        <td {{ (isset($value["SEG_1_TEMP_STATUS"]) ?  ($value["SEG_1_TEMP_STATUS"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>{{ (isset($value["MEAN_FILTER_SEG_1"]) ?  $value["MEAN_FILTER_SEG_1"] : 0) }}</td>--}}
{{--                        <td {{ (isset($value["SEG_2_TEMP_STATUS"]) ?  ($value["SEG_2_TEMP_STATUS"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>{{ (isset($value["MEAN_FILTER_SEG_2"]) ?  $value["MEAN_FILTER_SEG_2"] : 0) }}</td>--}}
{{--                        <td {{ (isset($value["SEG_3_TEMP_STATUS"]) ?  ($value["SEG_3_TEMP_STATUS"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>{{ (isset($value["MEAN_FILTER_SEG_3"]) ?  $value["MEAN_FILTER_SEG_3"] : 0) }}</td>--}}
{{--                        <td {{ (isset($value["SEG_4_TEMP_STATUS"]) ?  ($value["SEG_4_TEMP_STATUS"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>{{ (isset($value["MEAN_FILTER_SEG_4"]) ?  $value["MEAN_FILTER_SEG_4"] : 0) }}</td>--}}
{{--                        <td {{ (isset($value["SEG_5_TEMP_STATUS"]) ?  ($value["SEG_5_TEMP_STATUS"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>{{ (isset($value["MEAN_FILTER_SEG_5"]) ?  $value["MEAN_FILTER_SEG_5"] : 0) }}</td>--}}
{{--                        <td>Test</td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
                </tfoot>
            </table>
        </div>
    </div>

<hr />
<h5>Temp failure detail by Process Route</h5>
<div id="failureByProcessRouteStatsDetail" class="failureByProcessRouteStatsDetail">

</div>


        <hr />
<h5>Percentage of temperature failures by Process Route</h5>
        <div id="failuresByProcessRoute" style="height: 400px;">
            <svg></svg>
        </div>



<div id="individualFailurePieChartByProcessRoute" style="display: flex;">

</div>



@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/date-range-picker/moment.min.js')}}"></script>
    <script src="{{ asset('public/libraries/date-range-picker/daterangepicker.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>

    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    <!-- Extension scripts for datatables print functionality -->
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>
    <!-- End  Extension scripts for datatables print functionality -->
    <script>
        // $(document).ready(function() {
        //     $('#furnace-summary-tbl').DataTable({
        //         "order": [[ 6, "desc" ]]
        //     });
        // });

        function BuildTableRows(data) {
            var tablesRows = "";
            for (const [key, value] of Object.entries(data)) {
                // console.log(key, value);
                tablesRows += "<tr>" +

                    /**
                     *                     <th>CON_NO</th>
                     <th>SECTION</th>
                     <th>READINGS</th>
                     <th>MEAN</th>
                     <th>ENTERED</th>
                     <th>S1</th>
                     <th>THICK</th>
                     <th>GRADE</th>
                     <th>PR</th>
                     */
                    "<td>" + data[key].CON_NO + "</td>" +
                    "<td>" + data[key].SECTION_NO + "</td>" +
                    "<td>" + data[key].READINGS + "</td>" +
                    "<td>" + data[key].MEAN_FILTER + "</td>" +
                    "<td>" + data[key].TIME_STAMP + "</td>" +
                    "<td>" + data[key].PIPE_SIZE1 + "</td>" +
                    "<td>" + data[key].PIPE_THICK + "</td>" +
                    "<td>" + data[key].PIPE_GRADE + "</td>" +
                    "<td>" + data[key].PROCESS_ROUTE + "</td>" +

                    "<td " + (data[key].SEG_1_TEMP_STATUS !== undefined ? (data[key].SEG_1_TEMP_STATUS == "F" ? 'style="background:#e3342f;color:#ffffff !important;"' : '') : '') + ">" + (data[key].MEAN_FILTER_SEG_1 !== undefined ? Math.round(data[key].MEAN_FILTER_SEG_1 ) : 0) + "</td>" +
                    "<td " + (data[key].SEG_2_TEMP_STATUS !== undefined ? (data[key].SEG_2_TEMP_STATUS == "F" ? 'style="background:#e3342f;color:#ffffff !important;"' : '') : '') + ">" + (data[key].MEAN_FILTER_SEG_2 !== undefined ? Math.round(data[key].MEAN_FILTER_SEG_2 ) : 0) + "</td>" +
                    "<td " + (data[key].SEG_3_TEMP_STATUS !== undefined ? (data[key].SEG_3_TEMP_STATUS == "F" ? 'style="background:#e3342f;color:#ffffff !important;"' : '') : '') + ">" + (data[key].MEAN_FILTER_SEG_3 !== undefined ? Math.round(data[key].MEAN_FILTER_SEG_3 ) : 0) + "</td>" +
                    "<td " + (data[key].SEG_4_TEMP_STATUS !== undefined ? (data[key].SEG_4_TEMP_STATUS == "F" ? 'style="background:#e3342f;color:#ffffff !important;"' : '') : '') + ">" + (data[key].MEAN_FILTER_SEG_4 !== undefined ? Math.round(data[key].MEAN_FILTER_SEG_4 ) : 0) + "</td>" +
                    "<td " + (data[key].SEG_5_TEMP_STATUS !== undefined ? (data[key].SEG_5_TEMP_STATUS == "F" ? 'style="background:#e3342f;color:#ffffff !important;"' : '') : '') + ">" + (data[key].MEAN_FILTER_SEG_5 !== undefined ? Math.round(data[key].MEAN_FILTER_SEG_5 ) : 0) + "</td>" +
                    "<td> <a href='" + rootUrl + "/casing/section-furnace-trace?sectionNo=" + data[key].CON_NO + "&weekNo=" + data[key].WEEK_NO + "&yearNo=" + data[key].YEAR_NO + "&pr=" + data[key].PROCESS_ROUTE + "&grade=" + data[key].PIPE_GRADE + "'>View ></a></td>" +

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
                "order": [[4, "desc"]]
            });
        }


        function BuildFailureByPRPieChart(data) {

            var failureByPRPieChartData = []

            for (const [key, value] of Object.entries(data)) {
                console.log(key, value);
                failureByPRPieChartData.push({
                    "label": key,
                    "value" :((value.sectionFailedCount / value.sectionCount) * 100)
                });
            }

            nv.addGraph(function() {
                var chart = nv.models.pieChart()
                    .x(function(d) { return d.label })
                    .y(function(d) { return d.value })
                    .showLabels(true);

                d3.select("#failuresByProcessRoute svg")
                    .datum(failureByPRPieChartData)
                    .transition().duration(1200)
                    .call(chart);

                return chart;
            });
        }

        function BuildFailureByPRStatsWidget(data) {
            var html = "";

            for (const [key, value] of Object.entries(data)) {

                html+= "<div class='detail'><div>Process Route: "+ key +"   </div>  <div>Sections Processed: "+value.sectionCount+"</div>  <div>Sections Failed: " +value.sectionFailedCount+ "</div> <div>Sections Passed: " +value.sectionPassedCount+ "</div>  </div>";

            }

            $('#failureByProcessRouteStatsDetail').html(html);
        }


        function BuildFailureByPRIndividualPieCharts(data) {
            var html = "";
            for (const [key, value] of Object.entries(data)) {

                html+= "<div style='flex:1;'>" +
                    "<h6>Temp Stats for Process Route "+key+"</h6>" +
                    "<div id='failuresByProcessRoute_"+key+"' style='height: 400px;'>" +
                    "<svg></svg>" +
                    "</div></div>";

            }

            $('#individualFailurePieChartByProcessRoute').html(html)



            var failureByPRPieChartData = []

            for (const [key, value] of Object.entries(data)) {
                console.log(key, value);


                nv.addGraph(function () {
                    var chart = nv.models.pieChart()
                        .x(function (d) {
                            return d.label
                        })
                        .y(function (d) {
                            return d.value
                        })
                        .showLabels(true)  .showTooltipPercent(true);

                    d3.select("#failuresByProcessRoute_" + key + " svg")
                        .datum([{
                            "label": "Passed",
                            "value": value.sectionPassedCount,
                            "color": "#1effd4"
                        },{
                            "label": "Failed",
                            "value": value.sectionFailedCount,
                            "color": "#f64242"
                        }])
                        .transition().duration(1200)
                        .call(chart);

                    return chart;
                });

            }
        }

        $(document).ready(function () {
            // When page loads, request current weeks data and populate dashboard.
            $.ajax({
                type: 'POST',
                data: {
                    'dtFrom': moment().day('Sunday').format('YYYY-MM-DD 00:00:00'),
                    'dtTo': moment().day('Saturday').format('YYYY-MM-DD 23:59:59')
                },
                url: rootUrl + '/api/GetFurnaceTempControlData',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {
                    var rows = BuildTableRows(data.casingFurnaceData);
                    InjectTableRows(rows);
                    InitiateTable();
                    BuildFailureByPRPieChart(data.casingFurnaceStats);
                    BuildFailureByPRStatsWidget(data.casingFurnaceStats);
                    BuildFailureByPRIndividualPieCharts(data.casingFurnaceStats);
                },
                complete: function () {
                    $('.ajax-loader').css('display', 'none');
                }
            });
        });

    </script>
@endsection
