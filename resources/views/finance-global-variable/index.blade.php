@extends('layouts.app')

@section('pageTitle', 'Finance Global Variables')
@section('pageName', 'Finance Global Variables')
@section('content')

        <div class="row">
            <div class="col-sm-12">
                <a href="{{ route('finance-global-variable.create')}}" class="btn btn-primary mb-2">Create New</a>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>Variable</td>
                        <td>Value</td>
                        <td>Updated By</td>
                        <td>Updated At</td>
                        <td colspan=2>Actions</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($financeGlobalVariables as $row)
                        <tr>
                            <td>{{$row["variable"]}}</td>
                            <td>{{$row["value"]}}</td>
                            <td>{{$row["user"]["name"]}}</td>
                            <td>{{$row["updated_at"]}}</td>
                            <td>
                                <a href="{{ route('finance-global-variable.edit',$row["id"])}}" class="btn btn-primary">Edit</a>
                            </td>
                            <td>
                                <form method="post" class="delete-form"
                                      action="{{ route('finance-global-variable.destroy', $row["id"])}}">
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
