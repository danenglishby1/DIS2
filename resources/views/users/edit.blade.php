@extends('layouts.app')

@section('pageTitle', 'Edit User')
@section('pageName', 'Edit User')
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
      <form method="post" action="{{ route('users.update', $user->id) }}">
          @method('PATCH') 
          @csrf
          <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" class="form-control" name="name" value="{{$user->name}}"/>
          </div>

          <div class="form-group">
              <label for="email">Email:</label>
              <input type="text" class="form-control" name="email" value="{{$user->email}}"/>
          </div>
          <div class="form-group">
              <label for="job_title">Password:</label>
              <input type="text" class="form-control" name="password" value="{{$user->password}}" />
          </div>
          <input type="hidden" value="{{$user->id}}">
          <button type="submit" class="btn btn-primary">Update User</button>
      </form>
      <button class="btn btn-danger mt-3">Reset Password</button>
  </div>
</div>
</div>
@endsection
