@extends('layouts.app')

@section('pageTitle', 'Desp Order Tracking Dashboard')
@section('pageName', 'Desp Order Tracking Dashboard')

@section('content')
@section('css')
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/plotly.basic.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pivot.css?v=1.2.1')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>

    <style>

        div#despOrderTrackingPivot {
            width: 750px;
            height: 500px;
            padding: 15%;
        }
    </style>
@endsection


<div style="text-align: center;
    margin-top: -50px;">
    <h2>Desp Order Tracking Dashboard</h2>
</div>

<div style="display: flex; flex-wrap: wrap;">

    <div class="dashboardContainer" style="display: flex;">
        <div class="dashboard-flex-card" style="margin: 1em;">
            <h3 style="text-align: center;text-decoration: underline;margin-top: 10px;">Order Tracking Not Ready Stacked
                Bar</h3>
            <div id="despOrderTrackingPivotStackedBar" width="100%"></div>
        </div>
    </div>

    <div class="dashboardContainer" style="display: flex;">
        <div class="dashboard-flex-card" style="margin: 1em;">
            <h3 style="text-align: center;text-decoration: underline;margin-top: 10px;">Tonnes By Customer @ INSP &
                LOCA</h3>
            <div id="despOrderTrackingByCustomerInspLocaStackedBar" width="100%"></div>
        </div>
    </div>

    <div class="dashboardContainer">
        <div class="dashboard-flex-card" style="margin: 1em;">
            <h3 style="text-align: center;text-decoration: underline;margin-top: 10px;">Tonnes By Size @ INSP &
                LOCA</h3>
            <div id="despOrderTrackingBySizeInspLocaStackedBar" width="100%"></div>
        </div>
    </div>

    <div class="dashboardContainer" style="display: flex;">
        <div class="dashboard-flex-card" style="margin: 1em;">
            <h3 style="text-align: center;text-decoration: underline;margin-top: 10px;">Order Tracking Not Ready</h3>
            <div id="despOrderTrackingByDelbRangePivot" width="100%"></div>
        </div>
    </div>

    <div class="dashboardContainer" style="display: flex;">
        <div class="dashboard-flex-card" style="margin: 1em;">
            <h3 style="text-align: center;text-decoration: underline;margin-top: 10px;">Order Tracking By Latest
                Delivery</h3>
            <div id="despOrderTrackingByLatestDeliveryPivot" width="100%"></div>
        </div>
    </div>

    <div class="dashboardContainer" style="display: flex;">
        <div class="dashboard-flex-card" style="margin: 1em;">
            <h3 style="text-align: center;text-decoration: underline;margin-top: 10px;">Order Tracking By Date</h3>
            <div id="despOrderTrackingByShortDatePivot" width="100%"></div>
        </div>
    </div>
</div>


@endsection

