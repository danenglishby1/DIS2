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
                <form method="post" action="{{ route('shift-eng-log.update', $shiftEngLogMeta->id) }}"
                      enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf


                    <div class="form-group m-1">
                        <label for="department_id">Shift</label>
                        <select class="form-control" name="shift">
                            <option {{($shiftEngLogMeta->shift == "6x6 Nights" ? "selected" : "")}}>6x6 Nights</option>
                            <option {{($shiftEngLogMeta->shift == "6x6 Days" ? "selected" : "")}}>6x6 Days</option>
                            <option {{($shiftEngLogMeta->shift == "6x2 Days" ? "selected" : "")}}>6x2 Days</option>
                            <option {{($shiftEngLogMeta->shift == "10x6 Nights" ? "selected" : "")}}>10x6 Nights
                            </option>
                        </select>
                    </div>

                    <div class="form-group m-1">
                        <label for="absence_calls">Absence Calls</label>
                        <input class="form-control" type="text" name="absence_calls"
                               value="{{$shiftEngLogMeta->absence_calls}}">
                    </div>

                    <div class="form-group m-1">
                        <label for="covid_calls">Covid Calls</label>
                        <input class="form-control" type="text" name="covid_calls"
                               value="{{$shiftEngLogMeta->covid_calls}}">
                    </div>

                    <div class="form-group m-1">
                        <label for="general_comments">General Comments</label>
                        <input class="form-control" type="text" name="general_comments"
                               value="{{$shiftEngLogMeta->general_comments}}">
                    </div>

                    <div class="form-group m-1">
                        <label for="no_ba_for_eng_shift">No BA for Eng 1/shift</label>
                        <input class="form-control" type="text" name="no_ba_for_eng_shift"
                               value="{{$shiftEngLogMeta->no_ba_for_eng_shift}}">
                    </div>

                    <div class="form-group m-1">
                        <label for="no_konecranes_audits">No. of Konecranes Audits 1/shift</label>
                        <input class="form-control" type="text" name="no_konecranes_audits"
                               value="{{$shiftEngLogMeta->no_konecranes_audits}}">
                    </div>

                    <div class="form-group m-1">
                        <label for="any_functional_tests">Any functional tests?</label>
                        <select class="form-control" name="any_functional_tests">
                            <option value="">Please Select Y/N</option>
                            <option value="N" {{($shiftEngLogMeta->any_functional_tests == "N" ? "selected" : "")}}>N
                            </option>
                            <option value="Y" {{($shiftEngLogMeta->any_functional_tests == "Y" ? "selected" : "")}}>Y
                            </option>
                        </select>
                    </div>

                    <div class="form-group m-1">
                        <label for="not_right_first_time">Not Right First Time</label>
                        <select class="form-control" name="not_right_first_time">
                            <option value="">Please Select Y/N</option>
                            <option value="N" {{($shiftEngLogMeta->not_right_first_time == "N" ? "selected" : "")}}>N
                            </option>
                            <option value="Y" {{($shiftEngLogMeta->not_right_first_time == "Y" ? "selected" : "")}}>Y
                            </option>
                        </select>

                    </div>

                    <div class="form-group m-1">
                        <label for="checked_rhs_fitters_log">Checked RHS Fitters Log</label>
                        <select class="form-control" name="checked_rhs_fitters_log">
                            <option value="">Please Select Y/N</option>
                            <option value="N" {{($shiftEngLogMeta->checked_rhs_fitters_log == "N" ? "selected" : "")}}>
                                N
                            </option>
                            <option value="Y" {{($shiftEngLogMeta->checked_rhs_fitters_log == "Y" ? "selected" : "")}}>
                                Y
                            </option>
                        </select>
                    </div>

                    <div class="form-group m-1">
                        <label for="check_emerging_work_2_10">Check Emerging Work from 2-10</label>
                        <select class="form-control" name="check_emerging_work_2_10">
                            <option value="">Please Select Y/N</option>
                            <option value="N" {{($shiftEngLogMeta->check_emerging_work_2_10 == "N" ? "selected" : "")}}>
                                N
                            </option>
                            <option value="Y" {{($shiftEngLogMeta->check_emerging_work_2_10 == "Y" ? "selected" : "")}}>
                                Y
                            </option>
                        </select>
                    </div>

                    <div class="form-group m-1">
                        <label for="crane_keys_all_present">Crane Keys all present</label>
                        <select class="form-control" name="crane_keys_all_present">
                            <option value="">Please Select Y/N</option>
                            <option value="N" {{($shiftEngLogMeta->crane_keys_all_present == "N" ? "selected" : "")}}>
                                N
                            </option>
                            <option value="Y" {{($shiftEngLogMeta->crane_keys_all_present == "Y" ? "selected" : "")}}>
                                Y
                            </option>
                        </select>
                    </div>

                    <div class="form-group m-1">
                        <label for="stores_stock_out_email">Stores "Stock-out" email</label>
                        <select class="form-control" name="stores_stock_out_email">
                            <option value="">Please Select Y/N</option>
                            <option value="N" {{($shiftEngLogMeta->stores_stock_out_email == "N" ? "selected" : "")}}>
                                N
                            </option>
                            <option value="Y" {{($shiftEngLogMeta->stores_stock_out_email == "Y" ? "selected" : "")}}>
                                Y
                            </option>
                        </select>
                    </div>
                    <input type="hidden" name="shift_eng_log_meta_id" value="{{$shiftEngLogMeta->id}}"/>

                    <hr/>
                    <h4>Shift Log</h4>
                    <table class="table">
                        <thead>
                        <th>Machine</th>
                        <th>Job No</th>
                        <th>Trade</th>
                        <th>Break-Down</th>
                        <th>Description</th>
                        <th>Status</th>
                        </thead>
                        <tbody>
                        @for($i = 0; $i < 10; $i++)
                            <tr>
                                <td><input type="text" name="sl_machine[]"
                                           value="{{(isset($shiftEngLogs[$i]) ? $shiftEngLogs[$i]->machine : "")}}">
                                </td>
                                <td><input type="text" name="sl_job_no[]"
                                           value="{{(isset($shiftEngLogs[$i]) ? $shiftEngLogs[$i]->job_no : "")}}"></td>
                                <td><input type="text" name="sl_trade[]"
                                           value="{{(isset($shiftEngLogs[$i]) ? $shiftEngLogs[$i]->trade : "")}}"></td>
                                <td><input type="text" name="sl_breakdown[]"
                                           value="{{(isset($shiftEngLogs[$i]) ? $shiftEngLogs[$i]->breakdown : "")}}">
                                </td>
                                <td><input type="text" name="sl_description[]"
                                           value="{{(isset($shiftEngLogs[$i]) ? $shiftEngLogs[$i]->description : "")}}">
                                </td>
                                <td><input type="text" name="sl_status[]"
                                           value="{{(isset($shiftEngLogs[$i]) ? $shiftEngLogs[$i]->status : "")}}"></td>
                            </tr>
                            <input type="hidden" name="sl_id[]" value="{{(isset($shiftEngLogs[$i]) ? $shiftEngLogs[$i]->id : "")}}">
                        @endfor
                        </tbody>
                    </table>


                    <hr/>
                    <h4>Priority Emerging Work</h4>
                    <table class="table">
                        <thead>
                        <th>Machine</th>
                        <th>Job No</th>
                        <th>Trade</th>
                        <th>When</th>
                        <th>Description & Why?</th>
                        </thead>
                        <tbody>
                        @for($i = 0; $i < 3; $i++)
                            <tr>
                                <td><input type="text" name="pew_machine[]"
                                           value="{{(isset($shiftEngPriorityEmergingWork[$i]) ? $shiftEngPriorityEmergingWork[$i]->machine : "")}}">
                                </td>
                                <td><input type="text" name="pew_job_no[]"
                                           value="{{(isset($shiftEngPriorityEmergingWork[$i]) ? $shiftEngPriorityEmergingWork[$i]->job_no : "")}}">
                                </td>
                                <td><input type="text" name="pew_trade[]"
                                           value="{{(isset($shiftEngPriorityEmergingWork[$i]) ? $shiftEngPriorityEmergingWork[$i]->trade : "")}}">
                                </td>
                                <td><input type="text" name="pew_when[]"
                                           value="{{(isset($shiftEngPriorityEmergingWork[$i]) ? $shiftEngPriorityEmergingWork[$i]->when : "")}}">
                                </td>
                                <td><input type="text" name="pew_description_why[]"
                                           value="{{(isset($shiftEngPriorityEmergingWork[$i]) ? $shiftEngPriorityEmergingWork[$i]->description_why : "")}}">
                                </td>
                            </tr>

                            <input type="hidden" name="pew_id[]" value="{{(isset($shiftEngPriorityEmergingWork[$i]) ? $shiftEngPriorityEmergingWork[$i]->id : "")}}">
                        @endfor
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary m-1">Update</button>
                </form>


                @endsection
                @section('functionalScripts')
                    <script src="{{ asset('public/libraries/select2/select2.min.js')}}"></script>
                    <script>
                        $(document).ready(function () {
                            $('.js-example-basic-multiple').select2();
                        });
                    </script>
@endsection
