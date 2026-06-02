@extends('layouts.app')

@section('pageTitle', 'OEE')
@section('pageName', 'OEE')
@section('weldMillActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="simpleflex justify-content-center">
        <div class="btn-flex mt-2 text-center">
            @section('overrideStartEndDate')
                start = moment().startOf('month');
                end = moment().endOf('month');

                window.dtFrom = start.format('Y-MM-DD 00:00:01');
                window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.
            @endsection
            @section('dateRangePickerOnApplyCallback')
                $.ajax({
                type: 'POST',
                data: {'dtFrom': dtFrom, 'dtTo': dtTo},
                url: rootUrl + '/api/GetOEEData',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner anddefault to inline-block.
                $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {
                console.log(data);

                window.dtFrom = dtFrom;
                window.dtTo = dtTo;

                $('#processedTonnes').html('Processed Tonnes : '+data.weldMillOutputTonnes);
                $('#qualityLosses').html('Quality Losses : ' + Math.round(data.weldMillDGTonnes +
                data.weldMillScrapTonnes) );
                $('#plLosses').html('PL Losses : ' + data.cAndZStopHours );
                $('#unLosses').html('UN Losses : ' + data.pAndEAndMStopHours  );
                $('#noBreakdowns').html('No. Breakdowns : ' + data.pAndEAndMStopCount );
                $('#utLosses').val(data.utilisationLossHours);

                },
                complete: function () {
                $('.ajax-loader').css('display', 'none');
                }
                });
            @endsection
            <div class="filters">
                @include('layouts.templates.daterangepicker')
                {{--                @include('layouts.templates.daterangepicker')--}}
                {{--                <div style="width: 100px;margin-top: 5px;">--}}
                {{--                    <a id="exportDataLink"  href="#">Export CSV</a>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>

    <div>
        <span id="processedTonnes" style="font-weight: bold">Processed Tonnes : {{$weldMillOutputTonnes}}</span>
    </div>

    <div>
        <span id="qualityLosses"
              style="font-weight: bold">Quality Losses (Tonnes) : {{($weldMillDGTonnes + $weldMillScrapTonnes)}}</span>
    </div>

    <div>
        <span id="utLosses" style="font-weight: bold">UT Losses <input type="text" value="{{$utilisationLossHours}}" name="utLosses"/> </span>
    </div>


    <div>
        <span id="plLosses" style="font-weight: bold">PL Losses (Hours) : {{$cAndZStopHours}}</span>
    </div>

    <div>
        <span id="unLosses" style="font-weight: bold">UN Losses (Hours) : {{$pAndEAndMStopHours}}</span>
    </div>

    <div>
        <span id="noBreakdowns" style="font-weight: bold">No. Breakdowns : {{$pAndEAndMStopCount}}</span>
    </div>




    <div>
        <span id="qualityLosses"
              style="font-weight: bold">Quality Losses (Tonnes) : {{($weldMillDGTonnes + $weldMillScrapTonnes)}}</span>
    </div>


    <div>
        <span>Total Days per Month (TdM) : {{$totalDaysInMonth}}</span>
    </div>

    <div>
        <span>Worked Days per Month (M-Fr) : {{$totalWeekDaysInMonth}} </span>
    </div>

    <div>
        <span>Potential Workdays per Month (pWd) : {{$totalWeekDaysInMonth}} </span>
    </div>

    <div>
        <span>Total hours per Month (TdMx24) :  {{$totalHoursInMonth}} </span>
    </div>

    <div>
        <span>Holidays (Hol) : <input type="text"></span>
    </div>

    <div>
        <span>Potential Workhours per Month (pWdx16) : <span id="pWdx16">{{$potentialWorkHoursInMonth}}</span></span>
    </div>

    <div>
        <span>Over time hours worked in Month (OTh): <input id="OTh" type="text" value="50.5"></span>
    </div>

    <div>
        <span>Worked Hours in Month (pWdx16 + OTh) : <span id="workedHoursInMonth">{{$potentialWorkHoursInMonth}}</span> </span>
    </div>

    <div>
        <span>Planned Running (ThM - UT - PL) : <span id="">{{$plannedRunning}}</span> </span>
    </div>

    <div>
        <span>Effective Output Rate : <span id="">{{$effectiveOutputRate}}</span> </span>
    </div>

    <div>
        <span>% of 68.6 t/hr target : <span id="">{{$percentOf68TonneHrTarget}}</span> </span>
    </div>




@endsection
@section('functionalScripts')
    <script>


    </script>

    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    {{--            <!-- Extension scripts for datatables print functionality -->--}}
    {{--            <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>--}}
    {{--            <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>--}}
    {{--            <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>--}}
    {{--            <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>--}}

    <script>
        /**
         * Add ajax header for CSRF Token
         * */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).on('change', 'input#OTh', function() {

            let OTh = parseFloat($(this).val());

            let pWfx16 = parseFloat($('#pWdx16').text());


            console.log(pWfx16);
            console.log(OTh);

            $('#workedHoursInMonth').text(pWfx16 + OTh);

        });



    </script>

    <script>
        $('#exportDataLink').click(function (e) {
            console.log(window.dtFrom);
            window.location.href = rootUrl + "/api/exportMacroDataToCSV?dtFrom=" + window.dtFrom + "&dtTo=" + window.dtTo;
            $('.ajax-loader').css('display', 'none');
        });
    </script>

@endsection
