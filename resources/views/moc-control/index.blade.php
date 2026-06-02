@extends('layouts.app')

@section('pageTitle', 'MoC Controls')
@section('pageName', 'MoC Controls')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <style>
        select {
            max-width: 500px !important;
        }
    </style>
@endsection
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('moc-control.create')}}" class="btn btn-primary mb-2">Create New</a>

            <table id="macro-table" class="table table-striped">
                <thead>
                <th>Control</th>
                <th>Date</th>
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($mocControls as $control)
                    <tr>
                        <td>{{$control->control}}</td>
                        <td>{{$control->created_at}}</td>
                        <td>
                            <div style="display: flex;">
                                <a href="{{ route('moc-control.edit',$control->id)}}" class="btn btn-warning m-1">Edit</a>
                                <form method="post" class="delete-form"
                                      action="{{ route('moc-control.destroy', $control->id)}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-1" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <th>Dept</th>
                <th>Date</th>
                <th>Actions</th>
                </tfoot>
            </table>
            <div>
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

            <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
            <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
            <script>
                /**
                 * Add ajax header for CSRF Token
                 * */
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


            </script>
@endsection
