@extends('layouts.app')

@section('pageTitle', 'Add MoC')
@section('pageName', 'Add MoC')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/dropzone/dropzone.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/select2/select2.min.css')}}"/>
@endsection
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
                <form method="post" id="mocForm" action="{{ route('moc.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group m-1">
                        <label for="dept">Department.</label>
                        <select class="form-control" name="dept">
                            @foreach($mocDepartmentAndAuthorisers as $dept)
                                <option
                                    value="{{$dept->MocDepartment->id}}">{{$dept->MocDepartment->department}}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group m-1">
                        <label for="change_title">MoC Change Title.</label>
                        <input type="text" class="form-control" name="change_title" required>
                    </div>

                    <div class="form-group m-1">
                        <label for="change_description">MoC Description.</label>
                        <textarea style="width:100%" rows="6" name="change_description"></textarea>
                    </div>
                    <div class="form-group m-1">

                        <label for="persons_consulted">Persons Consulted.</label>
                        <select style="width:100%;" class="js-example-basic-multiple" name="persons_consulted[]"
                                multiple="multiple" >

                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="d-flex flex-wrap justify-content-center" style="margin: 20px auto;width: 500px;">
                        <div class="form-group m-1" style="width:140px">
                            <label for="consequence_of_failure">Consequence Of Failure</label>
                            <select id="consequence_of_failure" name="consequence_of_failure" required>
                                <option value="" disabled selected>Please select..</option>
                                <option value="1">1 - Minor</option>
                                <option value="2">2 - Moderate</option>
                                <option value="3">3 - Severe</option>
                            </select>
                        </div>
                        <div class="form-group m-1" style="width:140px">
                            <label for="complexity_of_change">Complexity Of Change</label>
                            <select id="complexity_of_change" name="complexity_of_change" required>
                                <option value="" disabled selected>Please select..</option>
                                <option value="1">1 - Simple</option>
                                <option value="2">2 - Moderate</option>
                                <option value="3">3 - Complex</option>
                            </select>
                        </div>
                        <div class="form-group m-1" style="width:140px">
                            <label for="familiarity_with_system">Familiarity With System</label>
                            <select id="familiarity_with_system" name="familiarity_with_system" required>
                                <option value="" disabled selected>Please select..</option>
                                <option value="1">1 - Familiar</option>
                                <option value="2">2 - Novel</option>
                            </select>
                        </div>
                        <div class="form-group m-1" style="width:140px">
                            <label for="risk_rating">Risk Rating</label>
                            <input type="number" id="risk_rating" class="form-control" name="risk_rating" value="0"
                                   readonly required/>
                        </div>
                        <div class="form-group m-1">
                            <label for="risk_impact">Status Impact</label>
                            <input type="text" id="status_impact" class="form-control" name="status_impact" readonly
                                   required/>

                        </div>
                    </div>

                    <div>
                        <div id="saveAsDraft" class="form-group">
                            <label for="is_draft">Save As Draft?</label>
                            <select name="is_draft" id="isDraftSelect" required class="form-control">
                                <option value="">Please Select</option>
                                <option value="Y">Yes</option>
                                <option value="N">No</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" id="initiateMocButton" class="btn btn-primary mt-2">Initiate MoC</button>
                </form>
                <br/>


            </div>
        </div>
    </div>
    </div>
@endsection

@section('functionalScripts')

    <script src="{{ asset('public/libraries/select2/select2.min.js')}}"></script>
    <script src="{{ asset('public/libraries/dropzone/dropzone.min.js')}}"></script>
    <script>

        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
        });

        $(document).on('change', '#consequence_of_failure, #complexity_of_change, #familiarity_with_system', function () {
            var riskRating = 0;
            var consequenceOfFailure = (isNaN(parseInt($('#consequence_of_failure').val())) ? 0 : parseInt($('#consequence_of_failure').val()));
            var complexityOfChange = (isNaN(parseInt($('#complexity_of_change').val())) ? 0 : parseInt($('#complexity_of_change').val()));
            var familiarityWithSystem = (isNaN(parseInt($('#familiarity_with_system').val())) ? 0 : parseInt($('#familiarity_with_system').val()));
            var statusImpact = "Insignificant";
            console.log(consequenceOfFailure, complexityOfChange, familiarityWithSystem);
            riskRating = consequenceOfFailure + complexityOfChange + familiarityWithSystem;
            $('#initiateMocButton').html('Initiate Insignificant MoC')

            if (riskRating >= 5) {
                statusImpact = "Significant"
                $('#initiateMocButton').html('Start Significant MoC')

            }


            $('#risk_rating').val(riskRating);
            $('#status_impact').val(statusImpact);
        });

    </script>
@endsection
