@extends('layouts.app')

@section('pageTitle', 'End Laser Summary')
@section('pageName', 'End Laser Summary')
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


@section('dateRangePickerOnApplyCallback')
    $.ajax({
    type: 'POST',
    data: {'dtFrom': dtFrom, 'dtTo': dtTo},
    url: rootUrl+'/api/GetEndLaserDataAsNVD3JSON',
    dataType: 'json',
    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
    $('.ajax-loader').css('display', 'block');
    },
    success: function (data) {
    console.log(data);
    BuildLineCharts(data);

    },
    complete: function () {
    $('.ajax-loader').css('display', 'none');
    }
    });
@endsection
<div class="filters">
    @include('layouts.templates.daterangepicker')
</div>
<div class="mb-3"></div>

<!-- Content Row -->
<div class="simpleflex">
    <div class="fl1-500">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">End Laser - All Series </h6>
            </div>
            <!-- Visual Content -->
            <!-- Card Body -->
            <div class="card-body">
                <div id="endLaserAllSeriesLineChart" style="height: 400px;"
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
                <h6 class="m-0 font-weight-bold text-primary">OD Avg, Min, Max </h6>
            </div>
            <!-- Visual Content -->
            <!-- Card Body -->
            <div class="card-body">
                <div id="endLaserODLineChart" style="height: 400px;"
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
                <h6 class="m-0 font-weight-bold text-primary">ID Avg, Min, Max </h6>
            </div>
            <!-- Visual Content -->
            <!-- Card Body -->
            <div class="card-body">
                <div id="endLaserIDLineChart" style="height: 400px;"
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
                <h6 class="m-0 font-weight-bold text-primary">WT Avg, Min, Max </h6>
            </div>
            <!-- Visual Content -->
            <!-- Card Body -->
            <div class="card-body">
                <div id="endLaserWTLineChart" style="height: 400px;"
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
                <h6 class="m-0 font-weight-bold text-primary">Ovality </h6>
            </div>
            <!-- Visual Content -->
            <!-- Card Body -->
            <div class="card-body">
                <div id="endLaserOvalityLineChart" style="height: 400px;"
                     class='with-3d-shadow with-transitions'>
                    <svg></svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- here for now -->

