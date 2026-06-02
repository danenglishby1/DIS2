@extends('layouts.app')

@section('pageTitle', 'Edit MoC Department')
@section('pageName', 'Edit MoC Department')
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
                <form method="post" action="{{ route('moc-department.update', $mocDepartment->id) }}">
                    @method('PATCH')
                    @csrf


                    <div class="form-group m-1">
                        <label for="quality">Department</label>
                        <input type="text" class="form-control" name="department"
                               value="{{$mocDepartment->department}}"/>
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
