@extends('layouts.app')

@section('pageTitle', 'Desp Dashboard 2')
@section('pageName', 'Desp Dashboard 2')

@section('content')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
@endsection


<div style="text-align: center;
    margin-top: -50px;">
    <h2>Desp Dashboard 2</h2>
</div>

@section('dateRangePickerOnApplyCallback')
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
    BuildCustomerTonnesTable(data.tonnesByCustomerArray);
    },
    complete: function () {
    $('.ajax-loader').css('display', 'none');
    }
    });
@endsection
<div class="filters" style="justify-content: normal;">
    @include('layouts.templates.daterangepicker')


</div>
<div class="mb-3"></div>

<div class="dashboardContainer" style="display: flex;">
    <div class="dashboard-flex-card" style="flex:1; margin:1em; overflow-y: scroll; height: 100vh">
        <div class="summaryTonnesTable">

        </div>

        <div class="card-body" >
            <h5>All Customer Despatches</h5>
            <div id="allCustomerDespatchesTable">

            </div>
        </div>
    </div>


    <div class="dashboard-flex-card" style="flex:3; margin:1em;">
        <div class="card-body" style="margin-bottom: 30px">
            <h5>Top 20 Tonnes Desp By Customer</h5>
            <div id="tonnesByCustomerBarChart" style="height: 300px;">
                <svg></svg>
            </div>
        </div>
        <div class="card-body" style="margin-bottom: 30px">
            <h5>Tonnes By Interval</h5>
            <div id="tonnesByIntervalBarChart" style="height: 300px;">
                <svg></svg>
            </div>
        </div>
    </div>
</div>


@endsection

@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js?v=1.21')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js?v=1.11')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js?v=1.11')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var data = <?php echo $data; ?>;
        console.log(data);

        // function BuildCharts(data) {
        //     RenderStaticDiscreteBarChart($.parseJSON(data.tonnesByCustomerJson), 'label', 'value', 'tonnesByCustomerBarChart', '', "Customer", 'Tonnes', '.0f', '.0f', [], true, false, null, null, null, null, null, 90, {
        //         top: 30,
        //         right: 20,
        //         bottom: 85,
        //         left: 40
        //     });
        //
        //     nv.addGraph(function () {
        //         var chart = nv.models.multiBarChart()
        //             .margin({top: 0, right: 0, bottom: 75, left: 75})
        //             .stacked(true).showControls(true).staggerLabels(false);
        //
        //         chart.yAxis.axisLabel("Tonnes");
        //         chart.xAxis.axisLabel("Interval");
        //         chart.yAxis.tickFormat(d3.format("1f"));
        //
        //
        //         d3.select('#tonnesByIntervalBarChart svg')
        //             .datum($.parseJSON(data.despatchTonnesByIntervalJson))
        //             .transition().duration(500).call(chart);
        //
        //         nv.utils.windowResize(chart.update); // Intitiate listener for window resize so the chart responds and changes width.
        //         return chart;
        //     });
        //
        //
        // }
        //
        // function BuildCustomerTonnesTable(data) {
        //     var tbl = "<table class='table'>";
        //     tbl += "<thead><th>Customer</th><th>Tonnes</th></thead>";
        //     tbl += "<tbody>";
        //     for (const [key, v] of Object.entries(data)) {
        //         tbl += "<tr>" + "<td>" + key + "</td>" + "<td>" + v.value.toFixed(2) + "</td>" + "</tr>";
        //     }
        //     tbl += "</tbody>";
        //     tbl += "</table>";
        //
        //     $('#allCustomerDespatchesTable').html(tbl);
        // }
        //
        // function BuildSummaryTonnesTable(data) {
        //     var tbl = "<table class='table'>";
        //     tbl += "<thead><th>Interval</th><th>Tubes</th><th>Energy</th><th>Tonnes</th></thead>";
        //     tbl += "<tbody>";
        //     // for (const [key, v] of Object.entries(data)) {
        //     //     tbl += "<tr>" + "<td>" + key + "</td>" + "<td>" + v.value.toFixed(2) + "</td>" + "</tr>";
        //     // }
        //     tbl += "</tbody>";
        //     tbl += "</table>";
        //
        //     $('#').html(tbl);
        // }
    </script>

@endsection
