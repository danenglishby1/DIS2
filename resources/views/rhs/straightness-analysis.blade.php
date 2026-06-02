<?php
use App\H20Custom\libraries\HTMLHelper;
?>
@extends('layouts.app')

@section('pageTitle', 'Straightness Analysis')
@section('pageName', 'Straightness Analysis')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
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

    <!-- Button trigger modal -->

    <!-- Content Row -->

    <div class="btn-flex-wrapper mt-2 text-center">

        <div class="filter-middle">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#customQueryModal">
                Custom Query
            </button>
        </div>


    </div>

    <div class="mb-3"></div> <!-- add space -->



    <?php

echo HTMLHelper::StartSimpleFlexBoxWrapper();

    echo HTMLHelper::StartFlexBoxFullWidth();

        echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Straightness Bend Per Metre (prev24)", "rhsStraightnessBendPMLineChart");

    echo HTMLHelper::EndFlexBoxFullWidth();

echo HTMLHelper::EndSimpleFlexBoxWrapper();

echo ' <div class="mb-3"></div> <!-- add space -->';

echo HTMLHelper::StartSimpleFlexBoxWrapper();

    echo HTMLHelper::StartFlexBoxFullWidth();

        echo HTMLHelper::LineViewFinderChartCardPlaceHolder("Straightness Total Bend (prev24)", "rhsStraightnessTotalBendLineChart");

    echo HTMLHelper::EndFlexBoxFullWidth();

echo HTMLHelper::EndSimpleFlexBoxWrapper();
    ?>


{{--    <div class="simpleflex">--}}

{{--        <div class="fl1">--}}

