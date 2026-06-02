@extends('layouts.app')

@section('pageTitle', 'Furnace Dashboard')
@section('pageName', 'Furnace Dashboard')
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
    <div class="simpleflex">
        <div class="fl4">

            <!-- Furnace Output Chart -->
            <div class="card shadow pb-2">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Furnace Output (24HR)</h6>
                    <span class="live-status pull-right">Updating Status: <i class="fa fa-check-circle updating"
                                                                             aria-hidden="true"></i></span>

                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="furnaceThroughputBarChart">
                        <svg></svg>
                    </div>
                    <hr/>
                    <h5>Failures</h5>
                    <div id="furnaceFailuresBarChart">
                        <svg></svg>
                    </div>
                </div>
            </div>
            <!-- END Furnace Output Chart -->

            <div class="mb-3"></div> <!-- add space -->

            <!-- Furnace Temp Chart -->
            <div class="card shadow pb-2">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Furnace Temperature (Last 2HR)</h6>
                    <span class="live-status pull-right">Updating Status: <i class="fa fa-check-circle updating"
                                                                             aria-hidden="true"></i></span>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="furnaceTemperatureLineChart">
                        <svg></svg>
                    </div>
                </div>
            </div>
            <!-- END Furnace Temp Chart -->

            <div class="mb-3"></div> <!-- add space -->

            <!-- Furnace Temp Performance Chart -->
            <div class="card shadow pb-2 mb-3">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Furnace Temp Performance (<span
                            id="furnaceTempPerformanceDateRangeIndicator">Today</span>)</h6>
                    <span class="live-status pull-right" id="furnaceTempPerformanceStatus">Updating Status: <i
                            class="fa fa-check-circle updating"
                            aria-hidden="true"></i></span>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <!-- Update buttons -->
                <div class="btn-flex mt-2 text-center">
                    @include('layouts.partial.update-date-buttons')
                </div>
                <div class="row">

                    <div class="card-body">
                        <h4>Shift 6x2</h4>
                        <hr/>
                        <div id="sixTillTwoFurnacePerformancePieChart">
                            <svg></svg>
                        </div>
                    </div>

                    <div class="card-body">
                        <h4>Shift 2x10</h4>
                        <hr/>
                        <div id="twoTillTenFurnacePerformancePieChart">
                            <svg></svg>
                        </div>
                    </div>

                    <div class="card-body">
                        <h4>Shift 10x6</h4>
                        <hr/>
                        <div id="tenTillSixFurnacePerformancePieChart">
                            <svg></svg>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="furnace-performance-totals-stats" id="furnace-performance-totals-stats">
                    </div>
                </div>
            </div>
        </div>


        <div class="fl2">
            <div class="card shadow pb-2">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Furnace Production Stats</h6>
                    <span class="live-status pull-right">Updating Status: <i class="fa fa-check-circle updating"
                                                                             aria-hidden="true"></i></span>
                </div>

                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div class="furnace-table-center" id="furnace-table-container">

                        <table class="custom-furnace-stats-table">
                            Loading.........
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!-- end row -->
    </div>


    <!-- END Furnace Temp Performance Chart -->

