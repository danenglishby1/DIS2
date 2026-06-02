@extends('layouts.app')

@section('pageTitle', 'Gauge Change Details')
@section('pageName', 'Gauge Change Details')
@section('content')


    <div class="row ml-3 mr-3">
        <form method="post" action="{{ route('wm-gauge-change.update', $gaugeChange["id"]) }}"
              enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="d-flex flex-wrap justify-content-center"
                 style="margin-bottom: 20px;background: #ececec;padding: 5px;border-radius: 10px;">

                <div class="form-group m-1">
                    <label for="week_no">Week (WW)</label>
                    <input type="number" id="weekNo" maxlength="2" class="form-control" required name="week_no"
                           value="{{$gaugeChange["week_no"]}}" readonly/>
                </div>

                <div class="form-group m-1">
                    <label for="coil_no">Coil</label>
                    <input type="text" id="coilNo" maxlength="3" class="form-control" required name="coil_no"
                           value="{{$gaugeChange["coil_no"]}}" readonly/>
                </div>

                <div class="form-group m-1">
                    <label for="diameter">Diameter</label>
                    <input type="number" id="diameter" step="any" class="form-control" required name="diameter"
                           value="{{$gaugeChange["diameter"]}}" readonly/>
                </div>

                <div class="form-group m-1">
                    <label for="thickness">Thickness</label>
                    <input type="number" step="any" id="thickness" class="form-control" required name="thickness"
                           value="{{$gaugeChange["thickness"]}}" readonly/>
                </div>

                <div class="form-group m-1">
                    <label for="quality">Quality</label>
                    <input type="string" id="quality" class="form-control" required name="quality"
                           value="{{$gaugeChange["quality"]}}" readonly/>
                </div>
            </div>

            <div class="d-flex">
                <div style="border: 1px solid #ccc;border-radius:3px;margin: 1em;padding:1em;min-width:300px">
                    <h3 style="width:100%;">Milled Width</h3>
                    <div class="d-flex flex-wrap">

                        {{-- Loop in milled width inputs --}}
                        @foreach($gaugeChangeAreaVariables["Milled Width"] as $value)
                            <div class="form-group" style="width:95%">
                                @if($value["variable"]["variable_name"] == "Milled Width Comments")
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <textarea readonly rows="6" class="form-control"
                                              name="{{$value["areaVariableId"]}}">{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}</textarea>

                                @else
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <input readonly type="text" class="form-control" name="{{$value["areaVariableId"]}}"
                                           value="{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div style="border: 1px solid #ccc;border-radius:3px;margin: 1em;padding:1em;min-width:300px">
                    <h3 style="width:100%;">Forming</h3>
                    <div class="d-flex flex-wrap">

                        @foreach($gaugeChangeAreaVariables["Forming"] as $value)
                            <div class="form-group" style="width:95%">
                                @if($value["variable"]["variable_name"] == "Forming Comments")
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <textarea readonly rows="6" class="form-control"
                                              name="{{$value["areaVariableId"]}}">{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}</textarea>

                                @else
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <input readonly type="text" class="form-control" name="{{$value["areaVariableId"]}}"
                                           value="{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div style="border: 1px solid #ccc;border-radius:3px;margin: 1em;padding:1em;min-width:300px">
                    <h3 style="width:100%;">Fins/Weld Station</h3>
                    <div class="d-flex flex-wrap">

                        @foreach($gaugeChangeAreaVariables["Fins/Welding Station"] as $value)
                            <div class="form-group" style="width:95%">
                                @if($value["variable"]["variable_name"] == "Fins/Weld Station Comments")
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <textarea readonly rows="6" class="form-control"
                                              name="{{$value["areaVariableId"]}}">{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}</textarea>

                                    {{--  Add skelp gap values and skelp gap calculations --}}
                                @elseif($value["variable"]["variable_name"] == "Skelp Gap A (800)")
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <input readonly type="text" class="form-control" name="{{$value["areaVariableId"]}}"
                                           value="{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}">

                                    @php
                                        $radCalcSkelp800 = round(rad2deg(asin($gaugeChangeVariableData[$value["areaVariableId"]]["value"]/800)), 3);
                                    @endphp

                                    @if($radCalcSkelp800 >= 4 && $radCalcSkelp800 <= 6)
                                        <span
                                            style="background: #1cc88a;padding: 4px;display: block;margin-top: 3px;border-radius: 3px;font-weight: bold;">{{$radCalcSkelp800}}&deg;</span>
                                    @else
                                        <span
                                            style="background: #f6c23e;padding: 4px;display: block;margin-top: 3px;border-radius: 3px;font-weight: bold;">{{$radCalcSkelp800}}&deg;</span>
                                    @endif
                                @elseif($value["variable"]["variable_name"] == "Skelp Gap B (120)")
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <input readonly type="text" class="form-control" name="{{$value["areaVariableId"]}}"
                                           value="{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}">

                                    @php
                                        $radCalcSkelp120 = round(rad2deg(asin($gaugeChangeVariableData[$value["areaVariableId"]]["value"]/120)),3);
                                    @endphp

                                    @if($radCalcSkelp120 >= 4 && $radCalcSkelp120 <= 6)
                                        <span
                                            style="background: #1cc88a;padding: 4px;display: block;margin-top: 3px;border-radius: 3px;font-weight: bold;">{{$radCalcSkelp120}}&deg;</span>
                                    @else
                                        <span
                                            style="background: #f6c23e;padding: 4px;display: block;margin-top: 3px;border-radius: 3px;font-weight: bold;">{{$radCalcSkelp120}}&deg;</span>
                                    @endif
                                @else
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <input readonly type="text" class="form-control" name="{{$value["areaVariableId"]}}"
                                           value="{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div style="border: 1px solid #ccc;border-radius:3px;margin: 1em;padding:1em;min-width:300px;">
                    <h3 style="width:100%;">Sizing</h3>
                    <div class="d-flex flex-wrap">

                        @foreach($gaugeChangeAreaVariables["Sizing"] as $value)
                            <div class="form-group" style="width:95%">
                                @if($value["variable"]["variable_name"] == "Sizing Comments")
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <textarea readonly rows="6" class="form-control"
                                              name="{{$value["areaVariableId"]}}">{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}</textarea>

                                @else
                                    <label>{{$value["variable"]["variable_name"]}}</label>
                                    <input readonly type="text" class="form-control" name="{{$value["areaVariableId"]}}"
                                           value="{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <a href="{{ route('wm-gauge-change.edit',$gaugeChange["id"])}}" class="btn btn-warning mb-2 mt-2 p-2">Edit
                This Gauge Change</a>




@endsection
