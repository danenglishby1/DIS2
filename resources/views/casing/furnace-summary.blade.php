@extends('layouts.app')

@section('pageTitle', 'Furnace Summary')
@section('pageName', 'Furnace Summary')
@section('casingActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}" />
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
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
    <div class="flex-right">
        <div id="daterange" class="daterangeControl pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
            <i class="fa fa-calendar dateRangeIcon"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
    </div>





    <div class="row">


        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Min Max Temps</h6>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="rhsFurnaceMinMaxTempsLineChart" style="height:500px;" class='with-3d-shadow with-transitions'>
                        <svg></svg>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Mean Temp</h6>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="rhsFurnaceMeanLineChart" style="height:500px;" class='with-3d-shadow with-transitions'>
                        <svg></svg>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12">

            <table id="furnace-summary-tbl" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>CON_NO</th>
                    <th>READINGS</th>
                    <th>MIN</th>
                    <th>MAX</th>
                    <th>MEAN</th>
                    <th>ENTERED</th>
                    <th>EXITED</th>
                    <th>Mean Seg 1</th>
                    <th>Mean Seg 2</th>
                    <th>Mean Seg 3</th>
                    <th>Mean Seg 4</th>
                    <th>Mean Seg 5</th>
                    <th>View Chart</th>
                </tr>
                </thead>
                <tbody>
                @foreach($furnaceSummaryArray as $key => $value)

                    <tr>
                        <td>{{$key}}</td>
                        <td>{{$value["NO_OF_READINGS"]}}</td>
                        <td>{{$value["MIN_TEMP"]}}</td>
                        <td>{{$value["MAX_TEMP"]}}</td>
                        <td>{{$value["MEAN_TEMP"]}}</td>
                        <td>{{$value["ENTERED"]}}</td>
                        <td>{{$value["EXITED"]}}</td>

                        <!--

                        Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours.
                        -->

                        <td {{ (isset($value["meanSegment1"]) ?  ($value["meanSegment1"] < 825 || $value["meanSegment1"] > 1000 ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>{{ (isset($value["meanSegment1"]) ?  $value["meanSegment1"] : 0) }}</td>
                        <td {{ (isset($value["meanSegment2"]) ?  ($value["meanSegment2"] < 825 || $value["meanSegment2"] > 1000 ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>{{ (isset($value["meanSegment2"]) ?  $value["meanSegment2"] : 0) }}</td>
                        <td {{ (isset($value["meanSegment3"]) ?  ($value["meanSegment3"] < 825 || $value["meanSegment3"] > 1000 ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>{{ (isset($value["meanSegment3"]) ?  $value["meanSegment3"] : 0) }}</td>
                        <td {{ (isset($value["meanSegment4"]) ?  ($value["meanSegment4"] < 825 || $value["meanSegment4"] > 1000 ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>{{ (isset($value["meanSegment4"]) ?  $value["meanSegment4"] : 0) }}</td>
                        <td {{ (isset($value["meanSegment5"]) ?  ($value["meanSegment5"] < 825 || $value["meanSegment5"] > 1000 ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>{{ (isset($value["meanSegment5"]) ?  $value["meanSegment5"] : 0) }}</td>
                        <td> <a href="<?php echo $rootUrl; ?>/rhs/section-furnace-trace?sectionNo=<?php echo $key ."&weekNo=".$value["WEEK_NO"]   ?>">View ></a></td>
                    </tr>
                @endforeach
                </tfoot>
            </table>
        </div>

        <div class="download-button">
            <a class="btn btn-primary" href="<?php echo $rootUrl; ?>/export/ExportFurnaceSummaryDataInRange">Download Data</a>
        </div>

    </div>


@endsection
@section('functionalScripts')
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
        const labelObject = [];
        // Strip values and build arrays
        function FormatDataAndBuildCharts(json) {
            const minArray = [];
            const maxArray = [];
            const meanArray = [];
            const avgArray = [];
            const lowerLimitArray = [];
            const upperLimitArray = [];
            let i = 0;
            // strip labels from json to array
            Object.keys(json).forEach(function(k){
                labelObject[i] = k;
                minArray.push({x : i, y: json[k].MIN_TEMP});
                maxArray.push({x : i, y: json[k].MAX_TEMP});
                meanArray.push({x : i, y: json[k].MEAN_TEMP})
                avgArray.push({x : i, y: json[k].AVG_TEMP})
                lowerLimitArray.push({x : i, y: 825});
                upperLimitArray.push({x : i, y: 1000});
                i++;
            });

            var minMaxLineChart = RenderLineWithFocusChart('rhsFurnaceMinMaxTempsLineChart',
                'lineWithFocus',
                labelObject, [
                    {values: minArray, key: 'MIN', color: '#FFCD56'},
                    {values: maxArray, key: 'MAX', color: '#FF9F40'},
                    {values: lowerLimitArray, key: 'LOWER_LIMIT', color: '#FF6384'},
                    {values: upperLimitArray, key: 'UPPER_LIMIT', color: '#FF6384'}
                ],
                'Degrees',
                true,
                'Date',
                true,
                true);

            var meanLineChart = RenderLineWithFocusChart('rhsFurnaceMeanLineChart',
                'lineWithFocus',
                labelObject, [
                    {values: meanArray, key: 'MEAN', color: '#FF9F40'},
                    {values: lowerLimitArray, key: 'LOWER_LIMIT', color: '#FF6384'},
                    {values: upperLimitArray, key: 'UPPER_LIMIT', color: '#FF6384'}
                ],
                'Degrees',
                true,
                'Date',
                true,
                true);
        }
        //  FormatDataAndBuildCharts(json);
    </script>

    <script>
        function GetDataAndBuildCharts(dtFrom, dtTo) {
            console.log(rootUrl);
            let data = PostDateFromToGetData(rootUrl+'/api/GetFurnaceSummaryJSONWithDateTime', dtFrom, dtTo);
            console.log(data);
            FormatDataAndBuildCharts(data);
        }

        $(function() {
            var start = moment().subtract(5, 'days');
            var end = moment();

            function cb(start, end) {
                $('#daterange span').html(start.format('DD-MM-Y 00:00:00') + ' - ' + end.format('DD-MM-Y 23:59:59'));
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
            if (picker.chosenLabel == "Yesterday") {
                var dtFrom = picker.startDate.format('YYYY-MM-DD 00:00:00');
                var dtTo = picker.endDate.format('YYYY-MM-DD 23:59:59');
            }
            else if (picker.chosenLabel == "Today") {
                var dtFrom = picker.startDate.format('YYYY-MM-DD 00:00:00');
                var dtTo = picker.endDate.format('YYYY-MM-DD 23:59:59');
            }
            else {
                var dtFrom = picker.startDate.format('YYYY-MM-DD H:mm:ss');
                var dtTo = picker.endDate.format('YYYY-MM-DD H:mm:ss');
            }
            console.log(picker.startDate.format('YYYY-MM-DD H:mm:ss'));
            console.log(picker.endDate.format('YYYY-MM-DD H:mm:ss'));
            GetDataAndBuildCharts(dtFrom, dtTo);
        });

        // Get last 5 days of data and build charts.
        var start = moment().subtract(5, 'days');
        var end = moment();
        GetDataAndBuildCharts(start.format('YYYY-MM-DD 00:00:00'), end.format('YYYY-MM-DD 23:59:59'));

    </script>


    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#furnace-summary-tbl').DataTable({
                "order": [[ 6, "desc" ]]
            });
        });
    </script>
@endsection
