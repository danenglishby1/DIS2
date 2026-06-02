@extends('layouts.app')

@section('pageTitle', 'RHS Dashboard')
@section('pageName', 'RHS Dashboard')
@section('rhsActiveLink', 'active activeUnderline')
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

                    boolRealTimeUpdateOn = false;


                    $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                    $.ajax({
                    type: "POST",
                    data: {'dtFrom': dtFrom, 'dtTo' : dtTo},
                    url: rootUrl + "/api/GetRHSDashboardData", // Pass in command to api and request new data.
                    dataType: "json",
                    async: true,
                    success: function (data) {
                    console.log("button used");
                    console.log(data);
                    UpdateCharts(data);

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

                {{--        <div class="pivot-update-slider-switch text-center">--}}
                {{--            <sub style="font-size: 16px">Updating</sub>--}}
                {{--            <!-- Rounded switch -->--}}
                {{--            <label class="switch">--}}
                {{--                <input id="pivotUpdateSwitch" type="checkbox" checked="true">--}}
                {{--                <span class="slider round"></span>--}}
                {{--            </label>--}}
                {{--        </div>--}}


    <div class="simpleflex">
        <div class="dashboard-flex-card" style="flex:3; margin:1em;">
            <div style="flex:2">
                <div class="card-body">

                    <div>
                        <div class="card-body">
                            <h5>RHS Stats</h5>
                            <div id="finishingStats">
                                <table class="table table-bordered table-reduced-padding" id="finishingStatsTable">
                                    <thead class="thead-light">
                                    <th>RHS</th>
                                    <th>Tons</th>
                                    <th>Metres</th>
                                    <th>Sections</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <h5>Furnace Throughput</h5>
                    <div id="furnaceThroughputBarChart" style="height: 150px; width:100%;">
                        <svg></svg>
                    </div>
                    <hr/>
                    <h5>Failures</h5>
                    <div id="furnaceFailuresBarChart" style="height: 100px; width:100%;">
                        <svg></svg>
                    </div>
                    <hr/>
                    {{--                    <div class="furnace-performance-totals-stats" id="furnace-performance-totals-stats">--}}
                    {{--                    </div>--}}
                </div>


                <div class="card-body" style="margin-top: -45px">


                    <h5>Furnace Trace</h5>


                    <div id="rhsFurnaceTracesLineChart" style="height:300px; width: 100%;">
                        <svg></svg>
                    </div>


                    {{--                        <div style="width:200px;">--}}
                    {{--                            <h6>Shift 2x10</h6>--}}
                    {{--                            <div id="twoTillTenFurnacePerformancePieChart" style="height:125px">--}}
                    {{--                                <svg></svg>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}

                    {{--                        <div style="width:200px;">--}}
                    {{--                            <h6>Shift 10x6</h6>--}}
                    {{--                            <div id="tenTillSixFurnacePerformancePieChart" style="height:125px">--}}
                    {{--                                <svg></svg>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <hr/>
                    <h5>Furnace Visibility</h5>
                    <div class="furance-visibility-inputs">
                        <label>WEEK NO</label> <input type="number" name="week" id="weekNo"
                                                      style="border: 0;border-bottom: 1px solid;"/>
                        <label>OD</label><input type="number" step="any" name="od" id="od"
                                                style="border: 0;border-bottom: 1px solid;"/>
                        <label>PR</label><input type="text" name="pr" id="pr"
                                                style="border: 0;border-bottom: 1px solid;"/>
                    </div>
                    <div id="furnaceVisibility" class="mt-1">
                        <table class="table" id="furnaceVisibilityTable">
                            <thead>
                            <th>SIZE</th>
                            <th>PR</th>
                            <th>PROG</th>
                            <th>ROLLED</th>
                            <th>FURN</th>
                            <th>BAL</th>
                            </thead>
                        </table>
                    </div>

                </div>

            </div>
        </div>


        {{--                    <div class="card-body">--}}
        {{--                        <h4>Shift 10x6</h4>--}}
        {{--                        <hr/>--}}
        {{--                        <div id="tenTillSixFurnacePerformancePieChart">--}}
        {{--                            <svg></svg>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}


        <div class="dashboard-flex-card" style="flex:2; margin:1em;">
            <!-- Visual Content -->
            <!-- Card Body -->
            <div class="card-body">
                <h5 style="margin-bottom: -15px;">STRM Throughput</h5>
                <hr/>
                <div id="straightnessThroughputBarChart" style="width:100%; height: 100px; margin-bottom: -60px;">
                    <svg></svg>
                </div>
            </div>

            <div class="card-body">
                <h5 style="margin-bottom: -15px;">BPM Failures</h5>
                <hr/>
                <div id="bendPerMetreFailuresBarChart" style="width:100%; height: 100px;margin-bottom: -60px;">
                    <svg></svg>
                </div>
            </div>
            <div class="card-body">
                <h5 style="margin-bottom: -15px;">TB Failures</h5>
                <hr/>
                <div id="totalBendFailuresBarChart" style="width:100%; height: 100px;margin-bottom: -60px;">
                    <svg></svg>
                </div>
            </div>

            <div class="card-body">
                <h5 style="margin-bottom: -15px;">Combined Section Failures</h5>
                <hr/>
                <div id="totalSectionFailuresBarChart" style="height: 100px;margin-bottom: -60px;">
                    <svg></svg>
                </div>
            </div>

            <div class="card-body">
                <h5 style="margin-bottom: -15px;">Blockmarks</h5>
                <hr/>
                <div id="blockMarkDefectsPerHour" style="height: 100px;margin-bottom: -60px;">
                    <svg></svg>
                </div>
            </div>

            <div class="card-body">
                <h5 style="margin-bottom: -15px;">Dress</h5>
                <hr/>
                <div id="pipesToDress" style="height: 100px;margin-bottom: -30px;">
                    <svg></svg>
                </div>
            </div>

            <div class="card-body">
                <h5 style="margin-bottom: -15px;">Bend Per Metre STN1 & STN2 Traces</h5>
                <hr/>
                <div id="rhsStraightnessBPMLineChart" style="height:300px"
                     class='with-3d-shadow with-transitions'>
                    <svg></svg>
                </div>
            </div>


        </div>

        <div class="dashboard-flex-card" style="flex:3; margin:1em;">
            <!-- Visual Content -->
            <!-- Card Body -->
            <div class="card-body">
                <h5>Misc</h5>
                <div id="stoppagesByMachineAndType" style="height: 150px;">
                    <svg></svg>
                </div>

                <div class="card-body" style="margin-bottom: -50px">
                    <h5>SAW Throughput</h5>
                    <div id="sawThroughputBarChart" style="height: 125px;">
                        <svg></svg>
                    </div>
                </div>

                <div class="card-body" style="margin-bottom: -50px">
                    <h5>SAW To Stock Throughput</h5>
                    <div id="sawToStockThroughputBarChart" style="height: 125px;">
                        <svg></svg>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5>Length Of Side (Continuous)</h5>
                <div id="lengthOfSideLineChart" class='with-3d-shadow with-transitions' style="height:125px;">
                    <svg></svg>
                </div>
                <h5>Length Of Short Side (Continuous)</h5>
                <div id="lengthOfShortSideLineChart" class='with-3d-shadow with-transitions' style="height:125px;">
                    <svg></svg>
                </div>

                <h5>Length Of Long Side (Continuous)</h5>
                <div id="lengthOfLongSideLineChart" class='with-3d-shadow with-transitions' style="height:125px;">
                    <svg></svg>
                </div>
            </div>
            <div class="card-body">
                <h5>Sections Deallocated</h5>
                <div id="sectionsDeallocated" style="text-align: center;font-size: 30px;font-weight: bold;">
                </div>
            </div>

            <div class="card-body">
                <h5>RHS Zumbach Failures</h5>
                <div id="rhsZumbachFailures" style="text-align: center;font-size: 30px;font-weight: bold;">

                </div>
            </div>

        </div>

    </div>

    <!-- END Furnace Temp Performance Chart -->

@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js?v=1.0')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let boolRealTimeUpdateOn = true;
        let firstCall = true;
        let deallocatedPipesRawData;
        let rhsZumbachSectionFailuresRawData;
        $(document).ready(function () {
            //Initialize Real Time Charts
            // Completely custom chart setup due to the tooltip content
            function GetFurnaceFailuresAndBuildBarCharts() {
                if (boolRealTimeUpdateOn) {
                    console.log(boolRealTimeUpdateOn);

                    $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                    $.ajax({
                        type: "POST",
                        url: rootUrl + "/api/GetRHSDashboardData", // Pass in command to api and request new data.
                        dataType: "json",
                        async: true,
                        success: function (data) {
                            firstCall = false;

                            let xAxisLabel = "Hour";
                            if (data.aggregateByDay) {
                                xAxisLabel = "Day No."
                            }
                            if (data.aggregateByMonth) {
                                xAxisLabel = "Month No."
                            }

                            RenderStaticDiscreteBarChart([data.blockmarkFailures], 'label', 'value', 'blockMarkDefectsPerHour', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                            RenderStaticDiscreteBarChart([data.pipesToDressCount], 'label', 'value', 'pipesToDress', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                            RenderStaticDiscreteBarChart([$.parseJSON(data.straightnessBPMFailures)], 'label', 'value', 'bendPerMetreFailuresBarChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                            RenderStaticDiscreteBarChart([$.parseJSON(data.straightnessTBFailures)], 'label', 'value', 'totalBendFailuresBarChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                            RenderStaticDiscreteBarChart([$.parseJSON(data.straightnessThroughput)], 'label', 'value', 'straightnessThroughputBarChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                            RenderStaticDiscreteBarChart([$.parseJSON(data.straightnessSectionFailures)], 'label', 'value', 'totalSectionFailuresBarChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                            RenderStaticDiscreteBarChart([$.parseJSON(data.sawThroughputCount)], 'label', 'value', 'sawThroughputBarChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                            RenderStaticDiscreteBarChart([$.parseJSON(data.sawToStockThroughputCount)], 'label', 'value', 'sawToStockThroughputBarChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                            RenderLineWithFocusChartDualAxisLabels('rhsStraightnessBPMLineChart', null, data.sectionTimeLabelArray, data.dateTimeLabelArray, $.parseJSON(data.bpmStraightnessBPMKeyValueJson), "Date/Section", true, "MM", true, true, false);
                            nv.addGraph(function () {
                                let chart = nv.models.multiBarChart().staggerLabels(false).stacked(false).showControls(false).legendPosition("right");

                                d3.select('#stoppagesByMachineAndType svg')
                                    .datum($.parseJSON(data.stoppageByMachineAndType))
                                    .transition().duration(500).call(chart);
                                nv.utils.windowResize(chart.update); // Intitiate listener for window resize so the chart responds and changes width.
                                return chart;
                            });

                            RenderStaticDiscreteBarChart([data.furnaceThroughput], 'label', 'value', 'furnaceThroughputBarChart', '', xAxisLabel, 'Count', '.0f', '.0f', [0,45], true, false, null, null, null, null, null);

                            nv.addGraph(function () {
                                let chart = nv.models.discreteBarChart()
                                    .x(function (d) {
                                        return d.label
                                    })
                                    .y(function (d) {
                                        return d.value
                                    })
                                    .showValues(true);


                                chart.tooltip.contentGenerator(function (obj) {
                                    let html = "<div style='padding: 5px 5px 5px 5px;'>";

                                    html += "Hour:" + obj.data.label + "</b> <br />";
                                    html += "<b>Failures: " + obj.data.value + "</b> <br /> <br />";
                                    html += "Breakdown "; // #60aeff
                                    html += "<div style='display: flex';><span style='display: block; width: 10px; height: 10px; background: #60aeff;border-radius: 50px; margin: 0 5px 0px 5px;'></span>Under:  <b>" + obj.data.UNDER_TEMP_PIPES + "</b> </div>";
                                    html += "<div style='display: flex';><span style='display: block; width: 10px; height: 10px; background: #ff8481;border-radius: 50px; margin: 0 5px 0px 5px;'></span>Over:  <b>" + obj.data.OVER_TEMP_PIPES + "</b> </div> ";
                                    html += "<div style='display: flex';><span style='display: block; width: 10px; height: 10px; background: #ff9133;border-radius: 50px; margin: 0 5px 0px 5px;'></span>Both:  <b>" + obj.data.UNDER_AND_OVER_TEMP_PIPES + " </b> </div> ";

                                    html += "</div>";
                                    return html;

                                });


                                chart.staggerLabels(true)
                                chart.margin({"left": 60, "right": 20, "top": 10, "bottom": 65})
                                chart.forceY([0, 5]);
                                chart.valueFormat(d3.format('.0f'))// Or whatever format you'd like
                                chart.yAxis
                                    .tickFormat(d3.format('.0f'))
                                    .axisLabel('Pipe Count')

                                chart.xAxis
                                    .tickFormat(d3.format('.0f'))
                                    .axisLabel(xAxisLabel)

                                d3.select('#furnaceFailuresBarChart svg')
                                    .datum([data.furnaceFailures])
                                    .call(chart);

                                nv.utils.windowResize(chart.update);
                                return chart;
                            });

                            LoadFurnaceVisibilityTable($('#weekNo').val(), $('#od').val(), $('#pr').val());
                            $('#sectionsDeallocated').html("<a href='#' id='deallocatedSectionsExportLink'>" + data.rhsDeallocatedSectionsCount + "</a>");
                            $('#rhsZumbachFailures').html("<a href='#' id='rhsZumbachFailuresExportLink'>" + data.rhsZumbachSectionFailedCount + "</a>");

                            deallocatedPipesRawData = data.rhsDeallocatedSections;
                            rhsZumbachSectionFailuresRawData = data.rhsZumbachSectionFailures;

                            UpdateStatsTable(data.rhsStats);


                            let filterValueArray = [];
                            let unfilterValueArray = [];
                            let filterUpperLimitArray = [];
                            let filterLowerLimitArray = [];
                            let northPyroValueArray = [];
                            let southPyroValueArray = [];
                            let pyroUpperLimitArray = [];
                            let pyroLowerLimitArray = [];
                            let thermalCameraValueArray = [];
                            let labelObject = {};

                            let json = $.parseJSON(data.furnaceTraces);

                            for (let i = 0; i < json.length; i++) {
                                filterValueArray.push({x: i, y: json[i].FILTER});
                                unfilterValueArray.push({x: i, y: json[i].UNFILTER});
                                northPyroValueArray.push({x: i, y: json[i].NORTH_PYRO});
                                southPyroValueArray.push({x: i, y: json[i].SOUTH_PYRO});
                                thermalCameraValueArray.push({x: i, y: json[i].THERMAL_CAMERA});
                                filterUpperLimitArray.push({x: i, y: 1000});
                                filterLowerLimitArray.push({x: i, y: 825});
                                pyroLowerLimitArray.push({x: i, y: 600});

                                labelObject[i] = json[i].TIME_STAMP;
                            }

                            console.log(filterValueArray);
                            var furnaceTraceLineChart = RenderLineWithFocusChart('rhsFurnaceTracesLineChart',
                                'lineWithFocus',
                                labelObject, [
                                    {values: filterValueArray, key: 'FILTER', color: '#f67019'},
                                    {values: northPyroValueArray, key: 'North Pyro 1', color: '#19f6b0'},
                                    {values: southPyroValueArray, key: 'North Pyro 2', color: '#1e6ed0'},
                                    {values: filterUpperLimitArray, key: 'UPPER_LIMIT', color: '#FF6384'},
                                    {values: filterLowerLimitArray, key: 'LOWER_LIMIT', color: '#FF6384'}
                                ],
                                'Degrees',
                                true,
                                'Date',
                                true,
                                true);


                        },
                        complete: function () {
                            $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                        }

                    });
                }
            }

            ///////////////////////////////////////////////
            //SET TIMER(MS) + INITIATE YIELD FIGS FUNCTION
            ///////////////////////////////////////////////
            setInterval(GetFurnaceFailuresAndBuildBarCharts, 240000);
            GetFurnaceFailuresAndBuildBarCharts();
            setInterval(GetVariableDataAndBuildChart, 280000);
            GetVariableDataAndBuildChart();
        });


        //
        //     $('.dateTimeControlButton').on('click', function () {
        //         $('.dateTimeControlButton').removeClass('btn-active');
        //         $(this).addClass('btn-active');
        //
        //         $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
        //         let filterCommand = $(this).data('filtercommand'); // Filtercommand from btn... eg PREV24, TODAY, THISWEEK
        //
        //         if (filterCommand == "today") {
        //             boolRealTimeUpdateOn = true;
        //         } else {
        //             boolRealTimeUpdateOn = false;
        //         }
        //
        //         $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
        //         $.ajax({
        //             type: "POST",
        //             data: {"dateRangeCommand": filterCommand},
        //             url: rootUrl + "/api/GetRHSDashboardData", // Pass in command to api and request new data.
        //             dataType: "json",
        //             async: true,
        //             success: function (data) {
        //                 console.log("button used");
        //                 console.log(data);
        //                 UpdateCharts(data);
        //
        //             },
        //             complete: function () {
        //                 $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
        //             }
        //         });
        //     });

            function UpdateCharts(data) {

                let xAxisLabel = "Hour";
                if (data.aggregateByDay) {
                    xAxisLabel = "Day No."
                }
                if (data.aggregateByMonth) {
                    xAxisLabel = "Month No."
                }

                RenderStaticDiscreteBarChart([data.furnaceThroughput], 'label', 'value', 'furnaceThroughputBarChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                RenderStaticDiscreteBarChart([data.blockmarkFailures], 'label', 'value', 'blockMarkDefectsPerHour', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                RenderStaticDiscreteBarChart([data.pipesToDressCount], 'label', 'value', 'pipesToDress', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                RenderStaticDiscreteBarChart([$.parseJSON(data.straightnessBPMFailures)], 'label', 'value', 'bendPerMetreFailuresBarChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                RenderStaticDiscreteBarChart([$.parseJSON(data.straightnessTBFailures)], 'label', 'value', 'totalBendFailuresBarChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                RenderStaticDiscreteBarChart([$.parseJSON(data.straightnessThroughput)], 'label', 'value', 'straightnessThroughputBarChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                RenderStaticDiscreteBarChart([$.parseJSON(data.straightnessSectionFailures)], 'label', 'value', 'totalSectionFailuresBarChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                RenderStaticDiscreteBarChart([$.parseJSON(data.sawThroughputCount)], 'label', 'value', 'sawThroughputBarChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                RenderStaticDiscreteBarChart([$.parseJSON(data.sawToStockThroughputCount)], 'label', 'value', 'sawToStockThroughputBarChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                RenderLineWithFocusChartDualAxisLabels('rhsStraightnessBPMLineChart', null, data.sectionTimeLabelArray, data.dateTimeLabelArray, $.parseJSON(data.bpmStraightnessBPMKeyValueJson), "Date/Section", true, "MM", true, true, false);

                nv.addGraph(function () {
                    let chart = nv.models.multiBarChart().staggerLabels(false).stacked(false).showControls(false).legendPosition("right");

                    d3.select('#stoppagesByMachineAndType svg')
                        .datum($.parseJSON(data.stoppageByMachineAndType))
                        .transition().duration(500).call(chart);
                    nv.utils.windowResize(chart.update); // Intitiate listener for window resize so the chart responds and changes width.
                    return chart;
                });

                nv.addGraph(function () {
                    let chart = nv.models.discreteBarChart()
                        .x(function (d) {
                            return d.label
                        })
                        .y(function (d) {
                            return d.value
                        })
                        .showValues(true);


                    chart.tooltip.contentGenerator(function (obj) {
                        let html = "<div style='padding: 5px 5px 5px 5px;'>";

                        html += "Hour:" + obj.data.label + "</b> <br />";
                        html += "<b>Failures: " + obj.data.value + "</b> <br /> <br />";
                        html += "Breakdown "; // #60aeff
                        html += "<div style='display: flex';><span style='display: block; width: 10px; height: 10px; background: #60aeff;border-radius: 50px; margin: 0 5px 0px 5px;'></span>Under:  <b>" + obj.data.UNDER_TEMP_PIPES + "</b> </div>";
                        html += "<div style='display: flex';><span style='display: block; width: 10px; height: 10px; background: #ff8481;border-radius: 50px; margin: 0 5px 0px 5px;'></span>Over:  <b>" + obj.data.OVER_TEMP_PIPES + "</b> </div> ";
                        html += "<div style='display: flex';><span style='display: block; width: 10px; height: 10px; background: #ff9133;border-radius: 50px; margin: 0 5px 0px 5px;'></span>Both:  <b>" + obj.data.UNDER_AND_OVER_TEMP_PIPES + " </b> </div> ";

                        html += "</div>";
                        return html;

                    });


                    chart.staggerLabels(true)
                    chart.margin({"left": 60, "right": 20, "top": 10, "bottom": 65})
                    chart.forceY([0, 5]);
                    chart.valueFormat(d3.format('.0f'))// Or whatever format you'd like
                    chart.yAxis
                        .tickFormat(d3.format('.0f'))
                        .axisLabel('Pipe Count')

                    chart.xAxis
                        .tickFormat(d3.format('.0f'))
                        .axisLabel(xAxisLabel);


                    d3.select('#furnaceFailuresBarChart svg')
                        .datum([data.furnaceFailures])
                        .call(chart);

                    nv.utils.windowResize(chart.update);
                    return chart;
                });

                $('#sectionsDeallocated').html("<a href='#' id='rhsZumbachFailuresExportLink'>" + data.rhsDeallocatedSectionsCount + "</a>");
                $('#rhsZumbachFailures').html("<a href='#' id='rhsZumbachFailuresExportLink'>" + data.rhsZumbachSectionFailedCount + "</a>");
                deallocatedPipesRawData = data.rhsDeallocatedSections;
                rhsZumbachSectionFailuresRawData = data.rhsZumbachSectionFailures;
                UpdateStatsTable(data.rhsStats);

                let filterValueArray = [];
                let unfilterValueArray = [];
                let filterUpperLimitArray = [];
                let filterLowerLimitArray = [];
                let northPyroValueArray = [];
                let southPyroValueArray = [];
                let pyroUpperLimitArray = [];
                let pyroLowerLimitArray = [];
                let thermalCameraValueArray = [];
                let labelObject = {};

                let json = $.parseJSON(data.furnaceTraces);

                for (let i = 0; i < json.length; i++) {
                    filterValueArray.push({x: i, y: json[i].FILTER});
                    unfilterValueArray.push({x: i, y: json[i].UNFILTER});
                    northPyroValueArray.push({x: i, y: json[i].NORTH_PYRO});
                    southPyroValueArray.push({x: i, y: json[i].SOUTH_PYRO});
                    thermalCameraValueArray.push({x: i, y: json[i].THERMAL_CAMERA});
                    filterUpperLimitArray.push({x: i, y: 1000});
                    filterLowerLimitArray.push({x: i, y: 825});
                    pyroLowerLimitArray.push({x: i, y: 600});

                    labelObject[i] = json[i].TIME_STAMP;
                }

                console.log(filterValueArray);
                var furnaceTraceLineChart = RenderLineWithFocusChart('rhsFurnaceTracesLineChart',
                    'lineWithFocus',
                    labelObject, [
                        {values: filterValueArray, key: 'FILTER', color: '#f67019'},
                        {values: northPyroValueArray, key: 'North Pyro 1', color: '#19f6b0'},
                        {values: southPyroValueArray, key: 'North Pyro 2', color: '#1e6ed0'},
                        {values: filterUpperLimitArray, key: 'UPPER_LIMIT', color: '#FF6384'},
                        {values: filterLowerLimitArray, key: 'LOWER_LIMIT', color: '#FF6384'}
                    ],
                    'Degrees',
                    true,
                    'Date',
                    true,
                    true);





        }

        // Format object data into nvd3 formatted object.
        function FurnaceTempPerformanceDataSorter(data) {
            return [
                {"label": "PASS", "value": data.GOOD_PIPE_TEMP},
                {"label": "UNDER", "value": data.UNDER_TEMP_PIPES},
                {"label": "OVER", "value": data.OVER_TEMP_PIPES},
                {"label": "BOTH", "value": data.UNDER_AND_OVER_TEMP_PIPES}
            ];
        }

        function GetVariableDataAndBuildChart() {
            $.ajax({
                type: "GET",
                data: {"noOfMeasurements": 70},
                url: rootUrl + "/api/GetRecentLengthOfSideMeasurements",
                dataType: "json",
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css("display", "block");
                },
                success: function (d) {
                    BuildLengthOfSideChart(d.diaData)
                    BuildLengthOfShortSideChart(d.dia2Data)
                    BuildLengthOfLongSideChart(d.dia1Data)

                },
                complete: function () {
                    $('.ajax-loader').css("display", "none");
                }
            });

        }


        function BuildLengthOfSideChart(d) {
            /**
             * Fill local arrays with data from data object.
             */
            let variableData = d;
            console.log(variableData);
            let lengthOfSideMeas1Array = [];
            let lengthOfSideMeas2Array = [];
            let lengthOfSideMeas3Array = [];
            let lengthOfSideMeas4Array = [];
            let lengthOfSideUCLArray = [];
            let lengthOfSideLCLArray = [];

            let size1 = [];
            let size2 = [];
            let thick = [];

            let xAxis1Labels = {};
            let xAxis2Labels = {};
            for (let i = 0; i < variableData.length; i++) { // Only show last 50 measurements
                xAxis1Labels[i] = variableData[i].TRACK_CODE;
                let dt = new Date(variableData[i].DATETIME_TANDEM);
                xAxis2Labels[i] = dt.getDate() + "-" + (dt.getMonth() + 1) + "-" + dt.getFullYear() + " " +
                    dt.getHours() + ":" + dt.getMinutes();

                // Length Of Side

                lengthOfSideMeas1Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_1});
                lengthOfSideMeas2Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_2});
                lengthOfSideMeas3Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_3});
                lengthOfSideMeas4Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_4});
                lengthOfSideLCLArray.push({
                    x: i,
                    y: variableData[i].PIPE_SIZE1 - (variableData[i].PIPE_SIZE1 * 0.005)
                });
                lengthOfSideUCLArray.push({
                    x: i,
                    y: +variableData[i].PIPE_SIZE1 + (variableData[i].PIPE_SIZE1 * 0.005)
                });

            }
//#FF6384
            let lengthOfSideLineChart = RenderLineChart('lengthOfSideLineChart',
                'lineWithFocus',
                xAxis1Labels, xAxis2Labels, [
                    {values: lengthOfSideMeas1Array, key: 'DIA Meas 1'},
                    {values: lengthOfSideMeas2Array, key: 'DIA Meas 2'},
                    {values: lengthOfSideMeas3Array, key: 'DIA Meas 3'},
                    {values: lengthOfSideMeas4Array, key: 'DIA Meas 4'},
                    {values: lengthOfSideLCLArray, key: 'LCL', color: '#FF6384'},
                    {values: lengthOfSideUCLArray, key: 'UCL', color: '#FF6384'}
                ],
                'Date/Section',
                true,
                'MM',
                true,
                true,
                []);
        }

        function BuildLengthOfShortSideChart(d) {
            /**
             * Fill local arrays with data from data object.
             */
            let variableData = d;
            console.log(variableData);
            let lengthOfShortSideMeas1Array = [];
            let lengthOfShortSideMeas2Array = [];
            let lengthOfShortSideUCLArray = [];
            let lengthOfShortSideLCLArray = [];


            let xAxis1Labels = {};
            let xAxis2Labels = {};
            for (let i = 0; i < variableData.length; i++) { // Only show last 50 measurements
                xAxis1Labels[i] = variableData[i].TRACK_CODE;
                let dt = new Date(variableData[i].DATETIME_TANDEM);
                xAxis2Labels[i] = dt.getDate() + "-" + (dt.getMonth() + 1) + "-" + dt.getFullYear() + " " +
                    dt.getHours() + ":" + dt.getMinutes();

                // Length Of Side

                lengthOfShortSideMeas1Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_1});
                lengthOfShortSideMeas2Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_2});
                lengthOfShortSideLCLArray.push({
                    x: i,
                    y: variableData[i].PIPE_SIZE2 - (variableData[i].PIPE_SIZE2 * 0.005)
                });
                lengthOfShortSideUCLArray.push({
                    x: i,
                    y: +variableData[i].PIPE_SIZE2 + (variableData[i].PIPE_SIZE2 * 0.005)
                });
            }
//#FF6384
            let lengthOfSideLineChart = RenderLineChart('lengthOfShortSideLineChart',
                'lineWithFocus',
                xAxis1Labels, xAxis2Labels, [
                    {values: lengthOfShortSideMeas1Array, key: 'DIA Meas 1'},
                    {values: lengthOfShortSideMeas2Array, key: 'DIA Meas 2'},
                    {values: lengthOfShortSideLCLArray, key: 'LCL', color: '#FF6384'},
                    {values: lengthOfShortSideUCLArray, key: 'UCL', color: '#FF6384'}
                ],
                'Date/Section',
                true,
                'MM',
                true,
                true,
                []);
        }

        function BuildLengthOfLongSideChart(d) {
            /**
             * Fill local arrays with data from data object.
             */
            let variableData = d;
            console.log(variableData);
            let lengthOfLongSideMeas1Array = [];
            let lengthOfLongSideMeas2Array = [];
            let lengthOfLongSideUCLArray = [];
            let lengthOfLongSideLCLArray = [];

            let xAxis1Labels = {};
            let xAxis2Labels = {};
            for (let i = 0; i < variableData.length; i++) { // Only show last 50 measurements
                xAxis1Labels[i] = variableData[i].TRACK_CODE;
                let dt = new Date(variableData[i].DATETIME_TANDEM);
                xAxis2Labels[i] = dt.getDate() + "-" + (dt.getMonth() + 1) + "-" + dt.getFullYear() + " " +
                    dt.getHours() + ":" + dt.getMinutes();

                // Length Of Side

                lengthOfLongSideMeas1Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_1});
                lengthOfLongSideMeas2Array.push({x: i, y: variableData[i].VARIABLE_MEASUREMENT_2});
                lengthOfLongSideLCLArray.push({
                    x: i,
                    y: variableData[i].PIPE_SIZE1 - (variableData[i].PIPE_SIZE1 * 0.005)
                });
                lengthOfLongSideUCLArray.push({
                    x: i,
                    y: +variableData[i].PIPE_SIZE1 + (variableData[i].PIPE_SIZE1 * 0.005)
                });
            }
//#FF6384
            let lengthOfSideLineChart = RenderLineChart('lengthOfLongSideLineChart',
                'lineWithFocus',
                xAxis1Labels, xAxis2Labels, [
                    {values: lengthOfLongSideMeas1Array, key: 'DIA Meas 1'},
                    {values: lengthOfLongSideMeas2Array, key: 'DIA Meas 2'},
                    {values: lengthOfLongSideLCLArray, key: 'LCL', color: '#FF6384'},
                    {values: lengthOfLongSideUCLArray, key: 'UCL', color: '#FF6384'}
                ],
                'Date/Section',
                true,
                'MM',
                true,
                true,
                []);
        }


        $("#weekNo, #od, #pr").focusout(function () {
            let weekNo = $('#weekNo').val();
            let od = $('#od').val();
            let pr = $('#pr').val();

            LoadFurnaceVisibilityTable(weekNo, od, pr);

        });

        function LoadFurnaceVisibilityTable(weekNo, od, pr) {
            if (weekNo !== "" && od !== "" && pr !== "") {
                $('#furnaceVisibility').html('Loading......')
                $.ajax({
                    type: "POST",
                    data: {"weekNo": weekNo, "od": od, "pr": pr},
                    url: rootUrl + "/api/GetFurnaceVisibility", // Pass in command to api and request new data.
                    dataType: "json",
                    async: true,
                    success: function (data) {
                        if (data.length == 0) {
                            $('#furnaceVisibility').html('No data found.... please try another variation')
                        } else {
                            $('#furnaceVisibility').html(BuildFurnaceVisibilityHTMLTable(data));
                        }

                    }
                });
            }
        }


        function BuildFurnaceVisibilityHTMLTable(data) {
            let tbl = '<table class="table" id="furnaceVisibilityTable">\n' +
                '                        <thead>\n' +
                '                        <th>SIZE</th>\n' +
                '                        <th>PR</th>\n' +
                '                        <th>PROG</th>\n' +
                '                        <th>ROLLED</th>\n' +
                '                        <th>FURN</th>\n' +
                '                        <th>BAL</th>\n' +
                '                        </thead>\n' +
                '                    <tbody>';

            $.each(data, function (index, value) {
                tbl += '<tr>';
                tbl += '<td>' + value.SIZE + '</td>';
                tbl += '<td>' + value.PROCESS_ROUTE.PROCESS_ROUTE + '</td>';
                tbl += '<td>' + value.PROGRAMMED_PIPES + '</td>';
                tbl += '<td>' + value.ROLLED_PIPES + '</td>';
                tbl += '<td>' + value.FURNACE_PIPES + '</td>';
                tbl += '<td>' + value.BALANCE + '</td>';
                tbl += '</tr>';
            });
            tbl += '</tbody></table>';
            console.log(tbl);
            return tbl;
        }

        $("body").on("click", "a#deallocatedSectionsExportLink", function (e) {
            e.preventDefault();
            //exporting to csv ref: https://stackoverflow.com/questions/14964035/how-to-export-javascript-array-info-to-csv-on-client-side
            let csvContent = "data:text/csv;charset=utf-8,";

            csvContent += "DATE,FROM_POS,TO_POS,CURRENT_POS,PIPE_NO,SECTION_NO,CUST_ORDER,CUST_ITEM,COMPLETE_FLAG,ORDER_POS" + "\r\n";

            for (const [key, value] of Object.entries(deallocatedPipesRawData)) {

                let row = value["DATETIME_TANDEM"] + "," + value["FROM_ROUTING_POS"] + "," + value["TO_ROUTING_POS"] + "," + value["ROUTING_POS"]
                    + "," + value["TRACK_CODE"] + "," + value["TRACK_CODE_ALT"] + "," + value["CUST_ORDER"] + "," + value["CUST_ITEM_X"] + "," + value["COMPLETE_FLAG"] + "," + value["ORDER_POS"];
                csvContent += row + "\r\n";
            }

            console.log(csvContent);
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "deallocated-sections.csv");
            document.body.appendChild(link); // Required for FF

            link.click(); // This will download the data file named "deallocated-sections.csv".
        });


        $("body").on("click", "a#rhsZumbachFailuresExportLink", function (e) {
            e.preventDefault();
            console.log("ZUM FAILURES");
            //exporting to csv ref: https://stackoverflow.com/questions/14964035/how-to-export-javascript-array-info-to-csv-on-client-side
            let csvContent = "data:text/csv;charset=utf-8,";

            csvContent += "DATE,SECTION,ACROSS_CORNER_TN_BS_V_FRONT,ACROSS_CORNER_TS_BN_V_FRONT,CONVEXITY_B_V_FRONT,CONVEXITY_N_V_FRONT,CONVEXITY_S_V_FRONT," +
                "CONVEXITY_T_V_FRONT,CORNER_ANGLE_BN_V_FRONT,CORNER_ANGLE_BS_V_FRONT,CORNER_ANGLE_TN_V_FRONT,CORNER_ANGLE_TS_V_FRONT,CORNER_RADIUS_BN_V_FRONT," +
                "CORNER_RADIUS_BS_V_FRONT,CORNER_RADIUS_TN_V_FRONT,CORNER_RADIUS_TS_V_FRONT,OD_HORIZONTAL_B_V_FRONT,OD_HORIZONTAL_T_V_FRONT,OD_VERTICAL_N_V_FRONT," +
                "OD_VERTICAL_S_V_FRONT,   ACROSS_CORNER_TN_BS_V_MIDDLE,ACROSS_CORNER_TS_BN_V_MIDDLE,CONVEXITY_B_V_MIDDLE,CONVEXITY_N_V_MIDDLE,CONVEXITY_S_V_MIDDLE,CONVEXITY_T_V_MIDDLE,CORNER_ANGLE_BN_V_MIDDLE,CORNER_ANGLE_BS_V_MIDDLE,CORNER_ANGLE_TN_V_MIDDLE,CORNER_ANGLE_TS_V_MIDDLE,CORNER_RADIUS_BN_V_MIDDLE,CORNER_RADIUS_BS_V_MIDDLE,CORNER_RADIUS_TN_V_MIDDLE,CORNER_RADIUS_TS_V_MIDDLE,OD_HORIZONTAL_B_V_MIDDLE,OD_HORIZONTAL_T_V_MIDDLE,OD_VERTICAL_N_V_MIDDLE,OD_VERTICAL_S_V_MIDDLE,       ACROSS_CORNER_TN_BS_V_REAR,ACROSS_CORNER_TS_BN_V_REAR,CONVEXITY_B_V_REAR,CONVEXITY_N_V_REAR,CONVEXITY_S_V_REAR,CONVEXITY_T_V_REAR,CORNER_ANGLE_BN_V_REAR,CORNER_ANGLE_BS_V_REAR,CORNER_ANGLE_TN_V_REAR,CORNER_ANGLE_TS_V_REAR,CORNER_RADIUS_BN_V_REAR,CORNER_RADIUS_BS_V_REAR,CORNER_RADIUS_TN_V_REAR,CORNER_RADIUS_TS_V_REAR,OD_HORIZONTAL_B_V_REAR,OD_HORIZONTAL_T_V_REAR,OD_VERTICAL_N_V_REAR,OD_VERTICAL_S_V_REAR" + "\r\n";

            for (const [key, value] of Object.entries(rhsZumbachSectionFailuresRawData)) {

                let row = value["DATETIME_TANDEM"] + "," + key + "," + value.FRONT.ACROSS_CORNER_TN_BS_V + "," + value.FRONT.ACROSS_CORNER_TS_BN_V + "," +
                    value.FRONT.CONVEXITY_B_V + "," + value.FRONT.CONVEXITY_N_V + "," + value.FRONT.CONVEXITY_S_V + "," + value.FRONT.CONVEXITY_T_V + "," +
                    value.FRONT.CORNER_ANGLE_BN_V + "," + value.FRONT.CORNER_ANGLE_BS_V + "," + value.FRONT.CORNER_ANGLE_TN_V + "," +
                    value.FRONT.CORNER_ANGLE_TS_V + "," + value.FRONT.CORNER_RADIUS_BN_V + "," +
                    value.FRONT.CORNER_RADIUS_BS_V + "," + value.FRONT.CORNER_RADIUS_TN_V + "," + value.FRONT.CORNER_RADIUS_TS_V
                    + "," + value.FRONT.OD_HORIZONTAL_B_V + "," + value.FRONT.OD_HORIZONTAL_T_V + "," + value.FRONT.OD_VERTICAL_N_V + "," +
                    value.FRONT.OD_VERTICAL_S_V + "," + value.MIDDLE.ACROSS_CORNER_TN_BS_V + "," + value.MIDDLE.ACROSS_CORNER_TS_BN_V + "," +
                    value.MIDDLE.CONVEXITY_B_V + "," + value.MIDDLE.CONVEXITY_N_V + "," + value.MIDDLE.CONVEXITY_S_V + "," + value.MIDDLE.CONVEXITY_T_V + "," +
                    value.MIDDLE.CORNER_ANGLE_BN_V + "," + value.MIDDLE.CORNER_ANGLE_BS_V + "," + value.MIDDLE.CORNER_ANGLE_TN_V + "," +
                    value.MIDDLE.CORNER_ANGLE_TS_V + "," + value.MIDDLE.CORNER_RADIUS_BN_V + "," +
                    value.MIDDLE.CORNER_RADIUS_BS_V + "," + value.MIDDLE.CORNER_RADIUS_TN_V + "," + value.MIDDLE.CORNER_RADIUS_TS_V
                    + "," + value.MIDDLE.OD_HORIZONTAL_B_V + "," + value.MIDDLE.OD_HORIZONTAL_T_V + "," + value.MIDDLE.OD_VERTICAL_N_V + "," +
                    value.MIDDLE.OD_VERTICAL_S_V + "," + value.REAR.ACROSS_CORNER_TN_BS_V + "," + value.REAR.ACROSS_CORNER_TS_BN_V + "," +
                    value.REAR.CONVEXITY_B_V + "," + value.REAR.CONVEXITY_N_V + "," + value.REAR.CONVEXITY_S_V + "," + value.REAR.CONVEXITY_T_V + "," +
                    value.REAR.CORNER_ANGLE_BN_V + "," + value.REAR.CORNER_ANGLE_BS_V + "," + value.REAR.CORNER_ANGLE_TN_V + "," +
                    value.REAR.CORNER_ANGLE_TS_V + "," + value.REAR.CORNER_RADIUS_BN_V + "," +
                    value.REAR.CORNER_RADIUS_BS_V + "," + value.REAR.CORNER_RADIUS_TN_V + "," + value.REAR.CORNER_RADIUS_TS_V
                    + "," + value.REAR.OD_HORIZONTAL_B_V + "," + value.REAR.OD_HORIZONTAL_T_V + "," + value.REAR.OD_VERTICAL_N_V + "," +
                    value.REAR.OD_VERTICAL_S_V;
                csvContent += row + "\r\n";
            }

            console.log(csvContent);
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "zumbach-failures-raw-data.csv");
            document.body.appendChild(link); // Required for FF

            link.click(); // This will download the data file named "my_data.csv".
        });


        function UpdateStatsTable(d) {
            let tbl = "<tr><td colspan='5' style='text-align: center; font-weight: bold'>PRODUCTION</td></tr>";
            tbl += "<tr><td>1CLG</td><td>" + (d.clg1Stats.tons == undefined ? 0 : d.clg1Stats.tons) + "</td><td>" + (d.clg1Stats.metres == undefined ? 0 : d.clg1Stats.metres) + "</td><td>" + (d.clg1Stats.pipes == undefined ? 0 : d.clg1Stats.pipes) + "</td></tr>";
            tbl += "<tr><td>2SAW (Incl ex-Stock)</td><td>" + (d.saw2Stats.tons + d.rwkdStats.tons).toFixed(3) + "</td><td>" + (d.saw2Stats.metres + d.rwkdStats.metres).toFixed(3) + "</td><td>" + (d.saw2Stats.pipes + d.rwkdStats.pipes) + "</td></tr>";
            // tbl += "<tr><td>SCRAP</td><td>" + d.finishingScrapStats.tons + "</td><td>" + d.finishingScrapStats.metres + "</td><td>" + d.finishingScrapStats.pipes + "</td><td>0</td></tr>";
            // tbl += "<tr><td>DGS</td><td>" + d.finishingDGStats.tons + "</td><td>" + d.finishingDGStats.metres + "</td><td>" + d.finishingDGStats.pipes + "</td><td>0</td></tr>";
            // tbl += "<tr><td colspan='5' style='text-align: center; font-weight: bold'>ALLOCATION</td></tr>";
            //
            // tbl += "<tr><td>4ALL</td><td>" + d.all4Stats.tons + "</td><td>" + d.all4Stats.metres + "</td><td>" + d.all4Stats.pipes + "</td><td>" + ((d.all4Stats.tons / d.mar2Stats.tons) * 100).toFixed(2) + "%</td></tr>";
            // tbl += "<tr><td>4STO (Surplus Stock)</td><td>" + d.sto4Stats.tons + "</td><td>" + d.sto4Stats.metres + "</td><td>" + d.sto4Stats.pipes + "</td><td>" + ((d.sto4Stats.tons / d.mar2Stats.tons) * 100).toFixed(2) + "%</td></tr>";
            // tbl += "<tr><td>IDST (Non-prime stock)</td><td>" + d.idstStats.tons + "</td><td>" + d.idstStats.metres + "</td><td>" + d.idstStats.pipes + "</td><td>" + ((d.idstStats.tons / d.mar2Stats.tons) * 100).toFixed(2) + "%</td></tr>";
            // tbl += "<tr><td>4DGR (Non-prime stock)</td><td>" + d.dgr4Stats.tons + "</td><td>" + d.dgr4Stats.metres + "</td><td>" + d.dgr4Stats.pipes + "</td><td>" + ((d.dgr4Stats.tons / d.mar2Stats.tons) * 100).toFixed(2) + "%</td></tr>";

            $('#finishingStatsTable').find('tbody').html(tbl);

        }

    </script>
@endsection
