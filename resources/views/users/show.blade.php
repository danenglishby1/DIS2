@extends('layouts.app')

@section('pageTitle', 'User Details')
@section('pageName', 'User Details')
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
               
          <dl class="row">
                <dt class="col-sm-3">User Name</dt>
                <dd class="col-sm-9">{{ $user->name }}</dd>
              
                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $user->email }}</dd>
                
                <dt class="col-sm-3">Roles</dt>
                <dd class="col-sm-9">{{ $user->roles[0]->name }}</dd>

                <a href="{{ route('users.edit',$user->id)}}" class="btn btn-primary ml-3">Edit</a>
                {{-- <dt class="col-sm-3">Nesting</dt>
                <dd class="col-sm-9">
                  <dl class="row">
                    <dt class="col-sm-4">Nested definition list</dt>
                    <dd class="col-sm-8">Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc.</dd>
                  </dl>
                </dd> --}}
              </dl>
  </div>
</div>
</div>
@endsection
