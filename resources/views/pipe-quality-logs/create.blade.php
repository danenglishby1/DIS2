@extends('layouts.app')

@section('pageTitle', 'Add Pipe Quality Log')
@section('pageName', 'Add Pipe Quality Log')
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

                <form method="post" action="{{ route('pipe-quality-logs.store') }}" enctype="multipart/form-data">
                    @csrf

                    <h3 style="text-align: center">Add log detail for pipe: {{$pipe_no}}    {{($pipeTrackingData[0]["TRACK_CODE_ALT"] == "00000000" ? "" : "Section = " . $pipeTrackingData[0]["TRACK_CODE_ALT"])}}</h3>


                    <div class="" id="pipeinfo" style="margin-bottom:20px;display: flex;justify-content: space-between;">

                    <div>
                    <div>Programme Ref: {{$pipeTrackingData[0]["ROLL_WEEK"] . " " . $pipeTrackingData[0]["BLOCK_NO"] . " " . $pipeTrackingData[0]["MILL_LINE"]. " " . $pipeTrackingData[0]["OHS_LINE"]}}</div>
                    <div>Process Route: {{$pipeTrackingData[0]["PROCESS_ROUTE"]}}</div>
                    <div>Pipe Length : {{$pipeTrackingData[0]["PIPE_LENGTH"]}}</div>
                    <div>LTR : {{$pipeTrackingData[0]["PIPE_LENGTH_TO_REMOVE"]}}</div>
                    <div>Status Code : {{$pipeTrackingData[0]["PIPE_STATUS_CODE"]}}</div>
                    </div>
                        <div>
                    <div>Cast No : {{$pipeTrackingData[0]["CAST_NO"]}}</div>
                    <div>Coil No : {{$pipeTrackingData[0]["COIL_NO"]}}</div>
                    <div>S1 : {{$pipeTrackingData[0]["PIPE_SIZE1"]}}</div>
                    <div>S2 : {{$pipeTrackingData[0]["PIPE_SIZE2"]}}</div>
                    <div>Thick : {{$pipeTrackingData[0]["PIPE_THICK"]}}</div>
                    <div>Pipe Weight (Theoretical) : {{$pipeTrackingData[0]["T_WEIGHT"]}}</div>
                        </div>
                    </div>

