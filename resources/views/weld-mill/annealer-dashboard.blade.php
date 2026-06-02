@extends('layouts.app')

@section('pageTitle', 'Annealer Dashboard')
@section('pageName', 'Annealer Dashboard')
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
    url: rootUrl+'/api/GetAnnealerDashboardAveragesAsNVD3Json',
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
    @include('layouts.templates.daterangepicker')

    <div class="form-group" style="margin-bottom: 0;">
        <label>Coil No Range (yywwnnn)</label>
        <input type="text" name="coilNoRangeStart" id="coilNoRangeStart" value="">
        <input type="text" name="coilNoRangeEnd" id="coilNoRangeEnd" value="">
        <button class="btn btn-primary" id="applyCoilRange">Apply Coil Range</button>
    </div>

    <div class="form-group" style="margin-bottom: 0;" id="exportDataButtonHolder">
        <button class="btn btn-success" id="exportDataBtn">Export Data</button>
    </div>
</div>
<div class="mb-3"></div>

<!-- Content Row -->
<div class="simpleflex">
    <div class="fl1-500">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Annealer - All Series (Segmented)</h6>
            </div>
            <!-- Visual Content -->
            <!-- Card Body -->
            <div class="card-body">
                <div id="weldHeadAllSeriesLineChart" style="height: 400px;"
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
                <h6 class="m-0 font-weight-bold text-primary">Annealer All Series (Raw Data)</h6>
            </div>
            <!-- Visual Content -->
            <!-- Card Body -->
            <div class="card-body">
                <div id="graphdiv" style="width:100%;"></div>

                <div class="tooltips" style="display: flex">
                    <div id="status" style="display:flex; flex-wrap: wrap; min-width:230px; margin-top:10px;"></div>
                    <div id="rawDataCoilNo"
                         style="margin-left:5px; font-weight: bold;font-size: 14px;text-align: right;color: #227aff; margin-top:10px;"></div>
                </div>
                <div id="list" style="display:flex; flex-wrap: wrap; min-width:230px;"></div>
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
        var liveApiFeedUrl = rootUrl + '/api/GetAnnealerDashboardAveragesAsNVD3Json';
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
                FillCoilNoRangeInputs(response.coilNoRange);

            }
        });

        function FillCoilNoRangeInputs(data) {
            // Fill coil range inputs
            $('#coilNoRangeStart').val((data[0] == false ? "" : data[0]));
            $('#coilNoRangeEnd').val((data[1] == false ? "" : data[1]));
        }

        $('#applyCoilRange').click(function () {

            $.ajax({
                type: "POST",
                url: liveApiFeedUrl,
                dataType: "json",
                data: {"coilNoStart": $('#coilNoRangeStart').val(), "coilNoEnd": $('#coilNoRangeEnd').val()},
                async: false,
                success: function (response) {
                    console.log(response);
                    // Build chart
                    BuildLineCharts(response);
                    FillCoilNoRangeInputs(response.coilNoRange);
                }
            });


        });


        /***
         * END Get initial chart data
         */
        function BuildLineCharts(data) {
            BuildNVD3LineCharts(data);
            BuildDyGraphLineChart(data);
        }

        function BuildNVD3LineCharts(data) {
            arrLabels1 = data.labelArrays.coilNoArray;
            arrLabels2 = data.labelArrays.dateTimeArray;

            data = data.values;


            nv.addGraph(function () {
                var chart =
                    nv.models.lineWithFocusChart();
                chart.useInteractiveGuideline(true);
                //   chart.xAxis.tickFormat(d3.format(',f')).axisLabel("Stream - 3,128,.1");
                chart.margin({"left": 110, "right": 60, "top": 10, "bottom": 65});
                chart.xAxis
                    .tickFormat(function (d) {
                        return arrLabels1[d] + " @ " + arrLabels2[d].substr(11, 8);
                    })
                    .axisLabel('CoilNo')
                    .rotateLabels(-15);

                chart.x2Axis
                    .tickFormat(function (d) {
                        return arrLabels2[d];
                    })
                    .axisLabel('Date').staggerLabels(true);

                chart.focus.margin({top: 0, right: 0, bottom: 50, left: 0});

                //chart.xAxis.tickFormat(d3.format(',f'));
                chart.yTickFormat(d3.format(',.2f'));

                d3.select('#weldHeadAllSeriesLineChart svg')
                    .datum(data)
                    .call(chart);

                nv.utils.windowResize(chart.update);

                console.log(chart);


                return chart;
            });


            nv.addGraph(function () {
                var chart =
                    nv.models.lineWithFocusChart();
                chart.useInteractiveGuideline(true);
                //   chart.xAxis.tickFormat(d3.format(',f')).axisLabel("Stream - 3,128,.1");
                chart.margin({"left": 110, "right": 60, "top": 10, "bottom": 65});
                chart.xAxis
                    .tickFormat(function (d) {
                        return arrLabels1[d] + " @ " + arrLabels2[d].substr(11, 8);
                    })
                    .axisLabel('CoilNo')
                    .rotateLabels(-15);
                chart.x2Axis
                    .tickFormat(function (d) {
                        return arrLabels2[d];
                    })
                    .axisLabel('Date').staggerLabels(true);

                chart.focus.margin({top: 0, right: 0, bottom: 50, left: 0});


                //chart.xAxis.tickFormat(d3.format(',f'));
                chart.yTickFormat(d3.format(',.2f'));
                //  console.log(); // speed
                d3.select('#weldHeadSpeedLineChart svg')
                    .datum([data[3]])
                    .call(chart);
                nv.utils.windowResize(chart.update);

                return chartObj;
            });


            nv.addGraph(function () {
                var chart =
                    nv.models.lineWithFocusChart();
                chart.useInteractiveGuideline(true);
                //   chart.xAxis.tickFormat(d3.format(',f')).axisLabel("Stream - 3,128,.1");
                chart.margin({"left": 110, "right": 60, "top": 10, "bottom": 65});
                chart.xAxis
                    .tickFormat(function (d) {
                        return arrLabels1[d] + " @ " + arrLabels2[d].substr(11, 8);
                    })
                    .axisLabel('CoilNo')
                    .rotateLabels(-15);
                chart.x2Axis
                    .tickFormat(function (d) {
                        return arrLabels2[d];
                    })
                    .axisLabel('Date').staggerLabels(true);

                chart.focus.margin({top: 0, right: 0, bottom: 50, left: 0});


                //chart.xAxis.tickFormat(d3.format(',f'));
                chart.yTickFormat(d3.format(',.2f'));
                //  console.log(); // speed
                d3.select('#weldHeadTempsLineChart svg')
                    .datum([data[1], data[4]])
                    .call(chart);
                nv.utils.windowResize(chart.update);

                return chartObj;
            });


            nv.addGraph(function () {
                var chart =
                    nv.models.lineWithFocusChart();
                chart.useInteractiveGuideline(true);
                //   chart.xAxis.tickFormat(d3.format(',f')).axisLabel("Stream - 3,128,.1");
                chart.margin({"left": 110, "right": 60, "top": 10, "bottom": 65});
                chart.xAxis
                    .tickFormat(function (d) {
                        return arrLabels1[d] + " @ " + arrLabels2[d].substr(11, 8);
                    })
                    .axisLabel('CoilNo')
                    .rotateLabels(-15);
                chart.x2Axis
                    .tickFormat(function (d) {
                        return arrLabels2[d];
                    })
                    .axisLabel('Date').staggerLabels(true);

                chart.focus.margin({top: 0, right: 0, bottom: 50, left: 0});


                //chart.xAxis.tickFormat(d3.format(',f'));
                chart.yTickFormat(d3.format(',.2f'));
                //  console.log(); // speed
                d3.select('#weldHeadSigPowerLineChart svg')
                    .datum([data[0], data[2]])
                    .call(chart);
                nv.utils.windowResize(chart.update);

                return chartObj;
            });
        }

        function BuildDyGraphLineChart(data) {
            function nameAnnotation(ann) {
                return "(" + ann.x + ")";
            }

            annotations = [];
            var graph_initialized = false;

            g = new Dygraph(
                // containing div
                document.getElementById("graphdiv"),

                data.csvDataString,
                {
                    highlightCallback: function (e, x, pts, row) {

                        console.log(x, pts, row);
                        $('#rawDataCoilNo').html("COIL_NO: " + data.rawCoilNoArray[row]);
                    },

                    unhighlightCallback: function (e) {
                        $('#rawDataCoilNo').html("");
                    },
                    labelsDiv: document.getElementById('status'),
                    drawCallback: function (g, is_initial) {
                        if (is_initial) {
                            graph_initialized = true;
                            if (annotations.length > 0) {
                                g.setAnnotations(annotations);
                            }
                        }

                        var ann = g.annotations();
                        var html = "";
                        for (var i = 0; i < ann.length; i++) {
                            var name = nameAnnotation(ann[i]);
                            html += "<span id='" + name + "' style='margin:5px;border-radius:2px;border:1px solid #333;padding:2px;'>"
                            html += name + ": " + (ann[i].shortText || '(icon)')
                            html += " -> " + ann[i].text + "</span><br/>";
                        }
                        document.getElementById("list").innerHTML = html;
                    },
                    highlightCallback: function (e, x, pts, row) {

                        console.log(x, pts, row);
                        $('#rawDataCoilNo').html("COIL_NO: " + data.rawCoilNoArray[row]);
                    },

                    unhighlightCallback: function (e) {
                        $('#rawDataCoilNo').html("");
                    },
                    labelsDiv: document.getElementById('status'),
                }
            );
            for (let i = 0; i < data.statusCodesArray.length; i++) {
                console.log("fired 1234");
                console.log(data.statusCodesArray[i].DATETIME_TANDEM);

                annotations.push({
                    series: "ANNEALER_A",
                    x: data.statusCodesArray[i].DATETIME_TANDEM,
                    shortText: data.statusCodesArray[i].PIPE_STATUS_CODE,
                    text: data.statusCodesArray[i].PIPE_STATUS_CODE,
                    tickHeight: 30,
                    tickColor: 'red',
                    tickWidth: 2,
                    width: 30,
                    height: 23,
                    cssClass: 'dyGraphAnnotation',
                });
            }
            //
            // for (let i = 0; i < data.stoppageCodesArray.length; i++) {
            //     annotations.push({
            //         series: "POWER",
            //         x: data.stoppageCodesArray[i].START_DATETIME,
            //         shortText: data.stoppageCodesArray[i].STCO_STOP_CODE,
            //         text: data.stoppageCodesArray[i].STCO_STOP_REASON,
            //         tickHeight: 15,
            //         tickColor: 'red',
            //         tickWidth: 2,
            //         width: 30,
            //         height: 23,
            //         cssClass: 'dyGraphAnnotation',
            //     });
            // }


            if (graph_initialized) {
                g.setAnnotations(annotations);
            }


            g.updateOptions({
                annotationClickHandler: function (ann, point, dg, event) {
                    eventDiv.innerHTML += "click: " + nameAnnotation(ann) + "<br/>";
                },
                annotationDblClickHandler: function (ann, point, dg, event) {
                    eventDiv.innerHTML += "dblclick: " + nameAnnotation(ann) + "<br/>";
                },
                annotationMouseOverHandler: function (ann, point, dg, event) {
                    document.getElementById(nameAnnotation(ann)).style.fontWeight = 'bold';
                    saveBg = ann.div.style.backgroundColor;
                    ann.div.style.backgroundColor = '#ddd';
                },
                annotationMouseOutHandler: function (ann, point, dg, event) {
                    document.getElementById(nameAnnotation(ann)).style.fontWeight = 'normal';
                    ann.div.style.backgroundColor = saveBg;
                },

                pointClickCallback: function (event, p) {
                    // Check if the point is already annotated.
                    if (p.annotation) return;

                    // If not, add one.
                    var ann = {
                        series: p.name,
                        xval: p.xval,
                        shortText: num,
                        text: "Annotation #" + num
                    };
                    var anns = g.annotations();
                    anns.push(ann);
                    g.setAnnotations(anns);

                    num++;
                }
            });
        }


        $('#exportDataBtn').click(function () {

            if ($('#coilNoRangeStart').val() !== '') {

                console.log("sending");
                console.log("sending");
                window.location.href = rootUrl + "/api/GetAnnealerCSV?coilNoStart=" + $('#coilNoRangeStart').val() + "&coilNoEnd=" + $('#coilNoRangeEnd').val();

            }
        });

    </script>
@endsection
