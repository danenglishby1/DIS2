@extends('layouts.app')

@section('pageTitle', 'Desp UKRFD Dashboard')
@section('pageName', 'Desp UKRFD Dashboard')

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
    <h2>UKRFD Dashboard</h2>
</div>

<hr />
<div style="text-align: center;">
    <h3>UK Ready For Despatch</h3>
</div>
<div style="display: flex; flex-wrap: wrap;">

    <div class="dashboardContainer" style="display: flex;">
        <div class="dashboard-flex-card" style="margin: 1em;">
            <h3 style="text-align: center;text-decoration: underline;margin-top: 10px;">Order Tracking UKRFD By Customer
                Bar</h3>
            <div id="despOrderTrackingUKRFDByCustomerPivotStackedBar" width="100%"></div>
        </div>
    </div>

    <div class="dashboardContainer" style="display: flex;">
        <div class="dashboard-flex-card" style="margin: 1em;">
            <h3 style="text-align: center;text-decoration: underline;margin-top: 10px;">Order Tracking UKRFD By Age
                Profiled
                Bar</h3>
            <div id="despOrderTrackingUKRFDByAgeProfilePivotStackedBar" width="100%"></div>
        </div>
    </div>


    <div class="dashboardContainer" style="display: flex;">
        <div class="dashboard-flex-card" style="margin: 1em;">
            <h3 style="text-align: center;text-decoration: underline;margin-top: 10px;">Order Tracking UKRFD</h3>
            <div id="despOrderUKRFDByCustomerPivot" width="100%"></div>
        </div>
    </div>
</div>

<hr/>
<div style="text-align: center;">
    <h3>Export Ready For Despatch</h3>
</div>

