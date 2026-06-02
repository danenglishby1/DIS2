@extends('layouts.app')

@section('pageTitle', 'Add Significant MoC')
@section('pageName', 'Add Significant MoC')

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
                <div>
                    <h4 style="color: #ff2828;background: yellow;padding: 10px;">Significant Form Required</h4>
                </div>

                <form method="post" id="mocForm" action="{{ route('moc-store-significant') }}">
                    @csrf

                    <div class="form-group m-1">
                        <label for="moc_id">MoC No.</label>
                        <input type="number" class="form-control" name="moc_id" value="{{$mocId}}" readonly/>
                    </div>

                    <h5 style="margin-top: 20px;">Changes To (&#10004;)</h5>
                    <div class="cb-wrap" style="display: flex; justify-content: space-between">
                        @foreach ($areaRelations as $relation)
                            <div class="form-group m-1">
                                <label for="area_relation[]" style="width: 190px;">{{$relation->area_relation}}</label>
                                <input type="checkbox" class="form-control" name="area_relation[]"
                                       style="width: 20px;height: 20px" value="{{$relation->id}}"/>
                            </div>
                        @endforeach
                    </div>
                    <hr/>

                    <h5 style="margin-top: 20px;">Description (Refer to MoC Checklist)</h5>
                    <div class="form-group m-1">
                        <textarea name="description" style="width:100%" rows="10"></textarea>
                    </div>

                    <hr/>
                    <h5 style="margin-top: 20px;">Discussions with competent persons / communications with department (&#10004;)</h5>
                    <div class="cb-wrap" style="display: flex; justify-content: space-between">
                        @foreach ($departments as $department)
                            <div class="form-group m-1">
                                <label for="departments[]" style="width: 100px;">{{$department->department}}</label>
                                <input type="checkbox" class="form-control" name="departments[]"
                                       style="width: 20px;height: 20px" value="{{$department->id}}"/>
                            </div>
                        @endforeach
                    </div>

                    <hr/>
                    <div class="form-group m-1" style="font-size:16px;">
                        <label for="existing_risk_assessment" style="margin-right: 20px;min-width: 200px;">Existing Risk Assessment?</label>
                        <input type="radio" name="existing_risk_assessment"  value="No">
                        <label for="male" style="margin-right: 20px;">No</label>
                        <input type="radio" name="existing_risk_assessment"  value="Yes">
                        <label for="female">Yes</label>
                        <br>
                    </div>

                    <div class="form-group m-1" style="font-size:16px;">
                        <label for="new_risk_assessment" style="margin-right: 20px;min-width: 200px;">New Risk
                            Assessment?</label>
                        <input type="radio" name="new_risk_assessment" value="No">
                        <label for="male" style="margin-right: 20px;">No</label>
                        <input type="radio" name="new_risk_assessment" value="Yes">
                        <label for="female">Yes</label><br>
                    </div>

                    <div class="form-group m-1">

                        <label for="reviewed_by">Reviewed By</label>
                        <select style="width:100%;" class="js-example-basic" name="reviewed_by" >
                            <option value="">Please Select..</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-1">
                        <label for="reference">Procedure Reference</label>
                        <input type="text" class="form-control" name="reference"/>
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
                        @for($i = 0; $i < 10; $i++)
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
                                <input type="hidden" name="action_type[]" value="standard">
                            </tr>
                        @endfor
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
                    </table>

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
                                           style="width: 30px;height: 30px" value="{{$v->id}}"/>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label for="is_draft">Save As Draft?</label>
                        <select name="is_draft" required class="form-control">
                            <option value="">Please Select</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Initiate Significant MoC</button>
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
