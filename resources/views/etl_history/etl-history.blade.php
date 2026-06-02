@extends('layouts.app')

@section('pageTitle', 'ETL RHS')
@section('pageName', 'ETL RHS')
{{--@section('weldMillActiveLink', 'active activeUnderline')--}}
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
    <div class="simpleflex justify-content-center">

    </div>
    <div class="row">
        <div class="col-sm-12">
{{--            <a href="{{ route('etl_mill_area_asset.create')}}" class="btn btn-primary mb-2">Create New</a>--}}
            <form method="get">
            <table id="macro-table" class="table table-striped">
                <thead>
                <th>Mill</th>
                <th>Area</th>
                <th>Asset</th>
                <th>KW</th>
                <th>KW_PS</th>
                <th>Turned Off?</th>
                </thead>
                <tbody>
{{--                {{dd($etlHistorySubmission)}}--}}
                @foreach($etlHistorySubmission as $hist)
                    <tr>

                        <td>{{$hist->mill}}</td>
{{--                        <td>{{$hist->millArea->area->name}}</td>--}}
{{--                        <td>{{$hist->asset->name}}</td>--}}
{{--                        <td>{{$hist->KW}}</td>--}}
{{--                        <td>{{$hist->KW_PS}}</td>--}}
{{--                        <td>--}}
{{--                            <div style="display: flex;">--}}
{{--                                <select name="switchedOff[]">--}}
{{--                                    <option value="Y">Y</option>--}}
{{--                                    <option value="N">N</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <input type="hidden" name="etlMillAreaAssetId[]" value="{{$hist->id}}">--}}
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <th>Mill</th>
                <th>Area</th>
                <th>Asset</th>
                <th>KW</th>
                <th>KW_PS</th>
                <th>Turned Off?</th>
                </tfoot>
            </table>
            <button type="submit">Submit</button>
            </form>
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

                var table = $('#macro-table').DataTable({
                    dom: 'Bfrtip',
                    pageLength : 99,
                    // buttons: ['print', 'excel'],


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
