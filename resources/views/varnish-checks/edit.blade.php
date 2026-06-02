@extends('layouts.app')

@section('pageTitle', 'Edit Ultrasonic Reject')
@section('pageName', 'Edit Ultrasonic Reject')
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
                <form method="post" action="{{ route('wm-shift-log.update', $wmShiftLog->id) }}" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf

                    <h2 style="text-align: center;">WELDMILL TEAM LEADER SHIFT HANDOVER REPORT</h2>

                    <hr/>

                    <div class="d-flex justify-content-center"
                         style="margin-bottom: 20px;background: #ececec;padding: 5px;border-radius: 10px;">

                        <div class="form-group m-1">
                            <label for="team_leader">TEAM LEADER</label>
                            <input type="text" id="team_leader"   class="form-control" required name="team_leader" value="{{$wmShiftLog->team_leader}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="shift_hours">SHIFT HOURS</label>
                            <input type="number" id="shift_hours" class="form-control"  required name="shift_hours" value="{{$wmShiftLog->shift_hours}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="shift_pattern">SHIFT PATTERNS</label>
                            <select class="form-control"  name="shift_pattern">
                                <option {{($wmShiftLog->shift_pattern == "6x2" ? "selected" : "")}} value="6x2">6x2</option>
                                <option {{($wmShiftLog->shift_pattern == "2x10" ? "selected" : "")}} value="2x10">2x10</option>
                            </select>
                        </div>


                    </div>

                    <div class="form-group m-1 mb-4">
                        <label for="hse_concerns">HSE CONCERNS</label>
                        <textarea name="hse_concerns"  class="form-control">{{$wmShiftLog->hse_concern}}</textarea>
                    </div>

                    <hr />
                    <h4>SHIFT TEAM INFO</h4>
                    <hr />
                    <div style="display:flex">

                        <div class="form-group m-1 text-center">
                            <h4>SICKNESS</h4>
                            <div  style="margin-top:31px;">
                                @foreach(json_decode(json_encode($wmShiftLog->WMShiftLogSickness),true) as $h)
                                    <input type="text" disabled  id="sickness" maxlength="3" class="form-control" placeholder="Name" value="{{$h["employee_name"]}}"  name="sickness[]"/>
                                @endforeach
                            </div>
                        </div>



                    <input type="hidden" id="XDEBUG_TRIGGER" maxlength="3" class="form-control"  name="XDEBUG_TRIGGER" value="1"/>




                    <button type="submit" class="btn btn-primary mt-5">Update</button>
                        </div>
                </form>
    </div>
@endsection
@section('functionalScripts')
    <script>
        const fileInput = document.getElementById("macroImage");
        window.addEventListener('paste', e => {
            fileInput.files = e.clipboardData.files;
        });

    </script>


@endsection
