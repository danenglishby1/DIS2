@extends('layouts.app')

@section('pageTitle', 'PLC Weld Head Dashboard')
@section('pageName', 'PLC Weld Head Dashboard')
@section('weldMillActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/dygraphs/dygraph.min.css')}}"/>

    <style>
        .dyGraphAnnotation {
            background: #ececec;
            border: 1px solid #cccccc;
            border-radius: 2px;
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


@section('dateRangePickerOnApplyCallback')
    $.ajax({
    type: 'POST',
    data: {'dtFrom': dtFrom, 'dtTo': dtTo},
    url: rootUrl+'/api/GetWeldHeadDashboardAveragesAsNVD3Json',
    dataType: 'json',
    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
    $('.ajax-loader').css('display', 'block');
    },
    success: function (data) {
    console.log(data);
    BuildLineCharts(data);
    FillCoilNoRangeInputs(data.coilNoRange);

    },
    complete: function () {
    $('.ajax-loader').css('display', 'none');
    }
    });
@endsection
<div class="filters">

</div>
<div class="mb-3"></div>

<!-- Content Row -->
<div class="simpleflex">
    <div class="fl1-500">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Weld Mill PLC</h6>
            </div>
            <!-- Visual Content -->
            <!-- Card Body -->
            <div class="card-body">

                <figure class="highcharts-figure">
                    <div id="container"></div>
                    <p class="highcharts-description">
{{--                        Chart showing data updating every second, with old data being removed.--}}
                    </p>
                </figure>





