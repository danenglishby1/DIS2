@extends('layouts.app')

@section('pageTitle', 'Add Speed Standard')
@section('pageName', 'Add Speed Standard')
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
                <form method="post" action="{{ route('speed-standards.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Process Route:</label>
                        <input type="text" class="form-control" name="process_route" required/>
                    </div>
                    <div class="form-group">
                        <label for="value">Size1:</label>
                        <input type="text" class="form-control" name="size1" required/>
                    </div>
                    <div class="form-group">
                        <label for="value">Size2:</label>
                        <input type="text" class="form-control" name="size2" required/>
                    </div>
                    <div class="form-group">
                        <label for="value">Thickness:</label>
                        <input type="text" class="form-control" name="thickness" required/>
                    </div>
                    <div class="form-group">
                        <label for="value">Speed TPH:</label>
                        <input type="text" class="form-control" name="speed_tph" required/>
                    </div>

                    <input type="hidden" name="user_id" value="{{$userId}}">

                    <button type="submit" class="btn btn-primary">Add Speed Standard</button>
                </form>
            </div>
        </div>
    </div>
@endsection
