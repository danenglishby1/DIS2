@extends('layouts.app')

@section('pageTitle', 'Admin Dash')
@section('pageName', 'Admin Dash')
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





{{--    <div class="simpleflex">--}}

{{--        <div class="card text-white bg-dark mb-3 m-1">--}}

{{--            <div class="card-body">--}}
{{--                <h5 class="card-title">RHS Furnace PLC Data</h5>--}}
{{--                <div class="dataOkIcon">--}}
{{--                    @if ($rhsFurnaceDataOK == true)--}}
{{--                        <i class="fa fa-check-circle" style="font-size:40px;color: #61b861;" aria-hidden="true"></i>--}}
{{--                    @else--}}
{{--                        <i class="fa fa-times-circle" style="font-size:40px;color: #da2525;" aria-hidden="true"></i>--}}
{{--                    @endif--}}

{{--                </div>--}}
{{--                <p class="card-text">--}}
{{--                    <span class="info-type">PLC Movement </span>:--}}
{{--                    {{$lastPipeInMySQLLocalRHSFurnaceDB[0]["CON_NO"]}} At--}}
{{--                    : {{$lastPipeInMySQLLocalRHSFurnaceDB[0]["TIME_STAMP"]}}--}}
{{--                    <br/>--}}
{{--                    <br/>--}}
{{--                    <span class="info-type">Tandem Last Movement</span>: {{$lastMovementRHSFurnaceTandemDB}}--}}
{{--                </p>--}}

{{--                --}}{{--                <a href="#" class="btn btn-primary">Go somewhere</a>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="card text-white bg-dark mb-3 m-1">--}}

{{--            <div class="card-body">--}}
{{--                <h5 class="card-title">RHS Quench PLC Data</h5>--}}
{{--                <div class="dataOkIcon">--}}
{{--                    @if ($rhsQuenchDataOK == true)--}}
{{--                        <i class="fa fa-check-circle" style="font-size:40px;color: #61b861;" aria-hidden="true"></i>--}}
{{--                    @else--}}
{{--                        <i class="fa fa-times-circle" style="font-size:40px;color: #da2525;" aria-hidden="true"></i>--}}
{{--                    @endif--}}

{{--                </div>--}}
{{--                <p class="card-text">--}}
{{--                    <span class="info-type">PLC Movement </span>:--}}
{{--                    SectNo {{$lastPipeInMySQLLocalRHSQuenchDB[0]["Section_No"]}} At--}}
{{--                    : {{$lastPipeInMySQLLocalRHSQuenchDB[0]["Date_Time"]}}--}}
{{--                    <br/>--}}
{{--                    <br/>--}}
{{--                    <span class="info-type">Tandem Last Movement</span>: {{$lastMovementRHSQuenchTandemDB}}--}}
{{--                </p>--}}

{{--                --}}{{--                <a href="#" class="btn btn-primary">Go somewhere</a>--}}
{{--            </div>--}}
{{--        </div>--}}


{{--        <div class="card text-white bg-dark mb-3 m-1">--}}
{{--            <div class="card-body">--}}
{{--                <h5 class="card-title">CHS Furnace PLC Data</h5>--}}
{{--                <div class="dataOkIcon">--}}
{{--                    @if ($chsFurnaceDataOK == true)--}}
{{--                        <i class="fa fa-check-circle" style="font-size:40px;color: #61b861;" aria-hidden="true"></i>--}}
{{--                    @else--}}
{{--                        <i class="fa fa-times-circle" style="font-size:40px;color: #da2525;" aria-hidden="true"></i>--}}
{{--                    @endif--}}

{{--                </div>--}}
{{--                <p class="card-text">--}}
{{--                    <span class="info-type">PLC Movement </span>:--}}
{{--                    {{$lastPipeInMySQLLocalCHSFurnaceDB[0]["CON_NO"]}} At--}}
{{--                    : {{$lastPipeInMySQLLocalCHSFurnaceDB[0]["TIME_STAMP"]}}--}}
{{--                    <br/>--}}
{{--                    <br/>--}}
{{--                    <span class="info-type">Tandem Last Movement</span>: {{$lastMovementCHSFurnaceTandemDB}}--}}
{{--                </p>--}}

{{--                --}}{{--                <a href="#" class="btn btn-primary">Go somewhere</a>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="card text-white bg-dark mb-3 m-1">--}}

{{--            <div class="card-body">--}}
{{--                <h5 class="card-title">CHS Quench PLC Data</h5>--}}
{{--                <div class="dataOkIcon">--}}
{{--                    @if ($chsQuenchDataOK == true)--}}
{{--                        <i class="fa fa-check-circle" style="font-size:40px;color: #61b861;" aria-hidden="true"></i>--}}
{{--                    @else--}}
{{--                        <i class="fa fa-times-circle" style="font-size:40px;color: #da2525;" aria-hidden="true"></i>--}}
{{--                    @endif--}}

{{--                </div>--}}
{{--                <p class="card-text">--}}
{{--                    <span class="info-type">PLC Movement </span>:--}}
{{--                    SectNo {{$lastPipeInMySQLLocalCHSQuenchDB[0]["Section_No"]}} At--}}
{{--                    : {{$lastPipeInMySQLLocalCHSQuenchDB[0]["Date_Time"]}}--}}
{{--                    <br/>--}}
{{--                    <br/>--}}
{{--                    <span class="info-type">Tandem Last Movement</span>: {{$lastMovementCHSQuenchTandemDB}}--}}
{{--                </p>--}}

{{--                --}}{{--                <a href="#" class="btn btn-primary">Go somewhere</a>--}}
{{--            </div>--}}
{{--        </div>--}}


{{--    </div>--}}



{{--    <div class="card text-white bg-dark mb-3 m-1">--}}

{{--        <div class="card-body">--}}
{{--            <h5 class="card-title">Spotfire Database</h5>--}}
{{--            <div class="dataOkIcon">--}}
{{--                --}}{{--                    @if ($furnaceDataOK == true)--}}
{{--                --}}{{--                        <i class="fa fa-check-circle" style="font-size:40px;color: #61b861;" aria-hidden="true"></i>--}}
{{--                --}}{{--                    @else--}}
{{--                --}}{{--                        <i class="fa fa-times-circle" style="font-size:40px;color: #da2525;" aria-hidden="true"></i>--}}
{{--                --}}{{--                    @endif--}}

{{--            </div>--}}

{{--            <table class="table table-striped table-dark text-white">--}}
{{--                <thead>--}}
{{--                <th style="padding:5px;">TableName</th>--}}
{{--                <th style="padding:5px;">LastUpdate</th>--}}
{{--                <th style="padding:5px;">RowCount</th>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @foreach ($azureDBStats as $stats)--}}
{{--                    <tr>--}}
{{--                        <td style="padding:2px;">{{$stats["table_name"]}}</td>--}}
{{--                        <td style="padding:2px;">{{$stats["update_date_time"]}}</td>--}}
{{--                        <td style="padding:2px;">{{$stats["row_count"]}}</td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}

{{--            </table>--}}


{{--            --}}{{--                <a href="#" class="btn btn-primary">Go somewhere</a>--}}
{{--        </div>--}}
{{--    </div>--}}

{{phpinfo()}}



@endsection
//7.1.12
