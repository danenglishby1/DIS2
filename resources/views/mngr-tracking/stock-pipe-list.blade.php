@extends('layouts.app')

@section('pageTitle', 'Stock Pipe List')
@section('pageName', 'Stock Pipe List')
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


    <div class="simpleflex">
        <div class="fl1">

            <table id="WIP-tbl" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>PIPE NO</th>
                    <th>PIPE NO ALT</th>
                    <th>CAST</th>
                    <th>ROLL WEEK</th>
                    <th>BLOCK</th>
                    <th>COMMENTS</th>
                    <th>STATUS CODE</th>
                    <th>LENGTH</th>
                    <th>WEIGHT</th>
                    <th>CUT BACK TO</th>
                    <th>SIZE</th>
                    <th>THICK</th>
                    <th>BLOCK GRADE</th>
                    <th>STOCK STATUS</th>
                    <th>OLD RPOS</th>
                    <th>OLD PR</th>
                    <th>DATE TO STOCK</th>
                    <th>DAYS IN STOCK</th>
                    <th>LAST MOVEMENT</th>
                    <th>DAYS SINCE LAST MOVE</th>
                    <th>BAY</th>


                </tr>
                </thead>
                <tbody>


                @foreach($stockPipeListArray as $value)


                    <tr>
                        <td>{{$value["TRACK_CODE"]}}</td>
                        <td>{{$value["TRACK_CODE_KEY2"]}}</td>
                        <td>{{$value["CAST_NO"]}}</td>
                        <td>{{$value["ROLL_WEEK"]}}</td>
                        <td>{{$value["BLOCK_NO"]}}</td>
                        <td>{{$value["COMMENTS"]}}</td>
                        <td>{{$value["PIPE_STATUS_CODE"]}}</td>
                        <td>{{round($value["PIPE_LENGTH"],3)}}</td>
                        <td>{{round($value["T_WEIGHT"],3)}}</td>
                        <td>{{$value["CUT_BACK_TO"]}}</td>
                        <td>{{$value["PIPE_SIZE1"]."x".$value["PIPE_SIZE2"]}}</td>
                        <td>{{$value["PIPE_THICK"]}}</td>
                        <td>{{$value["BLOCK_GRADE"]}}</td>
                        <td>{{$value["STOCK_STATUS"]}}</td>
                        <td>{{$value["OLD_ROUTING_POS"]}}</td>
                        <td>{{$value["OLD_PROCESS_ROUTE"]}}</td>

                        <td>{{substr($value["DATE_TO_STOCK"], 4, 2)."-".substr($value["DATE_TO_STOCK"], 2, 2)."-".strftime('%C').substr($value["DATE_TO_STOCK"], 0, 2)}}</td>

                        <?php


                        $dateTimeNow = time();

                        // Work out days since pipe moved into stock
                        $datePipeMovedToStock = strtotime(substr($value["DATE_TO_STOCK"], 4, 2) . "-" . substr($value["DATE_TO_STOCK"], 2, 2) . "-" . strftime('%C') . substr($value["DATE_TO_STOCK"], 0, 2));
                        $daysDifferenceToStock = $dateTimeNow - $datePipeMovedToStock;
                        // Work out days since pipe last moved when in stock.
                        $datePipeMovedInStock = strtotime(App\H20Custom\libraries\H20TandemData\H20DateTimeTandemTools::LongDateTimeToStandardDateTime($value["LAST_UPDATE_DATETIME"]));
                        $daysDifferenceInStock = $dateTimeNow - $datePipeMovedInStock;

                        ?>
                        <td>{{round($daysDifferenceToStock / (60 * 60 * 24))}}</td>
                        <td>{{App\H20Custom\libraries\H20TandemData\H20DateTimeTandemTools::LongDateTimeToStandardDateTime($value["LAST_UPDATE_DATETIME"])}}</td>
                        <td>{{round($daysDifferenceInStock / (60 * 60 * 24))}}</td>
                        <td>{{$value["BAY_LOCATION"]}}</td>
                    </tr>
                @endforeach
                </tbody>

                <tfoot>
                <tr>
                    <th>PIPE NO</th>
                    <th>PIPE NO ALT</th>
                    <th>CAST</th>
                    <th>ROLL WEEK</th>
                    <th>BLOCK</th>
                    <th>COMMENTS</th>
                    <th>STATUS CODE</th>
                    <th>LENGTH</th>
                    <th>CUT BACK TO</th>
                    <th>SIZE</th>
                    <th>THICK</th>
                    <th>BLOCK GRADE</th>
                    <th>STOCK STATUS</th>
                    <th>OLD RPOS</th>
                    <th>OLD PR</th>
                    <th>DATE TO STOCK</th>
                    <th>DAYS IN STOCK</th>
                    <th>LAST MOVEMENT</th>
                    <th>DAYS SINCE LAST MOVE</th>
                    <th>BAY</th>

                </tr>
                </tfoot>
            </table>
        </div>
    </div>


    <h3>Available fields for data table</h3>
    ACCEPT_CANCEL	<br />
    ACTUAL_WEIGHT	<br />
    BAY_LOCATION	<br />
    BEVEL_ANGLE	<br />
    BLOCK_NO	<br />
    CAST_NO	<br />
    COIL_NO	<br />
    COIL_QUALITY	<br />
    COL_CAT	<br />
    COMMENTS	<br />
    CUST_ITEM_X	<br />
    CUST_ORDER	<br />
    CUT_BACK_TO	<br />
    CUT_IN_HALF_IND	<br />
    DATE_TO_STOCK	<br />
    DIG_OUT_IND	<br />
    EX_HOLL_BLOCK_IND	<br />
    FURNACE_IND	<br />
    ID_TRIMMED	<br />
    INITIALS	<br />
    LAST_UPDATE_DATETIME	<br />
    LENGTH_CATEGORY	<br />
    MILL_LINE	<br />
    OHS_LINE	<br />
    OLD_BLOCK_NO	<br />
    OLD_MILL_LINE	<br />
    OLD_OHS_LINE	<br />
    OLD_PIPE_GRADE	<br />
    OLD_PIPE_SIZE1	<br />
    OLD_PIPE_SIZE2	<br />
    OLD_PIPE_THICK	<br />
    OLD_PROCESS_ROUTE	<br />
    OLD_ROLL_WEEK	<br />
    OLD_ROUTING_POS	<br />
    PAINT_VARNISH_IND	<br />
    PIPE_LENGTH	<br />
    PIPE_SIZE1	<br />
    PIPE_SIZE2	<br />
    PIPE_STATUS_CODE	<br />
    PIPE_THICK	<br />
    PROCESS_ROUTE	<br />
    RE_BEVEL_IND	<br />
    RE_HYDRO_IND	<br />
    RELEASE_RESULT	<br />
    RESTRICT_CODE	<br />
    ROLL_WEEK	<br />
    STOCK_MEMO_NO	<br />
    STOCK_STATUS	<br />
    STOCK_XREF	<br />
    SURFACE_FINISH	<br />
    TRACK_CODE	<br />
    TRACK_CODE_KEY2	<br />
    UNTYPE_IND	<br />


    <!--    <h4 class="mt-3">WIP By Size/Thick & Position</h4>-->
    <!--    <hr/>-->
    <!--    <div id="wipBySizeMultiBarChart" style="height:800px; width: 100%">-->
    <!--        <svg></svg>-->
    <!--    </div>-->
    <!---->
    <!--    <h4 class="mt-5">WIP By Routing</h4>-->
    <!--    <hr/>-->
    <!--    <div id="wipByRoutingMultiBarChart" style="height:500px;">-->
    <!--        <svg></svg>-->
    <!--    </div>-->





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

        // var wipBySizeThickJson = <?php //echo (isset($wipBySizeThickChartJSON) ? $wipBySizeThickChartJSON : ""); ?>//;
        // console.log(wipBySizeThickJson);
        // var wipByRoutingJson = <?php //echo (isset($wipByRoutingChartJSON) ? $wipByRoutingChartJSON : ""); ?>//;
        // console.log(wipByRoutingJson);
        //
        //// RenderStaticGroupedHorizontalBarChart(rhsWipJson, "rhsWipMultiBarChart");
        //// RenderStaticGroupedHorizontalBarChart(chsWipJson, "chsWipMultiBarChart");
        //// RenderStaticStackableBarChart(wipByPRJson, "wipByPRMultiBarChart");
        //
        // RenderStaticGroupedHorizontalBarChart(wipBySizeThickJson, "wipBySizeMultiBarChart");
        //
        // RenderStaticDiscreteBarChart(wipByRoutingJson, "wipByRoutingMultiBarChart", "");


    </script>



@endsection
