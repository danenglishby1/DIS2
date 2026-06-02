@extends('layouts.app')

@section('pageTitle', 'Ultrasonic Rejects')
@section('pageName', 'All Ultrasonic Rejects')
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
                start = moment().startOf('month');
                end = moment().endOf('month');

                window.dtFrom = start.format('Y-MM-DD 00:00:01');
                window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.
            @endsection
            @section('dateRangePickerOnApplyCallback')

                $.ajax({
                type: 'POST',
                data: {'dtFrom': dtFrom, 'dtTo': dtTo},
                url: rootUrl + '/api/GetUsrData',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and
            //    default to inline-block.
                $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {
                console.log(data);

                window.dtFrom = dtFrom;
                window.dtTo = dtTo;

                    // Clear table object before creating new instance.
                    table.destroy();
                    // Build up HTML with BuildNewRows() function
                    var newRows = BuildNewRows(data);
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
{{--                <div style="width: 100px;margin-top: 5px;">--}}
{{--                    <a id="exportDataLink" href="#">Export CSV</a>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <a href="{{ route('wm-shift-log.create')}}" class="btn btn-primary mb-2">Create New</a>

            <table id="macro-table" class="table table-striped">
                <thead>
                <th>Date</th>
                <th>Shift</th>
                <th>Submitted By</th>
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($wmShiftLogs as $shiftLog)
                    <tr>
                        <td>{{$shiftLog->created_at}}</td>
                        <td>{{$shiftLog->shift_pattern}}</td>
                        <td>{{$shiftLog->team_leader}}</td>
                        <td>
                            <div style="display: flex;">

                                <a href="{{ route('wm-shift-log.show',$shiftLog->id)}}" class="btn btn-primary m-1">View</a>
                                {{--                                $userId == R.Butler || $userId == LABS || $userId == D.E    --}}
                                @if($userId == 47 || $userId == 56 || $userId == 4 || $userId == 40)
                                    <a href="{{ route('wm-shift-log.edit',$shiftLog->id)}}" class="btn btn-warning m-1">Edit</a>

                                    <form method="post" class="delete-form"
                                          action="{{ route('wm-shift-log.destroy', $shiftLog->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger m-1" type="submit">Delete</button>
                                    </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <th>Date</th>
                <th>Shift</th>
                <th>Submitted By</th>
                <th>Actions</th>
                </tfoot>
            </table>
            <div>


            <script>
                $('#exportDataLink').click(function (e) {
                    console.log(window.dtFrom);
                    window.location.href = rootUrl + "/api/exportMacroDataToCSV?dtFrom=" + window.dtFrom + "&dtTo=" + window.dtTo;
                    $('.ajax-loader').css('display', 'none');
                });
            </script>

@endsection
