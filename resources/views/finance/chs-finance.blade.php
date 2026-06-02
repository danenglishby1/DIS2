@extends('layouts.app')

@section('pageTitle', 'CHS Finance')
@section('pageName', 'CHS Finance')
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

    <div class="simpleflex justify-content-center">
        <div class="btn-flex mt-2 text-center">
            @section('overrideStartEndDate')

                start = moment().subtract(2, 'months').startOf('month');
                end = moment().endOf('month');

                var urlParams = new URLSearchParams(window.location.search);
                var dtFrom = urlParams.get('dtFrom');
                var dtTo = urlParams.get('dtTo');

                if (dtFrom !== null) {
                start = moment(dtFrom);
                end = moment(dtTo);
                }



                window.dtFrom = start.format('Y-MM-DD 00:00:01');
                window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.
            @endsection
            @section('dateRangePickerOnApplyCallback')


                window.dtFrom = dtFrom;
                window.dtTo = dtTo;

                window.location.href = rootUrl + "/finance/chs-finance?dtFrom="+dtFrom+"&dtTo="+dtTo;

            @endsection
            <div class="filters">
                @include('layouts.templates.daterangepicker')
            </div>
        </div>
    </div>

    <div class="simpleflex" style="overflow: scroll;">
        <table class="table" id="financialTable">

            <thead>
            <th>Month</th>
            <th>WeekMonth</th>
            <th>Worked Days</th>
            <th>Worked Hours</th>
            <th>Activity Stops</th>
            <th>Total Stops</th>
            <th>Changing Stops</th>
            <th>Eng Stops</th>
            <th>Productions Stops</th>
            <th>Total Stop Time</th>
            <th>Available Run Time</th>
            <th>STD</th>
            <th>Tonnes</th>
            <th>STD Wk Time</th>
            <th>Stops STDS</th>
            <th>STD production Time</th>
            <th>Prod STD</th>
            <th>C/O STD</th>
            <th>Eng c/o</th>
            <th>Activity Std</th>
            <th>ActivManned Hrs</th>
            <th>ActivManned Cost</th>
            <th>ActivVariance Hrs</th>
            <th>ActivVariance Cost</th>
            <th>StopVariance Hr</th>
            <th>StopVariance Cost</th>
            <th>SpeedOfWork Hr</th>
            <th>SpeedOfWork Cost</th>
            <th>C/O Impact Hr</th>
            <th>C/O Impact Cost</th>


            </thead>
            <tbody>
            @foreach($stoppagesByMonthWeek as $key => $value)
                @php
                    $activtySTD = (80 * $standardsArray["activityStandard"]); // uses hours
                    $stopsStd = (80 - $activtySTD) * $standardsArray["allowableStopsStandard"]; // uses hours
                    $totalStopsExclActivity = ((isset($value["items"]["Activity"]["hoursStopped"]) ? $value["items"]["Activity"]["hoursStopped"] : 0)
                    + (isset($value["items"]["Changing"]["hoursStopped"]) ? $value["items"]["Changing"]["hoursStopped"] : 0)
                    + (isset($value["items"]["Prod"]["hoursStopped"]) ? $value["items"]["Prod"]["hoursStopped"] : 0)
                    + (isset($value["items"]["Eng"]["hoursStopped"]) ? $value["items"]["Eng"]["hoursStopped"] : 0));
                    $totalStopTimeInclActivity = ((isset($value["items"]["Changing"]["hoursStopped"]) ? $value["items"]["Changing"]["hoursStopped"] : 0)
                    + (isset($value["items"]["Prod"]["hoursStopped"]) ? $value["items"]["Prod"]["hoursStopped"] : 0)
                    + (isset($value["items"]["Eng"]["hoursStopped"]) ? $value["items"]["Eng"]["hoursStopped"] : 0));
                    $availableRunTime = (80 - $totalStopsExclActivity); // uses hours
                @endphp
                <tr>
                    <td>{{substr($key, 0 ,3)}}</td> <!-- Month -->
                    <td id="{{$key}}">{{$key}}</td> <!-- WeekMonth -->
                    <td><input type="number" class="daysWorked" value="5"></td>  <!-- Worked Days -->
                    <td><input type="number" class="hoursWorked" value="80"></td>  <!-- Worked Hours -->
                    <td class="activityStopHours">{{(isset($value["items"]["Activity"]["hoursStopped"]) ? $value["items"]["Activity"]["hoursStopped"] : 0)}}</td>
                    <!-- Activity Stops -->
                    <td class="totalStopsInclActivityHours">{{$totalStopTimeInclActivity}}</td>
                    <!-- Total Stops Including Activity -->
                    <td class="changingStopHours">{{(isset($value["items"]["Changing"]["hoursStopped"]) ? $value["items"]["Changing"]["hoursStopped"] : 0)}}</td>
                    <!-- Changing Stops -->
                    <td class="engineeringStopHours">{{(isset($value["items"]["Eng"]["hoursStopped"]) ? $value["items"]["Eng"]["hoursStopped"] : 0)}}</td> <!-- Eng Stops -->
                    <td class="productionStopHours">{{(isset($value["items"]["Prod"]["hoursStopped"]) ? $value["items"]["Prod"]["hoursStopped"] : 0)}}</td>
                    <!-- Production Stops -->
                    <td class="totalStopExclActivityHours">{{$totalStopsExclActivity}}</td>
                    <!-- Total Stops excl activity -->
                    <td style="background: #ffda97" class="availableRunTimeHours">{{$availableRunTime}}</td>
                    <!-- Available Run Time -->
                    <td class="stdHours">{{round((isset($speedStandards[$key]["time"]) ? $speedStandards[$key]["time"]  : 0),2) }}</td>
                    <!-- STD -->
                    <td class="tonnes">{{round((isset($speedStandards[$key]["tonnes"]) ? $speedStandards[$key]["tonnes"]  : 0),2) }}</td>
                    <!-- Tonnes -->

                    <td style="background: #ffda97" class="stdWorkedTimeHours">{{80 - $activtySTD}}</td>
                    <!-- STD WK Time -->
                    <td style="background: #ffda97" style="background: #ffda97"
                        class="stopStandardHours">{{$stopsStd}}</td> <!-- Stops STD -->
                    <td style="background: #ffda97"
                        class="standardProductionTimeHours">{{(80 - $activtySTD) * $standardsArray["availabilityStandard"] }}</td>
                    <!-- STD Production Time -->
                    <td style="background: #ffda97"
                        class="productionStandardHours">{{(80 - $activtySTD) * $standardsArray["productionStandard"]}}</td>
                    <!-- Prod Standard -->
                    <td style="background: #ffda97"
                        class="changeoverStandardHours">{{(80 - $activtySTD) * $standardsArray["changeoverStandard"]}}</td>
                    <!-- Changeover Standard -->
                    <td style="background: #ffda97"
                        class="engChangeOverStandardHours">{{(80 - $activtySTD) * $standardsArray["engStandard"]}}</td>
                    <!-- Eng c/o Standard -->
                    <td style="background: #ffda97" class="activityStandardHours">{{$activtySTD}}</td>
                    <!-- Activity Standard -->

                    <td style="background: antiquewhite" class="activityVarianceMannedHours"><input type="number"
                                                                                                    class="activityVarianceMannedHoursInput"
                                                                                                    value="0"></td>
                    <!-- ActivManned hrs  -->
                    <td style="background: antiquewhite"
                        class="activityVarianceMannedCost">{{(0 *$standardsArray["availabilityStandard"] * $standardsArray["standardCost"])}}</td>
                    <!-- ActivManned £  -->

                    <td style="background: antiquewhite"
                        class="activityVarianceHours">{{ round( ($activtySTD - (isset($value["items"]["Activity"]["hoursStopped"]) ? $value["items"]["Activity"]["hoursStopped"] : 0) ),2)}}</td>
                    <!-- Activity hrs  -->
                    <td style="background: antiquewhite" class="activityVarianceHoursCost">
                        {{round( ($activtySTD - (isset($value["items"]["Activity"]["hoursStopped"]) ? $value["items"]["Activity"]["hoursStopped"] : 0))  * $standardsArray["standardCost"] ,2) }}</td>
                    <!-- Activity £  -->

                    <td style="background: antiquewhite"
                        class="stopVarianceHours">{{ round(($stopsStd - $totalStopTimeInclActivity),2)}}</td>
                    <!-- Stop Variance hrs  -->
                    <td style="background: antiquewhite" class="stopVarianceCost">
                        {{round( ($stopsStd - $totalStopTimeInclActivity)* $standardsArray["standardCost"],2)}}</td>
                    <!-- Stop Variance £  -->

                    <td style="background: antiquewhite"
                        class="speedOfWorkVarianceHours">{{round(((isset($speedStandards[$key]["time"]) ? $speedStandards[$key]["time"]  : 0) - $availableRunTime),2) }}</td>
                    <!-- Speed of work Variance hrs  -->
                    <td style="background: antiquewhite" class="speedOfWorkVarianceCost">
                        {{round( ((isset($speedStandards[$key]["time"]) ? $speedStandards[$key]["time"]  : 0) - $availableRunTime)* $standardsArray["standardCost"],2)}}</td>
                    <!-- Speed of work Variance £  -->

                    <td style="background: antiquewhite" style="background: #ffda97"
                        class="changeoverImpactVarianceHours">{{round(((80 - $activtySTD) * $standardsArray["changeoverStandard"] - (isset($value["items"]["Changing"]["hoursStopped"]) ? $value["items"]["Changing"]["hoursStopped"] : 0) ),2)}}</td>
                    <!-- Changeover impact Variance hrs  -->
                    <td style="background: antiquewhite" style="background: #ffda97"
                        class="changeoverImpactVarianceCost">
                        {{round(((80 - $activtySTD) * $standardsArray["changeoverStandard"] - (isset($value["items"]["Changing"]["hoursStopped"]) ? $value["items"]["Changing"]["hoursStopped"] : 0)) * $standardsArray["standardCost"],2) }}</td>
                    <!-- Changeover impact Variance £  -->
                </tr>
            @endforeach
            <tr>
                <td>Holidays</td>
                <td></td> <!-- WeekMonth -->
                <td><input type="number" class="holidaysCount" value="0"></td>  <!-- Worked Days -->
                <td></td>  <!-- Worked Hours -->
                <td class="activityStopHours"></td> <!-- Activity Stops -->
                <td class="totalStopsInclActivityHours"></td> <!-- Total Stops Including Activity -->
                <td class="changingStopHours"></td> <!-- Changing Stops -->
                <td class="engineeringStopHours"></td> <!-- Eng Stops -->
                <td class="productionStopHours"></td> <!-- Production Stops -->
                <td class="totalStopExclActivityHours"></td> <!-- Total Stops excl activity -->
                <td style="background: #ffda97" class="availableRunTimeHours"></td> <!-- Available Run Time -->
                <td class="stdHours"></td> <!-- STD -->
                <td class="tonnes"></td> <!-- Tonnes -->

                <td style="background: #ffda97" class="stdWorkedTimeHours"></td> <!-- STD WK Time -->
                <td style="background: #ffda97" style="background: #ffda97" class="stopStandardHours"></td>
                <!-- Stops STD -->
                <td style="background: #ffda97" class="standardProductionTimeHours"></td> <!-- STD Production Time -->
                <td style="background: #ffda97" class="productionStandardHours"></td> <!-- Prod Standard -->
                <td style="background: #ffda97" class="changeoverStandardHours"></td> <!-- Changeover Standard -->
                <td style="background: #ffda97" class="engChangeOverStandardHours"></td> <!-- Eng c/o Standard -->
                <td style="background: #ffda97" class="activityStandardHours"></td> <!-- Activity Standard -->

                <td style="background: antiquewhite" class="activityVarianceMannedHours">0</td>
                <!-- ActivManned hrs  -->
                <td style="background: antiquewhite" class="activityVarianceMannedCost">0</td> <!-- ActivManned £  -->

                <td style="background: antiquewhite" class="activityVarianceHours"></td> <!-- Activity hrs  -->
                <td style="background: antiquewhite" class="activityVarianceHoursCost"></td> <!-- Activity £  -->

                <td style="background: antiquewhite" class="stopVarianceHours"></td> <!-- Stop Variance hrs  -->
                <td style="background: antiquewhite" class="stopVarianceCost"></td> <!-- Stop Variance £  -->

                <td style="background: antiquewhite" class="speedOfWorkVarianceHours"></td>
                <!-- Speed of work Variance hrs  -->
                <td style="background: antiquewhite" class="speedOfWorkVarianceCost"></td>
                <!-- Speed of work Variance £  -->

                <td style="background: antiquewhite" style="background: #ffda97"
                    class="changeoverImpactVarianceHours"></td> <!-- Changeover impact Variance hrs  -->
                <td style="background: antiquewhite" style="background: #ffda97"
                    class="changeoverImpactVarianceCost"></td> <!-- Changeover impact Variance £  -->
            </tr>
            </tbody>
        </table>

    </div>

    <div id="summary" style="margin-top: 3em;">

    </div>

