@extends('layouts.app')

@section('pageTitle', 'Hook & Camber Coil Data')
@section('pageName', 'Hook & Camber Coil Data')
@section('millTrackingActiveLink', 'active activeUnderline')
@section('css')
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
@endsection
@section('content')
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
    <table id="coil-tbl" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <th>H20 Coil No</th>
        <th>Supplier Coil No</th>
        <th>Width</th>
        <th>Thickness</th>
        <th>Quality</th>
        <th>View ></th>
        </thead>
        <tbody>

        @foreach($coilData as $coil)

            <tr>
                <td>{{$coil["COIL_COIL_NO"]}}</td>
                <td>{{$coil["SUPPLIER_COIL"]}}</td>
                <td>{{$coil["COIL_COIL_WIDTH"]}}</td>
                <td>{{$coil["COIL_COIL_THICK"]}}</td>
                <td>{{$coil["COIL_COIL_QUALITY"]}}</td>
                <td><a target="_blank" href="http://1.66.83.27/hartfieldi/Hartlepool/capability.php?width_matrix={{substr($coil["SUPPLIER_COIL"],2,8) }}">View ></a></td>
            </tr>

        @endforeach

        </tbody>
        <tfoot>
        <th>H20 Coil No</th>
        <th>Supplier Coil No</th>
        <th>View ></th>
        </tfoot>
    </table>





@endsection
@section('functionalScripts')
    <script src="{{ asset('public/js/jquery-3.3.1.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    <!-- Extension scripts for datatables print functionality -->
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>
    <!-- End  Extension scripts for datatables print functionality -->
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script>
        /**
         * Datatable intialization and config.
         */
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#coil-tbl').DataTable({
                dom: 'Bfrtip',
                buttons: ['print', 'excel'],
                pageLength : 100,
                order: [[ 2, "asc" ]],
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
        });
    </script>

@endsection
