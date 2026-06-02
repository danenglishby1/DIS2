@extends('layouts.app')

@section('pageTitle', 'Finance Global Variable Detail')
@section('pageName', 'Finance Global Variable Detail')
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
  </div>
</div>
</div>
@endsection