{{--                <figure class="highcharts-figure2">--}}
{{--                    <div id="container2"></div>--}}
{{--                    <p class="highcharts-description">--}}
{{--                        Chart showing use of plot bands with a gauge series. The chart is--}}
{{--                        updated dynamically every few seconds.--}}
{{--                    </p>--}}
{{--                </figure>--}}
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
    <script src="{{ asset('public/js/highcharts/code/highcharts.js')}}"></script>



    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
     //   var data = [];
        var arrLabels1 = [];
        var arrLabels2 = [];
        var liveApiFeedUrl = rootUrl + '/api/GetWeldPowerLastXMins';
        var liveUpdateOn = true;
        var initialChartData = [];
        var lastTimeStampRead = "";
        //   var data = [];

        /***
         * Get initial chart data
         */
        $.ajax({
            type: "GET",
            url: liveApiFeedUrl,
            dataType: "json",
            async: false,
            success: function (response) {
                console.log(response);
                initialChartData = response;
                console.log("last", response[0].created_at)
                lastTimeStampRead = response[0].created_at;
                // // Build chart
                // BuildLineCharts(response);
                // FillCoilNoRangeInputs(response.coilNoRange);

            }
        });


        // GET initial data (unchanged)
        var initialChartData = [];
        $.ajax({
            type: "GET",
            url: liveApiFeedUrl,
            dataType: "json",
            async: false,
            success: function (response) {
                initialChartData = response || [];
                if (initialChartData.length) {
                    lastTimeStampRead = initialChartData[0].created_at;
                }
            }
        });

        function parseTS(tsString) {
            if (typeof tsString !== 'string') return NaN;
            return new Date(tsString.replace(' ', 'T')).getTime();
        }

        // ensure sorted oldest -> newest
        initialChartData.sort((a, b) => parseTS(a.created_at) - parseTS(b.created_at));

        // Build two series' initial data arrays (data1 and data2)
        const data1 = [];
        const data2 = [];
        const data3 = [];
        for (let i = 0; i < initialChartData.length; i++) {
            const row = initialChartData[i];
            const x = parseTS(row.created_at);
            const y1 = Number(row.weld_power);
            const y2 = Number(row.smoothed_weld_temp); // second metric
            const y3 = Number(row.sizing_speed); // second metric
            if (!isNaN(x) && !isNaN(y1)) data1.push({ x: x, y: y1 });
            if (!isNaN(x) && !isNaN(y2)) data2.push({ x: x, y: y2 });
            if (!isNaN(x) && !isNaN(y3)) data3.push({ x: x, y: y3 });
        }
        // dedupe helper (keeps last of duplicates)
        function dedupeSeries(arr) {
            if (!arr.length) return arr;
            const out = [];
            for (let i = 0; i < arr.length; i++) {
                if (i && arr[i].x === arr[i-1].x) {
                    out[out.length - 1] = arr[i]; // replace previous
                } else {
                    out.push(arr[i]);
                }
            }
            return out;
        }
        const initData1 = dedupeSeries(data1);
        const initData2 = dedupeSeries(data2);
        const initData3 = dedupeSeries(data3);

        // repairSeries now accepts chart and (optionally) seriesIndex or repairs all
        function repairSeries(chart, maxPoints = 5000, seriesIndex = null) {
            const seriesList = typeof seriesIndex === 'number' ? [chart.series[seriesIndex]] : chart.series;
            seriesList.forEach(s => {
                const pts = s.data.map(p => ({ x: p.x, y: p.y }));
                pts.sort((a, b) => a.x - b.x);
                const dedup = [];
                for (let i = 0; i < pts.length; i++) {
                    if (i && pts[i].x === pts[i-1].x) {
                        dedup[dedup.length - 1] = pts[i];
                    } else {
                        dedup.push(pts[i]);
                    }
                }
                const finalData = dedup.length > maxPoints ? dedup.slice(dedup.length - maxPoints) : dedup;
                s.setData(finalData, true);
            });
            console.log('Repaired series(es).');
        }

        if (initialChartData.length) {
            lastTimeStampRead = initialChartData[initialChartData.length - 1].created_at;
        }

        // onChartLoad updates all three series from a single API response that includes all metrics
        const onChartLoad = function () {
            const chart = this;
            const s1 = chart.series[0];
            const s2 = chart.series[1];
            const s3 = chart.series[2];          // <-- define s3
            const maxPoints = 1200;

            // repair all series on first load
            repairSeries(chart, Math.max(maxPoints, 2000));

            setInterval(function () {
                $.ajax({
                    type: "POST",
                    url: liveApiFeedUrl,
                    dataType: "json",
                    data: { "created_at": lastTimeStampRead },
                    success: function (response) {
                        if (!response || !response.length) return;

                        // map response to points for all three series (use the same property names you used initially)
                        const incoming1 = [];
                        const incoming2 = [];
                        const incoming3 = [];

                        response.forEach(r => {
                            const x = parseTS(r.created_at);
                            const y1 = Number(r.weld_power);           // <- match server fields
                            const y2 = Number(r.smoothed_weld_temp);   // <- match server fields
                            const y3 = Number(r.sizing_speed);         // <- match server fields

                            if (!isNaN(x) && !isNaN(y1)) incoming1.push({ x: x, y: y1, raw: r });
                            if (!isNaN(x) && !isNaN(y2)) incoming2.push({ x: x, y: y2, raw: r });
                            if (!isNaN(x) && !isNaN(y3)) incoming3.push({ x: x, y: y3, raw: r });
                        });

                        // helper to merge existing series data with incoming for a given series
                        function mergeAndSet(series, incoming) {
                            if (!incoming.length) return;
                            const existing = series.data.map(p => ({ x: p.x, y: p.y }));
                            const merged = existing.concat(incoming).sort((a, b) => a.x - b.x);
                            const deduped = [];
                            for (let i = 0; i < merged.length; i++) {
                                if (i && merged[i].x === merged[i - 1].x) {
                                    deduped[deduped.length - 1] = merged[i];
                                } else {
                                    deduped.push(merged[i]);
                                }
                            }
                            const finalData = deduped.length > maxPoints ? deduped.slice(deduped.length - maxPoints) : deduped;
                            series.setData(finalData, true);
                        }

                        // update the three series if there are incoming points
                        mergeAndSet(s1, incoming1);
                        mergeAndSet(s2, incoming2);
                        mergeAndSet(s3, incoming3);

                        // update lastTimeStampRead to newest created_at returned by server (string)
                        // Use the last element in the response array as the server returns rows oldest->newest
                        lastTimeStampRead = response[response.length - 1].created_at;

                        console.log('Incoming rows:', response.length,
                            's1 added:', incoming1.length,
                            's2 added:', incoming2.length,
                            's3 added:', incoming3.length);
                    },
                    error: function (xhr, status, err) {
                        console.warn('Live feed error:', status, err);
                    }
                });
            }, 5000);
        };

        // pulse plugin unchanged (works for multiple series)
        Highcharts.addEvent(Highcharts.Series, 'addPoint', e => {
            const point = e.point,
                series = e.target;

            if (!series.pulse) {
                series.pulse = series.chart.renderer.circle()
                    .add(series.markerGroup);
            }

            setTimeout(() => {
                series.pulse
                    .attr({
                        x: series.xAxis.toPixels(point.x, true),
                        y: series.yAxis.toPixels(point.y, true),
                        r: series.options.marker && series.options.marker.radius || 3,
                        opacity: 1,
                        fill: series.color
                    })
                    .animate({
                        r: 20,
                        opacity: 0
                    }, {
                        duration: 1000
                    });
            }, 1);
        });

        // Build the chart with TWO series
        Highcharts.chart('container', {
            chart: {
                type: 'spline',
                events: { load: onChartLoad }
            },
            time: { useUTC: false },
            title: { text: 'Welding PLC' },
            xAxis: { type: 'datetime', tickPixelInterval: 150, maxPadding: 0.1 },
            yAxis: { title: { text: 'Value' }, plotLines: [{ value: 0, width: 1, color: '#808080' }] },
            tooltip: {
                crosshairs: true,
                animation: true,
                shared: true,
                // formatter: function() {
                //     return new Date(this.x) + '<br>'
                //         + this.points[0].series.name + ': ' + this.points[0].y + '<br>'
                //         + this.points[1].series.name + ': ' + this.points[1].y;
                // }
            },
            legend: { enabled: true }, // show legend for two series
            exporting: { enabled: false },
            series: [
                {
                    name: 'Weld Power',
                    lineWidth: 2,
                    color: Highcharts.getOptions().colors[2],
                    data: initData1
                },
                {
                    name: 'Smoothed Weld Temp',
                    lineWidth: 2,
                    color: Highcharts.getOptions().colors[0],
                    data: initData2
                }
                ,
                {
                    name: 'Weld Speed',
                    lineWidth: 2,
                    color: Highcharts.getOptions().colors[0],
                    data: initData3
                }
            ]
        });






    </script>
@endsection
