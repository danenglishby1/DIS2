@extends('layouts.app')

@section('pageTitle', 'Slitter Dashboard')
@section('pageName', 'Slitter Dashboard')
@section('millTrackingActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
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
    <div class="simpleflex justify-content-center">
        <div class="btn-flex mt-2 text-center">
            @section('overrideStartEndDate')
                start = moment().startOf('day');
                end = moment().endOf('day');

                window.dtFrom = start.format('Y-MM-DD 00:00:01');
                window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.
            @endsection
            @section('dateRangePickerOnApplyCallback')

                window.dtFrom = dtFrom;
                window.dtTo = dtTo;
                $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                $.ajax({
                type: 'POST',
                data: {'dtFrom': dtFrom, 'dtTo' : dtTo},
                url: rootUrl + '/api/slitter-dashboard-data',
                success: function (data) {
                console.log(data);
                    BuildSlitterQueueDetailsTable(data.slitdetfData);
                    BuildSlitterStatsTable(data.slitCoilHistory);
                    BuildSlitterOutputChart(data.slitterOutputTonnageJson);
                },
                complete: function () {
                $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                }
                });

            @endsection

                <div class="simpleflex justify-content-center" style="margin-top: -70px">
                    <div class="btn-flex mt-2 mb-3 text-center">
                        {{--            @include('layouts.partial.update-date-buttons')--}}
                        @include('layouts.templates.daterangepicker')
                    </div>


                    <div class="dashboard-flex">
        <div class="dashboard-left-col">
            <div class="dashboard-flex-card dashboard-flex-sm" style="height: 380px;">
                <div class="dashboard-box-container-header"><h5>Slitter Stats</h5></div>
                <div id="slitterStats">

                </div>
            </div>

            <div class="dashboard-flex-card dashboard-flex-sm" style="min-width: 100%;">
                <div class="dashboard-box-container-header"><h5>Placeholder</h5></div>

                <div id="nextCoil">

                    <table>
                    </table>
                </div>
            </div>

            <div class="dashboard-flex-card dashboard-flex-sm" style="min-width: 100%;">
                <div class="dashboard-box-container-header"><h5>Placeholder</h5></div>
                <div id="lastDimensionalVerification">
                </div>
            </div>

            <div class="dashboard-flex-card dashboard-flex-sm" style="height:285px;">
                <div class="dashboard-box-container-header"><h5>Placeholder</h5></div>
{{--                <table class="table table-bordered table-reduced-padding" id="wmStoppagePerformanceTable">--}}
{{--                    <tdead class="tdead-light">--}}
{{--                    <th>Weld Mill Availability</th>--}}
{{--                    <th>Performance</th>--}}
{{--                    <th>Detail</th>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}

{{--                    </tbody>--}}
                </table>
            </div>
        </div>

        <div class="dashboard-middle-col">
            <div class="dashboard-flex-card dashboard-flex-xl">
                <div class="dashboard-box-container-header"><h5>Slitter Output Tonnes</h5></div>
                <div id="slitterOutputBarChart" style="width:100%;height:210px;">
                    <svg></svg>
                </div>


{{--                <div class="text-center">--}}
{{--                    Standard/<span id="standardHOrDLabel">h</span>: <span id="standardTonsPerHourValue"></span>--}}
{{--                    <br/>--}}
{{--                    <!-- bestHourTonnageValue value injected from js -->--}}
{{--                    Best <span id="hourOrDayLabel">Hour</span>: <span id="bestHourTonnageValue"></span>--}}
{{--                    <br/>--}}
{{--                    <!-- averageHourTonnageValue value injected from js -->--}}
{{--                    Average/<span id="averageHOrDLabel">h</span>: <span id="averageHourTonnageValue"></span>--}}
{{--                </div>--}}

{{--                <div id="throughputChart" style="height: 300px; width:100%;    margin-top: 0.5em;">--}}
{{--                    <svg></svg>--}}
{{--                </div>--}}
            </div>

            <div class="dashboard-flex-card dashboard-flex-xl">
                <div class="dashboard-box-container-header"><h5>Slitter Queue</h5></div>
                <div id="slitterQueueDetail">

                </div>
            </div>

            <div class="dashboard-flex-card dashboard-flex-xl">
                <div class="dashboard-box-container-header"><h5>Placeholder</h5></div>
                <div id="tonsByStatusAndPRPivot" width="100%"></div>

{{--                <button class="coilPipePivotReportLoaderButton btn btn-primary mt-2"--}}
{{--                        style="display: block; margin:auto;" data-reportid="234">View Report--}}
{{--                </button>--}}
            </div>
        </div>

        <div class="dashboard-right-col">
            <div class="dashboard-flex-card dashboard-flex-xl">
                <div class="dashboard-box-container-header"><h5>Placeholder</h5></div>
                <div id="wmEngineeringStopsChart" style="height: 500px; width: 500px;">
                    <svg></svg>
                </div>
                <hr/>
                <div>
{{--                    <h5>Flattening Failures</h5>--}}

{{--                    <div id="flatteningFailuresCount"></div>--}}
{{--                    <div id="flatteningFailureData" class="flatteningFailureData"></div>--}}
                </div>
            </div>

            <div class="dashboard-flex-card dashboard-flex-xl">
                <div class="dashboard-box-container-header"><h5>Placeholder</h5></div>

                <div id="thicknessLineChart" style="height:450px;" class="with-3d-shadow with-transitions">
                    <svg></svg>
                </div>
            </div>
        </div>
    </div>








    @endsection
    @section('functionalScripts')
                        <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
                        <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
        <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js?v=1.0')}}"></script>



        <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
        <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
        {{--            <!-- Extension scripts for datatables print functionality -->--}}
                    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
                    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
                    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
                    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>


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

            function BuildSlitterQueueDetailsTable(slitdetfData) {
                var table = "<table class='table'>";
                table += "<thead>";
                table += "<th>Coil</th>";
                table += "<th>Slit?</th>";
                table += "<th>Width</th>";
                table += "<th>Thk</th>";
                table += "<th>Qual</th>";
                table += "<th>Weight</th>";
                table += "<th>Reserved Coil 1</th>";
                table += "<th>Reserved Coil 2</th>";
                table += "<th>Reserved Coil 3</th>";
                table += "</thead>";

                for (let i = 0; i < slitdetfData.length; i++) {
                    // console.log(slitdetfData[i]);
                    table += "<tr>";
                    table += "<td>" + slitdetfData[i].COIL_NO + "</td>";
                    table += "<td>" + slitdetfData[i].SLIT_IND + "</td>";
                    table += "<td>" + slitdetfData[i].COIL_WIDTH + "</td>";
                    table += "<td>" + slitdetfData[i].COIL_THK + "</td>";
                    table += "<td>" + slitdetfData[i].COIL_QUALITY + "</td>";
                    table += "<td>" + slitdetfData[i].COIL_ADV_WEIGHT + "</td>";
                    table += "<td>";
                    table += "No: <b>" + slitdetfData[i].SLIT_COIL_NO1 +"</b><br />";
                    table += "W:  <b>" + slitdetfData[i].SLIT_WIDTH1 +"<br />";
                    table += "OD:  <b>" + slitdetfData[i].SLIT_OD1 +"<br />";
                    table += "</td>";
                    table += "<td>";
                    table += "No: <b>" + slitdetfData[i].SLIT_COIL_NO2 +"</b><br />";
                    table += "W: <b>" + slitdetfData[i].SLIT_WIDTH2 +"</b><br />";
                    table += "OD: <b>" + slitdetfData[i].SLIT_OD2 +"</b><br />";
                    table += "</td>";
                    table += "<td>";
                    table += "No: <b>" + slitdetfData[i].SLIT_COIL_NO3 +"</b><br />";
                    table += "W: <b>" + slitdetfData[i].SLIT_WIDTH3 +"</b><br />";
                    table += "OD: <b>" + slitdetfData[i].SLIT_OD3 +"</b><br />";
                    table += "</td>";
                    table += "</tr>";
                }
                table += "</table>";

                $('#slitterQueueDetail').html(table);
            }


            function BuildSlitterStatsTable(slitCoilHistory) {
                let tonnesIn = 0;
                let tonnesOut = 0;
                let yield = 0;
                let scrapLoss = 0;
                let coilsSlit = 0;
                let childCoilsCreated = 0;

                for (let i = 0; i < slitCoilHistory.length; i++) {
                    // console.log(slitCoilHistory[i]);
                    tonnesIn += parseFloat(slitCoilHistory[i].COIL_ADV_WEIGHT);
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
                table += "<tr><td>Tonnes In</td><td>"+tonnesIn.toFixed(2)+"</td></tr>";
                table += "<tr><td>Tonnes Out</td><td>"+tonnesOut.toFixed(2)+"</td>";
                table += "<tr><td>Output Yield</td><td>"+((tonnesOut / tonnesIn) * 100).toFixed(2)+"%</td>";
                table += "<tr><td>Scrap/Loss</td><td>"+(tonnesIn - tonnesOut).toFixed(2)+"</td>";
                table += "<tr><td>Coils Slit</td><td>"+slitCoilHistory.length+"</td>";
                table += "<tr><td>Child Coils Created</td><td>"+childCoilsCreated+"</td>";
                table += "<tbody>";
                table += "";

                $('#slitterStats').html(table);

            }


            function BuildSlitterOutputChart(output) {
                console.log($.parseJSON(output));
                // d3.select("#slitterOutputBarChart svg").remove();
                // d3.select("#slitterOutputBarChart").append("svg");
                RenderStaticDiscreteBarChart($.parseJSON(output), 'label', 'value', 'slitterOutputBarChart', '', "day/month", 'Tonnes', '.0f', '.0f', [0,45], true, false, null, null, null, null, null);


            }

            /***
             * Get initial  data
             */
            $.ajax({
                type: "POST",
                url: rootUrl + '/api/slitter-dashboard-data',
                dataType: "json",
                async: false,
                success: function (response) {

                    console.log(response);

                    BuildSlitterQueueDetailsTable(response.slitdetfData);
                    BuildSlitterStatsTable(response.slitCoilHistory);
                    BuildSlitterOutputChart(response.slitterOutputTonnageJson);

                    // Build chart
                    // BuildLineCharts(response);
                    // FillCoilNoRangeInputs(response.coilNoRange);

                }
            });




            // var table = $('#macro-table').DataTable({
            //     dom: 'Bfrtip',
            //      buttons: ['print', 'excel'],
            //     "order": [5, "desc"],
            //
            //     initComplete: function () {
            //         this.api().columns().every(function () {
            //             var column = this;
            //             var select = $('<select><option value=""></option></select>')
            //                 .appendTo($(column.footer()).empty())
            //                 .on('change', function () {
            //                     var val = $.fn.dataTable.util.escapeRegex(
            //                         $(this).val()
            //                     );
            //
            //                     column
            //                         .search(val ? '^' + val + '$' : '', true, false)
            //                         .draw();
            //                 });
            //
            //             column.data().unique().sort().each(function (d, j) {
            //                 select.append('<option value="' + d + '">' + d + '</option>')
            //             });
            //         });
            //     }
            // });
            //
            // table.on('draw', function () {
            //     table.columns().indexes().each(function (idx) {
            //         var select = $(table.column(idx).footer()).find('select');
            //
            //         if (select.val() === '') {
            //             select
            //                 .empty()
            //                 .append('<option value=""/>');
            //
            //             table.column(idx, {search: 'applied'}).data().unique().sort().each(function (d, j) {
            //                 select.append('<option value="' + d + '">' + d + '</option>');
            //             });
            //         }
            //     });
            // });

        </script>

        <script>




{{--            function BuildNewRows(data) {--}}
{{--                var crsfToken = "{{@csrf_token()}}";--}}
{{--                var tablesRows = "";--}}
{{--                for (const [key, value] of Object.entries(data)) {--}}
{{--                    // console.log(key, value);--}}
{{--                    tablesRows += "<tr>" +--}}

{{--                        "<td>" + (data[key].WEEK_YEAR !== null ? data[key].WEEK_YEAR.padStart(2, "0") : "") + (data[key].COIL !== null ? data[key].COIL.toString().padStart(3, "0") : "") + (data[key].PIPE !== null ? data[key].PIPE.toString().padStart(2, "0") : "") + "</td>" +--}}
{{--                        "<td>" + data[key].DIAM_RANGE + "</td>" +--}}
{{--                        "<td>" + data[key].THK + "</td>" +--}}
{{--                        "<td>" + data[key].QUALITY + "</td>" +--}}
{{--                        "<td>" + (data[key].COMMENT == null ? "" : data[key].COMMENT) + "</td>" +--}}
{{--                        "<td>" + data[key].CREATED_AT + "</td>" +--}}
{{--                        "<td>" + (data[key].IMAGE !== "" ? "<a target='_blank' href='" +rootUrl + "/public/storage/macros/"+ data[key].IMAGE + "'><img style='width:100px; height: 50px;' src='" +rootUrl + "/public/storage/macros/"+ data[key].IMAGE + "'/></a>" : "") + "</td>"+--}}
{{--                        "<td>" +--}}
{{--                        "  <div style='display: flex;'>" +--}}
{{--                        "  <a href='"+rootUrl+"/wm-macros/"+data[key].id+"' class='btn btn-primary m-1'>View</a>" +--}}
{{--                        "  <a href='"+rootUrl+"/wm-macros/"+data[key].id+"/edit' class='btn btn-warning m-1'>Edit</a>" +--}}
{{--                        "<form method='post' class='delete-form' action='"+rootUrl+"/wm-macros/"+data[key].id+"'>" +--}}
{{--                        "  <input type='hidden' name='_token' value='"+crsfToken+"'> " +--}}
{{--                        "<input type='hidden' name='_method' value='DELETE'> " +--}}
{{--                        "<button class='btn btn-danger m-1' type='submit'>Delete</button>" +--}}
{{--                        "                                </form>" +--}}
{{--                        "                            </div>" +--}}
{{--                        "</td>"+--}}
{{--                        "</tr>";--}}

{{--                }--}}

{{--                return tablesRows;--}}
{{--            }--}}
        </script>


@endsection
