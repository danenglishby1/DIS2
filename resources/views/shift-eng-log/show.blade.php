@extends('layouts.app')

@section('pageTitle', 'Audit Details')
@section('pageName', 'Audit Details')
@section('css')
    <style>

    </style>
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
                    </div><br/>
                @endif

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


                            <h4>Shift Log No</h4>
                            {{$shiftEngLogMeta->id}}
                            <hr/>

                            <div class="simpleflex">
                                <div>
                                    <div>
                                        <h5 style="margin-top: 0.5em;text-decoration: underline;">Shift</h5>
                                        <span style="font-weight: bold">{{$shiftEngLogMeta->shift}}</span>
                                    </div>

                                    <div>
                                        <h5 style="margin-top: 0.5em;text-decoration: underline;">Absence Calls</h5>
                                        <span style="font-weight: bold">{{$shiftEngLogMeta->absence_calls}}
                                    </div>

                                    <div>
                                        <h5 style="margin-top: 0.5em;text-decoration: underline;">Covid Calls</h5>
                                        <span style="font-weight: bold">{{$shiftEngLogMeta->covid_calls}}
                                    </div>


                                    <div>
                                        <h5 style="margin-top: 0.5em;text-decoration: underline;">General Comments</h5>
                                        <span style="font-weight: bold">{{$shiftEngLogMeta->general_comments}}</span>
                                    </div>

                                    <div>
                                        <h5 style="margin-top: 0.5em;text-decoration: underline;">No. BA For Eng Shift</h5>
                                        <span style="font-weight: bold">{{$shiftEngLogMeta->no_ba_for_eng_shift}}</span>
                                    </div>

                                    <div>
                                        <h5 style="margin-top: 0.5em;text-decoration: underline;">Not Right First Time</h5>
                                        <span style="font-weight: bold"> {{$shiftEngLogMeta->not_right_first_time}}</span>
                                    </div>

                                    <div>
                                        <h5 style="margin-top: 0.5em;text-decoration: underline;">Not Right First Time</h5>
                                        <span style="font-weight: bold">{{$shiftEngLogMeta->not_right_first_time}}</span>
                                    </div>

                                    <div>
                                        <h5 style="margin-top: 0.5em;text-decoration: underline;">Crane Keys All Present</h5>
                                        <span style="font-weight: bold">{{$shiftEngLogMeta->crane_keys_all_present}}</span>
                                    </div>

                                    <div>
                                        <h5 style="margin-top: 0.5em;text-decoration: underline;">Any Functional Tests</h5>
                                        <span style="font-weight: bold">  {{$shiftEngLogMeta->any_functional_tests}}</span>
                                    </div>


                                    <div>
                                        <h5 style="margin-top: 0.5em;text-decoration: underline;">Checked RHS Fitters Log</h5>
                                        <span style="font-weight: bold">{{$shiftEngLogMeta->checked_rhs_fitters_log}}</span>
                                    </div>

                                    <div>
                                        <h5 style="margin-top: 0.5em;text-decoration: underline;">Stores Stock Out Email</h5>
                                        <span style="font-weight: bold">{{$shiftEngLogMeta->stores_stock_out_email}}</span>
                                    </div>

                                    <div>
                                        <h5 style="margin-top: 0.5em;text-decoration: underline;">No. Konecranes Audits</h5>
                                        <span style="font-weight: bold"> {{$shiftEngLogMeta->no_konecranes_audits}}</span>
                                    </div>

                                    <div>
                                        <h5 style="margin-top: 0.5em;text-decoration: underline;">Check Emerging Work 2-10</h5>
                                        <span style="font-weight: bold"> {{$shiftEngLogMeta->check_emerging_work_2_10}}</span>
                                    </div>
                                </div>

                            </div>


                            <hr/>
                            <div>
                                <div>
                                    <h5>Created At</h5>
                                    {{$shiftEngLogMeta->created_at}}
                                </div>

                                <div>
                                    <h5>Updated At</h5>
                                    {{$shiftEngLogMeta->updated_at}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
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
                @foreach($shiftEngLogs as $log)
                    <tr>
                        <td>{{$log->machine}}</td>
                        <td>{{$log->job_no}}</td>
                        <td>{{$log->trade}}</td>
                        <td>{{$log->breakdown}}</td>
                        <td>{{$log->description}}</td>
                        <td>{{$log->status}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>


            <hr/>
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
                @foreach($shiftEngPriorityEmergingWork as $shiftEmergingWorkLog)
                    <tr>
                        <td>{{$shiftEmergingWorkLog->machine}}</td>
                        <td>{{$shiftEmergingWorkLog->job_no}}</td>
                        <td>{{$shiftEmergingWorkLog->trade}}</td>
                        <td>{{$shiftEmergingWorkLog->breakdown}}</td>
                        <td>{{$shiftEmergingWorkLog->description_why}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>

@endsection



@section('functionalScripts')


    <script>


    </script>

@endsection
