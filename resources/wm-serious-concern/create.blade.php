@extends('layouts.app')

@section('pageTitle', 'Add Gauge Change Record')
@section('pageName', 'Add Gauge Change Record')
@section('content')
    <div class="row" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
        <div class="col-sm-8">
            <h2 class="display-3"></h2>
            <div style="margin-bottom: 2.5em">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br/>
                @endif
            </div>
        </div>
    </div>


    <div class="row ml-3 mr-3">
        <div class="alert-danger" id="coilNotFoundAlert"
             style="display:none;width: 100%;padding: 10px;text-align: center;font-weight: bold;font-size: 20px;margin-bottom: 5px;">
            ***COIL NOT FOUND*** PLEASE CHECK WEEK NO & COIL NO
        </div>
        <div class="alert-warning" id="coilFoundAlert"
             style="display:none;width: 100%;padding: 10px;text-align: center;font-weight: bold;font-size: 20px;margin-bottom: 5px;">
            Existing Gauge Change Found - Update Activated
        </div>

        <form method="post" id="gauge-change-form" action="{{ route('wm-gauge-change.store') }}"
              enctype="multipart/form-data">
            @csrf
            <div class="d-flex justify-content-center"
                 style="margin-bottom: 20px;background: #ececec;padding: 5px;border-radius: 10px;">

                <div class="form-group m-1">
                    <label for="week_no">Week (WW)</label>
                    <input type="number" id="weekNo" maxlength="2" class="form-control" required name="week_no"/>
                </div>

                <div class="form-group m-1">
                    <label for="coil_no">Coil</label>
                    <input type="text" id="coilNo" maxlength="3" class="form-control" required name="coil_no"/>
                </div>

                <div class="form-group m-1">
                    <label for="diameter">Diameter</label>
                    <input type="number" id="diameter" step="any" class="form-control" required readonly
                           name="diameter"/>
                </div>

                <div class="form-group m-1">
                    <label for="thickness">Thickness</label>
                    <input type="number" step="any" id="thickness" class="form-control" required readonly
                           name="thickness"/>
                </div>

                <div class="form-group m-1">
                    <label for="quality">Quality</label>
                    <input type="string" id="quality" class="form-control" readonly required name="quality"/>
                </div>
            </div>


            <input type="hidden" id="gaugeChangeId" name="gaugeChangeId">

            <div class="d-flex">
                <div style="border: 1px solid #ccc;margin: 1em;padding:1em;min-width: 300px;">
                    <h3 style="width:100%;">Milled Width</h3>
                    <div class="d-flex flex-wrap">
                        {{-- Loop in milled width inputs --}}
                        @foreach($gaugeChangeAreaVariables["Milled Width"] as $value)
                            <div class="form-group" style="width:95%">
                                @if($value["variable"]["variable_name"] == "Milled Width Comments")
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <textarea rows="6" cols="10" class="form-control"
                                              name="{{$value["areaVariableId"]}}"></textarea>

                                @else
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <input type="text" class="form-control" name="{{$value["areaVariableId"]}}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div style="border: 1px solid #ccc;margin: 1em;padding:1em;min-width: 300px;">
                    <h3 style="width:100%;">Forming</h3>
                    <div class="d-flex flex-wrap">

                        @foreach($gaugeChangeAreaVariables["Forming"] as $value)
                            <div class="form-group" style="width:95%">
                                @if($value["variable"]["variable_name"] == "Forming Comments")
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <textarea rows="6" class="form-control"
                                              name="{{$value["areaVariableId"]}}"></textarea>

                                    @elseif($value["variable"]["variable_name"] == "Tram Lines")
                                        <label>{{$value["variable"]["variable_name"]}}</label>
                                        <select class="form-control"
                                                  name="{{$value["areaVariableId"]}}">
                                            <option value="Not Applicable">N/A</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>

                                        </select>

                                    @else
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <input type="text" class="form-control" name="{{$value["areaVariableId"]}}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div style="border: 1px solid #ccc;margin: 1em;padding:1em;min-width: 300px;">
                    <h3 style="width:100%;">Fins/Weld Station</h3>
                    <div class="d-flex flex-wrap">

                        @foreach($gaugeChangeAreaVariables["Fins/Welding Station"] as $value)
                            <div class="form-group" style="width:95%">
                                @if($value["variable"]["variable_name"] == "Fins/Weld Station Comments")
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <textarea rows="6" class="form-control"
                                              name="{{$value["areaVariableId"]}}"></textarea>

                                @else
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <input type="text" class="form-control" name="{{$value["areaVariableId"]}}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div style="border: 1px solid #ccc;border-radius:3px;margin: 1em;padding:1em;min-width: 300px;">
                    <h3 style="width:100%;">Sizing</h3>
                    <div class="d-flex flex-wrap">

                        @foreach($gaugeChangeAreaVariables["Sizing"] as $value)
                            <div class="form-group" style="width:95%">
                                @if($value["variable"]["variable_name"] == "Sizing Comments")
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <textarea rows="6" class="form-control"
                                              name="{{$value["areaVariableId"]}}"></textarea>

                                @else
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <input type="text" class="form-control" name="{{$value["areaVariableId"]}}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <button id="createNewGaugeChangeButton" type="submit" class="btn btn-primary">Add New Gauge Change Record
            </button>
        </form>
        <button class="btn btn-warning" id="updateExistingGaugeChangeButton" style="display: none;">Update Gauge
            Change
        </button>
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


        $('#weekNo, #coilNo').focusout(function () {
            console.log("fired");

            // check if both week & coil have been entered
            var gotExistingGaugeChangeData = false;
            var weekNo = $('#weekNo').val();
            var coilNo = $('#coilNo').val();
            $('#coilFoundAlert').css('display', 'none');

            if (weekNo !== "" && coilNo !== "" && weekNo.length >= 1 && coilNo.length >= 1) {
                // Clear current input VARIABLES form -
                for (var i = 0; i < 50; i++) {
                    $('input[name="' + i + '"]').val("");
                }


                //IF both week & coil filled in, then check if existing gauge change record. If there is, then fill in fields with whats recorded already
                $('.ajax-loader').css('display', 'block');
                $.ajax({
                    type: 'POST',
                    data: {"coilNo": coilNo, "weekNo": weekNo},
                    async: false,
                    url: rootUrl + '/api/GetGaugeChangeByCoilWeek',
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        if (data.message === "Record Found") {
                            gotExistingGaugeChangeData = true;
                            PopulateGaugeChangeInputFieldsWithExistingData(data.gaugeChangeData);
                            PopulateGaugeChangeVariableInputFieldsWithExistingData(data.gaugeChangeVariableData);
                            $('#coilFoundAlert').css('display', 'block');
                            $('#createNewGaugeChangeButton').css('display', 'none');

                            // Redirect to update

                            window.location.href = rootUrl + "/wm-gauge-change/" + data.gaugeChangeData[0].id + "/edit/";

                        }
                    },
                    complete: function () {
                        $('.ajax-loader').css('display', 'none');
                    }
                });

                //  IF both week & coil filled in & No gauge change record found, get the coil details from tandem db and fill in fields
                if (!gotExistingGaugeChangeData) {
                    $('#createNewGaugeChangeButton').css('display', 'block');

                    $.ajax({
                        type: 'POST',
                        data: {"coilNo": coilNo, "week": weekNo},
                        url: rootUrl + '/api/GetCoilDetail',
                        async: false,
                        dataType: 'json',
                        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                            $('.ajax-loader').css('display', 'block');
                        },
                        success: function (data) {
                            console.log(data);
                            if (data.length == 0) {
                                $('#coilNotFoundAlert').css('display', 'block');
                                $('#quality').val("");
                                $('#diameter').val("");
                                $('#thickness').val("");
                            } else {
                                $('#quality').val(data[0].COIL_COIL_QUALITY);
                                $('#diameter').val(data[0].BLOCK_OD);
                                $('#thickness').val(data[0].BLOCK_THICK);
                                $('#coilNotFoundAlert').css('display', 'none');
                            }
                        },
                        complete: function () {
                            $('.ajax-loader').css('display', 'none');
                        }
                    });
                }
            }
        });


        function PopulateGaugeChangeInputFieldsWithExistingData(data) {
            $('#quality').val(data[0].quality);
            $('#diameter').val(data[0].diameter);
            $('#thickness').val(data[0].thickness);
            $('#gaugeChangeId').val(data[0].id);
            $('#coilNotFoundAlert').css('display', 'none');
        }

        function PopulateGaugeChangeVariableInputFieldsWithExistingData(data) {
            for (var i = 0; i < data.length; i++) {
                //Update all HTML form variable input fields with existing values.
                console.log(data[i].gauge_change_area_variable_id);

                $('input[name="' + data[i].gauge_change_area_variable_id + '"]').val(data[i].value);
            }
        }


    </script>

@endsection
