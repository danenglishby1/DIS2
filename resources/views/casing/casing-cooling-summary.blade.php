@extends('layouts.app')

@section('pageTitle', 'Cooling Summary')
@section('pageName', 'Cooling Summary')
@section('casingActiveLink', 'active activeUnderline')
@section('css')
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
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

    <div class="simpleflex justify-content-center">
        <div class="btn-flex mt-2 text-center">
            @include('layouts.partial.update-date-buttons')
        </div>
    </div>

    <div class="mb-3"></div> <!-- add space -->


    <!-- Content Row -->

    <h2>Cooling Summary</h2>
    <div class="simpleflex">
        <div class="fl1-500">

                <table id="quench-summary-tbl" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>SECTION</th>
                        <th>THICK</th>
                        <th>TIME</th>
                        <th>SERIES</th>
                        <th>READINGS</th>
                        <th>MIN</th>
                        <th>MAX</th>
                        <th>Drop Seg 1</th>
                        <th>Drop Seg 2</th>
                        <th>Drop Seg 3</th>
                        <th>Drop Seg 4</th>
                        <th>Drop Seg 5</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($quenchSummaryArray as $key => $value)
                        {{--{{var_dump($value)}}--}}
                        {{--                    {{ var_dump(isset($value["FAILURES"]) ? $value["FAILURES"]: "PASS")}}--}}
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{$value["SECTION_PROPERTIES"]["THICK"]}}</td>
                            <td>{{$value["SECTION_PROPERTIES"]["TIME_STAMP"]}}</td>
                            <td>QI_North_Pyro</td>
                            <td>{{(isset($value["QI_North_Pyro"]) ? $value["QI_North_Pyro"]["COUNT"] : 0)}}</td>
                            <td>{{(isset($value["QI_North_Pyro"]) ? $value["QI_North_Pyro"]["MIN"] : 0)}}</td>
                            <td>{{(isset($value["QI_North_Pyro"]) ? $value["QI_North_Pyro"]["MAX"] : 0)}}</td>

                            <!--
                            Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours.
                            -->
                            <td {{ (isset($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_1_ACCEPTANCE"]) ?  ($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_1_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_1"]) ? $value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_1"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_2_ACCEPTANCE"]) ?  ($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_2_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_2"]) ? $value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_2"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_3_ACCEPTANCE"]) ?  ($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_3_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_3"]) ? $value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_3"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_4_ACCEPTANCE"]) ?  ($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_4_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_4"]) ? $value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_4"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_5_ACCEPTANCE"]) ?  ($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_5_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_5"]) ? $value["DROPS"]["NORTH_PYRO_DROP_SEGMENT_5"]
                                : 0) }}
                            </td>

                        </tr>

                        <tr>
                            <td>{{$key}}</td>
                            <td>{{$value["SECTION_PROPERTIES"]["THICK"]}}</td>
                            <td>{{$value["SECTION_PROPERTIES"]["TIME_STAMP"]}}</td>
                            <td>QI_South_Pyro</td>
                            <td>{{(isset($value["QI_South_Pyro"]) ? $value["QI_South_Pyro"]["COUNT"] : 0)}}</td>
                            <td>{{(isset($value["QI_South_Pyro"]) ? $value["QI_South_Pyro"]["MIN"] : 0)}}</td>
                            <td>{{(isset($value["QI_South_Pyro"]) ? $value["QI_South_Pyro"]["MAX"] : 0)}}</td>

                            <!--
                            Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours.
                            -->
                            <td {{ (isset($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_1_ACCEPTANCE"]) ?  ($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_1_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_1"]) ? $value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_1"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_2_ACCEPTANCE"]) ?  ($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_2_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_2"]) ? $value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_2"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_3_ACCEPTANCE"]) ?  ($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_3_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_3"]) ? $value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_3"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_4_ACCEPTANCE"]) ?  ($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_4_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_4"]) ? $value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_4"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_5_ACCEPTANCE"]) ?  ($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_5_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_5"]) ? $value["DROPS"]["SOUTH_PYRO_DROP_SEGMENT_5"]
                                : 0) }}
                            </td>

                        </tr>

                        <tr>
                            <td>{{$key}}</td>
                            <td>{{$value["SECTION_PROPERTIES"]["THICK"]}}</td>
                            <td>{{$value["SECTION_PROPERTIES"]["TIME_STAMP"]}}</td>
                            <td>QI_Top_Pyro</td>
                            <td>{{(isset($value["QI_Top_Pyro"]) ? $value["QI_Top_Pyro"]["COUNT"] : 0)}}</td>
                            <td>{{(isset($value["QI_Top_Pyro"]) ? $value["QI_Top_Pyro"]["MIN"] : 0)}}</td>
                            <td>{{(isset($value["QI_Top_Pyro"]) ? $value["QI_Top_Pyro"]["MAX"] : 0)}}</td>

                            <!--
                            Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours.
                            -->
                            <td {{ (isset($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_1_ACCEPTANCE"]) ?  ($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_1_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_1"]) ? $value["DROPS"]["TOP_PYRO_DROP_SEGMENT_1"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_2_ACCEPTANCE"]) ?  ($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_2_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_2"]) ? $value["DROPS"]["TOP_PYRO_DROP_SEGMENT_2"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_3_ACCEPTANCE"]) ?  ($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_3_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_3"]) ? $value["DROPS"]["TOP_PYRO_DROP_SEGMENT_3"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_4_ACCEPTANCE"]) ?  ($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_4_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_4"]) ? $value["DROPS"]["TOP_PYRO_DROP_SEGMENT_4"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_5_ACCEPTANCE"]) ?  ($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_5_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["TOP_PYRO_DROP_SEGMENT_5"]) ? $value["DROPS"]["TOP_PYRO_DROP_SEGMENT_5"]
                                : 0) }}
                            </td>

                        </tr>

                        <tr style="border-bottom: 3px solid">
                            <td>{{$key}}</td>
                            <td>{{$value["SECTION_PROPERTIES"]["THICK"]}}</td>
                            <td>{{$value["SECTION_PROPERTIES"]["TIME_STAMP"]}}</td>
                            <td>QI_Bottom_Pyro</td>
                            <td>{{(isset($value["QI_Bottom_Pyro"]) ? $value["QI_Bottom_Pyro"]["COUNT"] : 0)}}</td>
                            <td>{{(isset($value["QI_Bottom_Pyro"]) ? $value["QI_Bottom_Pyro"]["MIN"] : 0)}}</td>
                            <td>{{(isset($value["QI_Bottom_Pyro"]) ? $value["QI_Bottom_Pyro"]["MAX"] : 0)}}</td>


                            <!--
                            Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours.
                            -->
                            <td {{ (isset($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_1_ACCEPTANCE"]) ?  ($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_1_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_1"]) ? $value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_1"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_2_ACCEPTANCE"]) ?  ($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_2_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_2"]) ? $value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_2"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_3_ACCEPTANCE"]) ?  ($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_3_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_3"]) ? $value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_3"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_4_ACCEPTANCE"]) ?  ($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_4_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_4"]) ? $value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_4"]
                                : 0) }}
                            </td>
                            <td {{ (isset($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_5_ACCEPTANCE"]) ?  ($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_5_ACCEPTANCE"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>
                                {{ (isset($value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_5"]) ? $value["DROPS"]["BOTTOM_PYRO_DROP_SEGMENT_5"]
                                : 0) }}
                            </td>

                        </tr>

                        {{--                    <tr>--}}
                        {{--                        <td>{{$key}}</td>--}}
                        {{--                        <td>{{$value["SECTION_PROPERTIES"]["THICK"]}}</td>--}}
                        {{--                        <td>{{$value["SECTION_PROPERTIES"]["TIME_STAMP"]}}</td>--}}
                        {{--                        <td>QO_North_Pyro</td>--}}
                        {{--                        <td>{{$value["QO_North_Pyro"]["NO_OF_READINGS"]}}</td>--}}
                        {{--                        <td>{{$value["QO_North_Pyro"]["MIN"]}}</td>--}}
                        {{--                        <td>{{$value["QO_North_Pyro"]["MAX"]}}</td>--}}
                        {{--                        <td>{{$value["QO_North_Pyro"]["MEAN_TEMP"]}}</td>--}}
                        {{--                        <!----}}
                        {{--                        Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours.--}}
                        {{--                        -->--}}
                        {{--                        <td {{ (isset($value["NorthPyroDrop1Acceptance"]) ?  ($value["NorthPyroDrop1Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["NorthPyroDrop"]["dropSegment1"]) ? $value["NorthPyroDrop"]["dropSegment1"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["NorthPyroDrop1Acceptance"]) ?  ($value["NorthPyroDrop1Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["NorthPyroDrop"]["dropSegment2"]) ? $value["NorthPyroDrop"]["dropSegment2"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["NorthPyroDrop1Acceptance"]) ?  ($value["NorthPyroDrop1Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["NorthPyroDrop"]["dropSegment3"]) ? $value["NorthPyroDrop"]["dropSegment3"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["NorthPyroDrop1Acceptance"]) ?  ($value["NorthPyroDrop1Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["NorthPyroDrop"]["dropSegment4"]) ? $value["NorthPyroDrop"]["dropSegment4"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["NorthPyroDrop1Acceptance"]) ?  ($value["NorthPyroDrop1Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["NorthPyroDrop"]["dropSegment5"]) ? $value["NorthPyroDrop"]["dropSegment5"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}

                        {{--                    </tr>--}}

                        {{--                    <tr>--}}
                        {{--                        <td>{{$key}}</td>--}}
                        {{--                        <td>{{$value["SECTION_PROPERTIES"]["THICK"]}}</td>--}}
                        {{--                        <td>{{$value["SECTION_PROPERTIES"]["TIME_STAMP"]}}</td>--}}
                        {{--                        <td>QI_South_Pyro</td>--}}
                        {{--                        <td>{{$value["QI_South_Pyro"]["NO_OF_READINGS"]}}</td>--}}
                        {{--                        <td>{{$value["QI_South_Pyro"]["MIN"]}}</td>--}}
                        {{--                        <td>{{$value["QI_South_Pyro"]["MAX"]}}</td>--}}
                        {{--                        <td>{{$value["QI_South_Pyro"]["MEAN_TEMP"]}}</td>--}}
                        {{--                        <!----}}
                        {{--                        Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours.--}}
                        {{--                        -->--}}
                        {{--                        <td {{ (isset($value["SouthPyroDrop1Acceptance"]) ?  ($value["SouthPyroDrop1Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["SouthPyroDrop"]["dropSegment1"]) ? $value["SouthPyroDrop"]["dropSegment1"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["SouthPyroDrop2Acceptance"]) ?  ($value["SouthPyroDrop2Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["SouthPyroDrop"]["dropSegment2"]) ? $value["SouthPyroDrop"]["dropSegment2"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["SouthPyroDrop3Acceptance"]) ?  ($value["SouthPyroDrop3Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["SouthPyroDrop"]["dropSegment3"]) ? $value["SouthPyroDrop"]["dropSegment3"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["SouthPyroDrop4Acceptance"]) ?  ($value["SouthPyroDrop4Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["SouthPyroDrop"]["dropSegment4"]) ? $value["SouthPyroDrop"]["dropSegment4"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["SouthPyroDrop5Acceptance"]) ?  ($value["SouthPyroDrop5Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["SouthPyroDrop"]["dropSegment5"]) ? $value["SouthPyroDrop"]["dropSegment5"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}

                        {{--                    </tr>--}}
                        {{--                    <tr>--}}
                        {{--                        <td>{{$key}}</td>--}}
                        {{--                        <td>{{$value["SECTION_PROPERTIES"]["THICK"]}}</td>--}}
                        {{--                        <td>{{$value["SECTION_PROPERTIES"]["TIME_STAMP"]}}</td>--}}
                        {{--                        <td>QO_South_Pyro</td>--}}
                        {{--                        <td>{{$value["QO_South_Pyro"]["NO_OF_READINGS"]}}</td>--}}
                        {{--                        <td>{{$value["QO_South_Pyro"]["MIN"]}}</td>--}}
                        {{--                        <td>{{$value["QO_South_Pyro"]["MAX"]}}</td>--}}
                        {{--                        <td>{{$value["QO_South_Pyro"]["MEAN_TEMP"]}}</td>--}}
                        {{--                        <!----}}
                        {{--                        Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours.--}}
                        {{--                        -->--}}
                        {{--                        <td {{ (isset($value["SouthPyroDrop1Acceptance"]) ?  ($value["SouthPyroDrop1Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["SouthPyroDrop"]["dropSegment1"]) ? $value["SouthPyroDrop"]["dropSegment1"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["SouthPyroDrop2Acceptance"]) ?  ($value["SouthPyroDrop2Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["SouthPyroDrop"]["dropSegment2"]) ? $value["SouthPyroDrop"]["dropSegment2"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["SouthPyroDrop3Acceptance"]) ?  ($value["SouthPyroDrop3Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["SouthPyroDrop"]["dropSegment3"]) ? $value["SouthPyroDrop"]["dropSegment3"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["SouthPyroDrop4Acceptance"]) ?  ($value["SouthPyroDrop4Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["SouthPyroDrop"]["dropSegment4"]) ? $value["SouthPyroDrop"]["dropSegment4"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["SouthPyroDrop5Acceptance"]) ?  ($value["SouthPyroDrop5Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["SouthPyroDrop"]["dropSegment5"]) ? $value["SouthPyroDrop"]["dropSegment5"]--}}
                        {{--                            : 0) }}--}}
                        {{--                        </td>--}}

                        {{--                    </tr>--}}


                        {{--                    <tr>--}}
                        {{--                        <td>{{$key}}</td>--}}
                        {{--                        <td>{{$value["SECTION_PROPERTIES"]["THICK"]}}</td>--}}
                        {{--                        <td>{{$value["SECTION_PROPERTIES"]["TIME_STAMP"]}}</td>--}}
                        {{--                        <td>QI_Top_Pyro</td>--}}
                        {{--                        <td>{{$value["QI_Top_Pyro"]["NO_OF_READINGS"]}}</td>--}}
                        {{--                        <td>{{$value["QI_Top_Pyro"]["MIN"]}}</td>--}}
                        {{--                        <td>{{$value["QI_Top_Pyro"]["MAX"]}}</td>--}}
                        {{--                        <td>{{$value["QI_Top_Pyro"]["MEAN_TEMP"]}}</td>--}}
                        {{--                        <!----}}
                        {{--                        Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours.--}}
                        {{--                        -->--}}
                        {{--                        <td {{ (isset($value["TopPyroDrop1Acceptance"]) ?  ($value["TopPyroDrop1Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["TopPyroDrop"]["dropSegment1"]) ? $value["TopPyroDrop"]["dropSegment1"] :--}}
                        {{--                            0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["TopPyroDrop2Acceptance"]) ?  ($value["TopPyroDrop2Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["TopPyroDrop"]["dropSegment2"]) ? $value["TopPyroDrop"]["dropSegment2"] :--}}
                        {{--                            0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["TopPyroDrop3Acceptance"]) ?  ($value["TopPyroDrop3Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["TopPyroDrop"]["dropSegment3"]) ? $value["TopPyroDrop"]["dropSegment3"] :--}}
                        {{--                            0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["TopPyroDrop4Acceptance"]) ?  ($value["TopPyroDrop4Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["TopPyroDrop"]["dropSegment4"]) ? $value["TopPyroDrop"]["dropSegment4"] :--}}
                        {{--                            0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["TopPyroDrop5Acceptance"]) ?  ($value["TopPyroDrop5Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["TopPyroDrop"]["dropSegment5"]) ? $value["TopPyroDrop"]["dropSegment5"] :--}}
                        {{--                            0) }}--}}
                        {{--                        </td>--}}

                        {{--                    </tr>--}}
                        {{--                    <tr>--}}
                        {{--                        <td>{{$key}}</td>--}}
                        {{--                        <td>{{$value["SECTION_PROPERTIES"]["THICK"]}}</td>--}}
                        {{--                        <td>{{$value["SECTION_PROPERTIES"]["TIME_STAMP"]}}</td>--}}
                        {{--                        <td>QO_Top_Pyro</td>--}}
                        {{--                        <td>{{$value["QO_Top_Pyro"]["NO_OF_READINGS"]}}</td>--}}
                        {{--                        <td>{{$value["QO_Top_Pyro"]["MIN"]}}</td>--}}
                        {{--                        <td>{{$value["QO_Top_Pyro"]["MAX"]}}</td>--}}
                        {{--                        <td>{{$value["QO_Top_Pyro"]["MEAN_TEMP"]}}</td>--}}
                        {{--                        <!----}}
                        {{--                        Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours.--}}
                        {{--                        -->--}}
                        {{--                        <td {{ (isset($value["TopPyroDrop1Acceptance"]) ?  ($value["TopPyroDrop1Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["TopPyroDrop"]["dropSegment1"]) ? $value["TopPyroDrop"]["dropSegment1"] :--}}
                        {{--                            0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["TopPyroDrop2Acceptance"]) ?  ($value["TopPyroDrop2Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["TopPyroDrop"]["dropSegment2"]) ? $value["TopPyroDrop"]["dropSegment2"] :--}}
                        {{--                            0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["TopPyroDrop3Acceptance"]) ?  ($value["TopPyroDrop3Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["TopPyroDrop"]["dropSegment3"]) ? $value["TopPyroDrop"]["dropSegment3"] :--}}
                        {{--                            0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["TopPyroDrop4Acceptance"]) ?  ($value["TopPyroDrop4Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["TopPyroDrop"]["dropSegment4"]) ? $value["TopPyroDrop"]["dropSegment4"] :--}}
                        {{--                            0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["TopPyroDrop5Acceptance"]) ?  ($value["TopPyroDrop5Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["TopPyroDrop"]["dropSegment5"]) ? $value["TopPyroDrop"]["dropSegment5"] :--}}
                        {{--                            0) }}--}}
                        {{--                        </td>--}}

                        {{--                    </tr>--}}

                        {{--Add thick border to show seperation between sections clearly--}}
                        {{--                    <tr style="border-bottom: 3px solid">--}}
                        {{--                        <td>{{$key}}</td>--}}
                        {{--                        <td>{{$value["SECTION_PROPERTIES"]["THICK"]}}</td>--}}
                        {{--                        <td>{{$value["SECTION_PROPERTIES"]["TIME_STAMP"]}}</td>--}}
                        {{--                        <td>QI_Bottom_Pyro</td>--}}
                        {{--                        <td>{{$value["QI_Bottom_Pyro"]["NO_OF_READINGS"]}}</td>--}}
                        {{--                        <td>{{$value["QI_Bottom_Pyro"]["MIN"]}}</td>--}}
                        {{--                        <td>{{$value["QI_Bottom_Pyro"]["MAX"]}}</td>--}}
                        {{--                        <td>{{$value["QI_Bottom_Pyro"]["MEAN_TEMP"]}}</td>--}}
                        {{--                        <!----}}
                        {{--                        Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours.--}}
                        {{--                        -->--}}
                        {{--                        <td {{ (isset($value["BottomPyroDrop1Acceptance"]) ?  ($value["BottomPyroDrop1Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["BottomPyroDrop"]["dropSegment1"]) ?--}}
                        {{--                            $value["BottomPyroDrop"]["dropSegment1"] : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["BottomPyroDrop2Acceptance"]) ?  ($value["BottomPyroDrop2Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["BottomPyroDrop"]["dropSegment2"]) ?--}}
                        {{--                            $value["BottomPyroDrop"]["dropSegment2"] : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["BottomPyroDrop3Acceptance"]) ?  ($value["BottomPyroDrop3Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["BottomPyroDrop"]["dropSegment3"]) ?--}}
                        {{--                            $value["BottomPyroDrop"]["dropSegment3"] : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["BottomPyroDrop4Acceptance"]) ?  ($value["BottomPyroDrop4Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["BottomPyroDrop"]["dropSegment4"]) ?--}}
                        {{--                            $value["BottomPyroDrop"]["dropSegment4"] : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["BottomPyroDrop5Acceptance"]) ?  ($value["BottomPyroDrop5Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["BottomPyroDrop"]["dropSegment5"]) ?--}}
                        {{--                            $value["BottomPyroDrop"]["dropSegment5"] : 0) }}--}}
                        {{--                        </td>--}}

                        {{--                    </tr>--}}
                        {{--                    <tr>--}}
                        {{--                        <td>{{$key}}</td>--}}
                        {{--                        <td>{{$value["SECTION_PROPERTIES"]["THICK"]}}</td>--}}
                        {{--                        <td>{{$value["SECTION_PROPERTIES"]["TIME_STAMP"]}}</td>--}}
                        {{--                        <td>QO_Bottom_Pyro</td>--}}
                        {{--                        <td>{{$value["QO_Bottom_Pyro"]["NO_OF_READINGS"]}}</td>--}}
                        {{--                        <td>{{$value["QO_Bottom_Pyro"]["MIN"]}}</td>--}}
                        {{--                        <td>{{$value["QO_Bottom_Pyro"]["MAX"]}}</td>--}}
                        {{--                        <td>{{$value["QO_Bottom_Pyro"]["MEAN_TEMP"]}}</td>--}}
                        {{--                        <!----}}
                        {{--                        Inline tenarys to check if mean segments are SET and if mean segments are out of spec,  - MIN 825, MAX 1000. If out of spec, fill bg colours.--}}
                        {{--                        -->--}}
                        {{--                        <td {{ (isset($value["BottomPyroDrop1Acceptance"]) ?  ($value["BottomPyroDrop1Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["BottomPyroDrop"]["dropSegment1"]) ?--}}
                        {{--                            $value["BottomPyroDrop"]["dropSegment1"] : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["BottomPyroDrop2Acceptance"]) ?  ($value["BottomPyroDrop2Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["BottomPyroDrop"]["dropSegment2"]) ?--}}
                        {{--                            $value["BottomPyroDrop"]["dropSegment2"] : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["BottomPyroDrop3Acceptance"]) ?  ($value["BottomPyroDrop3Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["BottomPyroDrop"]["dropSegment3"]) ?--}}
                        {{--                            $value["BottomPyroDrop"]["dropSegment3"] : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["BottomPyroDrop4Acceptance"]) ?  ($value["BottomPyroDrop4Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["BottomPyroDrop"]["dropSegment4"]) ?--}}
                        {{--                            $value["BottomPyroDrop"]["dropSegment4"] : 0) }}--}}
                        {{--                        </td>--}}
                        {{--                        <td {{ (isset($value["BottomPyroDrop5Acceptance"]) ?  ($value["BottomPyroDrop5Acceptance"] == "F" ? 'style=background:#e3342f;color:#ffffff !important;' : '') : '') }}>--}}
                        {{--                            {{ (isset($value["BottomPyroDrop"]["dropSegment5"]) ?--}}
                        {{--                            $value["BottomPyroDrop"]["dropSegment5"] : 0) }}--}}
                        {{--                        </td>--}}

                        {{--                    </tr>--}}

                    @endforeach
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
        </div>
    </div>

                <hr/>
                <h5>Pass/Fail Stats</h5>
                <div class="simpleflex pb-3">
                    <div class="fl1">
                        <h6 style="text-decoration: underline;">Section Count</h6>
                        <span class="section-count">{{$stats["totalSectionCount"]}}</span>
                    </div>
                    <div class="fl1">
                        <h6 style="text-decoration: underline;">Section Fails</h6>
                        <span class="section-count">{{$stats["totalSectionFailures"]}}</span>
                    </div>
                    <div class="fl1">
                        <h6 style="text-decoration: underline;">Failure Rate</h6>
                        <span id="failureRateStat">{{ ( $stats["totalSectionCount"] > 0 ? round((($stats["totalSectionFailures"] / $stats["totalSectionCount"]*100)), 2) : 0)}}%</span>
                    </div>
                    <div class="fl1">
                        <h6 style="text-decoration: underline;">Drop Passes</h6>
                        <span class="quench-drop-passed">{{$stats["totalDropPasses"]}}</span>
                    </div>
                    <div class="fl1">
                        <h6 style="text-decoration: underline;">Drop Fails</h6>
                        <span class="quench-drop-failed">{{$stats["totalDropFails"]}}</span>
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
                <!-- Extension scripts for datatables print functionality -->
                <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
                <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
                <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
                <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>
                <!-- End  Extension scripts for datatables print functionality -->

                <script>
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
// Initialize Data Table
                    $(window).on('load', function() {
                    $('#quench-summary-tbl').DataTable({
                        dom: 'Bfrtip',
                        buttons: ['print', 'excel'],
                        "order": [[2, "DESC"]]
                    });
                    });

                        $('.dateTimeControlButton').on('click', function () {
                            var dateCommand = $(this).data('filtercommand');
                            console.log(dateCommand);

                            var url = rootUrl + "/rhs/quench-summary?dateCommand="+dateCommand;
                            window.location.href = url;
                        });
                </script>

@endsection
