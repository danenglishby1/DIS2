@extends('layouts.app')

@section('pageTitle', 'Add WM Shift Log')
@section('pageName', 'Add WM Shift Log')
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

                <hr/>
                <form method="post" action="{{ route('varnish-check.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-center"
                         style="margin-bottom: 20px;background: #ececec;padding: 5px;border-radius: 10px;">

                        <div class="form-group m-1">
                            <label for="pipe_dia">Pipe Dia</label>
                            <input type="text" id="pipe_dia"  class="form-control" required name="pipe_dia"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="tip_size">Tip Size</label>
                            <input type="text" id="tip_size"  class="form-control" required name="tip_size"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="speed">Speed</label>
                            <input type="number" id="speed"  class="form-control" required name="speed"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="thickness">Thickness</label>
                            <input type="number" id="thickness"  class="form-control" required name="thickness"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="gun_1_dist">Gun 1 Dist</label>
                            <input type="text" id="gun_1_dist"  class="form-control" required name="gun_1_dist"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="gun_2_dist">Gun 2 Dist</label>
                            <input type="text" id="gun_2_dist"  class="form-control" required name="gun_2_dist"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="gun_3_dist">Gun 3 Dist</label>
                            <input type="text" id="gun_3_dist"  class="form-control" required name="gun_3_dist"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="gun_4_dist">Gun 4 Dist</label>
                            <input type="text" id="gun_4_dist"  class="form-control" required name="gun_4_dist"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="gun_5_dist">Gun 5 Dist</label>
                            <input type="text" id="gun_5_dist"  class="form-control" required name="gun_5_dist"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="gun_6_dist">Gun 6 Dist</label>
                            <input type="text" id="gun_6_dist"  class="form-control" required name="gun_6_dist"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="overlap">Overlap</label>
                            <input type="text" id="overlap"  class="form-control" required name="overlap"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="stencil">Stencil</label>
                            <input type="text" id="stencil"  class="form-control" required name="stencil"/>
                        </div>

                    </div>



                    <hr />
                    <input type="hidden" id="XDEBUG_TRIGGER" maxlength="3" class="form-control"  name="XDEBUG_TRIGGER" value="1"/>
                    <br />
                    <br />

                    <button type="submit" class="btn btn-primary">Submit Shift Log</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('functionalScripts')

    <script>
        /**
         * Add ajax header for CSRF Token
         * */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });




    </script>

@endsection
