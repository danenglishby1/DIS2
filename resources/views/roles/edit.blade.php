@extends('layouts.app')

@section('pageTitle', 'Edit Role')
@section('pageName', 'Edit Role')
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
      <form method="post" action="{{ route('roles.update', $role->id) }}">
        @method('PATCH') 
          @csrf
          <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" class="form-control" name="name" value="{{$role->name}}"/>
          </div>

          <div class="form-group">
              <label for="description">Description:</label>
              <input type="text" class="form-control" name="description" value="{{$role->description}}"/>
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
      </form>

  </div>
</div>
</div>
@endsection
