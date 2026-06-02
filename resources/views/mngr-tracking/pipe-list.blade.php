@extends('layouts.app')

@section('pageTitle', 'PipeList')
@section('pageName', 'PipeList')
@section('millTrackingActiveLink', 'active activeUnderline')
@section('css')
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
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
    <!-- Content Row -->

    <h3>{{ (isset($_GET["dept"]) ? $_GET["dept"] . " Pipe List" : "") }}</h3>
    <hr/>


    <div class="simpleflex">
        <div class="fl1">

            <table id="WIP-tbl" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>PIPE NO</th>
                    <th>PIPE NO ALT</th>
                    {{--                <th>CAST</th>--}}
                    <th>ROLL WEEK</th>
                    <th>BLOCK</th>
                    <th>COIL_QUAL</th>
                    <th>MILL LINE</th>
                    <th>STOCK?</th>
                    <th>STATUS CODE</th>
                    {{--                <th>COIL_NO</th>--}}
                    <th>LENGTH</th>
                    <th>WEIGHT</th>
                    <th>SIZE</th>
                    <th>THICK</th>
                    <th>RPOS</th>
                    <th>PR</th>
                    {{--                <th>DELA</th>--}}
                    <th>DELB</th>
                    <th>BREACH STATUS</th>
                    <th>DAYS AT POS</th>
                </tr>
                </thead>
                <tbody>


                <?php
                // Get $deliveryBracketMultiplierArray so we can lookup the process router and delivery bracket multiplier to build dela, delb and breach
                $deliveryBracketMultiplierArray = \App\H20Custom\ProcessRouteArray::GetDeliveryBracketMultiplierProcessRoute();
                ?>
                <!-- Note: $wipArray is 3 keys deep.-->
                @foreach($pipeListArray as $key => $value)
                    <tr>
                        <td>{{$value["TRACK_CODE"]}}</td>
                        <td>{{$value["TRACK_CODE_ALT"]}}</td>
                        {{--                        <td>{{$value["CAST_NO"]}}</td>--}}
                        <td>{{$value["ROLL_WEEK"]}}</td>
                        <td>{{$value["BLOCK_NO"]}}</td>
                        <td>{{$value["COIL_COIL_QUALITY"]}}</td>
                        <td>{{$value["MILL_LINE"]}}</td>
                        <td>{{($value["FINISHING_STATUS"] == "S" ? "Ex-Stock" : "")}}</td>
                        <td>{{$value["PIPE_STATUS_CODE"]}}</td>
                        {{--                        <td>{{$value["COIL_NO"]}}</td>--}}
                        <td>{{$value["PIPE_LENGTH"]}}</td>
                        <td>{{round($value["T_WEIGHT"],3)}}</td>
                        <td>{{$value["PIPE_SIZE1"]."x".$value["PIPE_SIZE2"]}}</td>
                        <td>{{$value["PIPE_THICK"]}}</td>
                        <td>{{$value["ROUTING_POS"]}}</td>
                        <td>{{$value["PROCESS_ROUTE"]}}</td>
                        {{--                        <td>{{($value["ROLL_WEEK"] + $deliveryBracketMultiplierArray[$value["PROCESS_ROUTE"]])}}</td>--}}
                        <td>{{($value["ROLL_WEEK"] + $deliveryBracketMultiplierArray[$value["PROCESS_ROUTE"]]) + 2}}</td>
                        <td>{{$value["BREACH_STATUS"]}}</td>

                        <?php
                        $dateTimeNow = time();
                        $datePipeMoved = strtotime($value["DATETIME_TANDEM"]);
                        $daysDifference = $dateTimeNow - $datePipeMoved;
                        ?>
                        <td>{{round($daysDifference / (60 * 60 * 24))}}</td>
                    </tr>
                @endforeach
                </tbody>

                <tfoot>
                <tr>
                    <th>PIPE NO</th>
                    <th>PIPE NO ALT</th>
                    {{--                <th>CAST</th>--}}
                    <th>ROLL WEEK</th>
                    <th>BLOCK</th>
                    <th>COIL_QUAL</th>
                    <th>MILL LINE</th>
                    <th>STOCK?</th>
                    <th>STATUS CODE</th>
                    {{--                <th>COIL_NO</th>--}}
                    <th>LENGTH</th>
                    <th>WEIGHT</th>
                    <th>SIZE</th>
                    <th>THICK</th>
                    <th>RPOS</th>
                    <th>PR</th>
                    {{--                <th>DELA</th>--}}
                    <th>DELB</th>
                    <th>BREACH STATUS</th>
                    <th>DAYS AT POS</th>
                </tr>
                </tfoot>
                </tfoot>
            </table>
        </div>
    </div>

    @if (isset($_GET["dept"]))
        <h4 class="mt-3">WIP By Size/Thick & Position</h4>
        <hr/>
        <div id="wipBySizeMultiBarChart" style="height:800px; width: 100%">
            <svg></svg>
        </div>

        <h4 class="mt-5">WIP By Routing</h4>
        <hr/>
        <div id="wipByRoutingMultiBarChart" style="height:500px;">
            <svg></svg>
        </div>
    @endif




@endsection
@section('functionalScripts')
    <script src="{{ asset('public/js/jquery-3.3.1.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    <!-- Extension scripts for datatables print functionality -->
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>
    <!-- End  Extension scripts for datatables print functionality -->
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script>
        /**
         * Datatable intialization and config.
         */
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#WIP-tbl').DataTable({
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

    <script>

        var wipBySizeThickJson = <?php echo(isset($wipBySizeThickChartJSON) ? $wipBySizeThickChartJSON : ""); ?>;
        console.log(wipBySizeThickJson);
        var wipByRoutingJson = <?php echo(isset($wipByRoutingChartJSON) ? $wipByRoutingChartJSON : ""); ?>;
        console.log(wipByRoutingJson);

        // RenderStaticGroupedHorizontalBarChart(rhsWipJson, "rhsWipMultiBarChart");
        // RenderStaticGroupedHorizontalBarChart(chsWipJson, "chsWipMultiBarChart");
        // RenderStaticStackableBarChart(wipByPRJson, "wipByPRMultiBarChart");

        RenderStaticGroupedHorizontalBarChart(wipBySizeThickJson, "wipBySizeMultiBarChart", true);
        RenderStaticDiscreteBarChart(wipByRoutingJson, "label", "value", "wipByRoutingMultiBarChart", null,"RoutingPos", "Pipe Count", ",0f", ",0f",[], true, false, null, null, null, null, null);


    </script>



@endsection
