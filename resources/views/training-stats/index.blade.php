@extends('layouts.app')

@section('pageTitle', 'Training Stats')
@section('pageName', 'Training Stats')
@section('weldMillActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <style>
        select {
            max-width: 500px !important;
        }
    </style>

@endsection
@section('content')
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
                url: rootUrl + '/api/GetMacroData',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and
                default to inline-block.
                $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {
                console.log(data);

                window.dtFrom = dtFrom;
                window.dtTo = dtTo;

                // Clear table object before creating new instance.
                table.destroy();
                // Build up HTML with BuildNewRows() function
                var newRows = BuildNewRows(data.macroData);
                // empty table.
                $('#macro-table').find('tbody').empty();
                // append new rows from api.
                $('#macro-table').find('tbody').append(newRows);

                // re initiate data table.
                table = $('#macro-table').DataTable({
                "pageLength": 10,
                dom: 'Bfrtip',
                "order": [[1, "DESC"]],
                initComplete: function () {
                this.api().columns().every(function () {
                var column = this;
                var select = $('<select>
                    <option value=""></option>
                </select>')
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
                select.append('
                <option value="' + d + '">' + d + '</option>')
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
                .append('
                <option value=""/>');

                table.column(idx, {search: 'applied'}).data().unique().sort().each(function (d, j) {
                select.append('
                <option value="' + d + '">' + d + '</option>');
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
{{--            <div class="filters">--}}
{{--                @include('layouts.templates.daterangepicker')--}}
{{--                <div style="width: 100px;margin-top: 5px;">--}}
{{--                    <a id="exportDataLink" href="#">Export CSV</a>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table id="training-stats-table" class="table table-striped">
                <thead>
                <th>Type</th>
                <th>Department</th>
                <th>No. Learning Paths Assigned</th>
                <th>No. Learning Paths Completed</th>
                <th>Age Competent Percent</th>
                <th>Updated At</th>
                </thead>
                <tbody>

                    @foreach($trainingStats as $stats)
                        <tr>
                            <td>{{$stats["type"]}}</td>
                            <td>{{$stats["dept"]}}</td>
                            <td>{{$stats["no_learning_paths_assigned"]}}</td>
                            <td>{{$stats["no_learning_paths_completed"]}}</td>
                            <td>{{$stats["age_competent_percent"]}}</td>
                            <td>{{$stats["updated_date"]}}</td>
                        </tr>
                    @endforeach


                </tbody>
                <tfoot>
                <th>Type</th>
                <th>Department</th>
                <th>No. Learning Paths Assigned</th>
                <th>No. Learning Paths Completed</th>
                <th>Age Competent Percent</th>
                <th>Updated At</th>
                </tfoot>
            </table>
            <div>
            </div>
        </div>
        @endsection
        @section('functionalScripts')


            <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
            <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
            {{--            <!-- Extension scripts for datatables print functionality -->--}}
            {{--            <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>--}}
            {{--            <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>--}}
            {{--            <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>--}}
            {{--            <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>--}}

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

                var table = $('#training-stats-table').DataTable({
                    dom: 'Bfrtip',
                    // buttons: ['print', 'excel'],
                    "order": [0, "desc"],
                    "pageLength" : 100,

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

                            "<td>" + (data[key].WEEK_YEAR !== null ? data[key].WEEK_YEAR.padStart(2, "0") : "") + (data[key].COIL !== null ? data[key].COIL.toString().padStart(3, "0") : "") + (data[key].PIPE !== null ? data[key].PIPE.toString().padStart(2, "0") : "") + "</td>" +
                            "<td>" + data[key].DIAM_RANGE + "</td>" +
                            "<td>" + data[key].THK + "</td>" +
                            "<td>" + data[key].QUALITY + "</td>" +
                            "<td>" + (data[key].COMMENT == null ? "" : data[key].COMMENT) + "</td>" +
                            "<td>" + data[key].CREATED_AT + "</td>" +
                            "<td>" + (data[key].IMAGE !== "" ? "<a target='_blank' href='" + rootUrl + "/public/storage/macros/" + data[key].IMAGE + "'><img style='width:100px; height: 50px;' src='" + rootUrl + "/public/storage/macros/" + data[key].IMAGE + "'/></a>" : "") + "</td>" +
                            "<td>" +
                            "  <div style='display: flex;'>" +
                            "  <a href='" + rootUrl + "/usr/" + data[key].id + "' class='btn btn-primary m-1'>View</a>" +
                            "  <a href='" + rootUrl + "/usr/" + data[key].id + "/edit' class='btn btn-warning m-1'>Edit</a>" +
                            "<form method='post' class='delete-form' action='" + rootUrl + "/usr/" + data[key].id + "'>" +
                            "  <input type='hidden' name='_token' value='" + crsfToken + "'> " +
                            "<input type='hidden' name='_method' value='DELETE'> " +
                            "<button class='btn btn-danger m-1' type='submit'>Delete</button>" +
                            "                                </form>" +
                            "                            </div>" +
                            "</td>" +
                            "</tr>";

                    }

                    return tablesRows;
                }
            </script>



            <script>
                $('#exportDataLink').click(function (e) {
                    console.log(window.dtFrom);
                    window.location.href = rootUrl + "/api/exportMacroDataToCSV?dtFrom=" + window.dtFrom + "&dtTo=" + window.dtTo;
                    $('.ajax-loader').css('display', 'none');
                });
            </script>

@endsection
