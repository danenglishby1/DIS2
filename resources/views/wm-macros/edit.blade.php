@extends('layouts.app')

@section('pageTitle', 'Edit Macro')
@section('pageName', 'Edit Macro')
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
                <form method="post" action="{{ route('wm-macros.update', $macro->id) }}" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="d-flex flex-wrap justify-content-center" style="margin-top: -70px;">
                        <div class="form-group m-1">
                            <label for="diam_range">Diam Range</label>
                            <input type="text" class="form-control" name="diam_range" value="{{$macro->DIAM_RANGE}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="technician">Technician</label>
                            <input type="text" class="form-control" name="technician" value="{{$macro->TECHNICIAN}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="igs">IGS</label>
                            <select class="form-control" name="igs">
                                {{($macro->IGS == "" ? "<option selected value=''>Please Select...</option>" : "")}}
                                <option value="No" {{($macro->IGS == "No" ? "selected" : "")}}>No</option>
                                <option value="Yes" {{($macro->IGS == "Yes" ? "selected" : "")}} >Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap justify-content-around">

                        <div class="form-group m-1">
                            <label for="week_year">Week Year</label>
                            <input type="number" max="52" class="form-control" name="week_year"
                                   value="{{$macro->WEEK_YEAR}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="coil">Coil</label>
                            <input type="number" max="999" class="form-control" name="coil" value="{{$macro->COIL}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="pipe">Pipe</label>
                            <input type="number" max="99" class="form-control" name="pipe" value="{{$macro->PIPE}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="thk">Thk</label>
                            <input type="text" class="form-control" name="thk" value="{{$macro->THK}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="grade">Grade</label>
                            <input type="text" class="form-control" name="grade" value="{{$macro->GRADE}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="quality">Quality</label>
                            <input type="text" class="form-control" name="quality" value="{{$macro->QUALITY}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="speed_fpm">Speed FPM</label>
                            <input type="text" class="form-control" name="speed_fpm" value="{{$macro->SPEED_FPM}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="weld_temp">Weld Temp</label>
                            <input type="text" class="form-control" name="weld_temp" value="{{$macro->WELD_TEMP}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="power">Power</label>
                            <input type="text" class="form-control" name="power" value="{{$macro->POWER}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="freq">Freq</label>
                            <input type="text" class="form-control" name="freq" value="{{$macro->FREQ}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="width">Width</label>
                            <input type="text" class="form-control" name="width" value="{{$macro->WIDTH}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="h_roll_spacer">Head Roll Spacer</label>
                            <input type="text" class="form-control" name="h_roll_spacer"
                                   value="{{$macro->H_ROLL_SPACER}}"/>
                        </div>

{{--                        <div class="form-group m-1">--}}
{{--                            <label for="h_roll_re_grind">Head Roll Re-Grind</label>--}}
{{--                            <input type="text" class="form-control" name="h_roll_re_grind"--}}
{{--                                   value="{{$macro->H_ROLL_RE_GRIND}}"/>--}}
{{--                        </div>--}}

