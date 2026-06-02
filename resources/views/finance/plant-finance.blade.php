@extends('layouts.app')

@section('pageTitle', 'Plant Finance')
@section('pageName', 'Plant Finance')
@section('engineeringActiveLink', 'active activeUnderline')
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
                start = moment().startOf('week');
                end = moment().endOf('week');

                window.dtFrom = start.format('Y-MM-DD 00:00:01');
                window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.

                let searchParams = new URLSearchParams(window.location.search)

                if(searchParams.has('dtFrom') && searchParams.has('dtTo')) {
                start = moment(searchParams.get('dtFrom'));
                end = moment(searchParams.get('dtTo'));

                window.dtFrom = start.format(searchParams.get('dtFrom'));
                window.dtTo = end.format(searchParams.get('dtTo')); // Set dt from/to as global.
                }


            @endsection
            @section('dateRangePickerOnApplyCallback')


                window.dtFrom = dtFrom;
                window.dtTo = dtTo;

                window.location.href = rootUrl + "/finance/plant-finance?dtFrom="+dtFrom+"&dtTo="+dtTo;

            @endsection
            <div class="filters">
                @include('layouts.templates.daterangepicker')
            </div>
        </div>
    </div>


        <button id="recalculateButton" class="btn btn-warning" style="display: none; margin: 10px auto;">Recalculate</button>


    <div class="simpleflex">


        <div>
            <table class="table">
                <thead>
                <th></th>
                <th>Actual</th>
                <th>Standard</th>
                <th>Delta</th>
                <th>Variance £</th>
                </thead>

                <tbody>
                <tr>
                    <td>Total Manned</td>
                    <td><input id="totalMannedHours" type="text" value="{{$totalMannedHours}}"></td>
                    <td><input id="standardTotalMannedHours" type="text" value="{{$standardTotalMannedHours}}"></td>
                    <td>{{$totalMannedHours - $standardTotalMannedHours}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Total Activity</td>
                    <td>{{$actualActivityHours}}</td>
                    <td>{{$standardActivityHours}}</td>
                    <td>{{$standardActivityHours - $actualActivityHours}}</td>
                    <td>£{{($standardActivityHours - $actualActivityHours) * $standardCost}}</td>
                </tr>
                <tr>
                    <td>Worked Time</td>
                    <td>{{$totalWorkedTime}}</td>
                    <td>{{$totalStandardWorkedTime}}</td>
                    <td>{{round($totalStandardWorkedTime - $totalWorkedTime,2)}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="background:yellow"></td>
                    <td style="background:yellow"></td>
                    <td style="background:yellow"></td>
                    <td style="background:yellow"></td>
                    <td style="background:yellow"></td>
                </tr>
                <tr>
                    <td>Total Stoppages</td>
                    <td>{{round($totalStopHours,2)}}</td>
                    <td>{{round($standardStopHours,2)}}</td>
                    <td>{{round($standardStopHours - $totalStopHours,2)}}</td>
                    <td>£{{round(($standardStopHours - $totalStopHours)* $standardCost,2)}}</td>
                </tr>
                <tr>
                    <td>Changing</td>
                    <td>{{round((isset($totalStoppageMinsByDescription["Changing"]["hoursStopped"]) ? $totalStoppageMinsByDescription["Changing"]["hoursStopped"] : 0),2)}}</td>
                    <td>{{round(($changingStoppageStandardPercentage * $totalStandardWorkedTime),2)}}</td>
                    <td>{{round((($changingStoppageStandardPercentage * $totalStandardWorkedTime) - (isset($totalStoppageMinsByDescription["Changing"]["hoursStopped"]) ? $totalStoppageMinsByDescription["Changing"]["hoursStopped"] : 0) ),2)}}</td>
                    <td>
                        £{{round((($changingStoppageStandardPercentage * $totalStandardWorkedTime) - (isset($totalStoppageMinsByDescription["Changing"]["hoursStopped"]) ? $totalStoppageMinsByDescription["Changing"]["hoursStopped"] : 0) )* $standardCost,2)}}</td>
                </tr>
                <tr>
                    <td>Eng</td>
                    <td>{{round( (isset($totalStoppageMinsByDescription["Eng"]["hoursStopped"]) ? $totalStoppageMinsByDescription["Eng"]["hoursStopped"] : 0),2) }}</td>
                    <td>{{round( ($engineeringStoppageStandardPercentage * $totalStandardWorkedTime), 2)}}</td>
                    <td>{{round ((($engineeringStoppageStandardPercentage * $totalStandardWorkedTime) - (isset($totalStoppageMinsByDescription["Eng"]["hoursStopped"]) ? $totalStoppageMinsByDescription["Eng"]["hoursStopped"] : 0) ), 2)}}</td>
                    <td>
                        £{{round ((($engineeringStoppageStandardPercentage * $totalStandardWorkedTime) - (isset($totalStoppageMinsByDescription["Eng"]["hoursStopped"]) ? $totalStoppageMinsByDescription["Eng"]["hoursStopped"] : 0) )* $standardCost ,2 )}}</td>
                </tr>
                <tr>
                    <td>Production</td>
                    <td>{{round ((isset($totalStoppageMinsByDescription["Prod"]["hoursStopped"]) ? $totalStoppageMinsByDescription["Prod"]["hoursStopped"] : 0),2)}}</td>
                    <td>{{round (($productionStoppageStandardPercentage * $totalStandardWorkedTime),2)}}</td>
                    <td>{{round ((($productionStoppageStandardPercentage * $totalStandardWorkedTime) - (isset($totalStoppageMinsByDescription["Prod"]["hoursStopped"]) ? $totalStoppageMinsByDescription["Prod"]["hoursStopped"] : 0) ),2)}}</td>
                    <td>
                        £{{round((($productionStoppageStandardPercentage * $totalStandardWorkedTime) - (isset($totalStoppageMinsByDescription["Prod"]["hoursStopped"]) ? $totalStoppageMinsByDescription["Prod"]["hoursStopped"] : 0) )* $standardCost, 2)}}</td>
                </tr>
                <tr>
                    <td style="background:yellow"></td>
                    <td style="background:yellow"></td>
                    <td style="background:yellow"></td>
                    <td style="background:yellow"></td>
                    <td style="background:yellow"></td>
                </tr>
                <tr>
                    <td>Available Production Time</td>
                    <td>{{round (($totalWorkedTime - $totalStopHours),2)}}</td>
                    <td>{{round($standardProducedProductHours,2)}}</td>
                    <td>{{round(($standardProducedProductHours - ($totalWorkedTime - $totalStopHours)),2)}}</td>
                    <td>£{{round(($standardProducedProductHours - ($totalWorkedTime - $totalStopHours)) * $standardCost, 2)}}</td>
                </tr>
                <tr>
                    <td>Standard</td>
                    <td></td>
                    <td>{{round (($totalMannedHours - $standardActivityHours - $standardStopHours),2)}}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="background:yellow"></td>
                    <td style="background:yellow"></td>
                    <td style="background:yellow"></td>
                    <td style="background:yellow"></td>
                    <td style="background:yellow"></td>
                </tr>
                <tr>
                    <td>Total Time Check</td>
                    <td>{{round((($totalWorkedTime - $totalStopHours) + $totalStopHours + $actualActivityHours),2)}}</td>
                    <td>{{round (( ($totalMannedHours - $standardActivityHours - $standardStopHours) + $standardStopHours + $standardActivityHours), 2) }}</td>
                    <td>{{round( (($totalWorkedTime - $totalStopHours) + $totalStopHours + $actualActivityHours) - ( ($totalMannedHours - $standardActivityHours - $standardStopHours) + $standardStopHours + $standardActivityHours),2)}} </td>
                    <td>£{{round(
    ((($totalWorkedTime - $totalStopHours) - ($totalWorkedTime - $totalStopHours)) * $standardCost) +
    (($standardStopHours - $totalStopHours)* $standardCost) +
    (($standardActivityHours - $actualActivityHours) * $standardCost),2)
    }}</td>
                </tr>

                <tr>
                    <td>Total Tonnage</td>
                    <td>{{round($totalTonnesProcessed,2)}}</td>
                    <td>{{round($standardTonnes,2)}}</td>
                    <td>{{round($totalTonnesProcessed - $standardTonnes,2)}}</td>
                    <td></td>
                </tr>
                </tbody>
            </table>

        </div>


        {{--        <div>--}}

        {{--            <table class="table">--}}
        {{--                <thead>--}}
        {{--                <th>--}}
        {{--                    Stop Type--}}
        {{--                </th>--}}
        {{--                <th>--}}
        {{--                    Stop Hours--}}
        {{--                </th>--}}
        {{--                </thead>--}}
        {{--                <tbody>--}}
        {{--                @foreach($totalStoppageMinsByDescription as $stop)--}}
        {{--                    <tr>--}}
        {{--                        <td>--}}
        {{--                            {{$stop["stopTypeDescription"]}}--}}
        {{--                        </td>--}}
        {{--                        <td>--}}
        {{--                            {{$stop["hoursStopped"]}}--}}
        {{--                        </td>--}}
        {{--                    </tr>--}}
        {{--                @endforeach--}}
        {{--                </tbody>--}}
        {{--            </table>--}}
        {{--        </div>--}}

        {{--        <div style="font-size: 16px;">--}}
        {{--            Total Stop Hours : {{$totalStopHours}}--}}
        {{--        </div>--}}
        {{--        <div style="font-size: 16px;">--}}
        {{--            Standard Product Production Hours : {{$standardProducedProductHours}}--}}
        {{--        </div>--}}
        {{--        <div style="font-size: 16px;">--}}
        {{--            Finance Variance Total Performance Hours : {{$financeVarianceTotalPerformance}}--}}
        {{--        </div>--}}
    </div>




@endsection
@section('functionalScripts')

    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>

    <script>
        $('#totalMannedHours, #standardTotalMannedHours').keyup(function () {
            console.log("up");
            $('#recalculateButton').css('display', 'block');
        });


        // On recalculation button click, submit manually updated hours and dtfrom/to from range picker to controller to recalculate
        // with new variables.
        $('#recalculateButton').click(function() {
           console.log("Submit");
           console.log(window.dtFrom);
        });

    </script>
@endsection
