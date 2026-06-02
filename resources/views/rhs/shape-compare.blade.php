@extends('layouts.app')

@section('pageTitle', 'Shape Comparison')
@section('pageName', 'Shape Compare')
@section('rhsActiveLink', 'active activeUnderline')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}" />
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
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Filters
    </button>
    <div class="flex-right">
        <div id="daterange" class="daterangeControl pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
            <i class="fa fa-calendar dateRangeIcon"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Manual DIA1 Measurement vs Zumbach Laser Measurement (MM)</h6>  <span class="filter-on-info"><span id="size1FilterValueOn"></span> <span id="size2FilterValueOn"></span> <span id="thickFilterValueOn"></span></span>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div id="dia1VsZumbachLineChart" style="height:500px;" class='with-3d-shadow with-transitions'>
                        <svg></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Manual DIA2 Measurement vs Zumbach Laser Measurement (MM)</h6>  <span class="filter-on-info"><span id="size1FilterValueOn"></span> <span id="size2FilterValueOn"></span> <span id="thickFilterValueOn"></span></span>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div id="dia2VsZumbachLineChart" style="height:500px;" class='with-3d-shadow with-transitions'>
                        <svg></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Size 1</label>
                    <select id="size1">
                        <option value="none"></option>
                    </select>

                    <label>Size 2</label>
                    <select id="size2">
                        <option value="none"></option>
                    </select>

                    <label>Thick</label>
                    <select id="thick">
                        <option value="none"></option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--                    <button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>

