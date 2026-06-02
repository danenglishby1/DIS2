@extends('layouts.app')

@section('pageTitle', 'MoC')
@section('pageName', 'MoC')
@section('weldMillActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <style>
        select {
            max-width: 500px !important;
        }

        tr.isDraft {
            background-color: #ffed93 !important;
        }

        #doublescroll
        {
            overflow: auto; overflow-y: hidden;
        }
        #doublescroll p
        {
            margin: 0;
            padding: 1em;
            white-space: nowrap;
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
            <a href="{{ route('moc.create')}}" class="btn btn-primary mb-2">Create New</a>

            <div class="d-flex mt-2">
                <div style="width:40px;height: 40px;background: #ffed93;border-radius: 40px;"></div>
                <div style="margin-left: 7px;font-size: 18px; margin-top: 6px;">Draft</div>
            </div>

            <div id="doublescroll">
                <table id="macro-table" class="table table-striped">
                    <thead>
                    <th>MOC No</th>
                    <th>Dept</th>
                    <th>Change Title</th>
                    <th>Description</th>
                    <th>Risk Rating</th>
                    <th>StatusImpact</th>
                    <th>Raised By</th>
                    <th>Complete?</th>
                    <th>Authorised?</th>
                    <th>Authoriser</th>
                    <th>Date</th>
                    <th>Actions</th>
                    </thead>
                    <tbody>

                    @foreach($mocs as $moc)
                        @if($moc->is_draft == "Y")
                            @if(in_array($userId, $superUsers) || $moc->user_id == $userId)
                                <tr class="isDraft">
                            @else
                                <tr style="display:none;">
                            @endif
                        @else
                            <tr>
                                @endif
                                <td>{{$moc->id}}</td>
                                <td>{{$moc->MocDepartment->department}}</td>
                                <td>{{$moc->change_title}}</td>
                                @if(strlen($moc->change_description) > 200)
                                    <td>{{substr($moc->change_description, 0 , 200) . "......"}}</td>
                                @else
                                    <td>{{$moc->change_description}}</td>
                                @endif
                                <td>{{$moc->risk_rating}}</td>
                                <td>{{$moc->status_impact}}</td>
                                <td>{{$moc->user->name}}</td>
                                <td>{{$moc->MocCompleteStatus->status}}</td>
                                <td>{{$moc->MocAuthorisedStatus->status}}</td>
                                <td>{{$moc->MocDepartmentAuthoriser->MocAuthoriser->user->name}}</td>
                                <td>{{$moc->created_at}}</td>

                                <td>
                                    <div style="display: flex;">
                                        @if($moc->status_impact == "Significant")
                                            <a href="{{ route('show-significant')}}?id={{$moc->id}}"
                                               class="btn btn-primary m-1">View</a>

                                            @if($moc->MocDepartmentAuthoriser->MocAuthoriser->user_id == $userId || $moc->user->id == $userId || $userId == 4)
                                                <a href="{{ route('moc-edit-significant')}}?id={{$moc->id}}"
                                                   class="btn btn-warning m-1">Edit</a>
                                            @endif
                                        @else
                                            <a href="{{ route('moc.show',$moc->id)}}"
                                               class="btn btn-primary m-1">View</a>
                                            @if($moc->MocDepartmentAuthoriser->MocAuthoriser->user_id == $userId || $moc->user->id == $userId || $userId == 4)
                                                <a href="{{ route('moc.edit',$moc->id)}}"
                                                   class="btn btn-warning m-1">Edit</a>
                                            @endif
                                        @endif

                                        @if($moc->user->id == $userId || $userId == 4)
                                            <a class="btn btn-success m-1"
                                               href="{{route('moc-files.create').'?id='.$moc->id}}">Manage Files</a>

                                            <form method="post" class="delete-form"
                                                  action="{{ route('moc.destroy', $moc->id)}}">
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
                    <th>MOC No</th>
                    <th>Dept</th>
                    <th>Change Title</th>
                    <th>Description</th>
                    <th>Risk Rating</th>
                    <th>StatusImpact</th>
                    <th>RaisedBy</th>
                    <th>Complete?</th>
                    <th>Authorised?</th>
                    <th>Date</th>
                    <th>Actions</th>
                    </tfoot>
                </table>


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
                        "order": [10, "desc"],

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
                                "  <a href='" + rootUrl + "/wm-macros/" + data[key].id + "' class='btn btn-primary m-1'>View</a>" +
                                "  <a href='" + rootUrl + "/wm-macros/" + data[key].id + "/edit' class='btn btn-warning m-1'>Edit</a>" +
                                "<form method='post' class='delete-form' action='" + rootUrl + "/wm-macros/" + data[key].id + "'>" +
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
                    function DoubleScroll(element) {
                        var scrollbar = document.createElement('div');
                        scrollbar.appendChild(document.createElement('div'));
                        scrollbar.style.overflow = 'auto';
                        scrollbar.style.overflowY = 'hidden';
                        scrollbar.firstChild.style.width = element.scrollWidth+'px';
                        scrollbar.firstChild.style.paddingTop = '1px';
                        scrollbar.firstChild.appendChild(document.createTextNode('\xA0'));
                        scrollbar.onscroll = function() {
                            element.scrollLeft = scrollbar.scrollLeft;
                        };
                        element.onscroll = function() {
                            scrollbar.scrollLeft = element.scrollLeft;
                        };
                        element.parentNode.insertBefore(scrollbar, element);
                    }

                    DoubleScroll(document.getElementById('doublescroll'));

                </script>


                <script>
                    $('#exportDataLink').click(function (e) {
                        console.log(window.dtFrom);
                        window.location.href = rootUrl + "/api/exportMacroDataToCSV?dtFrom=" + window.dtFrom + "&dtTo=" + window.dtTo;
                        $('.ajax-loader').css('display', 'none');
                    });
                </script>

@endsection
