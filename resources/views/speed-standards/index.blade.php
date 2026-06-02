@extends('layouts.app')

@section('pageTitle', 'Speed Standards')
@section('pageName', 'Speed Standards')
@section('css')
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('speed-standards.create')}}" class="btn btn-primary mb-2">Create New</a>
            <table id="speedStandardsTable" class="table table-striped">
                <thead>
                <th>PR</th>
                <th>SIZE 1</th>
                <th>SIZE 2</th>
                <th>THICKNESS</th>
                <th>SPEED TPH</th>
                <th>UPDATED BY</th>
                <th>Updated At</th>
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($speedStandards as $row)
                    <tr>
                        <td>{{$row["process_route"]}}</td>
                        <td>{{$row["size1"]}}</td>
                        <td>{{$row["size2"]}}</td>
                        <td>{{$row["thickness"]}}</td>
                        <td>{{$row["speed_tph"]}}</td>
                        <td>{{$row["user"]["name"]}}</td>
                        <td>{{$row["updated_at"]}}</td>
                        <td>
                            <div style="display: flex;">
                            <a href="{{ route('speed-standards.edit',$row["id"])}}" class="btn btn-primary">Edit</a>

                            <form method="post" class="delete-form"
                                  action="{{ route('speed-standards.destroy', $row["id"])}}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <th>PR</th>
                <th>SIZE 1</th>
                <th>SIZE 2</th>
                <th>THICKNESS</th>
                <th>SPEED TPH</th>
                <th>UPDATED BY</th>
                <th>Updated At</th>
                <th>Actions</th>
                </tfoot>
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

    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    {{--            <!-- Extension scripts for datatables print functionality -->--}}
    {{--            <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>--}}
    {{--            <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>--}}
    {{--            <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>--}}
    {{--            <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>--}}

    <script>
        /**
         * Add ajax header for CSRF Token
         * */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /**
         * Datatable intialization and config.
         */

        var table = $('#speedStandardsTable').DataTable({
            dom: 'Bfrtip',
            // buttons: ['print', 'excel'],
            "order": [6, "desc"],

            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            }
        });

        table.on('draw', function () {
            table.columns().indexes().each(function (idx) {
                var select = $(table.column(idx).footer()).find('select');

                if (select.val() === '') {
                    select
                        .empty()
                        .append('<option value=""/>');

                    table.column(idx, {search: 'applied'}).data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>');
                    });
                }
            });
        });

    </script>

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
