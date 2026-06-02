@extends('layouts.app')

    @section('pageTitle', 'Test Piece Pivot')
@section('pageName', 'Test Piece Pivot')
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
@section('dateRangePickerOnApplyCallback')

    UpdatePivotWithDateRange(dtFrom, dtTo)

@endsection
@section('overrideStartEndDate')
start = moment().startOf('month');
end = moment().endOf('month');
@endsection
<div class="filters">
@include('layouts.templates.daterangepicker')
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
        var pivotData = <?php echo $testPieceData; ?>;
        loadedDataSetLength = pivotData.length;
        var loadedConfig = ""; // Global config that will be changed if saved by user OR loaded from db. This will be the active setting for when refresh occurs.
        var pageNameUrl = "<?php echo basename($_SERVER['REQUEST_URI']); ?>";
        var liveUpdateOn = true; // Global
        //  var loadedDataSetLength = 0; // Global
        var userId = <?php echo Auth::user()->id; ?>; // Get user ID from Auth



        /**
         * Global Static Variables **/
        var dataTableLayoutObj = [
            {title: "TEST PIECE NO", data: "TEST_PIECE_NO"},
            {title: "TEST PIECE YEAR", data: "TEST_PIECE_YEAR"},
            {title: "BLOCK NO", data: "BLOCK_NO"},
            {title: "ROLL WEEK", data: "ROLL_WEEK"},
            {title: "CAST_NO", data: "CAST_NO"},
            {title: "EX HOLL BLOCK IND", data: "EX_HOLL_BLOCK_IND"},
            {title: "TEST_FREQUENCY_NO", data: "TEST_FREQUENCY_NO"},
            {title: "BATCH NO", data: "BATCH_NO"},
            {title: "TEST PIECE STATUS", data: "TEST_PIECE_STATUS"},
            {title: "TRACK CODE", data: "TRACK_CODE"},
            {title: "RING SUFFIX", data: "RING_SUFFIX"},
            {title: "CHARPSS CODE", data: "CHARPSS_CODE"},
            {title: "TEST_PIECE_TYPE", data: "TEST_PIECE_TYPE"},
            {title: "SHAPE", data: "SHAPE"},
            {title: "CUST ORDER", data: "CUST_ORDER"},
            {title: "CUST ITEM", data: "CUST_ITEM_X"},
            {title: "PASS FAIL IND", data: "PASS_FAIL_IND"},
            {title: "PARENT TEST PIECE NO", data: "PARENT_TEST_PIECE_NO"},
            {title: "PARENT TEST PIECE YEAR", data: "PARENT_TEST_PIECE_YEAR"},
            {title: "TEST ADDED DATETIME", data: "TEST_ADDED_DATETIME"},
            {title: "RING NO ADDED DATETIME", data: "RING_NO_ADDED_DATETIME"},
            {title: "LACKENBY_TFER_DATETIME", data: "LACKENBY_TFER_DATETIME"},
            {title: "ORIGIN IND", data: "ORIGIN_IND"},
            {title: "CUT IND", data: "CUT_IND"},
            {title: "TEST PIECE CUT DATETIME", data: "TEST_PIECE_CUT_DATETIME"},
            {title: "RES ELONG CODE", data: "RES_ELONG_CODE"},
            {title: "RES ELONG CODE PF IND", data: "RES_ELONG_CODE_PF_IND"},
            {title: "RES CHARPY TEST TEMP", data: "RES_CHARPY_TEST_TEMP"},
            {title: "RES CHARPY TEST TEMP PF IND", data: "RES_CHARPY_TEST_TEMP_PF_IND"},
            {title: "RES CHARPY T L IND", data: "RES_CHARPY_T_L_IND"},
            {title: "RES CHARPY T L PF IND", data: "RES_CHARPY_T_L_PF_IND"},
            {title: "RES CHARPSS CODE", data: "RES_CHARPSS_CODE"},
            {title: "RES CHARPSS CODE PF IND", data: "RES_CHARPSS_CODE_PF_IND"},
            {title: "RES CAST NO", data: "RES_CAST_NO"},
            {title: "RES CAST NO PF IND", data: "RES_CAST_NO_PF_IND"},
            {title: "RES RECVD DATETIME", data: "RES_RECVD_DATETIME"},
            {title: "CHARPY TEST TEMP", data: "CHARPY_TEST_TEMP"},
            {title: "LAST UPDATE DATETIME", data: "LAST_UPDATE_DATETIME"},
            {title: "COIL WEEK SEQ NO", data: "COIL_WEEK_SEQ_NO"},
            {title: "TEST TYPE CODE", data: "TEST_TYPE_CODE"},
            {title: "PASSED FOR ANALYSIS", data: "PASSED_FOR_ANALYSIS"},
            {title: "COMMENTS", data: "COMMENTS"},
            {title: "ORIG RES ELONG CODE", data: "ORIG_RES_ELONG_CODE"}
        ];

        loadedConfig = InitializePivot(["TEST_TYPE_CODE"], ["TEST_PIECE_TYPE"], pivotData, ["LENGTH_CATEGORY", "UNTYPE_IND", "COL_CAT", "ACCEPT_CANCEL", "RELEASE_RESULT", "STOCK_XREF", "DIG_OUT_IND"], 100);

        function UpdatePivotWithDateRange(dtFrom, dtTo) {
            $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
            $.ajax({
                type: "POST",
                url: rootUrl + '/api/GetTestPiecePivotData',
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
