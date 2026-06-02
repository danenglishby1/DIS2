@extends('layouts.app')

@section('pageTitle', 'Users')
@section('pageName', 'All Users')
@section('content')

<div class="row">
<div class="col-sm-12">
<a href="{{ route('users.create')}}" class="btn btn-primary mb-2">Create New</a>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Name</td>
          <td>Email</td>
          <td colspan = 3>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>
                <a href="{{ route('users.edit',$user->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <form action="{{ route('users.show', $user->id)}}" method="get">
                  @csrf
                  
                  <button class="btn btn-primary" type="submit">View</button>
                </form>
            </td>
            <td>
                <form method="post" class="delete-form" action="{{ route('users.destroy', $user->id)}}" >
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