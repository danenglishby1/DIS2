@extends('layouts.app')

@section('pageTitle', 'Add ETL Area')
@section('pageName', 'Add ETL Area')
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
                <form method="post" action="{{ route('etl_asset.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="">

                        <div class="form-group m-1">
                            <label for="name">Asset Name</label>
                            <input type="text" class="form-control" name="name"/>
                        </div>



                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('functionalScripts')



@endsection
