@extends('layouts.app')

@section('pageTitle', 'RHS ChangeLog View')
@section('pageName', 'RHS ChangeLog View')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <style>
        label {
            font-size: 20px;
        }

    </style>
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

    <hr/>

    <div class="simpleflex">
        <div class="fl1">

            <table id="changelog-tbl" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>ENTRY_TIME</th>
                    <th>MM/YY</th>
                    <th>INITIALS</th>
                    <th>Username</th>
                    <th>SIZE</th>
                    <th>THICK</th>
                    <th>CONCERN</th>
                    <th>SECTION AREA</th>
                    <th>TOP / BOTTOM</th>
                    <th>STAND ADJUSTED</th>
                    <th>MILL AREA</th>
                    <th>IN / OUT</th>
                    <th>MM</th>
                    <th>SECTION OK?</th>
                    <th>COMMENTS</th>
                </tr>
                </thead>
                <tbody>


                <?php
                // Get $deliveryBracketMultiplierArray so we can lookup the process router and delivery bracket multiplier to build dela, delb and breach
                $deliveryBracketMultiplierArray = \App\H20Custom\ProcessRouteArray::GetDeliveryBracketMultiplierProcessRoute();
                ?>
                <!-- Note: $wipArray is 3 keys deep.-->
                @foreach($changeLogData as $key => $value)
                    <tr>
                        <td>{{$value["date_time"]}}</td>
                        <td>{{date('m/y', strtotime($value["date_time"])) }}</td>
                        <td>{{$value["initials"]}}</td>
                        <td>{{$value["logged_in_username"]}}</td>
                        <td>{{$value["size"]}}</td>
                        <td>{{$value["thickness"]}}</td>
                        <td>{{$value["concern"]}}</td>
                        <td>{{$value["section_area"]}}</td>
                        <td>{{$value["top_bottom"]}}</td>
                        <td>{{$value["stand_adjusted"]}}</td>
                        <td>{{$value["mill_area"]}}</td>
                        <td>{{$value["in_out"]}}</td>
                        <td>{{$value["millimeters"]}}</td>
                        <td>{{$value["section_ok"]}}</td>
                        <td>{{$value["comments"]}}</td>
                    </tr>
                @endforeach
                </tbody>

                <tfoot>
                <tr>
                    <th>ENTRY TIME</th>
                    <th>MM/YY</th>
                    <th>INITIALS</th>
                    <th>Username</th>
                    <th>SIZE</th>
                    <th>THICK</th>
                    <th>CONCERN</th>
                    <th>SECTION AREA</th>
                    <th>TOP / BOTTOM</th>
                    <th>STAND ADJUSTED</th>
                    <th>MILL AREA</th>
                    <th>IN / OUT</th>
                    <th>MM</th>
                    <th>SECTION OK?</th>
                    <th>COMMENTS</th>
                </tr>
                </tfoot>
                </tfoot>
            </table>
        </div>
    </div>



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
    <script src="{{ asset('public/js/FormValueObjectMap.js')}}"></script>
    <script src="{{ asset('public/libraries/sweetalert/swal.js')}}"></script>



    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /**
         * Datatable intialization and config.
         */

        var table = $('#changelog-tbl').DataTable({
            dom: 'Bfrtip',
            buttons: ['print', 'excel'],
            "order": [[ 0, "desc" ]],
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
