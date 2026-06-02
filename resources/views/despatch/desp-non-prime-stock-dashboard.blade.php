@extends('layouts.app')

@section('pageTitle', 'Desp Non Prime Stock Dashboard')
@section('pageName', 'Desp Non Prime Stock Dashboard')

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
    <h2>Non Prime Stock Dashboard</h2>
</div>


<div style="display: flex; flex-wrap: wrap;">

    <div class="dashboardContainer" style="display: flex;">
        <div class="dashboard-flex-card" style="margin: 1em;">
            <h3 style="text-align: center;text-decoration: underline;margin-top: 10px;">Age Profiled Non Prime Stock By
                Process Route
                Bar</h3>
            <div id="despNonPrimeStockAgeProfilePRPivot" width="100%"></div>
        </div>
    </div>

    <div class="dashboardContainer" style="display: flex;">
        <div class="dashboard-flex-card" style="margin: 1em;">
            <h3 style="text-align: center;text-decoration: underline;margin-top: 10px;">Age Profiled Non Prime Stock By
                Process Route / Size</h3>
            <div id="despNonPrimeStockAgeProfilePRSizeStackedBar" width="100%"></div>
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
                "hiddenAttributes": ["LENGTH_CATEGORY", "UNTYPE_IND", "COL_CAT", "ACCEPT_CANCEL", "RELEASE_RESULT", "STOCK_XREF", "DIG_OUT_IND"],
                "hiddenFromAggregators": [],
                "hiddenFromDragDrop": [],
                "menuLimit": 100,
                "cols": ["AGE_PROFILE_AT_MONTH_END"],
                "rows": ["PROCESS_ROUTE"],
                "vals": ["T_WEIGHT"],
                "rowOrder": "key_a_to_z",
                "colOrder": "key_a_to_z",
                "exclusions": {},
                "inclusions": {},
                "unusedAttrsVertical": 85,
                "autoSortUnusedAttrs": false,
                "onRefresh": null,
                "showUI": false,
                "sorters": {},
                "rendererName": "Table",
                "inclusionsInfo": {},
                "aggregatorName": "Sum"
            };
            $("#despNonPrimeStockAgeProfilePRPivot").pivotUI(pivotData, loadedConfig); // render pivot.


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
                "hiddenAttributes": ["LENGTH_CATEGORY", "UNTYPE_IND", "COL_CAT", "ACCEPT_CANCEL", "RELEASE_RESULT", "STOCK_XREF", "DIG_OUT_IND"],
                "hiddenFromAggregators": [],
                "hiddenFromDragDrop": [],
                "menuLimit": 100,
                "cols": ["AGE_PROFILE_AT_MONTH_END"],
                "rows": ["PROCESS_ROUTE", "PIPE_SIZE1", "PIPE_SIZE2"],
                "vals": ["T_WEIGHT"],
                "rowOrder": "value_a_to_z",
                "colOrder": "key_a_to_z",
                "exclusions": {},
                "inclusions": {},
                "unusedAttrsVertical": 85,
                "autoSortUnusedAttrs": false,
                "onRefresh": null,
                "showUI": false,
                "sorters": {},
                "rendererName": "Horizontal Stacked Bar Chart",
                "inclusionsInfo": {},
                "aggregatorName": "Sum"
            };
            $("#despNonPrimeStockAgeProfilePRSizeStackedBar").pivotUI(pivotData, loadedConfig); // render pivot.


        }

        //
        var data = <?php echo $nonPrimeTrackingData; ?>;

        BuildPivots(data);

    </script>

@endsection
