@extends('layouts.app')

@section('pageTitle', 'Add Macro')
@section('pageName', 'Add Macro')
@section('content')
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

                <div class="simpleflex" style="font-size: 25px;">
                    <div>Week: {{$weekNo}}</div>
                    <div>Shift: {{$shift}}</div>
                    <div>Date: {{date('Y-m-d')}}</div>
                    <div>Day: {{date('D')}}</div>
                </div>

                <img style="margin: auto;display: block;"
                     src="{{ asset('public/images/annealer_pre_start_checks.JPG')}}"/>

                @php
                    $annealerCheckItems = ["Vertical Setting", "Contact Roll Condition", "Contact Roll Touching", "Head Alignment", "Head Spacing (6mm)",
                                            "Tracking Camera Position", "Annealer Calibration Offset", "Park Height (160mm)"];
                @endphp

                <form method="post" action="{{ route('annealer-pre-start-checks.store') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-wrap justify-content-center">
                        <table class="table">
                            <thead>
                            <th>
                                Item
                            </th>
                            <th>Annealer A</th>
                            <th>Annealer B</th>
                            <th>Annealer C</th>
                            <th>Annealer D</th>
                            <th>Annealer E</th>
                            </thead>
                            <tbody>

                            @foreach ($annealerCheckItems as $item)
                                <tr>
                                    <td>
                                        <input type="text" readonly value="{{$item}}">
                                    </td>

                                    @if($item == "Annealer Calibration Offset")
                                        <td>
                                            <div>
                                                <input type="number" id="annealerA"
                                                       name="annealerA_{{$item}}" value="0">

                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="number" id="annealerB"
                                                       name="annealerB_{{$item}}" value="0">
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="number" id="annealerC"
                                                       name="annealerC_{{$item}}" value="0">
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="number" id="annealerD"
                                                       name="annealerD_{{$item}}" value="0">

                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="number" id="annealerE"
                                                       name="annealerE_{{$item}}" value="0">
                                            </div>
                                        </td>

                                        <td>
                                            <textarea
                                                name="{{preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$item)}}_comment">OK</textarea>
                                        </td>
                                </tr>
                                @else

                                    <td>
                                        <div>
                                            <input type="radio" id="annealerA"
                                                   name="annealerA_{{preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$item)}}"
                                                   checked value="OK">
                                            <label for="contactChoice1">OK</label>

                                            <input type="radio" id="annealerA"
                                                   name="annealerA_{{preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$item)}}"
                                                   value="Concern">
                                            <label for="contactChoice2">Concern</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <input type="radio" id="annealerB"
                                                   name="annealerB_{{preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$item)}}"
                                                   checked value="OK">
                                            <label for="contactChoice1">OK</label>

                                            <input type="radio" id="annealerB"
                                                   name="annealerB_{{preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$item)}}"
                                                   value="Concern">
                                            <label for="contactChoice2">Concern</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <input type="radio" id="annealerC"
                                                   name="annealerC_{{preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$item)}}"
                                                   checked value="OK">
                                            <label for="contactChoice1">OK</label>

                                            <input type="radio" id="annealerC"
                                                   name="annealerC_{{preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$item)}}"
                                                   value="Concern">
                                            <label for="contactChoice2">Concern</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <input type="radio" id="annealerD"
                                                   name="annealerD_{{preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$item)}}"
                                                   checked value="OK">
                                            <label for="contactChoice1">OK</label>

                                            <input type="radio" id="annealerD"
                                                   name="annealerD_{{preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$item)}}"
                                                   value="Concern">
                                            <label for="contactChoice2">Concern</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <input type="radio" id="annealerE"
                                                   name="annealerE_{{preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$item)}}"
                                                   checked value="OK">
                                            <label for="contactChoice1">OK</label>

                                            <input type="radio" id="annealerE"
                                                   name="annealerE_{{preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$item)}}"
                                                   value="Concern">
                                            <label for="contactChoice2">Concern</label>
                                        </div>
                                    </td>

                                    <td>
                                        <textarea
                                            name="{{preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$item)}}_comment">OK</textarea>
                                    </td>
                                    </tr>

                                @endif

                            @endforeach
                            </tbody>
                        </table>


                    </div>

                    <div class="form-group m-1 mb-2">
                        <label for="operator">OD</label>
                        <select class="form-control" name="od">
                        <option value="219">219</option>
                        <option value="244">244</option>
                        <option value="273">273</option>
                        <option value="323">323</option>
                        <option value="355">355</option>
                        <option value="406">406</option>
                        <option value="457">457</option>
                        <option value="473">473</option>
                        <option value="508">508</option>
                        </select>
                    </div>

                    <div class="form-group m-1 mb-2">
                        <label for="operator">Operator</label>
                        <input class="form-control" type="text" name="operator">
                    </div>


                    <button type="submit" class="btn btn-primary">Add Annealer Pre Start Checks</button>

                </form>


                <form class="mt-3" method="post" action="{{ route('annealer-pre-start-checks.store') }}">
                    @csrf

                    <input type="hidden" name="notAnnealing" value="true">

                    <div class="form-group m-1 mb-2">
                        <label for="operator">Operator</label>
                        <input class="form-control" type="text" name="operator">
                    </div>
                    <button type="submit" class="btn btn-warning">Not Annealing</button>

                </form>
            </div>
        </div>
    </div>


@endsection

@section('functionalScripts')
    <script>


    </script>


@endsection
