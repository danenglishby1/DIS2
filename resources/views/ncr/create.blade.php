@extends('layouts.app')

@section('pageTitle', 'Add Audit')
@section('pageName', 'Add Audit')

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
                <form method="post" id="mocForm" action="{{ route('ncr.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group m-1">
                        <label for="department_id">Department.</label>
                        <select class="form-control" name="department_id">
                            @foreach($departments as $dept)
                                <option
                                    value="{{$dept->id}}">{{$dept->department}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group m-1">
                        <label for="process_area_id">Process Area.</label>
                        <select class="form-control" name="process_area_id">
                            @foreach($processAreas as $processArea)
                                <option
                                    value="{{$processArea->id}}">{{$processArea->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group m-1">

                        <label for="auditor_user_id">Originator</label>
                        <select style="width:100%;" disabled class="form-control"  name="auditor_user_id">

                            @foreach($users as $user)
                                <option {{($user->id == $loggedInUserId ? "selected" : "")}} value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group m-1">

                        <label for="manager_responsible_user_id">Manager Responsible</label>
                        <select style="width:100%;" class="form-control"  name="manager_responsible_user_id">

                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="form-group m-1">

                        <label for="category">Category</label>
                        <select style="width:100%;" class="form-control"  name="category">
                            <option value="Mill Kit">Mill Kit</option>
                            <option value="Coil Quality Supplier">Coil Quality Supplier</option>
                            <option value="Coil Quality Slitting">Coil Quality Slitting</option>
                            <option value="Coil Quality Milling">Coil Quality Milling</option>
                            <option value="Documentation">Documentation</option>
                            <option value="Working to Procedure">Working to Procedure</option>
                            <option value="Poor Standard of Work">Poor Standard of Work</option>
                            <option value="Calibration">Calibration</option>
                            <option value="Pipe Details">Pipe Details</option>
                            <option value="Quality Incident">Quality Incident</option>
                            <option value="Downgrade Control">Downgrade Control</option>
                            <option value="Label Issues">Label Issues</option>
                            <option value="WIP">WIP</option>
                            <option value="Communication">Communication</option>
                            <option value="Routing">Routing</option>
                            <option value="Dimensional Issue">Dimensional Issue</option>
                            <option value="Training">Training</option>
                            <option value="Manning">Manning</option>
                            <option value="Straightness Issue">Straightness Issue</option>
                            <option value="Supplier Quality">Supplier Quality</option>
                        </select>
                    </div>



                    <div class="d-flex flex-wrap justify-content-center">

                        @foreach($criterias as $criteria)
                     <input type="hidden" name="{{$criteria->name."_".$criteria->id}}" placeholder="1-10" value="0">
                        @endforeach
                    </div>

                    <div class="form-group m-1">
                        <label for="comments">Issue</label>
                        <textarea style="width:100%" rows="6" name="comments"></textarea>
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
                        @for($i = 0; $i < 12; $i++)
                            <tr>
                                <td><textarea name="action[]" cols="45" rows="4"></textarea></td>
                                <td>
                                    <select style="width:100%;" class="js-example-basic" name="responsibility[]">
                                        <option value="0">Please Select..</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="date" name="action_date[]"></td>
                                {{--                                <td><input type="checkbox" name="action_completed[]" ></td>--}}
                                <td>
                                    <select name="action_completed[]">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </td>
                            </tr>
                        @endfor

                        </tr>
                    </table>




                    <button type="submit" id="initiateMocButton" class="btn btn-primary mt-2">Submit</button>
                </form>
                <br/>


            </div>
        </div>
@endsection

@section('functionalScripts')


@endsection
