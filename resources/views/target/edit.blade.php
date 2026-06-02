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
      <form method="post" action="{{ route('target.update', $target->id) }}">
          @method('PATCH') 
          @csrf
          <div class="form-group">
              <label for="description">Target Description:</label>
              <input type="text" class="form-control" name="description" value="{{$target->target_description}}" disabled="true"/>
          </div>

          <div class="form-group">
              <label for="comments">Comments:</label>
              <input type="text" class="form-control" name="comments" value="{{$target->comments}}"/>
          </div>
          <div class="form-group">



              <label for="number_or_percent">Num or %:</label>

              <select name="number_or_percent">
                  <option value="N"  <?php echo ($target->number_or_percent == "N" ? "selected" : "")?> >Number</option>
                  <option value="P"  <?php echo ($target->number_or_percent == "P" ? "selected" : "")   ?>>Percent</option>
              </select>
          </div>
          <div class="form-group">
              <label for="target">Target Value:</label>
              <input type="number" class="form-control" name="target" step="any" value="{{$target->target}}"/>
          </div>
          <input type="hidden" value="{{$target->id}}">
          <button type="submit" class="btn btn-primary">Update Target</button>
      </form>
  </div>
</div>
</div>
@endsection
