@extends('layouts.app')

@section('pageTitle', 'Add Target')
@section('pageName', 'Add New Target')
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
                    </div><br />
                @endif
                <form method="post" action="{{ route('target.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="description">Target Description:</label>
                        <input type="text" class="form-control" name="description"/>
                    </div>

                    <div class="form-group">
                        <label for="comments">Comments:</label>
                        <input type="text" class="form-control" name="comments"/>
                    </div>
                    <div class="form-group">
                        <label for="number_or_percent">Num or %:</label>
                        <select name="number_or_percent">
                            <option value="N">Number</option>
                            <option value="P">Percent</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="target">Target Value:</label>
                        <input type="number" class="form-control" name="target" step="any"/>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Target</button>
                </form>
            </div>
        </div>
    </div>
@endsection
