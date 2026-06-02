@extends('layouts.app')

@section('pageTitle', 'Add Finance Global Variable')
@section('pageName', 'Add Finance Global Variable')
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
                <form method="post" action="{{ route('finance-global-variable.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Variable Name:</label>
                        <input type="text" class="form-control" name="variable" required/>
                    </div>
                    <div class="form-group">
                        <label for="value">Value:</label>
                        <input type="text" class="form-control" name="value" required/>
                    </div>

                    <input type="hidden" name="user_id" value="{{$userId}}">

                    <button type="submit" class="btn btn-primary">Add Variable</button>
                </form>
            </div>
        </div>
    </div>
@endsection
