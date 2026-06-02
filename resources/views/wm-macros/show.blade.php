@extends('layouts.app')

@section('pageTitle', 'Macro Details')
@section('pageName', 'Macro Details')
@section('content')
    <div class="row">
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

                <dl class="row">

                    <dt class="col-sm-2">WEEK/YEAR</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->WEEK_YEAR }}</dd>
                    <dt class="col-sm-2">COIL</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->COIL }}</dd>
                    <dt class="col-sm-2">PIPE</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->PIPE }}</dd>
                    <dt class="col-sm-2">THICKNESS</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->THK }}</dd>
                    <dt class="col-sm-2">GRADE</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->GRADE }}</dd>
                    <dt class="col-sm-2">QUALITY</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->QUALITY }}</dd>
                    <dt class="col-sm-2">SPEED FPM</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->SPEED_FPM }}</dd>
                    <dt class="col-sm-2">WELD TEMP</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->WELD_TEMP }}</dd>
                    <dt class="col-sm-2">POWER</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->POWER }}</dd>
                    <dt class="col-sm-2">FREQ</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->FREQ }}</dd>
                    <dt class="col-sm-2">WIDTH</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->WIDTH }}</dd>
                    <dt class="col-sm-2">IGS</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->IGS }}</dd>
                    <dt class="col-sm-2">HEAD ROLL SPACER</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->H_ROLL_SPACER }}</dd>
{{--                    <dt class="col-sm-2">HEAD ROLL RE-GRIND</dt>--}}
{{--                    <dd class="col-sm-2">{{ $macroDataRecord->H_ROLL_RE_GRIND }}</dd>--}}
{{--                    <dt class="col-sm-2">HEAD ROLL GAP</dt>--}}
{{--                    <dd class="col-sm-2">{{ $macroDataRecord->H_ROLL_GAP }}</dd>--}}
                    <dt class="col-sm-2">PRE FINS</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->PRE_FINS }}</dd>
                    <dt class="col-sm-2">PRE WELD</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->PRE_WELD }}</dd>
                    <dt class="col-sm-2">POST WELD</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->POST_WELD }}</dd>
                    <dt class="col-sm-2">OUTSIDE DIVERSIONS</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->OUTSIDE_DIAMETER }}</dd>
                    <dt class="col-sm-2">OUTSIDE DIVERSIONS NORTH</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->OUTSIDE_DIAMETER_NORTH }}</dd>
                    <dt class="col-sm-2">OUTSIDE DIVERSIONS SOUTH</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->OUTSIDE_DIAMETER_SOUTH }}</dd>
                    <dt class="col-sm-2">OUTSIDE DIVERSIONS AVG</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->OUTSIDE_DIAMETER_AVG }}</dd>
                    <dt class="col-sm-2">INSIDE DIVERSIONS NORTH</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->INSIDE_DIAMETER_NORTH }}</dd>
                    <dt class="col-sm-2">INSIDE DIVERSIONS SOUTH</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->INSIDE_DIAMETER_SOUTH }}</dd>
                    <dt class="col-sm-2">INSIDE DIVERSIONS AVG</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->INSIDE_DIAMETER_AVG }}</dd>
                    <dt class="col-sm-2">INSIDE DIVERSIONS</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->INSIDE_DIAMETER }}</dd>
                    <dt class="col-sm-2">WELD LINE OD</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->WELD_LINE_OD }}</dd>
                    <dt class="col-sm-2">WELD LINE ID</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->WELD_LINE_ID }}</dd>
                    <dt class="col-sm-2">HAZ OD</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->HAZ_OD }}</dd>
                    <dt class="col-sm-2">HAZ MID</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->HAZ_MID }}</dd>
                    <dt class="col-sm-2">HAZ ID</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->HAZ_ID }}</dd>
                    <dt class="col-sm-2">SWERVE</dt>
                    <dd class="col-sm-2">{{ (isset($swerveLookupTable[$macroDataRecord->SWERVE]) ? $swerveLookupTable[$macroDataRecord->SWERVE] : "") }}</dd>
                    <dt class="col-sm-2">A ANNEAL TEMP</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->A_ANNEAL_TEMP }}</dd>

                    <dt class="col-sm-2">A % POWER</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['A_%_POWER']}}</dd>

                    <dt class="col-sm-2">B ANNEAL TEMP</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->B_ANNEAL_TEMP }}</dd>

                    <dt class="col-sm-2">B % POWER</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['B_%_POWER']}}</dd>

                    <dt class="col-sm-2">C ANNEAL TEMP</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->C_ANNEAL_TEMP }}</dd>

                    <dt class="col-sm-2">C % POWER</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['C_%_POWER']}}</dd>

                    <dt class="col-sm-2">D ANNEAL TEMP</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->D_ANNEAL_TEMP }}</dd>

                    <dt class="col-sm-2">D % POWER</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['D_%_POWER']}}</dd>

                    <dt class="col-sm-2">E ANNEAL TEMP</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord->E_ANNEAL_TEMP }}</dd>

                    <dt class="col-sm-2">E % POWER</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['E_%_POWER']}}</dd>

                    <dt class="col-sm-2">920 OD</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['920_OD']}}</dd>

                    <dt class="col-sm-2">ALIGN</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['ALIGN']}}</dd>

                    <dt class="col-sm-2">920 ID</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['920_ID']}}</dd>

                    <dt class="col-sm-2">QUENCH</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['QUENCH']}}</dd>

                    <dt class="col-sm-2">PRE QUENCH TEMP</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['PRE_SIZE_TEMP']}}</dd>


                    <dt class="col-sm-2">TRACK LINE</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['TRACK_LINE']}}</dd>

                    <dt class="col-sm-2">XIRIS V-ANGLE</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['XIRIS_V_ANGLE']}}</dd>

                    <dt class="col-sm-2">COOLING 1</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['COOLING_1']}}</dd>

                    <dt class="col-sm-2">COOLING 2</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['COOLING_2']}}</dd>

                    <dt class="col-sm-2">COOLING 3</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['COOLING_3']}}</dd>

                    <dt class="col-sm-2">POST QUENCH TEMP</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['QUENCH_TEMP']}}</dd>

                    <dt class="col-sm-2">COMMENT</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['COMMENT']}}</dd>

                    <dt class="col-sm-2">TECHNICIAN</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['TECHNICIAN']}}</dd>

                    <dt class="col-sm-2">SHIFT</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['SHIFT']}}</dd>

