@extends('layouts.app')

@section('pageTitle', 'Edit ETL Mill')
@section('pageName', 'Edit ETL Mill')
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
                <form method="post" action="{{ route('etl_mill.update', $etlMillRecord->id) }}" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="d-flex flex-wrap justify-content-center" style="margin-top: -70px;">
                        <div class="form-group m-1">
                            <label for="name">ETL Mill Name</label>
                            <input type="text" class="form-control" name="name" value="{{$etlMillRecord->name}}"/>
                        </div>

                            <button type="submit" class="btn btn-primary mt-5">Update</button>
                        </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('functionalScripts')



@endsection
