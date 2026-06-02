@extends('layouts.app')

@section('pageTitle', 'Surplus Tracking')
@section('pageName', 'Surplus Tracking')
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

        <div class="pivot-update-slider-switch text-center">
            <sub style="font-size: 16px">Updating</sub>
            <!-- Rounded switch -->
            <label class="switch">
                <input id="pivotUpdateSwitch" type="checkbox" checked="true">
                <span class="slider round"></span>
            </label>

        </div>
    </div>

    <!-- Content Row -->
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

    <?php

    ?>
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
        var pivotData = <?php echo $surplusTrackingData; ?>;
        loadedDataSetLength = pivotData.length;
        var loadedConfig = ""; // Global config that will be changed if saved by user OR loaded from db. This will be the active setting for when refresh occurs.
        var pageNameUrl = "<?php echo basename($_SERVER['REQUEST_URI']); ?>";
        var liveUpdateOn = true; // Global
        //  var loadedDataSetLength = 0; // Global
        var userId = <?php echo Auth::user()->id; ?>; // Get user ID from Auth



        /**
         * Global Static Variables **/
        var dataTableLayoutObj = [
            {title: "PIPE_NO", data: "TRACK_CODE"},
            {title: "SECTION NO", data: "TRACK_CODE_KEY2"},
            {title: "SIZE1", data: "PIPE_SIZE1"},
            {title: "SIZE2", data: "PIPE_SIZE2"},
            {title: "THICK", data: "PIPE_THICK"},
            {title: "BLOCK GRADE", data: "BLOCK_GRADE"},
            {title: "PROCESS ROUTE", data: "PROCESS_ROUTE"},
            {title: "STOCK STATUS", data: "STOCK_STATUS"},
            {title: "AGE PROFILE", data: "AGE_PROFILE"},
            {title: "AGE", data: "AGE"},
            {title: "AGE PROFILE AT MONTH END", data: "AGE_PROFILE_AT_MONTH_END"},
            {title: "AGE AT MONTH END", data: "AGE_AT_MONTH_END"},
            {title: "SURFACE_FINISH", data: "SURFACE_FINISH"},
            {title: "CUST ORDER", data: "CUST_ORDER"},
            {title: "CUST_ITEM_X", data: "CUST_ITEM_X"},
            {title: "ROLL WEEK", data: "ROLL_WEEK"},
            {title: "BLOCK NO", data: "BLOCK_NO"},
            {title: "CAST NO", data: "CAST_NO"},
            {title: "COIL NO", data: "COIL_NO"},
            {title: "COIL QUALITY", data: "COIL_QUALITY"},
            {title: "PIPE LENGTH", data: "PIPE_LENGTH"},
            {title: "ACTUAL WEIGHT", data: "ACTUAL_WEIGHT"},
            {title: "BEVEL_ANGLE", data: "BEVEL_ANGLE"},
            {title: "COMMENTS", data: "COMMENTS"},
            {title: "DATE TO STOCK", data: "DATE_TO_STOCK"},
            {title: "INITIALS", data: "INITIALS"},
            {title: "PIPE STATUS CODE", data: "PIPE_STATUS_CODE"},
            {title: "MILL_LINE", data: "MILL_LINE"},
            {title: "OHS_LINE", data: "OHS_LINE"},
            {title: "STOCK_MEMO_NO", data: "STOCK_MEMO_NO"},
            {title: "FURNACE IND", data: "FURNACE_IND"},
            {title: "CUT BACK TO", data: "CUT_BACK_TO"},
            {title: "CUT IN HALF IND", data: "CUT_IN_HALF_IND"},
            {title: "RE_HYDRO_IND", data: "RE_HYDRO_IND"},
            {title: "RE_BEVEL_IND", data: "RE_BEVEL_IND"},
            {title: "PAINTVARNISH_IND", data: "PAINT_VARNISH_IND"},
            {title: "OLD BLOCK NO", data: "OLD_BLOCK_NO"},
            {title: "OLD ROLL WEEK", data: "OLD_ROLL_WEEK"},
            {title: "OLD MILL LINE", data: "OLD_MILL_LINE"},
            {title: "OLD OHS LINE", data: "OLD_OHS_LINE"},
            {title: "OLD PIPE SIZE1", data: "OLD_PIPE_SIZE1"},
            {title: "OLD PIPE SIZE2", data: "OLD_PIPE_SIZE2"},
            {title: "OLD PIPE THICK", data: "OLD_PIPE_THICK"},
            {title: "OLD PIPE_GRADE", data: "OLD_PIPE_GRADE"},
            {title: "OLD PROCESS ROUTE", data: "OLD_PROCESS_ROUTE"},
            {title: "OLD ROUTING POS", data: "OLD_ROUTING_POS"},
            {title: "LAST UPDATE DATETIME", data: "LAST_UPDATE_DATETIME"},
            {title: "EX HOLLOW BLOCK IND", data: "EX_HOLL_BLOCK_IND"},
            {title: "RESTRICT_CODE", data: "RESTRICT_CODE"},
            {title: "ID TRIMMED", data: "ID_TRIMMED"},
            {title: "BAY LOCATION", data: "BAY_LOCATION"},
            {title: "THEORETICAL WEIGHT", data: "T_WEIGHT"},
        ];

        loadedConfig = InitializePivot(["PROCESS_ROUTE"], ["STOCK_STATUS"], pivotData, ["LENGTH_CATEGORY", "UNTYPE_IND", "COL_CAT", "ACCEPT_CANCEL", "RELEASE_RESULT", "STOCK_XREF", "DIG_OUT_IND"], 100);
        RefreshPivotData('/api/GetSurplusTrackingPivotData', 300000);
        RefreshPivotWithDateCriteria("/api/GetSurplusTrackingPivotData");

    </script>
@endsection