@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js?v=1.21')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js?v=1.12')}}"></script>

    <script type="text/javascript" src="{{ asset('public/js/pivotJS/jqueryUI.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/pivot.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/pivotJS/plotly-renderers.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function BuildCharts(data) {
            // RenderStaticDiscreteBarChart($.parseJSON(data.tonnesByCustomerJson), 'label', 'value', 'tonnesByCustomerBarChart', '', "Customer", 'Tonnes', '.0f', '.0f', [], true, false, null, null, null, null, null, 90, {
            //     top: 30,
            //     right: 20,
            //     bottom: 80,
            //     left: 40
            // });

            // RenderStaticMultiBarChart(data.despatchTonnesBySingleCustomerIntervalJson, "Tonnes", "Interval", "tonnesByCustomerIntervalBarChart")
        }

        function BuildPivots(data) {
            /**
             * Render Tons By Status / PR Pivot
             * ********************************
             */

            let utils = $.pivotUtilities;
            let sum = $.pivotUtilities.aggregatorTemplates.sum;
            var numberFormat = $.pivotUtilities.numberFormat;
            var intFormat = numberFormat({digitsAfterDecimal: 2});
            let renderers = $.extend($.pivotUtilities.renderers,
                $.pivotUtilities.plotly_renderers);
            let pivotData = data;
            let loadedConfig = {
                "rendererOptions": {
                    "localeStrings": {
                        "renderError": "An error occurred rendering the PivotTable results.",
                        "computeError": "An error occurred computing the PivotTable results.",
                        "uiRenderError": "An error occurred rendering the PivotTable UI.",
                        "selectAll": "Select All",
                        "selectNone": "Select None",
                        "tooMany": "(too many to list)",
                        "filterResults": "Filter values",
                        "apply": "Apply",
                        "cancel": "Cancel",
                        "totals": "Totals",
                        "vs": "vs",
                        "by": "by"
                    }, "table": {}
                },
                "localeStrings": {
                    "renderError": "An error occurred rendering the PivotTable results.",
                    "computeError": "An error occurred computing the PivotTable results.",
                    "uiRenderError": "An error occurred rendering the PivotTable UI.",
                    "selectAll": "Select All",
                    "selectNone": "Select None",
                    "tooMany": "(too many to list)",
                    "filterResults": "Filter values",
                    "apply": "Apply",
                    "cancel": "Cancel",
                    "totals": "Totals",
                    "vs": "vs",
                    "by": "by"
                },
                "derivedAttributes": {},
                "hiddenAttributes": [],
                "hiddenFromAggregators": [],
                "hiddenFromDragDrop": [],
                "menuLimit": 3000,
                "cols": ["DELB_RANGE"],
                "rows": ["ORDER_POS"],
                "vals": ["TRACK_TONNES"],
                "rowOrder": "value_z_to_a",
                "colOrder": "key_a_to_z",
                "exclusions": {"ORDER_POS": ["BLCK", "CUST", "DESH", "DESX", "ROAD", "SHIP", "TRAN", "DOWN"]},
                "inclusions": {"ORDER_POS": ["BNDL", "COMP", "FAIL", "HOLD", "INSP", "LOCA", "MANL", "TCRT", "WDRW"]},
                "unusedAttrsVertical": 85,
                "autoSortUnusedAttrs": false,
                "onRefresh": null,
                "showUI": false,
                "sorters": {},
                "rendererName": "Table",
                "inclusionsInfo": {"ORDER_POS": ["BNDL", "COMP", "FAIL", "HOLD", "INSP", "LOCA", "MANL", "TCRT", "WDRW"]},
                "aggregatorName": "Sum"
            };
            $("#despOrderTrackingByDelbRangePivot").pivotUI(pivotData, loadedConfig); // render pivot.

            /**
             *
             */


            pivotData = data;
            loadedConfig = {
                "rendererOptions": {
                    "plotly": {
                        autosize: true,
                        width: 750,
                        height: 600
                    },
                    "localeStrings": {
                        "renderError": "An error occurred rendering the PivotTable results.",
                        "computeError": "An error occurred computing the PivotTable results.",
                        "uiRenderError": "An error occurred rendering the PivotTable UI.",
                        "selectAll": "Select All",
                        "selectNone": "Select None",
                        "tooMany": "(too many to list)",
                        "filterResults": "Filter values",
                        "apply": "Apply",
                        "cancel": "Cancel",
                        "totals": "Totals",
                        "vs": "vs",
                        "by": "by"
                    }, "table": {}
                },
                "localeStrings": {
                    "renderError": "An error occurred rendering the PivotTable results.",
                    "computeError": "An error occurred computing the PivotTable results.",
                    "uiRenderError": "An error occurred rendering the PivotTable UI.",
                    "selectAll": "Select All",
                    "selectNone": "Select None",
                    "tooMany": "(too many to list)",
                    "filterResults": "Filter values",
                    "apply": "Apply",
                    "cancel": "Cancel",
                    "totals": "Totals",
                    "vs": "vs",
                    "by": "by"
                },
                "derivedAttributes": {},
                "hiddenAttributes": [],
                "hiddenFromAggregators": [],
                "hiddenFromDragDrop": [],
                "menuLimit": 3000,
                "cols": ["DELB_RANGE"],
                "rows": ["ORDER_POS"],
                "vals": ["TRACK_TONNES"],
                "rowOrder": "value_a_to_z",
                "colOrder": "value_a_to_z",
                "exclusions": {"ORDER_POS": ["BOOK", "CUST", "DESH", "DESX", "NIRA", "ROAD", "SHIP", "TRAN", "BLCK", "DOWN"]},
                "inclusions": {"ORDER_POS": ["ABDL", "BNDL", "COMP", "FAIL", "HOLD", "INSP", "LOCA", "MANL", "OISP", "TCRT", "WDRW"]},
                "unusedAttrsVertical": 85,
                "autoSortUnusedAttrs": false,
                "showUI": false,
                "sorters": {},
                "rendererName": "Horizontal Stacked Bar Chart",
                "inclusionsInfo": {"ORDER_POS": ["ABDL", "BNDL", "COMP", "FAIL", "HOLD", "INSP", "LOCA", "MANL", "OISP", "TCRT", "WDRW"]},
                "aggregatorName": "Sum"
            };
            $("#despOrderTrackingPivotStackedBar").pivotUI(pivotData, loadedConfig); // render pivot.


            pivotData = data;
            loadedConfig = {
                "rendererOptions": {
                    "plotly": {
                        autosize: true,
                        width: 750,
                        height: 600
                    },
                    "localeStrings": {
                        "renderError": "An error occurred rendering the PivotTable results.",
                        "computeError": "An error occurred computing the PivotTable results.",
                        "uiRenderError": "An error occurred rendering the PivotTable UI.",
                        "selectAll": "Select All",
                        "selectNone": "Select None",
                        "tooMany": "(too many to list)",
                        "filterResults": "Filter values",
                        "apply": "Apply",
                        "cancel": "Cancel",
                        "totals": "Totals",
                        "vs": "vs",
                        "by": "by"
                    }, "table": {}
                },
                "localeStrings": {
                    "renderError": "An error occurred rendering the PivotTable results.",
                    "computeError": "An error occurred computing the PivotTable results.",
                    "uiRenderError": "An error occurred rendering the PivotTable UI.",
                    "selectAll": "Select All",
                    "selectNone": "Select None",
                    "tooMany": "(too many to list)",
                    "filterResults": "Filter values",
                    "apply": "Apply",
                    "cancel": "Cancel",
                    "totals": "Totals",
                    "vs": "vs",
                    "by": "by"
                },
                "derivedAttributes": {},
                "hiddenAttributes": [],
                "hiddenFromAggregators": [],
                "hiddenFromDragDrop": [],
                "menuLimit": 3000,
                "cols": ["ORDER_POS"],
                "rows": ["CUSTOMER_NAME_1"],
                "vals": ["TRACK_TONNES"],
                "rowOrder": "value_a_to_z",
                "colOrder": "value_a_to_z",
                "exclusions": {"ORDER_POS": ["ABDL", "AWBO", "BLCK", "BNDL", "BOOK", "COMP", "CUST", "DESH", "DESX", "DOWN", "FAIL", "HOLD", "MANL", "OISP", "ROAD", "SHIP", "TCRT", "TRAN", "WDRW"]},
                "inclusions": {"ORDER_POS": ["INSP", "LOCA"]},
                "unusedAttrsVertical": 85,
                "autoSortUnusedAttrs": false,
                "showUI": false,
                "sorters": {},
                "rendererName": "Horizontal Stacked Bar Chart",
                "inclusionsInfo": {"ORDER_POS": ["INSP", "LOCA"]},
                "aggregatorName": "Sum"
            };
            $("#despOrderTrackingByCustomerInspLocaStackedBar").pivotUI(pivotData, loadedConfig); // render pivot.

            pivotData = data;
            loadedConfig = {
                "rendererOptions": {
                    "plotly": {
                        autosize: true,
                        width: 750,
                        height: 600
                    },
                    "localeStrings": {
                        "renderError": "An error occurred rendering the PivotTable results.",
                        "computeError": "An error occurred computing the PivotTable results.",
                        "uiRenderError": "An error occurred rendering the PivotTable UI.",
                        "selectAll": "Select All",
                        "selectNone": "Select None",
                        "tooMany": "(too many to list)",
                        "filterResults": "Filter values",
                        "apply": "Apply",
                        "cancel": "Cancel",
                        "totals": "Totals",
                        "vs": "vs",
                        "by": "by"
                    }, "table": {}
                },
                "localeStrings": {
                    "renderError": "An error occurred rendering the PivotTable results.",
                    "computeError": "An error occurred computing the PivotTable results.",
                    "uiRenderError": "An error occurred rendering the PivotTable UI.",
                    "selectAll": "Select All",
                    "selectNone": "Select None",
                    "tooMany": "(too many to list)",
                    "filterResults": "Filter values",
                    "apply": "Apply",
                    "cancel": "Cancel",
                    "totals": "Totals",
                    "vs": "vs",
                    "by": "by"
                },
                "derivedAttributes": {},
                "hiddenAttributes": [],
                "hiddenFromAggregators": [],
                "hiddenFromDragDrop": [],
                "menuLimit": 3000,
                "cols": ["ORDER_POS"],
                "rows": ["PIPE_SIZE1", "PIPE_SIZE2"],
                "vals": ["TRACK_TONNES"],
                "rowOrder": "value_a_to_z",
                "colOrder": "value_a_to_z",
                "exclusions": {"ORDER_POS": ["ABDL", "AWBO", "BLCK", "BNDL", "BOOK", "COMP", "CUST", "DESH", "DESX", "DOWN", "FAIL", "HOLD", "MANL", "OISP", "ROAD", "SHIP", "TCRT", "TRAN", "WDRW"]},
                "inclusions": {"ORDER_POS": ["INSP", "LOCA"]},
                "unusedAttrsVertical": 85,
                "autoSortUnusedAttrs": false,
                "showUI": false,
                "sorters": {},
                "rendererName": "Horizontal Stacked Bar Chart",
                "inclusionsInfo": {"ORDER_POS": ["INSP", "LOCA"]},
                "aggregatorName": "Sum"
            };
            $("#despOrderTrackingBySizeInspLocaStackedBar").pivotUI(pivotData, loadedConfig); // render pivot.


            //
            pivotData = data;
            loadedConfig = {
                "rendererOptions": {
                    "localeStrings": {
                        "renderError": "An error occurred rendering the PivotTable results.",
                        "computeError": "An error occurred computing the PivotTable results.",
                        "uiRenderError": "An error occurred rendering the PivotTable UI.",
                        "selectAll": "Select All",
                        "selectNone": "Select None",
                        "tooMany": "(too many to list)",
                        "filterResults": "Filter values",
                        "apply": "Apply",
                        "cancel": "Cancel",
                        "totals": "Totals",
                        "vs": "vs",
                        "by": "by"
                    }, "table": {}
                },
                "localeStrings": {
                    "renderError": "An error occurred rendering the PivotTable results.",
                    "computeError": "An error occurred computing the PivotTable results.",
                    "uiRenderError": "An error occurred rendering the PivotTable UI.",
                    "selectAll": "Select All",
                    "selectNone": "Select None",
                    "tooMany": "(too many to list)",
                    "filterResults": "Filter values",
                    "apply": "Apply",
                    "cancel": "Cancel",
                    "totals": "Totals",
                    "vs": "vs",
                    "by": "by"
                },
                "derivedAttributes": {},
                "hiddenAttributes": [],
                "hiddenFromAggregators": [],
                "hiddenFromDragDrop": [],
                "menuLimit": 3000,
                "cols": ["ORDER_POS"],
                "rows": ["LATEST_DELIVERY"],
                "vals": ["TRACK_TONNES"],
                "rowOrder": "key_a_to_z",
                "colOrder": "value_z_to_a",
                "exclusions": {"ORDER_POS": ["BOOK", "CUST", "DESH", "DESX", "NIRA", "ROAD", "SHIP", "TRAN", "BLCK", "DOWN"]},
                "inclusions": {"ORDER_POS": ["ABDL", "BNDL", "COMP", "FAIL", "HOLD", "INSP", "LOCA", "MANL", "OISP", "TCRT", "WDRW"]},
                "unusedAttrsVertical": 85,
                "autoSortUnusedAttrs": false,
                "showUI": true,
                "sorters": {},
                "rendererName": "Table",
                "inclusions": {"ORDER_POS": ["ABDL", "BNDL", "COMP", "FAIL", "HOLD", "INSP", "LOCA", "MANL", "OISP", "TCRT", "WDRW"]},
                "aggregatorName": "Sum"
            };
            $("#despOrderTrackingByLatestDeliveryPivot").pivotUI(pivotData, loadedConfig); // render pivot.


            pivotData = data;
            loadedConfig = {
                "rendererOptions": {
                    "localeStrings": {
                        "renderError": "An error occurred rendering the PivotTable results.",
                        "computeError": "An error occurred computing the PivotTable results.",
                        "uiRenderError": "An error occurred rendering the PivotTable UI.",
                        "selectAll": "Select All",
                        "selectNone": "Select None",
                        "tooMany": "(too many to list)",
                        "filterResults": "Filter values",
                        "apply": "Apply",
                        "cancel": "Cancel",
                        "totals": "Totals",
                        "vs": "vs",
                        "by": "by"
                    }, "table": {}
                },
                "localeStrings": {
                    "renderError": "An error occurred rendering the PivotTable results.",
                    "computeError": "An error occurred computing the PivotTable results.",
                    "uiRenderError": "An error occurred rendering the PivotTable UI.",
                    "selectAll": "Select All",
                    "selectNone": "Select None",
                    "tooMany": "(too many to list)",
                    "filterResults": "Filter values",
                    "apply": "Apply",
                    "cancel": "Cancel",
                    "totals": "Totals",
                    "vs": "vs",
                    "by": "by"
                },
                "derivedAttributes": {},
                "hiddenAttributes": [],
                "hiddenFromAggregators": [],
                "hiddenFromDragDrop": [],
                "menuLimit": 3000,
                "cols": ["ORDER_POS"],
                "rows": ["SHORT_DATETIME_TANDEM"],
                "vals": ["TRACK_TONNES"],
                "rowOrder": "value_z_to_a",
                "colOrder": "key_a_to_z",
                "exclusions": {"ORDER_POS": ["BOOK", "CUST", "DESH", "DESX", "NIRA", "ROAD", "SHIP", "TRAN", "BLCK", "DOWN"]},
                "inclusions": {"ORDER_POS": ["ABDL", "BNDL", "COMP", "FAIL", "HOLD", "INSP", "LOCA", "MANL", "OISP", "TCRT", "WDRW"]},
                "unusedAttrsVertical": 85,
                "autoSortUnusedAttrs": false,
                "showUI": false,
                "sorters": {},
                "rendererName": "Table",
                "inclusionsInfo": {"ORDER_POS": ["ABDL", "BNDL", "COMP", "FAIL", "HOLD", "INSP", "LOCA", "MANL", "OISP", "TCRT", "WDRW"]},
                "aggregatorName": "Sum"
            };
            $("#despOrderTrackingByShortDatePivot").pivotUI(pivotData, loadedConfig); // render pivot.
        }

        var data = <?php echo $orderTrackingData; ?>;

        BuildPivots(data);

    </script>

@endsection
