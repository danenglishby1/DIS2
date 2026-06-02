@extends('layouts.app')

@section('pageTitle', 'Hydro Load Monitor')
@section('pageName', 'Hydro Load Monitor')
@section('engineeringActiveLink', 'active activeUnderline')
@section('content')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>

@endsection




<p>>85% end load capacity or >= 4750 PSI </p>

<div>

    <table id="macro-table" class="table table-striped">
        <thead>
        <th>ROLL WEEK</th>
        <th>BLOCK</th>
        <th>PR</th>
        <th>GRADE</th>
        <th>OD</th>
        <th>PRESSURE</th>
        <th>FORCE_LB</th>
        <th>END LOAD</th>
        <th>CAPACITY</th>
        </thead>
        <tbody>
        @foreach($data as $r)
            <tr>
                <td>{{$r["ROLL_WEEK"]}}</td>
                <td>{{$r["BLOCK_NO"]}}</td>
                <td>{{$r["PROCESS_ROUTE"]}}</td>
                <td>{{$r["BLOCK_GRADE"]}}</td>
                <td>{{$r["BLOCK_OD"]}}</td>
                @if($r["HT_PRESSURE_MIN"] > 4749)
                    <td style="background: red; color:yellow; font-weight:bold">{{$r["HT_PRESSURE_MIN"]}}</td>
                @else
                    <td>{{$r["HT_PRESSURE_MIN"]}}</td>
                @endif
                <td>{{$r["FORCE_LB"]}}</td>
                <td>{{$r["END_LOAD"]}}</td>
                @if($r["CAPACITY"] > 30 && $r["CAPACITY"] < 80)
                    <td style="background: yellow; color:red; font-weight:bold">{{$r["CAPACITY"]}}%</td>
                @elseif ($r["CAPACITY"] >= 80)
                    <td style="background: red; color:yellow; font-weight:bold">{{$r["CAPACITY"]}}%</td>
                @else
                    <td>{{$r["CAPACITY"]}}%</td>
                @endif
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <th>ROLL WEEK</th>
        <th>BLOCK</th>
        <th>PR</th>
        <th>GRADE</th>
        <th>PRESSURE</th>
        <th>FORCE_LB</th>
        <th>END LOAD</th>
        <th>CAPACITY</th>
        </tfoot>
    </table>



</div>

    </div>


    @endsection

    @section('functionalScripts')
        <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
        <script src="{{ asset('public/libraries/NVD3/nv.d3.js?v=1.2')}}"></script>
        <script src="{{ asset('public/js/engineering-stoppage-analysis/functions.js?v=1.23')}}"></script>
        <script src="{{ asset('public/js/engineering-stoppage-analysis/listeners.js?v=1.00')}}"></script>
        {{--        <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.20/lodash.min.js"></script>--}}

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /***
             * Get initial chart data
             */
            $.ajax({
                type: "POST",
                url: rootUrl + "/api/getEngineeringDashboardData",
                dataType: "json",
                async: false,
                success: function (response) {
                    console.log(response);
                    globalStoppageData = response;
                    BuildStoppageTypeSummaryTableRows(response.stoppageSummaryByType);
                    BuildStoppageTypeJsonAndGenerateChart();

                }
            });





        </script>

@endsection
