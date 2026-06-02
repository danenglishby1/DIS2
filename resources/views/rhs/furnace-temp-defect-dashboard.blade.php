@extends('layouts.app')

@section('pageTitle', 'Furnace Temp Defect Monitor')
@section('pageName', 'Furnace Temp Defect Monitor')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <style>
        #furnace-defect-actioned-tbl_wrapper {
            width: 100%;
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
                url: rootUrl + '/api/get-furnace-temp-defect-dashboard-data',
                success: function (data) {
                    console.log(data);
                    BuildChart(data.furnaceDefectShiftDataJson);
                },
                complete: function () {
                $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                }
                });

            @endsection
            {{--            <div class="filters">--}}
            {{--                --}}
            {{--                <div style="width: 100px;margin-top: 5px;">--}}
            {{--                    <a id="exportDataLink"  href="#">Export CSV</a>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--        </div>--}}
            {{--    </div>--}}


            <div class="simpleflex justify-content-center" style="margin-top: -70px">
                <div class="btn-flex mt-2 mb-3 text-center">
                    {{--            @include('layouts.partial.update-date-buttons')--}}
                    @include('layouts.templates.daterangepicker')
                </div>

            </div>

        </div>
    </div>



    <div class="row">
        <div id="actionsByShiftMultiBarChart" style="height:500px; width: 100%">
            <svg></svg>
        </div>

    </div>




@endsection
@section('functionalScripts')

    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    {{--            <!-- Extension scripts for datatables print functionality -->--}}
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

        var furnaceDefectShiftDataJson = <?php echo $furnaceDefectShiftDataJson; ?>;
        console.log(furnaceDefectShiftDataJson);


        function BuildChart(data) {
            nv.addGraph(function() {
                var chart = nv.models.multiBarHorizontalChart()
                    .x(function(d) { return d.label })
                    .y(function(d) { return d.value })
                    .margin({top: 30, right: 20, bottom: 50, left: 175})
                    .showValues(true)
                    .showControls(false);

                chart.yAxis
                    .tickFormat(d3.format(',.2f'));

                d3.select('#actionsByShiftMultiBarChart svg')
                    .datum(data)
                    .transition().duration(500)
                    .call(chart);

                nv.utils.windowResize(chart.update);

                return chart;
            });
        }


        BuildChart(furnaceDefectShiftDataJson);



    </script>
@endsection
