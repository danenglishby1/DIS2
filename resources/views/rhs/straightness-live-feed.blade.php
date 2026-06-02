@extends('layouts.app')

@section('pageTitle', 'Straightness Dashboard')
@section('pageName', 'Straightness Dashboard')
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
        <!-- Area Chart -->
        <div class="fl1-500">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Bend Per Metre STN1 & STN2</h6>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="rhsStraightnessBPMLiveLineChart"
                         class='with-3d-shadow with-transitions'>
                        <svg></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="fl1-500">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Total Bend STN1 & STN2</h6>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="rhsStraightnessTBLiveLineChart"
                         class='with-3d-shadow with-transitions'>
                        <svg></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="simpleflex">
        <div class="fl1-500">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Throughput & Failures</h6>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <h5>STRM Throughput</h5>
                    <div id="straightnessThroughputBarChart">
                        <svg></svg>
                    </div>
                    <hr/>
                    <h5>BPM Failures</h5>
                    <div id="bendPerMetreFailuresBarChart">
                        <svg></svg>
                    </div>
                    <hr/>
                    <h5>TB Failures</h5>
                    <div id="totalBendFailuresBarChart">
                        <svg></svg>
                    </div>

                    <hr/>
                    <h5>Combined Section Failures</h5>
                    <div id="totalSectionFailuresBarChart">
                        <svg></svg>
                    </div>


                    <hr/>
                    <hr/>
                    <h5>Blockmarks</h5>
                    <div id="blockMarkDefectsPerHour">
                        <svg></svg>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="simpleflex">
        <div class="fl1-500">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Last Section Total Bend Trace (<span
                            id="current-trace-section-no"></span>)</h6>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="totalBendTraceLineChart">
                        <svg></svg>
                    </div>


                </div>
            </div>
        </div>

    </div>

@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>
    <script>

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            RenderLiveDiscreteBarChart(rootUrl + '/api/GetBlockMarkDefectsPerHour', 'G', [], true, true, [], '.0f', 'Pipe Count', '.0f', 'Hour', 'blockMarkDefectsPerHour');

            RenderLiveLineWithFocusChartDualAxisLabels(rootUrl + '/api/GetLiveBPMStraightness', 'G', [], 'rhsStraightnessBPMLiveLineChart',
                'lineWithFocus',
                'MM',
                true,
                'Section',
                true,
                true,
                []);

            RenderLiveLineWithFocusChartDualAxisLabels(rootUrl + '/api/GetLiveTBStraightness', 'G', [], 'rhsStraightnessTBLiveLineChart',
                'lineWithFocus',
                'MM',
                true,
                'Section',
                true,
                true,
                []);

            CustomRenderLiveLineWithFocusChartDualAxisLabels(rootUrl + '/api/GetLastTotalBendTrace', 'G', [], 'totalBendTraceLineChart',
                'lineWithFocus',
                'MM',
                true,
                'Section',
                true,
                true,
                []);



            RenderLiveDiscreteBarChart(rootUrl + '/api/GetLiveStraightnessThroughput', 'G', [], true, true, [], '.0f', 'Pipe Count', '.0f', 'Hour', 'straightnessThroughputBarChart');

            RenderLiveDiscreteBarChart(rootUrl + '/api/GetLiveBPMStraightnessFailures', 'G', [], true, true, [], '.0f', 'Pipe Count', '.0f', 'Hour', 'bendPerMetreFailuresBarChart');

            RenderLiveDiscreteBarChart(rootUrl + '/api/GetLiveTBStraightnessFailures', 'G', [], true, true, [], '.0f', 'Pipe Count', '.0f', 'Hour', 'totalBendFailuresBarChart');

            RenderLiveDiscreteBarChart(rootUrl + '/api/GetLiveSectionStraightnessFailures', 'G', [], true, true, [], '.0f', 'Pipe Count', '.0f', 'Hour', 'totalSectionFailuresBarChart');


            function CustomRenderLiveLineWithFocusChartDualAxisLabels(feedURL, getOrPostInd, params, canvasIdentifier, strChartType, strXAxisLabel, boolShowXAxisLabel, strYAxisLabel, boolShowYAxisLabel, boolShowLegend, forceYValues) {
                var data = [];
                var arrLabels1 = [];
                var arrLabels2 = [];

                /***
                 * Get initial chart data
                 */
                if (getOrPostInd == "G") {
                    $.ajax({
                        type: "get",
                        url: feedURL,
                        dataType: "json",
                        async: false,
                        success: function (response) {
                            data = response.values;
                            console.info(data);
                            arrLabels1 = response.labelArrays.xAxisLabels1;
                            arrLabels2 = response.labelArrays.xAxisLabels2;

                            // console.log(arrLabels1);
                            $('#current-trace-section-no').html(response.sectionNo);
                        }
                    });
                } else if (getOrPostInd == "P") {
                    var paramObject = {};
                    if (params.length > 0) {

                    }
                }
                /***
                 * END Get initial chart data
                 */

                return nv.addGraph(function () {

                    var chart =
                        nv.models.lineWithFocusChart();
                    chart.useInteractiveGuideline(true);
                    //   chart.xAxis.tickFormat(d3.format(',f')).axisLabel("Stream - 3,128,.1");
                    chart.margin({"left": 60, "right": 60, "top": 10, "bottom": 65});
                    chart.xAxis
                        .tickFormat(function (d) {
                            return arrLabels1[d];
                        })
                        .axisLabel('Date');
                    chart.x2Axis
                        .tickFormat(function (d) {
                            return arrLabels2[d];
                        })
                        .axisLabel('Date');

                    // if forceYValues array is not empty... then set them to what was specified.. otherwise let the chart render defaults.
                    if (forceYValues.length > 0) {
                        chart.forceY([-forceYValues[0], forceYValues]);
                    }


                    //chart.xAxis.tickFormat(d3.format(',f'));
                    chart.yTickFormat(d3.format(',.2f'));

                    d3.select('#' + canvasIdentifier + ' svg')
                        .datum(data)
                        .call(chart);
                    nv.utils.windowResize(chart.update);


                    // Set repetetive API call to update charts.
                    setInterval(function () {
                        $.ajax({
                            type: "get",
                            url: feedURL,
                            dataType: "json",
                            success: function (response) {
                                chart.xAxis
                                    .tickFormat(function (d) {
                                        return response.labelArrays.xAxisLabels1[d];
                                    });
                                chart.x2Axis
                                    .tickFormat(function (d) {
                                        return response.labelArrays.xAxisLabels2[d];
                                    });
                                $('#current-trace-section-no').html(response.sectionNo);

                                console.log(response.sectionNo);
                                data = response.values;
                                console.log(data);
                                d3.select('#' + canvasIdentifier + ' svg')
                                    .datum(data);
                                chart.update();

                            }
                        });
                    }, 90000);


                    return chartObj;
                });
            }

        });

    </script>

@endsection
