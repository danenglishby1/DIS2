@extends('layouts.app')

@section('pageTitle', 'Coil Despatched Not Received')
@section('pageName', 'Coil Despatched Not Received')
@section('millTrackingActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
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
    <div style="width:100%;text-align: center; font-size:16px; font-weight: bold">
        Total Wagons: {{$totalWagons}}
        <br />
        Total Tonnes: {{$totalTonnes}}
    </div>
    <!-- Content Row -->
    <div class="simpleflex">



        <table id="dsp-not-received" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>DSP NOTE</th>
                <th>DSP DATE</th>
                <th>ADV WEIGHT</th>
                <th>CAST NO</th>
                <th>COIL NO</th>
                <th>WIDTH</th>
                <th>THICK</th>
                <th>QUALITY</th>
                <th>WAGON</th>
                <th>PT DSNO</th>
                <th>PT COIL</th>
                <th>DEL WK</th>
                <th>PLANNED ROLL WK</th>
                <th>COIL SUSP CODE</th>
                <th>CAST SUSPECT CODE</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($dspNotReceivedArray as $row)
                <tr>
                    <td>{{$row["CRPT_DSP_NOTE"]}}</td>
                    <td>{{$row["CRPT_DSP_DATE"]}}</td>
                    <td>{{$row["CRPT_ADV_WEIGHT"]}}</td>
                    <td>{{$row["CRPT_CAST_NO"]}}</td>
                    <td>{{$row["CRPT_COIL_NO"]}}</td>

                    <td>{{$row["CORD_COIL_WIDTH"]}}</td>
                    <td>{{$row["CORD_COIL_THICK"]}}</td>
                    <td>{{$row["CORD_COIL_QUALITY"]}}</td>
                    <td>{{$row["SUPPLIER_WAGON"]}}</td>
                    <td>{{$row["SUPPLIER_DSNO"]}}</td>
                    <td>{{$row["SUPPLIER_COIL"]}}</td>
                    <td>{{$row["CORD_DELY_WEEKNO"]}}</td>
                    <td>{{$row["PLANNED_ROLL_WEEK"]}}</td>
                    <td>{{$row["CONCESSION_CODE"]}}</td>
                    <td>{{$row["CRPT_CAST_SUSPECT_CODE"]}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>DSP NOTE</th>
                <th>DSP DATE</th>
                <th>ADV WEIGHT</th>
                <th>CAST NO</th>
                <th>COIL NO</th>

                <th>WIDTH</th>
                <th>THICK</th>
                <th>QUALITY</th>
                <th>WAGON</th>
                <th>PT DSNO</th>
                <th>PT COIL</th>
                <th>DEL WK</th>
                <th>PLANNED ROLL WK</th>
                <th>COIL SUSP CODE</th>
                <th>CAST SUSPECT CODE</th>
            </tr>
            </tfoot>
        </table>
    </div>

@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>

    <script src="{{ asset('public/js/jquery-3.3.1.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    <!-- Extension scripts for datatables print functionality -->
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>

    <script>
        //Listen for changes on the select drop down list...
        // Get position and append as get PARAM onto current URL then redirect to it.
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("select#throughputRPosSelect").change(function () {
                let rPos = this.value;
                console.log(rPos);
                let url = rootUrl + "/mngr-tracking/throughput?rPos=" + rPos;
                window.location.href = url;
            });


            $('#defaultDateOverride').change(function (e) {
                let checked = $(this).is(":checked");

                if (checked) {
                    $('#optionalDateFilters').css('display', 'block');
                } else {
                    $('#optionalDateFilters').css('display', 'none');
                }
            });

            $('#dateFilterSubmitButton').click(function (e) {
                var dtFrom = $('#dtFrom').val();
                var dtTo = $('#dtTo').val();
                if (dtFrom != "" && dtTo != "") {
                    let rPos = $('select#throughputRPosSelect').val();
                    console.log(rPos);
                    let url = rootUrl + "/mngr-tracking/throughput?rPos=" + rPos + "&dtFrom=" + dtFrom + "&dtTo=" + dtTo;
                    window.location.href = url;
                }


            });

        });


    </script>
    <script>

        /**
         * Datatable intialization and config.
         */
        $(document).ready(function () {
            let table = $('#dsp-not-received').DataTable({
                dom: 'Bfrtip',
                buttons: ['print', 'excel'],
                "order": [[0, 'desc']],
                initComplete: function () {
                    this.api().columns().every(function () {
                        let column = this;
                        let select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                let val = $.fn.dataTable.util.escapeRegex(
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
                    let select = $(table.column(idx).footer()).find('select');

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

