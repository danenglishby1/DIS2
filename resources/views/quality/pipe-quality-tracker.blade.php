@extends('layouts.app')

@section('pageTitle', 'Pipe Quality Tracker (Weld Mill)')
@section('pageName', 'Pipe Quality Tracker (Weld Mill)')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/plotly.basic.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pivot.css?v=1.2.1')}}"/>

    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">


    <style>
     #pipeQualityTrackerTbl td {padding: 5px 20px 8px 24px;}
     .pipeNoTd {background: #77ff7b;}
    </style>
@endsection
@section('content')
    <div class="simpleflex justify-content-center">
        <div class="btn-flex mt-2 text-center">
            @section('overrideStartEndDate')
                start = moment().startOf('today');
                end = moment().endOf('today');

                window.dtFrom = start.format('Y-MM-DD 00:00:01');
                window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.
            @endsection
            @section('dateRangePickerOnApplyCallback')

                $.ajax({
                type: 'POST',
                data: {'dtFrom': dtFrom, 'dtTo': dtTo},
                url: rootUrl + '/api/getPipeQualityTrackerData',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {
           //     console.log(data);

                window.dtFrom = dtFrom;
                window.dtTo = dtTo;
                    liveUpdateOn = false;
               //     console.log("got data");
                    let pipeDataByCoilSeqNoJson = data.pipeDataByCoilSeqNo;
                    let pipeQualityLogs = data.pipeQualityLogs;

                    BuildPipeQualityTrackerTable(pipeDataByCoilSeqNoJson,pipeQualityLogs, false);


                },
                complete: function () {
                $('.ajax-loader').css('display', 'none');
                }
                });

            @endsection
            <div class="filters">
                @include('layouts.templates.daterangepicker')

            </div>
        </div>
    </div>
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


    <span id="weldMillStatus"
          style="display: none; position: absolute; right: 25px;top: 128px; font-size: 26px; color: yellow; background: red;border-radius: 3px;">
            Weld Mill Stopped <span id="minsStopped"></span>

        </span>

    <div style="float:right">
        <div>
            <div>Add Log By Section No: </div><input id="logBySectionNo" type="text" placeholder="RWWNNNN"/> <button id="addLogBySectionNo">Add</button>
        </div>
        <div>
            <div>Add Log By Pipe No: </div><input id="logByPipeNo" type="text" placeholder="WWCCCNN"/> <button id="addLogByPipeNo">Add</button>
        </div>
        <div>
            Filter by Process Route

            <select id="processRoutes">
                <option value="B">B</option>
                <option value="F">F</option>
                <option value="H">H</option>
                <option value="L">L</option>
                <option value="N">N</option>
                <option value="O">O</option>
                <option value="P">P</option>
                <option value="Q">Q</option>
                <option value="R">R</option>
                <option value="T">X</option>

            </select>
        </div>

    </div>
    <h2>Pipe Quality Tracker - Weld Mill</h2>
    <h4 id="dailyNRFT"></h4>



    <div>
        <h5>Key</h5>
        <div style="display: flex";>
            <div style="background: #fb593f;padding:10px;margin:2px;">SC DG</div>
            <div style="background: #b96456;padding:10px;margin:2px;">CONFIRMED WELD FAULT</div>
            <div style="background: #ffc761;padding:10px;margin:2px;">NA XX</div>
            <div style="background: #3ec9ff;padding:10px;margin:2px;">HOLD FOR FURTHER NDT / INSPECTION</div>
            <div style="background: #ffff60;padding:10px;margin:2px;">CONFIRMED STEEL FAULT</div>
            <div style="background: #c1c1c1;padding:10px;margin:2px;">INLINE INDICATION</div>
            <div style="background: #71cf74;padding:10px;margin:2px;">INSPECTED</div>
            <div style="background: #62b365;padding:10px;margin:2px;">1/10 CHECKS</div>
            <div style="background: #4ba14d;padding:10px;margin:2px;">OVALITY CHECKS</div>

        </div>
    </div>



    <div id="pipeQualityTracker">

    </div>




    <!-- Button trigger modal -->
{{--    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">--}}
{{--        Open Address Form--}}
{{--    </button>--}}

    <!-- Modal -->
    <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
{{--                    <div class="modal-body">--}}

{{--                    </div>--}}
                    <div class="modal-footer" id="actionButtons">

                    </div>
                </form>
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

    <script>

        let updateRealTimeOnOff = true;
        let userId = {{$userId}};
        let pipeQualityLogs = "";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let liveUpdateOn = true;

        (function update() {

            if (updateRealTimeOnOff) {

        // $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
        $.ajax({
                type: 'POST',
                url: rootUrl + '/api/getPipeQualityTrackerData',
                success: function (data) {

                    data = $.parseJSON(data);
            //        console.log("got data");
                    let pipeDataByCoilSeqNoJson = data.pipeDataByCoilSeqNo;
                    pipeQualityLogs = data.pipeQualityLogs;

                    BuildPipeQualityTrackerTable(pipeDataByCoilSeqNoJson,pipeQualityLogs, true);
                },
                complete: function () {
                    // $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                }
            })
        .then(function() {           // on completion, restart
                setTimeout(update, 45000);  // function refers to itself
            });



        }
            })

            ();

        function BuildPipeQualityTrackerTable(data, pipeQualityLogLookup, updateOnOff) {
            updateRealTimeOnOff = updateOnOff;
            console.log("tracker update on/off " + updateRealTimeOnOff)

         //   console.log("pipeQualLogsLookup", pipeQualityLogLookup);
         //   console.log("data", data);
            let tbl = '<table id="pipeQualityTrackerTbl" class="table-light" >' +
                '<thead>' +
                '<th>Coil Week</th>' +
                '<th>Coil Seq</th>' +
                '<th>Qual</th>' +
                '<th>Grade</th>' +
                '<th>S1</th>' +
                '<th>S2</th>' +
                '<th>THICK</th>' +
                '<th>PR</th>' +
                '<th></th>' +
                '<th colspan="50">Pipe</th>' +
                '</thead>';

            const reversedTrackfData = Object.keys(data).reverse();
         //   console.log("reversedTrackfData", reversedTrackfData);
            let totalPipesCreated = 0;

            Object.keys(reversedTrackfData).forEach(function (key) {
        //    console.log(reversedTrackfData[key])
                // console.log(data);
                tbl += '<tr>';
                tbl += '<td>' + reversedTrackfData[key].substring(0,2) +  '</td>'; // split up.
                tbl += '<td>' + reversedTrackfData[key].substring(2) +  '</td>'; // split up.
                tbl += '<td>'+data[reversedTrackfData[key]][0]["COIL_COIL_QUALITY"]+'</td>';
                tbl += '<td>'+data[reversedTrackfData[key]][0]["PIPE_GRADE"]+'</td>';
                tbl += '<td>'+data[reversedTrackfData[key]][0]["PIPE_SIZE1"]+'</td>';
                tbl += '<td>'+data[reversedTrackfData[key]][0]["PIPE_SIZE2"]+'</td>';
                tbl += '<td>'+data[reversedTrackfData[key]][0]["PIPE_THICK"]+'</td>';
                tbl += '<td class="processRoute">'+data[reversedTrackfData[key]][0]["PROCESS_ROUTE"]+'</td>';
                tbl += '<td></td>';

                                   // data["coil"]["pipes".....]
                for (let i = 0; i < data[reversedTrackfData[key]].length; i++) {

                    //
                    // *************
                    // Count status codes to work out NRFT %
                    if (data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] !== "  ") {
                        if (data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] !== "TP"
                            && data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] !== "NE"
                            && data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] !== "SC") {

                        }

                    }
                    let nonSeriousInd = "";
                    let slabEdgeInd = "";
                    let edgeLamInd = "";
                    let visibleLamsInd = "";
                    let laminationInd = "";
                    let edgeLamToSurfaceInd = "";
                    let edgeLamToSubSurfaceInd = "";
                    let concessionCoilInd = "";
                    let entrappedMaterialInd = "";
                    let damagedEdgeInd = "";
                    let coldWeldInd = "";
                    let openSeamInd = "";
                    let inspectedFlag = "";
                    let oneInTenChecks = "";
                    let ovality = "";

                    let isPipeQualityLog = (pipeQualityLogLookup[reversedTrackfData[key]+''+data[reversedTrackfData[key]][i]["PIPE_NO"]] !== undefined);

                    // console.log(isPipeQualityLog);
                    // console.log(data[reversedTrackfData[key]][i]["PIPE_NO"]);
                    // console.log(pipeQualityLogLookup[reversedTrackfData[key]]);

                    if(isPipeQualityLog) {
                        // console.log("isPipeQualityLog", isPipeQualityLog);
                        let lookupPipe = data[reversedTrackfData[key]][i]["TRACK_CODE"].trim().substring(0, 7);
              //          console.log(data[reversedTrackfData[key]][i]["TRACK_CODE"]);
              //          console.log(lookupPipe);
                        if (pipeQualityLogs[lookupPipe] !== undefined);
                        {
                       //     console.log(pipeQualityLogs[lookupPipe] !== undefined);
                            nonSeriousInd = pipeQualityLogs[lookupPipe].fault_diagnosis == "INLINE INDICATION";
                            slabEdgeInd = pipeQualityLogs[lookupPipe].fault_diagnosis == "SLAB EDGE";
                            edgeLamInd = pipeQualityLogs[lookupPipe].fault_diagnosis == "EDGE LAM";
                            visibleLamsInd = pipeQualityLogs[lookupPipe].fault_diagnosis == "VISIBLE LAMS";
                            laminationInd = pipeQualityLogs[lookupPipe].fault_diagnosis == "LAMINATION";
                            edgeLamToSurfaceInd = pipeQualityLogs[lookupPipe].fault_diagnosis == "EDGE LAM TO SURFACE";
                            edgeLamToSubSurfaceInd = pipeQualityLogs[lookupPipe].fault_diagnosis == "EDGE LAM SUBSURFACE";
                            concessionCoilInd = pipeQualityLogs[lookupPipe].fault_diagnosis == "CONCESSION COIL";
                            entrappedMaterialInd = pipeQualityLogs[lookupPipe].fault_diagnosis == "ENTRAPPED MATERIAL";
                            damagedEdgeInd = pipeQualityLogs[lookupPipe].fault_diagnosis == "DAMAGED EDGE";
                            coldWeldInd = pipeQualityLogs[lookupPipe].fault_diagnosis == "COLD WELD";
                            openSeamInd = pipeQualityLogs[lookupPipe].fault_diagnosis == "OPEN SEAM";
                            inspectedFlag = pipeQualityLogs[lookupPipe].inspected == "Y";
                            oneInTenChecks = pipeQualityLogs[lookupPipe].fault_diagnosis == "1/10 CHECKS";
                            ovality = pipeQualityLogs[lookupPipe].fault_diagnosis == "OVALITY CHECKS";
                            console.log("inspected flag ", pipeQualityLogs[lookupPipe].inspected == "Y");
                        }
                    }
                    //console.log("routingPos", data[reversedTrackfData[key]][i]["ROUTING_POS"]);

                    /**
                     * Work out cell background colour
                     *
                     */
                    let backgroundColor = "";

                    if (inspectedFlag == true) {
                        backgroundColor = "#71cf74";
                    }

                    if (oneInTenChecks == true) {
                        backgroundColor = "#62b365";
                    }
                    if (ovality == true) {
                        backgroundColor = "#4ba14d";
                    }


                    if (nonSeriousInd == true) {
                        backgroundColor = "#c1c1c1";
                    }

                    if (data[reversedTrackfData[key]][i]["STATUS_DETAIL_CODE"] == "WR")
                    {
                        backgroundColor = "#b96456";
                    }

                    if (data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] == "CL" )
                    {
                        backgroundColor = "#77ff7b";
                    }

                    if (data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] == "ID" ||
                        data[reversedTrackfData[key]][i]["STATUS_DETAIL_CODE"] == "NT" ||
                        data[reversedTrackfData[key]][i]["STATUS_DETAIL_CODE"] == "GOS" ||
                        data[reversedTrackfData[key]][i]["STATUS_DETAIL_CODE"] == "IDH")
                    {
                        backgroundColor = "#e23ffb";
                    }


                    if (data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] == "SC" ||
                        data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] == "DG" )
                    {
                        backgroundColor = "#fb593f";
                    }

                    if (edgeLamInd || slabEdgeInd || visibleLamsInd || laminationInd || edgeLamToSurfaceInd ||
                        edgeLamToSubSurfaceInd || concessionCoilInd || data[reversedTrackfData[key]][i]["STATUS_DETAIL_CODE"] == "SE ") {
                        backgroundColor = "#ffff60";
                    }

                    if (entrappedMaterialInd || coldWeldInd || openSeamInd || damagedEdgeInd)
                    {
                        backgroundColor = "#b96456";
                    }

                    if (data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] == "NA" ||
                        data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] == "XX")
                    {
                        backgroundColor = "#ffc761";
                    }


                    if (data[reversedTrackfData[key]][i]["ROUTING_POS"] == "CSUS" ||
                        data[reversedTrackfData[key]][i]["ROUTING_POS"] == "WSUS" )
                    {
                        backgroundColor = "#3ec9ff";
                    }

                    if (data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] == "UT" ||
                        data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] == "HP" ||
                        data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] == "S") {
                        backgroundColor = "#3ec9ff";
                    }



                    // console.log("inline ", nonSeriousInd);
                    ///*****************

                    totalPipesCreated++;
                     tbl += '<td style="background: '+backgroundColor+'" class="'
                         +reversedTrackfData[key]+''+data[reversedTrackfData[key]][i]["PIPE_NO"]+' pipeNoTd" ' +

                         //***
                         //
                         // PIPE QUALITY LOGS DATA VIEWER.
                         // VIEW DETAILS FROM ADD LOG PAGE.
                         // PROCESS ROUTE
                         // 1CRP LOSSES
                         // SPLIT PIPE ISSUE 11TH
                         //**/
                         '>  '  + // + data[reversedTrackfData[key]][i]["ROUTING_POS"]
                         '<a  data-pipeno="'+reversedTrackfData[key]+''+data[reversedTrackfData[key]][i]["PIPE_NO"]+'" ' +
                     'data-quality="'+data[reversedTrackfData[key]][i]["COIL_COIL_QUALITY"]+'" ' +
                     'data-grade="'+data[reversedTrackfData[key]][i]["PIPE_GRADE"] +'" ' +
                     'data-s1="'+data[reversedTrackfData[key]][i]["PIPE_SIZE1"] +'" ' +
                     'data-s2="'+data[reversedTrackfData[key]][i]["PIPE_SIZE2"] +'" ' +
                     'data-thickness="'+data[reversedTrackfData[key]][i]["PIPE_THICK"] +'" ' +
                     'data-pr="'+data[reversedTrackfData[key]][i]["PROCESS_ROUTE"] +'" ' +
                     'data-ltr="'+data[reversedTrackfData[key]][i]["PIPE_LENGTH_TO_REMOVE"] +'" ' +
                     'data-routingpos="'+data[reversedTrackfData[key]][i]["ROUTING_POS"] +'" ' +
                     'data-pipestatuscode="'+data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] +'" ' +
                     'data-statusdetailcode="'+data[reversedTrackfData[key]][i]["STATUS_DETAIL_CODE"] +'" ' +
                     'data-castno="'+data[reversedTrackfData[key]][i]["COIL_CAST_NO"] +'" ' +
                     'data-supplier="'+data[reversedTrackfData[key]][i]["SUPPLIER_CODE"] +'" ' +
                     'data-pipelength="'+data[reversedTrackfData[key]][i]["PIPE_LENGTH"] +'" ' +
                     'data-weight="'+data[reversedTrackfData[key]][i]["T_WEIGHT"] +'" ' +
                       'style="color:#212529;'+(isPipeQualityLog ? "font-weight:bold;text-decoration:underline;" : "")+'" data-toggle="modal" data-target="#myModal" href='+rootUrl+'/pipe-quality-logs/create?pipe_no='+reversedTrackfData[key]+''+data[reversedTrackfData[key]][i]["PIPE_NO"]+ '&quality=' + data[reversedTrackfData[key]][i]["COIL_COIL_QUALITY"] + '&grade=' + data[reversedTrackfData[key]][i]["PIPE_GRADE"] + '> '+
                         data[reversedTrackfData[key]][i]["PIPE_NO"]+ "  " + data[reversedTrackfData[key]][i]["PIPE_STATUS_CODE"] + " " + data[reversedTrackfData[key]][i]["STATUS_DETAIL_CODE"]
                         '</a>' +
                          '</td>';

                }

            });

            $('#pipeQualityTracker').html(tbl);
    //        console.info($('#pipeQualityTrackerTbl tr').eq(1));
            $('#pipeQualityTrackerTbl tr').eq(1).hide().fadeIn(500);
            // $('#pipeQualityTrackerTbl tr:second').hide().fadeIn('slow');
       //     console.log("pipesCreated =" + totalPipesCreated );
            // $('#dailyNRFT').html('Daily NRFT = ' + ((totalStatusCodesFound / totalPipesCreated ) *100).toFixed(2) + '%');
            // $('#dailyNRFT').html('Daily NRFT = 99%');
            $("#myModal").on("shown.bs.modal", function (e) {
       //         console.log("opened");
                //get data-id attribute of the clicked element
                var pipeno = $(e.relatedTarget).data('pipeno').toString();
                var quality = $(e.relatedTarget).data('quality');
                var grade = $(e.relatedTarget).data('grade');
                var s1 = $(e.relatedTarget).data('s1');
                var s2 = $(e.relatedTarget).data('s2');
                var thick = $(e.relatedTarget).data('thickness');
                var pr = $(e.relatedTarget).data('pr');
                var ltr = $(e.relatedTarget).data('ltr');
                var routingPos = $(e.relatedTarget).data('routingpos');
                var pipeStatusCode = $(e.relatedTarget).data('pipestatuscode');
                var statusDetailCode = $(e.relatedTarget).data('statusdetailcode');
                var castNo = $(e.relatedTarget).data('castno');
                var supplier = $(e.relatedTarget).data('supplier');
                var weight = $(e.relatedTarget).data('weight');


                /**
                 var ltr = $(e.relatedTarget).data('ltr');
                 var routingPos = $(e.relatedTarget).data('routingpos');
                 var pioeStatusCode = $(e.relatedTarget).data('pipestatuscode');
                 var statusDetailCode = $(e.relatedTarget).data('statusdetailcode');
                 var castNo = $(e.relatedTarget).data('castno');
                 var supplier = $(e.relatedTarget).data('supplier');
                 var weight = $(e.relatedTarget).data('weight');
                 *
                 */

                console.log(pipeno);
                console.log(quality);
                console.log(grade);
                console.log(s1);
                console.log(s2);
                console.log(thick);
                console.log(pr);
                console.log(ltr);
                console.log(routingPos);
                console.log(pipeStatusCode);
                console.log(statusDetailCode);
                console.log(castNo);
                console.log(supplier);
                console.log(weight);


                $('#modalTitle').html("Pipe No : <span class='pipeNo'>" + pipeno +"</span>" +
                    "<span> Quality:</span>  <span class='quality'>" + quality + "</span>" +
                    "<span> Grade:</span>  <span class='grade'>" + grade + "</span> <br />" +
                    "<span> S1:</span>  <span class='s1'>" + s1 + "</span>" +
                    "<span> S2:</span>  <span class='s2'>" + s2 + "</span>" +
                    "<span> Thick:</span>  <span class='thick'>" + thick + "</span>" +
                    "<span> PR:</span>  <span class='pr'>" + pr + "</span>" +
                    "<span> Cast:</span>  <span class='castNo'>" + castNo + "</span>"

                );

                // // This line helps to make sure the checkmark goes back to where it belongs
                // $(window).resize();

                $('#actionButtons').html('<a href="#pipe_no='+pipeno+'"><button type="button" id="addInspectedFlagButton" class="btn" style="background-color: #71cf74;color:#000">Inspected</button></a>' +
                    '<a href="#pipe_no='+pipeno+'"><button type="button" id="addNonSeriousIndicationButton" class="btn btn-warning">Inline Indication</button></a>' +
                    '<a href="'+rootUrl+'/pipe-quality-logs/show?pipe_no='+pipeno+'"><button type="button" class="btn btn-secondary">View Details</button></a>' +
                    '<a href="'+rootUrl+'/pipe-quality-logs/create?pipe_no='+pipeno+'&quality='+quality+'&grade='+grade+'"><button type="button" class="btn btn-primary">Add Details</button></a>');
            });

            $("#myModal").on("hide.bs.modal", function() {

            });

        }

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

        setInterval(GetWeldMillActiveStatus, 100000);
        GetWeldMillActiveStatus();


        $( "#actionButtons" ).delegate( "#addNonSeriousIndicationButton", "click", function() {
            console.log("Inline Incident Clicked");
            let modalTitleSelector = $(this).parent().parent().parent().find('.modal-header').find('.modal-title');
            let pipeNumber = modalTitleSelector.find('.pipeNo').html();
            let quality = modalTitleSelector.find('.quality').html();
            let grade = modalTitleSelector.find('.grade').html();
            let s1 = modalTitleSelector.find('.s1').html();
            let s2 = modalTitleSelector.find('.s2').html();
            let thick = modalTitleSelector.find('.thick').html();
            let pr = modalTitleSelector.find('.pr').html();
            let castNo = modalTitleSelector.find('.castNo').html();
            console.log(pipeNumber);
            console.log(quality);
            console.log(grade);
            console.log(s1);
            console.log(s2);
            console.log(thick);
            console.log(pr);
            console.log("cast", castNo);

            $.ajax({
                type: 'POST',
                data: {"userId" : userId,
                "response" : "",
                "pipe_no" : pipeNumber,
                "position" : " ",
                "S1" : s1,
                "S2" : s2,
                "thickness" : thick,
                "PR" : pr,
                "quality" : quality,
                "grade" : grade,
                "status" : " ",
                "area" : "Weld Mill",
                "cast_no" : castNo,
                "comments" : " ",
                "fault_diagnosis" : "INLINE INDICATION",

                },
                url: rootUrl + '/api/setPipeQualityNonSerious',
                success: function (response) {
           //     console.log(response);

                if (response) {
                    $('.'+pipeNumber).css('background', '#bdbdbd');


                    $('#myModal').modal('toggle');
                }

                }
            });
        });
        $( "#actionButtons" ).delegate( "#addInspectedFlagButton", "click", function() {
            console.log("Inspected Button Clicked");
            let modalTitleSelector = $(this).parent().parent().parent().find('.modal-header').find('.modal-title');
            let pipeNumber = modalTitleSelector.find('.pipeNo').html();
            let quality = modalTitleSelector.find('.quality').html();
            let grade = modalTitleSelector.find('.grade').html();
            let s1 = modalTitleSelector.find('.s1').html();
            let s2 = modalTitleSelector.find('.s2').html();
            let thick = modalTitleSelector.find('.thick').html();
            let pr = modalTitleSelector.find('.pr').html();
            let castNo = modalTitleSelector.find('.castNo').html();
            console.log(pipeNumber);
            console.log(quality);
            console.log(grade);
            console.log(s1);
            console.log(s2);
            console.log(thick);
            console.log(pr);

            $.ajax({
                type: 'POST',
                data: {"userId" : userId,
                    "response" : "",
                    "pipe_no" : pipeNumber,
                    "cast_no" : castNo,
                    "position" : " ",
                    "S1" : s1,
                    "S2" : s2,
                    "thickness" : thick,
                    "PR" : pr,
                    "quality" : quality,
                    "grade" : grade,
                    "status" : " ",
                    "area" : "Weld Mill",
                    "comments" : " ",
                    "fault_diagnosis" : "",
                },
                url: rootUrl + '/api/setPipeQualityInspectedFlag?XDEBUG_TRIGGER=1',
                success: function (response) {
             //       console.log(response);

                    if (response) {
                        console.log($('.'+pipeNumber).css('background', '#71cf74'));
                        $('#myModal').modal('toggle');
                    }

                }
            });
        });
        //addInspectedFlagButton

        $( "#addLogBySectionNo" ).click(function (){
                let sectionNo = $('#logBySectionNo').val();
                console.log(sectionNo);
                window.location.href = rootUrl+'/pipe-quality-logs/create?section_no='+sectionNo;

        });

        $( "#addLogByPipeNo" ).click(function (){
            let pipeNo = $('#logByPipeNo').val();
            console.log(pipeNo);
            window.location.href = rootUrl+'/pipe-quality-logs/create?pipe_no='+pipeNo;

        });

        $("#processRoutes").on("change", function () {

            let selected = $(this).val().trim();   // e.g. "15"
            console.log("Selected:", selected);

            $('table tbody tr').each(function () {

                // find ANY td whose text matches the selected value
                let match = $(this).find('td').filter(function () {
                    return $(this).text().trim() === selected;
                }).length > 0;

                $(this).toggle(match || selected === "");
            });

        });

    </script>
@endsection
