@extends('layouts.app')

@section('pageTitle', 'p & o')
@section('pageName', 'p & o')
@section('orderTrackingActiveLink', 'active activeUnderline')

@section('css')
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
</div>           PCI47820210614/710
</div> -->
    <div class="text-center">
        <h3>P & O Delivery Performance Dashboard - Collected</h3>
    </div>

    <div class="simpleflex">
        <div class="fl4">
            <div class="card shadow pb-2">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Outstanding Loads Collected not Delivered (Beyond
                        planned delivery date)</h6>

                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="outstandingLoadsCollectedNotDeliveredBarChart" style="height:500px">
                        <svg></svg>
                    </div>
                </div>
            </div>
            <div class="mb-3"></div> <!-- add space -->
            <div class="card shadow pb-2">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Outstanding Loads Delivery Date Today</h6>

                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="outstandingLoadsCollectedDeliveryTodayMultiBarChart" style="height:500px">
                        <svg></svg>
                    </div>
                </div>
            </div>

            <div class="mb-3"></div> <!-- add space -->
            <div class="card shadow pb-2">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">All Planned Deliveries By Date - <span id="customerFilterSelected">(Select Customer)</span></h6>
                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div class="form-group" style="margin: 1em">
                        <label>Filter by Customer</label>
                        <select class="form-control" id="customersSelectList">

                        </select>
                    </div>

                    <div id="collectedPlannedDeliveriesBarChart" style="height:500px">
                        <svg></svg>
                    </div>
                </div>



            </div>

            <div class="mb-3"></div> <!-- add space -->
            <div class="card shadow pb-2">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tomorrow Loads Planned for Delivery</h6>

                </div>
                <!-- Visual Content -->
                <!-- Card Body -->
                <div class="card-body">
                    <div id="collectedPlannedDeliveriesTomorrowBarChart" style="height:500px">
                        <svg></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('functionalScripts')
    <script src="{{ asset('public/js/jquery-3.3.1.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var customerList ="";
        /**
         * Datatable intialization and config.
         */


        $(document).ready(function () {

            $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: rootUrl + '/api/getCollectedDashboardData',
                success: function (data) {
                    console.log(data);
                    buildCustomerSelectList($.parseJSON(data.customerList));

                  //  buildCustomerSelectList(data.customerList);
                    RenderStaticDiscreteBarChart([$.parseJSON(data.outstandingLateLoadsCollectedNotDeliveredByCustomerJson)], 'label', 'value', 'outstandingLoadsCollectedNotDeliveredBarChart', null, 'HOUR', 'Count', ',01f', ',01f', [], true, false, null, null, null, null, null, 45, {
                        top: 30,
                        right: 60,
                        bottom: 150,
                        left: 70
                    });

                    RenderStaticDiscreteBarChart([$.parseJSON(data.collectedAndPlannedDeliveriesGroupedDataJson)], 'label', 'value', 'collectedPlannedDeliveriesBarChart', null, 'HOUR', 'Count', ',01f', ',01f', [], true, false, null, null, null, null, null, 45, {
                        top: 30,
                        right: 60,
                        bottom: 150,
                        left: 70
                    });

                    RenderStaticDiscreteBarChart([$.parseJSON(data.outstandingLateLoadsCollectedDeliveryTomorrowByCustomerJson)], 'label', 'value', 'collectedPlannedDeliveriesTomorrowBarChart', null, 'HOUR', 'Count', ',01f', ',01f', [], true, false, null, null, null, null, null, 45, {
                        top: 30,
                        right: 60,
                        bottom: 150,
                        left: 70
                    });

                    console.log(data.plannedDeliveriesByTownCustomerJson);

                    nv.addGraph(function () {
                        let chart = nv.models.multiBarChart()
                            .margin({top: 0, right: 0, bottom: 140, left: 100})
                            .stacked(true).showControls(false).color(['#b6b6b6', '#92d44f']);

                        chart.yAxis.tickFormat(d3.format(",0f"));
                        chart.xAxis
                            .rotateLabels(45);

                        d3.select('#outstandingLoadsCollectedDeliveryTodayMultiBarChart svg')
                            .datum($.parseJSON(data.plannedDeliveriesByTownCustomerJson))
                            .transition().duration(500).call(chart);

                        nv.utils.windowResize(chart.update); // Intitiate listener for window resize so the chart responds and changes width.
                        return chart;
                    });


                },
                complete: function () {
                    $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                }
            });
        });

        function BuildDashboard() {

        }

        function buildCustomerSelectList(data) {
            // Fill select list for filtering on TonnesByCustomerInterval chart.
            var $dropdown = $("#customersSelectList");
            $dropdown.append($("<option />").val("*").text("Please Select"));
            $.each(data, function () {
                $dropdown.append($("<option />").val(this).text(this));
            });
        }





        // Listen for filter change on customer list to update chart with new data
        $("#customersSelectList").on('change', function () {
            var customerName = this.value;
            $('#customerFilterSelected').html(customerName);
            $.ajax({
                type: 'POST',
                data: {"customerName": customerName},
                url: rootUrl + '/api/getCollectedDashboardData',
                dataType: 'json',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css('display', 'block');
                },
                success: function (data) {


                    RenderStaticDiscreteBarChart([$.parseJSON(data.collectedAndPlannedDeliveriesGroupedDataJson)], 'label', 'value', 'collectedPlannedDeliveriesBarChart', null, 'Date', 'Count', ',01f', ',01f', [], true, false, null, null, null, null, null, 45, {
                        top: 30,
                        right: 60,
                        bottom: 150,
                        left: 70
                    });
                },
                complete: function () {
                    $('.ajax-loader').css('display', 'none');
                }
            });


        });

    </script>
@endsection