{{--            <!--  Straightness PM Chart -->--}}
{{--            <div class="card shadow pb-2">--}}
{{--                <!-- Card Header - Dropdown -->--}}
{{--                <div--}}
{{--                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">--}}
{{--                    <h6 class="m-0 font-weight-bold text-primary">Straightness Bend Per Metre (prev24)</h6>  <span--}}
{{--                            class="filter-on-info"><span class="size1FilterValueOn"></span> <span--}}
{{--                                class="size2FilterValueOn"></span> <span class="thickFilterValueOn"></span></span>--}}
{{--                    <div class="dropdown no-arrow">--}}
{{--                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"--}}
{{--                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>--}}
{{--                        </a>--}}
{{--                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"--}}
{{--                             aria-labelledby="dropdownMenuLink">--}}
{{--                            <div class="dropdown-header">Dropdown Header:</div>--}}
{{--                            <a class="dropdown-item" href="#">Action</a>--}}
{{--                            <a class="dropdown-item" href="#">Another action</a>--}}
{{--                            <div class="dropdown-divider"></div>--}}
{{--                            <a class="dropdown-item" href="#">Something else here</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- Visual Content -->--}}
{{--                <!-- Update buttons -->--}}
{{--                <!-- Card Body -->--}}
{{--                <div class="card-body">--}}
{{--                    <div id="rhsStraightnessBendPMLineChart" class='with-3d-shadow with-transitions'>--}}
{{--                        <svg></svg>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!-- END Straightness PM Chart -->--}}

{{--    <div class="mb-3"></div> <!-- add space -->--}}

{{--    <div class="simpleflex">--}}

{{--        <div class="fl1">--}}

{{--            <!--  Straightness PM Chart -->--}}
{{--            <div class="card shadow pb-2">--}}
{{--                <!-- Card Header - Dropdown -->--}}
{{--                <div--}}
{{--                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">--}}
{{--                    <h6 class="m-0 font-weight-bold text-primary">Straightness Total Bend (prev24)</h6> <span--}}
{{--                            class="filter-on-info"><span class="size1FilterValueOn"></span> <span--}}
{{--                                class="size2FilterValueOn"></span> <span class="thickFilterValueOn"></span></span>--}}
{{--                    <div class="dropdown no-arrow">--}}
{{--                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"--}}
{{--                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>--}}
{{--                        </a>--}}
{{--                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"--}}
{{--                             aria-labelledby="dropdownMenuLink">--}}
{{--                            <div class="dropdown-header">Dropdown Header:</div>--}}
{{--                            <a class="dropdown-item" href="#">Action</a>--}}
{{--                            <a class="dropdown-item" href="#">Another action</a>--}}
{{--                            <div class="dropdown-divider"></div>--}}
{{--                            <a class="dropdown-item" href="#">Something else here</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- Visual Content -->--}}
{{--                <!-- Update buttons -->--}}
{{--                <!-- Card Body -->--}}
{{--                <div class="card-body">--}}

{{--                    <div id="rhsStraightnessTotalBendLineChart" class='with-3d-shadow with-transitions'>--}}
{{--                        <svg></svg>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- END Straightness PM Chart -->--}}

{{--            <div class="mb-3"></div> <!-- add space -->--}}
{{--        </div>--}}
{{--    </div>--}}




    <!-- Modal -->
    <div class="modal fade" id="customQueryModal" tabindex="-1" role="dialog" aria-labelledby="customQueryModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customQueryLabel">Enter Query</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="custom-query-form">
                        <div class="form-group">
                            <label for="dateFrom">Date From</label>
                            <input type="date" name="dateFrom" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="dateTo">Date To</label>
                            <input type="date" name="dateTo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="size1">Size 1</label>
                            <input type="number"  name="size1" step="any" class="form-control">

                            <label for="size2">Size 2</label>
                            <input type="number"  name="size2" step="any" class="form-control">

                            <label for="thick">Thickness</label>
                            <input type="number"  name="thick" step="any" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
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
    <script src="{{ asset('public/js/filter-change-listeners.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/FormValueObjectMap.js')}}"></script>
    <script src="{{ asset('public/js/custom-query-submitter.js')}}"></script>


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function FillChartArraysAndRenderCharts(d) {

            /**
             * Fill local arrays with data from data object.
             */
            var straightnessData = d;
            console.log(straightnessData);
            var stn1BendPerMetreArray = [];
            var stn2BendPerMetreArray = [];
            var bendPerMetreUpperControlLimit = [];
            var bendPerMetreLowerControlLimit = [];

            var stn1TotalBendArray = [];
            var stn2TotalBendArray = [];
            var totalBendUpperControlLimit = [];
            var totalBendLowerControlLimit = [];

            var size1 = [];
            var size2 = [];
            var thick = [];

            var xAxis1Labels = {};
            var xAxis2Labels = {};
            for (var i = 0; i < straightnessData.length; i++) {
                xAxis1Labels[i] = straightnessData[i].SECTION_NO;
                xAxis2Labels[i] = straightnessData[i].F_TIME_STAMP;
                stn1BendPerMetreArray.push({x: i, y: straightnessData[i].STN1_BEND_PERM});
                stn2BendPerMetreArray.push({x: i, y: straightnessData[i].STN2_BEND_PERM});
                bendPerMetreUpperControlLimit.push({x: i, y: 3.0});
                bendPerMetreLowerControlLimit.push({x: i, y: -3.0});

                stn1TotalBendArray.push({x: i, y: straightnessData[i].STN1_TOT_BEND});
                stn2TotalBendArray.push({x: i, y: straightnessData[i].STN2_TOT_BEND});
                totalBendUpperControlLimit.push({x: i, y: straightnessData[i].TOTAL_BEND_TOLERANCE});
                totalBendLowerControlLimit.push({x: i, y: -straightnessData[i].TOTAL_BEND_TOLERANCE});


            }

            /**
             * Build charts using chart-builder.js helper.
             */
            var bendPerMetreLineChart = RenderLineWithFocusChartDualAxisLabels('rhsStraightnessBendPMLineChart',
                'lineWithFocus',
                xAxis1Labels, xAxis2Labels, [
                    {values: stn1BendPerMetreArray, key: 'STN1_B_P_M', color: '#537bc4'},
                    {values: stn2BendPerMetreArray, key: 'STN2_B_P_M', color: '#8549ba'},
                    {values: bendPerMetreUpperControlLimit, key: 'UCL', color: '#FF6384'},
                    {values: bendPerMetreLowerControlLimit, key: 'LCL', color: '#FF6384'}
                ],
                'MM',
                true,
                'Section',
                true,
                true,
                []);

            var totalBendLineChart = RenderLineWithFocusChartDualAxisLabels('rhsStraightnessTotalBendLineChart',
                'lineWithFocus',
                xAxis1Labels, xAxis2Labels, [
                    {values: stn1TotalBendArray, key: 'STN1_TOTAL_BEND', color: '#537bc4'},
                    {values: stn2TotalBendArray, key: 'STN2_TOTAL_BEND', color: '#8549ba'},
                    {values: totalBendUpperControlLimit, key: 'UCL', color: '#FF6384'},
                    {values: totalBendLowerControlLimit, key: 'LCL', color: '#FF6384'}
                ],
                'MM',
                true,
                'Section',
                true,
                true,
                [-10, 10]);
        }




        /**
        Listen for custom query submit, parse form values and submit to api, then rerun the FillChartArraysAndRenderCharts function.
        */

        $('.custom-query-form').on('submit', function (e) {
            e.preventDefault(); // stop submit
            // parse name values from form
            var formValuesObject = $(this).serializeObject();

            //Submit values to api.

            // Ajax call to api using dt from and dt to from date range picker, get data and update charts + filters.
            $('.ajax-loader').css("display", "block");
            $.ajax({
                type: "POST",
                data: formValuesObject,
                url: rootUrl+"/api/GetStraightnessCustomQuery",
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if ( data.length == 0 ) {
                        alert("No data found for query criteria");
                    }
                    else {
                        FillChartArraysAndRenderCharts(data);
                    }


                },
                complete: function () {
                    $('.ajax-loader').css("display", "none");
                }
            });
            // END Ajax call to api using dt from and dt to from date range picker, get data and update charts + filters.



        });









    </script>

@endsection
