@extends('layouts.app')

@section('pageTitle', 'WM Stoppage Comment Add')
@section('pageName', 'WM Stoppage Comment Add')
@section('weldMillActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/dygraphs/dygraph.min.css')}}"/>

    <style>
        .dyGraphAnnotation {
            background: #ececec;
            border: 1px solid #cccccc;
            border-radius: 2px;
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
                url: rootUrl + '/api/GetWeldMillStoppageCommentAdderData',
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
                var newRows = BuildNewRows(data);
                // empty table.
                $('#stoppage-table').find('tbody').empty();
                // append new rows from api.
                $('#stoppage-table').find('tbody').append(newRows);

                // re initiate data table.
                table = $('#stoppage-table').DataTable({
                "pageLength": 10,
                dom: 'Bfrtip',
                "order": [[0, "DESC"]],
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
    <div class="row">
        <div class="col-sm-12">

            <table id="stoppage-table" class="table table-striped">
                <thead>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Stop Type</th>
                <th>Area</th>
                <th>Stop Description</th>
                <th>Stop Reason</th>
                <th>Mins Stopped</th>
                <th>Stop Coil</th>
                <th>Stop Comment</th>
                <th>Add Comment</th>

                </thead>
                <tbody>
                @foreach($stoppageData as $data)
                    <tr>
                    <td>{{$data["START_DATETIME"]}}</td>
                    <td>{{$data["END_DATETIME"]}}</td>
                    <td>{{$data["STOP_STOP_TYPE"]}}</td>
                    <td>{{$data["AREA_DESCRIPTION"]}}</td>
                    <td>{{$data["STOP_TYPE_DESCRIPTION"]}}</td>
                    <td>{{$data["STCO_STOP_REASON"]}}</td>
                    <td>{{$data["MINS_STOPPED"]}}</td>
                    <td>{{$data["STOP_COIL"]}}</td>
{{--                    <td>{{(isset($weldMillStopComments[$data["START_DATETIME"]."_".$data["STOP_STOP_TYPE"]]) ? "jfsdkjfnsjkdn" : "")}}</td>--}}
                    <td>{{(isset($weldMillStopComments[$data["STOP_STOP_TYPE"]."_".$data["START_DATETIME"]]) ? $weldMillStopComments[$data["STOP_STOP_TYPE"]."_".$data["START_DATETIME"]]["comment"] : "")}}</td>
                    <td><a  data-toggle="modal" data-target="#myModal" class="btn btn-primary" style="color:#fff" data-datetimestart="{{$data["START_DATETIME"]}}" data-stoptype="{{$data["STOP_STOP_TYPE"]}}" href="{{$data["START_DATETIME"]."_".$data["STOP_STOP_TYPE"]}}">Add Comment</a> </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Stop Type</th>
                <th>Area</th>
                <th>Stop Description</th>
                <th>Stop Reason</th>
                <th>Mins Stopped</th>
                <th>Stop Comment</th>
                <th>Stop Coil</th>

                </tfoot>
            </table>
            <div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                                            <div class="modal-body">
                                                Stop Comments:
                                <textarea class="form-control" name="comments" id="comments"></textarea>
                                            </div>
                        <div class="modal-footer" id="actionButtons">

                        </div>
                    </form>
                </div>
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

                $("#myModal").on("shown.bs.modal", function (e) {

                    console.log("opened");
                    //get data-id attribute of the clicked element
                    var datetimeStart = $(e.relatedTarget).data('datetimestart').toString();
                    var stopType = $(e.relatedTarget).data('stoptype').toString();

                    console.log(datetimeStart);
                    console.log(stopType);


                    $('#modalTitle').html("Start Time : <span class='datetimeStart'>" + datetimeStart +"</span>" +
                        "<span> Stop Type:</span>  <span class='stopType'>" + stopType + "</span>");

                    // // This line helps to make sure the checkmark goes back to where it belongs
                    // $(window).resize();

                    $('#actionButtons').html('<a href="#key='+datetimeStart+'_'+stopType+'"><button type="button" id="addComment" class="btn btn-warning">Add Comment</button></a>');
                });

                $("#myModal").on("hide.bs.modal", function() {

                });

                $( "#actionButtons").delegate( "#addComment", "click", function() {


                    let modalTitleSelector = $(this).parent().parent().parent().find('.modal-header').find('.modal-title');
                    console.log(modalTitleSelector);
                    let datetimeStart = modalTitleSelector.find('.datetimeStart').html();
                    let stopType = modalTitleSelector.find('.stopType').html();
                    let comments = $('#comments').val();



                    console.log(datetimeStart);
                    console.log(stopType);
                    console.log(comments);
                    $.ajax({
                        type: 'POST',
                        data: {"key": stopType+"_"+datetimeStart, "comments": comments},
                        url: rootUrl + '/api/AddWeldMillStoppageComment',
                        async: false,
                        dataType: 'json',
                        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                            $('.ajax-loader').css('display', 'block');
                        },
                        success: function (data) {
                            console.log(data);

                            if (data.success) {
                                Swal.fire(
                                    'Updated!',
                                    'Record has been updated.',
                                    'success'
                                )
                                $('#myModal').modal('toggle');

                            }

                        },
                        complete: function () {
                            $('.ajax-loader').css('display', 'none');
                        }
                    });
                    console.log("actionButtonClicked To Submit");
                });


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

                var table = $('#stoppage-table').DataTable({
                    dom: 'Bfrtip',
                    // buttons: ['print', 'excel'],
                    "order": [0, "desc"],

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
                    var crsfToken = "{{@csrf_token()}}";
                    var tablesRows = "";
                    for (const [key, value] of Object.entries(data)) {
                         console.log(key, value);
                        // console.log(data[key].STOP_COMMENTS["comment"] );

                        tablesRows += "<tr>" +

                            "<td>" + data[key].START_DATETIME  + "</td>" +
                            "<td>" + data[key].END_DATETIME  + "</td>" +
                            "<td>" + data[key].STOP_STOP_TYPE  + "</td>" +
                            "<td>" + data[key].AREA_DESCRIPTION  + "</td>" +
                            "<td>" + data[key].STOP_TYPE_DESCRIPTION  + "</td>" +
                            "<td>" + data[key].STCO_STOP_REASON  + "</td>" +
                            "<td>" + data[key].MINS_STOPPED  + "</td>" +
                            "<td>" + data[key].STOP_COIL  + "</td>" +
                            "<td>" + data[key].STOP_CUSTOM_COMMENTS  + "</td>" +
                            "<td><a  data-toggle='modal' data-target='#myModal' class='btn btn-primary' style='color:#fff' data-datetimestart='"+data[key].START_DATETIME+"' data-stoptype='"+data[key].STOP_STOP_TYPE+"' >Add Comment</a></td>" +

                            // "  <div style='display: flex;'>" +
                            // "  <a href='"+rootUrl+"/wm-macros/"+data[key].id+"' class='btn btn-primary m-1'>View</a>" +
                            // "  <a href='"+rootUrl+"/wm-macros/"+data[key].id+"/edit' class='btn btn-warning m-1'>Edit</a>" +
                            // "<form method='post' class='delete-form' action='"+rootUrl+"/wm-macros/"+data[key].id+"'>" +
                            // "  <input type='hidden' name='_token' value='"+crsfToken+"'> " +
                            // "<input type='hidden' name='_method' value='DELETE'> " +
                            // "<button class='btn btn-danger m-1' type='submit'>Delete</button>" +
                            // "                                </form>" +
                            // "                            </div>" +
                            // "</td>"+
                            "</tr>";

                    }
                    {{--/**--}}
                    {{-- --}}{{--<td>{{(isset($weldMillStopComments[$data["START_DATETIME"]."_".$data["STOP_STOP_TYPE"]]) ? "jfsdkjfnsjkdn" : "")}}</td>--}}
                    {{--<td>{{(isset($weldMillStopComments[$data["STOP_STOP_TYPE"]."_".$data["START_DATETIME"]]) ? $weldMillStopComments[$data["STOP_STOP_TYPE"]."_".$data["START_DATETIME"]]["comment"] : "")}}</td>--}}
                    {{-- <td><a  data-toggle="modal" data-target="#myModal" class="btn btn-primary" style="color:#fff" data-datetimestart="{{$data["START_DATETIME"]}}" data-stoptype="{{$data["STOP_STOP_TYPE"]}}" href="{{$data["START_DATETIME"]."_".$data["STOP_STOP_TYPE"]}}">Add Comment</a> </td>--}}
                    {{-- </tr>--}}
                    {{-- *--}}
                    {{-- *--}}
                    {{-- */--}}

                    return tablesRows;
                }
            </script>



{{--            <script>--}}
{{--                $('#exportDataLink').click(function(e) {--}}
{{--                    console.log(window.dtFrom);--}}
{{--                    window.location.href = rootUrl + "/api/exportMacroDataToCSV?dtFrom=" + window.dtFrom + "&dtTo=" + window.dtTo;--}}
{{--                    $('.ajax-loader').css('display', 'none');--}}
{{--                });--}}
{{--            </script>--}}

@endsection
