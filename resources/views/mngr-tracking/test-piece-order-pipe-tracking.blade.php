@extends('layouts.app')

@section('pageTitle', '')
@section('pageName', '')
@section('millTrackingActiveLink', 'active activeUnderline')
@section('css')
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    {{--    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>--}}
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


    <hr/>
    <div class="simpleflex">
        <div class="fl1">

            <table id="pipeList" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>PIPE</th>
                    <th>SECTION</th>
                    <th>S1</th>
                    <th>S2</th>
                    <th>THICK</th>
                    <th>BLOCK</th>
                    <th>ROLL WEEK</th>
                    <th>CAST</th>
                    <th>ORDER</th>
                    <th>ITEM</th>
                    <th>TPIECE NO</th>
                    <th>TPIECE YR</th>
                    <th>TPIECE TYPE</th>
                    <th>TPIECE POS</th>
                    <th>ORDER POS</th>
                    <th>LAST UPDATED</th>

                </tr>
                </thead>
                <tbody>

                @foreach($dataArray as $d)
                    <tr>
                    <td>{{$d["TRACK_CODE"]}}</td>
                    <td>{{$d["TRACK_CODE_ALT"]}}</td>
                    <td>{{$d["PIPE_SIZE1"]}}</td>
                    <td>{{$d["PIPE_SIZE2"]}}</td>
                    <td>{{$d["PIPE_THICK"]}}</td>
                    <td>{{$d["BLOCK_NO"]}}</td>
                    <td>{{$d["ROLL_WEEK"]}}</td>
                    <td>{{$d["CAST_NO"]}}</td>
                    <td>{{$d["CUST_ORDER"]}}</td>
                    <td>{{$d["CUST_ITEM_X"]}}</td>
                    <td>{{$d["TEST_PIECE_NO"]}}</td>
                    <td>{{$d["TEST_PIECE_YEAR"]}}</td>
                    <td>{{$d["TEST_PIECE_TYPE"]}}</td>
                    <td>{{$d["TEST_PIECE_STATUS"]}}</td>
                    <td>{{$d["ORDER_POS"]}}</td>
                    <td>{{$d["LAST_UPDATE_DATETIME"]}}</td>
                    </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th>PIPE</th>
                    <th>SECTION</th>
                    <th>S1</th>
                    <th>S2</th>
                    <th>THICK</th>
                    <th>BLOCK</th>
                    <th>ROLL WEEK</th>
                    <th>CAST</th>
                    <th>ORDER</th>
                    <th>ITEM</th>
                    <th>TPIECE NO</th>
                    <th>TPIECE YR</th>
                    <th>TPIECE POS</th>
                    <th>TPIECE TYPE</th>
                    <th>ORDER POS</th>
                    <th>LAST UPDATED</th>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>

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
    {{--    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>--}}
    {{--    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>--}}
    {{--    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>--}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = null;
        /**
         * Datatable intialization and config.
         */
        $(document).ready(function () {
            table = $('#pipeList').DataTable({
                order: [[14, "desc"]],
                dom: 'Bfrtip',
                buttons: ['print', 'excel'],
                initComplete: function () {
                    $('.ajax-loader').css("display", "none");

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


        /**
         * Add ajax header for CSRF Token
         * */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /**
         * Datatable intialization and config.
         */
    </script>

@endsection
