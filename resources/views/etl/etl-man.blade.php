@extends('layouts.app')

@section('pageTitle', 'ETL - Manual')
@section('pageName', 'ETL - Manual ')
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
    <div class="row">
        <div class="col-sm-12">
            <form method="get">
            <table id="macro-table" class="table table-striped">
                <thead>
                <th>Key</th>
                <th>Date Missing</th>
                <th>Mill</th>
                <th>Day</th>
                <th>Submit?</th>
                </thead>
                <tbody>
                @foreach($missingDatesMillArray as $key => $value)
                    <tr>

                        <td>{{$key}}</td>
                        <td>{{explode("_", $key)[0]}}</td>
                        <td>{{explode("_", $key)[1]}}</td>
                        <td>{{date('D', strtotime(explode("_", $key)[0]))}}</td>
                        <td><button class="etlManualSubmit" id="{{$key}}">Submit ETL</button></td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <th>Key</th>
                <th>Date Missing</th>
                <th>Mill</th>
                <th>Day</th>
                <th>Submit?</th>
                </tfoot>
            </table>
            <button type="submit">Submit All</button>
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
                function redirectToDashboard()
                {
                    window.location.href = rootUrl + "/etl/dashboard";
                }

                {{--var dataSubmittedAndSaved = <?php echo $dataSubmittedAndSaved; ?>;--}}

                // if (dataSubmittedAndSaved) {
                //     Swal.fire(
                //         'Data Saved',
                //         'Redirecting...',
                //         'success'
                //     )
                //     setTimeout(redirectToDashboard, 3000);
                // }


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
                    order: [[2, 'desc'], [1, 'desc']],
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

    <script>
    $('#exportDataLink').click(function(e) {
        console.log(window.dtFrom);
        window.location.href = rootUrl + "/api/exportMacroDataToCSV?dtFrom=" + window.dtFrom + "&dtTo=" + window.dtTo;
        $('.ajax-loader').css('display', 'none');
    });


    $('.etlManualSubmit').click(function(e) {
        e.preventDefault();
        console.log("ETL Manual Button Pressed.");

        var etlKeyId = $(this).attr('id').split('_');
      //  console.log(etlKeyId.split('_'));


        console.log(etlKeyId);


        $('#' + etlKeyId[0]+ "_" +etlKeyId[1]).closest('tr').remove()

        $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
        $.ajax({
            type: "POST",
            url: rootUrl + "/api/ManualETLInsert",
            data: {"etlKeyId": etlKeyId[1], "submitDate": etlKeyId[0], "XDEBUG_TRIGGER": 1},
          //  data: {"etlKeyId": etlKeyId[1], "submitDate": etlKeyId[0]},
            dataType: "json",
            success: function (data) {
                console.log(data.status);

                if (data.status)
                {
                    Swal.fire(
                        'Data Saved',
                        '',
                        'success'
                    )
                }

 },
            complete: function () {
                $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                $('#' + etlKeyId[0]+ "_" +etlKeyId[1]).closest('tr').remove();
            }
        });

    })
    </script>

@endsection
