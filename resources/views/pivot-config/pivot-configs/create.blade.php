@extends('layouts.app')

@section('pageTitle', 'Add Pivot Config')
@section('pageName', 'Add Pivot Config')
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
      <form method="post" action="{{ route('pivot-configs.store') }}">
          @csrf
          <div class="form-group">
              <label for="config_report_name">Name:</label>
              <input type="text" class="form-control" name="config_report_name"/>
          </div>

          <button type="submit" class="btn btn-primary">Add Config</button>
      </form>
  </div>
</div>
</div>
@endsection
