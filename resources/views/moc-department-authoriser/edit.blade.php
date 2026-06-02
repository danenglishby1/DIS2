@extends('layouts.app')

@section('pageTitle', 'Edit Department Authorisers')
@section('pageName', 'Edit Department Authorisers')
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
                    </div><br/>
                @endif
                <form method="post"
                      action="{{ route('moc-department-authoriser.update', $mocDepartmentAuthoriser->id) }}">
                    @method('PATCH')
                    @csrf

                    <div class="form-group m-1">
                        <label for="moc_no">Authoriser.</label>
                        <select class="form-control" name="user_id">
                            @foreach($users as $user)
                                <option value="{{$user->id}}" {{($user->user_id == $mocDepartmentAuthoriser->MocAuthoriser->user_id ? "selected" : "")}}>{{$user->User->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group m-1">
                        <label for="dept_id">Department.</label>
                        <select class="form-control" name="department_id">
                            @foreach($departments as $dept)
                                <option value="{{$dept->id}}" {{($dept->id == $mocDepartmentAuthoriser->department_id ? "selected" : "")}}>{{$dept->department}}</option>
                            @endforeach

                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mt-5">Update</button>

                </form>

            </div>
        </div>
    </div>
@endsection
@section('functionalScripts')
    <script>
        const fileInput = document.getElementById("macroImage");
        window.addEventListener('paste', e => {
            fileInput.files = e.clipboardData.files;
        });

    </script>


@endsection