{{--                    <dt class="col-sm-2">DATE</dt>--}}
{{--                    <dd class="col-sm-2">{{ $macroDataRecord['DATE']}}</dd>--}}

                    <dt class="col-sm-2">A ANNEAL TEMP</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['A_ANNEAL_TEMP']}}</dd>

                    <dt class="col-sm-2">B ANNEAL TEMP</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['B_ANNEAL_TEMP']}}</dd>

                    <dt class="col-sm-2">C ANNEAL TEMP</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['C_ANNEAL_TEMP']}}</dd>

                    <dt class="col-sm-2">D ANNEAL TEMP</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['D_ANNEAL_TEMP']}}</dd>

                    <dt class="col-sm-2">E ANNEAL TEMP</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['E_ANNEAL_TEMP']}}</dd>

                    <dt class="col-sm-2">DIAM RANGE</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['DIAM_RANGE']}}</dd>

                    <dt class="col-sm-2">SKELP GAP</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['SKELP_GAP']}}</dd>

                    <dt class="col-sm-2">IMPEDER NUMBER</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['IMPEDER_NUMBER']}}</dd>

{{--                    <dt class="col-sm-2">REASON FOR ADJUSTMENT</dt>--}}
{{--                    <dd class="col-sm-2">{{ $macroDataRecord['REASON_FOR_ADJUSTMENT']}}</dd>--}}

                    <dt class="col-sm-2">COIL POSITION</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['COIL_POSITION']}}</dd>


                    <dt class="col-sm-2">TRIM BAR NUMBER</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['TRIM_BAR_NUMBER']}}</dd>


                    <dt class="col-sm-2">ID CARRIAGE NUMBER</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['ID_CARRIAGE_NUMBER']}}</dd>


                    {{--                    <dt class="col-sm-2">IMAGE</dt>--}}
{{--                    <dd class="col-sm-2">{{ $macroDataRecord['IMAGE']}}</dd>--}}

                    <dt class="col-sm-2">CREATED_AT</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['CREATED_AT']}}</dd>

                    <dt class="col-sm-2">UPDATED_AT</dt>
                    <dd class="col-sm-2">{{ $macroDataRecord['UPDATED_AT']}}</dd>

                    {{--                <a href="{{ route('users.edit',$user->id)}}" class="btn btn-primary ml-3">Edit</a>--}}

                </dl>
                    @if ($macroDataRecord->IMAGE !== "")
                <img style="width:100%;" src="{{asset('public/storage/macros/'.$macroDataRecord->IMAGE)}}"/>
                    @endif
                    {{-- $userId == R.Butler || $userId == LABS || $userId == D.E --}}
                    @if($userId == 47 || $userId == 56 || $userId == 4)
                    <a href="{{ route('wm-macros.edit',$macroDataRecord->id)}}" class="btn btn-warning mb-2 mt-2 p-2">Edit This Macro</a>
                        @endif
            </div>
        </div>
    </div>

@endsection
