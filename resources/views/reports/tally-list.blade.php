@extends('layouts.app')

@section('pageTitle', 'Tally List')
@section('pageName', 'Tally List')
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
        <form id="orderItemSelectForm">
        <select class="form-control" id="orderItem" name="orderItem">
            @foreach($orderItemArray as $orderItem)
            <option value="{{$orderItem["ORDER_ITEM"]}}" {{($orderItem["ORDER_ITEM"] == $selectedOrderItem ? "selected" : "" )}}  >{{$orderItem["ORDER_ITEM"]}}</option>
            @endforeach
        </select>

        <button class="btn btn-primary mt-2" type="submit">Get Tally List</button>
        </form>
    </div>

<hr class="mb-4" />




    <div>
        <table id="tallylist-tbl" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>CONSEC NO</th>
                <th>PIPE ID</th>
                <th>SECTION ID</th>
                <th>CAST NO</th>
                <th>COIL NO</th>
                <th>PIPE LENGTH</th>
                <th>T_WEIGHT</th>
                <th>ACT_WEIGHT</th>
                <th>ORDER POS</th>
            </tr>
            </thead>
            <tbody>

            <!-- Note: $wipArray is 3 keys deep.-->
            @foreach($tallyListArray as $row)
                <tr>
                    <td>{{$row["CONSEC_NO"]}}</td>
                    <td>{{$row["TRACK_CODE"]}}</td>
                    <td>{{$row["TRACK_CODE_ALT"]}}</td>
                    <td>{{$row["CAST_NO"]}}</td>
                    <td>{{$row["COIL_NO"]}}</td>
                    <td>{{$row["PIPE_LENGTH"]}}</td>
                    <td>{{$row["T_WEIGHT"]}}</td>
                    <td>{{$row["ACTUAL_WEIGHT"]}}</td>
                    <td>{{$row["ORDER_POS"]}}</td>
                </tr>
            @endforeach


            </tbody>
            <tfoot>
            <th>CONSEC NO</th>
            <th>PIPE ID</th>
            <th>SECTION ID</th>
            <th>CAST NO</th>
            <th>COIL NO</th>
            <th>PIPE LENGTH</th>
            <th>T_WEIGHT</th>
            <th>ACT_WEIGHT</th>
            <th>ORDER POS</th>
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
        $('#orderItemSelectForm').submit(function(e){
            e.preventDefault();
            let selectedOrder = $('#orderItem').val();
            window.location.href = rootUrl + "/reports/tally-list?ORDER_ITEM=" + selectedOrder;
        });

        /**
         * Datatable intialization and config.
         */

        var table = $('#tallylist-tbl').DataTable({
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
