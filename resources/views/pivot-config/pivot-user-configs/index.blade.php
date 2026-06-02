@extends('layouts.app-pivots')

@section('pageTitle', 'My Pivot Configurations')
@section('pageName', 'My Pivot Configurations')
@section('content')

    <div class="row">
        <div class="col-sm-12">
            {{--<a href="{{ route('pivot-configs.create')}}" class="btn btn-primary mb-2">Create New</a>--}}
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Pivot Report Name</td>
                    <td>Pivot Page</td>
                    <td>Pivot Report Description</td>
                    <td>Created</td>


                    <td colspan=3>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($records as $r)
                    <tr>
                        <td>{{$r->CONFIG_REPORT_NAME}}</td>
                        <td>{{$r->CONFIG_PAGE}}</td>
                        <td>{{$r->CONFIG_REPORT_DESCRIPTION}}</td>
                        <td>{{$r->CREATED_AT}}</td>
                        <td>
                            <a href="{{ route('pivot-user-configs.edit',$r->ID)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form method="post" class="delete-form"
                                  action="{{ route('pivot-user-configs.destroy', $r->ID)}}">
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
    </div>
@endsection
@section('functionalScripts')
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