@endsection
@section('functionalScripts')

    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="{{ asset('public/js/parseTable.js')}}"></script>
    <script src="{{ asset('public/libraries/lodash/lodash.js')}}"></script>

    <script>

        $('#totalMannedHours, #standardTotalMannedHours').keyup(function () {
            console.log("up");
            $('#recalculateButton').css('display', 'block');
        });


        // On recalculation button click, submit manually updated hours and dtfrom/to from range picker to controller to recalculate
        // with new variables.
        $('#recalculateButton').click(function () {
            console.log("Submit");
            console.log(window.dtFrom);
        });

        var stdCost = 5616;
        var availabilityStandard = 0.65;
        var stopsStandard = 0.35;
        var productionStandard = 0.08;
        var changeoverStandard = 0.18;
        var engineeringStandard = 0.09;
        var activityStandard = 0.08;


        $('.hoursWorked').keyup(function () {
            var hours = $(this).val();
            var totalStopsExclActivity = (parseFloat($(this).closest('tr').find('td.activityStopHours')[0].innerHTML) + parseFloat($(this).closest('tr').find('td.changingStopHours')[0].innerHTML) + parseFloat($(this).closest('tr').find('td.productionStopHours')[0].innerHTML) + parseFloat($(this).closest('tr').find('td.engineeringStopHours')[0].innerHTML));
            var totalStopTimeInclActivity = (parseFloat($(this).closest('tr').find('td.changingStopHours')[0].innerHTML) + parseFloat($(this).closest('tr').find('td.productionStopHours')[0].innerHTML) + parseFloat($(this).closest('tr').find('td.engineeringStopHours')[0].innerHTML));

            console.log(totalStopsExclActivity);

            var activityStd = hours * activityStandard;
            var stopsStd = (hours - activityStd) * stopsStandard;
            var availableRunTime = (hours - totalStopsExclActivity); // uses hours
            console.log($(this).val());

            // Update values in row
            console.info($(this).closest('tr').find('td.availableRunTimeHours'));
            $(this).closest('tr').find('td.availableRunTimeHours').html(availableRunTime.toFixed(2));
            $(this).closest('tr').find('td.stdWorkedTimeHours').html((hours - activityStd).toFixed(2));
            $(this).closest('tr').find('td.stopStandardHours').html((stopsStd).toFixed(2));
            $(this).closest('tr').find('td.standardProductionTimeHours').html(((hours - activityStd) * availabilityStandard).toFixed(2));
            $(this).closest('tr').find('td.productionStandardHours').html(((hours - activityStd) * productionStandard).toFixed(2));
            $(this).closest('tr').find('td.changeoverStandardHours').html(((hours - activityStd) * changeoverStandard).toFixed(2));
            $(this).closest('tr').find('td.engChangeOverStandardHours').html(((hours - activityStd) * engineeringStandard).toFixed(2));
            $(this).closest('tr').find('td.activityStandardHours').html((activityStd).toFixed(2));

            //Variances
            $(this).closest('tr').find('td.activityVarianceHours').html((activityStd - parseFloat($(this).closest('tr').find('td.activityStopHours')[0].innerHTML)).toFixed(2));
            $(this).closest('tr').find('td.activityVarianceHoursCost').html((parseFloat($(this).closest('tr').find('td.activityVarianceHours')[0].innerHTML) * stdCost).toFixed(2));

            $(this).closest('tr').find('td.stopVarianceHours').html((stopsStd - totalStopTimeInclActivity).toFixed(2));
            $(this).closest('tr').find('td.stopVarianceCost').html(((stopsStd - totalStopTimeInclActivity) * stdCost).toFixed(2));

            $(this).closest('tr').find('td.speedOfWorkVarianceHours').html((parseFloat($(this).closest('tr').find('td.stdHours')[0].innerHTML) - availableRunTime).toFixed(2));
            $(this).closest('tr').find('td.speedOfWorkVarianceCost').html((parseFloat($(this).closest('tr').find('td.speedOfWorkVarianceHours')[0].innerHTML) * stdCost).toFixed(2));

            $(this).closest('tr').find('td.changeoverImpactVarianceHours').html((((hours - activityStd) * changeoverStandard - parseFloat($(this).closest('tr').find('td.changingStopHours')[0].innerHTML))).toFixed(2));
            $(this).closest('tr').find('td.changeoverImpactVarianceCost').html((parseFloat($(this).closest('tr').find('td.changeoverImpactVarianceHours')[0].innerHTML) * stdCost).toFixed(2));
            UpdateMonthlyTotals();
        });


        $('.activityVarianceMannedHoursInput').keyup(function () {
            console.log($(this).val())
            $(this).closest('tr').find('td.activityVarianceMannedCost').html((parseFloat($(this).val()) * availabilityStandard * stdCost).toFixed(2));
            UpdateMonthlyTotals();
        });

        $('.holidaysCount').keyup(function () {
            $(this).closest('tr').find('td.activityVarianceMannedHours').html((parseFloat($(this).val()) * 16).toFixed(2));
            $(this).closest('tr').find('td.activityVarianceMannedCost').html((parseFloat(($(this).val() * 16) * stdCost)).toFixed(2));
        });


        function UpdateMonthlyTotals() {
            var table = document.querySelector("table");
            var output = document.querySelector("pre");
            var tableData = parseTable(table);
            console.info(tableData);

            var groupedByMonth = CalculateGroupedByMonth(tableData);
            var summedTotals = CalculateSumTotals(tableData);

            var summaryTable = BuildSummaryTable(groupedByMonth, summedTotals);
            $('#summary').html(summaryTable);
            AddMonthRowsToSummaryTable();
            CalculateTotalsOfMainTable();
            CalculateTotalsOfSummaryTable(tableData);
        }

        function CalculateGroupedByMonth(tableData) {
            var groupedByMonth =
                _(tableData)
                    .groupBy('Month')
                    .map((objs, key) => ({
                        'Month': key,
                        'Worked Days': _.sumBy(objs, item => Number(item['Worked Days'])),
                        'Worked Hours': _.sumBy(objs, item => Number(item['Worked Hours'])),
                        'Total Stops': _.sumBy(objs, item => Number(item['Total Stops'])),
                        'Total Stop Time': _.sumBy(objs, item => Number(item['Total Stop Time'])),
                        'Tonnes': _.sumBy(objs, item => Number(item['Tonnes'])),
                        'Stops STDS': _.sumBy(objs, item => Number(item['Stops STDS'])),
                        'StopVariance Cost': _.sumBy(objs, item => Number(item['StopVariance Cost'])),
                        'StopVariance Hr': _.sumBy(objs, item => Number(item['StopVariance Hr'])),
                        'SpeedOfWork Cost': _.sumBy(objs, item => Number(item['SpeedOfWork Cost'])),
                        'SpeedOfWork Hr': _.sumBy(objs, item => Number(item['SpeedOfWork Hr'])),
                        'STD production Time': _.sumBy(objs, item => Number(item['STD production Time'])),
                        'STD Wk Time': _.sumBy(objs, item => Number(item['STD Wk Time'])),
                        'STD': _.sumBy(objs, item => Number(item['STD'])),
                        'Productions Stops': _.sumBy(objs, item => Number(item['Productions Stops'])),
                        'Prod STD': _.sumBy(objs, item => Number(item['Prod STD'])),
                        'Eng c/o': _.sumBy(objs, item => Number(item['Eng c/o'])),
                        'Eng Stops': _.sumBy(objs, item => Number(item['Eng Stops'])),
                        'Changing Stops': _.sumBy(objs, item => Number(item['Changing Stops'])),
                        'C/O STD': _.sumBy(objs, item => Number(item['C/O STD'])),
                        'C/O Impact Hr': _.sumBy(objs, item => Number(item['C/O Impact Hr'])),
                        'C/O Impact Cost': _.sumBy(objs, item => Number(item['C/O Impact Cost'])),
                        'Available Run Time': _.sumBy(objs, item => Number(item['Available Run Time'])),
                        'Activity Stops': _.sumBy(objs, item => Number(item['Activity Stops'])),
                        'Activity Std': _.sumBy(objs, item => Number(item['Activity Std'])),
                        'ActivVariance Cost': _.sumBy(objs, item => Number(item['ActivVariance Cost'])),
                        'ActivVariance Hrs': _.sumBy(objs, item => Number(item['ActivVariance Hrs'])),
                        'ActivManned Cost': _.sumBy(objs, item => Number(item['ActivManned Cost'])),
                        'ActivManned Hrs': _.sumBy(objs, item => Number(item['ActivManned Hrs'])),
                    }))
                    .value();
            groupedByMonth = _.keyBy(groupedByMonth, "Month");
            console.log(groupedByMonth);

            return groupedByMonth;
        }

        function CalculateSumTotals(tableData) {
            var summedTotals =
                _(tableData)
                    .groupBy()
                    .map((objs, key) => ({
                        'Month': "Totals",
                        'Worked Days': _.sumBy(objs, item => Number(item['Worked Days'])),
                        'Worked Hours': _.sumBy(objs, item => Number(item['Worked Hours'])),
                        'Total Stops': _.sumBy(objs, item => Number(item['Total Stops'])),
                        'Total Stop Time': _.sumBy(objs, item => Number(item['Total Stop Time'])),
                        'Tonnes': _.sumBy(objs, item => Number(item['Tonnes'])),
                        'Stops STDS': _.sumBy(objs, item => Number(item['Stops STDS'])),
                        'StopVariance Cost': _.sumBy(objs, item => Number(item['StopVariance Cost'])),
                        'StopVariance Hr': _.sumBy(objs, item => Number(item['StopVariance Hr'])),
                        'SpeedOfWork Cost': _.sumBy(objs, item => Number(item['SpeedOfWork Cost'])),
                        'SpeedOfWork Hr': _.sumBy(objs, item => Number(item['SpeedOfWork Hr'])),
                        'STD production Time': _.sumBy(objs, item => Number(item['STD production Time'])),
                        'STD Wk Time': _.sumBy(objs, item => Number(item['STD Wk Time'])),
                        'STD': _.sumBy(objs, item => Number(item['STD'])),
                        'Productions Stops': _.sumBy(objs, item => Number(item['Productions Stops'])),
                        'Prod STD': _.sumBy(objs, item => Number(item['Prod STD'])),
                        'Eng c/o': _.sumBy(objs, item => Number(item['Eng c/o'])),
                        'Eng Stops': _.sumBy(objs, item => Number(item['Eng Stops'])),
                        'Changing Stops': _.sumBy(objs, item => Number(item['Changing Stops'])),
                        'C/O STD': _.sumBy(objs, item => Number(item['C/O STD'])),
                        'C/O Impact Hr': _.sumBy(objs, item => Number(item['C/O Impact Hr'])),
                        'C/O Impact Cost': _.sumBy(objs, item => Number(item['C/O Impact Cost'])),
                        'Available Run Time': _.sumBy(objs, item => Number(item['Available Run Time'])),
                        'Activity Stops': _.sumBy(objs, item => Number(item['Activity Stops'])),
                        'Activity Std': _.sumBy(objs, item => Number(item['Activity Std'])),
                        'ActivVariance Cost': _.sumBy(objs, item => Number(item['ActivVariance Cost'])),
                        'ActivVariance Hrs': _.sumBy(objs, item => Number(item['ActivVariance Hrs'])),
                        'ActivManned Cost': _.sumBy(objs, item => Number(item['ActivManned Cost'])),
                        'ActivManned Hrs': _.sumBy(objs, item => Number(item['ActivManned Hrs'])),
                    }))
                    .value();

            console.log(summedTotals);

            return summedTotals;
        }

        function AddMonthRowsToMainTable(tableData) {
            var currentMonth = tableData[0].Month;
            var dayTotal = 0;


            // for (var i = 0; i < tableData.length; i++) {
            //
            //     if (currentMonth == tableData[i].Month) {
            //         dayTotal += parseFloat(tableData[i]["Worked Days"]);
            //     } else {
            //         console.log(tableData[i - 1].Month, dayTotal);
            //         var html = BuildHtmlMonthRow(groupedByMonth[tableData[i - 1].Month]);
            //
            //         $('#financialTable > tbody > tr').eq(i - 1).after().html(html).attr('class', 'monthSubTotals');
            //         dayTotal = 5;
            //     }
            //     currentMonth = tableData[i].Month;
            // }

        }


        function BuildSummaryTable(groupedByMonthSumTotals, sumTotals) {
            var html = "<table class='table' id='summaryTablel'>" +
                "<thead><th></th><th>Activity</th><th>Stops</th><th>Speeds</th><th>Changeover Impact</th></thead>" +
                "<tbody>";

            for (const [key, value] of Object.entries(groupedByMonthSumTotals)) {
                if (key !== "Holidays") {
                    html += "<tr>" +
                        "<td>" + key + "</td>" +
                        "<td>" + Math.round(value["ActivVariance Cost"] + value["ActivManned Cost"]) + "</td>" +
                        "<td>" + Math.round(value["StopVariance Cost"]) + "</td>" +
                        "<td>" + Math.round(value["SpeedOfWork Cost"]) + "</td>" +
                        "<td>" + Math.round(value["C/O Impact Cost"]) + "</td>" +
                        "</tr>";
                }
            }

            for (var i = 0; i < sumTotals.length; i++) {
                html += "<tr style='border-top:2px dashed #333'>" +
                    "<td>SumTotal</td>" +
                    "<td>" + Math.round(sumTotals[i]["ActivVariance Cost"] + sumTotals[i]["ActivManned Cost"]) + "</td>" +
                    "<td>" + Math.round(sumTotals[i]["StopVariance Cost"]) + "</td>" +
                    "<td>" + Math.round(sumTotals[i]["SpeedOfWork Cost"]) + "</td>" +
                    "<td>" + Math.round(sumTotals[i]["C/O Impact Cost"]) + "</td>" +
                    "</tr>";
            }

            html += "</tbody></table>"

            return html;
        }


        var table = document.querySelector("table");
        var output = document.querySelector("pre");
        var tableData = parseTable(table);
        UpdateMonthlyTotals();
        console.info(tableData);
        // AddMonthRowsToMainTable(tableData);


        // unused


        function BuildHtmlMonthRow(groupedByMonthData) {
            console.info(groupedByMonthData);
            var html = '<td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;">' + groupedByMonthData["Month"] + '</td>' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;"></td> <!-- WeekMonth -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;">' + groupedByMonthData["Worked Days"] + '</td>  <!-- Worked Days -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;">' + groupedByMonthData["Worked Hours"] + '</td>  <!-- Worked Hours -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="activityStopHours">' + groupedByMonthData["Activity Stops"] + '</td> <!-- Activity Stops -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="totalStopsInclActivityHours">' + groupedByMonthData["Total Stops"] + '</td> <!-- Total Stops Including Activity -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="changingStopHours">' + groupedByMonthData["Changing Stops"] + '</td> <!-- Changing Stops -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="engineeringStopHours">' + groupedByMonthData["Eng Stops"] + '</td> <!-- Eng Stops -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="productionStopHours">' + groupedByMonthData["Productions Stops"] + '</td> <!-- Production Stops -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="totalStopExclActivityHours">' + groupedByMonthData["Total Stop Time"] + '</td> <!-- Total Stops excl activity -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" style="background: #ffda97" class="availableRunTimeHours">' + groupedByMonthData["Available Run Time"] + '</td> <!-- Available Run Time -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="stdHours">' + groupedByMonthData["STD"] + '</td> <!-- STD -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="tonnes">' + groupedByMonthData["Tonnes"] + '</td> <!-- Tonnes -->' +
                '' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="stdWorkedTimeHours">' + groupedByMonthData["STD Wk Time"] + '</td> <!-- STD WK Time -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" style="background: #ffda97" class="stopStandardHours">' + groupedByMonthData["Stops STDS"] + '</td>' +
                '                <!-- Stops STD -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="standardProductionTimeHours">' + groupedByMonthData["STD production Time"] + '</td> <!-- STD Production Time -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="productionStandardHours">' + groupedByMonthData["Prod STD"] + '</td> <!-- Prod Standard -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="changeoverStandardHours">' + groupedByMonthData["C/O STD"] + '</td> <!-- Changeover Standard -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="engChangeOverStandardHours">' + groupedByMonthData["Eng c/o"] + '</td> <!-- Eng c/o Standard -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="activityStandardHours">' + groupedByMonthData["Activity Std"] + '</td> <!-- Activity Standard -->' +
                '' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="activityVarianceMannedHours">' + groupedByMonthData["ActivManned Hrs"] + '</td> <!-- ActivManned hrs  -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="activityVarianceMannedCost">' + groupedByMonthData["ActivManned Cost"] + '</td> <!-- ActivManned £  -->' +
                '' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="activityVarianceHours">' + groupedByMonthData["ActivVariance Hrs"] + '</td> <!-- Activity hrs  -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="activityVarianceHoursCost">' + groupedByMonthData["ActivVariance Cost"] + '</td> <!-- Activity £  -->' +
                '' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="stopVarianceHours">' + groupedByMonthData["StopVariance Hr"] + '</td> <!-- Stop Variance hrs  -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="stopVarianceCost">' + groupedByMonthData["StopVariance Cost"] + '</td> <!-- Stop Variance £  -->' +
                '' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="speedOfWorkVarianceHours">' + groupedByMonthData["SpeedOfWork Hr"] + '</td>' +
                '                <!-- Speed of work Variance hrs  -->#ffda97' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;" class="speedOfWorkVarianceCost">' + groupedByMonthData["SpeedOfWork Cost"] + '</td>' +
                '                <!-- Speed of work Variance £  -->' +
                '' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;"style="background: #ffda97"' +
                '                    class="changeoverImpactVarianceHours">' + groupedByMonthData["C/O Impact Hr"] + '</td> <!-- Changeover impact Variance hrs  -->' +
                '                <td style="background: #efefef; border-bottom: 2px dashed #505050; border-top: 2px dashed #505050;"" style="background: #ffda97"' +
                '                    class="changeoverImpactVarianceCost">' + groupedByMonthData["C/O Impact Cost"] + '</td> <!-- Changeover impact Variance £  -->'
            return html;
        }

        function AddMonthRowsToSummaryTable() {

        }

        function CalculateTotalsOfMainTable() {

        }

        function CalculateTotalsOfSummaryTable() {

        }
    </script>
@endsection
