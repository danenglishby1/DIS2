@extends('layouts.app')

@section('pageTitle', 'RHS Throughput')
@section('pageName', '2 SAW Throughput')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
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
    <!-- Content Row -->

    <div class="simpleflex">

        {{--            <div class="movement-times">--}}
        {{--            <table class="table">--}}
        {{--                <thead>--}}
        {{--                <th>PartOfShift</th>--}}
        {{--                <th>Movement Time</th>--}}
        {{--                </thead>--}}

        {{--                <td>First Of 10x6</td>--}}
        {{--                <td>{{$rawThroughputDataArray[0]["DATETIME_TANDEM"]}}</td>--}}

        {{--            </table>--}}

        {{--            </div>--}}

        <div class="card-body">
            <h5>Throughput</h5>
            <div id="throughputChart">
                <svg></svg>
            </div>
            <hr/>
        </div>
    </div>

    <div class="card-body">
        <h5>Throughput History</h5>

        <table class="table" id="throughputHistoryTable">
            <thead>
            <th>MOVEMENT</th>
            <th>SIZE</th>
            <th>SHIFT</th>
            <th>CYCLE_TIME</th>
            </thead>
            <tbody>
            @foreach($rawThroughputDataArray as $key => $value)
                <tr>
                    <td>{{$value["DATETIME_TANDEM"]}}</td>
                    <td>{{$value["PIPE_SIZE1"] ."x". $value["PIPE_SIZE2"] ." ". $value["PIPE_THICK"]}}</td>
                    <td>{{(isset($value["SHIFT"]) ? $value["SHIFT"] : "" )}}</td>
                    <td>{{(isset($value["CYCLE_TIME"]) ? $value["CYCLE_TIME"] : "" )}}</td>

                </tr>
            @endforeach
            </tbody>

            <tfoot>
            <th>MOVEMENT</th>
            <th>SIZE</th>
            <th>SHIFT</th>
            <th>CYCLE_TIME</th>
            </tfoot>
        </table>

    </div>







@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>

    <script src="{{ asset('public/js/jquery-3.3.1.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    <!-- Extension scripts for datatables print functionality -->
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
        var throughputJson = <?php echo $throughputJSON; ?>;
        console.log(throughputJson);

        RenderStaticDiscreteBarChart(throughputJson, "label", "value", "throughputChart", null, "Hour", "Pipe Count", ",0f", ",0f",[], true, false, null, null, null, null, null);




        // function CustomRenderLiveLineWithFocusChartDualAxisLabels(feedURL, getOrPostInd, params, canvasIdentifier, strChartType, strXAxisLabel, boolShowXAxisLabel, strYAxisLabel, boolShowYAxisLabel, boolShowLegend, forceYValues) {
        //     var data = [];
        //     var arrLabels1 = [];
        //     var arrLabels2 = [];
        //
        //     /***
        //      * Get initial chart data
        //      */
        //     if (getOrPostInd == "G") {
        //         $.ajax({
        //             type: "get",
        //             url: feedURL,
        //             dataType: "json",
        //             async: false,
        //             success: function (response) {
        //                 data = response.values;
        //                 console.info(data);
        //                 arrLabels1 = response.labelArrays.xAxisLabels1;
        //                 arrLabels2 = response.labelArrays.xAxisLabels2;
        //
        //                 console.log(arrLabels1);
        //                 $('#current-trace-section-no').html(response.sectionNo);
        //             }
        //         });
        //     } else if (getOrPostInd == "P") {
        //         var paramObject = {};
        //         if (params.length > 0) {
        //
        //         }
        //     }
        //     /***
        //      * END Get initial chart data
        //      */
        //
        //     return nv.addGraph(function () {
        //
        //         var chart =
        //             nv.models.lineWithFocusChart();
        //         chart.useInteractiveGuideline(true);
        //         //   chart.xAxis.tickFormat(d3.format(',f')).axisLabel("Stream - 3,128,.1");
        //         chart.margin({"left": 60, "right": 60, "top": 10, "bottom": 65});
        //         chart.xAxis
        //             .tickFormat(function (d) {
        //                 return arrLabels1[d];
        //             })
        //             .axisLabel('Date');
        //         chart.x2Axis
        //             .tickFormat(function (d) {
        //                 return arrLabels2[d];
        //             })
        //             .axisLabel('Date');
        //
        //         // if forceYValues array is not empty... then set them to what was specified.. otherwise let the chart render defaults.
        //         if (forceYValues.length > 0) {
        //             chart.forceY([-forceYValues[0], forceYValues]);
        //         }
        //
        //
        //         //chart.xAxis.tickFormat(d3.format(',f'));
        //         chart.yTickFormat(d3.format(',.2f'));
        //
        //         d3.select('#' + canvasIdentifier + ' svg')
        //             .datum(data)
        //             .call(chart);
        //         nv.utils.windowResize(chart.update);
        //
        //
        //         // Set repetetive API call to update charts.
        //         setInterval(function () {
        //             $.ajax({
        //                 type: "get",
        //                 url: feedURL,
        //                 dataType: "json",
        //                 success: function (response) {
        //                     chart.xAxis
        //                         .tickFormat(function (d) {
        //                             return response.labelArrays.xAxisLabels1[d];
        //                         });
        //                     chart.x2Axis
        //                         .tickFormat(function (d) {
        //                             return response.labelArrays.xAxisLabels2[d];
        //                         });
        //                     $('#current-trace-section-no').html(response.sectionNo);
        //
        //                     console.log(response.sectionNo);
        //                     data = response.values;
        //                     console.log(data);
        //                     d3.select('#' + canvasIdentifier + ' svg')
        //                         .datum(data);
        //                     chart.update();
        //
        //                 }
        //             });
        //         }, 30000);
        //
        //
        //         return chartObj;
        //     });
        // }


        /**
         * Datatable intialization and config.
         */
        $(document).ready(function () {
            var table = $('#throughputHistoryTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['print', 'excel'],
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        });
                    });
                }
            });


            table.on('draw', function () {
                table.columns().indexes().each(function (idx) {
                    var select = $(table.column(idx).footer()).find('select');

                    if (select.val() === '') {
                        select
                            .empty()
                            .append('<option value=""/>');

                        table.column(idx, {search: 'applied'}).data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });
                    }
                });
            });
        });


    </script>

@endsection
