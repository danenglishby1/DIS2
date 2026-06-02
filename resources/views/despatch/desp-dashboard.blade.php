@extends('layouts.app')

@section('pageTitle', 'Desp Dashboard')
@section('pageName', 'Desp Dashboard')

@section('content')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
@endsection


<div style="text-align: center;
    margin-top: -50px;">
    <h2>Desp Dashboard</h2>
</div>
@section('overrideStartEndDate')
    start = moment().day('Sunday');
    end = moment().day('Saturday');

    window.dtFrom = start.format('Y-MM-DD 00:00:01');
    window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.
@endsection
@section('dateRangePickerOnApplyCallback')
    window.dtFrom = dtFrom;
    window.dtTo = dtTo;
    $.ajax({
    type: 'POST',
    data: {'dtFrom': dtFrom, 'dtTo': dtTo},
    url: rootUrl+'/api/getDespDashboardData',
    dataType: 'json',
    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
    $('.ajax-loader').css('display', 'block');
    },
    success: function (data) {
    console.log(data);
    BuildCharts(data);
    BuildSummaryTonnesTable(data.summaryTonnesArray);
    buildCustomerSelectList(data.customerList);
    },
    complete: function () {
    $('.ajax-loader').css('display', 'none');
    }
    });
@endsection

<div class="filters" style="justify-content: normal;">
    @include('layouts.templates.daterangepicker')
</div>
<sub style="margin-left: 15px;display: block;"><b>Please Note:</b> Date selected older than 80 days may having missing data</sub>
<div class="mb-3"></div>

<div class="dashboardContainer" style="display: flex;">

    <div class="dashboard-flex-card" style="flex:2; margin:1em; overflow-y: scroll; height: 100vh">

        <div class="card-body">
            <h5>Despatch Tonnes Summary</h5>
            <div id="summaryTonnesTable">

            </div>
        </div>
        <hr />
        <div class="card-body" style="margin-bottom: 30px">
            <h5>Tonnes By Customer</h5>
            <div id="tonnesByCustomerIntervalBarChart" style="height: 250px;">
                <svg></svg>
            </div>
            <div class="form-group">
                <label>Filter by Customer</label>
                <select class="form-control" id="customersSelectList">

                </select>
            </div>
        </div>
        <hr />
        <div class="despDashboardLinkButtons d-flex flex-wrap">
            <a href="{{route('desp-order-tracking-dashboard')}}" class="btn btn-primary">Order Tracking</a>
            <a href="{{route('desp-rfd-dashboard')}}" class="btn btn-primary">RFD - Available Despatch</a>
            <a href="#" class="btn btn-warning">P&O Performance (Coming soon)</a>
            <a href="#" class="btn btn-warning">P&O Portal (Coming soon)</a>
            <a href="{{route('desp-non-prime-stock-dashboard')}}" class="btn btn-primary">Non Prime Stock</a>
            <a href="#" class="btn btn-warning">Daily Load Plan UK (Coming soon)</a>
{{--            <a href="{{route('daily-load-plan')}}" class="btn btn-primary">Daily Load Plan UK</a>--}}
            <a href="#" class="btn btn-warning">Daily Load Plan Export (Coming soon)</a>

        </div>

    </div>


    <div class="dashboard-flex-card" style="flex:3; margin:1em;">

        <div class="card-body" style="margin-bottom: 5px">

            <h5>Top 20 Tonnes Desp By Customer</h5>
            <div id="tonnesByCustomerBarChart" style="height: 225px;">
                <svg></svg>
            </div>
            <div style="margin-top: 20px;">
                <button data-exporthomeind="H" class="btn btn-warning exportHomeFilterBtn">UK & Ireland</button>
                <button data-exporthomeind="X" class="btn btn-warning exportHomeFilterBtn">Export</button>
                <button data-energytubesind="E" class="btn btn-warning energyTubesFilterBtn">Energy</button>
                <button data-energytubesind="T" class="btn btn-warning energyTubesFilterBtn">Tubes</button>
            </div>
        </div>
        <hr />
        <div class="card-body" style="margin-bottom: 5px">
            <h5>Tonnes By Interval</h5>
            <div id="tonnesByIntervalBarChart" style="height: 225px;">
                <svg></svg>
            </div>
        </div>
        <hr />
        <div class="card-body" style="margin-bottom: 5px">
            <h5>Top 20 Tonnes Desp By Haulier</h5>
            <div id="tonnesByHaulierBarChart" style="height: 225px;">
                <svg></svg>
            </div>
        </div>
    </div>


</div>


@endsection

