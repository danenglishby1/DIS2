@extends('layouts.app')

@section('pageTitle', 'Weld Mill Stoppages')
@section('pageName', 'Weld Mill Stoppages')
@section('pivotsActiveLink', 'active activeUnderline')
@section('css')

    <script type="text/javascript" src="{{ asset('public/js/pivotJS/plotly.basic.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pivot.css?v=1.2.1')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">


    <style>

        table.pvtTable tbody tr td {
            cursor: pointer;
        }

        table.pvtTable tbody tr td:hover {
            background: #d0d0d0;
        }


        h5.notification-title {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 0px;
            font-size: 14px;
        }

        .upperNotificationContent {
            display: flex;
            flex-wrap: wrap;
            padding: 7px;
            background: #d8d8d8;
            border-radius: 3px;
            margin-bottom: 10px;
        }

        .upperNotificationContent > div {
            flex: 1 0 120px;
            margin-bottom: 10px;

        }

        .lowerNotificationContent {
            background: #d8d8d8;
            border-radius: 3px;
            margin-bottom: 10px;
            padding: 7px;
            display: flex;
            flex-wrap: wrap;
        }

        .lowerNotificationContent > div {
            flex: 1 0 180px;
            margin-bottom: 10px;
        }

        table.customAnalysisTable {
            border: 1px solid #333;
            margin: 2em auto;
        }

        table.customAnalysisTable td {
            border: 1px solid #333;
            padding: 5px;
        }

        table.customAnalysisTable th {
            border: 1px solid #333;
            padding: 8px;
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

        <span id="weldMillStatus"
              style="display: none; position: absolute; right: 25px;top: 128px; font-size: 26px; color: yellow; background: red;border-radius: 3px;">
            Weld Mill Stopped <span id="minsStopped"></span>
        </span>
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
                        <br/>
                        <input class="form-control" id="name" type="text" required>
                    </div>

                    <div class="form-group">
                        <label>Report Description</label>
                        <br/>
                        <textarea class="form-control" id="description" required></textarea>
                    </div>

                    @csrf
                    <div class="form-group">
                        <label>Add to global report list?</label>
                        <br/>
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







    <!-- Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 650px">
            <div class="modal-content" style="height:825px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Tandem Stoppage / Sap Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body notificationModalBody">
                    {{--                    <div class="upperNotificationContent">--}}
                    {{--                        <div>--}}
                    {{--                            <h5 class="notification-title">Coil No.</h5>--}}
                    {{--                            <div class="notification-content" id="stopageCoilNo">--}}

                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div>--}}
                    {{--                            <h5 class="notification-title">Diameter</h5>--}}
                    {{--                            <div class="notification-content" id="stoppageDiameter">--}}

                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div>--}}
                    {{--                            <h5 class="notification-title">Thickness</h5>--}}
                    {{--                            <div class="notification-content" id="stoppageThickness">--}}

                    {{--                            </div>--}}
                    {{--                        </div>--}}

                    {{--                        <div>--}}
                    {{--                            <h5 class="notification-title">StartTime</h5>--}}
                    {{--                            <div class="notification-content" id="stoppageStartTime">--}}

                    {{--                            </div>--}}
                    {{--                        </div>--}}

                    {{--                        <div>--}}
                    {{--                            <h5 class="notification-title">Duration (min)</h5>--}}
                    {{--                            <div class="notification-content" id="stoppageDuration">--}}

                    {{--                            </div>--}}
                    {{--                        </div>--}}

                    {{--                        <div>--}}
                    {{--                            <h5 class="notification-title">Type/Desc</h5>--}}
                    {{--                            <div class="notification-content" id="stoppageTypeDesc">--}}

                    {{--                            </div>--}}
                    {{--                        </div>--}}

                    {{--                        <div>--}}
                    {{--                            <h5 class="notification-title">Area/Desc</h5>--}}
                    {{--                            <div class="notification-content" id="stoppageAreaDesc">--}}

                    {{--                            </div>--}}
                    {{--                        </div>--}}


                    {{--                        <div>--}}
                    {{--                            <h5 class="notification-title">Code/Desc</h5>--}}
                    {{--                            <div class="notification-content" id="stoppageCodeDesc">--}}

                    {{--                            </div>--}}
                    {{--                        </div>--}}


                    {{--                        <div>--}}
                    {{--                            <h5 class="notification-title">Comments</h5>--}}
                    {{--                            <div class="notification-content" id="stoppageComments">--}}

                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

                    <div class="lowerNotificationContent">
                        <div style="flex: 1 0 375px">
                            <h5 class="notification-title">FLOC / Desc</h5>
                            <div class="notification-content" id="notificationFLocDesc">
                            </div>
                        </div>

                        <div>
                            <h5 class="notification-title">Notification No.</h5>
                            <div class="notification-content" id="notificationNo">
                            </div>
                        </div>

                        <div>
                            <h5 class="notification-title">Type / Desc</h5>
                            <div class="notification-content" id="notificationTypeDesc">
                            </div>
                        </div>

                        <div>
                            <h5 class="notification-title">Status / Desc</h5>
                            <div class="notification-content" id="notificationStatusDesc">
                            </div>
                        </div>

                        <div>
                            <h5 class="notification-title">Priority</h5>
                            <div class="notification-content" id="notificationPriority">
                            </div>
                        </div>

                        <div>
                            <h5 class="notification-title">Main WorkCtr / Description</h5>
                            <div class="notification-content" id="notificationWorkCtrDescription">
                            </div>
                        </div>

                        <div>
                            <h5 class="notification-title">Description</h5>
                            <div class="notification-content" id="notificationDescription">
                            </div>
                        </div>

                        <div>
                            <h5 class="notification-title">Linked To PM Order</h5>
                            <div class="notification-content" id="notificationPmOrder">

                            </div>
                        </div>
                    </div>

                    <div style="flex:1; width: 100%;" style="padding: 7px">
                        <h5 class="notification-title">Long Text</h5>
                        <div class="notification-content" id="notificationText"
                             style="background:#fff;height: 300px;overflow-y: scroll; border: 1px solid #8a8a8acc;padding: 5px; border-radius: 3px; margin-top: 5px">
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

            {{--    <script type="text/javascript" src="{{ asset('public/js/pivotJS/subtotal.js')}}"></script>--}}
            <script type="text/javascript"
                    src="{{ asset('public/js/pivot-helpers/UpdatePivotWithSweetAlert.js')}}"></script>
            <script type="text/javascript"
                    src="{{ asset('public/js/pivot-helpers/PivotHelperListeners.js?v=1.4')}}"></script>
            <script type="text/javascript"
                    src="{{ asset('public/js/pivot-helpers/PivotHelperFunctions.js?v=1.4')}}"></script>

            <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
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
                var sapNotifications = <?php echo $sapNotifications; ?>;
                console.log(sapNotifications);
                var pivotData = <?php echo $stoppageData; ?>;
                loadedDataSetLength = pivotData.length;
                var loadedConfig = ""; // Global config that will be changed if saved by user OR loaded from db. This will be the active setting for when refresh occurs.
                var pageNameUrl = "<?php echo basename($_SERVER['REQUEST_URI']); ?>";
                var liveUpdateOn = true; // Global
                //  var loadedDataSetLength = 0; // Global
                var userId = <?php echo Auth::user()->id; ?>; // Get user ID from Auth
                // Make call to PivotJSBuilder;

                /**
                 * Global Static Variables **/
                var dataTableLayoutObj = [
                    {title: "START", data: "START_DATETIME"},
                    {title: "END", data: "END_DATETIME"},
                    {title: "MINS STOPPED", data: "MINS_STOPPED"},
                    {title: "SHIFT DATE", data: "SHIFT_DATE"},
                    {title: "SHIFT", data: "SHIFT_NO"},
                    {title: "TYPE", data: "STOP_STOP_TYPE"},
                    {title: "AREA", data: "STOP_AREA"},
                    {title: "AREA DESCRIPTION", data: "AREA_DESCRIPTION"},
                    {title: "REASON", data: "STCO_STOP_REASON"},
                    {title: "CODE", data: "STOP_STOP_CODE"},
                    {title: "STOP COIL", data: "STOP_COIL"},
                    {title: "SIZE1", data: "PIPE_SIZE1"},
                    {title: "SIZE2", data: "PIPE_SIZE2"},
                    {title: "THICK", data: "PIPE_THICK"},
                    {title: "GRADE", data: "STOP_PIPE_GRADE"},
                    {title: "STOP ADDED EMP NUM", data: "STOP_ADDED_EMPLOYEE_NUM"},
                    {title: "STOP ADDED UPDATE DATE TIME", data: "STOP_ADDED_UPDATE_DATETIME"},
                    {title: "STOP UPDATED EMP NUM", data: "STOP_AMENDED_EMPLOYEE_NUM"},
                    {title: "STOP UPDATED UPDATE DATE TIME", data: "STOP_AMENDED_UPDATE_DATETIME"},
                    {title: "STOP COMMENTS", data: "STOP_COMMENTS"},
                    {
                        title: "SAP NO", data: "SAP_NOTIFICATION_NO",
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html("<a data-sapnotificationno='" + oData.SAP_NOTIFICATION_NO + "' class='notificationLink' href='#" + oData.SAP_NOTIFICATION_NO + "'>" + oData.SAP_NOTIFICATION_NO + "</a>");
                        }
                    }
                ];

                loadedConfig = InitializePivot(["STCO_STOP_REASON"], ["AREA_DESCRIPTION"], pivotData, [], 100);
                RefreshPivotData('/api/GetWeldMillStoppagePivotData', 300000);

                //RefreshPivotWithDateCriteria("/api/GetWeldMillStoppagePivotData");


                function GetWeldMillActiveStatus() {
                    $.ajax({
                        type: 'POST',
                        url: rootUrl + '/api/GetWeldMillIsStoppedData',
                        success: function (response) {
                            var parsedResponse = $.parseJSON(response);
                            if (parsedResponse.weldMillStopped) {

                                $('#weldMillStatus').css('display', 'block');
                                $('#minsStopped').html("(" + parsedResponse.stoppedMins + " Mins)")
                            } else {
                                $('#weldMillStatus').css('display', 'none');
                            }
                        }
                    });
                }

                setInterval(GetWeldMillActiveStatus, 180000);
                GetWeldMillActiveStatus();


                /**
                 * Check if report id has been passed in URL, if so, change the global report select option to load the report requested.
                 */
                $(document).ready(function () {
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
                        url: rootUrl + "/api/GetWeldMillStoppagePivotData",
                        data: {"dtFrom": dtFrom, "dtTo": dtTo},
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


                $('body').delegate(".notificationLink", "click", function (e) {
                    e.preventDefault();
                    var notificationNum = ($(this).data('sapnotificationno') == null ? $(this).data('comment') : $(this).data('sapnotificationno'));
                    var notification = sapNotifications[notificationNum];
                    // var stoppageData = sapNotifications[notificationNum].items[0];

                    $('#notificationFLocDesc').html(notification.FLoc); //+ " / " + globalStoppageData.functionalLocationDescriptionLookup[notification.FLoc]);
                    $('#notificationNo').html(notification.NotificationNum);
                    $('#notificationTypeDesc').html(notification.NotifType); //+ " / " + (notification.NotifType == "M1" ? "Maintenance Request" : "Malfunction Report"));
                    $('#notificationStatusDesc').html(notification.SysStatus);// + " / " + globalStoppageData.systemStatusDescriptionLookup[notification.SysStatus]);
                    $('#notificationPriority').html(notification.Priority);
                    $('#notificationWorkCtrDescription').html(notification.WorkCentre); // + " / " + globalStoppageData.workCentreDescriptionLookup[notification.WorkCentre]);
                    $('#notificationDescription').html(notification.Description);
                    $('#notificationPmOrder').html(notification.OrderNum);
                    $('#notificationText').html(notification.LongNotificationText.replace(/\n/g, "<br />"));
                    $('#notificationModal').modal('toggle');
                });




            </script>



@endsection


