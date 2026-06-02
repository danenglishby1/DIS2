@extends('layouts.app')

@section('pageTitle', 'Shipping')
@section('pageName', 'Shipping')

@section('content')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>

@endsection
@section('overrideStartEndDate')
    start = moment().subtract(1, 'day').startOf('day');
    end = moment().endOf('day');

    var urlParams = new URLSearchParams(window.location.search);
    var dtFrom = urlParams.get('dtFrom');
    var dtTo = urlParams.get('dtTo');

    if (dtFrom !== null) {
    start = moment(dtFrom);
    end = moment(dtTo);
    }
@endsection
@section('dateRangePickerOnApplyCallback')


    window.dtFrom = dtFrom;
    window.dtTo = dtTo;

    window.location.href = rootUrl + "/despatch/wfshipping?dtFrom="+dtFrom+"&dtTo="+dtTo;

@endsection

<div style="text-align: center;
    margin-top: -50px;">
    <h2>Shipping</h2>
</div>


<div class="filters" style="justify-content: normal;">
    @include('layouts.templates.daterangepicker')
</div>
<div class="mb-3"></div>


    <div class="simpleflex">
        <table id="shipping-table" class="table table-striped">
            <thead>

            <th>LOADREF</th>
            <th>LOADREFDATE</th>
            <th>CUSTNAME</th>
            <th>MKTDEST</th>
            <th>MKTNAME</th>
            <th>SITE</th>
            <th>DESPWKS</th>
            <th>ADVTN</th>
            <th>ADVMET</th>
            <th>REQUESTDATE</th>
            <th>REQUESTTIME</th>
            <th>COLLECTDATE</th>
            <th>COLLECTTIME</th>
            <th>QUAYDATE</th>
            <th>QUAYTIME</th>
            <th>LOADDATE</th>
            <th>LOADTIME</th>
            <th>DEPARTDATE</th>
            <th>DEPARTTIME</th>
            <th>ENROUTEDATE</th>
            <th>ENROUTETIME</th>
            <th>DELIVDATE</th>
            <th>DELIVTIME</th>
            <th>ADVNO</th>
            <th>CHARTFLAG</th>
            <th>CONSIGNREF</th>
            <th>SPARE1DATE</th>
            <th>SPARE1TIME</th>
            <th>SPARE2DATE</th>
            <th>SPARE2TIME</th>
            <th>AMENDDATE</th>
            <th>AMENDTIME</th>
            <th>CANCELDATE</th>
            <th>CANCELTIME</th>
            <th>REQUESTYR</th>
            <th>SALESYR</th>
            <th>SALESPRE</th>
            <th>SALESNO</th>
            <th>ITEMNO</th>
            <th>REFER_LAST_TRANS</th>
            <th>TIMST_LAST_ACTIV</th>
            <th>CARRIER</th>
            <th>SAPORDER</th>
            <th>WKSORDER</th>
            </thead>
            <tbody>
            @foreach($data as $row)
                <tr>
                    <td>{{$row["LOADREF"]}}</td>
                    <td>{{$row["LOADREFDATE"]}}</td>
                    <td>{{$row["CUSTNAME"]}}</td>
                    <td>{{$row["MKTDEST"]}}</td>
                    <td>{{$row["MKTNAME"]}}</td>
                    <td>{{$row["SITE"]}}</td>
                    <td>{{$row["DESPWKS"]}}</td>
                    <td>{{$row["SUMTN"]}}</td>
                    <td>{{$row["ADVMET"]}}</td>
                    <td>{{$row["REQUESTDATE"]}}</td>
                    <td>{{$row["REQUESTTIME"]}}</td>
                    <td>{{$row["COLLECTDATE"]}}</td>
                    <td>{{$row["COLLECTTIME"]}}</td>
                    <td>{{$row["QUAYDATE"]}}</td>
                    <td>{{$row["QUAYTIME"]}}</td>
                    <td>{{$row["LOADDATE"]}}</td>
                    <td>{{$row["LOADTIME"]}}</td>
                    <td>{{$row["DEPARTDATE"]}}</td>
                    <td>{{$row["DEPARTTIME"]}}</td>
                    <td>{{$row["ENROUTEDATE"]}}</td>
                    <td>{{$row["ENROUTETIME"]}}</td>
                    <td>{{$row["DELIVDATE"]}}</td>
                    <td>{{$row["DELIVTIME"]}}</td>
                    <td>{{$row["ADVNO"]}}</td>
                    <td>{{$row["CHARTFLAG"]}}</td>
                    <td>{{$row["CONSIGNREF"]}}</td>
                    <td>{{$row["SPARE1DATE"]}}</td>
                    <td>{{$row["SPARE1TIME"]}}</td>
                    <td>{{$row["SPARE2DATE"]}}</td>
                    <td>{{$row["SPARE2TIME"]}}</td>
                    <td>{{$row["AMENDDATE"]}}</td>
                    <td>{{$row["AMENDTIME"]}}</td>
                    <td>{{$row["CANCELDATE"]}}</td>
                    <td>{{$row["CANCELTIME"]}}</td>
                    <td>{{$row["REQUESTYR"]}}</td>
                    <td>{{$row["SALESYR"]}}</td>
                    <td>{{$row["SALESPRE"]}}</td>
                    <td>{{$row["SALESNO"]}}</td>
                    <td>{{$row["ITEMNO"]}}</td>
                    <td>{{$row["REFER_LAST_TRANS"]}}</td>
                    <td>{{$row["TIMST_LAST_ACTIV"]}}</td>
                    <td>{{$row["CARRIER"]}}</td>
                    <td>{{$row["SAPORDER"]}}</td>
                    <td>{{$row["WKSORDER"]}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <th>LOADREF</th>
            <th>LOADREFDATE</th>
            <th>CUSTNAME</th>
            <th>MKTDEST</th>
            <th>MKTNAME</th>
            <th>SITE</th>
            <th>DESPWKS</th>
            <th>ADVTN</th>
            <th>ADVMET</th>
            <th>REQUESTDATE</th>
            <th>REQUESTTIME</th>
            <th>COLLECTDATE</th>
            <th>COLLECTTIME</th>
            <th>QUAYDATE</th>
            <th>QUAYTIME</th>
            <th>LOADDATE</th>
            <th>LOADTIME</th>
            <th>DEPARTDATE</th>
            <th>DEPARTTIME</th>
            <th>ENROUTEDATE</th>
            <th>ENROUTETIME</th>
            <th>DELIVDATE</th>
            <th>DELIVTIME</th>
            <th>ADVNO</th>
            <th>CHARTFLAG</th>
            <th>CONSIGNREF</th>
            <th>SPARE1DATE</th>
            <th>SPARE1TIME</th>
            <th>SPARE2DATE</th>
            <th>SPARE2TIME</th>
            <th>AMENDDATE</th>
            <th>AMENDTIME</th>
            <th>CANCELDATE</th>
            <th>CANCELTIME</th>
            <th>REQUESTYR</th>
            <th>SALESYR</th>
            <th>SALESPRE</th>
            <th>SALESNO</th>
            <th>ITEMNO</th>
            <th>REFER_LAST_TRANS</th>
            <th>TIMST_LAST_ACTIV</th>
            <th>CARRIER</th>
            <th>SAPORDER</th>
            <th>WKSORDER</th>
            </tfoot>
        </table>
        <div>
        </div>
    </div>


    </div>

    @endsection

    @section('functionalScripts')

        <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
        <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
                    <!-- Extension scripts for datatables print functionality -->
                    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
                    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
                    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
                    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#shipping-table').DataTable({
                dom: 'Bfrtip',
                buttons: ['print', 'excel'],
                "order": [5, "desc"],

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
