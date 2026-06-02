@extends('layouts.app')

@section('pageTitle', 'CoilPipe Tracking')
@section('pageName', 'CoilPipe Tracking')
@section('millTrackingActiveLink', 'active activeUnderline')
@section('css')

    <script type="text/javascript" src="{{ asset('public/js/pivotJS/plotly.basic.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pivot.css')}}"/>
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
        <div class="btn-flex mt-2 text-center">
            @include('layouts.partial.update-date-buttons')
        </div>

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
        <button class="btn btn-primary" id="save">Save</button>
        <button class="btn btn-primary" id="restore">Restore</button>
    </div>
    <div id="output"></div>




@endsection
@section('functionalScripts')

    <script type="text/javascript" src="{{ asset('public/js/pivotJS/cookie.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/jqueryUI.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/pivot.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/plotly-renderers.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initial Load
        var liveUpdateOn = true; // Global
        var loadedDataSetLength = 0; // Global
        var loadedConfig;  // Globals

        var pivotData = <?php echo $rawData; ?>; // Passed in from controller.
        loadedDataSetLength = pivotData.length;
        // Make call to PivotJSBuilder;

        $(function () {
            var utils = $.pivotUtilities;
            var renderers = $.extend($.pivotUtilities.renderers,
                $.pivotUtilities.plotly_renderers);

            var config = {
                rows: ["ROUTING_POS"],
                cols: ["MILL_LINE"],
                //   aggregator: Count(["tip", "total_bill"]),
                // renderer: heatmap
                rendererName: "Table",
                renderers: $.extend(
                    $.pivotUtilities.renderers,
                    $.pivotUtilities.plotly_renderers
                )
            };
            loadedConfig = config;
            $("#output").pivotUI(
                pivotData, config);


            $("#save").on("click", function () {
                var config = $("#output").data("pivotUIOptions");
                var config_copy = JSON.parse(JSON.stringify(config));
                //delete some values which will not serialize to JSON
                delete config_copy["aggregators"];
                delete config_copy["renderers"];
                $.cookie("pivotConfig", JSON.stringify(config_copy));
            });

            $("#restore").on("click", function () {
                $("#output").pivotUI(pivotData, JSON.parse($.cookie("pivotConfig")), true);
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Set interval to update charts with new data.
            setInterval(function () {
                if (liveUpdateOn) {
                    $.ajax({
                        type: "POST",
                        url: rootUrl + "/api/GetCoilPipePivotData",
                        data: {"dateCommand": "today"},
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            if (data.length > loadedDataSetLength) {
                                console.log("is New Data");

                                if ($.cookie("pivotConfig") !== undefined) {
                                    $("#output").pivotUI(
                                        data, JSON.parse($.cookie("pivotConfig")), true);
                                } else {
                                    $("#output").pivotUI(
                                        data, loadedConfig);
                                }
                                //Update loaded data length
                                loadedDataSetLength = data.length;
                            }
                        }
                    });
                }
            }, 30000);
        });


        /**
         * listeners and ajax call to methods when date buttons are clicked.
         */
        $('.dateTimeControlButton').on('click', function () {
            liveUpdateOn = false;
            $('#pivotUpdateSwitch').prop('checked', false);
            var dateCommand = $(this).data('filtercommand');

            if (dateCommand == "today") {
                liveUpdateOn = true;
                $('#pivotUpdateSwitch').prop('checked', true);
            }

            console.log(dateCommand);
            // Make call to pivotBuilder, passing in filterCommand as param.
            $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
            $.ajax({
                type: "POST",
                url: rootUrl + "/api/GetCoilPipePivotData",
                data: {"dateCommand": dateCommand},
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if ($.cookie("pivotConfig") !== undefined) {
                        $("#output").pivotUI(
                            data, JSON.parse($.cookie("pivotConfig")), true);
                    } else {
                        $("#output").pivotUI(
                            data, loadedConfig);
                    }
                    //Update loaded data length
                    loadedDataSetLength = data.length;
                },
                complete: function () {
                    $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                }
            });

        });

        //Listen for manual toggle on updating switch.

        $('#pivotUpdateSwitch').on('change', function () {
            liveUpdateOn = $('#pivotUpdateSwitch').prop('checked');
            console.log("Updating Toggle manually changed to - " + liveUpdateOn)
        });


    </script>
@endsection
