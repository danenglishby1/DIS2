@extends('layouts.app')

@section('pageTitle', 'Section Furnace Traces')
@section('pageName', 'Section Furnace Traces')
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

    <div class="simpleflex" style="justify-content: flex-end;">
        <!-- Form to allow user to submit fresh CON Number and week number to re request new data .-->
        <form action="{{ route('section-furnace-trace') }}" method="GET">
        <div class="section-trace-input-flex">
        <input type="text" name="sectionNo" placeholder="Format: Con Num xxxx" value="{{$sectionNo}}">
        <input type="number" name="weekNo" placeholder="WW" value="{{$weekNo}}">
        <input type="number" name="yearNo" placeholder="yyyy" value="{{$yearNo}}">
        <input class="btn btn-primary" type="submit" value="Submit">
        </div>
        </form>
    </div>
    <!-- Content Row -->

    <div class="section-details-info">
        <h5>Section Furnace Trace for: {{$sectionNo}} WeekNo: {{$weekNo}} YearNo: {{$yearNo}} - Process Route: {{$pr}}  Grade: {{$grade}}</h5>
    </div>

    <div class="mb-3"></div> <!-- add space -->


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

        let json = <?php echo $furnaceSectionData; ?>;
        console.log(<?php echo $furnaceSectionData; ?>);
        let lastDateTimeStamp = "";
        let pr =  "<?php echo $pr; ?>";
        let grade =  "<?php echo $grade; ?>";
        function FormatDataAndBuildCharts(json) {

            let filterValueArray = [];
            let unfilterValueArray = [];
            let filterUpperLimitArray = [];
            let filterLowerLimitArray = [];
            let labelObject = {};


            let filterUpperLimit = 0;
            let filterLowerLimit = 0;


            if (pr == "R" && grade !== "50CTEMP") {
                filterLowerLimit = 800;
                filterUpperLimit = 975;
            }
            if (pr == "Q" || pr == "L") {
                filterLowerLimit = 620;
                filterUpperLimit = 720;
            }
            if (pr == "R" && grade == "50CTEMP") {
                filterLowerLimit = 650;
                filterUpperLimit = 750;
            }




            for (let i = 0; i < json.length; i++) {
                filterValueArray.push({x: i, y: json[i].FILTER});
                unfilterValueArray.push({x: i, y: json[i].UNFILTER});
                filterUpperLimitArray.push({x: i, y: filterUpperLimit});
                filterLowerLimitArray.push({x: i, y: filterLowerLimit});


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


        }
        FormatDataAndBuildCharts(json);


    </script>

@endsection
