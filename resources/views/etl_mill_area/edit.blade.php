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
                <form method="post" action="{{ route('etl_mill_area.update', $etlAreaRecord->id) }}" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="d-flex flex-wrap justify-content-center" style="margin-top: -70px;">

                        <div class="form-group m-1">
                            <label for="etl_mill_id">Mill.</label>
                            <select class="form-control" name="etl_mill_id">



                                @foreach($etlMills as $etlMill)
                                    <option {{($etlMill->id == $etlAreaRecord->etl_mill_id ? "selected" : "")}} value="{{$etlMill->id}}">{{$etlMill->name}}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group m-1">
                            <label for="etl_area_id">Area.</label>
                            <select class="form-control" name="etl_area_id">
                                @foreach($etlAreas as $etlArea)
                                    <option {{($etlArea->id == $etlAreaRecord->etl_area_id ? "selected" : "")}} value="{{$etlArea->id}}">{{$etlArea->name}}</option>
                                @endforeach

                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mt-5">Update</button>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('functionalScripts')



@endsection