@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>
    <script
        src="{{ asset('public/js/rhs-furnace-dashboard/production-statistics-table-refresher-3shift.js')}}"></script>
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {

            /*******************************************************************************************
             * Funace throughput bar charts  - - -
             */

            var firstCall = true;

            RenderLiveDiscreteBarChart(rootUrl + '/api/GetLatestRHSFurnaceThroughput', 'G', [], true, true, [], '.0f', 'Pipe Count', '.0f', 'Hour', 'furnaceThroughputBarChart');

            // Completely custom chart setup due to the tooltip content
            function GetFurnaceFailuresAndBuildBarCharts() {

                $.ajax({
                    type: "POST",
                    url: rootUrl + "/api/GetLatestRHSFurnaceFailures",
                    dataType: "json",
                    async: false,
                    success: function (json) {
                        console.log(json);

                        if (json.values.length > 0) {
                            firstCall = false;

                            console.log(json);

                            if (json.values.length == 0) {
                                console.log("nothing there!"); // don't update anything...
                            } else {

                                nv.addGraph(function () {
                                    var chart = nv.models.discreteBarChart()
                                        .x(function (d) {
                                            return d.label
                                        })
                                        .y(function (d) {
                                            return d.value
                                        })
                                        .showValues(true);


                                    chart.tooltip.contentGenerator(function (obj) {
                                        var html = "<div style='padding: 5px 5px 5px 5px;'>";

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
                                        .axisLabel('Hour')

                                    d3.select('#furnaceFailuresBarChart svg')
                                        .datum([json])
                                        .call(chart);

                                    nv.utils.windowResize(chart.update);
                                    return chart;
                                });
                            }
                        }
                    }
                });
            }


            ///////////////////////////////////////////////
            //SET TIMER(MS) + INITIATE YIELD FIGS FUNCTION
            ///////////////////////////////////////////////
            setInterval(GetFurnaceFailuresAndBuildBarCharts, 90000);
            GetFurnaceFailuresAndBuildBarCharts();


            /*******************************************************************************************
             * Funace temerature line chart - - -
             */
            var furnaceTempFeedJSON = <?php echo $furnaceTempData; ?>;

            function FormatDataAndBuildLineChart(json) {
                console.time('timer1');

                var filterValueArray = [];
                var labelObject = {};
                var filterUpperLimitArray = [];
                var filterLowerLimitArray = [];

                for (var i = 0; i < json.length; i++) {
                    filterValueArray.push({x: i, y: json[i].FILTER});
                    labelObject[i] = json[i].TIME_STAMP;
                    filterUpperLimitArray.push({x: i, y: 1020});
                    filterLowerLimitArray.push({x: i, y: 800});
                }
                // CODE
                console.timeEnd('timer1'); // this prints times on the console
                var filterLineChart = RenderLineWithFocusChart('furnaceTemperatureLineChart',
                    'lineWithFocus',
                    labelObject, [
                        {values: filterValueArray, key: 'FILTER', color: '#f67019'},
                        {values: filterUpperLimitArray, key: 'UPPER_LIMIT', color: '#FF6384'},
                        {values: filterLowerLimitArray, key: 'LOWER_LIMIT', color: '#FF6384'}
                    ],
                    'Degrees',
                    true,
                    'Date',
                    true,
                    true);


            }

            FormatDataAndBuildLineChart(furnaceTempFeedJSON);


            // Set interval to update charts with new data.
            setInterval(function () {
                $.ajax({
                    type: "POST",
                    url: rootUrl + "/api/GetRHSFurnaceFilterDataLastXHours",
                    data: {"hours": 2},
                    dataType: "json",
                    async: false,
                    success: function (data) {
                        data = $.parseJSON(data);

                        if (data.length > 0) {
                            FormatDataAndBuildLineChart(data);
                        }
                    }
                });
            }, 90000);


            /**********************************************************************************************
             Furnace Temp performance PIE charts
             */
            var boolFurnaceTempPerformanceRealTimeUpdateOn = true;

            var todaysDate = new Date(); // To access values with Date key..
            var dd = String(todaysDate.getDate()).padStart(2, '0');
            var mm = String(todaysDate.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = todaysDate.getFullYear();
            var todaysDateKey = yyyy + '-' + mm + '-' + dd;

            //  console.log(todaysDateKey);


            /**
             * Aggregate all values from the tempPerformance objects... Pipe passes, under temp, over temp, both.
             * After calculation, build formatted HTML and append widget underneath the PIE Charts.
             *
             * @param sixTillTwoData []
             * @param twoTillTenData []
             * @param tenTillSixData []
             * @return Void
             */
            function AggregateFurnacePerformanceAndAppendHTMLWidget(sixTillTwoData, twoTillTenData, tenTillSixData) {
                console.log("aggregating Data...");
                console.log(twoTillTenData);
                var passedTotal = 0;
                var underTotal = 0;
                var overTotal = 0;
                var bothTotal = 0;
                var passFailurePercentage = 0;

                // calculate totals... revert count to zero if null..
                passedTotal = ((sixTillTwoData.GOOD_PIPE_TEMP == null ? 0 : sixTillTwoData.GOOD_PIPE_TEMP) + (twoTillTenData.GOOD_PIPE_TEMP == null ? 0 : twoTillTenData.GOOD_PIPE_TEMP) + (tenTillSixData.GOOD_PIPE_TEMP == null ? 0 : tenTillSixData.GOOD_PIPE_TEMP));
                underTotal = ((sixTillTwoData.UNDER_TEMP_PIPES == null ? 0 : sixTillTwoData.UNDER_TEMP_PIPES) + (twoTillTenData.UNDER_TEMP_PIPES == null ? 0 : twoTillTenData.UNDER_TEMP_PIPES) + (tenTillSixData.UNDER_TEMP_PIPES == null ? 0 : tenTillSixData.UNDER_TEMP_PIPES));
                overTotal = ((sixTillTwoData.OVER_TEMP_PIPES == null ? 0 : sixTillTwoData.OVER_TEMP_PIPES) + (twoTillTenData.OVER_TEMP_PIPES == null ? 0 : twoTillTenData.OVER_TEMP_PIPES) + (tenTillSixData.OVER_TEMP_PIPES == null ? 0 : tenTillSixData.OVER_TEMP_PIPES));
                bothTotal = ((sixTillTwoData.UNDER_AND_OVER_TEMP_PIPES == null ? 0 : sixTillTwoData.UNDER_AND_OVER_TEMP_PIPES) + (twoTillTenData.UNDER_AND_OVER_TEMP_PIPES == null ? 0 : twoTillTenData.UNDER_AND_OVER_TEMP_PIPES) + (tenTillSixData.UNDER_AND_OVER_TEMP_PIPES == null ? 0 : tenTillSixData.UNDER_AND_OVER_TEMP_PIPES));
                // if passed number is more than one, then do the division, else leave at 0%
                if (passedTotal > 0) {
                    passFailurePercentage = parseFloat(((passedTotal - (underTotal + overTotal + bothTotal)) / passedTotal) * 100).toFixed(2);
                }

                // Build up HTML statistics view...
                var html = "<hr> <h4 class='text-center'> Totals </h4>"
                html += "<div class='simpleflex justify-content-center' style=''>";
                html += "<div style='display: flex';><span style='display: block; width: 10px; height: 10px; background: #87ff60;border-radius: 50px; margin: 10px 5px 0px 5px;'></span>Pass:  <b> " + passedTotal + "</b> </div>";
                html += "<div style='display: flex';><span style='display: block; width: 10px; height: 10px; background: #60aeff;border-radius: 50px; margin: 10px 5px 0px 5px;'></span>Under:  <b> " + underTotal + "</b> </div>";
                html += "<div style='display: flex';><span style='display: block; width: 10px; height: 10px; background: #ff8481;border-radius: 50px; margin: 10px 5px 0px 5px;'></span>Over:  <b> " + overTotal + "</b> </div> ";
                html += "<div style='display: flex';><span style='display: block; width: 10px; height: 10px; background: #ff9133;border-radius: 50px; margin: 10px 5px 0px 5px;'></span>Both:  <b> " + bothTotal + " </b> </div> ";
                html += "</div>";
                html += "<div class='text-center mt-2'>Good Pipe Yield: " + passFailurePercentage + "%</div>";
                $('#furnace-performance-totals-stats').html(html); // append html to container. (Below pie charts)
            }

            function BuildFurnaceTempPerformancePieCharts(data, id) {
                console.info("pieRenderData");
                console.log(data);

                if (data == undefined) { // Possibly later shifts dont exist yet..
                    var formattedData = []; // Pass [] into chart if not data, and not date available message will be displayed on chart.

                } else {
                    var formattedData = FurnaceTempPerformanceDataSorter(data)
                }

                //Regular pie chart example
                nv.addGraph(function () {
                    var chart = nv.models.pieChart()
                        .x(function (d) {
                            return d.label
                        })
                        .y(function (d) {
                            return d.value
                        })
                        .labelType(function (d, i) {
                            return d.data.label + ' (' + d.data.value + ')';
                        })
                        .showLabels(true)
                        .showTooltipPercent(true);

                    d3.select("#" + id + " svg")
                        .datum(formattedData)
                        .transition().duration(350)
                        .call(chart);

                    return chart;
                });

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

            function GetTodaysPieChartDataAndBuildCharts() {
                if (boolFurnaceTempPerformanceRealTimeUpdateOn) {
                    $.ajax({
                        type: "GET",
                        url: rootUrl + "/api/GetLatestRHSFurnaceTempPerformance", // API
                        dataType: "json",
                        async: false,
                        success: function (data) {
                            console.log(data);
                            // Update all pie charts
                            BuildFurnaceTempPerformancePieCharts(data.sixTillTwoFurnaceTempPerformanceKeyValue, "sixTillTwoFurnacePerformancePieChart");
                            BuildFurnaceTempPerformancePieCharts(data.twoTillTenFurnaceTempPerformanceKeyValue, "twoTillTenFurnacePerformancePieChart");
                            BuildFurnaceTempPerformancePieCharts(data.tenTillSixFurnaceTempPerformanceKeyValue, "tenTillSixFurnacePerformancePieChart");
                            // Update aggregation statistics box -
                            AggregateFurnacePerformanceAndAppendHTMLWidget(data.sixTillTwoFurnaceTempPerformanceKeyValue, data.twoTillTenFurnaceTempPerformanceKeyValue, data.tenTillSixFurnaceTempPerformanceKeyValue);
                        }
                    });
                }
            }

            // Set interval of 30 seconds to update furnace temp performance pie charts with new data.
            setInterval(function () {
                GetTodaysPieChartDataAndBuildCharts();
            }, 90000);
            // GetTodaysPieChartDataAndBuildCharts();

            setTimeout(GetTodaysPieChartDataAndBuildCharts, 4000)

            // Turn the updating status tick to a cross once one of the buttons has been pressed to show the data isn't being updated anymore.
            $('.dateTimeControlButton').on('click', function () {
                boolFurnaceTempPerformanceRealTimeUpdateOn = false;

                if (!boolFurnaceTempPerformanceRealTimeUpdateOn) {
                    $('#furnaceTempPerformanceStatus').html('Updating Status: <i class="fa fa-times-circle stopped" aria-hidden="true"></i>')
                }
                var filterCommand = $(this).data('filtercommand'); // Filtercommand from btn... eg PREV24, TODAY, THISWEEK
                $('#furnaceTempPerformanceDateRangeIndicator').html(filterCommand);
                //   console.log(filterCommand);
                boolRealTimeUpdateOn = false;
                $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                $.ajax({
                    type: "POST",
                    data: {"dateRangeCommand": filterCommand},
                    url: rootUrl + "/api/GetLatestRHSFurnaceTempPerformanceInRange", // Pass in command to api and request new data.
                    dataType: "json",
                    async: false,
                    success: function (data) {
                        console.log("button used");
                        console.log(data);
                        // update charts.
                        BuildFurnaceTempPerformancePieCharts(data.sixTillTwoFurnaceTempPerformanceKeyValue, "sixTillTwoFurnacePerformancePieChart");
                        BuildFurnaceTempPerformancePieCharts(data.twoTillTenFurnaceTempPerformanceKeyValue, "twoTillTenFurnacePerformancePieChart");
                        BuildFurnaceTempPerformancePieCharts(data.tenTillSixFurnaceTempPerformanceKeyValue, "tenTillSixFurnacePerformancePieChart");

                        // Update aggregation statistics box -
                        AggregateFurnacePerformanceAndAppendHTMLWidget(data.sixTillTwoFurnaceTempPerformanceKeyValue, data.twoTillTenFurnaceTempPerformanceKeyValue, data.tenTillSixFurnaceTempPerformanceKeyValue);

                    },
                    complete: function () {
                        $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                    }
                });
            });
        });


        // Set the chain of events every 30 seconds. - Function inside production-statistics-table-refresher.js
        setInterval(GetFurnaceStatisticsAndRefreshTable, 90000);
        GetFurnaceStatisticsAndRefreshTable();

        //    setTimeout(GetFurnaceStatisticsAndRefreshTable, 5000)    // Fire on page load, and await timer of 30 seconds.

    </script>




@endsection
