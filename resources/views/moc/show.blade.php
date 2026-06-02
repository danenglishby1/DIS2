@extends('layouts.app')

@section('pageTitle', 'MoC Details')
@section('pageName', 'MoC Details')
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

                @if($moc->is_soft_deleted == 1)
                <h1 class="alert-danger p-3">Deleted</h1>
                @endif

                <h3 style="margin: 1em 0;">Insignificant Management Of Change Details</h3>
                <hr>
                <div
                    style="font-size: 16px;display: flex; justify-content: space-around; margin-bottom: 30px;font-weight: bold;">
                    <div>Complete Status: {{($moc->MocCompleteStatus->status == "N" ? "Incomplete" : "Complete")}}</div>

                    <div>Authorised
                        Status: {{($moc->MocAuthorisedStatus->status == "N" ? "Unauthorised" : "Authorised")}}</div>
                </div>
                <div>
                    <dl class="row">
                        <dt class="col-sm-2">MoC No:</dt>
                        <dd class="col-sm-2">{{ $moc["id"] }}</dd>

                        <dt class="col-sm-2">Title</dt>
                        <dd class="col-sm-2">{{ $moc["change_title"] }}</dd>

                        <dt class="col-sm-2">Risk Rating</dt>
                        <dd class="col-sm-2">{{ $moc["risk_rating"] }}</dd>

                        <dt class="col-sm-2">Raised By</dt>
                        <dd class="col-sm-2">{{ $moc["user"]["name"] }}</dd>

                        <dt class="col-sm-2">Authoriser</dt>
                        <dd class="col-sm-2">{{$mocAuthoriser[0]["moc_authoriser"]["user"]["name"]}}</dd>
                    </dl>
                    <div>
                        <h4 style="margin: 1em 0;">Description</h4>
                        <div>{{ $moc["change_description"] }}</div>
                    </div>

                    <div>
                        <h4 style="margin: 1em 0;">People Consulted</h4>
                        <div>

                            @foreach($mocPersonsConsulted as $person)
                                <div class="m-2 mofc-border-background">&#10004; {{$person["user"]["name"]}}</div>
                            @endforeach

                        </div>
                    </div>

                    @if(count($moc["MocFiles"]) > 0)
                    <div>
                        <h4 style="margin: 1em 0;">Attached Files</h4>
                        <ul>
                        @foreach($moc["MocFiles"] as $mocFile)

                            <li><a target="_blank" href="{{asset('public/storage/moc-files/') ."/".$mocFile->file_path}}">{{$mocFile->original_file_name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                        @endif
                </div>
            </div>

@endsection
