@extends('layouts.app')

@section('pageTitle', 'Add ETL Mill Area')
@section('pageName', 'Add ETL Mill Area')
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
                <form method="post" action="{{ route('etl_mill_area.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="">

                        <div class="form-group m-1">
                            <label for="etl_mill_id">Mill.</label>
                            <select class="form-control" name="etl_mill_id">
                                @foreach($etlMills as $mill)
                                    <option value="{{$mill->id}}">{{$mill->name}}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group m-1">
                            <label for="etl_area_id">Area.</label>
                            <select class="form-control" name="etl_area_id">
                                @foreach($etlAreas as $area)
                                    <option value="{{$area->id}}">{{$area->name}}</option>
                                @endforeach

                            </select>
                        </div>



                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('functionalScripts')



@endsection
