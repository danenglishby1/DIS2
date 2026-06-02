@extends('layouts.app')

@section('pageTitle', 'Stock Report')
@section('pageName', 'Stock Report')
@section('stockReportActiveLink', 'active activeUnderline')
@section('css')
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <style>
        #wrapper #content-wrapper {
            overflow: hidden;
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

    <div>
        <table id="stockreport-tbl" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th colspan="4" style="border: none; border-left: 2px solid #333;">ReportInfo</th>
                <th colspan="11" style="border: none; background: #e7e8f2; border-left: 2px solid #333;">Glance</th>
                <th colspan="14" style="border: none; background: #d8dae5; border-left: 2px solid #333;">Goods</th>
                <th colspan="12" style="border: none; background: #cfd2df; border-left: 2px solid #333;">Other</th>
            </tr>
            <tr>
                <th>date time</th>
                <th>Week or Month</th>
                <th>week no</th>
                <th>year no</th>
                <th>next weeks plan</th>
                <th>actual coil tonnes</th>
                <th>glance coil</th>
                <th>glance wip</th>
                <th>glance surplus</th>
                <th>glance surplus (Prime)</th>
                <th>glance surplus (Non-Prime)</th>
                <th>glance ord inv not desp or income recognised</th>
                <th>glance stock not inv</th>
                <th>WIP + SURP + ORDERS</th>
                <th>invoices</th>

                <th>goods comp loca</th>
                <th>goods insp</th>
                <th>goods oisp</th>
                <th>goods make into loads</th>
                <th>goods cust delay</th>
                <th>goods waiting collection (HOME)</th>
                <th>goods to apply for</th>
                <th>goods waiting shipping DESXA</th>
                <th>goods waiting collection DESXR</th>
                <th>goods withdraw</th>
                <th>goods suspend</th>
                <th>goods api stk others</th>
                <th>goods sthl</th>
                <th>goods dni</th>
                <th>surplus hot chs</th>
                <th>surplus cold chs</th>
                <th>surplus nom stock</th>
                <th>surplus pipe</th>
                <th>surplus dout</th>
                <th>surplus rhs hollows</th>
                <th>surplus leeds shorts</th>
                <th>surplus hot rhs</th>
                <th>surplus cold rhs</th>
                <th>surplus downgrade</th>
                <th>surplus dispose</th>
                <th>surplus id stock</th>
            </tr>
            </thead>
            <tbody>

            <!-- Note: $wipArray is 3 keys deep.-->
            @foreach($reportData as $key => $value)
                <tr>
                    <td>{{$value["date_time"]}}</td>
                    <td>{{$value["week_month_report_ind"]}}</td>
                    <td>{{$value["week_no"]}}</td>
                    <td>{{$value["year_no"]}}</td>
                    @if($hasPlanningRole)
                    <td><input class="stockReportInput" data-week="{{$value["week_no"]}}"
                               data-year="{{$value["year_no"]}}"
                               data-weekOrMonth="{{$value["week_month_report_ind"]}}" type="text"
                               value="{{$value["next_weeks_plan"]}}" data-stockreportfield="next_weeks_plan"
                               name="next_weeks_plan"/></td>
                    @else
                       <td>{{$value["next_weeks_plan"]}}</td>
                    @endif

                    <td>{{$value["actual_coil_tonnes"]}}</td>
                    <td>{{$value["glance_coil"]}}</td>
                    <td>{{$value["glance_wip"]}}</td>
                    <td>{{$value["glance_surplus"]}}</td>
                    <td>{{$value["glance_surplus_prime"]}}</td>
                    <td>{{$value["glance_surplus_non_prime"]}}</td>

                    @if($hasPlanningRole)
                        <td><input class="stockReportInput" data-week="{{$value["week_no"]}}"
                                   data-year="{{$value["year_no"]}}"
                                   data-weekOrMonth="{{$value["week_month_report_ind"]}}" type="text"
                                   value="{{$value["glance_ord_inv_not_desp_or_income_recognised"]}}"
                                   data-stockreportfield="glance_ord_inv_not_desp_or_income_recognised"
                                   name="glance_ord_inv_not_desp_or_income_recognised"/></td>
                    @else
                       <td>{{$value["glance_ord_inv_not_desp_or_income_recognised"]}}</td>
                    @endif

                    <td>{{( ($value["glance_wip"] + $value["glance_surplus"] + $value["goods_comp_loca"] +
                      $value["goods_insp"] +$value["goods_oisp"] + $value["goods_make_into_loads"] +
                      $value["goods_cust_delay"] + $value["goods_awaiting_collection"] + $value["goods_to_apply_for"] +
                      $value["goods_waiting_shipping"] + $value["goods_withdraw"] +
                      $value["goods_suspend"] + $value["goods_dni"] + $value["glance_coil"]) - $value["glance_ord_inv_not_desp_or_income_recognised"])
                      }}</td>

                    <td>{{($value["glance_wip"] + $value["glance_surplus"] + $value["goods_comp_loca"] +
                      $value["goods_insp"] +$value["goods_oisp"] + $value["goods_make_into_loads"] +
                      $value["goods_cust_delay"] + $value["goods_awaiting_collection"] + $value["goods_to_apply_for"] +
                      $value["goods_waiting_shipping"] + $value["goods_withdraw"] +
                      $value["goods_suspend"] + $value["goods_dni"])}}</td>

                    @if($hasPlanningRole)
                        <td><input class="stockReportInput" data-week="{{$value["week_no"]}}"
                                   data-year="{{$value["year_no"]}}"
                                   data-weekOrMonth="{{$value["week_month_report_ind"]}}" type="text"
                                   value="{{$value["invoices"]}}" data-stockreportfield="invoices" name="invoices"/></td>
                    @else
                        <td>{{$value["invoices"]}}</td>
                    @endif


                    <td>{{$value["goods_comp_loca"]}}</td>
                    <td>{{$value["goods_insp"]}}</td>
                    <td>{{$value["goods_oisp"]}}</td>
                    <td>{{$value["goods_make_into_loads"]}}</td>
                    <td>{{$value["goods_cust_delay"]}}</td>
                    <td>{{$value["goods_awaiting_collection"]}}</td>
                    <td>{{$value["goods_to_apply_for"]}}</td>

                    @if($hasPlanningRole)
                        <td><input class="stockReportInput" data-week="{{$value["week_no"]}}"
                                   data-year="{{$value["year_no"]}}"
                                   data-weekOrMonth="{{$value["week_month_report_ind"]}}" type="text"
                                   value="{{$value["goods_waiting_shipping"]}}"
                                   data-stockreportfield="goods_waiting_shipping"
                                   name="goods_waiting_shipping"/></td>
                    @else
                        <td>{{$value["goods_waiting_shipping"]}}</td>
                    @endif

                    @if($hasPlanningRole)
                        <td><input class="stockReportInput" data-week="{{$value["week_no"]}}"
                                   data-year="{{$value["year_no"]}}"
                                   data-weekOrMonth="{{$value["week_month_report_ind"]}}" type="text"
                                   value="{{$value["goods_waiting_collection"]}}"
                                   data-stockreportfield="goods_waiting_collection" name="goods_waiting_collection"/></td>
                    @else
                       <td>{{$value["goods_waiting_collection"]}}</td>
                    @endif

                    <td>{{$value["goods_withdraw"]}}</td>
                    <td>{{$value["goods_suspend"]}}</td>
                    <td>{{$value["goods_api_stk_others"]}}</td>
                    <td>{{$value["goods_sthl"]}}</td>

                    @if($hasPlanningRole)
                        <td><input class="stockReportInput" data-week="{{$value["week_no"]}}"
                                   data-year="{{$value["year_no"]}}"
                                   data-weekOrMonth="{{$value["week_month_report_ind"]}}" type="text"
                                   value="{{$value["goods_dni"]}}" data-stockreportfield="goods_dni" name="goods_dni"/></td>
                    @else
                        <td>{{$value["goods_dni"]}}</td>
                    @endif

                    <td>{{$value["surplus_hot_chs"]}}</td>
                    <td>{{$value["surplus_cold_chs"]}}</td>
                    <td>{{$value["surplus_nom_stock"]}}</td>
                    <td>{{$value["surplus_pipe"]}}</td>
                    <td>{{$value["surplus_dout"]}}</td>
                    <td>{{$value["surplus_rhs_hollows"]}}</td>
                    <td>{{$value["surplus_leeds_shorts"]}}</td>
                    <td>{{$value["surplus_hot_rhs"]}}</td>
                    <td>{{$value["surplus_cold_rhs"]}}</td>
                    <td>{{$value["surplus_downgrade"]}}</td>
                    <td>{{$value["surplus_dispose"]}}</td>
                    <td>{{$value["surplus_id_stock"]}}</td>
                </tr>
            @endforeach


            </tbody>
            <tfoot>
            <th>date time</th>
            <th>Week or Month</th>
            <th>week no</th>
            <th>year no</th>
            <th>next weeks plan</th>
            <th>actual coil tonnes</th>
            <th>glance coil</th>
            <th>glance wip</th>
            <th>glance surplus</th>
            <th>glance surplus (Prime)</th>
            <th>glance surplus (Non-Prime)</th>
            <th>glance ord inv not desp</th>
            <th>glance stock not inv</th>
            <th>WIP + SURP + ORDERS</th>
            <th>invoices</th>
            <th>goods comp loca</th>
            <th>goods insp</th>
            <th>goods oisp</th>
            <th>goods make into loads</th>
            <th>goods cust delay</th>
            <th>goods awaiting collection</th>
            <th>goods to apply for</th>
            <th>goods waiting shipping</th>
            <th>goods waiting collection</th>
            <th>goods withdraw</th>
            <th>goods suspend</th>
            <th>goods api stk others</th>
            <th>goods sthl</th>
            <th>goods dni</th>
            <th>surplus hot chs</th>
            <th>surplus cold chs</th>
            <th>surplus nom stock</th>
            <th>surplus pipe</th>
            <th>surplus dout</th>
            <th>surplus rhs hollows</th>
            <th>surplus leeds shorts</th>
            <th>surplus hot rhs</th>
            <th>surplus cold rhs</th>
            <th>surplus downgrade</th>
            <th>surplus dispose</th>
            <th>surplus id stock</th>
            </tfoot>
        </table>


    </div>


