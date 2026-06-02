@extends('layouts.app')

@section('pageTitle', 'Add Macro')
@section('pageName', 'Add Macro')
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
                <form method="post" action="{{ route('wm-macros.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-wrap justify-content-center" style="margin-top: -70px;">
                        <div class="form-group m-1">
                            <label for="diam_range">Diam Range</label>
                            <input type="text" class="form-control" name="diam_range"/>
                        </div>


                        <div class="form-group m-1">
                            <label for="technician">Technician</label>
                            <input type="text" class="form-control" name="technician"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="igs">IGS</label>
                            <select class="form-control" name="igs">
                                <option value="No">NO</option>
                                <option value="Yes">YES</option>
                            </select>
                        </div>
                    </div>


                    <div class="d-flex flex-wrap justify-content-around">

                        <div class="form-group m-1">
                            <label for="week_year">Week Year</label>
                            <input type="number" max="52" class="form-control" name="week_year"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="coil">Coil</label>
                            <input type="number" max="999" class="form-control" name="coil"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="pipe">Pipe</label>
                            <input type="number" max="99" class="form-control" name="pipe"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="thk">Thk</label>
                            <input type="text" class="form-control" name="thk"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="grade">Grade</label>
                            <input type="text" class="form-control" name="grade"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="quality">Quality</label>
                            <input type="text" class="form-control" name="quality"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="speed_fpm">Speed FPM</label>
                            <input type="text" class="form-control" name="speed_fpm"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="weld_temp">Weld Temp</label>
                            <input type="text" class="form-control" name="weld_temp"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="power">Power</label>
                            <input type="text" class="form-control" name="power"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="freq">Freq</label>
                            <input type="text" class="form-control" name="freq"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="width">Width</label>
                            <input type="text" class="form-control" name="width"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="h_roll_spacer">Head Roll Spacer</label>
                            <input type="number" step="any" class="form-control" name="h_roll_spacer" value="18.0"/>
                        </div>


                        <!-- removed J.CADDY 08/01/2024 -->
                            <input type="hidden" step="any" class="form-control" name="h_roll_re_grind" value="0.0"/>
                            <input type="hidden" step="any" class="form-control" name="h_roll_gap" value="0.0"/>
                        <!-- //// -->

                        <div class="form-group m-1">
                            <label for="pre_fins">Pre Fins</label>
                            <input type="text" class="form-control" name="pre_fins"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="pre_weld">Pre Weld</label>
                            <input type="text" class="form-control" name="pre_weld"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="post_weld">Post Weld</label>
                            <input type="text" class="form-control" name="post_weld"/>
                        </div>


                        <div class="form-group m-1">
                            <label for="outside_diameter">OD Diversions North</label>
                            <input type="text" class="form-control" id="outside_diameter_north" name="outside_diameter_north" value="0"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="outside_diameter">OD Diversions South</label>
                            <input type="text" class="form-control" id="outside_diameter_south" name="outside_diameter_south" value="0"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="outside_diameter_ns_avg">OD Diversions AVG</label>
                            <input type="text" class="form-control" id="outside_diameter_ns_avg" name="outside_diameter_ns_avg" value="0"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="swerve">Swerve</label>
                            <select class="form-control" name="swerve">
                                <option value="6">Sound Weld</option>
                                <option value="0">Straight</option>
                                <option value="1">Swerved South</option>
                                <option value="2">Angled South</option>
                                <option value="3">Swerved North</option>
                                <option value="4">Angled North</option>
                                <option value="5">Dog Leg</option>
                                <option value="7">Low Divs</option>
                            </select>
                        </div>

                        <div class="form-group m-1">
                            <label for="inside_diameter">ID Diversions North</label>
                            <input type="text" class="form-control" id="inside_diameter_north" name="inside_diameter_north" value="0"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="inside_diameter">ID Diversions South</label>
                            <input type="text" class="form-control" id="inside_diameter_south" name="inside_diameter_south" value="0"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="inside_diameter_ns_avg">ID Diversions AVG</label>
                            <input type="text" class="form-control" id="inside_diameter_ns_avg" name="inside_diameter_ns_avg" value="0"/>
                        </div>


                        <div class="form-group m-1">
                            <label for="weld_line_od">Weld Line OD</label>
                            <input type="text" class="form-control" name="weld_line_od"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="weld_line_id">Weld Line ID</label>
                            <input type="text" class="form-control" name="weld_line_id"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="haz_od">Haz OD</label>
                            <input type="text" class="form-control" name="haz_od"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="haz_mid">Haz Mid</label>
                            <input type="text" class="form-control" name="haz_mid"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="haz_id">Haz ID</label>
                            <input type="text" class="form-control" name="haz_id"/>
                        </div>


                        <div class="form-group m-1">
                            <label for="skelp_gap">Skelp Gap</label>
                            <input type="text" class="form-control" name="skelp_gap"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="xiris_v_angle">Xiris V-Angle</label>
                            <input type="text" class="form-control" value="0" name="xiris_v_angle"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="920_od">920 OD</label>
                            <input type="text" class="form-control" name="920_od"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="align">Align (+ North, - South)</label>
                            <input type="text" class="form-control" name="align"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="920_id">920 ID</label>
                            <input type="text" class="form-control" name="920_id"/>
                        </div>
                    <div style="width: 100%;display: flex;">
                        <div class="form-group m-1" style="flex:1;">
                            <label for="coil_position">Coil Position</label>
                            <input type="text" class="form-control" name="coil_position"/>
                        </div>

                        <div class="form-group m-1" style="flex:1;">
                            <label for="impeder_number">Impeder Number</label>
                            <input type="text" class="form-control" name="impeder_number"/>
                        </div>

                        <div class="form-group m-1" style="flex:1;">
                            <label for="track_line">Track Line</label>
                            <input type="text" class="form-control" name="track_line"/>
                        </div>
                    </div>

                        <div style="width: 100%;display: flex;">
                            <div class="form-group m-1" style="flex:1;">
                                <label for="trim_bar_number">Trim Bar Number</label>
                                <input type="text" class="form-control" name="trim_bar_number"/>
                            </div>

                            <div class="form-group m-1" style="flex:1;">
                                <label for="id_carriage_number">ID Carriage Number</label>
                                <input type="text" class="form-control" name="id_carriage_number"/>
                            </div>
                        </div>
{{--                        <div class="form-group m-1">--}}
{{--                            <label for="reason_for_adjustment">Reason For Adjustment</label>--}}
                            <input type="hidden" value="" class="form-control" name="reason_for_adjustment"/>
{{--                        </div>--}}

                    </div>

                    <div class="d-flex flex-wrap justify-content-center">


                        <div class="form-group m-1">
                            <label for="annealer_calibration_time">Annealer Calibration Time</label>
                            <input type="datetime-local" class="form-control" name="annealer_calibration_time"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="annealer_calibration_coil">Annealer Calibration Coil</label>
                            <input type="text" class="form-control" name="annealer_calibration_coil"/>
                        </div>


                        <div class="form-group m-1">
                            <label for="a_anneal_temp">A Anneal Temp</label>
                            <input type="text" class="form-control" name="a_anneal_temp"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="b_anneal_temp">B Anneal Temp</label>
                            <input type="text" class="form-control" name="b_anneal_temp"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="c_anneal_temp">C Anneal Temp</label>
                            <input type="text" class="form-control" name="c_anneal_temp"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="d_anneal_temp">D Anneal Temp</label>
                            <input type="text" class="form-control" name="d_anneal_temp"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="e_anneal_temp">E Anneal Temp</label>
                            <input type="text" class="form-control" name="e_anneal_temp"/>
                        </div>
                    </div>


                    <div class="d-flex flex-wrap justify-content-center">
                        <div class="form-group m-1">
                            <label for="a_%_power">A % Power</label>
                            <input type="text" class="form-control" name="a_%_power"/>
                        </div>
                        <div class="form-group m-1">
                            <label for="b_%_power">B % Power</label>
                            <input type="text" class="form-control" name="b_%_power"/>
                        </div>
                        <div class="form-group m-1">
                            <label for="c_%_power">C % Power</label>
                            <input type="text" class="form-control" name="c_%_power"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="d_%_power">D % Power</label>
                            <input type="text" class="form-control" name="d_%_power"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="e_%_power">E % Power</label>
                            <input type="text" class="form-control" name="e_%_power"/>
                        </div>
                    </div>


                    <div class="d-flex flex-wrap justify-content-center">
                        <div class="form-group m-1">
                            <label for="a_anneal_freq">A Anneal Freq</label>
                            <input type="text" class="form-control" name="a_anneal_freq"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="b_anneal_freq">B Anneal Freq</label>
                            <input type="text" class="form-control" name="b_anneal_freq"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="c_anneal_freq">C Anneal Freq</label>
                            <input type="text" class="form-control" name="c_anneal_freq"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="d_anneal_freq">D Anneal Freq</label>
                            <input type="text" class="form-control" name="d_anneal_freq"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="e_anneal_freq">E Anneal Freq</label>
                            <input type="text" class="form-control" name="e_anneal_freq"/>
                        </div>
                    </div>


                    <div class="d-flex flex-wrap justify-content-around">
                        <div class="form-group m-1">
                            <label for="quench">Quench</label>
                            <input type="text" class="form-control" name="quench"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="cooling_1">Cooling 1</label>
                            <select class="form-control" name="cooling_1">
                                <option value="None">None</option>
                                <option value="Full" selected>Full</option>
                                <option value="Partial">Partial</option>
                            </select>
                        </div>

                        <div class="form-group m-1">
                            <label for="cooling_2">Cooling 2</label>
                            <select class="form-control" name="cooling_2">
                                <option value="None">None</option>
                                <option value="Full" selected>Full</option>
                                <option value="Partial">Partial</option>
                            </select>
                        </div>

                        <div class="form-group m-1">
                            <label for="cooling_3">Cooling 3</label>
                            <select class="form-control" name="cooling_3">
                                <option value="None">None</option>
                                <option value="Full" selected>Full</option>
                                <option value="Partial">Partial</option>
                            </select>
                        </div>
                        <div class="form-group m-1">
                            <label for="pre_size_temp">Pre Quench Temp</label>
                            <input type="text" class="form-control" name="pre_size_temp"/>
                        </div>
                        <div class="form-group m-1">
                            <label for="quench_temp">Post Quench Temp</label>
                            <input type="text" class="form-control" name="quench_temp"/>
                        </div>


                    </div>


                    <div class="form-group m-1">
                        <label for="comment">Comment</label>
                        <textarea class="form-control" name="comment"></textarea>

                    </div>


                    <div class="form-group m-1 p-1">
                        <div><label for="image">Macro Picture</label></div>
                        <div><input type="file" id="macroImage" name="image"/></div>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Macro</button>
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

            if ($('input#inside_diameter_north').val() > 0 && $('input#inside_diameter_south').val() > 0) {

                var avg = (parseFloat($('input#inside_diameter_north').val()) + parseFloat($('input#inside_diameter_south').val())) / 2;
                console.log(avg);
                $('input#inside_diameter_ns_avg').val(avg.toFixed(2));

            }

        });

        $(document).on('change', 'input#outside_diameter_north, input#outside_diameter_south', function() {

            if ($('input#outside_diameter_north').val() > 0 && $('input#outside_diameter_south').val() > 0) {

                var avg = (parseFloat($('input#outside_diameter_north').val()) + parseFloat($('input#outside_diameter_south').val())) / 2;
                console.log(avg);
                $('input#outside_diameter_ns_avg').val(avg.toFixed(2));
            }

        });

    </script>


@endsection
