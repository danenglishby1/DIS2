@extends('layouts.app')

@section('pageTitle', 'Edit Speed Standard')
@section('pageName', 'Edit Speed Standard')
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
        <form method="post" action="{{ route('speed-standards.update', $speedStandard->id) }}">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="variable">Process Route:</label>
                <input type="text" class="form-control" name="process_route" value="{{$speedStandard->process_route}}"/>
            </div>
            <div class="form-group">
                <label for="variable">Size1:</label>
                <input type="text" class="form-control" name="size1" value="{{$speedStandard->size1}}"/>
            </div>
            <div class="form-group">
                <label for="variable">Size2:</label>
                <input type="text" class="form-control" name="size2" value="{{$speedStandard->size2}}"/>
            </div>
            <div class="form-group">
                <label for="variable">Thickness:</label>
                <input type="text" class="form-control" name="thickness" value="{{$speedStandard->thickness}}"/>
            </div>
            <div class="form-group">
                <label for="variable">Speed TPH:</label>
                <input type="text" class="form-control" name="speed_tph" value="{{$speedStandard->speed_tph}}"/>
            </div>


            <input type="hidden" name="user_id" value="{{$userId}}">

            <button type="submit" class="btn btn-primary">Update Speed Standard</button>
        </form>

  </div>
</div>
</div>
@endsection
