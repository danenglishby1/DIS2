@extends('layouts.app')

@section('pageTitle', 'ETL Mill Details')
@section('pageName', 'ETL Mill Details')
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

                    <dt class="col-sm-2">Name</dt>
                    <dd class="col-sm-2">{{ $etlAreaRecord->name }}</dd>
                    <dt class="col-sm-2">Created By User</dt>
                    <dd class="col-sm-2">{{ $etlAreaRecord->user->name }}</dd>

                    <dt class="col-sm-2">Created At</dt>
                    <dd class="col-sm-2">{{ $etlAreaRecord->created_at }}</dd>

                    <dt class="col-sm-2">Updated At</dt>
                    <dd class="col-sm-2">{{ $etlAreaRecord->updated_at }}</dd>

                    {{--                <a href="{{ route('users.edit',$user->id)}}" class="btn btn-primary ml-3">Edit</a>--}}

                </dl>

            </div>
        </div>
    </div>

@endsection
