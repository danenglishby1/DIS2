@extends('layouts.app')

@section('pageTitle', 'TPM Summary')
@section('pageName', 'TPM Summary')
@section('tpmActiveLink', 'active activeUnderline')
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
</div>
</div> -->
    <!-- Content Row -->

    <div class="simpleflex justify-content-center">
        <div class="btn-flex mt-2 text-center">
            <div class="filters" style="margin-top: -75px;">
                <div class="form-group">
                    <label>Date From</label>
                    <input type="date" class="form-control" id="dtFrom">
                </div>
                <div class="form-group" style="margin-left: 10px;">
                    <label>Date To</label>
                    <input type="date" class="form-control" id="dtTo">
                </div>

                <div class="form-group" style="margin-left: 10px;">
                    <label>Test Piece</label>
                    <select class="form-control" id="tpIdentifier">
                        @foreach($testPieceIdentifiers as $identifier)
                            <option value="{{$identifier["identifier"]}}">{{$identifier["identifier"]}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <button id="getDataButton" class="btn btn-primary" style="margin-top: 30px;margin-left: 10px;">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div style="width: 100px;position: absolute; right: 10px; top: 115px;">
        <label>Bins:</label>
        <input class="form-control" id="bins" value="15" type="number">
    </div>

    <div class="simpleflex">

        <div id="chart" style="width: 100%; height:350px;">
            <svg></svg>
        </div>

        <div id="myDiv"></div>
    </div>

<hr />
    <h4>Filters </h4>
    <div class="simpleflex" style="justify-content: center;">

        <div class="form-group">
            <label>Roll Week</label>
            <select class="form-control" id="rollWeek">
                <option></option>
            </select>
        </div>

        <div class="form-group">
            <label>Block OD</label>
            <select class="form-control" id="blockOd">
                <option></option>
            </select>
        </div>

        <div class="form-group">
            <label>Block Thick</label>
            <select class="form-control" id="blockThick">
                <option></option>
            </select>
        </div>
        <div class="form-group">
            <label>Grade</label>
            <select class="form-control" id="grade">
                <option></option>
            </select>
        </div>
        <div class="form-group">
            <label>Process Route</label>
            <select class="form-control" id="pr">
                <option></option>
            </select>
        </div>
        <div class="form-group">
            <label>CastNo</label>
            <select class="form-control" id="castNo">
                <option></option>
            </select>
        </div>
    </div>

    <a href="#" style="display:block;text-align: center;" id="clearFilters">Clear Filters</a>

    <div class="mb-4"></div>
@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/libraries/lodash/lodash.js')}}"></script>

    <script>

        var globalData = "";
        var globalBins = 15;


        function FillSelectOptions(data, blockThickSelectActive, blockODSelectActive, gradeSelectActive, prSelectActive, castNoActive, rollWeekActive) {
            console.log("filtering");

            $('.ajax-loader').css("display", "block");
            $('#blockThick').find('option').remove();
            $('#blockOd').find('option').remove();
            $('#grade').find('option').remove();
            $('#pr').find('option').remove();
            $('#castNo').find('option').remove();
            $('#rollWeek').find('option').remove();

            var blockThick = [];
            var blockOD = [];
            var grade = [];
            var pr = [];
            var castNo = [];
            var rollWeek = [];
            for (var i=0;i< data.length;i++){
                blockThick.push(data[i].BLOCK_THICK);
                blockOD.push(data[i].BLOCK_OD);
                grade.push(data[i].BLOCK_GRADE);
                pr.push(data[i].PROCESS_ROUTE);
                castNo.push(data[i].CAST_NO);
                rollWeek.push(data[i].ROLL_WEEK);

            }
            blockThick = _.uniq(blockThick);
            blockOD = _.uniq(blockOD);
            grade = _.uniq(grade);
            pr = _.uniq(pr);
            castNo = _.uniq(castNo);
            rollWeek = _.uniq(rollWeek);

            var option = (blockODSelectActive == false ? '<option value="">Please Select..</option>' : '');
            for (var i=0;i< blockOD.length;i++){
                option += '<option value="'+ blockOD[i] + '">' + blockOD[i] + '</option>';
            }
            $('#blockOd').append(option);

            option = (blockThickSelectActive == false ? '<option value="">Please Select..</option>' : '');
            for (var i=0;i< blockThick.length;i++){
                option += '<option value="'+ blockThick[i] + '">' + blockThick[i] + '</option>';
            }
            $('#blockThick').append(option);

            option = (gradeSelectActive == false ? '<option value="">Please Select..</option>' : '');
            for (var i=0;i< grade.length;i++){
                option += '<option value="'+ grade[i] + '">' + grade[i] + '</option>';
            }
            $('#grade').append(option);

            option = (prSelectActive == false ? '<option value="">Please Select..</option>' : '');
            for (var i=0;i< pr.length;i++){
                option += '<option value="'+ pr[i] + '">' + pr[i] + '</option>';
            }
            $('#pr').append(option);

            option = (castNoActive == false ? '<option value="">Please Select..</option>' : '');
            for (var i=0;i< castNo.length;i++){
                option += '<option value="'+ castNo[i] + '">' + castNo[i] + '</option>';
            }
            $('#castNo').append(option);

            option = (rollWeekActive == false ? '<option value="">Please Select..</option>' : '');
            for (var i=0;i< rollWeek.length;i++){
                option += '<option value="'+ rollWeek[i] + '">' + rollWeek[i] + '</option>';
            }
            $('#rollWeek').append(option);

            $('.ajax-loader').css("display", "none");
        }


        function RecalculateDataDistribution(filteredData) {
            console.log(filteredData);
            var lowerCtrlLimit = parseFloat(filteredData[0].LOWER_CNTRL_LIMIT);
            var upperCtrlLimit = parseFloat(filteredData[0].UPPER_CNTRL_LIMIT);

            console.log(lowerCtrlLimit);
            console.log(upperCtrlLimit);

            var values = [];

            for (var i = 0; i < filteredData.length; i++) {
                values.push(parseFloat(filteredData[i].ACTUAL_RESULT_1));
            }

            console.log(values);
            var histGenerator = d3.layout.histogram()
                .range([lowerCtrlLimit, upperCtrlLimit])    // Set the domain to cover the entire intervall [0;]
                .bins(globalBins);  // number of thresholds; this will create 19+1 bins

            var bins = histGenerator(values);
            console.log(bins);

            // data
            var distributionValues = [];
            var binsArray = [];

            for (var i = 0; i < bins.length; i++) {
                distributionValues.push({
                    "label": bins[i].x.toFixed(3) + " - " + (bins[i].x + bins[i].dx).toFixed(3),
                    "value": bins[i].y,
                    color: '#4573ff'
                });
                binsArray.push(bins[i].x);

            }

            var chartData = [
                {
                    key: "DistributionData",
                    values: distributionValues
                }
            ]

            return chartData;

        }

    function DrawChart(chartData) {
        nv.addGraph(function () {
            var chart = nv.models.discreteBarChart()
                .x(function (d) {
                    return d.label
                })
                .y(function (d) {
                    return d.value
                })
                .margin({
                    top: 20,
                    right: 20,
                    bottom: 100,
                    left: 55
                })
                .staggerLabels(true)
                .wrapLabels(true)
                .showValues(true);
            // .rotateLabels(90);

            d3.select('#chart svg')
                .datum(chartData)
                .transition().duration(500)
                .call(chart);
            nv.utils.windowResize(chart.update);

            return chart;
        });
    }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    //Listeners

        $('#getDataButton').on('click', function() {
            var dtFrom = $('#dtFrom').val();
            var dtTo = $('#dtTo').val();
            var tpIdentifier = $('#tpIdentifier').val();
            console.log(dtFrom);
            console.log(dtTo);
            $.ajax({
                type: "POST",
                data: {"dtFrom": dtFrom, "dtTo" : dtTo, "tpIdentifier" : tpIdentifier},
                url: rootUrl + "/api/test-result-distribution",
                dataType: "json",
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('.ajax-loader').css("display", "block");
                },
                success: function (json) {
                    data = $.parseJSON(json.testResultsJson);
                    console.log(data);
                    if (data.length > 0)
                    {
                        FillSelectOptions(data, false, false, false, false, false, false);
                        var chartData = RecalculateDataDistribution(data);
                        DrawChart(chartData);
                        globalData = data;
                    }

                },
                complete: function () {
                    $('.ajax-loader').css("display", "none");
                }
            });

        });

        $('#clearFilters').on('click', function() {
            FillSelectOptions(globalData, false, false, false, false, false, false);
            data = RecalculateDataDistribution(globalData);
            DrawChart(data);
        });


        $('#blockOd, #blockThick, #grade, #pr, #castNo, #rollWeek, #bins').on('change', function() {
            var blockOdSelectActive = false;
            var blockThickSelectActive = false;
            var gradeSelectActive = false;
            var prSelectActive = false;
            var castNoActive = false;
            var rollWeekActive = false;

            var filterObj = {};
            if ($('#blockOd').val() !== "") {
                filterObj.BLOCK_OD = $('#blockOd').val();
                blockOdSelectActive = true;
            }
            if ($('#blockThick').val() !== "") {
                filterObj.BLOCK_THICK = $('#blockThick').val();
                blockThickSelectActive = true;
            }
            if ($('#grade').val() !== "") {
                filterObj.BLOCK_GRADE = $('#grade').val();
                gradeSelectActive = true;
            }
            if ($('#pr').val() !== "") {
                filterObj.PROCESS_ROUTE = $('#pr').val();
                prSelectActive = true;
            }
            if ($('#castNo').val() !== "") {
                filterObj.CAST_NO = $('#castNo').val();
                castNoActive = true;
            }
            if ($('#rollWeek').val() !== "") {
                filterObj.ROLL_WEEK = $('#rollWeek').val();
                rollWeekActive = true;
            }


            globalBins = parseInt($('#bins').val());
            console.log(globalBins);

            console.log(filterObj);
            var filtered = _.filter(globalData, filterObj);
            console.log(filtered);
            FillSelectOptions(filtered, blockThickSelectActive, blockOdSelectActive, gradeSelectActive, prSelectActive, castNoActive, rollWeekActive);
            data = RecalculateDataDistribution(filtered);
            DrawChart(data);
        });


    </script>
@endsection
