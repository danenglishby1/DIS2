@extends('layouts.app')

@section('pageTitle', 'Add User')
@section('pageName', 'Add a User')
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
      <form method="post" action="{{ route('users.store') }}">
          @csrf
          <div class="form-group">
              <label for="first_name">Name:</label>
              <input type="text" class="form-control" name="name"/>
          </div>

          <div class="form-group">
              <label for="email">Email:</label>
              <input type="text" class="form-control" name="email"/>
          </div>
          <div class="form-group">
              <label for="job_title">Password:</label>
              <input type="text" class="form-control" name="password" />
          </div>
          <button type="submit" class="btn btn-primary">Add User</button>
      </form>
  </div>
</div>
</div>
@endsection
