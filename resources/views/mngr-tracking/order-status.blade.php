@extends('layouts.app')

@section('pageTitle', 'Order Status')
@section('pageName', 'Order Status')
@section('millTrackingActiveLink', 'active activeUnderline')
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
    Status Of <?php echo $orderCount; ?> Orders
    </div>

    <div id="orderStatusMultiChart" >
        <svg> </svg>
    </div>

    <div id="orderStatusByProcessRouteStackedBarChart">
        <svg></svg>
    </div>

@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/lodash/lodash.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/stream_layers.js')}}"></script>

   <script>
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
       var orderStatusJson = <?php echo $orderStatus; ?>;
       var orderStatusSummaryJson = <?php echo $orderStatusSummary; ?>;
       var orderStatusSummaryByDELBRangeJson = <?php echo $orderStatusSummaryByDELBRangeArray; ?>;
       var orderStatusSummaryByPRJson = <?php echo $orderStatusSummaryByPRArray; ?>;

       console.info(orderStatusJson);
       console.info(orderStatusSummaryJson);
       console.info(orderStatusSummaryByDELBRangeJson);
       console.info(orderStatusSummaryByPRJson);

       var sumOfBalanceToMakeArray = [];
       var sumOfTonnesInDespArray = [];
       var sumOfTonnesInOrderTrackingArray = [];
       var sumOfSumOfTonnesMadeArray = [];
       var sumOfTonnesOrderedArray = [];
       var sumOfTonnesDesxArray = [];
       var labelObject = {};

       var i = 0;
       var keys = Object.keys(orderStatusSummaryByDELBRangeJson)
       for (var key of keys) {
           labelObject[i] = key;
           sumOfBalanceToMakeArray.push({x: i, y: orderStatusSummaryByDELBRangeJson[key].aggregates.SUM_OF_BALANCE_TO_MAKE});
           sumOfTonnesInDespArray.push({x: i, y: orderStatusSummaryByDELBRangeJson[key].aggregates.SUM_OF_TONNES_IN_DESP});
           sumOfTonnesInOrderTrackingArray.push({x: i, y: orderStatusSummaryByDELBRangeJson[key].aggregates.SUM_OF_TONNES_IN_ORDER_TRACKING});
           sumOfSumOfTonnesMadeArray.push({x: i, y: orderStatusSummaryByDELBRangeJson[key].aggregates.SUM_OF_TONNES_MADE});
           sumOfTonnesOrderedArray.push({x: i, y: orderStatusSummaryByDELBRangeJson[key].aggregates.SUM_OF_TONNES_ORDERED});
           sumOfTonnesDesxArray.push({x: i, y: orderStatusSummaryByDELBRangeJson[key].aggregates.SUM_OF_TONNES_DESX});
           i++;
       }

       // loop through keys again and make final json
       var data = [
           {values: sumOfBalanceToMakeArray, key: 'SUM_BAL_TO_MAKE', color: '#8db4e3'},
           {values: sumOfTonnesInDespArray, key: 'SUM_TONNES_IN_DESP', color: '#9bbb58'}, // , color: '#f67019'
           {values: sumOfTonnesInOrderTrackingArray, key: 'SUM_TONNES_ORD_TRACKING', color: '#f89748'},
           {values: sumOfSumOfTonnesMadeArray, key: 'SUM_TONNES_MADE', color: '#b95352'},
           {values: sumOfTonnesOrderedArray, key: 'SUM_TONNES_ORDERED', color: '#5781b3'},
           {values: sumOfTonnesDesxArray, key: 'SUM_TONNES_DESX', color: '#4aacc5'},
       ];


       var testdata = stream_layers(9,10+Math.random()*100,.1).map(function(data, i) {
           return {
               key: 'Stream' + i,
               values: data.map(function(a){a.y = a.y * (i <= 1 ? -1 : 1); return a})
           };
       });

       console.info(testdata);

       data[0].type = "bar";
       data[0].yAxis = 1;
       data[1].type = "bar";
       data[1].yAxis = 1;
       data[2].type = "bar";
       data[2].yAxis = 1;
       data[3].type = "line";
       data[3].yAxis = 1;
       data[4].type = "line";
       data[4].yAxis = 1;
       data[5].type = "bar";
       data[5].yAxis = 1;

       nv.addGraph(function() {
           var chart = nv.models.multiChart()
               .margin({top: 30, right: 60, bottom: 50, left: 70})
               .color(d3.scale.category10().range());
           chart.xAxis
               .tickFormat(function(d) {
                   return labelObject[d];
               });
           chart.yAxis1.tickFormat(d3.format(',.1f'));

            chart.bars1.stacked(true);
           // chart.bars3.stacked(true);

           d3.select('#orderStatusMultiChart svg')
               .datum(data)
               .transition().duration(500).call(chart);
           return chart;
       });


       nv.addGraph(function() {
           var chart = nv.models.multiBarChart();

           chart.xAxis
               .tickFormat(d3.format(',f'));

           chart.yAxis
               .tickFormat(d3.format(',.1f'));

           d3.select('#chart svg')
               .datum(stackData)
               .transition().duration(500)
               .call(chart)
           ;
           nv.utils.windowResize(chart.update);
           return chart;
       });



   </script>

@endsection
