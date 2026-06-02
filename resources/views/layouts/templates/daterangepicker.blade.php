@section('daterangepickerCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
@endsection


<div id="daterange" class="daterangeControl"
     style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="fa fa-calendar dateRangeIcon"></i>&nbsp;
    <span></span> <i class="fa fa-caret-down"></i>
</div>


@section('daterangepickerScripts')

    <script src="{{ asset('public/libraries/date-range-picker/moment.min.js')}}"></script>
    <script src="{{ asset('public/libraries/date-range-picker/daterangepicker.min.js')}}"></script>

    <script>
        $(function () {

            var start = moment().subtract(1, 'days');
            var end = moment();

            window.dtFrom = start.format('Y-MM-DD 00:00:01');
            window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.
            window.label = "";

            @yield('overrideStartEndDate')

            function cb(start, end) {
                $('#daterange span').html(start.format('DD-MM-Y 00:00:01') + ' - ' + end.format('DD-MM-Y 23:59:59'));
            }

            $('#daterange').daterangepicker({
                startDate: start,
                endDate: end,
                timePicker: true,
                timePicker24Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Prev24': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Prev Week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                    'This Week': [moment().startOf('week'), moment().endOf('week')],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    @yield('dateRangePickerAdditionalRanges')
                },
                locale: {
                    format: 'M/DD hh:mm A'
                }
            }, cb);

            cb(start, end);
        });
        /**
         * Listen for apply being clicked on the date range picker and pass dtfrom and dtto to the GetDataAndBuildCharts function which makes a json call to the api and builds new chart and filter.
         */
        $('#daterange').on('apply.daterangepicker', function (ev, picker) {
            window.label = picker.chosenLabel;
            console.log("LABEL SELECTED " + window.label);



            if (picker.chosenLabel == "Yesterday") {
                var dtFrom = picker.startDate.format('YYYY-MM-DD 00:00:00');
                var dtTo = picker.endDate.format('YYYY-MM-DD 23:59:59');
            } else if (picker.chosenLabel == "Today") {
                var dtFrom = picker.startDate.format('YYYY-MM-DD 00:00:00');
                var dtTo = picker.endDate.format('YYYY-MM-DD 23:59:59');
            }
            else if (picker.chosenLabel == "Custom Range") {
                var dtFrom = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
                var dtTo = picker.endDate.format('YYYY-MM-DD HH:mm:ss');
            }
            else {
                var dtFrom = picker.startDate.format('YYYY-MM-DD 00:00:00');
                var dtTo = picker.endDate.format('YYYY-MM-DD 23:59:59');
            }

            console.log(dtFrom);
            console.log(dtTo);


            @yield('dateRangePickerOnApplyCallback')

        });


    </script>
@endsection



