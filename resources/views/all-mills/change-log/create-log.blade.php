@extends('layouts.app')

@section('pageTitle', 'Add To Change Log')
@section('pageName', 'Add a new log')
@section('content')
    <div class="row" xmlns="http://www.w3.org/1999/html">
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
                <form method="post" action="{{ route('change-log.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="mill">Mill:</label>
                        <select class="form-control" name="mill">
                            <option value='20" Site Wide'>20" Site Wide</option>
                            <option  value='Weld'>Weld Mill</option>
                            <option  value='RHS'>RHS Mill</option>
                            <option  value='Cold'>Cold Mill</option>
                            <option value='Casing'>Casing Mill</option>
                            <option value='Energy'>Energy Mill</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="change_type">Change Type:</label>
                        <select class="form-control" name="change_type">
                            <option value='Machinery'>Machinery</option>
                            <option  value='Weld Parameters'>Weld Parameters</option>
                            <option  value='Tandem'>Tandem</option>
                            <option  value='Stoppage'>Stoppage</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="comment">Comments:</label>
                        <textarea class="form-control" name="comment" placeholder="General comments about the change"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Log</button>
                </form>
            </div>
        </div>
    </div>
@endsection