@endsection
@section('functionalScripts')

    <script src="{{ asset('public/libraries/lodash/lodash.js')}}"></script>
    <script src="{{ asset('public/js/classes/ProductionDataFilter.js')}}"></script>
    <script src="{{ asset('public/js/filter-change-listeners.js')}}"></script>
    <script src="{{ asset('public/libraries/date-range-picker/moment.min.js')}}"></script>
    <script src="{{ asset('public/libraries/date-range-picker/daterangepicker.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let dia1ManualVsLaserChart;
        let dia2ManualVsLaserChart;
        let data;
        let originalData;

        function FillChartArraysAndRenderCharts(json) {

            console.log(json);

            const labelArray = [];
            const labelObjectXAxis1 = {};
            const labelObjectXAxis2 = {};
            // Strip values from JSON and build arrays, prepped to pass into js chart.
            const dia1Meas1Array = [];
            const dia1Meas2Array = [];
            const dia1UCLArray = [];
            const dia1LCLArray = []
            const dia2UCLArray = [];
            const dia2LCLArray = []
            const dia2Meas1Array = [];
            const dia2Meas2Array = [];
            const frontHorizontalTopArray = [];
            const frontHorizontalBottomArray = [];
            const frontVerticalNorthArray = [];
            const frontVerticalSouthArray = [];
            const lowerLimitArray = [];
            const upperLimitArray = [];
            const size1Array = [];
            const size2Array = [];
            const thickArray = [];
            // strip labels from json to array
            for (var i = 0; i < json.length; i++) {
                labelObjectXAxis1[i] = json[i].DATETIME_TANDEM; // xAxis label object.
                labelObjectXAxis2[i] = json[i].TRACK_CODE; // xAxis label object.

                size1Array.push(json[i].SIZE1); // filters.
                size2Array.push(json[i].SIZE2); // filters.
                thickArray.push(json[i].THICK); // filters.

                // Check if variable = DIA1, DIA2 and push data to relevant arrays for chart.
                if (json[i].VARIABLE == "DIA1") {
                    dia1Meas1Array.push({x : i, y: json[i].VARIABLE_MEASUREMENT_1, fSize1: json[i].SIZE1, fSize2: json[i].SIZE2, fThick: json[i].THICK });
                    dia1Meas2Array.push({x : i, y: json[i].VARIABLE_MEASUREMENT_2, fSize1: json[i].SIZE1, fSize2: json[i].SIZE2, fThick: json[i].THICK});
                    frontHorizontalTopArray.push({x : i, y: json[i].OD_HORIZONTAL_T_V, fSize1: json[i].SIZE1, fSize2: json[i].SIZE2, fThick: json[i].THICK});
                    frontHorizontalBottomArray.push({x : i, y: json[i].OD_HORIZONTAL_B_V, fSize1: json[i].SIZE1, fSize2: json[i].SIZE2, fThick: json[i].THICK});
                    dia1LCLArray.push({x : i, y: json[i].LOWER_CONTROL_LIMIT, fSize1: json[i].SIZE1, fSize2: json[i].SIZE2, fThick: json[i].THICK});
                    dia1UCLArray.push({x : i, y: json[i].UPPER_CONTROL_LIMIT, fSize1: json[i].SIZE1, fSize2: json[i].SIZE2, fThick: json[i].THICK});
                }
                if (json[i].VARIABLE == "DIA2") {
                    dia2Meas1Array.push({x : i, y: json[i].VARIABLE_MEASUREMENT_1, fSize1: json[i].SIZE1, fSize2: json[i].SIZE2, fThick: json[i].THICK});
                    dia2Meas2Array.push({x : i, y: json[i].VARIABLE_MEASUREMENT_2, fSize1: json[i].SIZE1, fSize2: json[i].SIZE2, fThick: json[i].THICK});
                    frontVerticalNorthArray.push({x : i, y: json[i].OD_VERTICAL_N_V, fSize1: json[i].SIZE1, fSize2: json[i].SIZE2, fThick: json[i].THICK});
                    frontVerticalSouthArray.push({x : i, y: json[i].OD_VERTICAL_S_V, fSize1: json[i].SIZE1, fSize2: json[i].SIZE2, fThick: json[i].THICK});
                    dia2LCLArray.push({x : i, y: json[i].LOWER_CONTROL_LIMIT, fSize1: json[i].SIZE1, fSize2: json[i].SIZE2, fThick: json[i].THICK});
                    dia2UCLArray.push({x : i, y: json[i].UPPER_CONTROL_LIMIT, fSize1: json[i].SIZE1, fSize2: json[i].SIZE2, fThick: json[i].THICK});
                }
            }

            // d3.select("#dia1VsZumbachLineChart svg").remove();
            // d3.select("#dia2VsZumbachLineChart svg").remove();

            // Render new chart passing in data populated above.
            RenderLineWithFocusChartDualAxisLabels('dia1VsZumbachLineChart',
                'lineWithFocus',
                labelObjectXAxis2,labelObjectXAxis1, [
                    {values: dia1Meas1Array, key: 'DIA1_1'},
                    {values: dia1Meas2Array, key: 'DIA1_2'},
                    {values: frontHorizontalTopArray, key: 'FRONT_HORZ_TOP'},
                    {values: frontHorizontalBottomArray, key: 'FRONT_HORZ_BOT'},
                    {values: dia1LCLArray, key: 'LCL', 'color' : '#ef5350'},
                    {values: dia1UCLArray, key: 'UCL',  'color' : '#ef5350'},
                ],
                'Pipe/Date',
                true,
                "MM",
                true,
                true,
                []);

            RenderLineWithFocusChartDualAxisLabels('dia2VsZumbachLineChart',
                'lineWithFocus',
                labelObjectXAxis2,labelObjectXAxis1, [
                    {values: dia2Meas1Array, key: 'DIA2_1'},
                    {values: dia2Meas2Array, key: 'DIA2_2'},
                    {values: frontVerticalNorthArray, key: 'FRONT_VERT_NORTH'},
                    {values: frontVerticalSouthArray, key: 'FRONT_VERT_SOUTH'},
                    {values: dia2LCLArray, key: 'LCL', 'color' : '#ef5350'},
                    {values: dia2UCLArray, key: 'UCL',  'color' : '#ef5350'},
                ],
                'Pipe/Date',
                true,
                "MM",
                true,
                true,
                []);
        }
        // Post to api passing in datetime from and to.
        function GetDataAndBuildCharts(dtFrom, dtTo) {
            data = PostDateFromToGetData(rootUrl+'/api/GetShapeDataAsJSONWithDateTime', dtFrom, dtTo);

            originalData = data; // Save a copy of original data incase all filters are turned off
            var productionDataFilter = new ProductionDataFilter(data, '', '' , ''); // Set up filters with copy of data.
            console.log(data);
            FillChartArraysAndRenderCharts(data); // Sort data and build /render charts.
        }

    </script>

    <script>

        /**
         * Configure date range picker.
         * */
        $(function() {

            var start = moment().subtract(7, 'days');
            var end = moment();

            function cb(start, end) {
                $('#daterange span').html(start.format('DD-MM-Y 00:00:01') + ' - ' + end.format('DD-MM-Y 23:59:59'));
            }

            $('#daterange').daterangepicker({
                startDate: start,
                endDate: end,
                timePicker: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    format: 'M/DD hh:mm A'
                }
            }, cb);

            cb(start, end);
        });

        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            var dtFrom = picker.startDate.format('YYYY-MM-DD 00:00:00');
            var dtTo = picker.endDate.format('YYYY-MM-DD 23:59:59');
            console.log(dtFrom);
            console.log(dtTo);
            GetDataAndBuildCharts(dtFrom, dtTo);
        });

        // Get last 30 days of data and build charts.
        var start = moment().subtract(29, 'days');
        var end = moment();


        /**
         *  Using last 30 days variables above, pass in datetimes to the GetDataAndBuildCharts function to set the ajax call and build the charts on load.
         */

        GetDataAndBuildCharts(start.format('YYYY-MM-DD 00:00:01'), end.format('YYYY-MM-DD 23:59:59'));

    </script>

@endsection