@endsection

@section('functionalScripts')
    <script src="{{ asset('public/js/jquery-3.3.1.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    <!-- Extension scripts for datatables print functionality -->
{{--    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>--}}
{{--    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>--}}
{{--    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>--}}
{{--    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>--}}
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

        var table = $('#stockreport-tbl').DataTable({
            dom: 'Bfrtip',
            "order": [[0, "desc"]],
            "scrollX": true,
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

        // Listen for changes in the GoodsNotInvoicedInput
        $(document).on("focusout", ".stockReportInput", function (e) {
            let value = e.target.value;
            let stockReportField = $(this).data('stockreportfield');
            let weekNo = $(this).data('week');
            let yearNo = $(this).data('year');
            let weekMonthInd = $(this).data('weekormonth');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: rootUrl + "/api/UpdateStockValue",
                data: {
                    'weekNo': weekNo,
                    'yearNo': yearNo,
                    'weekOrMonthInd': weekMonthInd,
                    'value': value,
                    'stockReportField': stockReportField
                },
                async: false,
                success: function (data) {
                    jsonResponse = $.parseJSON(data);
                    if (jsonResponse.status) {
                        alert(stockReportField + " field updated with " + value);
                    }
                }
            });

            //UpdateGoodsDNIValue


        });

    </script>

@endsection
