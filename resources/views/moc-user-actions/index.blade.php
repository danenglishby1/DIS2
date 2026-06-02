@extends('layouts.app')

@section('pageTitle', 'Your MoC Actions')
@section('pageName', 'Your MoC Actions')
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
            <table id="moc-actions-table" class="table table-striped">
                <thead>
                <th>MoC No</th>
                <th>MoC Detail</th>
                <th>Action</th>
                <th>Complete By Date</th>
                <th>Complete?</th>
                <th>Edit Action</th>
                </thead>
                <tbody>
                @foreach($mocActions as $action)
                    <tr>
                        <td>{{$action->moc->id}}</td>
                        @if($action->moc->status_impact == "Significant")
                            <td><a href="{{ route('show-significant')}}?id={{$action->moc->id}}">View</a></td>
                        @else
                            <td><a href="{{ route('moc.show',$action->moc->id)}}">View</a></td>
                        @endif
                        <td>{{$action->action}}</td>
                        <td>{{$action->complete_by_date}}</td>
                        <td>{{$action->complete_status}}</td>
                        <td>
                            <div style="display: flex;">
                                <a href="{{ route('moc-user-action.edit',$action->id)}}" class="btn btn-warning m-1">Edit</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <th>MoC No</th>
                <th>MoC Detail</th>
                <th>Action</th>
                <th>Complete By Date</th>
                <th>Complete?</th>
                <th>Edit Action</th>
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
