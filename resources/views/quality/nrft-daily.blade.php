@extends('layouts.app')

@section('pageTitle', 'NRFT Daily')
@section('pageName', 'NRFT Daily')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/plotly.basic.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pivot.css?v=1.2.1')}}"/>

    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <style>


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
    <!-- Content Row -->

    <div class="mb-4">
        <h3 style="display: block">Serious Concerns</h3>
        <hr />
        <div><div id="seriousConcernPivotOutput"></div></div>
    </div>

    <div class="mb-4">
        <h3 style="display: block">1ISP</h3>
        <hr />
        <div><div id="ispPivotOutput"></div></div>
    </div>

    <div class="mb-4">
        <h3 style="display: block">UT</h3>
        <hr />
        <div><div id="utPivotOutput"></div></div>
    </div>



    <div class="mb-4">
        <h3 style="display: block">RHS</h3>
        <hr />
        <div><div id="rhsPivotOutput"></div></div>
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
        /**
         *
         * Global Dynamic Variables **/
        var seriousConcernPivotData = <?php echo $seriousConcernsData; ?>; // Passed in from controller.
        var ispPivotData = <?php echo $isp1Data; ?>; // Passed in from controller.
        var utPivotData = <?php echo $utData; ?>; // Passed in from controller.
        var rhsPivotData = <?php echo $rhsDefectData; ?>; // Passed in from controller.
        //  var loadedDataSetLength = 0; // Global
        var userId = <?php echo Auth::user()->id; ?>; // Get user ID from Auth

        var utils = $.pivotUtilities;
        var renderers = $.extend($.pivotUtilities.renderers,
            $.pivotUtilities.plotly_renderers,
            $.pivotUtilities.subtotal_renderers);
        var dataClass = $.pivotUtilities.SubtotalPivotData;

        var loadedConfig = {
            dataClass: dataClass,
            rows: ["REASON"],
            cols: ["DAY_NAME"],
            hiddenAttributes: [],
            // "menuLimit": menuLimit,
            //aggregator: Count(["tip", "total_bill"]),
            rendererName: "Table",
            renderers: renderers
        };

        $("#seriousConcernPivotOutput").pivot(seriousConcernPivotData, loadedConfig); // render pivot.
        // END Configure and load intial pivot.


        // END Configure and load intial pivot.

        var loadedConfig = {
            dataClass: dataClass,
            rows: ["PIPE_STATUS_CODE"],
            cols: ["DAY_NAME"],
            hiddenAttributes: [],
            // "menuLimit": menuLimit,
            //aggregator: Count(["tip", "total_bill"]),
            rendererName: "Table",
            renderers: renderers
        };

        $("#ispPivotOutput").pivot(ispPivotData, loadedConfig); // render pivot.


        // END Configure and load intial pivot.

        var loadedConfig = {
            dataClass: dataClass,
            rows: ["PIPE_STATUS_CODE"],
            cols: ["DAY_NAME"],
            hiddenAttributes: [],
            // "menuLimit": menuLimit,
            //aggregator: Count(["tip", "total_bill"]),
            rendererName: "Table",
            renderers: renderers
        };

        $("#utPivotOutput").pivot(utPivotData, loadedConfig); // render pivot.



        var loadedConfig = {
            dataClass: dataClass,
            rows: ["CONDITION_CODE_DESC"],
            cols: ["DAY_NAME"],
            hiddenAttributes: [],
            // "menuLimit": menuLimit,
            //aggregator: Count(["tip", "total_bill"]),
            rendererName: "Table",
            renderers: renderers
        };

        $("#rhsPivotOutput").pivot(rhsPivotData, loadedConfig); // render pivot.



    </script>
@endsection
