@extends('layouts.app')

@section('pageTitle', 'Weld Mill Main Dashboard')
@section('pageName', 'Weld Mill Main Dashboard')
@section('weldMillActiveLink', 'active activeUnderline')
@section('css')
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/plotly.basic.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pivot.css?v=1.2.1')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
    <style>
        table.pvtTable {
            width: 100%;
        }

        .flatteningFailureData {
            display: flex;
            width: 540px;
            overflow: scroll;
            margin-left: auto;
            margin-right: auto;
        }

        .flatteningFailureData > div {
            min-width: 130px;
        }

        .global-back-button {
            width: 70px;
            position: relative;
            height: 60px;
            margin: -30px 0 0px 30px;
        }
    </style>
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
                url: rootUrl + '/api/GetWeldMillMainDashboardData',
                success: function (data) {
                console.log(data);
                BuildDashboard(data);
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
                <span id="weldMillStatus"
                      style="display: none; position: absolute; right: 25px;top: 128px; font-size: 26px; color: yellow; background: red;border-radius: 3px;">
            Weld Mill Stopped <span id="minsStopped"></span>
        </span>


            </div>

                <div>
            <span id="millSpeed" style="font-size:18px;">
            <span id="weldMillSizingSpeed"></span>
        </span>
                </div>


            <div class="dashboard-flex">
                <div class="dashboard-left-col">
                    <div class="dashboard-flex-card dashboard-flex-sm" style="height: 380px;">
                        <div class="dashboard-box-container-header"><h5>WeldMill Stats</h5></div>
                        <table class="table table-bordered table-reduced-padding" id="wmStatsTable">
                            <thead class="thead-light">
                            <th>Weld Mill</th>
                            <th>Tons</th>
                            <th>Metres</th>
                            <th>%</th>
                            <th>Report</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div class="dashboard-flex-card dashboard-flex-sm" style="min-width: 100%;">
                        <div class="dashboard-box-container-header"><h5>Last Recorded Macro</h5></div>
                        <div id="lastMacroImageAndInfo">


                        </div>
                    </div>

                    <div class="dashboard-flex-card dashboard-flex-sm" style="min-width: 100%;">
                        <div class="dashboard-box-container-header"><h5>Last Dimensional Verif</h5></div>
                        <div id="lastDimensionalVerification">
                        </div>
                    </div>

                    <div class="dashboard-flex-card dashboard-flex-sm" style="height:285px;">
                        <div class="dashboard-box-container-header"><h5>WM Stoppage Performance</h5></div>
                        <table class="table table-bordered table-reduced-padding" id="wmStoppagePerformanceTable">
                            <thead class="thead-light">
                            <th>Weld Mill Availability</th>
                            <th>Performance</th>
                            <th>Detail</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="dashboard-middle-col">
                    <div class="dashboard-flex-card dashboard-flex-xl">
                        <div class="dashboard-box-container-header"><h5>Tons Per Hour 1DCO</h5></div>

                        <div class="text-center">
                            Standard/<span id="standardHOrDLabel">h</span>: <span id="standardTonsPerHourValue"></span>
                            <br/>
                            <!-- bestHourTonnageValue value injected from js -->
                            Best <span id="hourOrDayLabel">Hour</span>: <span id="bestHourTonnageValue"></span>
                            <br/>
                            <!-- averageHourTonnageValue value injected from js -->
                            Average/<span id="averageHOrDLabel">h</span>: <span id="averageHourTonnageValue"></span>
                        </div>

                        <div id="throughputChart" style="height: 300px; width:100%;    margin-top: 0.5em;">
                            <svg></svg>
                        </div>
                    </div>

                    <div class="dashboard-flex-card dashboard-flex-xl">
                        <div class="dashboard-box-container-header"><h5>WM Stoppage Mins Stopped By Hour</h5> <a
                                href="{{route('wm-stoppage-analysis-dashboard')}}">Stoppage Analysis ></a></div>

                        <div id="wmStopsByHourChart" style="height: 300px; width:100%;   margin-top: 0.5em;">
                            <svg></svg>
                        </div>
                    </div>

                    <div class="dashboard-flex-card dashboard-flex-xl">
                        <div class="dashboard-box-container-header"><h5>Tons By Status / PR</h5></div>
                        <div id="tonsByStatusAndPRPivot" width="100%"></div>

                        <button class="coilPipePivotReportLoaderButton btn btn-primary mt-2"
                                style="display: block; margin:auto;" data-reportid="234">View Report
                        </button>
                    </div>
                </div>

                <div class="dashboard-right-col">
                    <div class="dashboard-flex-card dashboard-flex-xl">
                        <div class="dashboard-box-container-header"><h5>WM Mech/Elec Stops</h5></div>
                        <div id="wmEngineeringStopsChart" style="height: 500px; width: 500px;">
                            <svg></svg>
                        </div>
                        <hr/>
                        <div>
                            <h5>Flattening Failures</h5>

                            <div id="flatteningFailuresCount"></div>
                            <div id="flatteningFailureData" class="flatteningFailureData"></div>
                        </div>
                    </div>

                    <div class="dashboard-flex-card dashboard-flex-xl">
                        <div class="dashboard-box-container-header"><h5>THK Variable Data</h5></div>

                        <div id="thicknessLineChart" style="height:450px;" class="with-3d-shadow with-transitions">
                            <svg></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-flex-card">
                <div class="dashboard-box-container-header"><h5>1DCO & 1CRP Throughput</h5></div>
                <h6>1DCO</h6>
                <div id="pipeThroughputChart1DCO" style="height: 100px; width:100%;">
                    <svg></svg>
                </div>
                <hr/>
                <h6>1CRP</h6>
                <div id="pipeThroughputChart1CRP" style="height: 100px; width:100%;">
                    <svg></svg>
                </div>

                <div class="dashboard-box-container-header"><h5>WM 1CRP WIP</h5></div>

                <div id="weldMillWipBySizeAge" style="height: 450px; width:100%;    margin-top: 2em;">
                    <svg></svg>
                </div>


            </div>

{{--                <video controls="" preload="auto" id="_video"></video>--}}

            <!-- here for now -->

            @endsection
            @section('functionalScripts')
                <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
                <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
                <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
{{--                <script src="https://jwpsrv.com/library/7O9sNNqCEeKKbiIACqoQEQ.js"></script>--}}
                <script type="text/javascript" src="{{ asset('public/js/pivotJS/jqueryUI.min.js')}}"></script>
                <script type="text/javascript" src="{{ asset('public/js/pivotJS/pivot.min.js')}}"></script>
                <script type="text/javascript" src="{{ asset('public/js/pivotJS/plotly-renderers.js')}}"></script>

                    <script>



                        $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    let flatteningTestFailures = "";

                    // On Page Load, get the data from API.
                    function BuildDashboard(jsonData) {

                        let throughputJson = $.parseJSON(jsonData.throughputTonnage1DCO);
                        console.log(throughputJson);
                        let throughputAverage = jsonData.throughputAverageTonnage;
                        let wmStopsByHourJson = $.parseJSON(jsonData.weldMillStopsByHourJSON);
                        let wmEngineeringStopsByReasonTypeJson = $.parseJSON(jsonData.weldMillEngineeringStopsJSON);
                        let weldMill1DCOPipeThroughputJSON = $.parseJSON(jsonData.weldMill1DCOPipeThroughputJSON);
                        let weldMill1CRPPipeThroughputJSON = $.parseJSON(jsonData.weldMill1CRPPipeThroughputJSON);
                        let weldMillWipByAgeSize = $.parseJSON(jsonData.weldMillWipBySizeAgeJSON);
                        let weldMillStatsObj = $.parseJSON(jsonData.weldMillStatisticsYieldArray);
                        let weldMillStoppagePerformanceObj = $.parseJSON(jsonData.weldMillStoppagePerformanceData);
                        let weldMillStoppagesHourlyLimits = $.parseJSON(jsonData.weldMillStoppagesHourlyLimits);
                        flatteningTestFailures = jsonData.failedFlatteningTests;
                        let flatteningTestFailureCount = jsonData.failedFlatteningTests.length;

                        console.log("flatteners", flatteningTestFailureCount);


                        // Build WeldMillStats & Stoppage Performance <tbody's>
                        BuildWMStatsTBody(weldMillStatsObj);
                        BuildWMStoppagePerformanceTBody(weldMillStoppagePerformanceObj);


                        /**
                         * Build Tons Per Hour 1DCO MultiChart
                         * ********************************
                         */

                            // prep arrays
                        let tonnesByHourArray = [];
                        let daysBetweenDateRange = jsonData.daysBetweenDateRange; // Get days between date range int from json - Used for multiplying standard / allowed stoppage time
                        let averageAcrossHoursArray = []; // will be filled with static throughputAverage value to produce full line across chart.
                        let stdAcrossHoursArray = []; // will be filled with static throughputTonnage standard value to produce full line across chart.
                        let labelObject = {}; // Hour labels
                        const standardTonnagePerHour = jsonData.standardHourlyTonnes;
                        console.log(throughputJson);
                        let i = 0;
                        let keys = Object.keys(throughputJson)
                        console.log("KEYS OF HOURS" , keys);
                        for (let key of keys) { // Loop over throughput json pushing hour, tonnesByHour and static avg and standard values to arrays.
                            // console.log(key);
                            labelObject[i] = key;
                            tonnesByHourArray.push({x: i, y: parseFloat(throughputJson[key].tons).toFixed(2)}); // round to two decimal place.
                            averageAcrossHoursArray.push({x: i, y: throughputAverage});
                            stdAcrossHoursArray.push({x: i, y: throughputJson[key].standard});
                            i++;
                        }
                        console.log(stdAcrossHoursArray);
                        $('#standardHOrDLabel').html((daysBetweenDateRange == 1 ? "h" : "d"))
                        $('#standardTonsPerHourValue').html(standardTonnagePerHour + " Tonnes"); // Update standardTonsPerHourValue element with standard tonnage value.

                        // build data array of objs for nvd3 chart.
                        let data = [
                            {values: tonnesByHourArray, key: 'TONNES_BY_HOUR', color: '#8db4e3', bar: true},
                            {
                                values: averageAcrossHoursArray,
                                key: 'AVG',
                                color: (throughputAverage >= standardTonnagePerHour ? '#9bbb58' : '#ff0000')
                            },
                            {values: stdAcrossHoursArray, key: 'STD', color: '#f89748'},
                        ];

                        // To quick fix dual axis force Y values, get the max value in tonnage array and if more than 175, use it + 100.
                        let maxTonnage = Math.max.apply(Math, tonnesByHourArray.map(function (o) {
                            return o.y;
                        }));
                        // Due to linePlusBarChart unable to handle further draw calls without clearing, remove the svg completely, append and re render.
                        d3.select("#throughputChart svg").remove();
                        d3.select("#throughputChart").append("svg");


                        // Configure and call the LinePlusBarChart for 'TonsPerHour1DCO'
                        nv.addGraph(function () {
                            let chart = nv.models.linePlusBarChart()
                                .margin({top: 30, right: 60, bottom: 50, left: 70})
                                .options({focusEnable: false});

                            chart.interactive(false);

                            chart.xAxis
                                .axisLabel((daysBetweenDateRange == 1 ? "Hour" : "Month/Day"))
                                .tickFormat(function (d) {
                                    return labelObject[d];
                                }).staggerLabels(false);

                            chart.y1Axis
                                .axisLabel("Tonnes");

                            // Force Y axis 1 & 2 to keep both scales in sync.
                            chart.bars.forceY([0, (maxTonnage > 175 ? maxTonnage + 100 : 175)]);
                            chart.lines.forceY([0, (maxTonnage > 175 ? maxTonnage + 100 : 175)]);

                            d3.select('#throughputChart svg')
                                .datum(data)
                                .transition().duration(500).call(chart);
                            nv.utils.windowResize(chart.update); // Intitiate listener for window resize so the chart responds and changes width.
                            return chart;
                        });

                        $('#averageHOrDLabel').html((daysBetweenDateRange == 1 ? "h" : "d"))
                        // Add the average/h value to the averageHourTonnageValue element -
                        if (throughputAverage >= standardTonnagePerHour) {
                            $('#averageHourTonnageValue').html(throughputAverage + " Tonnes").css('color', 'green');
                        } else {
                            $('#averageHourTonnageValue').html(throughputAverage + " Tonnes").css('color', 'red');
                        }

                        $('#hourOrDayLabel').html((daysBetweenDateRange == 1 ? "Hour" : "Day"))
                        // Add the bestHour value to the bestHourTonnageValue element  -
                        if (maxTonnage >= standardTonnagePerHour) {
                            $('#bestHourTonnageValue').html(maxTonnage + " Tonnes").css('color', 'green');
                        } else {
                            $('#bestHourTonnageValue').html(maxTonnage + " Tonnes").css('color', 'red');
                        }

                        /**
                         * Render Tons By Status / PR Pivot
                         * ********************************
                         */

                        let utils = $.pivotUtilities;
                        let sum = $.pivotUtilities.aggregatorTemplates.sum;
                        var numberFormat = $.pivotUtilities.numberFormat;
                        var intFormat = numberFormat({digitsAfterDecimal: 2});
                        let renderers = $.extend($.pivotUtilities.renderers,
                            $.pivotUtilities.plotly_renderers);
                        let pivotData = $.parseJSON(jsonData.tonsByStatusPRPivotData);
                        let loadedConfig = {
                            "rendererOptions": {
                                "localeStrings": {
                                    "renderError": "An error occurred rendering the PivotTable results.",
                                    "computeError": "An error occurred computing the PivotTable results.",
                                    "uiRenderError": "An error occurred rendering the PivotTable UI.",
                                    "selectAll": "Select All",
                                    "selectNone": "Select None",
                                    "tooMany": "(too many to list)",
                                    "filterResults": "Filter values",
                                    "apply": "Apply",
                                    "cancel": "Cancel",
                                    "totals": "Totals",
                                    "vs": "vs",
                                    "by": "by"
                                }, "table": {}
                            },
                            "localeStrings": {
                                "renderError": "An error occurred rendering the PivotTable results.",
                                "computeError": "An error occurred computing the PivotTable results.",
                                "uiRenderError": "An error occurred rendering the PivotTable UI.",
                                "selectAll": "Select All",
                                "selectNone": "Select None",
                                "tooMany": "(too many to list)",
                                "filterResults": "Filter values",
                                "apply": "Apply",
                                "cancel": "Cancel",
                                "totals": "Totals",
                                "vs": "vs",
                                "by": "by"
                            },
                            "derivedAttributes": {},
                            "hiddenAttributes": [],
                            "hiddenFromAggregators": [],
                            "hiddenFromDragDrop": [],
                            "menuLimit": 500,
                            "cols": ["PIPE_STATUS_CODE"],
                            "rows": ["PROCESS_ROUTE"],
                            "vals": ["T_WEIGHT"],
                            "rowOrder": "key_a_to_z",
                            "colOrder": "key_a_to_z",
                            "exclusions": {},
                            "inclusions": {},
                            "unusedAttrsVertical": 85,
                            "autoSortUnusedAttrs": false,
                            "onRefresh": null,
                            //  "showUI": true,
                            "sorters": {},
                            "rendererName": "Table",
                            "inclusionsInfo": {},
                            "aggregator": sum(intFormat)(["T_WEIGHT"])
                        };

                        $("#tonsByStatusAndPRPivot").pivot(pivotData, loadedConfig); // render pivot.

                        /**
                         * WM Stoppage Mins Stopped By Hour stacked bar chart.
                         * ********************************
                         */
                        console.log(wmStopsByHourJson);
                        if (daysBetweenDateRange > 1) {
                            d3.selectAll("#wmStopsByHourChart svg > *").remove(); // clear hourly chart

                            nv.addGraph(function () {
                                let chart = nv.models.multiBarChart()
                                    .margin({top: 30, right: 60, bottom: 50, left: 70});


                                chart.reduceXTicks(false).staggerLabels(true).stacked(true).showControls(false);

                                chart.xAxis
                                    .axisLabel((daysBetweenDateRange == 1 ? "Hour" : "Month/Day"));
                                chart.yAxis
                                    .axisLabel("Mins");

                                d3.select('#wmStopsByHourChart svg')
                                    .datum(wmStopsByHourJson)
                                    .transition().duration(500).call(chart);
                                nv.utils.windowResize(chart.update); // Intitiate listener for window resize so the chart responds and changes width.
                                return chart;
                            });
                        } else {
                            d3.selectAll("#wmStopsByHourChart svg > *").remove(); // clear hourly chart
                            ///// BREAK 9am and 3pm
                            let multiChartData = [
                                {
                                    key: 'STD',
                                    values: weldMillStoppagesHourlyLimits.values,
                                    "yAxis": 1,
                                    "type": "line"
                                },
                            ];
                            //  console.log(multiChartData);
                            for (let i = 0; i < wmStopsByHourJson.length; i++) {

                                wmStopsByHourJson[i].yAxis = 1;
                                wmStopsByHourJson[i].type = "bar";
                                wmStopsByHourJson[i].stacked = "true";
                                multiChartData.push(wmStopsByHourJson[i]);
                            }


                            nv.addGraph(function () {
                                let chart = nv.models.multiChart();
                                //   .margin({top: 30, right: 60, bottom: 50, left: 70})


                                //   chart.useInteractiveGuideline(true);
                                chart.bars1.stacked(true);
                                chart.bars2.stacked(true);

                                chart.xAxis
                                    .axisLabel((daysBetweenDateRange == 1 ? "Hour" : "Month/Day"))
                                    .staggerLabels(false);

                                chart.yAxis1
                                    .axisLabel('Mins');


                                d3.select('#wmStopsByHourChart svg')
                                    .datum(multiChartData)
                                    .transition().duration(500).call(chart);
                                //  nv.utils.windowResize(chart.update); // Intitiate listener for window resize so the chart responds and changes width.
                                return chart;
                            });

                        }

                        //loop through keys again and make final json


                        /**
                         * Configure and call the wmEngineeringStopsChart Stacked Chart
                         * ********************************
                         */
                        console.log(wmEngineeringStopsByReasonTypeJson);
                        nv.addGraph(function () {
                            let chart = nv.models.multiBarChart().staggerLabels(false).stacked(true).showControls(false).legendPosition("right");

                            d3.select('#wmEngineeringStopsChart svg')
                                .datum(wmEngineeringStopsByReasonTypeJson)
                                .transition().duration(500).call(chart);
                            nv.utils.windowResize(chart.update); // Intitiate listener for window resize so the chart responds and changes width.
                            return chart;
                        });

                        /**
                         * Render 1DCO/1CRP Pipe throughput bar charts
                         * ********************************
                         */

                        RenderStaticDiscreteBarChart(weldMill1DCOPipeThroughputJSON, "label", "value", "pipeThroughputChart1DCO", null, (daysBetweenDateRange == 1 ? "Hour" : "Month/Day"), "Pipe Count", ",0f", ",0f", [], true, false, null, null, null, null, null);
                        RenderStaticDiscreteBarChart(weldMill1CRPPipeThroughputJSON, "label", "value", "pipeThroughputChart1CRP", null, (daysBetweenDateRange == 1 ? "Hour" : "Month/Day"), "Pipe Count", ",0f", ",0f", [], true, false, null, null, null, null, null);


                        /**
                         * Configure and call the wmEngineeringStopsChart Stacked Chart
                         * ********************************
                         */

                        nv.addGraph(function () {
                            let chart = nv.models.multiBarHorizontalChart()
                                .margin({top: 0, right: 0, bottom: 25, left: 100})
                                .stacked(true).showControls(false);
                            ;
                            chart.yAxis.tickFormat(d3.format(",0f"));

                            d3.select('#weldMillWipBySizeAge svg')
                                .datum(weldMillWipByAgeSize)
                                .transition().duration(500).call(chart);

                            nv.utils.windowResize(chart.update); // Intitiate listener for window resize so the chart responds and changes width.
                            return chart;
                        });


                        $('#lastMacroImageAndInfo').html(
                            'Week: ' + jsonData.LastMacroData.WEEK_YEAR +
                            ' Coil: ' + jsonData.LastMacroData.COIL +
                            ' Pipe: ' + jsonData.LastMacroData.PIPE + '<br />' +
                            ' Recorded At: ' + jsonData.LastMacroData.CREATED_AT +
                            '<br />' +
                            '<a target="_blank" href="' + rootUrl + '/wm-macros/' + jsonData.LastMacroData.id + '"><img style="width: 100%;" src="' + rootUrl + '/public/storage/macros/' + jsonData.LastMacroData.IMAGE + '"></a>');

                        $('#lastDimensionalVerification').html(
                            ' Week: ' + jsonData.LastDimensionalVerification.WEEK +
                            ' Coil: ' + jsonData.LastDimensionalVerification.COIL + '<br />' +
                            ' Recorded At: ' + jsonData.LastDimensionalVerification.created_at +
                            ' <div style="display:flex;font-size: 13px;"><div><ul> ' +
                            ' <li>POST_FINS_B: ' + jsonData.LastDimensionalVerification.POST_FINS_B + '</l>' +
                            ' <li>POST_FINS_C: ' + jsonData.LastDimensionalVerification.POST_FINS_C + '</l>' +
                            ' <li>POST_FINS_D: ' + jsonData.LastDimensionalVerification.POST_FINS_D + '</l>' +
                            ' <li>POST_FINS_OFFSET: ' + jsonData.LastDimensionalVerification.POST_FINS_OFFSET + '</l>' +
                            '</div> <div><ul>' +
                            ' <li>POST_WELD_A: ' + jsonData.LastDimensionalVerification.POST_WELD_A + '</l>' +
                            ' <li>POST_WELD_B: ' + jsonData.LastDimensionalVerification.POST_WELD_B + '</l>' +
                            ' <li>POST_WELD_C: ' + jsonData.LastDimensionalVerification.POST_WELD_C + '</l>' +
                            ' <li>POST_WELD_OOR: ' + jsonData.LastDimensionalVerification.POST_WELD_OOR + '</l>' +
                            ' <li>POST_WELD_PEAK: ' + jsonData.LastDimensionalVerification.POST_WELD_PEAK + '</l>' +
                            '</div></div>');


                        //Configure data and call thk chart

                        var thkMeasure1 = [];
                        var thkMeasure2 = [];
                        var thkMeasure3 = [];
                        var thkMeasure4 = [];
                        var thkUpperControlLimit = [];
                        var thkLowerControlLimit = [];

                        var xAxis1Labels = {};
                        var xAxis2Labels = {};
                        for (i = 0; i < jsonData.lab1ThkData.length; i++) {
                            xAxis1Labels[i] = jsonData.lab1ThkData[i].COIL_COIL_WEEK + " " + jsonData.lab1ThkData[i].COIL_COIL_SEQ_NO + " " + jsonData.lab1ThkData[i].TRACK_CODE;
                            var dt = new Date(jsonData.lab1ThkData[i].DATETIME_TANDEM);
                            xAxis2Labels[i] = dt.getDate() + "-" + (dt.getMonth() + 1) + "-" + dt.getFullYear() + " " +
                                dt.getHours() + ":" + dt.getMinutes();

                            thkMeasure1.push({
                                x: i,
                                y: parseFloat(jsonData.lab1ThkData[i].VARIABLE_MEASUREMENT_1)
                            });
                            thkMeasure2.push({
                                x: i,
                                y: parseFloat(jsonData.lab1ThkData[i].VARIABLE_MEASUREMENT_2)
                            });

                            thkMeasure3.push({
                                x: i,
                                y: parseFloat(jsonData.lab1ThkData[i].VARIABLE_MEASUREMENT_3)
                            });

                            thkLowerControlLimit.push({
                                x: i,
                                y: parseFloat(jsonData.lab1ThkData[i].LOWER_CONTROL_LIMIT)
                            });

                            thkUpperControlLimit.push({
                                x: i,
                                y: parseFloat(jsonData.lab1ThkData[i].UPPER_CONTROL_LIMIT)
                            });
                        }


                        d3.selectAll("#thicknessLineChart svg > *").remove(); // clear hourly chart

                        if (jsonData.lab1ThkData.length > 0) {
                            var thicknessLineChart = RenderLineWithFocusChartDualAxisLabels('thicknessLineChart',
                                'lineWithFocus',
                                xAxis1Labels, xAxis2Labels, [
                                    {values: thkMeasure1, key: 'THK Meas 1'},
                                    {values: thkMeasure2, key: 'THK Meas 2'},
                                    {values: thkMeasure3, key: 'THK Meas 3'},
                                    {values: thkLowerControlLimit, key: 'LCL', color: '#FF6384'},
                                    {values: thkUpperControlLimit, key: 'UCL', color: '#FF6384'},
                                ],
                                'Date/Coil',
                                true,
                                'MM',
                                true,
                                true,
                                []);
                        }

                        if (flatteningTestFailureCount > 0) {
                            // Update Flattener Count
                            $('#flatteningFailuresCount').html("Flattener Failures: <a href='#' id='flatteningFailuresExportLink'>" + flatteningTestFailureCount + "</a>");

                            let html = "";
                            for (let i = 0; i < flatteningTestFailureCount; i++) {
                                html += "<div>Pipe: " + flatteningTestFailures[i].TRACK_CODE + "("+ flatteningTestFailures[i].PIPE_SIZE1 +") <br /> Time: " + flatteningTestFailures[i].RES_RECVD_DATETIME + "</div>";
                            }

                            $('#flatteningFailureData').html(html);

                        }


                    } // end function

                    $(document).ready(function () {

                        $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                        $.ajax({
                            type: 'POST',
                            url: rootUrl + '/api/GetWeldMillMainDashboardData',
                            success: function (data) {
                                console.log(data);
                                BuildDashboard(data);
                            },
                            complete: function () {
                                $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                            }
                        });
                    });

                    // $('.dateTimeControlButton').on('click', function () {
                    //
                    //     $('.dateTimeControlButton').removeClass('btn-active');
                    //     $(this).addClass('btn-active');
                    //
                    //     let dateCommand = $(this).data('filtercommand');
                    //     $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                    //     $.ajax({
                    //         type: 'POST',
                    //         url: rootUrl + '/api/GetWeldMillMainDashboardData',
                    //         data: {'dateRangeCommand': dateCommand},
                    //         success: function (data) {
                    //             console.log(data);
                    //             BuildDashboard(data);
                    //         },
                    //         complete: function () {
                    //             $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                    //         }
                    //     });
                    //
                    // });

                    function RefreshTodaysData() {
                        var todaysDate = moment();

                        var todaysDateDayNo = todaysDate.format('DD');
                        var currentDateRangeSetDtFromDayNo = window.dtFrom.substr(8, 2);
                        var currentDateRangeSetDtToDayNo = window.dtFrom.substr(8, 2);

                        if (todaysDateDayNo == currentDateRangeSetDtFromDayNo && todaysDateDayNo == currentDateRangeSetDtToDayNo) {
                            console.log("Update On");
                            $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                            $.ajax({
                                type: 'POST',
                                url: rootUrl + '/api/GetWeldMillMainDashboardData',
                                success: function (data) {
                                    console.log(data);
                                    BuildDashboard(data);
                                },
                                complete: function () {
                                    $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                                }
                            });
                        } else {
                            console.log("Update Off");
                        }

                    }

                    setTimeout(function () {
                        console.log("timeout fired");
                        setInterval(RefreshTodaysData, 180000);
                        RefreshTodaysData();
                    }, 180000);

                    function BuildWMStatsTBody(obj) {

                        let html = ' <tr>\n' +
                            '                        <td>Input Coil</td>\n' +
                            '                        <td>' + obj.INPUT_COIL.TONNES + '</td>\n' +
                            '                        <td></td>\n' +
                            '                        <td></td>\n' +
                            '                        <td rowspan="1"><button class="coilStockPivotReportLoaderButton btn btn-primary" style="display: block; margin: 5% auto;" data-reportid="225">Report</button></td>\n' +
                            '                    </tr>';


                        html += '<tr>\n' +
                            '                        <td>Pipe Output</td>\n' +
                            '                        <td>' + parseFloat(obj["1DCO_STATS"].OUTPUT.TONNES).toFixed(2) + '</td>\n' +
                            '                        <td>' + parseFloat(obj["1DCO_STATS"].OUTPUT.METRES).toFixed(2) + '</td>\n' +
                            '                        <td>' + parseFloat((obj["1DCO_STATS"].OUTPUT.TONNES / obj.INPUT_COIL.TONNES) * 100).toFixed(2) + '%' + '</td>' +
                            '                        <td rowspan="5"><button class="coilPipePivotReportLoaderButton btn btn-primary mb-4 mt-5" data-reportid="232">Report (T)</button> <button class="coilPipePivotReportLoaderButton btn btn-primary" data-reportid="233">Report (M)</button></td>\n' +
                            '                    </tr>\n' +
                            '                    <tr>\n' +
                            '                        <td>Pipe DG</td>\n' +
                            '                        <td>' + parseFloat(obj["1DCO_STATS"].DOWNGRADE.TONNES).toFixed(2) + '</td>\n' +
                            '                        <td>' + parseFloat(obj["1DCO_STATS"].DOWNGRADE.METRES).toFixed(2) + '</td>\n' +
                            '                        <td>' + parseFloat((obj["1DCO_STATS"].DOWNGRADE.TONNES / obj.INPUT_COIL.TONNES) * 100).toFixed(2) + '%' + '</td>' +
                            '                    </tr>\n' +
                            '                    <tr>\n' +
                            '                        <td>Scrap</td>\n' +
                            '                        <td>' + parseFloat(obj["1DCO_STATS"].SCRAP.TONNES).toFixed(2) + '</td>\n' +
                            '                        <td>' + parseFloat(obj["1DCO_STATS"].SCRAP.METRES).toFixed(2) + '</td>\n' +
                            '                        <td>' + parseFloat((obj["1DCO_STATS"].SCRAP.TONNES / obj.INPUT_COIL.TONNES) * 100).toFixed(2) + '%' + '</td>' +

                            '                    </tr>\n' +
                            '                    <tr>\n' +
                            '                        <td>Good Pipe</td>\n' +
                            '                        <td>' + parseFloat(obj["1DCO_STATS"].GOOD_PIPE.TONNES).toFixed(2) + '</td>\n' +
                            '                        <td>' + parseFloat(obj["1DCO_STATS"].GOOD_PIPE.METRES).toFixed(2) + '</td>\n' +
                            '                        <td>' + parseFloat((obj["1DCO_STATS"].GOOD_PIPE.TONNES / obj.INPUT_COIL.TONNES) * 100).toFixed(2) + '%' + '</td>' + '                        <td></td>\n' +
                            '                    <tr>\n' +
                            '                        <td>UT</td>\n' +
                            '                        <td>' + parseFloat(obj["1DCO_STATS"].UT.TONNES).toFixed(2) + '</td>\n' +
                            '                        <td>' + parseFloat(obj["1DCO_STATS"].UT.METRES).toFixed(2) + '</td>\n' +
                            '                        <td>' + parseFloat((obj["1DCO_STATS"].UT.TONNES / obj.INPUT_COIL.TONNES) * 100).toFixed(2) + '%' + '</td>' +
                            '                    </tr>\n' +
                            '                    <tr>\n' +
                            '                        <td>NA</td>\n' +
                            '                        <td>' + parseFloat(obj["1DCO_STATS"].NA.TONNES).toFixed(2) + '</td>\n' +
                            '                        <td>' + parseFloat(obj["1DCO_STATS"].NA.METRES).toFixed(2) + '</td>\n' +
                            '                        <td>' + parseFloat((obj["1DCO_STATS"].NA.TONNES / obj.INPUT_COIL.TONNES) * 100).toFixed(2) + '%' + '</td>' +
                            '                        <td rowspan="1"></td>\n' +
                            '                    </tr>';

                        $('#wmStatsTable tbody').html(html);
                    }

                    function BuildWMStoppagePerformanceTBody(obj) {
                        let html = "";
                        let i = 0;
                        let keys = Object.keys(obj)
                        for (let key of keys) {
                            html += '<tr>\n' +
                                '         <td>' + key + '</td>\n' +
                                '         <td>' + obj[key] + '%</td>\n' +
                                (i == 0 ? '<td rowspan="7"><button class="weldMillStopsPivotReportLoaderButton btn btn-primary mt-5" data-reportid="235">Report</button> </td>' : '') +
                                '</tr>';
                            i++;
                        }
                        $('#wmStoppagePerformanceTable tbody').html(html);

                    }

                    function GetWeldMillActiveStatus() {
                        $.ajax({
                            type: 'POST',
                            url: rootUrl + '/api/GetWeldMillIsStoppedData',
                            success: function (response) {
                                var parsedResponse = $.parseJSON(response);
                                if (parsedResponse.weldMillStopped) {

                                    $('#weldMillStatus').css('display', 'block');
                                    $('#minsStopped').html("(" + parsedResponse.stoppedMins + " Mins)")
                                } else {
                                    $('#weldMillStatus').css('display', 'none');
                                }

                            }
                        });
                    }

                    setInterval(GetWeldMillActiveStatus, 180000);
                    GetWeldMillActiveStatus();


                        function GetWMSizingSpeed() {
                            $.ajax({
                                type: 'POST',
                                url: rootUrl + '/api/GetSizingMillSpeed',
                                success: function (response) {
                                        var sizingSpeed = $.parseJSON(response)[0].value;

                                        $('#millSpeed').html(" Weld Mill Speed " + sizingSpeed.toFixed(2) + " Ft/m ")

                                }
                            });
                        }

                        setInterval(GetWMSizingSpeed, 4000);
                        GetWMSizingSpeed();

                    /**
                     * Report button listeners to go to pivot reports.
                     */

                    $("body").delegate(".coilStockPivotReportLoaderButton", "click", function () {
                        let reportId = $(this).data('reportid');
                        console.log(reportId);
                        let url = rootUrl + "/pivots/coil-tracking-pivot?reportId=" + reportId;
                        window.location.href = url;

                    });

                    $("body").delegate(".coilPipePivotReportLoaderButton", "click", function () {
                        let reportId = $(this).data('reportid');
                        console.log(reportId);
                        let url = rootUrl + "/pivots/coil-pipe-pivot?reportId=" + reportId;
                        window.location.href = url;

                    });

                    $("body").delegate(".weldMillStopsPivotReportLoaderButton", "click", function () {
                        let reportId = $(this).data('reportid');
                        console.log(reportId);
                        let url = rootUrl + "/pivots/weld-mill-stoppages-pivot?reportId=" + reportId;
                        window.location.href = url;

                    });


                    $("body").on("click", "a#flatteningFailuresExportLink", function (e) {
                        e.preventDefault();
                        //exporting to csv ref: https://stackoverflow.com/questions/14964035/how-to-export-javascript-array-info-to-csv-on-client-side
                        let csvContent = "data:text/csv;charset=utf-8,";

                        csvContent += "Pipe,DateTime,S1,S2,THICK,PR,RPOS,PREV_RPOS" + "\r\n";

                        for (const [key, value] of Object.entries(flatteningTestFailures)) {

                            let row = value["TRACK_CODE"] + "," + value["RES_RECVD_DATETIME"] + "," + value["PIPE_SIZE1"] + "," + value["PIPE_SIZE2"]
                                + "," + value["PIPE_THICK"] + "," + value["PROCESS_ROUTE"] + "," + value["ROUTING_POS"] + "," + value["FROM_ROUTING_POS"];
                            csvContent += row + "\r\n";
                        }

                        console.log(csvContent);
                        var encodedUri = encodeURI(csvContent);
                        var link = document.createElement("a");
                        link.setAttribute("href", encodedUri);
                        link.setAttribute("download", "flattening-failures.csv");
                        document.body.appendChild(link); // Required for FF

                        link.click(); // This will download the data file named "deallocated-sections.csv".
                    });


                </script>
@endsection
