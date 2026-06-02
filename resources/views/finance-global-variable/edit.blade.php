@extends('layouts.app')

@section('pageTitle', 'Edit Finance Global Variable')
@section('pageName', 'Edit Finance Global Variable')
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
        <form method="post" action="{{ route('finance-global-variable.update', $financeGlobalVariable->id) }}">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="variable">Variable:</label>
                <input type="text" class="form-control" name="variable" value="{{$financeGlobalVariable->variable}}"/>
            </div>

            <div class="form-group">
                <label for="Variable">Value:</label>
                <input type="text" class="form-control" name="value" value="{{$financeGlobalVariable->value}}"/>
            </div>

            <input type="hidden" name="user_id" value="{{$userId}}">

            <button type="submit" class="btn btn-primary">Update Global Variable</button>
        </form>

  </div>
</div>
</div>
@endsection
