@extends('layouts.app')

@section('pageTitle', 'Edit Audit')
@section('pageName', 'Edit Audit')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/select2/select2.min.css')}}"/>
@endsection
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
                    </div>
                    <br/>
                @endif
                <form method="post" action="{{ route('audit.update', $audit->id) }}">
                    @method('PATCH')
                    @csrf

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
                                <form method="post" id="mocForm" action="{{ route('audit.store') }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group m-1">
                                        <label for="department_id">Department.</label>
                                        <select class="form-control" name="department_id">
                                            @foreach($departments as $dept)
                                                <option
                                                    {{($dept->id == $audit->department_id ? "selected" : "")}} value="{{$dept->id}}">{{$dept->department}}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="form-group m-1">
                                        <label for="process_area_id">Process Area.</label>
                                        <select  class="form-control" name="process_area_id">
                                            @foreach($processAreas as $processArea)
                                                <option
                                                    {{($processArea->id == $audit->process_area_id ? "selected" : "")}}
                                                    value="{{$processArea->id}}">{{$processArea->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group m-1">

                                        <label for="auditor_user_id">Auditor.</label>
                                        <select style="width:100%;" class="form-control" name="auditor_user_id">

                                            @foreach($users as $user)
                                                <option
                                                    {{($user->id == $audit->auditor_user_id ? "selected" : "")}} value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group m-1">
                                        <label for="manager_responsible_user_id">Manager Responsible</label>
                                        <select style="width:100%;" class="form-control" name="manager_responsible_user_id">

                                            @foreach($users as $user)
                                                <option
                                                    {{($user->id == $audit->manager_responsible_user_id ? "selected" : "")}} value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-center">

                                        @foreach($criteriaScores as $criteriaScore)
                                            <input type="hidden" name="criteriaScoreIds[]" value="{{$criteriaScore->id}}"/>
                                            <div style="margin:10px;">{{$criteriaScore->criterias->name}} Audit Criteria
                                                <input type="number"
                                                       name="criteriaScores[]"
                                                       placeholder="1-10" value="{{$criteriaScore->score}}"></div>
                                        @endforeach
                                    </div>

                                    <div class="form-group m-1">
                                        <label for="comments">Comments/Feedback</label>
                                        <textarea style="width:100%" rows="6" name="comments">{{$audit->comments}}</textarea>
                                    </div>


                                    <table class="table">
                                        <thead>
                                        <th colspan="4">Agreed Action Plan (Following discussion)</th>
                                        </thead>
                                        <tr>
                                            <td>Action</td>
                                            <td>Responsibility</td>
                                            <td>Date</td>
                                            <td>Completed</td>
                                        </tr>

                                        <!-- Inputs -->
                                        @for($i = 0; $i < count($auditActions); $i++)
                                            <tr>
                                                <td><textarea name="action[]" cols="45" rows="4">{{$auditActions[$i]["action"]}}</textarea></td>
                                                <td>
                                                    <select style="width:100%;" class="js-example-basic" name="responsibility[]">
                                                        <option value="0">Please Select..</option>
                                                        @foreach($users as $user)
                                                            <option {{($user->id == $auditActions[$i]["responsibility_user_id"] ? "selected" : "")}} value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="date" name="action_date[]" value="{{$auditActions[$i]["date_to_be_completed_by"]}}"></td>
                                                <td>
                                                    <select name="action_completed[]">
                                                        <option value="No">No</option>
                                                        <option {{($auditActions[$i]["completed"] == "Yes" ? "selected" : "")}} value="Yes">Yes</option>
                                                    </select>
                                                </td>
                                                <input type="hidden" name="action_id[]" value="{{$auditActions[$i]["id"]}}">
                                            </tr>
                                            @endfor

                                            </tr>
                                    </table>



                                    <button type="submit" class="btn btn-primary m-1">Update</button>
                            </div>
                        </div>
                    </div>
            </div>


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
    </script>
@endsection
