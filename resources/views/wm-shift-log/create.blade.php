@extends('layouts.app')

@section('pageTitle', 'Add WM Shift Log')
@section('pageName', 'Add WM Shift Log')
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

                <h2 style="text-align: center;">WELDMILL TEAM LEADER SHIFT HANDOVER REPORT</h2>

                <hr/>
                <form method="post" action="{{ route('wm-shift-log.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-center"
                         style="margin-bottom: 20px;background: #ececec;padding: 5px;border-radius: 10px;">

                        <div class="form-group m-1">
                            <label for="team_leader">TEAM LEADER</label>
                            <input type="text" id="team_leader"  class="form-control" required name="team_leader"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="shift_hours">SHIFT HOURS</label>
                            <input type="number" id="shift_hours" class="form-control" required name="shift_hours"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="shift_pattern">SHIFT PATTERNS</label>
                            <select class="form-control" name="shift_pattern">
                                <option value="6x2">6x2</option>
                                <option value="2x10">2x10</option>
                                <option value="10x6">10x6N</option>
                                <option value="6x6D">6x6D</option>
                                <option value="6x6N">6x6N</option>
                            </select>
                        </div>


                    </div>

                    <div class="form-group m-1 mb-4">
                        <label for="hse_concerns">HSE CONCERNS</label>
                        <textarea name="hse_concerns" class="form-control"></textarea>
                    </div>

                    <hr />
                    <h4>SHIFT TEAM INFO</h4>
                    <hr />
                    <div style="display:flex">

                    <div class="form-group m-1 text-center">
                        <h4>SICKNESS</h4>
                        <div  style="margin-top:31px;">
                        <input type="text" id="sickness"    class="form-control" placeholder="Name"  name="sickness[]"/>
                        <input type="text" id="sickness"    class="form-control" placeholder="Name"   name="sickness[]"/>
                        <input type="text" id="sickness"    class="form-control" placeholder="Name"   name="sickness[]"/>
                        <input type="text" id="sickness"    class="form-control" placeholder="Name"   name="sickness[]"/>
                        <input type="text" id="sickness"    class="form-control" placeholder="Name"   name="sickness[]"/>
                        </div>
                    </div>

                        <div class="form-group m-1 text-center">
                            <h4>HOLIDAYS</h4>
                            <div  style="margin-top:31px;">
                            <input type="text" id="holidays"    class="form-control" placeholder="Name"   name="holidays[]"/>
                            <input type="text" id="holidays"    class="form-control" placeholder="Name"   name="holidays[]"/>
                            <input type="text" id="holidays"    class="form-control" placeholder="Name"   name="holidays[]"/>
                            <input type="text" id="holidays"    class="form-control" placeholder="Name"   name="holidays[]"/>
                            <input type="text" id="holidays"    class="form-control" placeholder="Name"   name="holidays[]"/>
                            </div>
                        </div>
                        <div class="form-group m-1 text-center">
                            <h4>TRAINING</h4>
                            <div style="display:flex">

                            <div>

                            <label for="shift_hours"></label>
                            <input type="text" id="training"    class="form-control" placeholder="Name"  name="training_name[]"/>
                            <input type="text" id="training"    class="form-control" placeholder="Name" name="training_name[]"/>
                            <input type="text" id="training"    class="form-control" placeholder="Name"  name="training_name[]"/>
                            <input type="text" id="training"    class="form-control" placeholder="Name"  name="training_name[]"/>
                            <input type="text" id="training"    class="form-control" placeholder="Name" name="training_name[]"/>
                            </div>
                                <div>
                                    <label for="shift_hours"></label>
                                    <input type="text" id="training"    class="form-control" placeholder="Area"  name="training_area[]"/>
                                    <input type="text" id="training"    class="form-control" placeholder="Area" name="training_area[]"/>
                                    <input type="text" id="training"    class="form-control" placeholder="Area" name="training_area[]"/>
                                    <input type="text" id="training"    class="form-control" placeholder="Area" name="training_area[]"/>
                                    <input type="text" id="training"    class="form-control" placeholder="Area" name="training_area[]"/>
                                </div>

                                <div>
                                    <label for="shift_hours"></label>
                                    <input type="text" id="training"    class="form-control" placeholder="Hours" name="training_hours[]"/>
                                    <input type="text" id="training"    class="form-control" placeholder="Hours" name="training_hours[]"/>
                                    <input type="text" id="training"    class="form-control" placeholder="Hours" name="training_hours[]"/>
                                    <input type="text" id="training"    class="form-control" placeholder="Hours" name="training_hours[]"/>
                                    <input type="text" id="training"    class="form-control" placeholder="Hours" name="training_hours[]"/>
                                </div>
                            </div>
                        </div>



                        <div class="form-group m-1 text-center">
                            <h4>OVERTIME</h4>
                            <div style="display:flex">
                                <div style="margin-bottom: -1em">
                                    <label for="shift_hours"></label>
                                    <input type="text" class="form-control" placeholder="Name"  name="overtime_name[]"/>
                                    <input type="text" class="form-control" placeholder="Name" name="overtime_name[]"/>
                                    <input type="text" class="form-control" placeholder="Name"  name="overtime_name[]"/>
                                    <input type="text" class="form-control" placeholder="Name"  name="overtime_name[]"/>
                                    <input type="text" class="form-control" placeholder="Name" name="overtime_name[]"/>
                                </div>
                                <div>
                                    <label for="shift_hours"></label>
                                    <input type="text" class="form-control" placeholder="Area"  name="overtime_area[]"/>
                                    <input type="text" class="form-control" placeholder="Area" name="overtime_area[]"/>
                                    <input type="text" class="form-control" placeholder="Area" name="overtime_area[]"/>
                                    <input type="text" class="form-control" placeholder="Area" name="overtime_area[]"/>
                                    <input type="text" class="form-control" placeholder="Area" name="overtime_area[]"/>
                                </div>

                                <div>
                                    <label for="shift_hours"></label>
                                    <input type="text" class="form-control" placeholder="Hours" name="overtime_hours[]"/>
                                    <input type="text" class="form-control" placeholder="Hours" name="overtime_hours[]"/>
                                    <input type="text" class="form-control" placeholder="Hours" name="overtime_hours[]"/>
                                    <input type="text" class="form-control" placeholder="Hours" name="overtime_hours[]"/>
                                    <input type="text" class="form-control" placeholder="Hours" name="overtime_hours[]"/>
                                </div>
                            </div>

                        </div>
                        </div>
                    <hr />
                    <h4>BEHAVIOURAL CONCERNS</h4>
                    <hr />

                    <div class="form-group m-1 mb-4">
                        <label for="behavioural_concerns">BEHAVIOURAL CONCERNS</label>
                        <textarea name="behavioural_concerns" class="form-control"></textarea>
                    </div>
                    <hr />
                    <h4>QUALITY</h4>
                    <hr />
                    <div style="display:flex;     justify-content: space-around;">

                        <div class="form-group m-1 mb-4">
                            <label for="id_trim_concerns">ID TRIM CONCERNS</label>
                            <textarea name="id_trim_concerns" class="form-control"></textarea>
                        </div>

                        <div class="form-group m-1 mb-4">
                            <label for="weld_rejection_concerns">WELD REJECTION CONCERNS</label>
                            <textarea name="weld_rejection_concerns" class="form-control"></textarea>
                        </div>

                        <div class="form-group m-1 mb-4">
                            <label for="steel_rejection_concerns">STEEL REJECTION CONCERNS</label>
                            <textarea name="steel_rejection_concerns" class="form-control"></textarea>
                        </div>

                        <div class="form-group m-1 mb-4">
                            <label for="shape_rejection_concerns">SHAPE CONCERNS</label>
                            <textarea name="shape_rejection_concerns" class="form-control"></textarea>
                        </div>

                        <div class="form-group m-1 mb-4">
                            <label for="straightness_rejection_concerns">STRAIGHTNESS CONCERNS</label>
                            <textarea name="straightness_rejection_concerns" class="form-control"></textarea>
                        </div>
                    </div>


                    <hr />
                    <h4>SHIFT HANDOVER</h4>
                    <hr />

                    <div style="display:flex;justify-content: space-around;"  >

                        <div class="form-group m-1 mb-4">
                            <label for="hse">HSE</label>
                            <textarea name="hse_handover_info" class="form-control"></textarea>
                        </div>

                        <div class="form-group m-1 mb-4">
                            <label for="manning">MANNING</label>
                            <textarea name="manning_handover_info" class="form-control"></textarea>
                        </div>

                        <div class="form-group m-1 mb-4">
                            <label for="shape_concerns">SHAPE CONCERNS</label>
                            <textarea name="shape_concerns_handover_info" class="form-control"></textarea>
                        </div>

                        <div class="form-group m-1 mb-4">
                            <label for="setup_change">SET UP / CHANGES</label>
                            <textarea name="setup_change_handover_info" class="form-control"></textarea>
                        </div>


                        <div class="form-group m-1 mb-4">
                            <label for="engineering">ENGINEERING</label>
                            <textarea name="eng_handover_info" class="form-control"></textarea>
                        </div>
                    </div>
                    <hr />
                    <h4>WORK IN PROGRESS</h4>
                    <hr />

                    <h4>OVERTIME</h4>
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
                                <input type="text" class="form-control" placeholder="PIPES"  name="sco_wip_pipes">
                                <input type="text" class="form-control" placeholder="PIPES" name="eighteenmetres_wip_pipes"/>
                                <input type="text" class="form-control" placeholder="PIPES" name="dress_wip_pipes"/>
                            </div>

                            <div>
                                <label for="shift_hours"></label>
                                <input type="text" class="form-control" placeholder="COMMENTS" name="sco_wip_comments"/>
                                <input type="text" class="form-control" placeholder="COMMENTS" name="eighteenmetres_wip_comments"/>
                                <input type="text" class="form-control" placeholder="COMMENTS" name="dress_wip_comments"/>
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
                                <input type="text" class="form-control" placeholder="PIPES"  name="restraight_wip_pipes">
                                <input type="text" class="form-control" placeholder="PIPES" name="table_9_wip_pipes"/>
                                <input type="text" class="form-control" placeholder="PIPES" name="rhs_floor_wip_pipes"/>
                            </div>

                            <div>
                                <label for="shift_hours"></label>
                                <input type="text" class="form-control" placeholder="COMMENTS" name="restraight_wip_comments"/>
                                <input type="text" class="form-control" placeholder="COMMENTS" name="table_9_wip_comments"/>
                                <input type="text" class="form-control" placeholder="COMMENTS" name="rhs_floor_wip_comments"/>
                            </div>

                        </div>
                    </div>

                    <hr />
                    <input type="hidden" id="XDEBUG_TRIGGER"    class="form-control"  name="XDEBUG_TRIGGER" value="1"/>
                    <br />
                    <br />

                    <button type="submit" class="btn btn-primary">Submit Shift Log</button>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('functionalScripts')

    <script>
        /**
         * Add ajax header for CSRF Token
         * */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });




    </script>

@endsection
