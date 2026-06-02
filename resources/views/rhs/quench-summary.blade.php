@extends('layouts.app')

@section('pageTitle', 'Cooling Summary')
@section('pageName', 'Cooling Summary')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
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

            @section('dateRangePickerOnApplyCallback')

                $.ajax({
                type: 'POST',
                data: {'dtFrom': dtFrom, 'dtTo': dtTo},
                url: rootUrl + '/api/GetRHSQuenchSummarySummary',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {
                console.log(data);

                //Populate Stats
                $('#total-section-count').html(data.stats.totalSectionCount);
                $('#section-fails').html(data.stats.totalSectionFailures);
                $('#failureRateStat').html((data.stats.totalSectionCount > 0 ? (data.stats["totalSectionFailures"] / data.stats["totalSectionCount"]*100 ).toFixed(2) : 0) + "%");
                $('#drop-passes').html(data.stats.totalDropPasses);
                $('#drop-fails').html(data.stats.totalDropFails);


                // Clear table object before creating new instance.
                table.destroy();
                // Build up HTML with BuildNewRows() function
                var newRows = BuildNewRows(data.quenchSummaryArray);
                // empty table.
                $('#quench-summary-tbl').find('tbody').empty();
                // append new rows from api.
                $('#quench-summary-tbl').find('tbody').append(newRows);

                // re initiate data table.
                table = $('#quench-summary-tbl').DataTable({
                "pageLength": 10,
                dom: 'Bfrtip',
                buttons: ['print', 'excel'],
                "order": [[2, "DESC"]],
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


    <script>


    </script>


    <div class="mb-3"></div> <!-- add space -->


    <!-- Content Row -->

    <h2>Cooling Summary</h2>
    <div class="simpleflex">
        <div class="fl1-500">

            <table id="quench-summary-tbl" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>SECTION</th>
                    <th>THICK</th>
                    <th>TIME</th>
                    <th>SERIES</th>
                    <th>READINGS</th>
                    <th>MIN</th>
                    <th>MAX</th>
                    <th>Drop Seg 1</th>
                    <th>Drop Seg 2</th>
                    <th>Drop Seg 3</th>
                    <th>Drop Seg 4</th>
                    <th>Drop Seg 5</th>
                    <th>Has Failure</th>
                    <th>View Chart</th>

                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                <tr>
                    <th>SECTION</th>
                    <th>THICK</th>
                    <th>TIME</th>
                    <th>SERIES</th>
                    <th>READINGS</th>
                    <th>MIN</th>
                    <th>MAX</th>
                    <th>Drop Seg 1</th>
                    <th>Drop Seg 2</th>
                    <th>Drop Seg 3</th>
                    <th>Drop Seg 4</th>
                    <th>Drop Seg 5</th>
                    <th>Has Failure</th>
                    <th>View Chart</th>

                </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <hr/>
    <h5>Pass/Fail Stats</h5>
    <div class="simpleflex pb-3">
        <div class="fl1">
            <h6 style="text-decoration: underline;">Section Count</h6>
            <span id="total-section-count"></span>
        </div>
        <div class="fl1">
            <h6 style="text-decoration: underline;">Section Fails</h6>
            <span id="section-fails"></span>
        </div>
        <div class="fl1">
            <h6 style="text-decoration: underline;">Failure Rate</h6>
            <span id="failureRateStat"></span>
        </div>
        <div class="fl1">
            <h6 style="text-decoration: underline;">Drop Passes</h6>
            <span id="drop-passes" style="font-weight: bold;color: green;"></span>
        </div>
        <div class="fl1">
            <h6 style="text-decoration: underline;">Drop Fails</h6>
            <span id="drop-fails" style="font-weight: bold;color: #e3342f;"></span>
        </div>
    </div>

@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    <!-- Extension scripts for datatables print functionality -->
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>
    <!-- End  Extension scripts for datatables print functionality -->

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let table;
        // Initialize Data Table
        $(window).on('load', function () {
            table = $('#quench-summary-tbl').DataTable({
                dom: 'Bfrtip',
                buttons: ['print', 'excel'],
                "order": [[2, "DESC"]],
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

        });

        $('.dateTimeControlButton').on('click', function () {
            var dateCommand = $(this).data('filtercommand');
            console.log(dateCommand);

            var url = rootUrl + "/rhs/quench-summary?dateCommand=" + dateCommand;
            window.location.href = url;
        });



        function BuildNewRows(data) {
            var tablesRows = "";
            for (const [key, value] of Object.entries(data)) {
                // console.log(key, value);
                tablesRows += "<tr>" +
                    "<td>" + key + "</td>" +
                    "<td>" + data[key].SECTION_PROPERTIES.THICK + "</td>" +
                    "<td>" + data[key].SECTION_PROPERTIES.TIME_STAMP + "</td>" +
                     "<td>QI_North_Pyro</td>" +
                    "<td " + (data[key].QI_North_Pyro == undefined ? " style='background:#ffbf91;'" : "") + ">" + (data[key].QI_North_Pyro !== undefined ? data[key].QI_North_Pyro.COUNT : "OFFLINE") + "</td>" +
                    "<td " + (data[key].QI_North_Pyro == undefined ? " style='background:#ffbf91;'" : "") + ">"  + (data[key].QI_North_Pyro !== undefined ? data[key].QI_North_Pyro.MIN : "OFFLINE") + "</td>" +
                    "<td " + (data[key].QI_North_Pyro == undefined ? " style='background:#ffbf91;'" : "") + ">"  + (data[key].QI_North_Pyro !== undefined ? data[key].QI_North_Pyro.MAX : "OFFLINE") + "</td>" +

                    "<td " + (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_1_ACCEPTANCE ? (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_1_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_1 ? data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_1 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_2_ACCEPTANCE ? (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_2_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_2 ? data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_2 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_3_ACCEPTANCE ? (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_3_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_3 ? data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_3 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_4_ACCEPTANCE ? (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_4_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_4 ? data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_4 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_5_ACCEPTANCE ? (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_5_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_5 ? data[key].DROPS.NORTH_PYRO_DROP_SEGMENT_5 : 0) +
                    "</td>" +
                    "<td>" + (data[key].FAILURES !== undefined ? "Y" : "N") + "</td>" +
                    "<td><a href='"+rootUrl+"/rhs/section-cooling-trace?sectionNo="+key+"'>View ></td>" +
                    "</tr>" +



                    "<tr>" +
                    "<td>" + key + "</td>" +
                    "<td>" + data[key].SECTION_PROPERTIES.THICK + "</td>" +
                    "<td>" + data[key].SECTION_PROPERTIES.TIME_STAMP + "</td>" +
                    "<td>QI_South_Pyro</td>" +
                    "<td " + (data[key].QI_South_Pyro == undefined ? " style='background:#ffbf91;'" : "") + ">" + (data[key].QI_South_Pyro !== undefined ? data[key].QI_South_Pyro.COUNT : "OFFLINE") + "</td>" +
                    "<td " + (data[key].QI_South_Pyro == undefined ? " style='background:#ffbf91;'" : "") + ">" + (data[key].QI_South_Pyro !== undefined ? data[key].QI_South_Pyro.MIN : "OFFLINE") + "</td>" +
                    "<td " + (data[key].QI_South_Pyro == undefined ? " style='background:#ffbf91;'" : "") + ">" + (data[key].QI_South_Pyro !== undefined ? data[key].QI_South_Pyro.MAX : "OFFLINE") + "</td>" +
                    "<!--" +
                    "Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours." +
                    "-->" +

                    "<td " + (data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_1_ACCEPTANCE ? (data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_1_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_1 ? data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_1 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_2_ACCEPTANCE ? (data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_2_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_2 ? data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_2 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_3_ACCEPTANCE ? (data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_3_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_3 ? data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_3 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_4_ACCEPTANCE ? (data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_4_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_4 ? data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_4 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.South_PYRO_DROP_SEGMENT_5_ACCEPTANCE ? (data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_5_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_5 ? data[key].DROPS.SOUTH_PYRO_DROP_SEGMENT_5 : 0) +
                    "</td>" +

                    "<td>" + (data[key].FAILURES !== undefined ? "Y" : "N") + "</td>" +
                    "<td><a href='"+rootUrl+"/rhs/section-cooling-trace?sectionNo="+key+"'>View ></td>" +
                    "</tr>" +


                    "<tr>" +
                    "<td>" + key + "</td>" +
                    "<td>" + data[key].SECTION_PROPERTIES.THICK + "</td>" +
                    "<td>" + data[key].SECTION_PROPERTIES.TIME_STAMP + "</td>" +
                    "<td>QI_Top_Pyro</td>" +
                    "<td " + (data[key].QI_Top_Pyro == undefined ? " style='background:#ffbf91;'" : "") + ">" + (data[key].QI_Top_Pyro !== undefined ? data[key].QI_Top_Pyro.COUNT : "OFFLINE") + "</td>" +
                    "<td " + (data[key].QI_Top_Pyro == undefined ? " style='background:#ffbf91;'" : "") + ">" + (data[key].QI_Top_Pyro !== undefined ? data[key].QI_Top_Pyro.MIN : "OFFLINE") + "</td>" +
                    "<td " + (data[key].QI_Top_Pyro == undefined ? " style='background:#ffbf91;'" : "") + ">" + (data[key].QI_Top_Pyro !== undefined ? data[key].QI_Top_Pyro.MAX : "OFFLINE") + "</td>" +

                    "<!--" +
                    "Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours." +
                    "-->" +

                    "<td " + (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_1_ACCEPTANCE ? (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_1_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_1 ? data[key].DROPS.TOP_PYRO_DROP_SEGMENT_1 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_2_ACCEPTANCE ? (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_2_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_2 ? data[key].DROPS.TOP_PYRO_DROP_SEGMENT_2 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_3_ACCEPTANCE ? (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_3_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_3 ? data[key].DROPS.TOP_PYRO_DROP_SEGMENT_3 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_4_ACCEPTANCE ? (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_4_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_4 ? data[key].DROPS.TOP_PYRO_DROP_SEGMENT_4 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_5_ACCEPTANCE ? (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_5_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.TOP_PYRO_DROP_SEGMENT_5 ? data[key].DROPS.TOP_PYRO_DROP_SEGMENT_5 : 0) +
                    "</td>" +
                    "<td>" + (data[key].FAILURES !== undefined ? "Y" : "N") + "</td>" +
                    "<td><a href='"+rootUrl+"/rhs/section-cooling-trace?sectionNo="+key+"'>View ></td>" +

                    "</tr>" +


                    "<tr>" +
                    "<td>" + key + "</td>" +
                    "<td>" + data[key].SECTION_PROPERTIES.THICK + "</td>" +
                    "<td>" + data[key].SECTION_PROPERTIES.TIME_STAMP + "</td>" +
                    "<td>QI_Bottom_Pyro</td>" +
                    "<td " + (data[key].QI_Bottom_Pyro == undefined ? " style='background:#ffbf91;'" : "") + ">" + (data[key].QI_Bottom_Pyro !== undefined ? data[key].QI_Bottom_Pyro.COUNT : "OFFLINE") + "</td>" +
                    "<td " + (data[key].QI_Bottom_Pyro == undefined ? " style='background:#ffbf91;'" : "") + ">" + (data[key].QI_Bottom_Pyro !== undefined ? data[key].QI_Bottom_Pyro.MIN : "OFFLINE") + "</td>" +
                    "<td " + (data[key].QI_Bottom_Pyro == undefined ? " style='background:#ffbf91;'" : "") + ">" + (data[key].QI_Bottom_Pyro !== undefined ? data[key].QI_Bottom_Pyro.MAX : "OFFLINE") + "</td>" +

                    "<!--" +
                    "Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours." +
                    "-->" +

                    "<td " + (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_1_ACCEPTANCE ? (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_1_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_1 ? data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_1 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_2_ACCEPTANCE ? (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_2_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_2 ? data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_2 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_3_ACCEPTANCE ? (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_3_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_3 ? data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_3 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_4_ACCEPTANCE ? (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_4_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_4 ? data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_4 : 0) +
                    "</td>" +
                    "<td " + (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_5_ACCEPTANCE ? (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_5_ACCEPTANCE == "F" ? ' style=background:#e3342f;color:#ffffff !important;' : '') : '') + ">" +
                    (data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_5 ? data[key].DROPS.BOTTOM_PYRO_DROP_SEGMENT_5 : 0) +
                    "</td>" +
                    "<td>" + (data[key].FAILURES !== undefined ? "Y" : "N") + "</td>" +
                    "<td><a href='"+rootUrl+"/rhs/section-cooling-trace?sectionNo="+key+"'>View ></td>" +
                    "</tr>";
            }

            return tablesRows;
        }




    </script>

@endsection