@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/libraries/dygraphs/dygraph.min.js')}}"></script>



    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var data = [];
        var arrLabels1 = [];
        var arrLabels2 = [];
        var liveApiFeedUrl = rootUrl + '/api/GetEndLaserDataAsNVD3JSON';
        var liveUpdateOn = true;
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

                // Build chart
                BuildLineCharts(response);

            }
        });




        /***
         * END Get initial chart data
         */
        function BuildLineCharts(data) {
            BuildNVD3LineCharts(data);
        }

        function BuildNVD3LineCharts(data) {
            arrLabels1 = data.labelArrays.pipeNoFrontBackArray;
            arrLabels2 = data.labelArrays.dateTimeFrontBackArray;
            console.log(arrLabels2);
            data = data.values;

            // All series chart
            nv.addGraph(function () {
                var chart =
                    nv.models.lineWithFocusChart();
                chart.useInteractiveGuideline(true);
                //   chart.xAxis.tickFormat(d3.format(',f')).axisLabel("Stream - 3,128,.1");
                chart.margin({"left": 110, "right": 60, "top": 10, "bottom": 65});
                chart.xAxis
                    .tickFormat(function (d) {
                        return arrLabels1[d];
                    })
                    .axisLabel('PipeNo')
                    .rotateLabels(-15);

                chart.x2Axis
                    .tickFormat(function (d) {
                        return arrLabels2[d];
                    })
                    .axisLabel('Date').staggerLabels(true);

                chart.focus.margin({top: 0, right: 0, bottom: 50, left: 0});

                //chart.xAxis.tickFormat(d3.format(',f'));
                chart.yTickFormat(d3.format(',.2f'));

                d3.select('#endLaserAllSeriesLineChart svg')
                    .datum(data)
                    .call(chart);

                nv.utils.windowResize(chart.update);

                console.log(chart);


                return chart;
            });

// OD series chart
            nv.addGraph(function () {
                var chart =
                    nv.models.lineWithFocusChart();
                chart.useInteractiveGuideline(true);
                //   chart.xAxis.tickFormat(d3.format(',f')).axisLabel("Stream - 3,128,.1");
                chart.margin({"left": 110, "right": 60, "top": 10, "bottom": 65});
                chart.xAxis
                    .tickFormat(function (d) {
                        return arrLabels2[d];
                    })
                    .axisLabel('PipeNo')
                    .rotateLabels(-15);

                chart.x2Axis
                    .tickFormat(function (d) {
                        return arrLabels2[d];
                    })
                    .axisLabel('Date').staggerLabels(true);

                chart.focus.margin({top: 0, right: 0, bottom: 50, left: 0});

                //chart.xAxis.tickFormat(d3.format(',f'));
                chart.yTickFormat(d3.format(',.2f'));

                d3.select('#endLaserODLineChart svg')
                    .datum([data[0], data[1], data[2]])
                    .call(chart);

                nv.utils.windowResize(chart.update);

                console.log(chart);


                return chart;
            });

// ID series chart
            nv.addGraph(function () {
                var chart =
                    nv.models.lineWithFocusChart();
                chart.useInteractiveGuideline(true);
                //   chart.xAxis.tickFormat(d3.format(',f')).axisLabel("Stream - 3,128,.1");
                chart.margin({"left": 110, "right": 60, "top": 10, "bottom": 65});
                chart.xAxis
                    .tickFormat(function (d) {
                        return arrLabels2[d];
                    })
                    .axisLabel('Date')
                    .rotateLabels(-15);

                chart.x2Axis
                    .tickFormat(function (d) {
                        return arrLabels2[d];
                    })
                    .axisLabel('Date').staggerLabels(true);

                chart.focus.margin({top: 0, right: 0, bottom: 50, left: 0});

                //chart.xAxis.tickFormat(d3.format(',f'));
                chart.yTickFormat(d3.format(',.2f'));

                d3.select('#endLaserIDLineChart svg')
                    .datum([data[3], data[4], data[5]])
                    .call(chart);

                nv.utils.windowResize(chart.update);

                console.log(chart);


                return chart;
            });


            // WT series chart
            nv.addGraph(function () {
                var chart =
                    nv.models.lineWithFocusChart();
                chart.useInteractiveGuideline(true);
                //   chart.xAxis.tickFormat(d3.format(',f')).axisLabel("Stream - 3,128,.1");
                chart.margin({"left": 110, "right": 60, "top": 10, "bottom": 65});
                chart.xAxis
                    .tickFormat(function (d) {
                        return arrLabels2[d];
                    })
                    .axisLabel('Date')
                    .rotateLabels(-15);

                chart.x2Axis
                    .tickFormat(function (d) {
                        return arrLabels2[d];
                    })
                    .axisLabel('Date').staggerLabels(true);

                chart.focus.margin({top: 0, right: 0, bottom: 50, left: 0});

                //chart.xAxis.tickFormat(d3.format(',f'));
                chart.yTickFormat(d3.format(',.2f'));

                d3.select('#endLaserWTLineChart svg')
                    .datum([data[6], data[7], data[8]])
                    .call(chart);

                nv.utils.windowResize(chart.update);

                console.log(chart);


                return chart;
            });



            // WT series chart
            nv.addGraph(function () {
                var chart =
                    nv.models.lineWithFocusChart();
                chart.useInteractiveGuideline(true);
                //   chart.xAxis.tickFormat(d3.format(',f')).axisLabel("Stream - 3,128,.1");
                chart.margin({"left": 110, "right": 60, "top": 10, "bottom": 65});
                chart.xAxis
                    .tickFormat(function (d) {
                        return arrLabels2[d];
                    })
                    .axisLabel('Date')
                    .rotateLabels(-15);

                chart.x2Axis
                    .tickFormat(function (d) {
                        return arrLabels2[d];
                    })
                    .axisLabel('Date').staggerLabels(true);

                chart.focus.margin({top: 0, right: 0, bottom: 50, left: 0});

                //chart.xAxis.tickFormat(d3.format(',f'));
                chart.yTickFormat(d3.format(',.2f'));

                d3.select('#endLaserOvalityLineChart svg')
                    .datum([data[9]])
                    .call(chart);

                nv.utils.windowResize(chart.update);

                console.log(chart);


                return chart;
            });

        }




    </script>
@endsection
