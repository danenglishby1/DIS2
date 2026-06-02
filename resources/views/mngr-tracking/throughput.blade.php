@extends('layouts.app')

@section('pageTitle', 'Throughput')
@section('pageName', 'Throughput')
@section('millTrackingActiveLink', 'active activeUnderline')
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
    <div class="routingPositionChangerSelect" style="float: right">

        <h6>Change Position</h6>
        <select class="form-control" id="throughputRPosSelect">
            @foreach ($positionsSelectList as $pos)
                <option value="{{$pos}}" {{($throughputPosition == $pos ? "selected" : "")}} >{{$pos}}</option>
            @endforeach
        </select>
        <br/>

        <input type="checkbox" name="defaultDateOverride" id="defaultDateOverride"> Custom Date<br>

        <div id="optionalDateFilters" style="display:none;">
            <h6>Custom DateTime</h6>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input class="form-control" type="date" name="dtFrom" id="dtFrom">
                </div>
                <div class="form-group col-md-6">
                    <input class="form-control" type="date" name="dtTo" id="dtTo">
                </div>
                <button class="btn btn-primary" style="margin: auto;" id="dateFilterSubmitButton">Submit</button>
            </div>
        </div>

    </div>
    </div>

    <hr/>

    <div class="simpleflex">

        <div class="card-body">
            <h5><b> {{$throughputPosition}}</b> Throughput</h5>
            <div id="throughputChart">
                <svg></svg>
            </div>
            <hr/>
        </div>
    </div>

    <div class="card-body">
        <h5>{{$throughputPosition}} Throughput History</h5>


        <a href="{{$queryString}}" class="btn btn-success downloadButtonLink mb-1">Download Data</a>
        <table class="table" id="throughputHistoryTable">
            <thead>
            <th>MOVEMENT</th>
            <th>TRACK_CODE</th>
            <th>SECTION</th>
            <th>BLOCK</th>
            <th>ROLL_WEEK</th>
            <th>MILL_LINE</th>
            <th>OHS_LINE</th>
            <th>ORDER</th>
            <th>ORDER</th>
            <th>CURRENT SIZE</th>
            <th>TRANS SIZE</th>
            <th>GRADE</th>
            <th>CAST_NO</th>
            <th>SHIFT</th>
            <th>CYCLE_TIME</th>
            <th>CURRENT LENGTH</th>
            <th>TRANS LENGTH</th>
            <th>CURRENT WEIGHT</th>
            <th>TRANS WEIGHT</th>
            <th>TO_POS</th>
            <th>CURRENT_POS</th>
            <th>STAT_CODE</th>
            <th>EMP_NUM</th>
            </thead>
            <tbody>
            @foreach($rawThroughputDataArray as $key => $value)
                <tr>
                    <td>{{$value["DATETIME_TANDEM"]}}</td>
                    <td>{{$value["TRACK_CODE"]}}</td>
                    <td>{{$value["TRACK_CODE_ALT"]}}</td>
                    <td>{{$value["BLOCK_NO"]}}</td>
                    <td>{{$value["ROLL_WEEK"]}}</td>
                    <td>{{$value["MILL_LINE"]}}</td>
                    <td>{{$value["OHS_LINE"]}}</td>
                    <td>{{$value["CUST_ORDER"]}}</td>
                    <td>{{$value["CUST_ITEM_X"]}}</td>
                    <td>{{$value["PIPE_SIZE1"] ."x". $value["PIPE_SIZE2"] ." ". $value["PIPE_THICK"]}}</td>
                    <td>{{$value["TRANS_SIZE"]}}</td>
                    <td>{{$value["PIPE_GRADE"]}}</td>
                    <td>{{$value["CAST_NO"]}}</td>
                    <td>{{(isset($value["SHIFT"]) ? $value["SHIFT"] : "" )}}</td>
                    <td>{{(isset($value["CYCLE_TIME"]) ? $value["CYCLE_TIME"] : "" )}}</td>
                    <td>{{$value["PIPE_LENGTH"]}}</td>
                    <td>{{$value["TRANS_LENGTH"]}}</td>
                    <td>{{$value["CURRENT_WEIGHT"]}}</td>
                    <td>{{$value["TRANS_WEIGHT"]}}</td>
                    <td>{{$value["TO_ROUTING_POS"]}}</td>
                    <td>{{$value["ROUTING_POS"]}}</td>
                    <td>{{$value["PIPE_STATUS_CODE"]}}</td>
                    <td>{{$value["EMPLOYEE_NUM"]}}</td>
                </tr>
            @endforeach
            </tbody>

            <tfoot>
            <th>MOVEMENT</th>
            <th>TRACK_CODE</th>
            <th>SECTION</th>
            <th>TRANS_BLOCK</th>
            <th>TRANS_ROLL_WEEK</th>
            <th>TRANS_MILL_LINE</th>
            <th>OHS_LINE</th>
            <th>ORDER</th>
            <th>ORDER</th>
            <th>CURRENT SIZE</th>
            <th>TRANS SIZE</th>
            <th>GRADE</th>
            <th>CAST_NO</th>
            <th>SHIFT</th>
            <th>CYCLE_TIME</th>
            <th>CURRENT LENGTH</th>
            <th>TRANS LENGTH</th>
            <th>CURRENT WEIGHT</th>
            <th>TRANS WEIGHT</th>
            <th>TO_POS</th>
            <th>CURRENT_POS</th>
            <th>STAT_CODE</th>
            <th>EMP_NUM</th>
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
        //Listen for changes on the select drop down list...
        // Get position and append as get PARAM onto current URL then redirect to it.
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("select#throughputRPosSelect").change(function () {
                let rPos = this.value;
                console.log(rPos);
                let url = rootUrl + "/mngr-tracking/throughput?rPos=" + rPos;
                window.location.href = url;
            });


            $('#defaultDateOverride').change(function (e) {
                let checked = $(this).is(":checked");

                if (checked) {
                    $('#optionalDateFilters').css('display', 'block');
                } else {
                    $('#optionalDateFilters').css('display', 'none');
                }
            });

            $('#dateFilterSubmitButton').click(function (e) {
                var dtFrom = $('#dtFrom').val();
                var dtTo = $('#dtTo').val();
                if (dtFrom != "" && dtTo != "") {
                    let rPos = $('select#throughputRPosSelect').val();
                    console.log(rPos);
                    let url = rootUrl + "/mngr-tracking/throughput?rPos=" + rPos + "&dtFrom=" + dtFrom + "&dtTo=" + dtTo;
                    window.location.href = url;
                }


            });

        });


    </script>
    <script>
        let throughputJson = <?php echo $throughputJSON; ?>;
        console.log(throughputJson);
        RenderStaticDiscreteBarChart(throughputJson, "label", "value", "throughputChart", null, "Hour", "Pipe Count", ",0f", ",0f", [], true, false, null, null, null, null, null);


        /**
         * Datatable intialization and config.
         */
        $(document).ready(function () {
            let table = $('#throughputHistoryTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['print'],
                "order": [[0, 'desc']],
                initComplete: function () {
                    this.api().columns().every(function () {
                        let column = this;
                        let select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                let val = $.fn.dataTable.util.escapeRegex(
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
                    let select = $(table.column(idx).footer()).find('select');

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

