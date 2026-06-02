@extends('layouts.app')

@section('pageTitle', 'Edit Global Setting')
@section('pageName', 'Edit Global Setting')
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
        <form method="post" action="{{ route('global-settings.update', $gSetting->id) }}">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="machine_name">Value:</label>
                <input type="text" class="form-control" name="value" value="{{$gSetting->value}}"/>
            </div>

            <input type="hidden" name="user_id" value="{{$userId}}">
            <button type="submit" class="btn btn-primary">Update Setting</button>
        </form>

  </div>
</div>
</div>
@endsection
