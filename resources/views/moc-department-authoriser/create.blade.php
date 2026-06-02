@extends('layouts.app')

@section('pageTitle', 'Add MoC Department Authoriser')
@section('pageName', 'Add MoC Department Authoriser')

@section('css')
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
                <form method="post" id="mocForm" action="{{ route('moc-department-authoriser.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group m-1">
                        <label for="moc_no">Authoriser.</label>
                        <select class="form-control" name="user_id">
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->User->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group m-1">
                        <label for="dept_id">Department.</label>
                        <select class="form-control" name="dept_id">
                            @foreach($departments as $dept)
                            <option value="{{$dept->id}}">{{$dept->department}}</option>
                            @endforeach

                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2" >Add Department Authoriser</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('functionalScripts')
    <script src="{{ asset('public/libraries/select2/select2.min.js')}}"></script>



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

            if (riskRating >= 5) {
                statusImpact = "Significant"
            }

            $('#risk_rating').val(riskRating);
            $('#status_impact').val(statusImpact);
        });

    </script>
@endsection
