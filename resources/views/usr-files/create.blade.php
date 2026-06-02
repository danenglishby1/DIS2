@extends('layouts.app')

@section('pageTitle', 'Add USR Images')
@section('pageName', 'Add USR Images')

@section('css')
    <style>
        .footer {
            position:relative !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/dropzone/dropzone.min.css?v=1.1.2')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/select2/select2.min.css')}}"/>
@endsection
@section('content')

    @if(count($usrFiles) > 0)

        <h4 style="margin: 1em 0;">Attached Files</h4>
        <table class="table">
            <thead>
            <th>File</th>
            <th>Actions</th>
            </thead>
            <tbody>
            @foreach($usrFiles as $usrFile)
                <tr>
                    <td><a target="_blank" href="{{asset('public/storage/usr-files/') ."/".$usrFile->file_path}}">{{$usrFile->original_file_name}}</a></td>
                    <td><form method="post" class="delete-form"
                              action="{{ route('usr-files.destroy', $usrFile->id)}}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger m-1" type="submit">Delete</button>
                        </form></td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif


    <h4 style="margin: 1em 0;">Upload New Files</h4>

    <form action="{{route('usr-files.store')}}"
          class="dropzone"
          id="dropzone">

        @csrf
        <div class="dz-message" style="font-size: 25px;font-weight: bold; color: grey;">»Drop files to upload (or click)«</div>
        <input type="hidden" name="usrId" value="{{$usrId}}">

    </form>



@endsection

@section('functionalScripts')

    <script src="{{ asset('public/libraries/select2/select2.min.js')}}"></script>
    <script src="{{ asset('public/libraries/dropzone/dropzone.min.js')}}"></script>
    <script>
        $('form.delete-form').one('submit', function (e) {
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
