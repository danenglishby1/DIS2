@extends('layouts.app')

@section('pageTitle', 'Defects')
@section('pageName', 'RHS Defects')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
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
<!-- Content Row -->
    <hr/>
    <h3>WIP Defect List</h3>
    <hr/>

    <div class="flex-justify-right">

        <div class="fl1">

            <table id="outstandingDefectTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>SECTION</th>
                    <th>DATE FOUND</th>
                    <th>YEAR/MONTH</th>
                    <th>SIZE</th>
                    <th>THICK</th>
                    <th>FOUND AT POS</th>
                    <th>CURRENT POS</th>
                    <th>DEFECT</th>
                    <th>CODE</th>
                    <th>REWORK COMMENTS</th>
                    <th>REWORK COMPLETE</th>
                    <th>BLOCK NO</th>
                    <th>ROLL WEEK</th>
                    <th>MILL LINE</th>
                </tr>
                </thead>
                <tbody>

                <!-- Note: $wipArray is 3 keys deep.-->
                @foreach($allDefectsArray as $key => $value)
                    <tr>
                        <td>{{$value["TRACK_CODE_KEY2"]}}</td>
                        <td>{{ date('Y-m-d H:i:s', strtotime($value["DATETIME_TANDEM"])) }}</td>
                        <td>{{ date('y/m', strtotime($value["DATETIME_TANDEM"])) }}</td>
                        <td>{{$value["PIPE_SIZE1"]."x".$value["PIPE_SIZE2"]}}</td>
                        <td>{{$value["BLOCK_THICK"]}}</td>
                        <td>{{$value["FOUND_POS"]}}</td>
                        <td>{{$value["ROUTING_POS"]}}</td>
                        <td>{{$value["CONDITION_CODE_DESC"]}}</td>
                        <td>{{$value["CONDITION_CODE"]}}</td>
                        <td>{{$value["REWORK_COMMENTS"]}}</td>
                        <td>{{($value["REWORK_COMMENTS"] == "               " ? "N": "Y")}}</td>
                        <td>{{$value["BLOCK_NO"]}}</td>
                        <td>{{$value["ROLL_WEEK"]}}</td>
                        <td>{{$value["MILL_LINE"]}}</td>
{{--                        <td>--}}
{{--                            <a href="{{ route('pipe-list')}}?size1={{$value["SIZE1"]}}&size2={{$value["SIZE2"]}}&thick={{$value["THICK"]}}&routingPos={{$value["ROUTING_POS"]}}&processRoute={{$value["PR"]}}">View--}}
{{--                                Pipes/Sections ></a></td>--}}
                    </tr>
                @endforeach
                </tbody>

                <tfoot>
                <tr>
                    <th>SECTION</th>
                    <th>DATE FOUND</th>
                    <th>YEAR/MONTH</th>
                    <th>SIZE</th>
                    <th>THICK</th>
                    <th>FOUND AT POS</th>
                    <th>CURRENT POS</th>
                    <th>DEFECT</th>
                    <th>CODE</th>
                    <th>REWORK COMMENTS</th>
                    <th>REWORK COMPLETE</th>
                    <th>BLOCK NO</th>
                    <th>ROLL WEEK</th>
                    <th>MILL LINE</th>
                </tr>
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
    <!-- End  Extension scripts for datatables print functionality -->
    <script src="{{ asset('public/libraries/lodash/lodash.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /**
         * Datatable intialization and config.
         */
        $(document).ready(function () {
            var table = $('#outstandingDefectTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['print', 'excel'],
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


            // Listen to changes on routing drop down.

            $(table.column(2).footer()).find('select').on('change', function (e) {

                var routingPositionSelected = this.value;

                // If routing pos selected isn't blank, then show buttons.
                console.log(routingPositionSelected);
                if (routingPositionSelected == "") {
                    $('.all-pipe-list-buttons').css('display', 'none');
                } else {
                    $('.all-pipe-list-buttons').css('display', 'flex');
                }

                //Update buttons and links

                $('#allPipeByPositionListLink').attr('href', rootUrl + '/mngr-tracking/pipe-list?routingPos=' + routingPositionSelected);
                $('#allPipeByPositionListLink').find('button').html(routingPositionSelected + " - (ALL)");

                $('#exStockPipeByPositionListLink').attr('href', rootUrl + '/mngr-tracking/pipe-list?routingPos=' + routingPositionSelected + '&exStock=true');
                $('#exStockPipeByPositionListLink').find('button').html(routingPositionSelected + " - (Ex-Stock Only)");


            });


        });


    </script>

@endsection
