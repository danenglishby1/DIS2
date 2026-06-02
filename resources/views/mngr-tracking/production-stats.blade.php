@extends('layouts.app')

@section('pageTitle', 'Prod Stats')
@section('pageName', 'Prod Stats')
@section('weldMillActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <style>
        select {
            max-width: 500px !important;
        }
    </style>
@endsection
@section('content')
    <div class="simpleflex justify-content-center">
        <div class="btn-flex mt-2 text-center">
            @section('overrideStartEndDate')
                start = moment().startOf('week');
                end = moment().endOf('week');

                window.dtFrom = start.format('Y-MM-DD 00:00:01');
                window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.
            @endsection
            @section('dateRangePickerOnApplyCallback')

                $.ajax({
                type: 'POST',
                data: {'dtFrom': dtFrom, 'dtTo': dtTo},
                url: rootUrl + '/api/GetProductionStats',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {
                console.log(data);

                window.dtFrom = dtFrom;
                window.dtTo = dtTo;

                    UpdateStatsTable(data.productionStats);

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

    <div>
        <div class="card-body">
            <h5>Weld Mill Stats</h5>
            <div id="casingStats">
                <table class="table table-bordered table-reduced-padding" id="weldMillStatsTable">
                    <thead class="thead-light">
                    <th>Weld Mill</th>
                    <th>Tons</th>
                    <th>Metres</th>
                    <th>Pipes</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

        <div>
            <div class="card-body">
                <h5>Casing Stats</h5>
                <div id="casingStats">
                    <table class="table table-bordered table-reduced-padding" id="casingStatsTable">
                        <thead class="thead-light">
                        <th>Casing</th>
                        <th>Tons</th>
                        <th>Metres</th>
                        <th>Pipes</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <div>
        <div class="card-body">
            <h5>Production Services Stats</h5>
            <div id="productionServicesStats">
                <table class="table table-bordered table-reduced-padding" id="productionServicesStatsTable">
                    <thead class="thead-light">
                    <th>Production Services</th>
                    <th>Tons</th>
                    <th>Metres</th>
                    <th>Pipes</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="card-body">
            <h5>RHS Stats</h5>
            <div id="rhsStats">
                <table class="table table-bordered table-reduced-padding" id="rhsStatsTable">
                    <thead class="thead-light">
                    <th>RHS Stats</th>
                    <th>Tons</th>
                    <th>Metres</th>
                    <th>Pipes</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="card-body">
            <h5>Rounds Finishing Stats</h5>
            <div id="finishingStatsTable">
                <table class="table table-bordered table-reduced-padding" id="productionServicesStatsTable">
                    <thead class="thead-light">
                    <th>RF Stats</th>
                    <th>Tons</th>
                    <th>Metres</th>
                    <th>Pipes</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="card-body">
            <h5>Despatch Stats</h5>
            <div id="despatchServicesStats">
                <table class="table table-bordered table-reduced-padding" id="despatchStatsTable">
                    <thead class="thead-light">
                    <th>Despatch Stats</th>
                    <th>Tons</th>
                    <th>Metres</th>
                    <th>Pipes</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="card-body">
            <h5>Slitter Stats</h5>
            <div id="slitterStats">

            </div>
        </div>
    </div>

        @endsection
        @section('functionalScripts')
            <script>
                /**
                 * Add ajax header for CSRF Token
                 * */
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                /**
                 * Datatable intialization and config.
                 */

                function UpdateStatsTable(d) {

                    console.info(d);


                    let tbl = "<tr><td colspan='5' style='text-align: center; font-weight: bold'>PRODUCTION</td></tr>";
                    tbl += "<tr><td>1DCO</td><td>" + (d.dco1Stats.tons == undefined ? 0 : d.dco1Stats.tons) + "</td><td>" + (d.dco1Stats.metres == undefined ? 0 : d.dco1Stats.metres) + "</td><td>" + (d.dco1Stats.pipes == undefined ? 0 : d.dco1Stats.pipes) + "</td></tr>";
                    $('#weldMillStatsTable').find('tbody').html(tbl);



                    tbl = "<tr><td colspan='5' style='text-align: center; font-weight: bold'>PRODUCTION</td></tr>";
                    tbl += "<tr><td>WSAW</td><td>" + (d.wsawStats.tons == undefined ? 0 : d.wsawStats.tons) + "</td><td>" + (d.wsawStats.metres == undefined ? 0 : d.wsawStats.metres) + "</td><td>" + (d.wsawStats.pipes == undefined ? 0 : d.wsawStats.pipes) + "</td></tr>";
                    tbl += "<tr><td>WSUS</td><td>" + (d.wsusStats.tons == undefined ? 0 : d.wsusStats.tons) + "</td><td>" + (d.wsusStats.metres == undefined ? 0 : d.wsusStats.metres) + "</td><td>" + (d.wsusStats.pipes == undefined ? 0 : d.wsusStats.pipes) + "</td></tr>";
                    $('#productionServicesStatsTable').find('tbody').html(tbl);

                    tbl = "<tr><td colspan='5' style='text-align: center; font-weight: bold'>PRODUCTION</td></tr>";
                    tbl += "<tr><td>2CLG</td><td>" + (d.clg2Stats.tons == undefined ? 0 : d.clg2Stats.tons) + "</td><td>" + (d.clg2Stats.metres == undefined ? 0 : d.clg2Stats.metres) + "</td><td>" + (d.clg2Stats.pipes == undefined ? 0 : d.clg2Stats.pipes) + "</td></tr>";
                    $('#casingStatsTable').find('tbody').html(tbl);

                    tbl = "<tr><td colspan='5' style='text-align: center; font-weight: bold'>PRODUCTION</td></tr>";
                    tbl += "<tr><td>1BEV</td><td>" + (d.bev1Stats.tons == undefined ? 0 : d.bev1Stats.tons) + "</td><td>" + (d.bev1Stats.metres == undefined ? 0 : d.bev1Stats.metres) + "</td><td>" + (d.bev1Stats.pipes == undefined ? 0 : d.bev1Stats.pipes) + "</td></tr>";
                    tbl += "<tr><td>1HYD</td><td>" + (d.hyd1Stats.tons == undefined ? 0 : d.hyd1Stats.tons) + "</td><td>" + (d.hyd1Stats.metres == undefined ? 0 : d.hyd1Stats.metres) + "</td><td>" + (d.hyd1Stats.pipes == undefined ? 0 : d.hyd1Stats.pipes) + "</td></tr>";
                    tbl += "<tr><td>2NDT</td><td>" + (d.ndt2Stats.tons == undefined ? 0 : d.ndt2Stats.tons) + "</td><td>" + (d.ndt2Stats.metres == undefined ? 0 : d.ndt2Stats.metres) + "</td><td>" + (d.ndt2Stats.pipes == undefined ? 0 : d.ndt2Stats.pipes) + "</td></tr>";
                    tbl += "<tr><td>RP20</td><td>" + (d.rp20Stats.tons == undefined ? 0 : d.rp20Stats.tons) + "</td><td>" + (d.rp20Stats.metres == undefined ? 0 : d.rp20Stats.metres) + "</td><td>" + (d.rp20Stats.pipes == undefined ? 0 : d.rp20Stats.pipes) + "</td></tr>";
                    tbl += "<tr><td>1ISP</td><td>" + (d.isp1Stats.tons == undefined ? 0 : d.isp1Stats.tons) + "</td><td>" + (d.isp1Stats.metres == undefined ? 0 : d.isp1Stats.metres) + "</td><td>" + (d.isp1Stats.pipes == undefined ? 0 : d.isp1Stats.pipes) + "</td></tr>";
                    tbl += "<tr><td>2MAR</td><td>" + (d.mar2Stats.tons == undefined ? 0 : d.mar2Stats.tons) + "</td><td>" + (d.mar2Stats.metres == undefined ? 0 : d.mar2Stats.metres) + "</td><td>" + (d.mar2Stats.pipes == undefined ? 0 : d.mar2Stats.pipes) + "</td></tr>";
                    $('#finishingStatsTable').find('tbody').html(tbl);

                    tbl = "<tr><td colspan='5' style='text-align: center; font-weight: bold'>PRODUCTION</td></tr>";
                    tbl += "<tr><td>1CLG</td><td>" + (d.clg1Stats.tons == undefined ? 0 : d.clg1Stats.tons) + "</td><td>" + (d.clg1Stats.metres == undefined ? 0 : d.clg1Stats.metres) + "</td><td>" + (d.clg1Stats.pipes == undefined ? 0 : d.clg1Stats.pipes) + "</td></tr>";
                    tbl += "<tr><td>2SAW</td><td>" + (d.saw2Stats.tons == undefined ? 0 : d.saw2Stats.tons) + "</td><td>" + (d.saw2Stats.metres == undefined ? 0 : d.saw2Stats.metres) + "</td><td>" + (d.saw2Stats.pipes == undefined ? 0 : d.saw2Stats.pipes) + "</td></tr>";

                    $('#rhsStatsTable').find('tbody').html(tbl);

                    tbl = "<tr><td colspan='5' style='text-align: center; font-weight: bold'>DESPATCHED</td></tr>";
                    tbl += "<tr><td>DESPATCHED</td><td>" + (d.despSummary.TONNES == undefined ? 0 : d.despSummary.TONNES) + "</td><td>" + (d.despSummary.METRES == undefined ? 0 : d.despSummary.METRES) + "</td><td>" + (d.despSummary.PIPES == undefined ? 0 : d.despSummary.PIPES) + "</td></tr>";


                    $('#despatchStatsTable').find('tbody').html(tbl);

                    BuildSlitterStatsTable(d.slitterStats);

                }


                function BuildSlitterStatsTable(slitCoilHistory) {
                    let tonnesIn = 0;
                    let tonnesOut = 0;
                    let yield = 0;
                    let scrapLoss = 0;
                    let coilsSlit = 0;
                    let childCoilsCreated = 0;

                    for (let i = 0; i < slitCoilHistory.length; i++) {
                        console.log(slitCoilHistory[i]);
                        tonnesIn += parseFloat(slitCoilHistory[i].COIL_ACT_WEIGHT);
                        tonnesOut += parseFloat(slitCoilHistory[i].CHILD_COIL_1_WEIGHT) +
                            parseFloat(slitCoilHistory[i].CHILD_COIL_2_WEIGHT) +
                            parseFloat(slitCoilHistory[i].CHILD_COIL_3_WEIGHT);
                        childCoilsCreated += (slitCoilHistory[i].CHILD_COIL1 !== "0" ? 1 : 0) +
                            (slitCoilHistory[i].CHILD_COIL2 !== "0" ? 1 : 0) +
                            (slitCoilHistory[i].CHILD_COIL3 !== "0" ? 1 : 0);
                    }


                    var table = "<table class='table table-bordered table-reduced-padding'>";

                    table += "<thead class='thead-light'>";
                    table += "<th colspan='2'>Slitter Stats</th></thead>";
                    table += "<tr><td>Tonnes In</td><td>" + tonnesIn.toFixed(2) + "</td></tr>";
                    table += "<tr><td>Tonnes Out</td><td>" + tonnesOut.toFixed(2) + "</td>";
                    table += "<tr><td>Output Yield</td><td>" + ((tonnesOut / tonnesIn) * 100).toFixed(2) + "%</td>";
                    table += "<tr><td>Scrap/Loss</td><td>" + (tonnesIn - tonnesOut).toFixed(2) + "</td>";
                    table += "<tr><td>Coils Slit</td><td>" + slitCoilHistory.length + "</td>";
                    table += "<tr><td>Child Coils Created</td><td>" + childCoilsCreated + "</td>";
                    table += "<tbody>";
                    table += "";

                    $('#slitterStats').html(table);
                }



            </script>




@endsection
