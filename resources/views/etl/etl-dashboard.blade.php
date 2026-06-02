@extends('layouts.app')

@section('pageTitle', 'Energy Tick List')
@section('pageName', 'Energy Tick List')
@section('homeActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <style>
        select {
            max-width: 500px !important;
        }
    </style>
@endsection
@section('dateRangePickerOnApplyCallback')
    /***
    * Get initial chart data
    */
    $.ajax({
    type: "POST",
    data: {'dtFrom': dtFrom, 'dtTo': dtTo},
    url: rootUrl + "/api/get-etl-dashboard",
    dataType: "json",
    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
    $('.ajax-loader').css('display', 'block');
    },
    // async: false,
    success: function (response) {
    console.log(response);
    globalStoppageData = response;
    window.dtFrom = dtFrom;
    window.dtTo = dtTo;

    BuildSubmissionByDayHeatmap(response.etlHeatmapArray);
    BuildSubmissionsByDateBarChart(response.etlSubmissionsByDateMill, response.dayCount);


    // Clear table object before creating new instance.
    table.destroy();
    // Build up HTML with BuildNewRows() function
    var newRows = BuildNewRows(response.etlHistorySummary);
    // empty table.
    $('#etl-history-table').find('tbody').empty();
    // append new rows from api.
    $('#etl-history-table').find('tbody').append(newRows);

    // re initiate data table.
    table = $('#etl-history-table').DataTable({
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




    {{--    BuildStoppageMonthlyAnalysisTable();--}}
    },
    complete: function () {
    $('.ajax-loader').css('display', 'none');
    }
    });
@endsection
@section('dateRangePickerAdditionalRanges')
    'Last 3 Months': [moment().subtract(3, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
    'This Year': [moment().startOf('year'), moment().endOf('year')],
    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
@endsection
@section('highChartScripts')
    <script src="{{ asset('public/js/highcharts/code/highcharts.js')}}"></script>
    <script src="{{ asset('public/js/highcharts/code/modules/heatmap.js')}}"></script>
    <script src="{{ asset('public/js/highcharts/code/modules/exporting.js')}}"></script>
    <script src="{{ asset('public/js/highcharts/code/modules/export-data.js')}}"></script>


@endsection
@section('content')

    <div class="filters" style="justify-content: normal;">
        @include('layouts.templates.daterangepicker')
    </div>
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
    <!-- Content Row -->



    <table id="etl-history-table" class="table table-striped" style="width: 100%;">
        <thead>
        <th>Mill</th>
        <th>Submitted By</th>
        <th>TurnedOffRatio</th>
        <th>Date</th>
        <th>Day</th>
        <th>Edit</th>
        </thead>
        <tbody>
        @foreach($etlHistorySummary as $etlHistory)
            <tr>

                <td>{{$etlHistory->mill}}</td>
                <td>{{$etlHistory->name}}</td>
                <td>{{round(($etlHistory->SwitchedOn /$etlHistory->totalCountOfAssets) * 100, 1)}} %</td>
                <td>{{ substr($etlHistory->created_at, 0, 10)}}</td>
                <td>{{$etlHistory->day_name}}</td>
                <input type="hidden" name="etlHistoryId"
                       value="{{substr($etlHistory->created_at, 0, 10) . "_" . $etlHistory->mill}}">
                <td><a href="{{ route('edit-etl')}}?dt={{$etlHistory->created_at}}&mill={{$etlHistory->mill}}"
                       class="btn btn-warning m-1">Edit</a></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <th>Mill</th>
        <th>Submitted By</th>
        <th>TurnedOffRatio</th>
        <th>Date</th>
        <th>Day</th>
        </tfoot>
    </table>

    {{--    <h4>Submissions This year by Area</h4>--}}

    {{--    <figure class="highcharts-figure">--}}

    {{--        <div style="display:flex">--}}
    {{--            <div style="flex: 1 0 200px;" id="container-weldMill" class="chart-container"></div>--}}
    {{--            <div style="flex: 1 0 200px;" id="container-rhs" class="chart-container"></div>--}}
    {{--            <div style="flex: 1 0 200px;" id="container-roundsFin" class="chart-container"></div>--}}
    {{--            <div style="flex: 1 0 200px;" id="container-casing" class="chart-container"></div>--}}
    {{--            <div style="flex: 1 0 200px;" id="container-despatch" class="chart-container"></div>--}}
    {{--            <div style="flex: 1 0 200px;" id="container-prodServices" class="chart-container"></div>--}}
    {{--            <div style="flex: 1 0 200px;" id="container-engineering" class="chart-container"></div>--}}
    {{--        </div>--}}



    {{--    </figure>--}}

    <h4 style="margin: 2em 0">Submissions This year by Area</h4>
    <div>
        <figure class="highcharts-figure">
            <div id="container"></div>
        </figure>
    </div>

    <figure class="highcharts-figure">
        <div id="container-etl-subByMonthByDeot"></div>
    </figure>



    <script>
         function BuildSubmissionByDayHeatmap(etlHeatmapArray) {
            // Create the chart
            Highcharts.chart('container', {

                chart: {
                    type: 'heatmap',
                    marginTop: 40,
                    marginBottom: 80,
                    plotBorderWidth: 1
                },


                title: {
                    text: 'Submissions per Dept / Weekday',
                    style: {
                        fontSize: '1em'
                    }
                },

                xAxis: {
                    categories: ['Weld Mill', 'RHS', 'Rounds Finishing', 'Casing', 'Despatch', 'Production Services', 'Engineering']
                },

                yAxis: {
                    categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    title: null,
                    reversed: true
                },

                accessibility: {
                    point: {
                        descriptionFormat: '{(add index 1)}. ' +
                            '{series.xAxis.categories.(x)} sales ' +
                            '{series.yAxis.categories.(y)}, {value}.'
                    }
                },

                colorAxis: {
                    min: 0,
                    minColor: '#FFFFFF',
                    maxColor: Highcharts.getOptions().colors[0]
                },

                legend: {
                    align: 'right',
                    layout: 'vertical',
                    margin: 0,
                    verticalAlign: 'top',
                    y: 25,
                    symbolHeight: 280
                },

                tooltip: {
                    format: '<b>{series.xAxis.categories.(point.x)}</b> <br>' +
                        '<b>{point.value}</b> Submitted on <br>' +
                        '<b>{series.yAxis.categories.(point.y)}</b>'
                },

                series: [{
                    name: 'ETL Submissions',
                    borderWidth: 1,
                    data: etlHeatmapArray,
                    dataLabels: {
                        enabled: true,
                        color: '#000000'
                    }
                }],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            yAxis: {
                                labels: {
                                    format: '{substr value 0 1}'
                                }
                            }
                        }
                    }]
                }

            });

         }



        function BuildSubmissionsByDateBarChart(etlSubmissionsByDateMill, dayCount) {


            Highcharts.chart('container-etl-subByMonthByDeot', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Energy Tick List Submissions By Dept / DateSpanSelected'
                },
                xAxis: {
                    categories: [
                        'Weld Mill',
                        'RHS',
                        'Casing',
                        'Prod Serv',
                        'Despatch',
                        'Rounds Finishing'
                    ]
                },
                yAxis: [{
                    min: 0,
                    title: {
                        text: 'Employees'
                    }
                }, {
                    title: {
                        text: 'Profit (millions)'
                    },
                    opposite: true
                }],
                legend: {
                    shadow: false
                },
                tooltip: {
                    shared: true
                },
                plotOptions: {
                    column: {
                        grouping: false,
                        shadow: false,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Target',
                    color: 'rgba(165,170,217,1)',
                    data: [dayCount, dayCount, dayCount, dayCount, dayCount, dayCount],
                    pointPadding: 0.3,
                    pointPlacement: -0.2
                }, {
                    name: 'Actual',
                    color: 'rgba(126,86,134,.9)',
                    data: [
                        (etlSubmissionsByDateMill['Weld Mill'] == undefined ? 0 : etlSubmissionsByDateMill['Weld Mill'].value),
                        (etlSubmissionsByDateMill['RHS'] == undefined ? 0 : etlSubmissionsByDateMill['RHS'].value),
                        (etlSubmissionsByDateMill['Casing'] == undefined ? 0 : etlSubmissionsByDateMill['Casing'].value),
                        (etlSubmissionsByDateMill['Production Services'] == undefined ? 0 : etlSubmissionsByDateMill['Production Services'].value),
                        (etlSubmissionsByDateMill['Despatch'] == undefined ? 0 : etlSubmissionsByDateMill['Despatch'].value),
                        (etlSubmissionsByDateMill['Rounds Finishing'] == undefined ? 0 : etlSubmissionsByDateMill['Rounds Finishing'].value)],

                    pointPadding: 0.4,
                    pointPlacement: -0.2
                }]
            });

        }



        let etlSubmissionsByDateMill = <?php echo json_encode($etlSubmissionsByDateMill); ?>;
        let etlHeatmapArray = <?php echo json_encode($etlHeatmapArray); ?>;
        let dayCount = <?php echo json_encode($dayCount); ?>;
         console.log(dayCount);
        console.log(etlSubmissionsByDateMill);

        BuildSubmissionsByDateBarChart(etlSubmissionsByDateMill, Math.abs(dayCount));
        BuildSubmissionByDayHeatmap(etlHeatmapArray);
    </script>

