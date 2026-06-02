@extends('layouts.app')

@section('pageTitle', 'RHS Furnace Energy')
@section('pageName', 'RHS Furnace Energy')
@section('casingActiveLink', 'active activeUnderline')
@section('css')
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
    <!-- Content Row -->
    <div class="simpleflex justify-content-center">
        <div class="btn-flex mt-2 text-center">
            @section('overrideStartEndDate')
                start = moment().startOf('day');
                end = moment().endOf('day');

                window.dtFrom = start.format('Y-MM-DD 00:00:01');
                window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.
            @endsection
            @section('dateRangePickerOnApplyCallback')

                window.dtFrom = dtFrom;
                window.dtTo = dtTo;
                $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                $.ajax({
                type: 'POST',
                data: {'dtFrom': dtFrom, 'dtTo' : dtTo},
                url: rootUrl + '/api/atlas-energy/get-rhs-furnace-energy-prod-monitor-data',
                success: function (data) {
                console.log(data);
                    RebuildChartsAndTable(data);
                },
                complete: function () {
                $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                }
                });

            @endsection
            {{--            <div class="filters">--}}
            {{--                --}}
            {{--                <div style="width: 100px;margin-top: 5px;">--}}
            {{--                    <a id="exportDataLink"  href="#">Export CSV</a>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--        </div>--}}
            {{--    </div>--}}


            <div class="simpleflex justify-content-center" style="margin-top: -70px">
                <div class="btn-flex mt-2 mb-3 text-center">
                    {{--            @include('layouts.partial.update-date-buttons')--}}
                    @include('layouts.templates.daterangepicker')
                </div>

            </div>

        </div>
    </div>




    <div class="row" style="margin:1em;">


        <h3>RHS Furnace Throughput (Tonnes) & Gas Usage</h3>

        <div id="rhsFurnaceEnergyThroughputChart" style="height: 500px; width:100%;">
            <svg></svg>
        </div>
        <h5>Size Change Info</h5>
        <table id="sizeChangeTable" class="table">
            <thead>
            <th>Size Change</th>
            <th>Time</th>
            </thead>
            <tbody>
            @foreach($sizeChangeData as $row)
                <tr>
                    <td>{{$row["SIZE"]}}</td>
                    <td>{{$row["DATETIME"]}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h3>RHS Furnace GJ Per Tonne</h3>
        <div id="gjPerTonneChart" style="width:100%;margin-top: 0.5em;height:200px;">
            <svg></svg>
        </div>


        <h3>RHS Furnace Throughput (Tonnes)</h3>
        <div id="throughputChart" style="width:100%;margin-top: 0.5em;height:200px;">
            <svg></svg>
        </div>

        <h3>RHS Furnace Gas Usage</h3>
        <div id="gasChart" style="width:100%;margin-top: 0.5em;height:200px;">
            <svg></svg>
        </div>

    </div>





@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var furnaceThroughputData = [{!! $groupedFurnaceTonnageByHalfHourPeriod !!}];
        var furnaceGasUsageData = [{!! $groupedFurnaceGasUsageByHalfHourPeriod !!}];
        var gjPerTonneData = [{!! $gjPerTonneByHalfHourPeriodJson !!}];

        console.log(furnaceThroughputData);
        console.log(furnaceGasUsageData);
        console.log(gjPerTonneData);


        RenderStaticDiscreteBarChart(furnaceThroughputData, "label", "value", "throughputChart", null, "Period (Half Hourly)", "Tonnes", ",0f", ",0f", [], false, false, null, null, null, null, null);
        RenderStaticDiscreteBarChart(furnaceGasUsageData, "label", "value", "gasChart", null, "Period (Half Hourly)", "GasUsage", ",0f", ",0f", [], false, false, null, null, null, null, null);
        RenderStaticDiscreteBarChart(gjPerTonneData, "label", "value", "gjPerTonneChart", null, "Period (Half Hourly)", "GJ P/Tonne", ",0f", ",0f", [], false, false, null, null, null, null, null);


        function RebuildChartsAndTable(data) {
            RenderStaticDiscreteBarChart([$.parseJSON(data.groupedFurnaceTonnageByHalfHourPeriod)], "label", "value", "throughputChart", null, "Period (Half Hourly)", "Tonnes", ",0f", ",0f", [], false, false, null, null, null, -90, null);
            RenderStaticDiscreteBarChart([$.parseJSON(data.groupedFurnaceGasUsageByHalfHourPeriod)], "label", "value", "gasChart", null, "Period (Half Hourly)", "GasUsage", ",0f", ",0f", [], false, false, null, null, null, -90, null);
            RenderStaticDiscreteBarChart([$.parseJSON(data.gjPerTonneByHalfHourPeriod)], "label", "value", "gjPerTonneChart", null, "Period (Half Hourly)", "GJ P/Tonne", ",0f", ",0f", [], false, false, null, null, null, -90, null);

            furnaceThroughputData = $.parseJSON(data.groupedFurnaceTonnageByHalfHourPeriod);
            furnaceGasUsageData = $.parseJSON(data.groupedFurnaceGasUsageByHalfHourPeriod);
            gjPerTonneData = $.parseJSON(data.gjPerTonneByHalfHourPeriod);

            console.log(furnaceThroughputData);
            /**
             * Add X & Y to label array of objects. replicate label and value values as x & y
             */
            //console.log(furnaceThroughputData[0].values);
            for (let i = 0; i < furnaceThroughputData.values.length; i++) {

                furnaceThroughputData.values[i].x = parseInt(furnaceThroughputData.values[i].label);
                furnaceThroughputData.values[i].y = furnaceThroughputData.values[i].value;

            }
            //console.log(furnaceThroughputData[0].values);

            for (let i = 0; i < furnaceGasUsageData.values.length; i++) {

                furnaceGasUsageData.values[i].x = parseInt(furnaceGasUsageData.values[i].label);
                furnaceGasUsageData.values[i].y = furnaceGasUsageData.values[i].value;

            }

            for (let i = 0; i < gjPerTonneData.values.length; i++) {

                gjPerTonneData.values[i].x = parseInt(gjPerTonneData.values[i].label);
                gjPerTonneData.values[i].y = gjPerTonneData.values[i].value;

            }

            // console.log(globalStoppageData.stoppageSummaryByType)
            // var data = globalStoppageData.stoppageSummaryByType;
            // var labelObject = {};
            // labelObject[0] = "E";
            // labelObject[1] = "M";
            // labelObject[2] = "P";
            // labelObject[3] = "C";
            // labelObject[4] = "Z";

            let multiChartData = [
                {
                    key: 'Throughput Tonnes',
                    type: 'bar',
                    yAxis: 1,
                    chartTitle: "stoppageTypeChart",
                    values: furnaceThroughputData.values,
                },
                {
                    key: 'Gas Usage',
                    type: 'line',
                    yAxis: 2,
                    chartTitle: "stoppageTypeChart",
                    values: furnaceGasUsageData.values,
                },
                {
                    key: 'GJ p/Tonne',
                    type: 'line',
                    yAxis: 1,
                    chartTitle: "stoppageTypeChart",
                    values: gjPerTonneData.values,
                    color: "#e42bff",
                },
            ];

            nv.addGraph(function () {
                var chart = nv.models.multiChart()
                    .margin({top: 30, right: 60, bottom: 100, left: 50})
                    .color(d3.scale.category10().range());

                // chart.xAxis
                //     .tickFormat(function (d) {
                //         return labelObject[d];
                //     });
                chart.useInteractiveGuideline(true);

                // Get max values for each axis
                var minY1 = 0;
                var minY2 = 0;
                var maxY1 = 0;
                var maxY2 = 0;
                for (var i = 0; i < multiChartData.length; i++) {
                    var _axis = multiChartData[i].yAxis;
                    var _values = multiChartData[i].values;

                    // Walk values and set largest to variables
                    for (var j = 0; j < _values.length; j++) {
                        // For maxY1
                        if (_axis == 1) {
                            if (_values[j].y > maxY1) {
                                maxY1 = _values[j].y;
                            }
                        }
                        // For maxY2
                        if (_axis == 2) {
                            if (_values[j].y > maxY2) {
                                maxY2 = _values[j].y;
                            }
                        }
                    }
                }
                // Set min, max values of axis
                chart.yDomain1([minY1, maxY1]);
                chart.yDomain2([minY2, maxY2]);

                chart.yAxis1.tickFormat(d3.format(',.1f'))
                chart.yAxis2.tickFormat(d3.format(',.1f'));
                d3.select('#rhsFurnaceEnergyThroughputChart svg')
                    .datum(multiChartData)
                    .transition().duration(500).call(chart);
                return chart;
            });

            var tableBodyRows = "";

            Object.keys(data.sizeChangeData).forEach(function(key) {

                console.log(key, data.sizeChangeData[key]);
                tableBodyRows += "<tr>" + "<td>" + data.sizeChangeData[key].SIZE +  "</td>" + "<td>" + data.sizeChangeData[key].DATETIME + "</td>" + "</tr>";
            });

             $('#sizeChangeTable').find('tbody').empty();
            // // append new rows from api.
             $('#sizeChangeTable').find('tbody').append(tableBodyRows);

        }


        /**
         * Add X & Y to label array of objects. replicate label and value values as x & y
         */
        //console.log(furnaceThroughputData[0].values);
        for (let i = 0; i < furnaceThroughputData[0].values.length; i++) {

            furnaceThroughputData[0].values[i].x = parseInt(furnaceThroughputData[0].values[i].label);
            furnaceThroughputData[0].values[i].y = furnaceThroughputData[0].values[i].value;

        }
        //console.log(furnaceThroughputData[0].values);

        for (let i = 0; i < furnaceGasUsageData[0].values.length; i++) {

            furnaceGasUsageData[0].values[i].x = parseInt(furnaceGasUsageData[0].values[i].label);
            furnaceGasUsageData[0].values[i].y = furnaceGasUsageData[0].values[i].value;

        }

        for (let i = 0; i < gjPerTonneData[0].values.length; i++) {

            gjPerTonneData[0].values[i].x = parseInt(gjPerTonneData[0].values[i].label);
            gjPerTonneData[0].values[i].y = gjPerTonneData[0].values[i].value;

        }

        console.log(gjPerTonneData);
        // console.log(globalStoppageData.stoppageSummaryByType)
        // var data = globalStoppageData.stoppageSummaryByType;
        // var labelObject = {};
        // labelObject[0] = "E";
        // labelObject[1] = "M";
        // labelObject[2] = "P";
        // labelObject[3] = "C";
        // labelObject[4] = "Z";

        let multiChartData = [
            {
                key: 'Throughput Tonnes',
                type: 'bar',
                yAxis: 1,
                chartTitle: "stoppageTypeChart",
                values: furnaceThroughputData[0].values,
            },
            {
                key: 'Gas Usage',
                type: 'line',
                yAxis: 2,
                chartTitle: "stoppageTypeChart",
                values: furnaceGasUsageData[0].values,
            },
            {
                key: 'GJ p/Tonne',
                type: 'line',
                yAxis: 1,
                chartTitle: "stoppageTypeChart",
                values: gjPerTonneData[0].values,
                color: "#e42bff",
            },
        ];

        nv.addGraph(function () {
            var chart = nv.models.multiChart()
                .margin({top: 30, right: 60, bottom: 100, left: 50})
                .color(d3.scale.category10().range());

            // chart.xAxis
            //     .tickFormat(function (d) {
            //         return labelObject[d];
            //     });
            chart.useInteractiveGuideline(true);

            // Get max values for each axis
            var minY1 = 0;
            var minY2 = 0;
            var maxY1 = 0;
            var maxY2 = 0;
            for (var i = 0; i < multiChartData.length; i++) {
                var _axis = multiChartData[i].yAxis;
                var _values = multiChartData[i].values;

                // Walk values and set largest to variables
                for (var j = 0; j < _values.length; j++) {
                    // For maxY1
                    if (_axis == 1) {
                        if (_values[j].y > maxY1) {
                            maxY1 = _values[j].y;
                        }
                    }
                    // For maxY2
                    if (_axis == 2) {
                        if (_values[j].y > maxY2) {
                            maxY2 = _values[j].y;
                        }
                    }
                }
            }
            // Set min, max values of axis
            chart.yDomain1([minY1, maxY1]);
            chart.yDomain2([minY2, maxY2]);

            chart.yAxis1.tickFormat(d3.format(',.1f'))
            chart.yAxis2.tickFormat(d3.format(',.1f'));
            d3.select('#rhsFurnaceEnergyThroughputChart svg')
                .datum(multiChartData)
                .transition().duration(500).call(chart);
            return chart;
        });


    </script>
@endsection
