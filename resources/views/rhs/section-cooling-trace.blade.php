@extends('layouts.app')

@section('pageTitle', 'Section Cooling Trace')
@section('pageName', 'Section Cooling Trace')
@section('rhsActiveLink', 'active activeUnderline')
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

<!-- Content Row -->
<div class="simpleflex">
    <div class="fl1-500">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Section Cooling Trace {{$sectionNo}}</h6>

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


        var sectionCoolingData = <?php echo $sectionCoolingPyroTraces; ?>;
        var data = sectionCoolingData.values;
        var arrLabels1 = [];
        var arrLabels2 = [];
        console.log(sectionCoolingData);
        data = sectionCoolingData.values;
        arrLabels1 = sectionCoolingData.labelArrays.xAxisLabels1;
        arrLabels2 = sectionCoolingData.labelArrays.xAxisLabels2;


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

            return chart;
        });


    </script>


@endsection
