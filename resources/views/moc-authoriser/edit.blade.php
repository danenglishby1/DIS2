@extends('layouts.app')

@section('pageTitle', 'Edit MoC Authoriser')
@section('pageName', 'Edit MoC Authoriser')
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
                <form method="post" action="{{ route('moc-authoriser.update', $mocAuthoriser->id) }}">
                    @method('PATCH')
                    @csrf

                <p style="font-size:16px">Use this page to assign all authorisation responsibility from one employee to another. <b>Use With Caution</b></p>
                    <div class="form-group m-1">
                        <label for="user_id">Authoriser</label>
                        <select class="form-control" required name="user_id">
                            @foreach($users as $user)
                                <option value="{{$user->id}}" {{($user->id == $mocAuthoriser->user->id ? "selected" : "")}}>{{$user->name}}</option>
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
