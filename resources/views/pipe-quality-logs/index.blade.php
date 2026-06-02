@extends('layouts.app')

@section('pageTitle', 'Pipe Quality Logs')
@section('pageName', 'Pipe Quality Logs')
@section('css')
    <style>
    .dt-buttons { display: none; }
    </style>
    @endsection
@section('content')
    <div class="row" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
        <div class="col-sm-8 offset-sm-2">
            <h2 class="display-3"></h2>
            <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br/>
                @endif
                    @section('content')
                        <div class="simpleflex justify-content-center">
                            <div class="btn-flex mt-2 text-center">
                                @section('overrideStartEndDate')
                                    start = moment();
                                    end = moment();

                                    window.dtFrom = start.format('Y-MM-DD 00:00:01');
                                    window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.
                                @endsection
                                @section('dateRangePickerOnApplyCallback')

                                    $.ajax({
                                    type: 'POST',
                                    data: {'dtFrom': dtFrom, 'dtTo': dtTo},
                                    url: rootUrl + '/api/getPipeQualityLogs',
                                    dataType: 'json',
                                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
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
{{--                                    dom: 'Bfrtip',--}}
                                        "order": [16, "desc"],
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
                                    <div style="width: 100px;margin-top: 5px;">
                                        <a id="exportDataLink"  href="#">Export CSV</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
{{--                                <a href="{{ route('wm-macros.create')}}" class="btn btn-primary mb-2">Create New</a>--}}

                                <table id="macro-table" class="table table-striped">
                                    <thead>
                                    <th>Pipe</th>
                                    <th>User</th>
                                    <th>S1</th>
                                    <th>S2</th>
                                    <th>Thickness</th>
                                    <th>PR</th>
                                    <th>Quality</th>
                                    <th>Fault Diagnosis</th>
                                    <th>Position</th>
                                    <th>Response</th>
                                    <th>Status</th>
                                    <th>Area</th>
                                    <th>Comments</th>
                                    <th>Year</th>
                                    <th>Shift</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    </thead>
                                    <tbody>
                                    @foreach($pipeQualityLogs as $pipeQualityLog)
                                        <tr>
{{--                                            <td>{{str_pad($macro->WEEK_YEAR,2, "0", STR_PAD_LEFT) . str_pad($pipeQualityLog->COIL,3,"0",STR_PAD_LEFT)  . str_pad($pipeQualityLog->PIPE, 2, "0", STR_PAD_LEFT)}}</td>--}}
                                            <td>{{$pipeQualityLog->pipe_no}}</td>
                                            <td>{{$pipeQualityLog->user->name}}</td>
                                            <td>{{$pipeQualityLog->S1}}</td>
                                            <td>{{$pipeQualityLog->S2}}</td>
                                            <td>{{$pipeQualityLog->thickness}}</td>
                                            <td>{{$pipeQualityLog->PR}}</td>
                                            <td>{{$pipeQualityLog->quality}}</td>
                                            <td>{{$pipeQualityLog->fault_diagnosis}}</td>
                                            <td>{{$pipeQualityLog->position}}</td>
                                            <td>{{$pipeQualityLog->response}}</td>
                                            <td>{{$pipeQualityLog->status}}</td>
                                            <td>{{$pipeQualityLog->area}}</td>
                                            <td>{{$pipeQualityLog->comments}}</td>
                                            <td>{{$pipeQualityLog->year}}</td>
                                            <td>{{$pipeQualityLog->shift}}</td>
                                            <td>{{$pipeQualityLog->created_at}}</td>
                                            <td>{{$pipeQualityLog->updated_at}}</td>
{{--
{{--                                                <div style="display: flex;">--}}


{{--                                                    <a href="{{ route('wm-macros.show',$pipeQualityLog->id)}}" class="btn btn-primary m-1">View</a>--}}
{{--                                                    --}}{{--                                $userId == R.Butler || $userId == LABS || $userId == D.E    --}}
{{--                                                    @if($userId == 47 || $userId == 56 || $userId == 4)--}}
{{--                                                        <a href="{{ route('wm-macros.edit',$pipeQualityLog->id)}}" class="btn btn-warning m-1">Edit</a>--}}

{{--                                                        <form method="post" class="delete-form"--}}
{{--                                                              action="{{ route('wm-macros.destroy', $pipeQualityLog->id)}}">--}}
{{--                                                            @csrf--}}
{{--                                                            @method('DELETE')--}}
{{--                                                            <button class="btn btn-danger m-1" type="submit">Delete</button>--}}
{{--                                                        </form>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <th>Pipe</th>
                                    <th>User</th>
                                    <th>S1</th>
                                    <th>S2</th>
                                    <th>Thickness</th>
                                    <th>PR</th>
                                    <th>Quality</th>
                                    <th>Fault Diagnosis</th>
                                    <th>Position</th>
                                    <th>Response</th>
                                    <th>Status</th>
                                    <th>Area</th>
                                    <th>Comments</th>
                                    <th>Year</th>
                                    <th>Shift</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    </tfoot>
                                </table>
                                <div>
                                </div>
                            </div>
                            @endsection

@endsection

@section('functionalScripts')
                                <script>

                                    $('form.delete-form').one('submit', function (e) {
                                        e.preventDefault();

                                        Swal.fire({
                                            title: 'Are you sure?',
                                            text: "You won't be able to revert this!",
                                            type: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Yes, delete it!'
                                        }).then((result) => {
                                            if (result.value) {
                                                $(this).submit();
                                            }
                                        })

                                    });
                                </script>

                                <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
                                <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
                                {{--            <!-- Extension scripts for datatables print functionality -->--}}
                                            <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
                                            <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
                                            <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
                                            <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>

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

                                    var table = $('#macro-table').DataTable({
                                        dom: 'Bfrtip',
                                         // buttons: ['print', 'excel'],
                                        "order": [16, "desc"],

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
                                             console.log(key, value);
                                            tablesRows += "<tr>" +

                                                "<td>" + data[key].pipe_no + "</td>" +
                                                "<td>" + data[key].user.name + "</td>" +
                                                "<td>" + data[key].S1 + "</td>" +
                                                "<td>" + data[key].S2 + "</td>" +
                                                "<td>" + data[key].thickness +"</td>" +
                                                "<td>" + data[key].PR +"</td>" +
                                                "<td>" + data[key].quality +"</td>" +
                                                "<td>" + data[key].fault_diagnosis +"</td>" +
                                                "<td>" + data[key].position +"</td>" +
                                                "<td>" + data[key].response +"</td>" +
                                                "<td>" + data[key].status +"</td>" +
                                                "<td>" + data[key].area +"</td>" +
                                                "<td>" + data[key].comments +"</td>" +
                                                "<td>" + data[key].year +"</td>" +
                                                "<td>" + data[key]["shift"] +"</td>" +
                                                "<td>" + data[key].created_at +"</td>" +
                                                "<td>" + data[key].updated_at +"</td>" +
                                                // "<td>" + data[key].PR +"</td>" +

                                                "</tr>";

                                        }

                                        return tablesRows;
                                    }
                                </script>



                                <script>
                                    $('#exportDataLink').click(function(e) {
                                        console.log(window.dtFrom);
                                        window.location.href = rootUrl + "/api/exportPipeQualityLogDataToCSV?dtFrom=" + window.dtFrom + "&dtTo=" + window.dtTo;
                                        $('.ajax-loader').css('display', 'none');
                                    });
                                </script>

@endsection
