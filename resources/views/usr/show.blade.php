@extends('layouts.app')

@section('pageTitle', 'Ultrasonic Reject Details')
@section('pageName', 'Ultrasonic Reject Details')
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

                <dl class="row">

                    <dt class="col-sm-2">Week</dt>
                    <dd class="col-sm-2">{{ $usrRecord->week }}</dd>

                    <dt class="col-sm-2">Coil</dt>
                    <dd class="col-sm-2">{{ $usrRecord->coil }}</dd>

                    <dt class="col-sm-2">Pipe</dt>
                    <dd class="col-sm-2">{{ $usrRecord->pipe }}</dd>

                    <dt class="col-sm-2">Diameter</dt>
                    <dd class="col-sm-2">{{ $usrRecord->diameter }}</dd>

                    <dt class="col-sm-2">Thickness</dt>
                    <dd class="col-sm-2">{{ $usrRecord->thick }}</dd>

                    <dt class="col-sm-2">Grade</dt>
                    <dd class="col-sm-2">{{ $usrRecord->grade }}</dd>
                    <dt class="col-sm-2">Cast</dt>
                    <dd class="col-sm-2">{{ $usrRecord->cast_no }}</dd>

                    <dt class="col-sm-2">Quality</dt>
                    <dd class="col-sm-2">{{ $usrRecord->quality }}</dd>

                    <dt class="col-sm-2">Location</dt>
                    <dd class="col-sm-2">{{ $usrRecord->location }}</dd>

                    <dt class="col-sm-2">Defect</dt>
                    <dd class="col-sm-2">{{ $usrRecord->defect }}</dd>

                    <dt class="col-sm-2">Side Of Weld</dt>
                    <dd class="col-sm-2">{{ $usrRecord->side_of_weld }}</dd>

                    <dt class="col-sm-2">Comments</dt>
                    <dd class="col-sm-2">{{ $usrRecord->comments }}</dd>

                    <dt class="col-sm-2">Created At</dt>
                    <dd class="col-sm-2">{{ $usrRecord->created_at }}</dd>


                    {{--                <a href="{{ route('users.edit',$user->id)}}" class="btn btn-primary ml-3">Edit</a>--}}

                </dl>


                @if ($usrRecord->USRFiles !== "")

                    @foreach($usrRecord->USRFiles as $file)
                        <img style="width:100%;" src="{{asset('public/storage/usr-files/'.$file->file_path)}}"/>
                    @endforeach
                @endif
                {{-- $userId == R.Butler || $userId == LABS || $userId == D.E --}}
                @if($userId == 47 || $userId == 56 || $userId == 4)
                    <a href="{{ route('usr.edit',$usrRecord->id)}}" class="btn btn-warning mb-2 mt-2 p-2">Edit
                        This USR</a>
                @endif
            </div>
        </div>
    </div>

@endsection
