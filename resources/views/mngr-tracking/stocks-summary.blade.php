@extends('layouts.app')

@section('pageTitle', 'Stocks Summary')
@section('pageName', 'Stocks Summary')
@section('engineeringActiveLink', 'active activeUnderline')
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

{{--    <div class="simpleflex justify-content-center">--}}
{{--        <div class="btn-flex mt-2 text-center">--}}
{{--            @section('overrideStartEndDate')--}}
{{--                start = moment().subtract(2, 'months').startOf('month');--}}
{{--                end = moment().endOf('month');--}}

{{--                var urlParams = new URLSearchParams(window.location.search);--}}
{{--                var dtFrom = urlParams.get('dtFrom');--}}
{{--                var dtTo = urlParams.get('dtTo');--}}

{{--                if (dtFrom !== null) {--}}
{{--                start = moment(dtFrom);--}}
{{--                end = moment(dtTo);--}}
{{--                }--}}
{{--            @endsection--}}
{{--            @section('dateRangePickerOnApplyCallback')--}}


{{--                window.dtFrom = dtFrom;--}}
{{--                window.dtTo = dtTo;--}}

{{--                window.location.href = rootUrl + "/finance/wm-finance?dtFrom="+dtFrom+"&dtTo="+dtTo;--}}

{{--            @endsection--}}
{{--            <div class="filters">--}}
{{--                @include('layouts.templates.daterangepicker')--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
<style>
    .Red{background-color:#ff0000;}
    .Amber{background-color: #ff8223;}
    .Green{background-color:#00ff00;}

</style>
    <div id="summary" style="margin-top: 3em;">


        <div>

        <table class="table">

            <th colspan=""></th>
            <th colspan="">Stocks</th>
            <th colspan="">Week to Date Delivery</th>
            <th colspan="">Comments</th>

            <tr>
                <td colspan="1">Coils</td>
                <td colspan="1">{{$coilTonnesInStockCount}}</td>
                <td colspan="1">{{$coilTonnesDeliveredThisWeek}}</td>
                <td colspan="1"><input style="width:100%" type="text"></td>

            </tr>

        </table>


            <table class="table">

                <th colspan=""></th>
                <th colspan="">WIP</th>
                <th colspan="">FG</th>
                <th colspan="">Surplus & Non Prime</th>

                <tr>
                    <td colspan="1">Pipe</td>
                    <td colspan="1">{{$wipTonnes}}</td>
                    <td colspan="1">{{$finishedGoodsTonnes}}</td>
                    <td colspan="1">{{$surplusNonPrimeTonnes}}</td>

                </tr>

            </table>

{{--            ->with('$rhsMillTonnesDay', $rhsMillTonnesDay)--}}
{{--            ->with('$rhsMillTonnesWeekToDate', $rhsMillTonnesWeekToDate)--}}
{{--            ->with('$rhsMillTonnesMonthToDate', $rhsMillTonnesMonthToDate)--}}
{{--            ->with('$rhsMillTonnesMonthToDate', $rhsMillTonnesMonthToDate)--}}
{{--            ->with('$rhsMillTonnesMonthToDate', $rhsMillTonnesMonthToDate)--}}
{{--            ->with('$rhsMillTonnesMonthToDate', $rhsMillTonnesMonthToDate)--}}
{{--            ->with('coilTonnesDeliveredThisWeek', $coilTonnesDeliveredThisWeek);--}}


            <table class="table">

                <th colspan=""></th>
                <th colspan="">Daily</th>
                <th colspan="">Week To Date</th>
                <th colspan="">Month To Date</th>
                <th colspan="">AP RAG</th>
                <th colspan="">Comments</th>

                <tr>
                    <td colspan="1">Weld Mill</td>
                    <td colspan="1">{{$weldMillTonnesDay}}</td>
                    <td colspan="1">{{$weldMillTonnesWeekToDate}}</td>
                    <td colspan="1">{{$weldMillTonnesMonthToDate}}</td>
                    <td class="Red"><select>
                            <option class="Red">Red</option>
                            <option class="Amber">Amber</option>
                            <option class="Green">Green</option>
                        </select></td>
                    <td colspan="1"><input style="width:100%" type="text"></td>

                </tr>

                <tr>
                    <td colspan="1">RHS Mill</td>
                    <td colspan="1">{{$rhsMillTonnesDay}}</td>
                    <td colspan="1">{{$rhsMillTonnesWeekToDate}}</td>
                    <td colspan="1">{{$rhsMillTonnesMonthToDate}}</td>
                    <td  class="Red" colspan="1"><select>
                            <option class="Red">Red</option>
                            <option class="Amber">Amber</option>
                            <option class="Green">Green</option>
                        </select></td>
                    <td colspan="1"><input style="width:100%" type="text"></td>

                </tr>

                <tr>
                    <td colspan="1">Rounds Finishing Mill</td>
                    <td colspan="1">{{$roundsMillTonnesDay}}</td>
                    <td colspan="1">{{$roundsMillTonnesWeekToDate}}</td>
                    <td colspan="1">{{$roundsMillTonnesMonthToDate}}</td>
                    <td  class="Red" colspan="1"><select>
                            <option class="Red">Red</option>
                            <option class="Amber">Amber</option>
                            <option class="Green">Green</option>
                        </select></td>
                    <td colspan="1"><input style="width:100%" type="text"></td>

                </tr>

                <tr>
                    <td colspan="1">Despatch</td>
                    <td colspan="1">{{$despatchMillTonnesDay}}</td>
                    <td colspan="1">{{$despatchMillTonnesWeekToDate}}</td>
                    <td colspan="1">{{$despatchMillTonnesMonthToDate}}</td>
                    <td  class="Red"  colspan="1" ><select>
                            <option class="Red">Red</option>
                            <option class="Amber">Amber</option>
                            <option class="Green">Green</option>
                        </select></td>
                    <td colspan="1"><input style="width:100%" type="text"></td>

                </tr>

            </table>
        </div>


    </div>


@endsection
@section('functionalScripts')

    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="{{ asset('public/js/parseTable.js')}}"></script>
    <script src="{{ asset('public/libraries/lodash/lodash.js')}}"></script>

    {{--            <!-- Extension scripts for datatables print functionality -->--}}
                <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
                <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
                <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
                <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>

    <script>



        $("select").change(function(){
            var origBGColor=$(this).attr("class");

            $(this).parent().removeClass($(this).parent().attr('class'))
                .addClass($(":selected",this).attr('class'));


        });





        // unused





        /**
         * Datatable intialization and config.
         */



    </script>
@endsection
