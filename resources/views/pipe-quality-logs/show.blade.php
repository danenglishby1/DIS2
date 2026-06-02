@extends('layouts.app')

@section('pageTitle', 'Pipe Quality Log')
@section('pageName', 'Pipe Quality Log')
@section('content')
    <div class="row" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
        <div class="col-sm-8 offset-sm-2">
            <h2 class="display-3"></h2>
            <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br/>
                @endif

                <h3>Pipe: {{$trackingData[0]["TRACK_CODE"]}}</h3>
                <hr/>
                <h4>Tracking Data (LIVE)</h4>
                <table class="table">
                    <thead>
                    <th>Pipe No</th>
                    <th>Section No</th>
                    <th>Coil No</th>
                    <th>Block</th>
                    <th>RPOS</th>
                    <th>S1</th>
                    <th>S2</th>
                    <th>Thick</th>
                    <th>PR</th>
                    <th>Len</th>
                    <th>Status Code</th>
                    <th>Inspected?</th>
                    <th>Weight</th>
                    </thead>

                    <tr>
                        <td>{{$trackingData[0]["TRACK_CODE"]}}</td>
                        <td>{{$trackingData[0]["TRACK_CODE_ALT"]}}</td>
                        <td>{{$trackingData[0]["COIL_NO"]}}</td>
                        <td>{{$trackingData[0]["BLOCK_NO"]}}</td>
                        <td>{{$trackingData[0]["ROUTING_POS"]}}</td>
                        <td>{{$trackingData[0]["PIPE_SIZE1"]}}</td>
                        <td>{{$trackingData[0]["PIPE_SIZE2"]}}</td>
                        <td>{{$trackingData[0]["PIPE_THICK"]}}</td>
                        <td>{{$trackingData[0]["PROCESS_ROUTE"]}}</td>
                        <td>{{$trackingData[0]["PIPE_LENGTH"]}}</td>
                        <td style="font-weight:bold">{{$trackingData[0]["PIPE_STATUS_CODE"]}}</td>
                        <td>{{$trackingData[0]["T_WEIGHT"]}}</td>
                    </tr>
                </table>

                @if(count($pipeQualityLogData) > 0)
                        <h4>Pipe Quality Log</h4>
                    <table class="table">
                        <thead>
                        <th>Pipe</th>
                        <th>Logged By</th>
                        <th>Quality</th>
                        <th>Fault Diagnosis</th>
                        <th>Position</th>
                        <th>Response</th>
                        <th>Area</th>
                        <th>Inspected</th>
                        <th>Comments</th>
                        <th>Created At</th>
                        <th>Delete</th>
                        </thead>
                        @foreach($pipeQualityLogData as $r)
                        <tr>
                            <td>{{$r["pipe_no"]}}</td>
                            <td>{{$r["user"]["name"]}}</td>
                            <td>{{$r["quality"]}}</td>
                            <td>{{$r["fault_diagnosis"]}}</td>
                            <td>{{$r["position"]}}</td>
                            <td>{{$r["response"]}}</td>
                            <td>{{$r["area"]}}</td>
                            <td>{{$r["inspected"]}}</td>
                            <td>{{$r["comments"]}}</td>
                            <td>{{date('Y-m-d H:i:s', strtotime($r["created_at"]))}}</td>
                            <td><form method="post" class="delete-form"
                                      action="{{ route('pipe-quality-logs.destroy', $r["id"])}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-1" type="submit">Delete</button>
                                </form>
                                </td>

                        </tr>
@endforeach

                    </table>





                @endif




                    <h4>Variable / Other Data</h4>
                    <table class="table">
                        <thead>
                        <th>FE OOR A</th>
                        <th>FE OOR B</th>
                        <th>FE OOR C</th>
                        <th>FE OOR D</th>
                        <th>FE OOR TOTAL</th>
                        <th>RE OOR A</th>
                        <th>RE OOR B</th>
                        <th>RE OOR C</th>
                        <th>RE OOR D</th>
                        <th>RE OOR TOTAL</th>
                        <th>FE OD TAPE</th>
                        <th>RE OD TAPE</th>
                        <th>FE WELD THICK</th>
                        <th>RE WELD THICK</th>
                        <th>FE BODY THICK</th>
                        <th>RE BODY THICK</th>
                        <th>STRAIGHTNESS</th>
                        <th>FE BEVEL ANGLE</th>
                        <th>RE BEVEL ANGLE</th>
                        <th>NDT</th>
                        <th>DRIFTED</th>

                        </thead>
                        <tr>
                            <td>{{(isset($pipeQualityLogData[0]["fe_oor_a"]) ? $pipeQualityLogData[0]["fe_oor_a"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["fe_oor_b"]) ? $pipeQualityLogData[0]["fe_oor_b"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["fe_oor_c"]) ? $pipeQualityLogData[0]["fe_oor_c"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["fe_oor_d"]) ? $pipeQualityLogData[0]["fe_oor_d"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["fe_oor_total"]) ? $pipeQualityLogData[0]["fe_oor_total"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["re_oor_a"]) ? $pipeQualityLogData[0]["re_oor_a"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["re_oor_b"]) ? $pipeQualityLogData[0]["re_oor_b"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["re_oor_c"]) ? $pipeQualityLogData[0]["re_oor_c"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["re_oor_d"]) ? $pipeQualityLogData[0]["re_oor_d"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["re_oor_total"]) ? $pipeQualityLogData[0]["re_oor_total"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["od_tape"]) ? $pipeQualityLogData[0]["od_tape"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["re_od_tape"]) ? $pipeQualityLogData[0]["re_od_tape"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["fe_weld_thick"]) ? $pipeQualityLogData[0]["fe_weld_thick"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["re_weld_thick"]) ? $pipeQualityLogData[0]["re_weld_thick"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["body_thick"]) ? $pipeQualityLogData[0]["body_thick"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["re_body_thick"]) ? $pipeQualityLogData[0]["re_body_thick"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["straightness"]) ? $pipeQualityLogData[0]["straightness"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["fe_bevel_angle"]) ? $pipeQualityLogData[0]["fe_bevel_angle"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["re_bevel_angle"]) ? $pipeQualityLogData[0]["re_bevel_angle"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["ndt"]) ? $pipeQualityLogData[0]["ndt"] : "")}}</td>
                            <td>{{(isset($pipeQualityLogData[0]["drifted"]) ? $pipeQualityLogData[0]["drifted"] : "")}}</td>

                        </tr>
                    </table>
                @if(count($macroData) > 0)
                    <h4>Macro Data</h4>
                    <hr/>
                    {{--                        {{dd($macroData)}}--}}
                    View Macro: <a href="{{ route('wm-macros.show',$macroData[0]["id"])}}">View </a>
                @endif


<br />
<br />

                    @if(count($usrData) > 0)
                        <h4>USR Data</h4>
                        <hr/>
                        {{--                        {{dd($macroData)}}--}}
                        View USR: <a href="{{ route('usr.show',$usrData[0]["id"])}}">View </a>
                    @endif


            </div>
        </div>
    </div>
@endsection

@section('functionalScripts')
    <script>
    </script>

@endsection
