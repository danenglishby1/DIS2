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
            <a href="{{ route('usr.create')}}" class="btn btn-primary mb-2">Create New</a>

            <table id="macro-table" class="table table-striped">
                <thead>
                <th>Week</th>
                <th>Coil</th>
                <th>Pipe</th>
                <th>Diameter</th>
                <th>Thick</th>
                <th>Grade</th>
                <th>Quality</th>
                <th>Cast</th>
                <th>OriginCountry</th>
                <th>OriginCompany</th>
                <th>Location</th>
                <th>Defect</th>
                <th>Comments</th>
                <th>Created</th>
{{--                <th>Image</th>--}}
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($usrs as $usr)
                    <tr>
                        <td>{{$usr->week}}</td>
                        <td>{{$usr->coil}}</td>
                        <td>{{$usr->pipe}}</td>
                        <td>{{$usr->diameter}}</td>
                        <td>{{$usr->thick}}</td>
                        <td>{{$usr->grade}}</td>
                        <td>{{$usr->quality}}</td>
                        <td>{{$usr->cast_no}}</td>
                        <td>{{(!isset($supdetfLookup[substr($usr->cast_no, 0, 2)]["country"]) ? "" : $supdetfLookup[substr($usr->cast_no, 0, 2)]["country"])}}</td>
                        <td>{{(!isset($supdetfLookup[substr($usr->cast_no, 0, 2)]["supplier_desc"]) ? "" : $supdetfLookup[substr($usr->cast_no, 0, 2)]["supplier_desc"])}}</td>

                        <td>{{$usr->location}}</td>
                        <td>{{$usr->defect}}</td>
                        <td>{{$usr->comments}}</td>
                        <td>{{$usr->created_at}}</td>

                        <td>
                            <div style="display: flex;">

                                <a href="{{ route('usr-files.create',["id" => $usr->id])}}" class="btn btn-success m-1">Add
                                    Images</a>
                                <a href="{{ route('usr.show',$usr->id)}}" class="btn btn-primary m-1">View</a>
                                {{--                                $userId == R.Butler || $userId == LABS || $userId == D.E    --}}
                                @if($userId == 47 || $userId == 56 || $userId == 4 || $userId == 40)
                                    <a href="{{ route('usr.edit',$usr->id)}}" class="btn btn-warning m-1">Edit</a>

                                    <form method="post" class="delete-form"
                                          action="{{ route('usr.destroy', $usr->id)}}">
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
                <th>Week</th>
                <th>Coil</th>
                <th>Pipe</th>
                <th>Diameter</th>
                <th>Thick</th>
                <th>Grade</th>
                <th>Cast</th>
                <th>OriginCountry</th>
                <th>OriginCompany</th>
                <th>Quality</th>
                <th>Location</th>
                <th>Defect</th>
                <th>Comments</th>
                <th>Created</th>
                {{--                <th>Image</th>--}}
                <th>Actions</th>
                </tfoot>
            </table>
            <div>
            </div>
        </div>
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
                        <!-- Extension scripts for datatables print functionality -->
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
                     buttons: ['print', 'excel'],
                    "order": [13, "desc"],

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

                    console.log(data);
                    console.log(data.supdetfLookup);



                    var crsfToken = "{{@csrf_token()}}";
                    var tablesRows = "";
                    for (const [key, value] of Object.entries(data.usrs)) {
                        // console.log(key, value);
                        // console.log(value.cast_no.substring(0,2));

                        tablesRows += "<tr>" +

                            "<td>" + value.week + "</td>" +
                            "<td>" + value.coil + "</td>" +
                            "<td>" + value.pipe + "</td>" +
                            "<td>" + value.diameter + "</td>" +
                            "<td>" + value.thick + "</td>" +
                            "<td>" + value.grade + "</td>" +
                            "<td>" + value.quality + "</td>" +
                            "<td>" + value.cast_no + "</td>" +
                            "<td>" + (value.cast_no == "" ? "" : (data.supdetfLookup[value.cast_no.substring(0,2)] != undefined ? data.supdetfLookup[value.cast_no.substring(0,2)].country : "")) + "</td>" +
                            "<td>" + (value.cast_no == "" ? "" : (data.supdetfLookup[value.cast_no.substring(0,2)] != undefined ? data.supdetfLookup[value.cast_no.substring(0,2)].supplier_desc : "")) + "</td>" +
                            "<td>" + (value.cast_no == "" ? "" : (data.supdetfLookup[value.cast_no.substring(0,2)] != undefined ? data.supdetfLookup[value.cast_no.substring(0,2)].location : "")) + "</td>" +
                            "<td>" + value.defect + "</td>" +
                            "<td>" + (value.comments == null ? "" : value.comments) + "</td>" +
                            "<td>" + value.created_at + "</td>" +
                            "<td>" +
                            "  <div style='display: flex;'>" +
                            "  <a href='" + rootUrl + "/usr-files/create?id=" + value.id + "' class='btn btn-success m-1'>Add Images</a>" +

                            "  <a href='" + rootUrl + "/usr/" + value.id + "' class='btn btn-primary m-1'>View</a>" +
                            "  <a href='" + rootUrl + "/usr/" + value.id + "/edit' class='btn btn-warning m-1'>Edit</a>" +
                            "<form method='post' class='delete-form' action='" + rootUrl + "/usr/" + value.id + "'>" +
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
