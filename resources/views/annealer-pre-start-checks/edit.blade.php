@extends('layouts.app')

@section('pageTitle', 'Edit Macro')
@section('pageName', 'Edit Macro')
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

        <div class="simpleflex" style="font-size: 25px;">
            <div>Week: {{$annealerPreStartChecks[0]->week_no}}</div>
            <div>Shift: {{$annealerPreStartChecks[0]->shift}}</div>
        </div>

        @php
            $annealerCheckItems = ["Vertical Setting", "Contact Roll Condition", "Contact Roll Touching", "Head Alignment", "Head Spacing (6mm)",
                                    "Tracking Camera Position", "Annealer Calibration Offset", "Park Height (160mm)"];
        @endphp

        <form method="post" action="{{ route('annealer-pre-start-checks.update', $annealerPreStartChecks[0]->check_key) }}">
            @method('PATCH')
            @csrf

            <label>OD</label>
            <input type="number" name="od" value="{{$annealerPreStartChecks[0]->od}}">

            <div class="d-flex flex-wrap" style="width: 90%;margin: auto;">


                @foreach ($annealerPreStartChecks as $item)
                    <div class="form-group" style="margin:1em; flex:1;">
                        <label>Annealer {{$item["annealer"]}} | {{$item["item"]}}</label>

                        @if($item["item"] == "Annealer Calibration Offset")
                            <input type="number" name="{{$item["id"]}}" value="{{$item["status"]}}">
                        @else
                            <select name="{{$item["id"]}}" >
                            <option value="OK" {{($item["status"] == "OK" ? "selected" : "")}}>OK</option>
                            <option value="Concern"  {{($item["status"] == "Concern" ? "selected" : "")}}>Concern</option>

                            </select>
                        @endif

                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Update Annealer Pre Start Checks</button>

        </form>
    </div>


    </div>
@endsection
