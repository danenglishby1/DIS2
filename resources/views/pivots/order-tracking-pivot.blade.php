@extends('layouts.app')

@section('pageTitle', 'Order Tracking')
@section('pageName', 'Order Tracking')
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
                        <option
                            value="{{$userReports["PIVOT_CONFIG_ID"]}}">{{$userReports["CONFIG_REPORT_NAME"]}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Global Reports</label>
                <select id="globalConfigReports">
                    <option>Please select a report</option>
                    @foreach($globalPredefinedReports as $globalReports )
                        <option
                            value="{{$globalReports["PIVOT_CONFIG_ID"]}}">{{$globalReports["CONFIG_REPORT_NAME"]}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button class="btn btn-primary" id="save" data-toggle="modal" data-target="#filterModal">Save New Report
        </button>
        <button class="btn btn-secondary" style="display: none" id="update">Update Report</button>
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
    <script type="text/javascript" src="{{ asset('public/js/pivot-helpers/UpdatePivotWithSweetAlert.js?v=1.4')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/pivot-helpers/PivotHelperListeners.js?v=1.4')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/pivot-helpers/PivotHelperFunctions.js?v=1.4')}}"></script>

    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js?v=1.0')}}"></script>
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

        /**
         *
         * Global Dynamic Variables **/
        var dataTable = undefined; // Global so we can update dt with fresh data when user clicks on cells.
        var pivotData = <?php echo $orderTrackingData; ?>;
        loadedDataSetLength = pivotData.length;
        var loadedConfig = ""; // Global config that will be changed if saved by user OR loaded from db. This will be the active setting for when refresh occurs.
        var pageNameUrl = "<?php echo basename($_SERVER['REQUEST_URI']); ?>";
        var liveUpdateOn = true; // Global
        //  var loadedDataSetLength = 0; // Global
        var userId = <?php echo Auth::user()->id; ?>; // Get user ID from Auth


        /**
         * Global Static Variables **/
        var dataTableLayoutObj = [
            {title: "ORDER ROUTE", data: "ORDER_ROUTE"},
            {title: "CUST ORDER", data: "CUST_ORDER"},
            {title: "CUST ITEM", data: "CUST_ITEM_X"},
            {title: "LOT QTY", data: "LOT_QTY"},
            {title: "TRACK METRES", data: "TRACK_METRES"},
            {title: "TRACK TONNES", data: "TRACK_TONNES"},
            {title: "ORDER POS", data: "ORDER_POS"},
            {title: "DATETIME UPDATE", data: "DATETIME_TANDEM"},
            {title: "ADVISED STATE", data: "ADVISED_STATE"},
            {title: "ADVISED TO DATE KG", data: "ADVISED_TO_DATE_KG"},
            {title: "ADVISED TO DATE METRES", data: "ADVISED_TO_DATE_METRES"},
            {title: "ADVISED TO DATE QTY", data: "ADVISED_TO_DATE_QTY"},
            {title: "COMPLETE DATE", data: "COMPLETE_DATE"},
            {title: "S VALUE", data: "S_VALUE"},
            {title: "OWNER BUSINESS", data: "OWNER_BUSINESS"},
            {title: "SALES DEPT", data: "SALES_DEPT"},
            {title: "SALES REF NO", data: "SALES_REFNO"},
            {title: "ORDER CLASS", data: "ORDER_CLASS"},
            {title: "ORDER SPEC", data: "ORDER_SPEC"},
            {title: "ORDER GRADE", data: "ORDER_GRADE"},
            {title: "BLOCK NO", data: "BLOCK_NO"},

            {title: "CUSTOMER NO", data: "CUSTOMER_NO"},
            {title: "CUSTOMER CARD", data: "CUSTOMER_CARD"},
            {title: "PIPE SIZE1", data: "PIPE_SIZE1"},
            {title: "PIPE SIZE2", data: "PIPE_SIZE2"},
            {title: "PIPE THICK", data: "PIPE_THICK"},
            {title: "PIPE_GRADE", data: "PIPE_GRADE"},
            {title: "PROCESS ROUTE", data: "PROCESS_ROUTE"},
            {title: "SURFACE FINISH", data: "SURFACE_FINISH"},
            {title: "BEVEL_ANGLE", data: "BEVEL_ANGLE"},
            {title: "ORDERED METRES", data: "ORDER_METRES"},
            {title: "ORDERED TONNES", data: "ORDER_TONNES"},
            {title: "ORDERED PIPES", data: "ORDER_PIPES"},
            {title: "ALLOC UNIT", data: "ALLOC_UNIT"},
            {title: "FIN AVR LENGTH", data: "FIN_AVR_LENGTH"},
            {title: "FIN MIN LENGTH", data: "FIN_MIN_LENGTH"},
            {title: "FIN MAX LENGTH", data: "FIN_MAX_LENGTH"},
            {title: "WM MIN LENGTH", data: "WM_MAX_LENGTH"},
            {title: "WM MAX LENGTH", data: "WM_MAX_LENGTH"},
            {title: "EARLIEST DELIVERY (DELA)", data: "EARLIEST_DELIVERY"},
            {title: "LATEST DELIVERY (DELB)", data: "LATEST_DELIVERY"},
            {title: "COMPLETE FLAG", data: "COMPLETE_FLAG"},
            {title: "CANCEL FLAG", data: "CANCEL_FLAG"},
            {title: "EXCESS PLUS", data: "EXCESS_PLUS"},
            {title: "EXCESS MINUS", data: "EXCESS_MINUS"},
            {title: "SHORTS MIN LENGTH", data: "SHORTS_MIN_LENGTH"},
            {title: "SHORTS MAX", data: "SHORTS_MAX"},
            {title: "WEIGHT FLAG", data: "WEIGHT_FLAG"},
            {title: "OUTSIDE INSPECTION", data: "OUTSIDE_INSPECTION"},
            {title: "INDENT", data: "INDENT"},
            {title: "PLASTIC CAPS", data: "PLASTIC_CAPS"},
            {title: "ID TRIMMED", data: "ID_TRIMMED"},
            {title: "INSPECTION BY", data: "INSPECTION_BY"},
            {title: "CUSTOMER NAME1", data: "CUSTOMER_NAME_1"},
            {title: "CUSTOMER NAME2", data: "CUSTOMER_NAME_2"},
            {title: "CUSTOMER REFERENCE 1", data: "CUSTOMER_REFERENCE_1"},
            {title: "ITEM REFERENCE", data: "ITEM_REFERENCE"},
            {title: "NO OF CUTS", data: "NO_OF_CUTS"},
            {title: "STOCK ALLOWED FLAG", data: "STOCK_ALLOWED_FLAG"},
            {title: "SCH ROLL WEEK", data: "SCH_ROLL_WEEK"},
            {title: "EX STOCK IND", data: "EX_STOCK_IND"},
            {title: "PRODNO", data: "PRODNO"},
            {title: "MIN AVE LENGTH", data: "MIN_AVE_LEN"},
            {title: "BUNDLE IND", data: "BUNDLE_IND"},
            {title: "UNDERCOVER IND", data: "UNDERCOVER_IND"},
            {title: "OVERLENGTH", data: "OVERLENGTH"},
            {title: "READY STATUS", data: "READY_STATUS"},
            {title: "DELB RANGE", data: "DELB_RANGE"},
            {title: "ORDER TONNES MINUS EXCESS", data: "ORDER_TONNES_MINUS_EXCESS"},
            {title: "ORDER PIPES MINUS EXCESS", data: "ORDER_PIPES_MINUS_EXCESS"},
            {title: "ORDER METRES MINUS EXCESS", data: "ORDER_METRES_MINUS_EXCESS"},
            {title: "ORDER TONNES BTM", data: "ORDER_TONNES_BTM"},
            {title: "ORDER PIPES BTM", data: "ORDER_PIPES_BTM"},
            {title: "ORDER METRES BTM", data: "ORDER_METRES_BTM"},
            {title: "BLOCK OD", data: "BLOCK_OD"},
            {title: "BLOCK GRADE", data: "BLOCK_GRADE"},
            {title: "CUSTOMER CATEGORY CODE", data: "CUSTOMER_CATEGORY_CODE"},
        ];

//Hidden array (Now filtered out in sql) ["ORDER_GROUP", "ORDER_TRACK_XREF", "WAIT_REASON", "WAIT_DATETIME", "ACT_MAX_LENGTH", "ACT_MIN_LENGTH", "ALLOCATION_FLAG", "ATO_FLAG", "EX_STOCK_METRES",
//        "EX_STOCK_PIPES", "IMP_LENGTH_1", "IMP_LENGTH2", "IMP_SIZE1", "IMP_SIZE2", "IMP_THICK", "LENGTH_UNIT", "PRE_DESP_INSP", "PROGRAMME_COMMENTS", "PROGRAMME_COMMENTS_2", "PROGRESS_COMMENTS",
//            "QUALITY_PLAN", "TEST_CERT_COPIES"]
        loadedConfig = InitializePivot(["ORDER_POS"], [], pivotData, [], 3000);
        RefreshPivotData('/api/GetOrderTrackingPivotData', 300000);
        RefreshPivotWithDateCriteria("/api/GetOrderTrackingPivotData");


    </script>
@endsection
