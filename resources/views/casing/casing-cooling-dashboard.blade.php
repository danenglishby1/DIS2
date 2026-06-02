@extends('layouts.app')

@section('pageTitle', 'Cooling Summary Dashboard')
@section('pageName', 'Cooling Summary Dashboard (24H)')
@section('casingActiveLink', 'active activeUnderline')
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
    @section('dateRangePickerOnApplyCallback')
            $.ajax({
                type: 'POST',
                data: {'dtFrom': dtFrom, 'dtTo': dtTo},
                url: rootUrl+'/api/GetCasingCoolingData',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {
                    RebuildAllCharts(data);

                    liveApiUpdateOn = false;
                },
                complete: function () {
                    $('.ajax-loader').css('display', 'none');
                }
            });
    @endsection
<div class="filters">
    @include('layouts.templates.daterangepicker')



</div>



    <div class="simpleflex justify-content-center">
        <div class="btn-flex mt-2 text-center">

        </div>
    </div>



    <div class="mb-3"></div> <!-- add space -->


    <!-- Content Row -->
    <div class="simpleflex">
        <div class="fl1-500">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Quench Machine - All Series - Last 100 Sections of Date Range</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                             aria-labelledby="dropdownMenuLink">
                        </div>
                    </div>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="allQuenchFeedsLineChart"
                         class='with-3d-shadow with-transitions'>
                        <svg></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="simpleflex">
        <div class="fl1-500">
            <div class="card shadow pb-2">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Accelerated Cooling Output </h6>
                    <span class="live-status pull-right"></span>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="acceleratedCoolingThroughput">
                        <svg></svg>
                    </div>
                    <hr/>
                    <h4>Failures</h4>
                    <h6>Drop Fails</h6>
                    <div id="dropFailureThroughput">
                        <svg></svg>
                    </div>
                    <h6>Outlet < 600 Fails</h6>
                    <div id="outletLessThan600FailureThroughput">
                        <svg></svg>
                    </div>

                    <hr/>
                    <h5>Stats</h5>
                    <div class="simpleflex">
                        <div class="fl1">
                            <h6 style="text-decoration: underline;">Section Count</h6>
                            <span id="sectionCountStat" class="section-count"></span>
                        </div>
                        <div class="fl1">
                            <h6 style="text-decoration: underline;">Section Fails</h6>
                            <span id="sectionFailStat"></span>
                        </div>
                        <div class="fl1">
                            <h6 style="text-decoration: underline;">Failure Rate</h6>
                            <span id="failureRateStat"></span>
                        </div>
                    </div>
                </div>


                <hr/>
                <h4>Warnings</h4>
                <h6><b>Inlet</b> Zero Pyro Trace Warnings</h6>
                <div id="inletZeroPyroTraceWarningThroughput">
                    <svg></svg>
                </div>
                <h6><b>Outlet</b> Zero Pyro Trace Warnings</h6>
                <div id="outletZeroPyroTraceWarningThroughput">
                    <svg></svg>
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

        var data = [];
        var arrLabels1 = [];
        var arrLabels2 = [];
        var liveApiFeedUrl = rootUrl + '/api/GetCasingCoolingData';
        var liveApiUpdateOn = true;
        /***
         * Get initial chart data
         */
        $.ajax({
            type: "POST",
            url: liveApiFeedUrl,
            dataType: "json",
            async: false,
            success: function (response) {
                console.log(response);
                data = response.allCoolingPyroTraces.values;

                console.info(data);
                arrLabels1 = response.allCoolingPyroTraces.labelArrays.xAxisLabels1;
                arrLabels2 = response.allCoolingPyroTraces.labelArrays.xAxisLabels2;
                UpdateStats(response.stats.totalSectionCount, response.stats.totalSectionFailures);
                UpdateAllBarCharts(response);
            }
        });

        /***
         * END Get initial chart data
         */

        nv.addGraph(function () {

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


            //chart.xAxis.tickFormat(d3.format(',f'));
            chart.yTickFormat(d3.format(',.2f'));

            d3.select('#allQuenchFeedsLineChart svg')
                .datum(data)
                .call(chart);
            nv.utils.windowResize(chart.update);

            // Set repetetive API call to update charts.
            setInterval(function () {
                if (liveApiUpdateOn) {


                    $.ajax({
                        type: "POST",
                        url: liveApiFeedUrl,
                        dataType: "json",
                        success: function (response) {
                            chart.xAxis
                                .tickFormat(function (d) {

                                    return response.allCoolingPyroTraces.labelArrays.xAxisLabels1[d];
                                });
                            chart.x2Axis
                                .tickFormat(function (d) {
                                    return response.allCoolingPyroTraces.labelArrays.xAxisLabels2[d];
                                });
                            data = response.allCoolingPyroTraces.values;
                            console.log(data);
                            d3.select('#allQuenchFeedsLineChart svg')
                                .datum(data);
                            chart.update();

                            // Update the rest of the page charts
                            UpdateAllBarCharts(response);
                            UpdateStats(response.stats.totalSectionCount, response.stats.totalSectionFailures);
                        }
                    });
                }
            }, 30000003);

            return chartObj;
        });

        function UpdateStats(sectionCount, sectionFail) {
            $('#sectionCountStat').html(sectionCount);
            $('#sectionFailStat').html(sectionFail);
            $('#failureRateStat').html((sectionCount > 0 ? ((sectionFail / sectionCount)*100).toFixed(2) : 0));
        }

        function UpdateAllBarCharts(data) {

            var coolingThroughput = $.parseJSON(data.coolingThroughput);

            var dropFailuresByHourJSON = $.parseJSON(data.dropFailureThroughputFailures);
            var outletLessThan600CountByHourJSON = $.parseJSON(data.outletLessThan600ThroughputFailures);
            var inletZeroPyroTraceWarningCountByHourJSON = $.parseJSON(data.inletZeroPyroTraceWarnings);
            var ouletZeroPyroTraceWarningCountByHourJSON = $.parseJSON(data.outletZeroPyroTraceWarnings);


            // Get throughput data and pass into chart functions.
            RenderStaticDiscreteBarChart(coolingThroughput, "label", "value", "acceleratedCoolingThroughput", null, "Hour", "Pipe Count", ",0f", ",0f", [0, 30], true, false, null, null, null, null, null);
            RenderStaticDiscreteBarChart(dropFailuresByHourJSON, "label", "value", "dropFailureThroughput", null, "Hour", "Failure Count", ",0f", ",0f", [0, 30], true, false, null, null, null, null, null);
            RenderStaticDiscreteBarChart(inletZeroPyroTraceWarningCountByHourJSON, "label", "value", "inletZeroPyroTraceWarningThroughput", null, "Hour", "Failure Count", ",0f", ",0f", [0, 30], true, false, null, null, null, null, null);
            RenderStaticDiscreteBarChart(ouletZeroPyroTraceWarningCountByHourJSON, "label", "value", "outletZeroPyroTraceWarningThroughput", null, "Hour", "Failure Count", ",0f", ",0f", [0, 30], true, false, null, null, null, null, null);
            RenderStaticDiscreteBarChart(outletLessThan600CountByHourJSON, "label", "value", "outletLessThan600FailureThroughput", null, "Hour", "Failure Count", ",0f", ",0f", [0, 30], true, false, null, null, null, null, null);
        }



        function RebuildAllCharts(response) {

            let data = response.allCoolingPyroTraces.values;
            UpdateStats(response.stats.totalSectionCount, response.stats.totalSectionFailures);
            console.info(data);
            let arrLabels1 = response.allCoolingPyroTraces.labelArrays.xAxisLabels1;
            let arrLabels2 = response.allCoolingPyroTraces.labelArrays.xAxisLabels2;

            UpdateAllBarCharts(response);

            nv.addGraph(function () {

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


                //chart.xAxis.tickFormat(d3.format(',f'));
                chart.yTickFormat(d3.format(',.2f'));

                d3.select('#allQuenchFeedsLineChart svg')
                    .datum(data)
                    .call(chart);
                nv.utils.windowResize(chart.update);

                // Set repetetive API call to update charts.

                return chartObj;
            });

        }
    </script>



@endsection

