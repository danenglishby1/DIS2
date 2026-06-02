@extends('layouts.app')

@section('pageTitle', 'Scrap / DGs Pipe List')
@section('pageName', 'Scrap / DGs Pipe List')
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


    <div class="simpleflex justify-content-center">
        <div class="btn-flex mt-2 text-center">
            @section('overrideStartEndDate')
                start = moment().startOf('week');
                end = moment().endOf('week');

                window.dtFrom = start.format('Y-MM-DD 00:00:01');
                window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.
            @endsection
            @section('dateRangePickerOnApplyCallback')

                $.ajax({
                type: 'POST',
                data: {'dtFrom': dtFrom, 'dtTo': dtTo},
                url: rootUrl + '/api/GetScrapDGPipeList',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner anddefault to inline-block.
                $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {
                console.log(data);

                window.dtFrom = dtFrom;
                window.dtTo = dtTo;

                // Clear table object before creating new instance.
                table.destroy();
                // Build up HTML with BuildNewRows() function
                var newRows = BuildNewRows(data.data);
                // empty table.
                $('#pipeList').find('tbody').empty();
                // append new rows from api.
                $('#pipeList').find('tbody').append(newRows);

                // re initiate data table.
                table = $('#pipeList').DataTable({
                "pageLength": 10,
                dom: 'Bfrtip',
                "order": [[1, "DESC"]],
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

                },
                complete: function () {
                $('.ajax-loader').css('display', 'none');
                }
                });

            @endsection
            <div class="filters">
                @include('layouts.templates.daterangepicker')

            </div>
        </div>
    </div>


    <!-- Content Row -->


    <hr/>
    <div class="simpleflex">
        <div class="fl1">

            <table id="pipeList" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>DEPT</th>
                    <th>FROM_ROUTING_POS</th>
                    <th>LENGTH</th>
                    <th>DATE_TIME</th>
                    <th>DAY_NO</th>
                    <th>PIPE</th>
                    <th>SECTION</th>
                    <th>S1</th>
                    <th>S2</th>
                    <th>THICK</th>
                    <th>PR</th>
                    <th>WEIGHT</th>
                    <th>STATUS_CODE</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>DEPT</th>
                    <th>FROM_ROUTING_POS</th>
                    <th>LENGTH</th>
                    <th>DATE_TIME</th>
                    <th>DAY_NO</th>
                    <th>PIPE</th>
                    <th>SECTION</th>
                    <th>S1</th>
                    <th>S2</th>
                    <th>THICK</th>
                    <th>PR</th>
                    <th>WEIGHT</th>
                    <th>STATUS_CODE</th>
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
            $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
            table = $('#pipeList').DataTable({
                order: [[3, "desc"]],
                dom: 'Bfrtip',
                buttons: ['print', 'excel'],
                ajax: rootUrl + '/api/GetScrapDGPipeList',
                columns: [
                    {"data": "DEPT"},
                    {"data": "FROM_ROUTING_POS"},
                    {"data": "PIPE_LENGTH"},
                    {"data": "DATETIME_TANDEM"},
                    {"data": "DAY_NO"},
                    {"data": "TRACK_CODE"},
                    {"data": "TRACK_CODE_ALT"},
                    {"data": "PIPE_SIZE1"},
                    {"data": "PIPE_SIZE2"},
                    {"data": "PIPE_THICK"},
                    {"data": "PROCESS_ROUTE"},
                    {"data": "T_WEIGHT"},
                    {"data": "PIPE_STATUS_CODE"},
                ],

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

        var table = $('#annealer-pre-start-checks-table').DataTable({
            dom: 'Bfrtip',
            // buttons: ['print', 'excel'],
            "order": [5, "desc"],

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

    <script>
        function BuildNewRows(data) {
            var crsfToken = "{{@csrf_token()}}";
            var tablesRows = "";
            for (const [key, value] of Object.entries(data)) {
                // console.log(key, value);
                tablesRows += "<tr>" +

                    "<td>" + data[key].DEPT + "</td>" +
                    "<td>" + data[key].FROM_ROUTING_POS + "</td>" +
                    "<td>" + data[key].PIPE_LENGTH + "</td>" +
                    "<td>" + data[key].DATETIME_TANDEM + "</td>" +
                    "<td>" + data[key].DAY_NO + "</td>" +
                    "<td>" + data[key].TRACK_CODE + "</td>" +
                    "<td>" + data[key].TRACK_CODE_ALT + "</td>" +
                    "<td>" + data[key].PIPE_SIZE1 + "</td>" +
                    "<td>" + data[key].PIPE_SIZE2 + "</td>" +
                    "<td>" + data[key].PIPE_THICK + "</td>" +
                    "<td>" + data[key].PROCESS_ROUTE + "</td>" +
                    "<td>" + data[key].T_WEIGHT + "</td>" +
                    "<td>" + data[key].PIPE_STATUS_CODE + "</td>" +
                    "</tr>";

            }

            return tablesRows;
        }
    </script>

@endsection
