@extends('layouts.app')

@section('pageTitle', 'Audit Details')
@section('pageName', 'Audit Details')
@section('css')
    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }

        #chartjs-tooltip {
            opacity: 1;
            position: absolute;
            background: rgba(0, 0, 0, .7);
            color: white;
            border-radius: 3px;
            -webkit-transition: all .1s ease;
            transition: all .1s ease;
            pointer-events: none;
            -webkit-transform: translate(-50%, 0);
            transform: translate(-50%, 0);
        }

        #chartjs-radar{
            width : 60%;
            height: 60%;
        }

        .chartjs-tooltip-key {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin-right: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h2 class="display-3"></h2>
            <div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br/>
                @endif

                <div class="row" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
                    <div class="col-sm-8 offset-sm-2">
                        <h2 class="display-3"></h2>
                        <div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div><br/>
                            @endif


                            <h4>Dept</h4>
                            {{$audit->MocDepartment->department}}
                            <hr/>
                            <h4>Process Area</h4>
                            {{$audit->AuditProcessArea->name}}
                            <hr/>

                            <h4>Auditor</h4>
                            {{$audit->auditorUser->name}}
                            <hr/>

                            <h4>Manager Responsible</h4>
                            {{$audit->managerResponsibleUser->name}}
                            <hr/>

                            <h4>Audit Scores</h4>
                            <div class="d-flex flex-wrap justify-content-center">
                                @php
                                    $totalScore = 0;
                                @endphp
                                @foreach($criteriaScores as $criteriaScore)

                                    <div style="margin:10px;">
                                        {{$criteriaScore->criterias->name}} Audit Criteria
                                        : {{$criteriaScore->score}}</div>
                                    @php
                                        $totalScore += $criteriaScore->score;
                                    @endphp
                                @endforeach

                            </div>
                            <br/>
                            <h5>Audit Score Total {{$totalScore}}</h5>


                                <div id="chartjs-radar" style="margin: auto">
                                    <canvas id="canvas"></canvas>
                                </div>

                            <hr/>
                            <h4>Comments</h4>
                            {{$audit->comments}}


                            <hr/>


                            <table class="table">
                                <thead>
                                <th colspan="4">Agreed Action Plan (Following discussion)</th>
                                </thead>
                                <tr>
                                    <td>Action</td>
                                    <td>Responsibility</td>
                                    <td>Date</td>
                                    <td>Completed</td>
                                </tr>

                                <!-- Inputs -->
                                @for($i = 0; $i < count($auditActions); $i++)
                                    <tr>
                                        <td><textarea readonly="true" name="action[]" cols="45"
                                                      rows="4">{{$auditActions[$i]["action"]}}</textarea></td>
                                        <td>
                                            <select disabled="true" readonly="true" style="width:100%;"
                                                    class="js-example-basic" name="responsibility[]">
                                                <option value="0">Please Select..</option>
                                                @foreach($users as $user)
                                                    <option
                                                        {{($user->id == $auditActions[$i]["responsibility_user_id"] ? "selected" : "")}} value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input readonly="true" type="date" name="action_date[]"
                                                   value="{{$auditActions[$i]["date_to_be_completed_by"]}}"></td>
                                        <td>
                                            <select disabled="true" readonly="true" name="action_completed[]">
                                                <option value="No">No</option>
                                                <option
                                                    {{($auditActions[$i]["completed"] == "Yes" ? "selected" : "")}} value="Yes">
                                                    Yes
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    @endfor

                                    </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        @endsection



        @section('functionalScripts')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>

                <script>

                    var healthAndSafetyScore = <?php echo $auditScoresKeyedByCriteria["Health & Safety"]["score"];  ?>;
                    var environmentScore = <?php echo $auditScoresKeyedByCriteria["Environment"]["score"];  ?>;
                    var procedureScore = <?php echo $auditScoresKeyedByCriteria["Procedure"]["score"];  ?>;
                    var fiveSScore = <?php echo $auditScoresKeyedByCriteria["5S"]["score"];  ?>;
                    var visualManagementScore = <?php echo $auditScoresKeyedByCriteria["Visual Management"]["score"];  ?>;
                    var inspectionScore = <?php echo $auditScoresKeyedByCriteria["Inspection"]["score"];  ?>;
                    var trainingAndCompetenceScore = <?php echo $auditScoresKeyedByCriteria["Training & Competence"]["score"];  ?>;

                window.chartColors = {
                    red: 'rgb(255, 99, 132)',
                    orange: 'rgb(255, 159, 64)',
                    yellow: 'rgb(255, 205, 86)',
                    green: 'rgb(75, 192, 192)',
                    blue: 'rgb(54, 162, 235)',
                    purple: 'rgb(153, 102, 255)',
                    grey: 'rgb(231,233,237)'
                };

                window.randomScalingFactor = function () {
                    return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
                }

                var randomScalingFactor = function () {
                    return Math.round(Math.random() * 100);
                };




                var color = Chart.helpers.color;
                var config = {
                    type: 'radar',
                    data: {
                        labels: [
                            "Health & Safety", "Environment", "Procedure", "5S", "Visual Management", "Inspection", "Training & Competence"],
                        datasets: [{
                            label: "Audit Score",
                            backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
                            borderColor: window.chartColors.blue,
                            pointBackgroundColor: window.chartColors.blue ,
                            data: [healthAndSafetyScore, environmentScore, procedureScore, fiveSScore, visualManagementScore, inspectionScore, trainingAndCompetenceScore],
                            notes: ["", "", "", "", "", "", ""]
                        }]
                    },
                    options: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: ''
                        },
                        scale: {
                            ticks: {
                                beginAtZero: true
                            }
                        },
                        tooltips: {
                            enabled: false,
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    //This will be the tooltip.body
                                    return datasetLabel + ': ' + tooltipItem.yLabel + ': ' + data.datasets[tooltipItem.datasetIndex].notes[tooltipItem.index];
                                }
                            },
                            custom: function (tooltip) {
                                // Tooltip Element
                                var tooltipEl = document.getElementById('chartjs-tooltip');
                                if (!tooltipEl) {
                                    tooltipEl = document.createElement('div');
                                    tooltipEl.id = 'chartjs-tooltip';
                                    tooltipEl.innerHTML = "<table></table>"
                                    document.body.appendChild(tooltipEl);
                                }
                                // Hide if no tooltip
                                if (tooltip.opacity === 0) {
                                    tooltipEl.style.opacity = 0;
                                    return;
                                }
                                // Set caret Position
                                tooltipEl.classList.remove('above', 'below', 'no-transform');
                                if (tooltip.yAlign) {
                                    tooltipEl.classList.add(tooltip.yAlign);
                                } else {
                                    tooltipEl.classList.add('no-transform');
                                }

                                function getBody(bodyItem) {
                                    return bodyItem.lines;
                                }

                                // Set Text
                                if (tooltip.body) {
                                    var titleLines = tooltip.title || [];
                                    var bodyLines = tooltip.body.map(getBody);
                                    var innerHtml = '<thead>';
                                    titleLines.forEach(function (title) {
                                        innerHtml += '<tr><th>' + title + '</th></tr>';
                                    });
                                    innerHtml += '</thead><tbody>';
                                    bodyLines.forEach(function (body, i) {
                                        var colors = tooltip.labelColors[i];
                                        var style = 'background:' + colors.backgroundColor;
                                        style += '; border-color:' + colors.borderColor;
                                        style += '; border-width: 2px';
                                        var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
                                        innerHtml += '<tr><td>' + span + body + '</td></tr>';
                                    });
                                    innerHtml += '</tbody>';
                                    var tableRoot = tooltipEl.querySelector('table');
                                    tableRoot.innerHTML = innerHtml;
                                }
                                var position = this._chart.canvas.getBoundingClientRect();
                                // Display, position, and set styles for font
                                tooltipEl.style.opacity = 1;
                                tooltipEl.style.left = position.left + tooltip.caretX + 'px';
                                tooltipEl.style.top = position.top + tooltip.caretY + 'px';
                                tooltipEl.style.fontFamily = tooltip._fontFamily;
                                tooltipEl.style.fontSize = tooltip.fontSize;
                                tooltipEl.style.fontStyle = tooltip._fontStyle;
                                tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
                            }
                        }
                    }
                };
                window.onload = function () {
                    window.myRadar = new Chart(document.getElementById("canvas"), config);
                };
                var colorNames = Object.keys(window.chartColors);


            </script>

@endsection
