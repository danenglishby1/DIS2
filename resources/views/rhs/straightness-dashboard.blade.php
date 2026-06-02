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
                    <div id="rhsStraightnessBPMLineChart" style="height:300px"
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
                    <div id="rhsStraightnessTBLineChart" style="height:300px"
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
                            class="current-trace-section-no"></span>)</h6>
                    <div>

                        <button id="minusTenSections">-10</button>
                        <button id="minusOneSection">-1</button>
                        <button id="plusOneSection">+1</button>
                        <button id="plusTenSections">+10</button>

                        <input type="number" placeholder="Enter Year YYYY" id="sectionYear" value="{{date('Y')}}">
                        <input type="text" id="current-trace-section-no">
                        <button type="submit" id="changeSectionTraceBtn">Change</button></div>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <h5>Station1</h5>
                        <div id="totalBendTraceStation1LineChart" style="height: 400px;">
                            <svg></svg>
                        </div>
                </div>

                <div class="card-body">
                    <h5>Station2</h5>
                    <div id="totalBendTraceStation2LineChart" style="height: 400px;">
                        <svg></svg>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <div class="card-body">
        <div id="totalBendTraceStation2LineChart">
            <svg></svg>
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

            function GetStraightnessDashboardDataAndBuildCharts() {
                $('.ajax-loader').css("display", "block");
                $.ajax({
                    type: "POST",
                    url: rootUrl + "/api/getStraightnessDashboardData",
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        if (data.length == 0) {
                            alert("No data found for query criteria");
                        } else {
                            BuildCharts(data);
                        }
                    },
                    complete: function () {
                        $('.ajax-loader').css("display", "none");
                    }
                });
            }

            // test

            function BuildCharts(data) {
                var totalBendTraceData = $.parseJSON(data.lastSectionTotalBendTrace);
                var totalBendTraceSection = totalBendTraceData.station1.sectionNo;
                $('#current-trace-section-no').val(totalBendTraceSection);
                $('.current-trace-section-no').html(totalBendTraceSection);
                RenderLineWithFocusChartDualAxisLabels('rhsStraightnessBPMLineChart', null, data.sectionTimeLabelArray, data.dateTimeLabelArray, $.parseJSON(data.bpmStraightnessBPMKeyValueJson), "Date/Section", true, "MM", true, true, false);
                RenderLineWithFocusChartDualAxisLabels('rhsStraightnessTBLineChart', null, data.sectionTimeLabelArray, data.dateTimeLabelArray, $.parseJSON(data.tbStraightnessBPMKeyValueJson), "Date/Section", true, "MM", true, true, false);
                RenderLineWithFocusChartDualAxisLabels('totalBendTraceStation1LineChart', null, totalBendTraceData.station1.labelArrays.xAxisLabels1, totalBendTraceData.station1.labelArrays.xAxisLabels1, totalBendTraceData.station1.values, "Pos", true, "MM", true, true, false);
                RenderLineWithFocusChartDualAxisLabels('totalBendTraceStation2LineChart', null, totalBendTraceData.station2.labelArrays.xAxisLabels1, totalBendTraceData.station2.labelArrays.xAxisLabels1, totalBendTraceData.station2.values, "Pos", true, "MM", true, true, false);
                RenderStaticDiscreteBarChart([$.parseJSON(data.straightnessThroughputJson)], 'label', 'value','straightnessThroughputBarChart',null,'HOUR', 'Count',',01f',',01f', [], true, false, null,null,null,null,null);
                RenderStaticDiscreteBarChart([$.parseJSON(data.bpmFailureJson)], 'label', 'value','bendPerMetreFailuresBarChart',null,'HOUR', 'FailCount',',01f',',01f', [], true, false, null,null,null,null,null);
                RenderStaticDiscreteBarChart([$.parseJSON(data.tbFailureJson)], 'label', 'value','totalBendFailuresBarChart',null,'HOUR', 'FailCount',',01f',',01f', [], true, false, null,null,null,null,null);
                RenderStaticDiscreteBarChart([$.parseJSON(data.bpmOrTbFailureJson)], 'label', 'value','totalSectionFailuresBarChart',null,'HOUR', 'FailCount',',01f',',01f', [], true, false, null,null,null,null,null);
                RenderStaticDiscreteBarChart([$.parseJSON(data.blockmarkDefectsJson)], 'label', 'value','blockMarkDefectsPerHour',null,'HOUR', 'FailCount',',01f',',01f', [], true, false, null,null,null,null,null);
            }

            setInterval(function () {
                GetStraightnessDashboardDataAndBuildCharts();
            }, 300000);
            GetStraightnessDashboardDataAndBuildCharts();

            $('#changeSectionTraceBtn').click( function () {
                var sectionNo = $('#current-trace-section-no').val();
                var sectionYear = $('#sectionYear').val();

                $('.ajax-loader').css("display", "block");
                $.ajax({
                    type: "POST",
                    url: rootUrl + "/api/getStraightnessTraceBySectionNo",
                    dataType: "json",
                    data: {"sectionNo" : sectionNo, "sectionYear" : sectionYear},
                    success: function (data) {
                     //   console.log(data.labelArrays.xAxisLabels1);
                        RenderLineWithFocusChartDualAxisLabels('totalBendTraceStation1LineChart', null, data.station1.labelArrays.xAxisLabels1, data.station1.labelArrays.xAxisLabels1, data.station1.values, "Pos", true, "MM", true, true, false);
                        RenderLineWithFocusChartDualAxisLabels('totalBendTraceStation2LineChart', null, data.station2.labelArrays.xAxisLabels1, data.station2.labelArrays.xAxisLabels1, data.station2.values, "Pos", true, "MM", true, true, false);
                        // RenderLineWithFocusChartDualAxisLabels('totalBendTraceLineChart', null, data.station1.labelArrays.xAxisLabels1, data.station2.labelArrays.xAxisLabels1, data.station1.values, "Pos", true, "MM", true, true, false);
                        $('.current-trace-section-no').html(data.station1.sectionNo);
                        },
                    complete: function () {
                        $('.ajax-loader').css("display", "none");
                    }
                });
            });
        });


        $('#minusOneSection, #minusTenSections, #plusOneSection, #plusTenSections').click( function () {
            var toggleValue = parseInt($(this).html());
            toggleSectionNoByXSections(toggleValue)
        });

        function toggleSectionNoByXSections(toggleValue) {
            var sectionNoString = $('#current-trace-section-no').val();
            var sectionNo = parseInt(sectionNoString.substr(1, 10)) + toggleValue;
            console.log(sectionNo);
            var sectionYear = $('#sectionYear').val();


            $('.ajax-loader').css("display", "block");
            $.ajax({
                type: "POST",
                url: rootUrl + "/api/getStraightnessTraceBySectionNo",
                dataType: "json",
                data: {"sectionNo" : "R" + sectionNo, "sectionYear" : sectionYear},
                success: function (data) {
                    var totalBendTraceSection = data.station1.sectionNo;

                    $('#current-trace-section-no').val(totalBendTraceSection);
                    $('.current-trace-section-no').html(totalBendTraceSection);
                    RenderLineWithFocusChartDualAxisLabels('totalBendTraceStation1LineChart', null, data.station1.labelArrays.xAxisLabels1, data.station1.labelArrays.xAxisLabels1, data.station1.values, "Pos", true, "MM", true, true, false);
                    RenderLineWithFocusChartDualAxisLabels('totalBendTraceStation2LineChart', null, data.station2.labelArrays.xAxisLabels1, data.station2.labelArrays.xAxisLabels1, data.station2.values, "Pos", true, "MM", true, true, false);
                    $('.current-trace-section-no').html(data.station1.sectionNo);
                },
                complete: function () {
                    $('.ajax-loader').css("display", "none");
                }
            });
        }

    </script>

@endsection
