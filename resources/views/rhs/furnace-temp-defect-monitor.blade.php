@extends('layouts.app')

@section('pageTitle', 'Furnace Temp Defect Monitor')
@section('pageName', 'Furnace Temp Defect Monitor')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <style>
        #furnace-defect-actioned-tbl_wrapper {
            width: 100%;
        }
    </style>
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

    <div class="row">
        <div class="col-xl-12 col-lg-12">

            <table id="furnace-defect-monitor-tbl" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <th>Section Number</th>
                <th>Condition</th>
                <th>S1</th>
                <th>S2</th>
                <th>WT</th>
                <th>Grade</th>
                <th>Quality</th>
                <th>Date Time Found</th>
                <th>CON_NO</th>
                <th>READINGS</th>
                <th>MIN</th>
                <th>MAX</th>
                <th>MEAN</th>
                <th>DATETIME</th>
                <th>Mean Seg 1</th>
                <th>Mean Seg 2</th>
                <th>Mean Seg 3</th>
                <th>Mean Seg 4</th>
                <th>Mean Seg 5</th>
                <th>View Chart</th>
                <th>Shift</th>
                <th>Action</th>
                <th>Comments</th>
                <th>Apply</th>
                </thead>
                <tbody>

                @php
                    $condCodeArray = ["27" => "Under Temp", "28" => "Over Temp", "29" => "Both"]
                @endphp

                @foreach($defectsArrayKeyedBySection as $key => $defect)
                    <tr data-sectionno="{{$defect["TRACK_CODE_KEY2"]}}"
                        data-thickness="{{$defect["BLOCK_THICK"]}}"
                        data-tempdefect="{{$condCodeArray[trim($defect["CONDITION_CODE"])]}}"
                        data-size1="{{$defect["PIPE_SIZE1"]}}"
                        data-size2="{{$defect["PIPE_SIZE2"]}}"
                        data-datetime_defect_found="{{$defect["DATETIME_TANDEM"]}}"
                                                                >
                        <td>{{$defect["TRACK_CODE_KEY2"]}}</td>
                        <td>{{$defect["CONDITION_CODE"]}} - ({{$condCodeArray[trim($defect["CONDITION_CODE"])]}})</td>
                        <td>{{$defect["PIPE_SIZE1"]}}</td>
                        <td>{{$defect["PIPE_SIZE2"]}}</td>
                        <td>{{$defect["BLOCK_THICK"]}}</td>
                        <td>{{$defect["BLOCK_GRADE"]}}</td>
                        <td>{{$defect["COIL_QUALITY"]}}</td>
                        <td>{{$defect["DATETIME_TANDEM"]}}</td>
                        <td>{{(isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? $furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["CON_NO"] : "PLC DATA NOT FOUND")}}</td>
                        <td>{{(isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? $furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["READINGS"] : "PLC DATA NOT FOUND")}}</td>
                        <td>{{(isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? $furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MIN_FILTER"] : "PLC DATA NOT FOUND")}}</td>
                        <td>{{(isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? $furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MAX_FILTER"] : "PLC DATA NOT FOUND")}}</td>
                        <td>{{(isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? $furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER"] : "PLC DATA NOT FOUND")}}</td>
                        <td>{{(isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? $furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["TIME_STAMP"] : "PLC DATA NOT FOUND")}}</td>

                        <td {{ (isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? (($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_1"]) < 800 || ($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_1"]) > 1025 ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }} ">{{(isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? $furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_1"] : "PLC DATA NOT FOUND")}}</td>
                        <td {{ (isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? (($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_2"]) < 800 || ($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_2"]) > 1025 ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }} ">{{ (isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? $furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_2"] : "PLC DATA NOT FOUND")}}</td>
                        <td {{ (isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? (($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_3"]) < 800 || ($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_3"]) > 1025 ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }} ">{{(isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? $furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_3"] : "PLC DATA NOT FOUND")}}</td>
                        <td {{ (isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? (($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_4"]) < 800 || ($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_4"]) > 1025 ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }} ">{{(isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? $furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_4"] : "PLC DATA NOT FOUND")}}</td>
                        <td {{ (isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? (($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_5"]) < 800 || ($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_5"]) > 1025 ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }} ">{{(isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? $furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["MEAN_FILTER_SEG_5"] : "PLC DATA NOT FOUND")}}</td>
                        <td>
                            <a href="{{$rootUrl . '/rhs/section-furnace-trace?sectionNo=' . (isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? $furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["CON_NO"] : '') .'&weekNo=' . (isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? $furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["WEEK_NO"] : '') . '&yearNo=' .(isset($furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]) ? $furnacePlcArray[trim($defect["TRACK_CODE_KEY2"])]["YEAR_NO"] : '') }} ">View
                                ></a></td>

                        <td><select name="shift">
                                <option value="">Select</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select></td>
                        <td><select name="action">
                                <option value="">Select</option>
                                <option value="Accept">Accept</option>
                                <option value="J2H">J2H</option>
                                <option value="Scrap">Scrap</option>
                            </select></td>
                        <td><textarea name="comments"></textarea></td>
                        <td>
                            <button class="btn btn-primary apply-action">Apply</button>
                        </td>
                    </tr>
                @endforeach


                </tbody>
                <tfoot>
                <th>Section Number</th>
                <th>Condition</th>
                <th>S1</th>
                <th>S2</th>
                <th>WT</th>
                <th>Grade</th>
                <th>Quality</th>
                <th>Date Time Found</th>
                <th>CON_NO</th>
                <th>READINGS</th>
                <th>MIN</th>
                <th>MAX</th>
                <th>MEAN</th>
                <th>DATETIME</th>
                <th>Mean Seg 1</th>
                <th>Mean Seg 2</th>
                <th>Mean Seg 3</th>
                <th>Mean Seg 4</th>
                <th>Mean Seg 5</th>
                <th>View Chart</th>
                <th>Shift</th>
                <th>Action</th>
                <th>Comments</th>
                <th>Apply</th>
                </tfoot>
            </table>


{{--            <div class="text-right">--}}
{{--                <button class="btn btn-primary">Apply to all</button>--}}
{{--            </div>--}}
        </div>


    </div>
    <hr/>
    <h3>Actioned Sections</h3>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
        <table id="furnace-defect-actioned-tbl" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <th>Section Number</th>
            <th>Shift</th>
            <th>DateTimeActioned</th>
            <th>DateTimeFound</th>
            <th>Action</th>
            <th>Thickness</th>
            <th>Temp Defect</th>
            <th>Size 1</th>
            <th>Size 2</th>
            <th>Comments</th>
            </thead>
            <tbody>
            @foreach($furnaceDefectAttributeData as $furnaceDefectActioned)
                <tr>
                    <td>{{$furnaceDefectActioned->section_no}}</td>
                    <td>{{$furnaceDefectActioned->shift}}</td>
                    <td>{{$furnaceDefectActioned->created_at}}</td>
                    <td>{{$furnaceDefectActioned->datetime_defect_found}}</td>
                    <td>{{$furnaceDefectActioned->action}}</td>
                    <td>{{$furnaceDefectActioned->thickness}}</td>
                    <td>{{$furnaceDefectActioned->temp_defect}}</td>
                    <td>{{$furnaceDefectActioned->size1}}</td>
                    <td>{{$furnaceDefectActioned->size2}}</td>
                    <td>{{$furnaceDefectActioned->comments}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <th>Section Number</th>
            <th>Shift</th>
            <th>DateTimeActioned</th>
            <th>DateTimeFound</th>
            <th>Action</th>
            <th>Thickness</th>
            <th>Temp Defect</th>
            <th>Size 1</th>
            <th>Size 2</th>
            <th>Comments</th>
            </tfoot>
        </table>

        </div>
    </div>

@endsection
@section('functionalScripts')

    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    {{--            <!-- Extension scripts for datatables print functionality -->--}}
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // const labelObject = [];
        var globalTable;

        globalTable = $('#furnace-defect-actioned-tbl').DataTable({
            dom: 'Bfrtip',
            buttons: ['print', 'excel'],
            "order": [[2, "desc"]]
        });

        // // Strip values and build arrays
        // function FormatDataAndBuildCharts(json) {
        //     const minArray = [];
        //     const maxArray = [];
        //     const meanArray = [];
        //     const avgArray = [];
        //     const lowerLimitArray = [];
        //     const upperLimitArray = [];
        //     let i = 0;
        //     // strip labels from json to array
        //     Object.keys(json).forEach(function (k) {
        //         labelObject[i] = json[k].SECTION_NO;
        //         minArray.push({x: i, y: json[k].MIN_TEMP});
        //         maxArray.push({x: i, y: json[k].MAX_TEMP});
        //         meanArray.push({x: i, y: json[k].MEAN_TEMP})
        //         avgArray.push({x: i, y: json[k].AVG_TEMP})
        //         lowerLimitArray.push({x: i, y: 800});
        //         upperLimitArray.push({x: i, y: 1025});
        //         i++;
        //     });
        //
        //     var minMaxLineChart = RenderLineWithFocusChart('rhsFurnaceMinMaxTempsLineChart',
        //         'lineWithFocus',
        //         labelObject, [
        //             {values: minArray, key: 'MIN', color: '#FFCD56'},
        //             {values: maxArray, key: 'MAX', color: '#FF9F40'},
        //             {values: lowerLimitArray, key: 'LOWER_LIMIT', color: '#FF6384'},
        //             {values: upperLimitArray, key: 'UPPER_LIMIT', color: '#FF6384'}
        //         ],
        //         'Degrees',
        //         true,
        //         'Date',
        //         true,
        //         true);
        //
        //     var meanLineChart = RenderLineWithFocusChart('rhsFurnaceMeanLineChart',
        //         'lineWithFocus',
        //         labelObject, [
        //             {values: meanArray, key: 'MEAN', color: '#FF9F40'},
        //             {values: lowerLimitArray, key: 'LOWER_LIMIT', color: '#FF6384'},
        //             {values: upperLimitArray, key: 'UPPER_LIMIT', color: '#FF6384'}
        //         ],
        //         'Degrees',
        //         true,
        //         'Date',
        //         true,
        //         true);
        // }
        //
        // function BuildTable(data) {
        //
        // }
        //
        //

        // When page loads, request current weeks data and populate dashboard.

        function RegenerateActionedTable(data) {
            var rows = BuildTableRows(data.furnaceStatRawData);
            InjectTableRows(rows);
            InitiateTable();
        }

        function BuildTableRows(data) {

            console.log(data.length);

            var tablesRows = "";
            data.forEach(function (value) {
                console.log(value.section_no);
            // console.log(key, value);
                tablesRows += "<tr>" +
                    "<td>" + value.section_no + "</td>" +
                    "<td>" + value.shift + "</td>" +
                    "<td>" + value.created_at + "</td>" +
                    "<td>" + value.action + "</td>" +
                    "<td>" + value.thickness + "</td>" +
                    "<td>" + (value.temp_defect == null ? "" : value.temp_defect) + "</td>" +
                    "<td>" + (value.size1 == null ? "" : value.size1) + "</td>" +
                    "<td>" + (value.size2 == null ? "" : value.size2) + "</td>" +
                    "<td>" + (value.comments == null ? "" : value.comments) + "</td>" +
                    "</tr>";
            });

            return tablesRows;
        }

        function InjectTableRows(rows) {
            $('#furnace-defect-actioned-tbl').find('tbody').empty();
            $('#furnace-defect-actioned-tbl').find('tbody').append(rows);
        }

        function InitiateTable() {
            globalTable = $('#furnace-defect-actioned-tbl').DataTable({
                dom: 'Bfrtip',
                buttons: ['print', 'excel'],
                "order": [[2, "desc"]]
            });
        }

        $('.apply-action').click(function () {
            console.log("clicked");

            // console.log($(this).closest("tr").find("select[name='shift']").val());
            // console.log($(this).closest("tr").find("select[name='action']").val());
            // console.log($(this).closest("tr").find("textarea[name='comments']").val());
            // console.log($(this).closest("tr").data('sectionno'));

            var sectionno = $(this).closest("tr").data('sectionno');
            var shift = $(this).closest("tr").find("select[name='shift']").val();
            var action = $(this).closest("tr").find("select[name='action']").val();
            var comments = $(this).closest("tr").find("textarea[name='comments']").val();
            var thickness = $(this).closest("tr").data('thickness');
            var tempdefect = $(this).closest("tr").data('tempdefect');
            var size1 = $(this).closest("tr").data('size1');
            var size2 = $(this).closest("tr").data('size2');
            var datetimeDefectFound = $(this).closest("tr").data('datetime_defect_found');

            if (shift == "" || action == "") {
                Swal.fire(
                    'Data Missing!',
                    'Please check inputs for this section',
                    'error'
                )
            } else {
                console.log("Submit data.");

                $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                $.ajax({
                    type: 'POST',
                    url: rootUrl + '/api/saveFurnaceTempDefectAction',
                    data: {"shift": shift, "action": action, "comments": comments, "sectionNo": sectionno,
                        "thickness" : thickness, "tempDefect" : tempdefect, "size1" : size1, "size2" : size2, "datetime_defect_found" : datetimeDefectFound},
                    success: function (data) {
                        console.log(data);
                        if (data.success) {
                            Swal.fire(
                                'Saved',
                                '',
                                'success'
                            )
                        }
                    },
                    complete: function () {
                        $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                        RemoveActionedSectionFromTbl(sectionno);
                        RegenerateActionedTable();
                    }
                });
            }

            // Swal.fire({
            //     title: 'Are you sure?',
            //     text: "You won't be able to revert this!",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Yes, delete it!'
            // }).then((result) => {
            //     if (result.value) {
            //         this.submit();
            //     }
            // })
        });

        function RemoveActionedSectionFromTbl(sectionNo) {
            var sectionRow = $('tr[data-sectionno="' + sectionNo + '"]');
            sectionRow.remove();
            console.log(sectionRow);
        }

        function RegenerateActionedTable(data) {
            var furnaceDefectAttributeData;

            $.ajax({
                type: 'POST',
                url: rootUrl + '/api/getFurnaceTempDefectAction',
                success: function (data) {
                    console.log(data);
                    furnaceDefectAttributeData = data.furnaceDefectAttributeData;
                    var rows = BuildTableRows(furnaceDefectAttributeData);
                    // console.log(rows);
                    InjectTableRows(rows);
                    // InitiateTable();
                }
            });
        }
    </script>
@endsection