{{--                        <div class="form-group m-1">--}}
{{--                            <label for="h_roll_gap">Head Roll Gap</label>--}}
{{--                            <input type="text" class="form-control" name="h_roll_gap"--}}
{{--                                   value="{{$macro->H_ROLL_GAP}}"/>--}}
{{--                        </div>--}}

                        <div class="form-group m-1">
                            <label for="pre_fins">Pre Fins</label>
                            <input type="text" class="form-control" name="pre_fins" value="{{$macro->PRE_FINS}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="pre_weld">Pre Weld</label>
                            <input type="text" class="form-control" name="pre_weld" value="{{$macro->PRE_WELD}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="post_weld">Post Weld</label>
                            <input type="text" class="form-control" name="post_weld" value="{{$macro->POST_WELD}}"/>
                        </div>


                        <div class="form-group m-1">
                            <label for="outside_diameter">OD Diversions North</label>
                            <input type="text" class="form-control" id="outside_diameter_north" name="outside_diameter_north"
                                   value="{{$macro->OUTSIDE_DIAMETER_NORTH}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="outside_diameter">OD Diversions South</label>
                            <input type="text" class="form-control" id="outside_diameter_south" name="outside_diameter_south"
                                   value="{{$macro->OUTSIDE_DIAMETER_SOUTH}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="outside_diameter">OD Diversions Avg</label>
                            <input type="text" class="form-control" id="outside_diameter_ns_avg" name="outside_diameter_ns_avg"
                                   value="{{$macro->OUTSIDE_DIAMETER_AVG}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="swerve">Weld Comment</label>
                            <select class="form-control" name="swerve">
                                <option value="0" {{($macro->SWERVE == 0 ? "selected" : "")}}>Straight</option>
                                <option value="1" {{($macro->SWERVE == 1 ? "selected" : "")}}>Swerved South</option>
                                <option value="2" {{($macro->SWERVE == 2 ? "selected" : "")}}>Angled South</option>
                                <option value="3" {{($macro->SWERVE == 3 ? "selected" : "")}}>Swerved North</option>
                                <option value="4" {{($macro->SWERVE == 4 ? "selected" : "")}}>Angled North</option>
                                <option value="5" {{($macro->SWERVE == 5 ? "selected" : "")}}>Dog Leg</option>
                                <option value="6" {{($macro->SWERVE == 6 ? "selected" : "")}}>Sound Weld</option>
                                <option value="7" {{($macro->SWERVE == 7 ? "selected" : "")}}>Low Divs</option>
                            </select>
                        </div>


                        <div class="form-group m-1">
                            <label for="inside_diameter">ID Diversions North</label>
                            <input type="text" class="form-control" id="inside_diameter_north" name="inside_diameter_north"
                                   value="{{$macro->INSIDE_DIAMETER_NORTH}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="inside_diameter">ID Diversions South</label>
                            <input type="text" class="form-control" id="inside_diameter_south" name="inside_diameter_south"
                                   value="{{$macro->INSIDE_DIAMETER_SOUTH}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="outside_diameter">ID Diversions Avg</label>
                            <input type="text" class="form-control" id="inside_diameter_ns_avg" name="inside_diameter_ns_avg"
                                   value="{{$macro->INSIDE_DIAMETER_AVG}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="weld_line_od">Weld Line OD</label>
                            <input type="text" class="form-control" name="weld_line_od"
                                   value="{{$macro->WELD_LINE_OD}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="weld_line_id">Weld Line ID</label>
                            <input type="text" class="form-control" name="weld_line_id"
                                   value="{{$macro->WELD_LINE_ID}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="haz_od">Haz OD</label>
                            <input type="text" class="form-control" name="haz_od" value="{{$macro->HAZ_OD}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="haz_mid">Haz Mid</label>
                            <input type="text" class="form-control" name="haz_mid" value="{{$macro->HAZ_MID}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="haz_id">Haz ID</label>
                            <input type="text" class="form-control" name="haz_id" value="{{$macro->HAZ_ID}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="skelp_gap">Skelp Gap</label>
                            <input type="text" class="form-control" name="skelp_gap" value="{{$macro->SKELP_GAP}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="920_od">920 OD</label>
                            <input type="text" class="form-control" name="920_od" value="{{$macro["920_OD"]}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="align">Align (+ North, - South)</label>
                            <input type="text" class="form-control" name="align" value="{{$macro->ALIGN}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="920_id">920 ID</label>
                            <input type="text" class="form-control" name="920_id" value="{{$macro["920_ID"]}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="coil_position">Coil Position</label>
                            <input type="text" class="form-control" name="coil_position"
                                   value="{{$macro->COIL_POSITION}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="impeder_number">Impeder Number</label>
                            <input type="text" class="form-control" name="impeder_number"
                                   value="{{$macro->IMPEDER_NUMBER}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="track_line">Track Line</label>
                            <input type="text" class="form-control" name="track_line" value="{{$macro->TRACK_LINE}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="xiris_v_angle">XIRIS V-ANGLE</label>
                            <input type="text" class="form-control" name="xiris_v_angle" value="{{$macro->XIRIS_V_ANGLE}}"/>
                        </div>

                        {{--                        <div class="form-group m-1">--}}
                        {{--                            <label for="reason_for_adjustment">Reason For Adjustment</label>--}}
                        <input type="hidden" class="form-control" name="reason_for_adjustment"
                               value="{{$macro->REASON_FOR_ADJUSTMENT}}"/>
                        {{--                        </div>--}}
                        {{--                    </div>--}}



                        <div class="d-flex flex-wrap justify-content-center">




                            <div class="form-group m-1">
                                <label for="annealer_calibration_time">Annealer Calibration Time</label>
                                <input type="datetime-local" class="form-control" name="annealer_calibration_time" value="{{$macro->ANNEALER_CALIBRATION_TIME}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="annealer_calibration_coil">Annealer Calibration Coil</label>
                                <input type="text" class="form-control" name="annealer_calibration_coil" VALUE="{{$macro->ANNEALER_CALIBRATION_COIL}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="a_anneal_temp">A Anneal Temp</label>
                                <input type="text" class="form-control" name="a_anneal_temp"
                                       value="{{$macro->A_ANNEAL_TEMP}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="b_anneal_temp">B Anneal Temp</label>
                                <input type="text" class="form-control" name="b_anneal_temp"
                                       value="{{$macro->B_ANNEAL_TEMP}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="c_anneal_temp">C Anneal Temp</label>
                                <input type="text" class="form-control" name="c_anneal_temp"
                                       value="{{$macro->C_ANNEAL_TEMP}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="d_anneal_temp">D Anneal Temp</label>
                                <input type="text" class="form-control" name="d_anneal_temp"
                                       value="{{$macro->D_ANNEAL_TEMP}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="e_anneal_temp">E Anneal Temp</label>
                                <input type="text" class="form-control" name="e_anneal_temp"
                                       value="{{$macro->E_ANNEAL_TEMP}}"/>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-center">
                            <div class="form-group m-1">
                                <label for="a_%_power">A % Power</label>
                                <input type="text" class="form-control" name="a_%_power"
                                       value="{{$macro["A_%_POWER"]}}"/>
                            </div>
                            <div class="form-group m-1">
                                <label for="b_%_power">B % Power</label>
                                <input type="text" class="form-control" name="b_%_power"
                                       value="{{$macro["B_%_POWER"]}}"/>
                            </div>
                            <div class="form-group m-1">
                                <label for="c_%_power">C % Power</label>
                                <input type="text" class="form-control" name="c_%_power"
                                       value="{{$macro["C_%_POWER"]}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="d_%_power">D % Power</label>
                                <input type="text" class="form-control" name="d_%_power"
                                       value="{{$macro["D_%_POWER"]}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="e_%_power">E % Power</label>
                                <input type="text" class="form-control" name="e_%_power"
                                       value="{{$macro["E_%_POWER"]}}"/>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-center">
                            <div class="form-group m-1">
                                <label for="a_anneal_freq">A Anneal Freq</label>
                                <input type="text" class="form-control" name="a_anneal_freq"
                                       value="{{$macro->A_ANNEAL_FREQ}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="b_anneal_freq">B Anneal Freq</label>
                                <input type="text" class="form-control" name="b_anneal_freq"
                                       value="{{$macro->B_ANNEAL_FREQ}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="c_anneal_freq">C Anneal Freq</label>
                                <input type="text" class="form-control" name="c_anneal_freq"
                                       value="{{$macro->C_ANNEAL_FREQ}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="d_anneal_freq">D Anneal Freq</label>
                                <input type="text" class="form-control" name="d_anneal_freq"
                                       value="{{$macro->D_ANNEAL_FREQ}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="e_anneal_freq">E Anneal Freq</label>
                                <input type="text" class="form-control" name="e_anneal_freq"
                                       value="{{$macro->E_ANNEAL_FREQ}}"/>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-around">
                            <div class="form-group m-1">
                                <label for="quench">Quench</label>
                                <input type="text" class="form-control" name="quench" value="{{$macro->QUENCH}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="cooling_1">Cooling 1</label>
                                <select class="form-control" name="cooling_1">
                                    <option {{($macro->COOLING_1 == "None" ? "selected" : "")}} value="None">None
                                    </option>
                                    <option {{($macro->COOLING_1 == "Full" ? "selected" : "")}} value="Full">Full
                                    </option>
                                    <option {{($macro->COOLING_1 == "Partial" ? "selected" : "")}} value="Partial">
                                        Partial
                                    </option>
                                </select>
                            </div>

                            <div class="form-group m-1">
                                <label for="cooling_2">Cooling 2</label>
                                <select class="form-control" name="cooling_2">
                                    <option {{($macro->COOLING_2 == "None" ? "selected" : "")}} value="None">None
                                    </option>
                                    <option {{($macro->COOLING_2 == "Full" ? "selected" : "")}} value="Full">Full
                                    </option>
                                    <option {{($macro->COOLING_2 == "Partial" ? "selected" : "")}} value="Partial">
                                        Partial
                                    </option>
                                </select>
                            </div>

                            <div class="form-group m-1">
                                <label for="cooling_3">Cooling 3</label>
                                <select class="form-control" name="cooling_3">
                                    <option {{($macro->COOLING_3 == "None" ? "selected" : "")}} value="None">None
                                    </option>
                                    <option {{($macro->COOLING_3 == "Full" ? "selected" : "")}} value="Full">Full
                                    </option>
                                    <option {{($macro->COOLING_3 == "Partial" ? "selected" : "")}} value="Partial">
                                        Partial
                                    </option>
                                </select>
                            </div>
                            <div class="form-group m-1">
                                <label for="pre_size_temp">Pre Quench Temp</label>
                                <input type="text" class="form-control" name="pre_size_temp"
                                       value="{{$macro->PRE_SIZE_TEMP}}"/>
                            </div>
                            <div class="form-group m-1">
                                <label for="quench_temp">Post Quench Temp</label>
                                <input type="text" class="form-control" name="quench_temp"
                                       value="{{$macro->QUENCH_TEMP}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="quench_temp">ID Carriage Number</label>
                                <input type="text" class="form-control" name="id_carriage_number"
                                       value="{{$macro->ID_CARRIAGE_NUMBER}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="trim_bar_number">Trim Bar Number</label>
                                <input type="text" class="form-control" name="trim_bar_number"
                                       value="{{$macro->TRIM_BAR_NUMBER}}"/>
                            </div>
                        </div>

                        <div class="form-group m-1">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" name="comment">{{$macro->COMMENT}}</textarea>

                        </div>

                        <div class="form-group m-1 p-1">
                                <div>
                                    <label for="image">MACRO PICTURE</label>
                                </div>
                            <div>
                                @if ($macro->IMAGE !== "")
                                    <a class="btn btn-danger" href="{{$rootUrl}}/wm-macros/remove-image/{{$macro->id}}">Remove
                                        Image</a>
                                    <img style="width:50%;" src="{{asset('public/storage/macros/'.$macro->IMAGE)}}"/>
                                @endif
                            </div>
                                <div class="mt-2"><input id="macroImage" type="file" name="image"/></div>
                            <button type="submit" class="btn btn-primary mt-5">Update</button>
                        </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('functionalScripts')

    <script>
        const fileInput = document.getElementById("macroImage");
        window.addEventListener('paste', e => {
            fileInput.files = e.clipboardData.files;
        });

        $(document).on('change', 'input#inside_diameter_north, input#inside_diameter_south', function() {
            // console.log("changed");
            // console.log($('input#inside_diameter_north').val());
            // console.log($('input#inside_diameter_south').val());

            if ($('input#inside_diameter_north').val() > 0 && $('input#inside_diameter_south').val() > 0) {
                var avg = (parseFloat($('input#inside_diameter_north').val()) + parseFloat($('input#inside_diameter_south').val())) / 2;
                console.log(avg);
                $('input#inside_diameter_ns_avg').val(avg.toFixed(2));
            }

        });

        $(document).on('change', 'input#outside_diameter_north, input#outside_diameter_south', function() {

            // console.log("changed");
             console.log($('input#outside_diameter_north').val());
             console.log($('input#outside_diameter_south').val());
            if ($('input#outside_diameter_north').val() > 0 && $('input#outside_diameter_south').val() > 0) {
                var avg = (parseFloat($('input#outside_diameter_north').val()) + parseFloat($('input#outside_diameter_south').val())) / 2;



                console.log(avg);
                $('input#outside_diameter_ns_avg').val(avg);
            }
        });


    </script>


@endsection