<div style="display: flex; flex-wrap: wrap;">
    <div class="dashboardContainer" style="display: flex;">
        <div class="dashboard-flex-card" style="margin: 1em;">
            <h3 style="text-align: center;text-decoration: underline;margin-top: 10px;">Order Tracking Export RFD By Customer Bar</h3>
            <div id="despOrderTrackingExportByCustomerPivotStackedBar" width="100%"></div>
        </div>
    </div>

    <div class="dashboardContainer" style="display: flex;">
        <div class="dashboard-flex-card" style="margin: 1em;">
            <h3 style="text-align: center;text-decoration: underline;margin-top: 10px;">Order Tracking Export RFD Age Profile Pivot</h3>
            <div id="despOrderTrackingExportByAgeProfilePivot" width="100%"></div>
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


            /**
             *
             *  "plotly": {
                            autosize: true,
                            width: 750,
                            height: 600
                        },

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
                "colOrder": "key_a_to_z",
                "exclusions": {"ORDER_POS": ["ABDL", "BLCK", "BNDL", "COMP", "DESX", "DOWN", "FAIL", "HOLD", "INSP", "LOCA", "MANL", "OISP", "ROAD", "SHIP", "TCRT", "TRAN", "WDRW"]},
                "inclusions": {"ORDER_POS": ["BOOK", "CUST", "DESH"]},
                "unusedAttrsVertical": 85,
                "autoSortUnusedAttrs": false,
                "showUI": false,
                "sorters": {},
                "rendererName": "Horizontal Stacked Bar Chart",
                "inclusionsInfo": {"ORDER_POS": ["BOOK", "CUST", "DESH"]},
                "aggregatorName": "Sum"
            };
            $("#despOrderTrackingUKRFDByCustomerPivotStackedBar").pivotUI(pivotData, loadedConfig); // render pivot.

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
                "cols": ["ORDER_POS"],
                "rows": ["AGE_PROFILE"],
                "vals": ["TRACK_TONNES"],
                "rowOrder": "value_a_to_z",
                "colOrder": "key_a_to_z",
                "exclusions": {"ORDER_POS": ["ABDL", "BLCK", "BNDL", "COMP", "DESX", "DOWN", "FAIL", "HOLD", "INSP", "LOCA", "MANL", "OISP", "ROAD", "SHIP", "TCRT", "TRAN", "WDRW"]},
                "inclusions": {"ORDER_POS": ["BOOK", "CUST", "DESH"]},
                "unusedAttrsVertical": 85,
                "autoSortUnusedAttrs": false,
                "showUI": false,
                "sorters": {},
                "rendererName": "Horizontal Stacked Bar Chart",
                "inclusionsInfo": {"ORDER_POS": ["BOOK", "CUST", "DESH"]},
                "aggregatorName": "Sum"
            };
            $("#despOrderTrackingUKRFDByAgeProfilePivotStackedBar").pivotUI(pivotData, loadedConfig); // render pivot.

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
                "colOrder": "key_a_to_z",
                "exclusions": {"ORDER_POS": ["ABDL", "BLCK", "BNDL", "COMP", "DESX", "DOWN", "FAIL", "HOLD", "INSP", "LOCA", "MANL", "OISP", "ROAD", "SHIP", "TCRT", "TRAN", "WDRW"]},
                "inclusions": {"ORDER_POS": ["BOOK", "CUST", "DESH"]},
                "unusedAttrsVertical": 85,
                "autoSortUnusedAttrs": false,
                "showUI": false,
                "sorters": {},
                "rendererName": "Table",
                "inclusionsInfo": {"ORDER_POS": ["BOOK", "CUST", "DESH"]},
                "aggregatorName": "Sum"
            };
            $("#despOrderUKRFDByCustomerPivot").pivotUI(pivotData, loadedConfig); // render pivot.

            /**
             * Export orders
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
                "cols": ["ORDER_POS"],
                "rows": ["CUSTOMER_NAME_1"],
                "vals": ["TRACK_TONNES"],
                "rowOrder": "value_a_to_z",
                "colOrder": "key_a_to_z",
                "exclusions": {"ORDER_POS": ["BOOK", "CUST", "DESH", "ABDL", "BLCK", "BNDL", "COMP", "DOWN", "FAIL", "HOLD", "INSP", "LOCA", "MANL", "OISP", "ROAD", "TCRT", "TRAN", "WDRW"]},
                "inclusions": {"ORDER_POS": ["DESX", "SHIP"]},
                "unusedAttrsVertical": 85,
                "autoSortUnusedAttrs": false,
                "showUI": false,
                "sorters": {},
                "rendererName": "Horizontal Stacked Bar Chart",
                "inclusionsInfo": {"ORDER_POS": ["DESX", "SHIP"]},
                "aggregatorName": "Sum"
            };
            $("#despOrderTrackingExportByCustomerPivotStackedBar").pivotUI(pivotData, loadedConfig); // render pivot.

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
                "rows": ["AGE_PROFILE"],
                "vals": ["TRACK_TONNES"],
                "rowOrder": "value_a_to_z",
                "colOrder": "key_a_to_z",
                "exclusions": {"ORDER_POS": ["BOOK", "CUST", "DESH", "ABDL", "BLCK", "BNDL", "COMP", "DOWN", "FAIL", "HOLD", "INSP", "LOCA", "MANL", "OISP", "ROAD", "TCRT", "TRAN", "WDRW"]},
                "inclusions": {"ORDER_POS": ["DESX", "SHIP"]},
                "unusedAttrsVertical": 85,
                "autoSortUnusedAttrs": false,
                "showUI": false,
                "sorters": {},
                "rendererName": "Table",
                "inclusionsInfo": {"ORDER_POS": ["DESX", "SHIP"]},
                "aggregatorName": "Sum"
            };
            $("#despOrderTrackingExportByAgeProfilePivot").pivotUI(pivotData, loadedConfig); // render pivot.

        }
//
        var data = <?php echo $orderTrackingData; ?>;

        BuildPivots(data);

    </script>

@endsection
