@extends('layouts.app')

@section('pageTitle', 'Live Furnace Traces')
@section('pageName', 'Live Furnace Traces')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
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
    <!-- Content Row -->



    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-6 col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Furnace Filter</h6>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="rhsFurnaceFilterLineChart" style="height:500px;" class='with-3d-shadow with-transitions'>
                        <svg></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Furnace Unfilter</h6>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="rhsFurnaceUnfilterLineChart" style="height:500px;" class='with-3d-shadow with-transitions'>
                        <svg></svg>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-6 col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">North Pyro 1</h6>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="rhsFurnaceNorthPyroLineChart" style="height:500px;" class='with-3d-shadow with-transitions'>
                        <svg></svg>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-xl-6 col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">North Pyro 2</h6>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="rhsFurnaceSouthPyroLineChart" style="height:500px;" class='with-3d-shadow with-transitions'>
                        <svg></svg>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Thermal Camera</h6>

                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="thermalCameraLineChart" style="height:500px;" class='with-3d-shadow with-transitions'>
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let json = <?php echo $furnaceDataHour; ?>;
        console.log(<?php echo $furnaceDataHour; ?>);
        let lastDateTimeStamp = "";
        function FormatDataAndBuildCharts(json) {


            let filterValueArray = [];
            let unfilterValueArray = [];
            let filterUpperLimitArray = [];
            let filterLowerLimitArray = [];
            let northPyroValueArray = [];
            let southPyroValueArray = [];
            let pyroUpperLimitArray = [];
            let pyroLowerLimitArray = [];
            let thermalCameraValueArray = [];
            let labelObject = {};

            for (let i = 0; i < json.length; i++) {
                filterValueArray.push({x : i, y: json[i].FILTER});
                unfilterValueArray.push({x : i, y: json[i].UNFILTER});
                northPyroValueArray.push({x : i, y: json[i].NORTH_PYRO});
                southPyroValueArray.push({x : i, y: json[i].SOUTH_PYRO});
                thermalCameraValueArray.push({x : i, y: json[i].THERMAL_CAMERA});
                filterUpperLimitArray.push({x : i, y: 1000});
                filterLowerLimitArray.push({x : i, y: 825});
                pyroLowerLimitArray.push({x : i, y: 600});

                labelObject[i] = json[i].TIME_STAMP;
                lastDateTimeStamp = json[i].TIME_STAMP.toString();
            }

            var filterLineChart = RenderLineWithFocusChart('rhsFurnaceFilterLineChart',
                'lineWithFocus',
                labelObject, [
                    {values: filterValueArray, key: 'FILTER', color: '#f67019'},
                    {values: filterUpperLimitArray, key: 'UPPER_LIMIT', color: '#FF6384'},
                    {values: filterLowerLimitArray, key: 'LOWER_LIMIT', color: '#FF6384'}
                ],
                'Degrees',
                true,
                'Date',
                true,
                true);

            var unfilterLineChart = RenderLineWithFocusChart('rhsFurnaceUnfilterLineChart',
                'lineWithFocus',
                labelObject, [
                    {values: unfilterValueArray, key: 'UNFILTER', color: '#f67019'},
                    {values: filterUpperLimitArray, key: 'UPPER_LIMIT', color: '#FF6384'},
                    {values: filterLowerLimitArray, key: 'LOWER_LIMIT', color: '#FF6384'}
                ],
                'Degrees',
                true,
                'Date',
                true,
                true);

            var northPyroLineChart = RenderLineWithFocusChart('rhsFurnaceNorthPyroLineChart',
                'lineWithFocus',
                labelObject, [
                    {values: northPyroValueArray, key: 'NORTH_PYRO', color: '#537bc4'},
                    {values: pyroLowerLimitArray, key: 'LOWER_LIMIT', color: '#FF6384'}
                ],
                'Degrees',
                true,
                'Date',
                true,
                true);

            var southPyroLineChart = RenderLineWithFocusChart('rhsFurnaceSouthPyroLineChart',
                'lineWithFocus',
                labelObject, [
                    {values: southPyroValueArray, key: 'SOUTH_PYRO', color: '#537bc4'},
                    {values: pyroLowerLimitArray, key: 'LOWER_LIMIT', color: '#FF6384'}
                ],
                'Degrees',
                true,
                'Date',
                true,
                true);


            var thermalCameraLineChart = RenderLineWithFocusChart('thermalCameraLineChart',
                'lineWithFocus',
                labelObject, [
                    {values: thermalCameraValueArray, key: 'THERMAL_CAMERA', color: '#8549ba'},
                    {values: filterUpperLimitArray, key: 'UPPER_LIMIT', color: '#FF6384'},
                    {values: filterLowerLimitArray, key: 'LOWER_LIMIT', color: '#FF6384'}
                ],
                'Degrees',
                true,
                'Date',
                true,
                true);
        }

        FormatDataAndBuildCharts(json);

        // Set security token REF: https://laravel.com/docs/5.2/routing#csrf-protection
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Set interval to update charts with new data.
        setInterval(function(){
            console.log(lastDateTimeStamp);
            $.ajax({
                type: "post",
                url: rootUrl+"/api/GetFurnaceDataAsJSONAfterDateTime",
                data: {"dt" : lastDateTimeStamp},
                dataType: "json",
                success: function(data) {
                    console.log("single data req");
                    console.log(data);

                    if (data.length > 0) {
                        FormatDataAndBuildCharts(data);
                    }
                }
            });
        }, 10000);

    </script>

@endsection
