<?php
use App\H20Custom\libraries\HTMLHelper;
?>
@extends('layouts.app')

@section('pageTitle', 'Straightness Reject Rates By Week')
@section('pageName', 'Straightness Reject Rates By Week')
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
    <h5 id="queryParamsSelected" style="text-align: center"></h5>


    <div class="mb-3"></div> <!-- add space -->

    <?php
    echo HTMLHelper::StartSimpleFlexBoxWrapper();

    echo HTMLHelper::StartFlexBoxFullWidth();

    echo HTMLHelper::DiscreteBarCharttCardPlaceHolder("All Bend Rejection Rate", "allBendRejectionRateBarChart");

    echo HTMLHelper::EndFlexBoxFullWidth();

    echo HTMLHelper::EndSimpleFlexBoxWrapper();

    echo ' <div class="mb-3"></div> <!-- add space -->';
    ?>

    <h5 class="ml-3 mt-3 mb-3">Breakdown</h5>
    <hr class="ml-3 mt-3 mb-3" />

    <?php
    echo HTMLHelper::StartSimpleFlexBoxWrapper();

    echo HTMLHelper::StartFlexBoxFullWidth();

    echo HTMLHelper::DiscreteBarCharttCardPlaceHolder("Stn1 BPM Rejection Rate", "stn1BPMRejectionRateBarChart");

    echo HTMLHelper::EndFlexBoxFullWidth();

    echo HTMLHelper::EndSimpleFlexBoxWrapper();

    echo ' <div class="mb-3"></div> <!-- add space -->';

    echo HTMLHelper::StartSimpleFlexBoxWrapper();

    echo HTMLHelper::StartFlexBoxFullWidth();

    echo HTMLHelper::DiscreteBarCharttCardPlaceHolder("Stn2 BPM Rejection Rate", "stn2BPMRejectionRateBarChart");

    echo HTMLHelper::EndFlexBoxFullWidth();

    echo HTMLHelper::EndSimpleFlexBoxWrapper();

    echo ' <div class="mb-3"></div> <!-- add space -->';

    echo HTMLHelper::StartSimpleFlexBoxWrapper();

    echo HTMLHelper::StartFlexBoxFullWidth();

    echo HTMLHelper::DiscreteBarCharttCardPlaceHolder("Stn1 TB Rejection Rate", "stn1TBRejectionRateBarChart");

    echo HTMLHelper::EndFlexBoxFullWidth();

    echo HTMLHelper::EndSimpleFlexBoxWrapper();

    echo ' <div class="mb-3"></div> <!-- add space -->';

    echo HTMLHelper::StartSimpleFlexBoxWrapper();

    echo HTMLHelper::StartFlexBoxFullWidth();

    echo HTMLHelper::DiscreteBarCharttCardPlaceHolder("Stn2 TB Rejection Rate", "stn2TBRejectionRateBarChart");

    echo HTMLHelper::EndFlexBoxFullWidth();

    echo HTMLHelper::EndSimpleFlexBoxWrapper();
    ?>




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
                            <input type="date" name="dtFrom" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="dateTo">Date To</label>
                            <input type="date" name="dtTo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="size1">Size 1</label>
                            <input type="number" name="size1" step="any" class="form-control">

                            <label for="size2">Size 2</label>
                            <input type="number" name="size2" step="any" class="form-control">

                            <label for="thick">Thickness</label>
                            <input type="number" name="thick" step="any" class="form-control">
                        </div>
                        <input type="hidden" name="default" value=false>
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
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.ajax-loader').css("display", "block");
            $.ajax({
                type: "GET",
                url: rootUrl + "/api/GetDefaultStraightnessRejectionByWeekData",
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data.length == 0) {
                        alert("No data found for query criteria");
                    } else {

                        RenderStaticDiscreteBarChart(JSON.parse(data.allBendRejectionRateJson), "label", "value", "allBendRejectionRateBarChart", null, "Week No", "Reject %", ",2f", ",2f",[], true, true, "SECTIONS_PROCESSED", null, null, null, null);
                        RenderStaticDiscreteBarChart(JSON.parse(data.stn1BPMRejectionRateJson), "label", "value", "stn1BPMRejectionRateBarChart", null, "Week No", "Reject %", ",2f", ",2f",[], true, true, "SECTIONS_PROCESSED", null, null, null, null);
                        RenderStaticDiscreteBarChart(JSON.parse(data.stn2BPMRejectionRateJson), "label", "value", "stn2BPMRejectionRateBarChart", null, "Week No", "Reject %", ",2f", ",2f",[], true, true, "SECTIONS_PROCESSED", null, null, null, null);
                        RenderStaticDiscreteBarChart(JSON.parse(data.stn1TBRejectionRateJson), "label", "value", "stn1TBRejectionRateBarChart", null, "Week No", "Reject %", ",2f", ",2f",[], true, true, "SECTIONS_PROCESSED", null, null, null, null);
                        RenderStaticDiscreteBarChart(JSON.parse(data.stn2TBRejectionRateJson), "label", "value", "stn2TBRejectionRateBarChart", null, "Week No", "Reject %", ",2f", ",2f",[], true, true, "SECTIONS_PROCESSED", null, null, null, null);

                    }
                },
                complete: function () {
                    $('.ajax-loader').css("display", "none");
                }
            });
        });
        /**
         Listen for custom query submit, parse form values and submit to api, then rerun the FillChartArraysAndRenderCharts function.
         */

        $('.custom-query-form').on('submit', function (e) {
            e.preventDefault(); // stop submit

            // Close modal.
            $('#customQueryModal').modal('toggle');

            // parse name values from form
            var formValuesObject = $(this).serializeObject();

            // Show query params on page .
            $('#queryParamsSelected').html('Active Filter ---' + 'SIZE1: ' + formValuesObject.size1 + 'mm x ' + formValuesObject.size2 + 'mm  ' + formValuesObject.thick + 'mm Thick');

            //Submit values to api.
            // Ajax call to api using dt from and dt to from date range picker, get data and update charts + filters.
            $('.ajax-loader').css("display", "block");
            $.ajax({
                type: "POST",
                data: formValuesObject,
                url: rootUrl + "/api/GetStraightnessRejectionByWeekDataCustomQuery",
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data.length == 0) {
                        alert("No data found for query criteria");
                    } else {
                        console.log("Redraw");
                        RenderStaticDiscreteBarChart(JSON.parse(data.allBendRejectionRateJson), "label", "value", "allBendRejectionRateBarChart", null, "Week No", "Reject %", ",2f", ",2f",[], true, true, "SECTIONS_PROCESSED", null, null, null, null);
                        RenderStaticDiscreteBarChart(JSON.parse(data.stn1BPMRejectionRateJson), "label", "value", "stn1BPMRejectionRateBarChart", null, "Week No", "Reject %", ",2f", ",2f",[], true, true, "SECTIONS_PROCESSED", null, null, null, null);
                        RenderStaticDiscreteBarChart(JSON.parse(data.stn2BPMRejectionRateJson), "label", "value", "stn2BPMRejectionRateBarChart", null, "Week No", "Reject %", ",2f", ",2f",[], true, true, "SECTIONS_PROCESSED", null, null, null, null);
                        RenderStaticDiscreteBarChart(JSON.parse(data.stn1TBRejectionRateJson), "label", "value", "stn1TBRejectionRateBarChart", null, "Week No", "Reject %", ",2f", ",2f",[], true, true, "SECTIONS_PROCESSED", null, null, null, null);
                        RenderStaticDiscreteBarChart(JSON.parse(data.stn2TBRejectionRateJson), "label", "value", "stn2TBRejectionRateBarChart", null, "Week No", "Reject %", ",2f", ",2f",[], true, true, "SECTIONS_PROCESSED", null, null, null, null);
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
