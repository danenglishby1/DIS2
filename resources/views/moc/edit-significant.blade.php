@extends('layouts.app')

@section('pageTitle', 'Edit Significant MoC')
@section('pageName', 'Edit Significant MoC')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/select2/select2.min.css')}}"/>
    <style>
        .cb-changes-flex {
            flex: 1;
        }
    </style>
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

                <form method="post" id="mocForm" action="{{ route('moc-update-significant') }}">
                    @csrf

                    <div class="form-group m-1">
                        <label for="moc_id">MoC No.</label>
                        <input type="number" class="form-control" name="moc_id" value="{{$moc[0]["moc_id"]}}" readonly/>
                    </div>


                    <h5 style="margin-top: 20px;">Changes To (&#10004;)</h5>
                    <div class="cb-wrap" style="display: flex; justify-content: space-between">
                        @foreach ($areaRelations as $relation)
                            <div class="form-group m-1">
                                <label for="area_relation[]" style="width: 190px;">{{$relation->area_relation}}</label>
                                <input type="checkbox" class="form-control" name="area_relation[]"
                                       style="width: 20px;height: 20px"
                                       value="{{$relation->id}}" {{(in_array($relation->id, $mocAreaRelations) ? "checked" : "")}}/>
                            </div>
                        @endforeach
                    </div>
                    <hr/>

                    <h5 style="margin-top: 20px;">Description (Refer to MoC Checklist)</h5>
                    <div class="form-group m-1">
                        <textarea name="description"  style="width:100%"
                                  rows="10">{{$moc[0]["description"]}}</textarea>
                    </div>

                    <hr/>
                    <h5 style="margin-top: 20px;">Discussions with competent persons / communications with department (&#10004;)</h5>
                    <div class="cb-wrap" style="display: flex; justify-content: space-between">
                        @foreach ($departments as $department)
                            <div class="form-group m-1">
                                <label for="departments[]" style="width: 100px;">{{$department->department}}</label>
                                <input type="checkbox" class="form-control" name="departments[]"
                                       style="width: 20px;height: 20px"
                                       value="{{$department->id}}" {{(in_array($department->id, $mocDepartments) ? "checked" : "")}}/>
                            </div>
                        @endforeach
                    </div>

                    <hr/>
                    <div class="form-group m-1" style="font-size:16px;">
                        <label for="existing_risk_assessment_ind" style="margin-right: 20px;min-width: 200px;">Existing Risk
                            Assessment?</label>
                        <input type="radio" name="existing_risk_assessment_ind"
                               {{$moc[0]["existing_risk_assessment_ind"] == "No" ? "checked" : ""}} value="No">
                        <label for="male" style="margin-right: 20px;">No</label>
                        <input type="radio" name="existing_risk_assessment_ind"
                               {{$moc[0]["existing_risk_assessment_ind"] == "Yes" ? "checked" : ""}} value="Yes">
                        <label for="female">Yes</label><br>
                    </div>

                    <div class="form-group m-1" style="font-size:16px;">
                        <label for="new_risk_assessment_ind" style="margin-right: 20px;min-width: 200px;">New Risk
                            Assessment?</label>
                        <input type="radio" name="new_risk_assessment_ind"
                               {{$moc[0]["new_risk_assessment_ind"] == "No" ? "checked" : ""}} value="No">
                        <label for="male" style="margin-right: 20px;">No</label>
                        <input type="radio" name="new_risk_assessment_ind"
                               {{$moc[0]["new_risk_assessment_ind"] == "Yes" ? "checked" : ""}}  value="Yes">
                        <label for="female">Yes</label><br>
                    </div>

                    <div class="form-group m-1">

                        <label for="reviewed_by">Reviewed By</label>
                        <select style="width:100%;" class="js-example-basic" name="reviewed_by">
                            <option value="0">Please Select..</option>
                            @foreach($users as $user)
                                <option
                                    value="{{$user->id}}" {{($user->id == $moc[0]["reviewed_by_user_id"] ? "selected" : "")}}>{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-1">
                        <label for="reference">Reference</label>
                        <input type="text" class="form-control" name="reference" value="{{$moc[0]["reference"]}}"/>
                    </div>
                    <div style="margin-top: 40px;"></div>
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
                        @foreach($mocUserActions as $userAction)
                            @if($userAction["action_type_ind"] == "standard")
                                <tr>
                                    <input type="hidden" name="action_id[]" value="{{$userAction["id"]}}">
                                    <td><textarea name="action[]" cols="45"
                                                  rows="4">{{$userAction["action"]}}</textarea></td>
                                    <td>
                                        <select style="width:100%;" class="js-example-basic" name="responsibility[]">
                                            <option value="0">Please Select..</option>
                                            @foreach($users as $user)
                                                {{$user}}
                                                <option
                                                    value="{{$user->id}}" {{($user->id == $userAction["user_id"] ? "selected": "")}}>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="date" name="action_date[]"
                                               value="{{$userAction["complete_by_date"]}}"></td>
                                    {{--                                <td><input type="checkbox" name="action_completed[]" ></td>--}}
                                    <td>
                                        <select name="action_completed[]">
                                            <option
                                                value="No" {{($userAction["complete_status"] == "No" ? "selected" : "")}}>
                                                No
                                            </option>
                                            <option
                                                value="Yes" {{($userAction["complete_status"] == "Yes" ? "selected" : "")}}>
                                                Yes
                                            </option>
                                        </select>
                                    </td>
                                    <input type="hidden" name="action_type[]" value="standard">
                                </tr>
                            @endif
                        @endforeach

                    <!-- extra spare fields -->
                        @for($i = 0; $i < 10 - count($mocUserActions); $i++)
                            <tr>
                                <input type="hidden" name="action_id[]" value="0">
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
                                <input type="hidden" name="action_type[]" value="standard">
                            </tr>
                        @endfor
                        <!-- END extra spare fields -->
                        @php
                            $reviewEffectivenessOfChangeActionIsSet = false;
                        @endphp
                        @foreach($mocUserActions as $userAction)
                            @if($userAction["action_type_ind"] == "reoc")
                                @php
                                    $reviewEffectivenessOfChangeActionIsSet = true;
                                @endphp
                                <tr>
                                    <td colspan="4">Review Effectiveness Of Change</td>
                                </tr>
                                <tr style="">
                                    <input type="hidden" name="action_id[]" value="{{$userAction["id"]}}">
                                    <td><input type="text" name="action[]" value="{{$userAction["action"]}}"></td>
                                    <td>
                                        <select style="width:100%;" class="js-example-basic" name="responsibility[]">
                                            <option value="0">Please Select..</option>
                                            @foreach($users as $user)
                                                <option
                                                    value="{{$user->id}}" {{($user->id == $userAction["user_id"] ? "selected": "")}}>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="date" name="action_date[]"
                                               value="{{$userAction["complete_by_date"]}}"></td>
                                    <td>
                                        <select name="action_completed[]">
                                            <option
                                                value="No" {{($userAction["complete_status"] == "No" ? "selected" : "")}}>
                                                No
                                            </option>
                                            <option
                                                value="Yes" {{($userAction["complete_status"] == "Yes" ? "selected" : "")}}>
                                                Yes
                                            </option>
                                        </select>
                                    </td>
                                    <input type="hidden" name="action_type[]" value="reoc">
                                </tr>
                            @endif
                        @endforeach


                        @if(!$reviewEffectivenessOfChangeActionIsSet)
                            <tr>
                                <td colspan="4">Review Effectiveness Of Change</td>
                            </tr>
                            <tr style="">
                                <td><input type="text" name="action[]"></td>
                                <td>
                                    <select style="width:100%;" class="js-example-basic" name="responsibility[]">
                                        <option value="">Please Select..</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="date" name="action_date[]"></td>
                                <td>
                                    <select name="action_completed[]">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </td>
                                <input type="hidden" name="action_type[]" value="reoc">
                            </tr>
                        @endif
                    </table>


                    <div class="form-group m-1">

                        <label for="persons_consulted">Persons Consulted.</label>
                        <select style="width:100%;" class="js-example-basic-multiple" name="persons_consulted[]"
                                multiple="multiple">

                            @foreach($users as $user)
                                <option
                                    {{(in_array($user->id, $personsConsulted) ? "selected" : "")}} value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <h3 style="text-align: center;margin-top: 60px; text-decoration: underline">MoC Checklist</h3>
                    @foreach($significantControls as $key => $value)
                        <h5 style="margin-top:40px;">{{$key}} Controls (&#10004;)</h5>
                        <hr/>
                        <div class="checkbox-wrapper"
                             style="display:flex;flex-wrap:wrap;justify-content: space-between;">
                            @foreach ($value as $v)
                                <div class="form-group m-1 cb-flex" style="width: 260px;display: flex;">
                                    <label for="significant_control[]" style="width: 190px;">{{$v->control}}</label>
                                    <input type="checkbox" class="form-control" name="significant_control[]"
                                           style="width: 30px;height: 30px"
                                           value="{{$v->id}}" {{(in_array($v->id, $mocSignificantControls) ? "checked" : "")}}/>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div id="saveAsDraft" class="form-group mb-2 mt-2">
                        <label for="is_draft">Save As Draft?</label>
                        <select name="is_draft" required class="form-control">
                            <option value="">Please Select</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>

                    <div class="m-1" style="background: #fcfcfc;border:1px solid #ccc;padding: 15px;">
                        @if($moc[0]["user_id"] == $loggedInUserId && $actionsAllComplete || 5 == $loggedInUserId && $actionsAllComplete )
                            <div class="form-group m-1" style="display: flex">
                                <label for="complete" style="width:100px">Complete MoC.</label>
                                <input class="form-control" style="width:40px" name="complete"
                                       type="checkbox" {{($mocCompleteStatus->status == "N" ? "" : "checked")}}>
                            </div>
                        @endif
                        @if($mocAuthoriser[0]["moc_authoriser"]["user"]["id"] == $loggedInUserId)
                            <div class="form-group m-1" style="display: flex">
                                <label for="authorise" style="width:100px">Authorise MoC.</label>
                                <input class="form-control" style="width:40px" name="authorise"
                                       type="checkbox" {{($mocAuthStatus->status == "N" ? "" : "checked")}}>
                            </div>
                        @endif




                        @if($mocAuthoriser[0]["moc_authoriser"]["user"]["id"] == $loggedInUserId || $moc[0]["user_id"] == $loggedInUserId)

                            <div class="mb-3">
                                <h4 style="margin: 1em 0;">Authoriser Comments</h4>
                                <div class="form-group">
                                    <textarea class="form-control" name="free_form_comments">{{$moc[0]["moc"]["free_form_comments"]}}</textarea>
                                </div>
                            </div>

                        @endif


                    </div>


                    @if($moc[0]["user_id"] == $loggedInUserId || $mocAuthoriser[0]["moc_authoriser"]["user"]["id"] == $loggedInUserId)
                        <button type="submit" class="btn btn-primary m-1">Update</button>
                    @endif

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
