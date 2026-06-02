@extends('layouts.app')

@section('pageTitle', 'Ultrasonic Reject Details')
@section('pageName', 'Ultrasonic Reject Details')
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

                    <h2 style="text-align: center;">WELDMILL TEAM LEADER SHIFT HANDOVER REPORT</h2>

                    <hr/>

                        <div class="d-flex justify-content-center"
                             style="margin-bottom: 20px;background: #ececec;padding: 5px;border-radius: 10px;">

                            <div class="form-group m-1">
                                <label for="team_leader">TEAM LEADER</label>
                                <input type="text" id="team_leader" disabled  class="form-control" required name="team_leader" value="{{$wmShiftLog->team_leader}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="shift_hours">SHIFT HOURS</label>
                                <input type="number" id="shift_hours" class="form-control" disabled required name="shift_hours" value="{{$wmShiftLog->shift_hours}}"/>
                            </div>

                            <div class="form-group m-1">
                                <label for="shift_pattern">SHIFT PATTERNS</label>
                                <select class="form-control" disabled name="shift_pattern">
                                    <option {{($wmShiftLog->shift_pattern == "6x2" ? "selected" : "")}} value="6x2">6x2</option>
                                    <option {{($wmShiftLog->shift_pattern == "2x10" ? "selected" : "")}} value="2x10">2x10</option>
                                </select>
                            </div>


                        </div>

                        <div class="form-group m-1 mb-4">
                            <label for="hse_concerns">HSE CONCERNS</label>
                            <textarea name="hse_concerns" disabled class="form-control">{{$wmShiftLog->hse_concern}}</textarea>
                        </div>

                        <hr />
                        <h4>SHIFT TEAM INFO</h4>
                        <hr />
                        <div style="display:flex">

                            <div class="form-group m-1 text-center">
                                <h4>SICKNESS</h4>
                                <div  style="margin-top:31px;">
                                    @foreach(json_decode(json_encode($wmShiftLog->WMShiftLogSickness),true) as $h)
                                    <input type="text"  disabled id="sickness" maxlength="3" class="form-control" placeholder="Name" value="{{$h["employee_name"]}}"  name="sickness[]"/>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group m-1 text-center">
                                <h4>HOLIDAYS</h4>
                                <div  style="margin-top:31px;">
                                    @foreach(json_decode(json_encode($wmShiftLog->WMShiftLogHolidays),true) as $h)
                                        <input disabled type="text" id="sickness" maxlength="3" class="form-control" placeholder="Name" value="{{$h["employee_name"]}}"  name="holidays[]"/>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group m-1 text-center">
                                <h4>TRAINING</h4>
                                <div style="display:flex">

                                    <div>

                                        <label for="shift_hours"></label>
                                        @foreach(json_decode(json_encode($wmShiftLog->WMShiftLogTraining),true) as $h)
                                            <input disabled type="text" id="training_name"  class="form-control" placeholder="Name" value="{{$h["employee_name"]}}"  name="training_name[]"/>
                                        @endforeach
                                    </div>
                                    <div>
                                        <label for="shift_hours"></label>
                                        @foreach(json_decode(json_encode($wmShiftLog->WMShiftLogTraining),true) as $h)
                                            <input disabled type="text" id="training_area"  class="form-control" placeholder="Name" value="{{$h["area"]}}"  name="training_area[]"/>
                                        @endforeach
                                    </div>

                                    <div>
                                        <label for="shift_hours"></label>
                                        @foreach(json_decode(json_encode($wmShiftLog->WMShiftLogTraining),true) as $h)
                                            <input disabled type="text" id="training_hours"  class="form-control" placeholder="Name" value="{{$h["hours"]}}"  name="training_hours[]"/>
                                        @endforeach
                                    </div>
                                </div>
                            </div>



                            <div class="form-group m-1 text-center">
                                <h4>OVERTIME</h4>
                                <div style="display:flex">
                                    <div>

                                        <label for="shift_hours"></label>
                                        @foreach(json_decode(json_encode($wmShiftLog->WMShiftLogOvertime),true) as $h)
                                            <input  disabled type="text" id="training_name"  class="form-control" placeholder="Name" value="{{$h["employee_name"]}}"  name="training_name[]"/>
                                        @endforeach
                                    </div>
                                    <div>
                                        <label for="shift_hours"></label>
                                        @foreach(json_decode(json_encode($wmShiftLog->WMShiftLogOvertime),true) as $h)
                                            <input disabled type="text" id="training_area"  class="form-control" placeholder="Name" value="{{$h["area"]}}"  name="training_area[]"/>
                                        @endforeach
                                    </div>

                                    <div>
                                        <label for="shift_hours"></label>
                                        @foreach(json_decode(json_encode($wmShiftLog->WMShiftLogOvertime),true) as $h)
                                            <input disabled type="text" id="training_hours"  class="form-control" placeholder="Name" value="{{$h["hours"]}}"  name="training_hours[]"/>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr />
                        <h4>BEHAVIOURAL CONCERNS</h4>
                        <hr />

                        <div class="form-group m-1 mb-4">
                            <label for="behavioural_concerns">BEHAVIOURAL CONCERNS</label>
                            <textarea disabled name="behavioural_concerns" class="form-control">{{$wmShiftLog->behavioural_concerns}}</textarea>
                        </div>


                        <hr />
                        <h4>QUALITY</h4>
                        <hr />
                        <div style="display:flex;     justify-content: space-around;">

                            <div class="form-group m-1 mb-4">
                                <label for="id_trim_concerns">ID TRIM CONCERNS</label>
                                <textarea disabled name="id_trim_concerns" class="form-control">{{$wmShiftLog->id_trim_concerns}}</textarea>
                            </div>

                            <div class="form-group m-1 mb-4">
                                <label for="weld_rejection_concerns">WELD REJECTION CONCERNS</label>
                                <textarea disabled name="weld_rejection_concerns" class="form-control">{{$wmShiftLog->weld_rejection_concerns}}</textarea>
                            </div>

                            <div class="form-group m-1 mb-4">
                                <label for="steel_rejection_concerns">STEEL REJECTION CONCERNS</label>
                                <textarea disabled name="steel_rejection_concerns" class="form-control">{{$wmShiftLog->steel_rejection_concerns}}</textarea>
                            </div>

                            <div class="form-group m-1 mb-4">
                                <label for="shape_rejection_concerns">SHAPE CONCERNS</label>
                                <textarea disabled name="shape_rejection_concerns" class="form-control">{{$wmShiftLog->shape_rejection_concerns}}</textarea>
                            </div>

                            <div class="form-group m-1 mb-4">
                                <label for="straightness_rejection_concerns">STRAIGHTNESS CONCERNS</label>
                                <textarea disabled name="straightness_rejection_concerns" class="form-control">{{$wmShiftLog->straightness_rejection_concerns}}</textarea>
                            </div>
                        </div>


                    <hr />
                    <h4>WORK IN PROGRESS</h4>
                    <hr />
                    <div class="form-group m-1 text-center" style="display: flex; justify-content: space-between">

                        <div style="display:flex">
                            <div style="margin-bottom: -1em">
                                <label for="shift_hours"></label>
                                <input type="text" disabled class="form-control" placeholder="SCO"/>
                                <input type="text" disabled class="form-control" placeholder="18MS" />
                                <input type="text" disabled class="form-control" placeholder="DRESS" />
                            </div>
                            <div>
                                <label for="shift_hours"></label>
                                <input type="text" disabled class="form-control" placeholder="PIPES"  name="sco_wip_pipes" value="{{$wmShiftLog->sco_wip_pipes}}">
                                <input type="text" disabled class="form-control" placeholder="PIPES" name="eighteenmetres_wip_pipes" value="{{$wmShiftLog->eighteenmetres_wip_pipes}}"/>
                                <input type="text" disabled class="form-control" placeholder="PIPES" name="dress_wip_pipes" value="{{$wmShiftLog->dress_wip_pipes}}"/>
                            </div>

                            <div>
                                <label for="shift_hours"></label>
                                <input type="text"  disabled class="form-control" placeholder="COMMENTS" name="sco_wip_comments" value="{{$wmShiftLog->sco_wip_comments}}"/>
                                <input type="text" disabled  class="form-control" placeholder="COMMENTS" name="eighteenmetres_wip_comments" value="{{$wmShiftLog->sco_wip_comments}}"/>
                                <input type="text" disabled  class="form-control" placeholder="COMMENTS" name="dress_wip_comments" value="{{$wmShiftLog->sco_wip_comments}}"/>
                            </div>
                        </div>

                        <div style="display:flex">
                            <div style="margin-bottom: -1em">
                                <label for="shift_hours"></label>
                                <input type="text" disabled class="form-control" placeholder="RESTRAIGHTS"/>
                                <input type="text" disabled class="form-control" placeholder="TABLE 9" />
                                <input type="text" disabled class="form-control" placeholder="RHS FLOOR" />
                            </div>
                            <div>
                                <label for="shift_hours"></label>
                                <input type="text" disabled  class="form-control" placeholder="PIPES"  name="restraight_wip_pipes" value="{{$wmShiftLog->eighteenmetres_wip_pipes}}" >
                                <input type="text" disabled  class="form-control" placeholder="PIPES" name="table_9_wip_pipes" value="{{$wmShiftLog->table9_wip_pipes}}"/>
                                <input type="text" disabled  class="form-control" placeholder="PIPES" name="rhs_floor_wip_pipes" value="{{$wmShiftLog->rhsfloor_wip_pipes}}"/>
                            </div>

                            <div>
                                <label for="shift_hours"></label>
                                <input type="text"  disabled class="form-control" placeholder="COMMENTS" name="restraight_wip_comments" value="{{$wmShiftLog->eighteenmetres_wip_comments}}"/>
                                <input type="text" disabled  class="form-control" placeholder="COMMENTS" name="table_9_wip_comments" value="{{$wmShiftLog->table9_wip_comments}}"/>
                                <input type="text" disabled  class="form-control" placeholder="COMMENTS" name="rhs_floor_wip_comments" value="{{$wmShiftLog->rhsfloor_wip_comments}}"/>
                            </div>
                        </div>

                    </div>



                    <hr />
                    <h4>LINE STOPS</h4>
                    <hr />
                    <div style="display:flex">

                        <div style="margin:3px;padding: 6px;border: 1px solid;border-radius: 7px; flex:1;">
                            <div style="text-align: center;"><h5>C - PLANNED STOPS</h5></div>
                            <div style="display: flex;border-top: 1px solid;text-align: center;">
                                <div style="flex:1;">Mins: {{$wmShiftLog->line_stops_c}}</div>
                                <div style="flex:1;">%: {{round(($wmShiftLog->line_stops_c / $wmShiftLog->shift_mins) * 100, 2) }}%</div>
                            </div>
                        </div>

                        <div style="margin:3px;padding: 6px;border: 1px solid;border-radius: 7px;flex:1;">
                            <div style="text-align: center;"><h5>E - ELECTRICAL STOPS</h5></div>
                            <div style="display: flex;border-top: 1px solid;text-align: center;">
                                <div style="flex:1;">Mins: {{$wmShiftLog->line_stops_e}}</div>
                                <div style="flex:1;">%: {{round(($wmShiftLog->line_stops_e / $wmShiftLog->shift_mins) * 100, 2) }}%</div>
                            </div>
                        </div>

                        <div style="margin:3px;padding: 6px;border: 1px solid;border-radius: 7px;flex:1;">
                            <div style="text-align: center;"><h5>M - MECHANICAL STOPS</h5></div>
                            <div style="display: flex;border-top: 1px solid;text-align: center;">
                                <div style="flex:1;">Mins: {{$wmShiftLog->line_stops_m}}</div>
                                <div style="flex:1;">%: {{round(($wmShiftLog->line_stops_m / $wmShiftLog->shift_mins) * 100, 2) }}%</div>
                            </div>
                        </div>

                        <div style="margin:3px;padding: 6px;border: 1px solid;border-radius: 7px;flex:1;">
                            <div style="text-align: center;"><h5>P - PRODUCTION STOPS</h5></div>
                            <div style="display: flex;border-top: 1px solid;text-align: center;">
                                <div style="flex:1;">Mins: {{$wmShiftLog->line_stops_p}}</div>
                                <div style="flex:1;">%: {{round(($wmShiftLog->line_stops_p / $wmShiftLog->shift_mins) * 100, 2) }}%</div>
                            </div>
                        </div>

                        <div style="margin:3px;padding: 6px;border: 1px solid;border-radius: 7px;flex:1;">
                            <div style="text-align: center;"><h5>Z&T - UTILISATION STOPS</h5></div>
                            <div style="display: flex;border-top: 1px solid;text-align: center;">
                                <div style="flex:1;">Mins: {{$wmShiftLog->line_stops_z_t}}</div>
                                <div style="flex:1;">%: {{round(($wmShiftLog->line_stops_z_t / $wmShiftLog->shift_mins) * 100, 2) }}%</div>
                            </div>
                        </div>



                    </div>


                    <hr />
                    <h4>MATERIAL PRODUCED & OEE</h4>
                    <div class="form-group m-1 text-center" style="display: flex; justify-content: space-between">

                        <div style="display:flex">

                            <div style="margin-bottom: -1em">
                                <label for="shift_hours"></label>
                                <input type="text" disabled class="form-control" placeholder="COILS"/>
                                <input type="text" disabled class="form-control" placeholder="INPUT TONNES" />
                                <input type="text" disabled class="form-control" placeholder="GOOD OUTPUT TONNES" />
                            </div>

                            <div>
                                <label for="shift_hours"></label>
                                <input type="text" class="form-control" placeholder="NO OF COILS"  name="coils_processed" value="{{$wmShiftLog->coils_processed}}">
                                <input type="text" class="form-control" placeholder="INPUT TONNES" name="input_tonnes" value="{{$wmShiftLog->input_tonnes}}"/>
                                <input type="text" class="form-control" placeholder="GOOD OUTPUT TONNES" name="good_output_tonnes" value="{{$wmShiftLog->good_output_tonnes}}"/>
                            </div>

                        </div>

                        <div style="display:flex">
                            <div style="margin-bottom: -1em">
                                <label for="shift_hours"></label>
                                <input type="text" disabled class="form-control" placeholder="TPH"/>
                                <input type="text" disabled class="form-control" placeholder="YEILD" />
                                <input type="text" disabled class="form-control" placeholder="AVAILABILITY" />
                                <input type="text" disabled class="form-control" placeholder="OEE" />
                            </div>
                            <div>
                                <label for="shift_hours"></label>
                                <input type="text" class="form-control" placeholder="TPH"  name="tph" value="{{$wmShiftLog->tph}}%">
                                <input type="text" class="form-control" placeholder="YEILD" name="yeild" value="{{$wmShiftLog->yeild}}%"/>
                                <input type="text" class="form-control" placeholder="AVAILABILITY" name="availability" value="{{$wmShiftLog->availability}}%"/>
                                <input type="text" class="form-control" placeholder="OEE" name="oee" value="{{$wmShiftLog->oee}}%"/>
                            </div>
                        </div>

                    </div>


                        <hr />
                        <h4>SHIFT HANDOVER</h4>
                        <hr />

                        <div style="display:flex;justify-content: space-around;">

                            <div class="form-group m-1 mb-4">
                                <label for="hse">HSE</label>
                                <textarea  disabled name="hse_handover_info" class="form-control">{{$wmShiftLog->hse_handover_info}}</textarea>
                            </div>

                            <div class="form-group m-1 mb-4">
                                <label for="manning">MANNING</label>
                                <textarea  disabled name="manning_handover_info" class="form-control">{{$wmShiftLog->manning_handover_info}}</textarea>
                            </div>

                            <div class="form-group m-1 mb-4">
                                <label for="setup_change">SET UP / CHANGES</label>
                                <textarea disabled name="setup_change_handover_info" class="form-control">{{$wmShiftLog->setup_change_handover_info}}</textarea>
                            </div>


                            <div class="form-group m-1 mb-4">
                                <label for="engineering">ENGINEERING</label>
                                <textarea disabled name="eng_handover_info" class="form-control">{{$wmShiftLog->eng_handover_info}}</textarea>
                            </div>


                        </div>








                        <input type="hidden" id="XDEBUG_TRIGGER" maxlength="3" class="form-control"  name="XDEBUG_TRIGGER" value="1"/>


            </div>
        </div>
    </div>

            </div>
        </div>
    </div>

@endsection
