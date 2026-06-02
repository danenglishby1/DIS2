@extends('layouts.app')

@section('pageTitle', 'Serious Concern Details')
@section('pageName', 'Serious Concern Details')
@section('content')
    <a href="/DIS/wm-serious-concern" class="btn-link" style="margin:1em;">< Back to serious concerns</a>
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

                <dl class="row">

                    <dt class="col-sm-2">WEEK</dt>
                    <dd class="col-sm-2">{{ $seriousConcern->WEEK }}</dd>
                    <dt class="col-sm-2">COIL</dt>
                    <dd class="col-sm-2">{{ $seriousConcern->COIL }}</dd>
                    <dt class="col-sm-2">OD</dt>
                    <dd class="col-sm-2">{{ $seriousConcern->OD }}</dd>
                    <dt class="col-sm-2">GRADE</dt>
                    <dd class="col-sm-2">{{ $seriousConcern->GRADE }}</dd>
                    <dt class="col-sm-2">THICKNESS</dt>
                    <dd class="col-sm-2">{{ $seriousConcern->THICKNESS }}</dd>
                    <dt class="col-sm-2">REASON</dt>
                    <dd class="col-sm-2">{{ $seriousConcern->REASON }}</dd>
                    <dt class="col-sm-2">PROCESS_ROUTE</dt>
                    <dd class="col-sm-2">{{ $seriousConcern->PROCESS_ROUTE }}</dd>
                    <dt class="col-sm-2">PROCESS_ROUTE</dt>
                    <dd class="col-sm-2">{{ $seriousConcern->COMMENTS }}</dd>
                    <dt class="col-sm-2">PIPES</dt>
                    <dd class="col-sm-2">{{ $seriousConcern->PIPES }}</dd>

                    <dt class="col-sm-2">RAISED BY</dt>
                    <dd class="col-sm-2">{{ $seriousConcern->user->name }}</dd>


                    <dt class="col-sm-2">REPORTED TO</dt>
                    <dd class="col-sm-2">{{ $seriousConcern->REPORTED_TO_USER }}</dd>


{{--                    <dt class="col-sm-2">IMAGE</dt>--}}
{{--                    <dd class="col-sm-2">{{ $seriousConcern['IMAGE']}}</dd>--}}

                    <dt class="col-sm-2">CREATED_AT</dt>
                    <dd class="col-sm-2">{{ $seriousConcern->created_at}}</dd>

                    <dt class="col-sm-2">UPDATED_AT</dt>
                    <dd class="col-sm-2">{{ $seriousConcern->updated_at}}</dd>

                    {{--                <a href="{{ route('users.edit',$user->id)}}" class="btn btn-primary ml-3">Edit</a>--}}

                </dl>
                    @if ($seriousConcern->IMAGE !== "")
                <img style="width:100%;" src="{{asset('public/storage/wm-serious-concern/'.$seriousConcern->FILE_PATH)}}"/>
                    @endif
                    {{-- $userId == R.Butler || $userId == LABS || $userId == D.E --}}
                    @if($userId == 47 || $userId == 56 || $userId == 4)
                    <a href="{{ route('wm-serious-concern.edit',$seriousConcern->id)}}" class="btn btn-warning mb-2 mt-2 p-2">Edit This Serious Concern</a>
                        @endif
            </div>
        </div>
    </div>

@endsection