@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js?v=1.21')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js?v=1.12')}}"></script>
    <script>


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function BuildCharts(data) {
            console.log("tonnesByCustomerChart ready to fire");
            RenderStaticDiscreteBarChart($.parseJSON(data.tonnesByCustomerJson), 'label', 'value', 'tonnesByCustomerBarChart', '', "Customer", 'Tonnes', '.0f', '.0f', [], true, false, null, null, null, null, null, 90, {
                top: 30,
                right: 20,
                bottom: 80,
                left: 40
            });


            RenderStaticDiscreteBarChart($.parseJSON(data.tonnesByHaulierJson), 'label', 'value', 'tonnesByHaulierBarChart', '', "Haulier", 'Tonnes', '.0f', '.0f', [], true, false, null, null, null, null, null, 90, {
                top: 30,
                right: 20,
                bottom: 80,
                left: 40
            });




            nv.addGraph(function () {
                var chart = nv.models.multiBarChart()
                    .margin({top: 0, right: 0, bottom: 75, left: 75})
                    .x(function(d) { return d.x })
                    .y(function(d) { return d.y });
                    // .stacked(true).showControls(true).staggerLabels(false);

                chart.yAxis.axisLabel("Tonnes");
                chart.xAxis.axisLabel("Interval");
                // chart.yAxis.tickFormat(d3.format("1f"));


                d3.select('#tonnesByIntervalBarChart svg')
                    .datum($.parseJSON(data.despatchTonnesByIntervalJson))
                    .transition().duration(500).call(chart);

                nv.utils.windowResize(chart.update); // Intitiate listener for window resize so the chart responds and changes width.
                return chart;
            });
            //
            RenderStaticMultiBarChart(data.despatchTonnesBySingleCustomerIntervalJson, "Tonnes", "Interval", "tonnesByCustomerIntervalBarChart")
        }

        function BuildSummaryTonnesTable(data) {
            var tbl = "<table class='table table-reduced-padding'>";
            tbl += "<thead>" +
                "<tr><th></th><th colspan='2' style='text-align: center'>Prime</th><th colspan='2'  style='text-align: center'>Non Prime</th><th></th></tr>" +
                "<tr><th>Interval</th><th>Tubes</th><th>Energy</th><th>Tubes</th><th>Energy</th><th>Total</th></tr>" +
                "</thead>";
            tbl += "<tbody>";

            tbl += "<tr>" +
                "<td>Today</td>" +
                "<td>" + (data.todaysTonnage.prime.Tubes != undefined ? data.todaysTonnage.prime.Tubes : 0) + "</td>" +
                "<td>" + (data.todaysTonnage.prime.Energy != undefined ? data.todaysTonnage.prime.Energy : 0) + "</td>" +
                "<td>" + (data.todaysTonnage.nonprime.Tubes != undefined ? data.todaysTonnage.nonprime.Tubes : 0) + "</td>" +
                "<td>" + (data.todaysTonnage.nonprime.Energy != undefined ? data.todaysTonnage.nonprime.Energy : 0) + "</td>" +
                "<td>" + ((data.todaysTonnage.prime.Tubes != undefined ? data.todaysTonnage.prime.Tubes : 0)
                    + (data.todaysTonnage.prime.Energy != undefined ? data.todaysTonnage.prime.Energy : 0)
                    + (data.todaysTonnage.nonprime.Tubes != undefined ? data.todaysTonnage.nonprime.Tubes : 0)
                    + (data.todaysTonnage.nonprime.Energy != undefined ? data.todaysTonnage.nonprime.Energy : 0)).toFixed(3) + "</td>" +
                "</tr>";

            tbl += "<tr>" +
                "<td>Yesterday</td>" +
                "<td>" + (data.yesterdaysTonnage.prime.Tubes != undefined ? data.yesterdaysTonnage.prime.Tubes : 0) + "</td>" +
                "<td>" + (data.yesterdaysTonnage.prime.Energy != undefined ? data.yesterdaysTonnage.prime.Energy : 0) + "</td>" +
                "<td>" + (data.yesterdaysTonnage.nonprime.Tubes != undefined ? data.yesterdaysTonnage.nonprime.Tubes : 0) + "</td>" +
                "<td>" + (data.yesterdaysTonnage.nonprime.Energy != undefined ? data.yesterdaysTonnage.nonprime.Energy : 0) + "</td>" +
                "<td>" + ((data.yesterdaysTonnage.prime.Tubes != undefined ? data.yesterdaysTonnage.prime.Tubes : 0) + (data.yesterdaysTonnage.prime.Energy != undefined ? data.yesterdaysTonnage.prime.Energy : 0) +
                    (data.yesterdaysTonnage.nonprime.Tubes != undefined ? data.yesterdaysTonnage.nonprime.Tubes : 0) + (data.yesterdaysTonnage.nonprime.Energy != undefined ? data.yesterdaysTonnage.nonprime.Energy : 0)).toFixed(3) + "</td>" +
                "</tr>";

            tbl += "<tr>" +
                "<td>CurrentWeek</td>" +
                "<td>" + (data.thisWeekTonnage.prime.Tubes != undefined ? data.thisWeekTonnage.prime.Tubes : 0) + "</td>" +
                "<td>" + (data.thisWeekTonnage.prime.Energy != undefined ? data.thisWeekTonnage.prime.Energy : 0) + "</td>" +
                "<td>" + (data.thisWeekTonnage.nonprime.Tubes != undefined ? data.thisWeekTonnage.nonprime.Tubes : 0) + "</td>" +
                "<td>" + (data.thisWeekTonnage.nonprime.Energy != undefined ? data.thisWeekTonnage.nonprime.Energy : 0) + "</td>" +
                "<td>" + ((data.thisWeekTonnage.prime.Tubes != undefined ? data.thisWeekTonnage.prime.Tubes : 0) + (data.thisWeekTonnage.prime.Energy != undefined ? data.thisWeekTonnage.prime.Energy : 0) +
                    (data.thisWeekTonnage.nonprime.Tubes != undefined ? data.thisWeekTonnage.nonprime.Tubes : 0) + (data.thisWeekTonnage.nonprime.Energy != undefined ? data.thisWeekTonnage.nonprime.Energy : 0)).toFixed(3) + "</td>" +
                "</tr>";

            tbl += "<tr>" +
                "<td>LastWeek</td>" +
                "<td>" + (data.lastWeekTonnage.prime.Tubes != undefined ? data.lastWeekTonnage.prime.Tubes : 0) + "</td>" +
                "<td>" + (data.lastWeekTonnage.prime.Energy != undefined ? data.lastWeekTonnage.prime.Energy : 0) + "</td>" +
                "<td>" + (data.lastWeekTonnage.nonprime.Tubes != undefined ? data.lastWeekTonnage.nonprime.Tubes : 0) + "</td>" +
                "<td>" + (data.lastWeekTonnage.nonprime.Energy != undefined ? data.lastWeekTonnage.nonprime.Energy : 0) + "</td>" +
                "<td>" + ((data.lastWeekTonnage.prime.Tubes != undefined ? data.lastWeekTonnage.prime.Tubes : 0) + (data.lastWeekTonnage.prime.Energy != undefined ? data.lastWeekTonnage.prime.Energy : 0) +
                    (data.lastWeekTonnage.nonprime.Tubes != undefined ? data.lastWeekTonnage.nonprime.Tubes : 0) + (data.lastWeekTonnage.nonprime.Energy != undefined ? data.lastWeekTonnage.nonprime.Energy : 0)).toFixed(3) + "</td>" +
                "</tr>";

            tbl += "<tr>" +
                "<td>CurrentMonth</td>" +
                "<td>" + (data.currentMonthTonnage.prime.Tubes != undefined ? data.currentMonthTonnage.prime.Tubes : 0) + "</td>" +
                "<td>" + (data.currentMonthTonnage.prime.Energy != undefined ? data.currentMonthTonnage.prime.Energy : 0) + "</td>" +
                "<td>" + (data.currentMonthTonnage.nonprime.Tubes != undefined ? data.currentMonthTonnage.nonprime.Tubes : 0) + "</td>" +
                "<td>" + (data.currentMonthTonnage.nonprime.Energy != undefined ? data.currentMonthTonnage.nonprime.Energy : 0) + "</td>" +
                "<td>" + ((data.currentMonthTonnage.prime.Tubes != undefined ? data.currentMonthTonnage.prime.Tubes : 0) + (data.currentMonthTonnage.prime.Energy != undefined ? data.currentMonthTonnage.prime.Energy : 0) +
                    (data.currentMonthTonnage.nonprime.Tubes != undefined ? data.currentMonthTonnage.nonprime.Tubes : 0) + (data.currentMonthTonnage.nonprime.Energy != undefined ? data.currentMonthTonnage.nonprime.Energy : 0)).toFixed(3) + "</td>" +
                "</tr>";

            tbl += "<tr>" +
                "<td>LastMonth</td>" +
                "<td>" + (data.lastMonthTonnage.prime.Tubes != undefined ? data.lastMonthTonnage.prime.Tubes : 0) + "</td>" +
                "<td>" + (data.lastMonthTonnage.prime.Energy != undefined ? data.lastMonthTonnage.prime.Energy : 0) + "</td>" +
                "<td>" + (data.lastMonthTonnage.nonprime.Tubes != undefined ? data.lastMonthTonnage.nonprime.Tubes : 0) + "</td>" +
                "<td>" + (data.lastMonthTonnage.nonprime.Energy != undefined ? data.lastMonthTonnage.nonprime.Energy : 0) + "</td>" +
                "<td>" + ((data.lastMonthTonnage.prime.Tubes != undefined ? data.lastMonthTonnage.prime.Tubes : 0) + (data.lastMonthTonnage.prime.Energy != undefined ? data.lastMonthTonnage.prime.Energy : 0) +
                    (data.lastMonthTonnage.nonprime.Tubes != undefined ? data.lastMonthTonnage.nonprime.Tubes : 0) + (data.lastMonthTonnage.nonprime.Energy != undefined ? data.lastMonthTonnage.nonprime.Energy : 0)).toFixed(3) + "</td>" +
                "</tr>";

            tbl += "</tbody>";
            tbl += "</table>";

            $('#summaryTonnesTable').html(tbl);
        }

        function buildCustomerSelectList(data) {
            // Fill select list for filtering on TonnesByCustomerInterval chart.
            var $dropdown = $("#customersSelectList");
            $.each(data, function () {
                if (this == "NATIONAL T") {
                    $dropdown.append($("<option />").val(this).text(this).attr('selected', true));
                } else {
                    $dropdown.append($("<option />").val(this).text(this));
                }

            });

        }

        // Listen for filter change on customer list to update chart with new data
        $("#customersSelectList").on('change', function () {
            var customerName = this.value;

            $.ajax({
                type: 'POST',
                data: {'dtFrom': dtFrom, 'dtTo': dtTo, "customerName": customerName},
                url: rootUrl + '/api/getSingleCustomerIntervalStackedBarJson',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {
                    console.log(data);
                    RenderStaticMultiBarChart(data.despDataByCustomer, "Tonnes", "Interval", "tonnesByCustomerIntervalBarChart")
                },
                complete: function () {
                    $('.ajax-loader').css('display', 'none');
                }
            });
        });


        $('.exportHomeFilterBtn').on('click', function() {
            var exportHomeInd = $(this).data('exporthomeind');
            $.ajax({
                type: 'POST',
                data: {'dtFrom': dtFrom, 'dtTo': dtTo, "exportHomeInd": exportHomeInd},
                url: rootUrl + '/api/getcustomerTonnesByHomeExportBarChartJson',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {
                    console.log(data);
                    RenderStaticDiscreteBarChart($.parseJSON(data.customerDespTonnesByHomeExportJson), 'label', 'value', 'tonnesByCustomerBarChart', '', "Customer", 'Tonnes', '.0f', '.0f', [], true, false, null, null, null, null, null, 90, {
                        top: 30,
                        right: 20,
                        bottom: 80,
                        left: 40
                    });
                },
                complete: function () {
                    $('.ajax-loader').css('display', 'none');
                }
            });
        });

        $('.prime.EnergyTubesFilterBtn').on('click', function() {
            var energyTubesInd = $(this).data('energytubesind');
            $.ajax({
                type: 'POST',
                data: {'dtFrom': dtFrom, 'dtTo': dtTo, "energyTubesInd": energyTubesInd},
                url: rootUrl + '/api/getcustomerTonnesByBusinessBarChartJson',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {
                    console.log(data);
                    RenderStaticDiscreteBarChart($.parseJSON(data.customerDespTonnesByBusinessExportJson), 'label', 'value', 'tonnesByCustomerBarChart', '', "Customer", 'Tonnes', '.0f', '.0f', [], true, false, null, null, null, null, null, 90, {
                        top: 30,
                        right: 20,
                        bottom: 80,
                        left: 40
                    });
                },
                complete: function () {
                    $('.ajax-loader').css('display', 'none');
                }
            });
        });


        $( document ).ready(function() {
            // When page loads, request current weeks data and populate dashboard.
            $.ajax({
                type: 'POST',
                data: {
                    'dtFrom': moment().day('Sunday').format('YYYY-MM-DD 00:00:00'),
                    'dtTo': moment().day('Saturday').format('YYYY-MM-DD 23:59:59')
                },
                url: rootUrl + '/api/getDespDashboardData',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {
                    console.log(data);
                    BuildCharts(data);
                    BuildSummaryTonnesTable(data.summaryTonnesArray);
                    buildCustomerSelectList(data.customerList);
                },
                complete: function () {
                    $('.ajax-loader').css('display', 'none');
                }
            });
        });

    </script>


@endsection

