@extends('layouts.app')

@section('pageTitle', 'Scrap Analysis')
@section('pageName', 'Scrap Analysis')
@section('millTrackingActiveLink', 'active activeUnderline')
@section('css')
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    {{--    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>--}}
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
                    url: rootUrl + '/api/getScrapAnalysisData',
                    dataType: 'json',
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css('display', 'block');
                    },
                    success: function (data) {
                    console.log(data);

                    window.dtFrom = dtFrom;
                    window.dtTo = dtTo;

                    swarfDataToTable(data.swarfSkipData);
                    cutOffDataToTable(data.totalNoCuts, data.totalPipeCutOffWeight, data.cutOffsByDept);
                    scrapSummaryPipeDataToTable(data.pipeDataByRoutingPosition);
                    scrapSummaryPipeDataToTable(data.pipeDataByRoutingPosition);

                    // Clear table object before creating new instance.
                    table.destroy();
                    // Build up HTML with ScrapPipeDataToTable() function
                    var newRows = ScrapPipeDataToTable(data.pipeData);
                    // empty table.
                    $('#scrapPipeList').find('tbody').empty();
                    // append new rows from api.
                    $('#scrapPipeList').find('tbody').append(newRows);

                    // re initiate data table.
                    table = $('#scrapPipeList').DataTable({
                    "pageLength": 10,
                    dom: 'Bfrtip',
                    "order": [[5, "DESC"]],
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



    <button onClick="goBack()" class="btn btn-primary mb-3">< Back</button>
    <hr/>
    <h3>Scrap Pipes</h3>
    <div class="simpleflex">
        <div class="fl1">

            <table id="scrapPipeList" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>DEPT</th>
                    <th>FROM_ROUTING_POS</th>
                    <th>TRANSACTION LENGTH</th>
                    <th>CURRENT LENGTH</th>
                    <th>DATE_TIME</th>
                    <th>DAY_NO</th>
                    <th>PIPE</th>
                    <th>SECTION</th>
                    <th>S1</th>
                    <th>S2</th>
                    <th>THICK</th>
                    <th>PR</th>
                    <th>TRANSACTION WEIGHT</th>
                    <th>CURRENT WEIGHT</th>
                    <th>WEIGHT DIFF</th>
                    <th>STATUS_CODE</th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th>DEPT</th>
                    <th>FROM_ROUTING_POS</th>
                    <th>TRANSACTION LENGTH</th>
                    <th>CURRENT LENGTH</th>
                    <th>DATE_TIME</th>
                    <th>DAY_NO</th>
                    <th>PIPE</th>
                    <th>SECTION</th>
                    <th>S1</th>
                    <th>S2</th>
                    <th>THICK</th>
                    <th>PR</th>
                    <th>TRANSACTION WEIGHT</th>
                    <th>CURRENT WEIGHT</th>
                    <th>WEIGHT DIFF</th>
                    <th>STATUS_CODE</th>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>
    <h4>Scrap Pipe Summary</h4>
    <div id="scrapPipeSummaryData" class="mb-2">

    </div>


    <h3>Swarf Skips</h3>
    <div id="swarfData">

    </div>


    <h3>Pipe Cut Offs</h3>
    <div id="cutOffsData">

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

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script>





        function ScrapPipeDataToTable(data) {
            var crsfToken = "{{@csrf_token()}}";
            var tablesRows = "";
            for (var i = 0; i < data.length; i++) {
                // console.log(key, value);
                tablesRows += "<tr>" +

                    "<td>" + data[i].DEPT  + "</td>" +
                    "<td>" + data[i].FROM_ROUTING_POS + "</td>" +
                    "<td>" + data[i].TRANS_LENGTH + "</td>" +
                    "<td>" + data[i].PIPE_LENGTH + "</td>" +
                    "<td>" + data[i].DATETIME_TANDEM + "</td>" +
                    "<td>" + data[i].DAY_NO + "</td>" +
                    "<td>" + data[i].TRACK_CODE + "</td>" +
                    "<td>" + data[i].TRACK_CODE_ALT + "</td>" +
                    "<td>" + data[i].PIPE_SIZE1 + "</td>" +
                    "<td>" + data[i].PIPE_SIZE2 + "</td>" +
                    "<td>" + data[i].PIPE_THICK + "</td>" +
                    "<td>" + data[i].PROCESS_ROUTE + "</td>" +
                    "<td>" + data[i].TRANSACTION_WEIGHT + "</td>" +
                    "<td>" + data[i].CURRENT_WEIGHT + "</td>" +
                    "<td>" + (data[i].TRANSACTION_WEIGHT - data[i].CURRENT_WEIGHT) + "</td>" +
                    "<td>" + data[i].PIPE_STATUS_CODE  + "</td>" +
                    "</tr>";

            }
            return tablesRows;
        }

        function swarfDataToTable(swarfData) {
            var totalWeight = 0;
            var tbl = "<table class='table'>";
            tbl +="<thead><th>BookOutDate</th><th>Weight</th></thead>";
            tbl += "<tbody>";
            console.log(swarfData);
            for (var i = 0; i < swarfData.length; i++) {
                tbl+= "<tr>"+ "<td>" + swarfData[i].BOOKED_OUT_DATE + "</td>" + "<td>" + swarfData[i].BOOK_OUT_WEIGHT + "</td>" + "</tr>";
                totalWeight += parseFloat(swarfData[i].BOOK_OUT_WEIGHT);
            }
            tbl += "<tr>"+ "<td>Total</td>" + "<td style='font-weight: bold;'>Total Weight</td>" + "</tr>";
            tbl += "<tr>"+ "<td></td>" + "<td  style='font-weight: bold;background: #fffc99'>"+totalWeight+"</td>" + "</tr>";
            tbl +="</table>";
            $('#swarfData').html(tbl);

        }

        function cutOffDataToTable(cutOffsCount, totalCutWeight, cutsByDept) {
            var tbl = "<table class='table'>";
            tbl +="<thead><th>Dept</th><th>Weight</th></thead>";
            tbl += "<tbody>";
            console.info(cutsByDept);
            for (var [key, value] of Object.entries(cutsByDept)) {
                tbl+= "<tr>"+ "<td>" + value.DEPT + "</td>" + "<td>" + value.TONNES.toFixed(3) + "</td>" + "</tr>";
            }

            tbl+= "<tr>"+ "<td  style='font-weight: bold;'>TotalCuts</td>" + "<td  style='font-weight: bold;'>TotalWeight</td>" + "</tr>";
            tbl+= "<tr>"+ "<td   style='font-weight: bold;background: #fffc99'>" + cutOffsCount + "</td>" + "<td   style='font-weight: bold;background: #fffc99'>" + totalCutWeight.toFixed(3) + "</td>" + "</tr>";

            tbl +="</table>";
            $('#cutOffsData').html(tbl);


        }

        function scrapSummaryPipeDataToTable(data) {
            var totalTonnes = 0;
            var totalMetres = 0;
            var totalCount = 0;


            var tbl = "<table class='table'>";
            tbl +="<thead><th>Pos</th><th>Metres</th><th>Count</th><th>Tonnes</th></thead>";
            tbl += "<tbody>";
            console.info(data);
            for (var [key, value] of Object.entries(data)) {
                tbl+= "<tr>"+ "<td>" + value.POS + "</td>" + "<td>" + value.METRES.toFixed(3) + "<td>" + value.COUNT +  "<td>" + value.TONNES.toFixed(3) + "</td>" + "</tr>";
                totalCount = (totalCount + value.COUNT);
                totalMetres = (totalMetres + value.METRES);
                totalTonnes = (totalTonnes + value.TONNES);
            }

            tbl+= "<tr>"+"<td> </td>"+"<td  style='font-weight: bold;'>TotalMetres</td>" + "<td  style='font-weight: bold;'>TotalCount</td>" + "<td  style='font-weight: bold;'>TotalWeight</td>"  + "</tr>";
            tbl+= "<tr>"+"<td> </td>" + "<td   style='font-weight: bold;background: #fffc99'>" + totalMetres.toFixed(3) + "</td>" + "<td   style='font-weight: bold;background: #fffc99'>" + totalCount + "<td   style='font-weight: bold;background: #fffc99'>" + totalTonnes.toFixed(3) + "</td>" + "</tr>";

            tbl +="</table>";
            $('#scrapPipeSummaryData').html(tbl);
        }

    </script>

<script>
    var table;
    $( document ).ready(function() {

        // When page loads, request current weeks data and populate dashboard.
        $.ajax({
            type: 'POST',

            url: rootUrl + '/api/getScrapAnalysisData',
            dataType: 'json',
            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('.ajax-loader').css('display', 'block');
            },
            success: function (data) {
                swarfDataToTable(data.swarfSkipData);
                cutOffDataToTable(data.totalNoCuts, data.totalPipeCutOffWeight, data.cutOffsByDept);
                scrapSummaryPipeDataToTable(data.pipeDataByRoutingPosition);

                // Build up HTML with ScrapPipeDataToTable() function
                var newRows = ScrapPipeDataToTable(data.pipeData);
                // empty table.
                $('#scrapPipeList').find('tbody').empty();
                // append new rows from api.
                $('#scrapPipeList').find('tbody').append(newRows);

                // re initiate data table.
                table = $('#scrapPipeList').DataTable({
                    "pageLength": 10,
                    dom: 'Bfrtip',
                    "order": [[5, "DESC"]],
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
    });
    </script>
@endsection
