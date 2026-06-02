@extends('layouts.app')

@section('pageTitle', 'Roles')
@section('pageName', 'All Roles')
@section('content')

<div class="row">
<div class="col-sm-12">
<a href="{{ route('roles.create')}}" class="btn btn-primary mb-2">Create New</a>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Name</td>
          <td>Description</td>
          <td colspan = 2>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $role)
        <tr>
            <td>{{$role->id}}</td>
            <td>{{$role->name}}</td>
            <td>{{$role->description}}</td>
            <td>
                <a href="{{ route('roles.edit',$role->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
             

              <form method="post" class="delete-form" action="{{ route('roles.destroy', $role->id)}}" >
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Delete</button>
              </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>
</div>
@endsection
@section('functionalScripts')
<script>

$('form.delete-form').one('submit', function(e) {
  e.preventDefault();

  Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
      $(this).submit();
  }
})

});


</script>
@endsection