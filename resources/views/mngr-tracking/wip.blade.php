@extends('layouts.app')

@section('pageTitle', 'WIP')
@section('pageName', 'WIP')
@section('millTrackingActiveLink', 'active activeUnderline')
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
    <h4>Pipe List Shortcut Buttons</h4>
    <hr/>
    <div class="wip-shortcut-buttons simpleflex mb-4">

        <a href="{{ route('pipe-list', ["all"=>"true"]) }}">
            <button class="btn btn-outline-primary">ALL WIP</button>
        </a>
        <a href="{{ route('pipe-list-dept', ["dept"=>"Finishing"]) }}" style="max-width: 120px; flex:1;margin:2px;">
            <button class="btn btn-outline-primary">Finishing</button>
        </a>
        <a href="{{ route('pipe-list-dept', ["dept"=>"Despatch"]) }}" style="max-width: 120px; flex:1;margin:2px;">
            <button class="btn btn-outline-primary">Despatch</button>
        </a>
        <a href="{{ route('pipe-list-dept', ["dept"=>"Casing"]) }}" style="max-width: 120px; flex:1;margin:2px;">
            <button class="btn btn-outline-primary">Casing</button>
        </a>
        <a href="{{ route('pipe-list-dept', ["dept"=>"Weld Mill"]) }}" style="max-width: 120px; flex:1;margin:2px;">
            <button class="btn btn-outline-primary">Weld Mill</button>
        </a>
        <a href="{{ route('pipe-list-dept', ["dept"=>"RHS"]) }}" style="max-width: 120px; flex:1;margin:2px;">
            <button class="btn btn-outline-primary">RHS</button>
        </a>
        <a href="{{ route('pipe-list-dept', ["dept"=>"NDT"]) }}" style="max-width: 120px; flex:1;margin:2px;">
            <button class="btn btn-outline-primary">NDT</button>
        </a>
        <a href="{{ route('pipe-list-dept', ["dept"=>"Prod Serv"]) }}" style="max-width: 120px; flex:1;margin:2px;">
            <button class="btn btn-outline-primary">Prod Serv</button>
        </a>
        <a href="{{ route('stock-pipe-list') }}" style="max-width: 120px; flex:1;margin:2px;">
            <button class="btn btn-outline-primary">Stock WIP</button>
        </a>
    </div>

    <h5>All WIP By Size</h5>
    <hr/>
    <div class="flex-right all-pipe-list-buttons">


        <a id="allPipeByPositionListLink" href="#" style="max-width: 120px; flex:1;margin:2px;">
            <button class="btn btn-outline-primary"></button>
        </a>
        <a id="exStockPipeByPositionListLink" href="#" style="max-width: 170px; flex:1;margin:2px;">
            <button class="btn btn-outline-primary"></button>
        </a>
    </div>

    <div class="flex-justify-right">

        <div class="fl1">

            <table id="WIP-tbl" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>SIZE</th>
                    <th>THICK</th>
                    <th>ROUTING_POS</th>
                    <th>DEPT</th>
                    <th>COUNT</th>
                    <th>METRES</th>
                    <th>WEIGHT</th>
                    <th>PR</th>
                    <th>PR_DESCRIPTION</th>
                    <th>Detail</th>
                </tr>
                </thead>
                <tbody>

                <?php
                // Get DepartmentByRoutingArray so we can lookup the Dept name with the routing pos.
                $deptByRoutingArray = \App\H20Custom\DepartmentByRoutingArray::GetDeptByRoutingLookupArray();
                ?>
                <!-- Note: $wipArray is 3 keys deep.-->
                @foreach($wipArray as $key => $value)
                    <tr>
                        <td>{{$value["SIZE1"]."x".$value["SIZE2"]}}</td>
                        <td>{{$value["THICK"]}}</td>
                        <td>{{$value["ROUTING_POS"]}}</td>
                        <td>{{$deptByRoutingArray[$value["ROUTING_POS"]]}}</td>
                        <td>{{$value["COUNT"]}}</td>
                        <td>{{$value["TOTAL_METRES"]}}</td>
                        <td>{{$value["TOTAL_TONNES"]}}</td>
                        <td>{{$value["PR"]}}</td>
                        <td>{{$processRouteLookupArray[$value["PR"]]}}</td>
                        <td>
                            <a href="{{ route('pipe-list')}}?size1={{$value["SIZE1"]}}&size2={{$value["SIZE2"]}}&thick={{$value["THICK"]}}&routingPos={{$value["ROUTING_POS"]}}&processRoute={{$value["PR"]}}">View
                                Pipes/Sections ></a></td>
                    </tr>
                @endforeach
                </tbody>

                <tfoot>
                <tr>
                    <th>SIZE</th>
                    <th>THICK</th>
                    <th>ROUTING_POS</th>
                    <th>DEPT</th>
                    <th>COUNT</th>
                    <th>METRES</th>
                    <th>WEIGHT</th>
                    <th>PR</th>
                    <th>PR_DESCRIPTION</th>
                    <th>Detail</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <hr/>
    <h3>RHS WIP By Size/Thick</h3>
    <hr/>


    <div id="rhsWipMultiBarChart" style="height:1000px">
        <svg></svg>
    </div>



    <hr/>
    <h3>CHS WIP By Size/Thick</h3>
    <hr/>

    <div id="chsWipMultiBarChart" style="height:800px">
        <svg></svg>
    </div>

    <hr/>
    <h3>WIP By Process Route</h3>
    <hr/>
    <div id="wipByPRMultiBarChart" style="height:500px">
        <svg></svg>
    </div>

    <hr/>
    <h3>Status Code By Position WIP </h3>
    <hr/>
    <div id="statusCodeByPositionWipMultiBarChart" style="height:500px">
        <svg></svg>
    </div>

    <hr/>
    <h3>Status Code WIP</h3> <p>Click bar to get pipe list</p>
    <hr/>
    <div id="statusCodeWipBarChart">
        <svg></svg>
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
        var rhsWipJson = <?php echo $rhsWipJson; ?>;
        console.log(rhsWipJson);
        var chsWipJson = <?php echo $chsWipJson; ?>;
        console.log(chsWipJson);
        var wipByPRJson = <?php echo $wipByPR; ?>;
        console.log("wipByPRJSON", wipByPRJson);

        var statusCodeByPosWipJSON = <?php echo $statusCodeWipByPos; ?>;
        console.log(statusCodeByPosWipJSON);

        var statusCodeWipJSON = <?php echo $statusCodeWip; ?>;
        console.log(statusCodeWipJSON);

        var sortedValues = _.orderBy(statusCodeWipJSON[0].values, 'value', 'desc');
        statusCodeWipJSON[0].values = sortedValues

        console.log(statusCodeWipJSON)
        RenderStaticGroupedHorizontalBarChart(rhsWipJson, "rhsWipMultiBarChart", true);
        RenderStaticGroupedHorizontalBarChart(chsWipJson, "chsWipMultiBarChart", true);
        RenderStaticStackableBarChart(wipByPRJson, "wipByPRMultiBarChart");

        RenderStaticStackableBarChart(statusCodeByPosWipJSON, "statusCodeByPositionWipMultiBarChart");
        RenderStaticDiscreteBarChart(statusCodeWipJSON, "label", "value", "statusCodeWipBarChart", "/mngr-tracking/pipe-list-status-code?statusCode=", "Status Code", "Pipe Count", ",0f", ",0f",[], true, false, null, null, null, null, null);

        /**
         * Datatable intialization and config.
         */
        $(document).ready(function () {
            var table = $('#WIP-tbl').DataTable({
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
