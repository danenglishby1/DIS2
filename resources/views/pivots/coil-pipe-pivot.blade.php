@extends('layouts.app')

@section('pageTitle', 'CoilPipe Pivot')
@section('pageName', 'CoilPipe Pivot')
@section('pivotsActiveLink', 'active activeUnderline')
@section('css')
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/plotly.basic.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pivot.css?v=1.2.1')}}"/>

    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <style>

        table.pvtTable tbody tr td {
            cursor: pointer;
        }

        table.pvtTable tbody tr td:hover {
            background: #d0d0d0;
        }

    </style>
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
    <div class="simpleflex justify-content-center">
        @section('overrideStartEndDate')
            start = moment().startOf('day');
            end = moment().endOf('day');

            window.dtFrom = start.format('Y-MM-DD 00:00:01');
            window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.


        @endsection
        @section('dateRangePickerOnApplyCallback')
            RefreshPivotWithCustomDateCriteria(dtFrom, dtTo, window.label);

        @endsection

        <div class="btn-flex mt-2 text-center">
            @include('layouts.templates.daterangepicker')
        </div>

        <div class="pivot-update-slider-switch text-center" style="margin-top: 9px;">
            <sub style="font-size: 16px">Updating</sub>
            <!-- Rounded switch -->
            <label class="switch">
                <input id="pivotUpdateSwitch" type="checkbox" checked="true">
                <span class="slider round"></span>
            </label>
        </div>
    </div>


    <div class="mb-2">
        <div class="text-left">
            <div>
                <label>MyReports</label>
                <select id="userConfigReports">
                    <option>Please select a report</option>
                    @foreach($userPredefinedReports as $userReports )
                        <option value="{{$userReports["PIVOT_CONFIG_ID"]}}">{{$userReports["CONFIG_REPORT_NAME"]}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Global Reports</label>
                <select  id="globalConfigReports">
                    <option>Please select a report</option>
                    @foreach($globalPredefinedReports as $globalReports )
                        <option value="{{$globalReports["PIVOT_CONFIG_ID"]}}">{{$globalReports["CONFIG_REPORT_NAME"]}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button class="btn btn-primary" id="save" data-toggle="modal" data-target="#filterModal">Save New Report</button>
        <button class="btn btn-secondary" style="display: none" id="update" >Update Report</button>
    </div>

    <div class="reportDescription text-center" id="report-description">

    </div>

    <div id="pivotOutput"></div>



    <hr class="mb-5">

    <table id="tbl" class="table table-striped table-bordered" style="width:100%">
        <thead>


        </thead>
        <tbody>
        </tbody>

        <tfoot>

        </tfoot>


    </table>

    <!-- Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Save New Pivot Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Descriptive report name</label>
                        <br />
                        <input class="form-control" id="name" type="text" required>
                    </div>

                    <div class="form-group">
                        <label>Report Description</label>
                        <br />
                        <textarea class="form-control" id="description" required></textarea>
                    </div>

                    @csrf
                    <div class="form-group">
                        <label>Add to global report list?</label>
                        <br />
                        <select class="form-control" id="globalListFlag">
                            <option value="N">N</option>
                            <option value="Y">Y</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="savePivotReport" type="button" class="btn btn-primary">Save Report</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('functionalScripts')

    <script type="text/javascript" src="{{ asset('public/js/pivotJS/cookie.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/jqueryUI.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/pivot.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/plotly-renderers.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/subtotal.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/pivot-helpers/PivotHelperListeners.js?v=1.4')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/pivot-helpers/PivotHelperFunctions.js?v=1.4')}}"></script>



    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    <!-- Extension scripts for datatables print functionality -->
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /**
         *
         * Global Dynamic Variables **/
        var dataTable = undefined; // Global so we can update dt with fresh data when user clicks on cells.
        var pivotData = <?php echo $rawData; ?>; // Passed in from controller.
        loadedDataSetLength = pivotData.length;
        var loadedConfig = ""; // Global config that will be changed if saved by user OR loaded from db. This will be the active setting for when refresh occurs.
        var pageNameUrl = "<?php echo basename($_SERVER['REQUEST_URI']); ?>";
        var liveUpdateOn = true; // Global
        //  var loadedDataSetLength = 0; // Global
        var userId = <?php echo Auth::user()->id; ?>; // Get user ID from Auth


        /**
         * Global Static Variables **/
        var dataTableLayoutObj = [
            {title: "PIPE NO", data: "TRACK_CODE"},
            {title: "SECTION NO", data: "TRACK_CODE_ALT"},
            {title: "ROLL WEEK", data: "ROLL_WEEK"},
            {title: "PROCESS_ROUTE", data: "PROCESS_ROUTE"},
            {title: "ROUTING POS", data: "ROUTING_POS"},
            {title: "THICK", data: "PIPE_THICK"},
            {title: "SIZE1", data: "PIPE_SIZE1"},
            {title: "SIZE2", data: "PIPE_SIZE2"},
            {title: "STATUS CODE", data: "PIPE_STATUS_CODE"},
            {title: "STATUS CODE SEVERITY", data: "PIPE_STATUS_CODE_SEVERITY"},
            {title: "PIPE LENGTH", data: "PIPE_LENGTH"},
            {title: "PIPE LENGTH TO REMOVE", data: "PIPE_LENGTH_TO_REMOVE"},
            {title: "PIPE GRADE", data: "PIPE_GRADE"},
            {title: "MILL LINE", data: "MILL_LINE"},
            {title: "OHS LINE", data: "OHS_LINE"},
            {title: "BLOCK NO", data: "BLOCK_NO"},
            {title: "COIL CAST NO", data: "COIL_CAST_NO"},
            {title: "COIL NO", data: "COIL_COIL_NO"},
            {title: "COIL WEEK", data: "COIL_COIL_WEEK"},
            {title: "COIL SEQ NO", data: "COIL_COIL_SEQ_NO"},
            {title: "COIL ADV WEIGHT", data: "COIL_ADV_WEIGHT"},
            {title: "DATETIME", data: "DATETIME_TANDEM"},
            {title: "PIPE NO", data: "PIPE_NO"},
            {title: "THEORETICAL WEIGHT", data: "T_WEIGHT"},
            {title: "CUST ORDER", data: "CUST_ORDER"},
            {title: "CUST ITEM", data: "CUST_ITEM_X"},
            {title: "ORDER_POS", data: "ORDER_POS"},
        ];

        loadedConfig = InitializePivot(["ROUTING_POS"], ["MILL_LINE"], pivotData, ["COIL_ACT_WEIGHT", "COIL_COIL_ITEM", "COIL_COIL_WIDTH_ALT", "COIL_COIL_THICK_ALT", "COIL_COIL_QUALITY_ALT",
            "COIL_STK_DATE", "COIL_AMEND_DATE", "COIL_MILL_SHEAR", "COIL_PART_COIL", "COIL_CAST_SUSPECT_DATE", "COIL_AMEND_REASON", "COIL_S_I_FLAG", "COIL_PROD_ANAL_TEST_IND",
            "COIL_AUTO_RELEASE_FLAG", "COIL_TPC_USED", "SLAB_NO"], 9999);
        RefreshPivotData('/api/GetCoilPipePivotData', 300000);
        //RefreshPivotWithDateCriteria("/api/GetCoilPipePivotData");


        /**
         * Check if report id has been passed in URL, if so, change the global report select option to load the report requested.
         */
        $( document ).ready(function() {
            var reportId = <?php echo(isset($_GET["reportId"]) ? $_GET["reportId"] : "null"); ?>;


            if (reportId !== null) {
                $('#globalConfigReports').val(reportId);
                $('#globalConfigReports').trigger("change");
            }

        });




        function RefreshPivotWithCustomDateCriteria(dtFrom, dtTo, label) {

            console.log(label);
            liveUpdateOn = false;
            $('#pivotUpdateSwitch').prop('checked', false);

            if (label == "Today") {
                liveUpdateOn = true;
                $('#pivotUpdateSwitch').prop('checked', true);
            }

            //    Make call to pivotBuilder, passing in filterCommand as param.
            $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
            $.ajax({
                type: "POST",
                url: rootUrl + "/api/GetCoilPipePivotData",
                data: {"dtFrom": dtFrom, "dtTo" : dtTo},
                dataType: "json",
                success: function (data) {
                    pivotData = data;
                    console.log(data);
                    if ($.cookie("pivotConfig") !== undefined) {
                        $("#pivotOutput").pivotUI(
                            data, JSON.parse($.cookie("pivotConfig")), true);
                    } else {
                        $("#pivotOutput").pivotUI(
                            data, loadedConfig);
                    }
                    //Update loaded data length
                    loadedDataSetLength = data.length;
                },
                complete: function () {
                    $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                }
            });


        }

    </script>
@endsection
