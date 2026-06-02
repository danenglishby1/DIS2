@extends('layouts.app')

@section('pageTitle', 'Edit Pivot Config')
@section('pageName', 'Edit Pivot Config')
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
      <form method="post" action="{{ route('pivot-user-configs.update', $record[0]->ID) }}">
          @method('PATCH')
          @csrf
          <div class="form-group">
              <label for="name">Pivot Report Name:</label>
              <input type="text" class="form-control" name="name" value="{{$record[0]->CONFIG_REPORT_NAME}}"/>
          </div>

          <div class="form-group">
              <label for="description">Pivot Report Description:</label>
              <input type="text" class="form-control" name="description" value="{{$record[0]->CONFIG_REPORT_DESCRIPTION}}"/>
          </div>

          <button type="submit" class="btn btn-primary">Update Pivot Config</button>
      </form>

  </div>
</div>
</div>
@endsection
