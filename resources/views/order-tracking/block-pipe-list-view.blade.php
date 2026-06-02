@extends('layouts.app')

@section('pageTitle', 'Block Pipe List')
@section('pageName', 'Block Pipe List')
@section('orderTrackingActiveLink', 'active activeUnderline')

@section('css')
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <style>
        #wrapper #content-wrapper {
            overflow: hidden;
        }
    </style>
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

    <div class="mb-4">
        <form id="blockSelectForm">
        <select class="form-control" id="blockNo" name="blockNo">
            @foreach($blockListArray as $blockNo)
            <option value="{{$blockNo["BLOCK_NO"]}}" {{($blockNo["BLOCK_NO"] == $userSelectedBlockNo ? "selected" : "" )}}  >{{$blockNo["BLOCK_NO"]}}</option>
            @endforeach
        </select>

        <button class="btn btn-primary mt-2" type="submit">Get Pipe List</button>
        </form>
    </div>

<hr class="mb-4" />

    <div>
        <table id="pipeList-tbl" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>PIPE ID</th>
                <th>SECTION ID</th>
                <th>BLOCK</th>
                <th>ROLL WEEK</th>
                <th>CAST NO</th>
                <th>COIL NO</th>
                <th>S1</th>
                <th>S2</th>
                <th>THICK</th>
                <th>PR</th>
                <th>MILL LINE</th>
                <th>GRADE</th>
                <th>PIPE LENGTH</th>
                <th>T_WEIGHT</th>
                <th>ACT_WEIGHT</th>
                <th>ROUTING POS</th>
            </tr>
            </thead>
            <tbody>

            <!-- Note: $wipArray is 3 keys deep.-->
            @foreach($blockPipeListArray as $row)
                <tr>
                    <td>{{$row["TRACK_CODE"]}}</td>
                    <td>{{$row["TRACK_CODE_ALT"]}}</td>
                    <td>{{$row["BLOCK_NO"]}}</td>
                    <td>{{$row["ROLL_WEEK"]}}</td>
                    <td>{{$row["CAST_NO"]}}</td>
                    <td>{{$row["COIL_NO"]}}</td>
                    <td>{{$row["PIPE_SIZE1"]}}</td>
                    <td>{{$row["PIPE_SIZE2"]}}</td>
                    <td>{{$row["PIPE_THICK"]}}</td>
                    <td>{{$row["PROCESS_ROUTE"]}}</td>
                    <td>{{$row["MILL_LINE"]}}</td>
                    <td>{{$row["PIPE_GRADE"]}}</td>
                    <td>{{$row["PIPE_LENGTH"]}}</td>
                    <td>{{$row["T_WEIGHT"]}}</td>
                    <td>{{$row["ACTUAL_WEIGHT"]}}</td>
                    <td>{{$row["ROUTING_POS"]}}</td>
                </tr>
            @endforeach


            </tbody>
            <tfoot>
            <th>PIPE ID</th>
            <th>SECTION ID</th>
            <th>BLOCK</th>
            <th>ROLL WEEK</th>
            <th>CAST NO</th>
            <th>COIL NO</th>
            <th>S1</th>
            <th>S2</th>
            <th>THICK</th>
            <th>PR</th>
            <th>MILL LINE</th>
            <th>GRADE</th>
            <th>PIPE LENGTH</th>
            <th>T_WEIGHT</th>
            <th>ACT_WEIGHT</th>
            <th>ROUTING POS</th>
            </tfoot>
        </table>


{{--    </div>--}}



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
    <script src="{{ asset('public/js/FormValueObjectMap.js')}}"></script>
    <script src="{{ asset('public/libraries/sweetalert/swal.js')}}"></script>



    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#blockSelectForm').submit(function(e){
            e.preventDefault();
            let blockNo = $('#blockNo').val();
            window.location.href = rootUrl + "/order-tracking/block-pipe-list-view?BLOCK_NO=" + blockNo;
        });

        /**
         * Datatable intialization and config.
         */

        var table = $('#pipeList-tbl').DataTable({
            dom: 'Bfrtip',
            buttons: ['print', 'excel'],
            "order": [[0, "asc"]],
            "scrollX": true,
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


    </script>

@endsection