@endsection
@section('functionalScripts')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js?v=1')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js?v=1')}}"></script>
    <!-- Extension scripts for datatables print functionality -->
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>


    <script>

        /** On initial Load */

        var table = $('#etl-history-table').DataTable({
            dom: 'Bfrtip',
// buttons: ['print', 'excel'],

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


        function BuildNewRows(data) {
            var crsfToken = "{{@csrf_token()}}";
            var tablesRows = "";
            for (const [key, value] of Object.entries(data)) {
                // console.log(key, value);
                tablesRows += "<tr>" +

                    "<td>" + data[key].mill + "</td>" +
                    "<td>" + data[key].name + "</td>" +
                    "<td>" + Math.round((data[key].SwitchedOn / data[key].totalCountOfAssets) * 100).toFixed(1)  + "</td>" +
                    "<td>" + data[key].created_at + "</td>" +
                    "<td>" + data[key].day_name + "</td>" +
                    "<input type='hidden' name='etlHistoryId' value='"+data[key].created_at+"_"+data[key].mill+"'> " +
                    "<td><a class='btn btn-warning m-1' href='" + rootUrl + "/etl" + "/edit-etl-submission?dt=" + data[key].created_at + "&mill="+data[key].mill  +   "'>Edit</a></td>" +
                    "</tr>";

            }

            return tablesRows;
        }

    </script>

@endsection
