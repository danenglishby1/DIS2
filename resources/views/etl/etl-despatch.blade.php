@extends('layouts.app')

@section('pageTitle', 'ETL Despatch')
@section('pageName', 'ETL Despatch')
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
        <button class="btn btn-primary" id="turnedOffAllN">Turned Off = N (ALL)</button>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('etl_mill_area_asset.create')}}" class="btn btn-primary mb-2">Create New</a>
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
                @foreach($etlMillAreaAssets as $etlArea)
                    <tr>

                        <td>{{$etlArea->millArea->mill->name}}</td>
                        <td>{{$etlArea->millArea->area->name}}</td>
                        <td>{{$etlArea->asset->name}}</td>
                        <td>{{$etlArea->KW}}</td>
                        <td>{{$etlArea->KW_PS}}</td>
                        <td>
                            <div style="display: flex;">
                                <select class="switchedOffSelector"  name="switchedOff[]">
                                    <option value="Y">Y</option>
                                    <option value="N">N</option>
                                </select>
                            </div>
                        </td>
                        <input type="hidden" name="etlMillAreaAssetId[]" value="{{$etlArea->id}}">
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
                function redirectToDashboard()
                {
                    window.location.href = rootUrl + "/etl/dashboard";
                }

                var dataSubmittedAndSaved = <?php echo $dataSubmittedAndSaved; ?>;

                if (dataSubmittedAndSaved) {
                    Swal.fire(
                        'Data Saved',
                        'Redirecting...',
                        'success'
                    )
                    setTimeout(redirectToDashboard, 3000);
                }


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

<script>

            function BuildNewRows(data) {
            var crsfToken = "{{@csrf_token()}}";
            var tablesRows = "";
            for (const [key, value] of Object.entries(data)) {
            // console.log(key, value);
            tablesRows += "<tr>" +

                "<td>" + (data[key].WEEK_YEAR !== null ? data[key].WEEK_YEAR.padStart(2, "0") : "") + (data[key].COIL !== null ? data[key].COIL.toString().padStart(3, "0") : "") + (data[key].PIPE !== null ? data[key].PIPE.toString().padStart(2, "0") : "") + "</td>" +
                "<td>" + data[key].DIAM_RANGE + "</td>" +
                "<td>" + data[key].THK + "</td>" +
                "<td>" + data[key].QUALITY + "</td>" +
                "<td>" + (data[key].COMMENT == null ? "" : data[key].COMMENT) + "</td>" +
                "<td>" + data[key].CREATED_AT + "</td>" +
                "<td>" + (data[key].IMAGE !== "" ? "<a target='_blank' href='" +rootUrl + "/public/storage/macros/"+ data[key].IMAGE + "'><img style='width:100px; height: 50px;' src='" +rootUrl + "/public/storage/macros/"+ data[key].IMAGE + "'/></a>" : "") + "</td>"+
                "<td>" +
                "  <div style='display: flex;'>" +
                "  <a href='"+rootUrl+"/etl_mill_area/"+data[key].id+"' class='btn btn-primary m-1'>View</a>" +
                "  <a href='"+rootUrl+"/etl_mill_area/"+data[key].id+"/edit' class='btn btn-warning m-1'>Edit</a>" +
                "<form method='post' class='delete-form' action='"+rootUrl+"/etl_mill_area/"+data[key].id+"'>" +
                "  <input type='hidden' name='_token' value='"+crsfToken+"'> " +
                "<input type='hidden' name='_method' value='DELETE'> " +
                "<button class='btn btn-danger m-1' type='submit'>Delete</button>" +
                "                                </form>" +
                "                            </div>" +
                "</td>"+
                "</tr>";

            }

            return tablesRows;
            }
</script>



    <script>
    $('#exportDataLink').click(function(e) {
        console.log(window.dtFrom);
        window.location.href = rootUrl + "/api/exportMacroDataToCSV?dtFrom=" + window.dtFrom + "&dtTo=" + window.dtTo;
        $('.ajax-loader').css('display', 'none');
    });

    $('#turnedOffAllN').click(function(e) {
        console.log("turning all selects to N");
        $('.switchedOffSelector').val("N");
    })
    </script>

@endsection
