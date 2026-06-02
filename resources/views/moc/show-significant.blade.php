@extends('layouts.app')

@section('pageTitle', 'MofC Significant Details')
@section('pageName', 'MofC Significant Details')
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

                <div class="print-logos">
                    <div><img src="{{asset('public/images/tata-logo-1.png')}}"/></div>
                    <div><img src="{{asset('public/images/tata-logo-2.png')}}"/></div>

                </div>

                @if($moc["moc"]["is_soft_deleted"] == 1)
                    <h1 class="alert-danger p-3">Deleted</h1>
                @endif

                <h3 style="margin: 1em 0;">Significant Management Of Change Details</h3>
                <hr>
                <div
                    style="font-size: 16px;display: flex; justify-content: space-around; margin-bottom: 30px;font-weight: bold;">

                    <div>Complete
                        Status: {{($moc["moc"]["moc_complete_status"]["status"] == "N" ? "Incomplete" : "Complete")}}</div>

                    <div>Authorised
                        Status: {{($moc["moc"]["moc_authorised_status"]["status"] == "N" ? "Unauthorised" : "Authorised")}}</div>
                </div>
                <div>
                    <dl class="row">
                        <dt class="col-sm-2">MofC No:</dt>
                        <dd class="col-sm-2">{{ $moc["moc_id"] }}</dd>

                        <dt class="col-sm-2">Title</dt>
                        <dd class="col-sm-2">{{ $moc["moc"]["change_title"] }}</dd>

                        <dt class="col-sm-2">Risk Rating</dt>
                        <dd class="col-sm-2">{{ $moc["moc"]["risk_rating"] }}</dd>

                        <dt class="col-sm-2">Raised By</dt>
                        <dd class="col-sm-2">{{ $moc["user"]["name"] }}</dd>

                        <dt class="col-sm-2">Authoriser</dt>
                        <dd class="col-sm-2">{{$mocAuthoriser[0]["moc_authoriser"]["user"]["name"]}}</dd>

                        <dt class="col-sm-2">Reference</dt>
                        <dd class="col-sm-2">{{$moc["reference"]}}</dd>

                        <dt class="col-sm-2">New Risk Assessment?</dt>
                        <dd class="col-sm-2">{{$moc["new_risk_assessment_ind"]}}</dd>

                        <dt class="col-sm-2">Existing Risk Assessment?</dt>
                        <dd class="col-sm-2">{{$moc["existing_risk_assessment_ind"]}}</dd>

                        <dt class="col-sm-2">Reviewed By</dt>
                        <dd class="col-sm-2">{{$moc["reviewed_by_user"]["name"]}}</dd>

                    </dl>
                    <div>
                        <h4 style="margin: 1em 0;">Description</h4>
                        <div>{{ $moc["description"] }}</div>
                    </div>

                    <div>
                        <h4 style="margin: 1em 0;">People Consulted</h4>
                        <div style="display:flex ;flex-wrap: wrap;justify-content: space-between;">

                            @foreach($personsConsulted as $person)
                                <div class="m-2 mofc-border-background">&#10004; {{$person["user"]["name"]}}</div>
                            @endforeach

                        </div>
                    </div>

                    <div>
                        <h4 style="margin: 1em 0;">Departments Consulted/Involved</h4>
                        <div style="display:flex ;flex-wrap: wrap;justify-content: space-between;">

                            @foreach($mocDepartments as $dept)
                                <span
                                    class="m-2 mofc-border-background"> &#10004; {{$dept["moc_department"]["department"]}} </span>
                            @endforeach

                        </div>
                    </div>

                    <div>
                        <h4 style="margin: 1em 0;">Area Consulted/Involved</h4>
                        <div style="display:flex;">

                            @foreach($mocAreaRelations as $area)
                                <span
                                    class="m-2 mofc-border-background"> &#10004; {{$area["moc_area_relation"]["area_relation"]}} </span>
                            @endforeach

                        </div>
                    </div>

                    <div>
                        <h4 style="margin: 1em 0;">Controls Affected/Involved</h4>
                        <div style="display:flex ;flex-wrap: wrap;justify-content: space-between;">
                            @foreach($mocControls as $control)
                                <span
                                    class="m-2 mofc-border-background"> &#10004; {{$control["moc_controls"]["control"]}} </span>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 style="margin: 1em 0;">Actions</h4>
                        <div>
                            <table class="table table-striped">
                                <thead>
                                <th colspan="5">Agreed Action Plan (Following discussion)</th>
                                </thead>
                                <tr class="table-dark" style="font-weight: bold; color:#000">
                                    <td>Action</td>
                                    <td>Responsibility</td>
                                    <td>Date</td>
                                    <td>Actionee Comments</td>
                                    <td>Completed</td>
                                </tr>

                                @foreach($mocUserActions as $userAction)
                                    <tr class="{{ ($userAction["complete_status"] == "Yes" ? 'table-success' : 'table-warning') }}">
                                        <td>{{$userAction["action"]}}</td>
                                        <td>{{$userAction["user"]["name"]}}</td>
                                        <td>{{$userAction["complete_by_date"]}}</td>
                                        <td>{{$userAction["actionee_comment"]}}</td>
                                        <td>{{$userAction["complete_status"]}}</td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>

                </div>

                    @if(count($moc["moc"]["moc_files"]) > 0)
                        <div>
                            <h4 style="margin: 1em 0;">Attached Files</h4>
                            <ul>
                                @foreach($moc["moc"]["moc_files"] as $mocFile)
                                    <li><a target="_blank" href="{{asset('public/storage/moc-files/') ."/".$mocFile["file_path"]}}">{{$mocFile["original_file_name"]}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

            </div>
        </div>

@endsection
