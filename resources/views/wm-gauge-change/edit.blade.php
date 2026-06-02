@extends('layouts.app')

@section('pageTitle', 'Edit WM Gauge Change')
@section('pageName', 'Edit WM Gauge Change')
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
            </div>
        </div>
        <div class="row ml-3 mr-3">
            <form method="post" action="{{ route('wm-gauge-change.update', $gaugeChange["id"]) }}"
                  enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="d-flex flex-wrap justify-content-center"
                     style="margin-bottom: 20px;background: #ececec;padding: 5px;border-radius: 10px;">

                    <div class="form-group m-1">
                        <label for="year_no">Year (YY)</label>
                        <input type="number" id="yearNo" maxlength="2" class="form-control" required name="year_no"
                               value="{{$gaugeChange["year"]}}" readonly/>
                    </div>


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
                                        <textarea rows="6" class="form-control"
                                                  name="{{$value["areaVariableId"]}}">{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}</textarea>

                                    @else
                                        <label>{{$value["variable"]["variable_name"]}}</label>
                                        <input type="text" class="form-control" name="{{$value["areaVariableId"]}}"
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
                                        <textarea rows="6" class="form-control"
                                                  name="{{$value["areaVariableId"]}}">{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}</textarea>

                                    @elseif($value["variable"]["variable_name"] == "Tram Lines")
                                        <label>{{$value["variable"]["variable_name"]}}</label>
                                        <select class="form-control"
                                                name="{{$value["areaVariableId"]}}">
                                            <option {{($gaugeChangeVariableData[$value["areaVariableId"]]["value"] == "Not Applicable" ? "selected" : "")}} value="Not Applicable">N/A</option>
                                            <option {{($gaugeChangeVariableData[$value["areaVariableId"]]["value"] == "Yes" ? "selected" : "")}} value="Yes">Yes</option>
                                            <option {{($gaugeChangeVariableData[$value["areaVariableId"]]["value"] == "No" ? "selected" : "")}} value="No">No</option>

                                        </select>
                                    @else
                                        <label>{{$value["variable"]["variable_name"]}}</label>
                                        <input type="text" class="form-control" name="{{$value["areaVariableId"]}}"
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
                                        <textarea rows="6" class="form-control"
                                                  name="{{$value["areaVariableId"]}}">{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}</textarea>

                                    @else
                                        <label>{{$value["variable"]["variable_name"]}}</label>
                                        <input type="text" class="form-control" name="{{$value["areaVariableId"]}}"
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
                                        <textarea rows="6" class="form-control"
                                                  name="{{$value["areaVariableId"]}}">{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}</textarea>

                                    @else
                                        <label>{{$value["variable"]["variable_name"]}}</label>
                                        <input type="text" class="form-control" name="{{$value["areaVariableId"]}}"
                                               value="{{$gaugeChangeVariableData[$value["areaVariableId"]]["value"]}}">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div style="margin: auto;width: 75px;">
                    <button type="submit" class="btn btn-primary mt-5">Update</button>
                </div>

            </form>
        </div>

    </div>
    </div>
@endsection
@section('functionalScripts')
    <script>

    </script>


@endsection
