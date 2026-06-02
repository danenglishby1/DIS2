@extends('layouts.app')

@section('pageTitle', 'Add Ultrasonic Rejects')
@section('pageName', 'Add Ultrasonic Rejects')
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
                <form method="post" action="{{ route('usr.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-center"
                         style="margin-bottom: 20px;background: #ececec;padding: 5px;border-radius: 10px;">

                        <div class="form-group m-1">
                            <label for="week_no">Week (WW)</label>
                            <input type="number" id="weekNo" maxlength="2" class="form-control" required
                                   name="week_no"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="coil_no">Coil</label>
                            <input type="text" id="coilNo" maxlength="3" class="form-control" required name="coil_no"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="pipe_no">Pipe</label>
                            <input type="text" id="pipeNo" maxlength="3" class="form-control" required name="pipe_no"/>
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
                            <label for="quality">Grade</label>
                            <input type="string" id="grade" class="form-control" readonly required name="grade"/>
                        </div>
                        <div class="form-group m-1">
                            <label for="quality">Quality</label>
                            <input type="string" id="quality" class="form-control" readonly required name="quality"/>
                        </div>
                        <div class="form-group m-1">
                            <label for="cast">Cast</label>
                            <input type="string" id="cast" class="form-control" readonly required name="cast"/>
                        </div>
                    </div>

                    <div class="form-group m-1 text-center">
                        <label style="font-weight: bold;font-size:16px;" for="location">Location</label>
                        <select name="location" class="mr-2">
                            <option value="Mill">Mill</option>
                            <option value="Finishing">Finishing</option>
                        </select>


                        <label style="font-weight: bold;font-size:16px;" for="defect">Defect</label>
                        <select name="defect" class="mr-2">
                            <option value="OD Lam to Surface Segragate">OD Lam to Surface Segragate</option>
                            <option value="ID Lam to Surface Segragate">ID Lam to Surface Segragate</option>
                            <option value="OD Lam Sub Surface Segragate">OD Lam Sub Surface Segragate</option>
                            <option value="ID Lam Sub Surface Segragate">ID Lam Sub Surface Segragate</option>
                            <option value="Mid Wall Laminar Segragate">Mid Wall Laminar Segragate</option>
                            <option value="OD Slab Edge Defect">OD Slab Edge Defect</option>
                            <option value="ID Slab Edge Defect">ID Slab Edge Defect</option>
                            <option value="OD Lam to Surface">OD Lam to Surface</option>
                            <option value="ID lam to Surface">ID lam to Surface</option>
                            <option value="OD Lam Sub Surface">OD Lam Sub Surface</option>
                            <option value="ID Lam Sub Surface">ID Lam Sub Surface</option>
                            <option value="Mid Wall Laminar">Mid Wall Laminar</option>
                            <option value="Rolled in Trim">Rolled in Trim</option>
                            <option value="Cold Weld">Cold Weld</option>
                            <option value="Low Squeeze">Low Squeeze</option>
                            <option value="Entrapped Material">Entrapped Material</option>
                            <option value="Black Edges">Black Edges</option>
                            <option value="High ID Trim">High ID Trim</option>
                            <option value="Offset Edges">Offset Edges</option>
                            <option value="NAD">NAD</option>
                            <option value="Miscellaneous">Miscellaneous</option>
                            <option value="Damaged Edge">Damaged Edge</option>

                        </select>

                        <label style="font-weight: bold;font-size:16px;" for="side_of_weld">Side Of Weld</label>
                        <select name="side_of_weld">
                            <option value="NA"></option>
                            <option value="N">N</option>
                            <option value="S">S</option>
                        </select>




                    </div>

                    <div class="form-group m-1 text-center">

                    </div>

                    <div class="form-group m-1 mb-4">
                        <label for="comments">Comments</label>
                        <textarea name="comments" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Add USR</button>
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


        $('#coilNo, #pipeNo').focusout(function () {
            console.log("fired");

            // check if both week & coil have been entered
            var gotExistingGaugeChangeData = false;
            var weekNo = $('#weekNo').val();
            var coilNo = $('#coilNo').val();
            var pipeNo = $('#pipeNo').val();
            $('#coilFoundAlert').css('display', 'none');

            if (pipeNo !== "" && weekNo !== "" && coilNo !== "" && weekNo.length >= 1 && coilNo.length >= 1) {
                // Clear current input VARIABLES form -
                // for (var i = 0; i < 50; i++) {
                //     $('input[name="' + i + '"]').val("");
                // }


                // //IF both week & coil filled in, then check if existing gauge change record. If there is, then fill in fields with whats recorded already
                // $('.ajax-loader').css('display', 'block');
                // $.ajax({
                //     type: 'POST',
                //     data: {"coilNo": coilNo, "weekNo": weekNo},
                //     async: false,
                //     url: rootUrl + '/api/GetGaugeChangeByCoilWeek',
                //     dataType: 'json',
                //     success: function (data) {
                //         console.log(data);
                //         if (data.message === "Record Found") {
                //             gotExistingGaugeChangeData = true;
                //             // PopulateGaugeChangeInputFieldsWithExistingData(data.gaugeChangeData);
                //             PopulateGaugeChangeVariableInputFieldsWithExistingData(data.gaugeChangeVariableData);
                //             $('#coilFoundAlert').css('display', 'block');
                //             $('#createNewGaugeChangeButton').css('display', 'none');
                //
                //             // Redirect to update
                //
                //             window.location.href = rootUrl + "/wm-gauge-change/" + data.gaugeChangeData[0].id + "/edit/";
                //
                //         }
                //     },
                //     complete: function () {
                //         $('.ajax-loader').css('display', 'none');
                //     }
                // });

                //  IF both week & coil filled in & No gauge change record found, get the coil details from tandem db and fill in fields

                    $('#createNewGaugeChangeButton').css('display', 'block');

                    $.ajax({
                        type: 'POST',
                        data: {"coilNo": coilNo, "week": weekNo, "pipeNo" : pipeNo},
                        url: rootUrl + '/api/GetCoilAndPipeDetail',
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
                                $('#grade').val("");
                                $('#cast').val("");
                            } else {
                                $('#quality').val(data[0].COIL_COIL_QUALITY);
                                $('#diameter').val(data[0].BLOCK_OD);
                                $('#thickness').val(data[0].BLOCK_THICK);
                                $('#grade').val(data[0].BLOCK_GRADE);
                                $('#cast').val(data[0].COIL_CAST_NO);
                                $('#coilNotFoundAlert').css('display', 'none');
                            }
                        },
                        complete: function () {
                            $('.ajax-loader').css('display', 'none');
                        }
                    });
                }

        });


        function PopulateGaugeChangeInputFieldsWithExistingData(data) {
            $('#quality').val(data[0].quality);
            $('#diameter').val(data[0].diameter);
            $('#thickness').val(data[0].thickness);

            $('#gaugeChangeId').val(data[0].id);
            $('#coilNotFoundAlert').css('display', 'none');
        }


    </script>

@endsection
