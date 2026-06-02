@extends('layouts.app')

@section('pageTitle', 'Change Log')
@section('pageName', 'Change Log')

@section('css')
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
    <a href="{{ route('change-log.create')}}" class="btn btn-primary mb-2 -pull-right">Add Log</a>



    <table id="change-log-tbl" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>Mill</th>
            <th>Change</th>
            <th>Comments</th>
            <th>By</th>
            <th>TimeStamp</th>

        </tr>
        </thead>
        <tbody>
        @foreach($logs as $log)

            <tr>
                <td>{{$log["MILL"]}}</td>
                <td>{{$log["CHANGE_TYPE"]}}</td>
                <td>{{$log["COMMENTS"]}}</td>
                <td>{{$log["NAME"]}}</td>
                <td>{{$log["TIME_STAMP"]}}</td>
            </tr>


        @endforeach
        </tfoot>
    </table>








    <!-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div> -->
<!-- Content Row -->






@endsection
@section('functionalScripts')
<script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>


<script>
$(document).ready(function() {
$('#change-log-tbl').DataTable();
});
</script>
@endsection