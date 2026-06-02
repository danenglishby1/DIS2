@extends('layouts.app')

@section('pageTitle', 'Pipe Quality Tracker (RHS)')
@section('pageName', 'Pipe Quality Tracker (RHS)')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/plotly.basic.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pivot.css?v=1.2.1')}}"/>

    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">


    <style>
    td {padding: 5px 20px 8px 24px;}
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
    <!-- Content Row
    "TRACK_CODE" => "4513601 "
    "TRACK_CODE_ALT" => "00000000"
    "ROUTING_POS" => "4ALL"
    "ROLL_WEEK" => "2441"
    "PROCESS_ROUTE" => "N"
    "PIPE_THICK" => "12.70"
    "PIPE_SIZE1" => "508.0"
    "PIPE_SIZE2" => "0.0"
    "PIPE_STATUS_CODE" => "  "
    "PIPE_STATUS_CODE_SEVERITY" => "0"
    "PIPE_LENGTH" => "13.097"
    "PIPE_LENGTH_TO_REMOVE" => "0.000"
    "PIPE_GRADE" => "5LX65P2"
    "MILL_LINE" => "1"
    "OHS_LINE" => "0"
    "BLOCK_NO" => "98276"
    "COIL_CAST_NO" => "7T33023 "
    "COIL_COIL_NO" => "23586"
    "COIL_COIL_WEEK" => "45"
    "COIL_COIL_SEQ_NO" => "136"
    "COIL_ADV_WEIGHT" => "29.08"
    "DATETIME_TANDEM" => "2024-11-10 06:45:12.86"
    "PIPE_NO" => "01"
    "T_WEIGHT" => 2.032
    "DEPT" => "UNDEFINED_POS" -->


    <span id="weldMillStatus"
          style="display: none; position: absolute; right: 25px;top: 128px; font-size: 26px; color: yellow; background: red;border-radius: 3px;">
            Weld Mill Stopped <span id="minsStopped"></span>

        </span>






    <h2>Pipe Quality Tracker - RHS</h2>
    <h4 id="dailyNRFT"></h4>


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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        (function update() {


        // $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
        $.ajax({
                type: 'POST',
                url: rootUrl + '/api/getPipeQualityTrackerDataRHS',
                success: function (data) {

                    data = $.parseJSON(data);
                    console.log("got data");
                    let pipeDataByCoilSeqNoJson = data.pipeDataByCoilSeqNo;
                    let pipeQualityLogs = data.pipeQualityLogs;

                    BuildPipeQualityTrackerTable(pipeDataByCoilSeqNoJson,pipeQualityLogs);
                },
                complete: function () {
                    // $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                }
            })
        .then(function() {           // on completion, restart
                setTimeout(update, 999000);  // function refers to itself
            });
        })();


        function BuildPipeQualityTrackerTable(data, pipeQualityLogLookup) {

            console.info(data);
            console.info(pipeQualityLogLookup);

            let tbl = '<table id="pipeQualityTrackerTbl" class="table-light" >' +
                '<thead>' +
                '<th colspan="25">Pipe</th>' +
                '</thead>';


            let totalPipesCreated = 0;
            let totalStatusCodesFound = 0;
            let lastSizeThick = "";

            for (let i = 0; i < data.length; i++) {

                if (lastSizeThick !== data[i]["PIPE_SIZE1"]+data[i]["PIPE_SIZE2"]+data[i]["PIPE_THICK"]){
                    console.log("Different");
                    // tbl+= "<tr>";
                }

                    console.log(i);
                    console.log("Open TR");
                    tbl += "<td>"+data[i]["COIL_COIL_QUALITY"]+"</td><td>"+data[i]["PIPE_SIZE1"]+"</td><td>"+data[i]["PIPE_SIZE2"]+"</td><td>"+data[i]["PIPE_THICK"]+"</td>";
                    tbl += "<td>" + data[i]["TRACK_CODE_ALT"]

                    + "</td>";


                if (lastSizeThick !== data[i]["PIPE_SIZE1"]+data[i]["PIPE_SIZE2"]+data[i]["PIPE_THICK"]){
                    console.log("Different");
                    // tbl+= "</tr>";
                }

                lastSizeThick =data[i]["PIPE_SIZE1"]+data[i]["PIPE_SIZE2"]+data[i]["PIPE_THICK"];

                console.log(lastSizeThick);
            }




            $('#pipeQualityTracker').html(tbl);
            // console.info($('#pipeQualityTrackerTbl tr').eq(1));
            // $('#pipeQualityTrackerTbl tr').eq(1).hide().fadeIn(500);
            // $('#pipeQualityTrackerTbl tr:second').hide().fadeIn('slow');
            console.log("pipesCreated =" + totalPipesCreated );
            console.log("pipesWithStatusCode =" + totalStatusCodesFound );

            $('#dailyNRFT').html('Daily NRFT = ' + ((totalStatusCodesFound / totalPipesCreated ) *100).toFixed(2) + '%');



            $("#myModal").on("shown.bs.modal", function (e) {
                console.log("opened");
                //get data-id attribute of the clicked element
                var pipeno = $(e.relatedTarget).data('pipeno');
                var quality = $(e.relatedTarget).data('quality');
                var grade = $(e.relatedTarget).data('grade');

                console.log(pipeno);
                console.log(quality);
                console.log(grade);

                $('#modalTitle').html("Pipe No : " + pipeno)

                // // This line helps to make sure the checkmark goes back to where it belongs
                // $(window).resize();

                $('#actionButtons').html('<a href="'+rootUrl+'/pipe-quality-logs/show?pipe_no='+pipeno+'"><button type="button" class="btn btn-secondary">View Details</button></a>' +
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

        setInterval(GetWeldMillActiveStatus, 180000);
        GetWeldMillActiveStatus();






    </script>
@endsection
