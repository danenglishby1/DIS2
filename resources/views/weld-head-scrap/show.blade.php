@extends('layouts.app')

@section('pageTitle', 'QR WM715 Details')
@section('pageName', 'QR WM715 Details')
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

                    <dt class="col-sm-2">DATE</dt>
                    <dd class="col-sm-2">{{ $data->created_at }}</dd>
                    <dt class="col-sm-2">COIL</dt>
                    <dd class="col-sm-2">{{ $data->coil_no }}</dd>
                    <dt class="col-sm-2">QUALITY</dt>
                    <dd class="col-sm-2">{{ $data->quality }}</dd>
                    <dt class="col-sm-2">FRONT END SCRAP (M)</dt>
                    <dd class="col-sm-2">{{ $data->front_end_scrap }}</dd>
                    <dt class="col-sm-2">READ END SCRAP (M)</dt>
                    <dd class="col-sm-2">{{ $data->rear_end_scrap }}</dd>
                    <dt class="col-sm-2">FRONT END COMMENTS</dt>
                    <dd class="col-sm-2">{{ $data->front_end_comments }}</dd>
                    <dt class="col-sm-2">REAR END COMMENTS</dt>
                    <dd class="col-sm-2">{{ $data->rear_end_comments }}</dd>
                    <dt class="col-sm-2">OPERATOR/USER</dt>
                    <dd class="col-sm-2">{{ $data->user->name }}</dd>
                    {{--                <a href="{{ route('users.edit',$user->id)}}" class="btn btn-primary ml-3">Edit</a>--}}

                </dl>

            </div>
        </div>
    </div>

@endsection