<div>
                    <div class="">
                        <div class="form-group m-1">
                            <label for="fault_diagnosis">Fault Diagnosis</label>
                            <select class="form-control" name="fault_diagnosis">
                                <option value="">Please Select</option>
                                <option value="CALIBRATION SITE 1">CALIBRATION SITE 1</option>
                                <option value="CALIBRATION SITE 2">CALIBRATION SITE 2</option>
                                <option value="INLINE INDICATION">INLINE INDICATION</option>
                                <option value="ENTRAPPED MATERIAL">ENTRAPPED MATERIAL</option>
                                <option value="COLD WELD">COLD WELD</option>
                                <option value="OPEN SEAM">OPEN SEAM</option>
                                <option value="DAMAGED EDGE">DAMAGED EDGE</option>
                                <option value="WELD FAULT">WELD FAULT</option>
                                <option value="SLAB EDGE">SLAB EDGE</option>
                                <option value="EDGE LAM TO SURFACE">EDGE LAM TO SURFACE</option>
                                <option value="EDGE LAM SUBSURFACE">EDGE LAM SUBSURFACE</option>
                                <option value="EDGE LAM">EDGE LAM</option>
                                <option value="LOW SQUEEZE">LOW SQUEEZE</option>
                                <option value="POOR PUSH OUT">POOR PUSH OUT</option>
                                <option value="VISIBLE LAMS">VISIBLE LAMS</option>
                                <option value="ID TRIM">ID TRIM</option>
                                <option value="TRIM SKIP">TRIM SKIP</option>
                                <option value="NAD">NAD</option>
                                <option value="GROSS OFFSET">GROSS OFFSET</option>
                                <option value="OFFSET">OFFSET</option>
                                <option value="TRIM TOOL TOO DEEP">TRIM TOOL TOO DEEP</option>
                                <option value="UNTRIMMED">UNTRIMMED</option>
                                <option value="ROLLED IN TRIM">ROLLED IN TRIM</option>
                                <option value="OVER TEMP">OVER TEMP</option>
                                <option value="BODY SPLIT">BODY SPLIT</option>
                                <option value="LAMINATION">LAMINATION</option>
                                <option value="HIGH ID">HIGH ID</option>
                                <option value="UNDERCUT">UNDERCUT</option>
                                <option value="BUILD UP">BUILD UP</option>
                                <option value="SCRAP">SCRAP</option>
                                <option value="UNKNOWN">UNKNOWN</option>
                                <option value="COLLAPSED EDGE">COLLAPSED EDGE</option>
                                <option value="ROLL MARKS">ROLL MARKS</option>
                                <option value="EDGE THICKENING">EDGE THICKENING</option>
                                <option value="LAPPED">LAPPED</option>
                                <option value="MECHANICAL DAMAGE">MECHANICAL DAMAGE</option>
                                <option value="CONCESSION COIL">CONCESSION COIL</option>
                                <option value="TRIM TOOL DAMAGE">TRIM TOOL DAMAGE</option>
                                <option value="WEAK DIVERSIONS">WEAK DIVERSIONS</option>
                                <option value="ROLL MARK TOP">ROLL MARK TOP</option>
                                <option value="ROLL MARK BOTTOM">ROLL MARK BOTTOM</option>
                                <option value="WELD IN TOP NORTH CORNER">WELD IN TOP NORTH CORNER</option>
                                <option value="WELD IN TOP SOUTH CORNER">WELD IN TOP SOUTH CORNER</option>
                                <option value="STRAIGHTNESS">STRAIGHTNESS</option>
                                <option value="CONVEXITY">CONVEXITY</option>
                                <option value="CONCAVITY">CONCAVITY</option>
                                <option value="OOS CORNER RADIUS">OOS CORNER RADIUS</option>
                                <option value="SHAPE ISSUE">SHAPE ISSUE</option>
                                <option value="FLATTENING FAILURE">FLATTENING FAILURE</option>
                                <option value="1/10 CHECKS">1/10 CHECKS</option>
                                <option value="OVALITY CHECKS">OVALITY CHECKS</option>

                            </select>
                        </div>

                        <div class="form-group m-1">
                            <label for="fault-diagnosis">Position</label>
                            <select class="form-control" name="position">
                                <option value="">Please Select</option>
                                <option value="NONE">NONE</option>
                                <option value="OD">OD</option>
                                <option value="ID">ID</option>
                                <option value="MW">MW</option>
                                <option value="ID NORTH">ID NORTH</option>
                                <option value="ID SOUTH">ID SOUTH</option>
                                <option value="OD NORTH">OD NORTH</option>
                                <option value="OD SOUTH">OD SOUTH</option>
                                <option value="MW NORTH">MW NORTH</option>
                                <option value="MW SOUTH">MW SOUTH</option>
                                <option value="THROUGH WALL">THROUGH WALL</option>
                                <option value="IDM">IDM</option>
                                <option value="ODM">ODM</option>
                                <option value="MWM">MWM</option>
                                <option value="IDOD">ID OD</option>
                            </select>
                        </div>

                        <div class="form-group m-1">
                            <label for="response">Response</label>
                            <select class="form-control" name="response">
                                <option value=" "> </option>
                                <option value="CLEAR">CLEAR</option>
                                <option value="N5">N5</option>
                                <option value="N5-">N5-</option>
                                <option value="N5+">N5+</option>
                                <option value="2X-N5">2X-N5</option>
                                <option value="2XN5+">2XN5+</option>
                                <option value="N10-">N10-</option>
                                <option value="N10+">N10+</option>
                                <option value="2X-N10">2X-N10</option>
                                <option value="2XN10+">2XN10+</option>
                                <option value="N15-">N15-</option>
                                <option value="N15+">N15+</option>
                                <option value="2X-N15">2X-N15</option>
                                <option value="2XN15+">2XN15+</option>
                                <option value="FSH">FSH</option>
                                <option value="2XFSH">2XFSH</option>
                                <option value="2XN5 N10">2XN5 N10</option>
                            </select>
                        </div>

                        <div class="form-group m-1">
                            <label for="area">Area</label>
                            <select class="form-control" name="area">
{{--                                <option value="Weld Mill">Weld Mill</option>--}}
{{--                                <option value="Finishing">Finishing</option>--}}
                                <option value="Weld Mill NDT">Weld Mill NDT</option>
                                <option value="RHS">RHS</option>
                                <option value="LABS">LABS</option>
                                <option value="Casing">Casing</option>
                                <option value="Mill Desk">Mill Desk</option>

                                <option value="FCO">FCO</option>
                                <option value="Intermediate Inspection">Intermediate Inspection</option>
                                <option value="Site 2 Finishing">Site 2 Finishing</option>
                                <option value="Final Inspection">Final Inspection</option>
                                <option value="Production Services">Production Services</option>
                                <option value="RHS">RHS</option>
                                <option value="Casing Mill Inspection">Casing Mill Inspection</option>
                            </select>
                        </div>

                        <br />
                        <div class="form-group m-1">
                            <div>  <label for="cut_back_length">Loss Length</label></div>
                            <input type="number" step="any" name="cut_back_length" value="{{$pipeTrackingData[0]["PIPE_LENGTH"]}}" >
                        </div>
                        <br />

                        <div class="form-group m-1">
                            <label for="comments">Comments</label>
                        <textarea style="width:100%" name="comments"></textarea>
                        </div>

                        <input type="hidden" name="PR" value="{{$pipeTrackingData[0]["PROCESS_ROUTE"]}}">
                        <input type="hidden" name="S1" value="{{$pipeTrackingData[0]["PIPE_SIZE1"]}}">
                        <input type="hidden" name="S2" value="{{$pipeTrackingData[0]["PIPE_SIZE2"]}}">
                        <input type="hidden" name="thickness" value="{{$pipeTrackingData[0]["PIPE_THICK"]}}">
                        <input type="hidden" name="ltr" value="{{$pipeTrackingData[0]["PIPE_LENGTH_TO_REMOVE"]}}">
                        <input type="hidden" name="pipe_length" value="{{$pipeTrackingData[0]["PIPE_LENGTH"]}}">
                        <input type="hidden" name="routingPos" value="{{$pipeTrackingData[0]["ROUTING_POS"]}}">
                        <input type="hidden" name="pipeStatusCode" value="{{$pipeTrackingData[0]["PIPE_STATUS_CODE"]}}">
                        <input type="hidden" name="statusDetailCode" value="{{$pipeTrackingData[0]["STATUS_DETAIL_CODE"]}}">
                        <input type="hidden" name="castNo" value="{{$pipeTrackingData[0]["COIL_CAST_NO"]}}">
                        <input type="hidden" name="supplier" value="{{$pipeTrackingData[0]["SUPPLIER_CODE"]}}">
                        <input type="hidden" name="weight" value="{{$pipeTrackingData[0]["T_WEIGHT"]}}">
                        <input type="hidden" name="grade" value="{{$grade}}">
                        <input type="hidden" name="quality" value="{{$coilQuality}}">
                        <input type="hidden" name="XDEBUG_TRIGGER" value="1">
{{--                        <input type="hidden" name="thickness" value="{{$pipeTrackingData[0]["QUALITY"]}}">--}}
                    </div>

    <div>


        <div style="display: flex;">
            <div class="form-group m-1">
                <label for="response">FE OOR A</label>
                <input type="text" class="form-control" name="fe_oor_a">
            </div>

            <div class="form-group m-1">
                <label for="response">FE OOR B</label>
                <input type="text" class="form-control" name="fe_oor_b">
            </div>

            <div class="form-group m-1">
                <label for="response">FE OOR C</label>
                <input type="text" class="form-control" name="fe_oor_c">
            </div>

            <div class="form-group m-1">
                <label for="response">FE OOR D</label>
                <input type="text" class="form-control" name="fe_oor_d">
            </div>
            <div class="form-group m-1">
                <label for="response">RE OOR A</label>
                <input type="text" class="form-control" name="re_oor_a">
            </div>

            <div class="form-group m-1">
                <label for="response">RE OOR B</label>
                <input type="text" class="form-control" name="re_oor_b">
            </div>

            <div class="form-group m-1">
                <label for="response">RE OOR C</label>
                <input type="text" class="form-control" name="re_oor_c">
            </div>

            <div class="form-group m-1">
                <label for="response">RE OOR D</label>
                <input type="text" class="form-control" name="re_oor_d">
            </div>

        </div>


        <div style="display: flex;">


        </div>

        <div style="display:flex;">




        </div>

        <div style="display: flex">

            <div class="form-group m-1">
                <label for="fe_weld_thick">FE Weld Thick</label>
                <input type="text" class="form-control" name="fe_weld_thick">
            </div>

            <div class="form-group m-1">
                <label for="fe_weld_thick">FE Body Thick</label>
                <input type="text" class="form-control" name="body_thick">
            </div>


            <div class="form-group m-1">
                <label for="fe_weld_thick">RE Weld Thick</label>
                <input type="text" class="form-control" name="re_weld_thick">
            </div>

            <div class="form-group m-1">
                <label for="fe_weld_thick">RE Body Thick</label>
                <input type="text" class="form-control" name="re_body_thick">
            </div>



        </div>

        <div style="display: flex">



            <div class="form-group m-1">
                <label for="fe_bevel_angle">FE Bevel Angle</label>
                <input type="text" class="form-control" name="fe_bevel_angle">
            </div>

            <div class="form-group m-1">
                <label for="root_face">FE Root Face</label>
                <input type="text" class="form-control" name="fe_root_face">
            </div>


            <div class="form-group m-1">
                <label for="fe_bevel_angle">RE Bevel Angle</label>
                <input type="text" class="form-control" name="re_bevel_angle">
            </div>

            <div class="form-group m-1">
                <label for="root_face">RE Root Face</label>
                <input type="text" class="form-control" name="re_root_face">
            </div>

        </div>

        <div style="display: flex">


            <div class="form-group m-1">
                <label for="od_tape">FE OD Tape</label>
                <input type="text" class="form-control" name="od_tape">
            </div>

            <div class="form-group m-1">
                <label for="re_od_tape">RE OD Tape</label>
                <input type="text" class="form-control" name="re_od_tape">
            </div>

            <div class="form-group m-1">
                <label for="od_tape">FE ID Tape</label>
                <input type="text" class="form-control" name="id_tape">
            </div>

            <div class="form-group m-1">
                <label for="od_tape">RE ID Tape</label>
                <input type="text" class="form-control" name="re_id_tape">
            </div>
            <div class="form-group m-1">
                <label for="straightness">Straightness</label>
                <input type="text" class="form-control" name="straightness">
            </div>


            <div class="form-group m-1">
                <label for="go_no_go">Go No Go</label>
                <select class="form-control" name="go_no_go">
                    <option value=""></option>
                    <option value="NDT">Y</option>
                    <option value="MPI">N</option>
                </select>
            </div>

            <div class="form-group m-1">
                <label for="ndt">NDT</label>
                <select class="form-control" name="ndt">
                    <option value=""></option>
                    <option value="UT">UT</option>
                    <option value="MPI">MPI</option>
                    <option value="BOTH">BOTH</option>
                </select>
            </div>

            <div class="form-group m-1">
                <label for="drifted">Drifted</label>
                <select class="form-control" name="drifted">
                    <option value=""></option>
                    <option value="Y">Y</option>
                    <option value="N">N</option>
                </select>
            </div>



            <div class="form-group m-1">
                <label for="label_length">Label Length</label>
                <input type="text" class="form-control" name="label_length">
            </div>

            <div class="form-group m-1">
                <label for="shift">Shift</label>
                <select class="form-control" name="shift">
                    <option value=""></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>



        </div>

        <input type="hidden" name="pipe_no" value="{{$pipe_no}}">
{{--                        <div class="form-group m-1">--}}
{{--                            <label for="technician">Technician</label>--}}
{{--                            <input type="text" class="form-control" name="technician"/>--}}
{{--                        </div>--}}

                    </div>
</div>
                    <button type="submit" class="btn btn-primary">Add Log</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('functionalScripts')
    <script>


    </script>


@endsection
