@extends('layouts.app')

@section('pageTitle', 'RF Dashboard')
@section('pageName', 'RF Dashboard')
@section('roundsFinishingActiveLink', 'active activeUnderline')
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
    <!-- Content Row -->
    <div class="simpleflex justify-content-center" style="margin-top: -70px">
        <div class="btn-flex mt-2 mb-3 text-center">
            <!-- Update buttons -->
            <button data-filtercommand="today" class="btn btn-primary dateTimeControlButton btn-active">Today
            </button>
            <button data-filtercommand="prev24" class="btn btn-primary dateTimeControlButton">Prev
                24
            </button>
            <button data-filtercommand="prevWeek" class="btn btn-primary dateTimeControlButton">Prev
                Week
            </button>
            <button data-filtercommand="thisWeek" class="btn btn-primary dateTimeControlButton">This
                Week
            </button>
            <button data-filtercommand="prevMonth" class="btn btn-primary dateTimeControlButton">Prev
                Month
            </button>
            <button data-filtercommand="thisMonth" class="btn btn-primary dateTimeControlButton">This
                Month
            </button>
            <button data-filtercommand="prevThreeMonths" class="btn btn-primary dateTimeControlButton">Prev 3
                Months
            </button>
        </div>
    </div>
    <div class="simpleflex">
        <div class="dashboard-flex-card m-1" style="flex:2">
            <div>
                <div class="card-body">
                    <h5>Finishing Stats</h5>
                    <div id="finishingStats">
                        <table class="table table-bordered table-reduced-padding" id="finishingStatsTable">
                            <thead class="thead-light">
                            <th>Finishing</th>
                            <th>Tons</th>
                            <th>Metres</th>
                            <th>Pipes</th>
                            <th>%</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <h5>1BEV Throughput</h5>
                    <div id="bevThroughputChart" style="height: 100px; margin-bottom: -10px;">
                        <svg></svg>
                    </div>
                    <h5>1HYD Throughput</h5>
                    <div id="hydaThroughputChart" style="height: 100px; margin-bottom: -10px;">
                        <svg></svg>
                    </div>
                    <h5>2NDT Throughput</h5>
                    <div id="ndtThroughputChart" style="height: 100px; margin-bottom: -10px;">
                        <svg></svg>
                    </div>
                    <h5>RP20 Throughput</h5>
                    <div id="rp20ThroughputChart" style="height: 100px; margin-bottom: -10px;">
                        <svg></svg>
                    </div>
                    <h5>1ISP Throughput</h5>
                    <div id="isp1ThroughputChart" style="height: 100px; margin-bottom: -10px;">
                        <svg></svg>
                    </div>
                    <h5>2MAR Throughput</h5>
                    <div id="mar2ThroughputChart" style="height: 100px; margin-bottom: -10px;">
                        <svg></svg>
                    </div>

                </div>
            </div>
        </div>

        <div class="dashboard-flex-card  m-1" style="flex:3">
            <!-- Visual Content -->
            <!-- Card Body -->
            <div class="card-body">
                <h5>Stops</h5>
                <div id="stoppagesByMachineAndType" style="height: 450px;">
                    <svg></svg>
                </div>

                <h5>Rejections</h5>
                <div id="finishingRejections" style="height: 200px;">
                    <svg></svg>
                </div>

            </div>
        </div>

        <div class="dashboard-flex-card m-1" style="flex:2">
            <!-- Visual Content -->
            <!-- Card Body -->
            <div class="card-body">
                <h5>WIP at CSAW & 3SAW </h5>
                <div id="WipBySizeAge" style="height: 450px;    margin-top: 2em;">
                    <svg></svg>
                </div>

                <h5>Downgrades/Scraps </h5>
                <div id="downgrades" style="height: 250px;   margin-top: 2em;">
                    <svg></svg>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-content">

                </div>
            </div>
        </div>
    </div>

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
        let dateCommand = "today";
        let boolRealTimeUpdateOn = true;
        let firstCall = true;
        $(document).ready(function () {
            //Initialize Real Time Charts
            // Completely custom chart setup due to the tooltip content
            function GetDataAndBuildCharts() {
                if (boolRealTimeUpdateOn) {
                    console.log(boolRealTimeUpdateOn);

                    $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                    $.ajax({
                        type: "POST",
                        data: {"dateRangeCommand": dateCommand},
                        url: rootUrl + "/api/GetRFDashboardData", // Pass in command to api and request new data.
                        dataType: "json",
                        async: true,
                        success: function (data) {
                            firstCall = false;
                            console.log(data);
                            let xAxisLabel = "Hour";
                            if (data.isMoreThanOneDay) {
                                xAxisLabel = "Day No."
                            }
                            if (data.isMoreThanMonth) {
                                xAxisLabel = "Month No."
                            }

                            RenderStaticDiscreteBarChart([data.bevThroughput], 'label', 'value', 'bevThroughputChart', null, xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                            RenderStaticDiscreteBarChart([data.hydaThroughput], 'label', 'value', 'hydaThroughputChart', null, xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                            RenderStaticDiscreteBarChart([data.ndtThroughput], 'label', 'value', 'ndtThroughputChart', null, xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                            RenderStaticDiscreteBarChart([data.rp20Throughput], 'label', 'value', 'rp20ThroughputChart', null, xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                            RenderStaticDiscreteBarChart([data.isp1Throughput], 'label', 'value', 'isp1ThroughputChart', null, xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                            RenderStaticDiscreteBarChart([data.mar2throughput], 'label', 'value', 'mar2ThroughputChart', null, xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
                            //RenderStaticDiscreteBarChart($.parseJSON(data.finishingRejections), 'label', 'value', 'finishingRejections', null, "RPos", 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);

                            nv.addGraph(function () {
                                var chart = nv.models.discreteBarChart()
                                    .x(function (d) {
                                        return d.label
                                    })
                                    .y(function (d) {
                                        return d.value
                                    })
                                    .showValues(true);

                                chart.yAxis.axisLabel("Count");
                                chart.xAxis.axisLabel("RPos");

                                chart.yAxis.tickFormat(d3.format('.0f'));
                                chart.valueFormat(d3.format('.0f'));

                                d3.select('#finishingRejections svg')
                                    .datum($.parseJSON(data.finishingRejections))
                                    .transition().duration(500)
                                    .call(chart)
                                ;

                                // Listen for bar click and get data label and redirect to callback url with param of label.
                                chart.discretebar.dispatch.on('elementClick', function (e) {
                                    console.log(e.data.label);
                                    // Redirect to url with label as param.
                                    $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                                    $.ajax({
                                        type: "POST",
                                        data: {"dateRangeCommand": dateCommand, "rPos" : e.data.label},
                                        url: rootUrl + "/api/GetPipeDetailToPositionByDate", // Pass in command to api and request new data.
                                        dataType: "json",
                                        async: true,
                                        success: function (data) {
                                            $('#modal-body-content').html("");
                                            var table = "<table class='table'><thead>";
                                            table += "<th>Pipe</th>";
                                            table += "<th>FromPos</th>";
                                            table += "<th>ToPos</th>";
                                            table += "</thead>";
                                            table += "<tbody>";
                                            for (var i = 0; i < data.length; i++) {
                                                table+= "<tr>";
                                                table+= "<td>";
                                                table+= data[i].TRACK_CODE;
                                                table+= "</td>";
                                                table+= "<td>";
                                                table+= data[i].FROM_ROUTING_POS;
                                                table+= "</td>";
                                                table+= "<td>";
                                                table+= data[i].TO_ROUTING_POS;
                                                table+= "</td>";
                                                table+= "</tr>";
                                            }
                                            table+= "</tbody></table>";
                                            $('#modal-body-content').html(table);
                                            $('#modal').modal('toggle');
                                        },
                                        complete: function () {
                                            $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                                        }
                                    });
                                });
                                nv.utils.windowResize(chart.update);
                                return chart;
                            });


                            RenderStaticDiscreteBarChart($.parseJSON(data.finishingDgsScraps), 'label', 'value', 'downgrades', null, "Code", 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);

                            nv.addGraph(function () {
                                let chart = nv.models.multiBarChart().staggerLabels(false).stacked(false).showControls(false).legendPosition("right");
                                chart.yAxis.axisLabel("Mins");
                                chart.xAxis.axisLabel("RoutingPos");
                                d3.select('#stoppagesByMachineAndType svg')
                                    .datum($.parseJSON(data.hydaStoppages))
                                    .transition().duration(500).call(chart);
                                nv.utils.windowResize(chart.update); // Intitiate listener for window resize so the chart responds and changes width.
                                return chart;
                            });

                            nv.addGraph(function () {
                                let chart = nv.models.multiBarHorizontalChart()
                                    .margin({top: 0, right: 0, bottom: 25, left: 100})
                                    .stacked(true).showControls(false);
                                ;
                                chart.yAxis.tickFormat(d3.format(",0f"));

                                d3.select('#WipBySizeAge svg')
                                    .datum($.parseJSON(data.wip))
                                    .transition().duration(500).call(chart);

                                nv.utils.windowResize(chart.update); // Intitiate listener for window resize so the chart responds and changes width.
                                return chart;
                            });

                            UpdateStatsTable(data.finishingStats);
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
            setInterval(GetDataAndBuildCharts, 240000);
            GetDataAndBuildCharts();
        });


        $(document).ready(function () {
            $('.dateTimeControlButton').on('click', function () {
                $('.dateTimeControlButton').removeClass('btn-active');
                $(this).addClass('btn-active');

                $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                let filterCommand = $(this).data('filtercommand'); // Filtercommand from btn... eg PREV24, TODAY, THISWEEK
                dateCommand = filterCommand;
                if (filterCommand == "today") {
                    boolRealTimeUpdateOn = true;
                } else {
                    boolRealTimeUpdateOn = false;
                }

                $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                $.ajax({
                    type: "POST",
                    data: {"dateRangeCommand": filterCommand},
                    url: rootUrl + "/api/GetRFDashboardData", // Pass in command to api and request new data.
                    dataType: "json",
                    async: true,
                    success: function (data) {
                        console.log("button used");
                        console.log(data);
                        UpdateCharts(data);
                        UpdateStatsTable(data.finishingStats);
                    },
                    complete: function () {
                        $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                    }
                });
            });

        });

        function UpdateCharts(data) {

            let xAxisLabel = "Hour";
            if (data.isMoreThanOneDay) {
                xAxisLabel = "Day No."
            }
            if (data.isMoreThanMonth) {
                xAxisLabel = "Month No."
            }

            RenderStaticDiscreteBarChart([data.bevThroughput], 'label', 'value', 'bevThroughputChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
            RenderStaticDiscreteBarChart([data.hydaThroughput], 'label', 'value', 'hydaThroughputChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
            RenderStaticDiscreteBarChart([data.ndtThroughput], 'label', 'value', 'ndtThroughputChart', '', xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
            RenderStaticDiscreteBarChart([data.rp20Throughput], 'label', 'value', 'rp20ThroughputChart', null, xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
            RenderStaticDiscreteBarChart([data.isp1Throughput], 'label', 'value', 'isp1ThroughputChart', null, xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
            RenderStaticDiscreteBarChart([data.mar2throughput], 'label', 'value', 'mar2ThroughputChart', null, xAxisLabel, 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
            //   RenderStaticDiscreteBarChart($.parseJSON(data.finishingRejections), 'label', 'value', 'finishingRejections', null, "RPos", 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);

            nv.addGraph(function () {
                var chart = nv.models.discreteBarChart()
                    .x(function (d) {
                        return d.label
                    })
                    .y(function (d) {
                        return d.value
                    })
                    .showValues(true);

                chart.yAxis.axisLabel("Count");
                chart.xAxis.axisLabel("RPos");

                chart.yAxis.tickFormat(d3.format('.0f'));
                chart.valueFormat(d3.format('.0f'));

                d3.select('#finishingRejections svg')
                    .datum($.parseJSON(data.finishingRejections))
                    .transition().duration(500)
                    .call(chart)
                ;

                // Listen for bar click and get data label and redirect to callback url with param of label.
                chart.discretebar.dispatch.on('elementClick', function (e) {
                    console.log(e.data.label);
                    // Redirect to url with label as param.
                    $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                    $.ajax({
                        type: "POST",
                        data: {"dateRangeCommand": dateCommand, "rPos" : e.data.label},
                        url: rootUrl + "/api/GetPipeDetailToPositionByDate", // Pass in command to api and request new data.
                        dataType: "json",
                        async: true,
                        success: function (data) {
                            $('#modal-body-content').html("");
                            var table = "<table class='table'><thead>";
                            table += "<th>Pipe</th>";
                            table += "<th>FromPos</th>";
                            table += "<th>ToPos</th>";
                            table += "</thead>";
                            table += "<tbody>";
                            for (var i = 0; i < data.length; i++) {
                                table+= "<tr>";
                                table+= "<td>";
                                table+= data[i].TRACK_CODE;
                                table+= "</td>";
                                table+= "<td>";
                                table+= data[i].FROM_ROUTING_POS;
                                table+= "</td>";
                                table+= "<td>";
                                table+= data[i].TO_ROUTING_POS;
                                table+= "</td>";
                                table+= "</tr>";
                            }
                            table+= "</tbody></table>";
                            $('#modal-body-content').html(table);
                            $('#modal').modal('toggle');
                        },
                        complete: function () {
                            $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                        }
                    });
                });
                nv.utils.windowResize(chart.update);
                return chart;
            });


            RenderStaticDiscreteBarChart($.parseJSON(data.finishingDgsScraps), 'label', 'value', 'downgrades', null, "Code", 'Count', '.0f', '.0f', [], true, false, null, null, null, null, null);
            nv.addGraph(function () {
                let chart = nv.models.multiBarChart().staggerLabels(false).stacked(false).showControls(false).legendPosition("right");
                chart.yAxis.axisLabel("Mins");
                chart.xAxis.axisLabel("RoutingPos");
                d3.select('#stoppagesByMachineAndType svg')
                    .datum($.parseJSON(data.hydaStoppages))
                    .transition().duration(500).call(chart);
                nv.utils.windowResize(chart.update); // Intitiate listener for window resize so the chart responds and changes width.
                return chart;
            });
        }

        function UpdateStatsTable(d) {
            let tbl = "<tr><td colspan='5' style='text-align: center; font-weight: bold'>PRODUCTION</td></tr>";
            tbl += "<tr><td>1HYD</td><td>" + (d.hyd1Stats.tons == undefined ? 0 : d.hyd1Stats.tons) + "</td><td>" + (d.hyd1Stats.metres == undefined ? 0 : d.hyd1Stats.metres) + "</td><td>" + (d.hyd1Stats.pipes == undefined ? 0 : d.hyd1Stats.pipes) + "</td><td>0</td></tr>";
            tbl += "<tr><td>2MAR</td><td>" + d.mar2Stats.tons + "</td><td>" + d.mar2Stats.metres + "</td><td>" + d.mar2Stats.pipes + "</td><td>0</td></tr>";
            tbl += "<tr><td>SCRAP</td><td>" + d.finishingScrapStats.tons + "</td><td>" + d.finishingScrapStats.metres + "</td><td>" + d.finishingScrapStats.pipes + "</td><td>0</td></tr>";
            tbl += "<tr><td>DGS</td><td>" + d.finishingDGStats.tons + "</td><td>" + d.finishingDGStats.metres + "</td><td>" + d.finishingDGStats.pipes + "</td><td>0</td></tr>";
            tbl += "<tr><td colspan='5' style='text-align: center; font-weight: bold'>ALLOCATION</td></tr>";

            tbl += "<tr><td>4ALL</td><td>" + d.all4Stats.tons + "</td><td>" + d.all4Stats.metres + "</td><td>" + d.all4Stats.pipes + "</td><td>" + ((d.all4Stats.tons / d.mar2Stats.tons) * 100).toFixed(2) + "%</td></tr>";
            tbl += "<tr><td>4STO (Surplus Stock)</td><td>" + d.sto4Stats.tons + "</td><td>" + d.sto4Stats.metres + "</td><td>" + d.sto4Stats.pipes + "</td><td>" + ((d.sto4Stats.tons / d.mar2Stats.tons) * 100).toFixed(2) + "%</td></tr>";
            tbl += "<tr><td>IDST (Non-prime stock)</td><td>" + d.idstStats.tons + "</td><td>" + d.idstStats.metres + "</td><td>" + d.idstStats.pipes + "</td><td>" + ((d.idstStats.tons / d.mar2Stats.tons) * 100).toFixed(2) + "%</td></tr>";
            tbl += "<tr><td>4DGR (Non-prime stock)</td><td>" + d.dgr4Stats.tons + "</td><td>" + d.dgr4Stats.metres + "</td><td>" + d.dgr4Stats.pipes + "</td><td>" + ((d.dgr4Stats.tons / d.mar2Stats.tons) * 100).toFixed(2) + "%</td></tr>";

            $('#finishingStatsTable').find('tbody').html(tbl);

        }

    </script>




@endsection
