@extends('layouts.app')

@section('pageTitle', 'Add Shift Eng Log')
@section('pageName', 'Add Shift Eng Log')

@section('css')

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
                <form method="post" id="mocForm" action="{{ route('shift-eng-log.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group m-1">
                        <label for="department_id">Shift</label>
                        <select class="form-control" name="shift">
                            <option>6x6 Nights</option>
                            <option>6x6 Days</option>
                            <option>6x2 Days</option>
                            <option>10x6 Nights</option>
                        </select>
                    </div>

                    <div class="form-group m-1">
                        <label for="absence_calls">Absence Calls</label>
                        <input class="form-control" type="text" name="absence_calls">
                    </div>

                    <div class="form-group m-1">
                        <label for="covid_calls">Covid Calls</label>
                        <input class="form-control" type="text" name="covid_calls">
                    </div>

                    <div class="form-group m-1">
                        <label for="general_comments">General Comments</label>
                        <input class="form-control" type="text" name="general_comments">
                    </div>

                    <div class="form-group m-1">
                        <label for="no_ba_for_eng_shift">No BA for Eng 1/shift</label>
                        <input class="form-control" type="text" name="no_ba_for_eng_shift">
                    </div>

                    <div class="form-group m-1">
                        <label for="no_konecranes_audits">No. of Konecranes Audits 1/shift</label>
                        <input class="form-control" type="text" name="no_konecranes_audits">
                    </div>

                    <div class="form-group m-1">
                        <label for="any_functional_tests">Any functional tests?</label>
                        <select class="form-control"  name="any_functional_tests">
                            <option value="">Please Select Y/N</option>
                            <option value="N">N</option>
                            <option value="Y">Y</option>
                        </select>
                    </div>

                    <div class="form-group m-1">
                        <label for="not_right_first_time">Not Right First Time</label>
                        <select class="form-control"  name="not_right_first_time">
                            <option value="">Please Select Y/N</option>
                            <option value="N">N</option>
                            <option value="Y">Y</option>
                        </select>

                    </div>

                    <div class="form-group m-1">
                        <label for="checked_rhs_fitters_log">Checked RHS Fitters Log</label>
                        <select class="form-control"  name="checked_rhs_fitters_log">
                            <option value="">Please Select Y/N</option>
                            <option value="N">N</option>
                            <option value="Y">Y</option>
                        </select>
                    </div>

                    <div class="form-group m-1">
                        <label for="check_emerging_work_2_10">Check Emerging Work from 2-10</label>
                        <select class="form-control"  name="check_emerging_work_2_10">
                            <option value="">Please Select Y/N</option>
                            <option value="N">N</option>
                            <option value="Y">Y</option>
                        </select>
                    </div>

                    <div class="form-group m-1">
                        <label for="crane_keys_all_present">Crane Keys all present</label>
                        <select class="form-control"  name="crane_keys_all_present">
                            <option value="">Please Select Y/N</option>
                            <option value="N">N</option>
                            <option value="Y">Y</option>
                        </select>
                    </div>

                    <div class="form-group m-1">
                        <label for="stores_stock_out_email">Stores "Stock-out" email</label>
                        <select class="form-control"  name="stores_stock_out_email">
                            <option value="">Please Select Y/N</option>
                            <option value="N">N</option>
                            <option value="Y">Y</option>
                        </select>
                    </div>
                    <hr />
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
                                <td><input type="text" name="sl_machine[]"></td>
                                <td><input type="text" name="sl_job_no[]"></td>
                                <td><input type="text" name="sl_trade[]"></td>
                                <td><input type="text" name="sl_breakdown[]"></td>
                                <td><input type="text" name="sl_description[]"></td>
                                <td><input type="text" name="sl_status[]"></td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>


                    <hr />
                    <h4>Priority Emerging Work</h4>
                    <table class="table">
                        <thead>
                        <th>Machine</th>
                        <th>Job No</th>
                        <th>When</th>
                        <th>Trade</th>
                        <th>Description & Why?</th>
                        </thead>
                        <tbody>
                        @for($i = 0; $i < 3; $i++)
                            <tr>
                                <td><input type="text" name="pew_machine[]"></td>
                                <td><input type="text" name="pew_job_no[]"></td>
                                <td><input type="text" name="pew_trade[]"></td>
                                <td><input type="text" name="pew_breakdown[]"></td>
                                <td><input type="text" name="pew_description_why[]"></td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>


                    <button type="submit" id="initiateMocButton" class="btn btn-primary mt-2">Add Shift Eng Log</button>
                </form>
                <br/>


            </div>
        </div>
    </div>
    </div>
@endsection

@section('functionalScripts')


@endsection
