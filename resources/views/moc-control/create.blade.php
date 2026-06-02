@extends('layouts.app')

@section('pageTitle', 'Add MoC Department')
@section('pageName', 'Add MoC Department')

@section('css')

@endsection
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
                <form method="post" id="mocForm" action="{{ route('moc-control.store') }}">
                    @csrf

                    <div class="form-group m-1">
                        <label for="control">Control</label>
                        <input type="text" class="form-control" required name="control">

                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Add Control</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('functionalScripts')

@endsection
