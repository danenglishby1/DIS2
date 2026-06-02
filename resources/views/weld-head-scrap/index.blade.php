@extends('layouts.app')

@section('pageTitle', 'QR WM715')
@section('pageName', 'All QR WM715')
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
                dom: 'Bfrtip',
                "order": [[6, "DESC"]],
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
{{--                @include('layouts.templates.daterangepicker')--}}
{{--                <div style="width: 100px;margin-top: 5px;">--}}
{{--                    <a id="exportDataLink"  href="#">Export CSV</a>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('weld-head-scrap.create')}}" class="btn btn-primary mb-2">Create New</a>

            <table id="macro-table" class="table table-striped">
                <thead>
                <th>Week No</th>
                <th>Date No</th>
                <th>Area</th>
                <th>Coil</th>
                <th>Quality</th>
                <th>Front End Scrap (m)</th>
                <th>Rear End Scrap (m)</th>
                <th>Front End Comment</th>
                <th>Rear End Comment</th>
                <th>Operator/User</th>
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($weldHeadScrapData as $data)
                    <tr>
                        <td>{{$data->created_at}}</td>
                        <td>{{$data->created_at}}</td>
                        <td>{{$data->area}}</td>
                        <td>{{$data->coil_no}}</td>
                        <td>{{$data->quality}}</td>
                        <td>{{$data->front_end_scrap}}</td>
                        <td>{{$data->rear_end_scrap}}</td>
                        <td>{{$data->front_end_comments}}</td>
                        <td>{{$data->rear_end_comments}}</td>
                        <td>{{$data->user->name}}</td>

                        <td>
                            <div style="display: flex;">
                                <a href="{{ route('weld-head-scrap.show',$data->id)}}" class="btn btn-primary m-1">View</a>
                                <a href="{{ route('weld-head-scrap.edit',$data->id)}}" class="btn btn-warning m-1">Edit</a>
                                <form method="post" class="delete-form"
                                      action="{{ route('weld-head-scrap.destroy', $data->id)}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-1" type="submit">Delete</button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <th>Week No</th>
                <th>Date No</th>
                <th>Area</th>
                <th>Coil</th>
                <th>Quality</th>
                <th>Front End Scrap (m)</th>
                <th>Rear End Scrap (m)</th>
                <th>Front End Comment</th>
                <th>Rear End Comment</th>
                <th>Operator/User</th>
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

                var table = $('#macro-table').DataTable({
                    dom: 'Bfrtip',
                    // buttons: ['print', 'excel'],
                     "order": [6, "desc"],

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

                var swerveLookupTable = ["Straight Line","Swerved South","Angled South","Swerved North","Angled North","Dog Leg","Sound Weld","Low Divs"];
            console.info(swerveLookupTable);
                var crsfToken = "{{@csrf_token()}}";
            var tablesRows = "";
            for (const [key, value] of Object.entries(data)) {
            // console.log(key, value);
            tablesRows += "<tr>" +

                "<td>" + (data[key].WEEK_YEAR !== null ? data[key].WEEK_YEAR.padStart(2, "0") : "") + (data[key].COIL !== null ? data[key].COIL.toString().padStart(3, "0") : "") + (data[key].PIPE !== null ? data[key].PIPE.toString().padStart(2, "0") : "") + "</td>" +
                "<td>" + data[key].DIAM_RANGE + "</td>" +
                "<td>" + data[key].THK + "</td>" +
                "<td>" + swerveLookupTable[data[key].SWERVE] + "</td>" +
                // "<td>" + data[key].SWERVE + "</td>" +
                "<td>" + data[key].QUALITY + "</td>" +
                "<td>" + (data[key].COMMENT == null ? "" : data[key].COMMENT) + "</td>" +
                "<td>" + data[key].CREATED_AT + "</td>" +
                "<td>" + (data[key].IMAGE !== "" ? "<a target='_blank' href='" +rootUrl + "/public/storage/macros/"+ data[key].IMAGE + "'><img style='width:100px; height: 50px;' src='" +rootUrl + "/public/storage/macros/"+ data[key].IMAGE + "'/></a>" : "") + "</td>"+
                "<td>" +
                "  <div style='display: flex;'>" +
                "  <a href='"+rootUrl+"/wm-macros/"+data[key].id+"' class='btn btn-primary m-1'>View</a>" +
                "  <a href='"+rootUrl+"/wm-macros/"+data[key].id+"/edit' class='btn btn-warning m-1'>Edit</a>" +
                "<form method='post' class='delete-form' action='"+rootUrl+"/wm-macros/"+data[key].id+"'>" +
                "  <input type='hidden' name='_token' value='"+crsfToken+"'> " +
                "<input type='hidden' name='_method' value='DELETE'> " +
                "<button class='btn btn-danger m-1' type='submit'>Delete</button>" +
                "                                </form>" +
                "                            </div>" +
                "</td>"+
                "</tr>";

            }

            return tablesRows;
            }
</script>



    <script>
    $('#exportDataLink').click(function(e) {
        console.log(window.dtFrom);
        window.location.href = rootUrl + "/api/exportMacroDataToCSV?dtFrom=" + window.dtFrom + "&dtTo=" + window.dtTo;
        $('.ajax-loader').css('display', 'none');
    });
    </script>

@endsection
