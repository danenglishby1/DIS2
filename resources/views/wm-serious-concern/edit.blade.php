@extends('layouts.app')

@section('pageTitle', 'Edit WM Serious Concern')
@section('pageName', 'Edit WM Serious Concern')
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

                <form method="post"  enctype="multipart/form-data" action="{{ route('wm-serious-concern.update', $seriousConcern->id) }}">
                    @method('PATCH')
                    @csrf
                    <div class="form-group">
                        <label for="name">Week:</label>
                        <input type="text" class="form-control" name="week" readonly value="{{$seriousConcern->WEEK}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">CoilNo:</label>
                        <input type="text" class="form-control" name="coilNo" readonly value="{{$seriousConcern->COIL}}"/>
                    </div>

                    <div class="form-group">
                        <label for="od">OD:</label>
                        <input type="text" class="form-control" name="od" readonly value="{{$seriousConcern->OD}}"/>
                    </div>

                    <div class="form-group">
                        <label for="thickness">THICKNESS:</label>
                        <input type="text" class="form-control" name="thickness" readonly value="{{$seriousConcern->THICKNESS}}"/>
                    </div>

                    <div class="form-group">
                        <label for="grade">GRADE:</label>
                        <input type="text" class="form-control" name="grade" readonly value="{{$seriousConcern->GRADE}}"/>
                    </div>

                    <div class="form-group">
                        <label for="grade">REASON:</label>
                        <select class="form-control" name="reason">
                            <option value="ID" {{($seriousConcern->REASON == "ID" ? "selected" : "")}}>ID</option>
                            <option value="OD" {{($seriousConcern->REASON == "OD" ? "selected" : "")}}>OD</option>
                            <option value="SURFACE CONDITION" {{($seriousConcern->REASON == "SURFACE CONDITION" ? "selected" : "")}}>SURFACE CONDITION</option>
                            <option value="DIMENSION" {{($seriousConcern->REASON == "DIMENSION" ? "selected" : "")}}>DIMENSION</option>
                            <option value="STRAIGHTNESS" {{($seriousConcern->REASON == "STRAIGHTNESS" ? "selected" : "")}}>STRAIGHTNESS</option>
                            <option value="TWST" {{($seriousConcern->REASON == "TWST" ? "selected" : "")}}>TWST</option>
                            <option value="CONCAVITY/CONVEXITY" {{($seriousConcern->REASON == "CONCAVITY/CONVEXITY" ? "selected" : "")}}>CONCAVITY/CONVEXITY</option>
                            <option value="END CONDITION" {{($seriousConcern->REASON == "END CONDITION " ? "selected" : "")}}>END CONDITION</option>
                            <option value="TRACKING LINE" {{($seriousConcern->REASON == "TRACKING LINE" ? "selected" : "")}}>TRACKING LINE</option>
                            <option value="ANNEALING" {{($seriousConcern->REASON == "ANNEALING" ? "selected" : "")}}>ANNEALING</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="processRoute">PROCESS ROUTE:</label>
                        <select class="form-control" name="processRoute">
                            <option value="COLD CHS" {{($seriousConcern->PROCESS_ROUTE == "COLD CHS" ? "selected" : "")}}>COLD CHS</option>
                            <option value="COLD RHS" {{($seriousConcern->PROCESS_ROUTE == "COLD RHS" ? "selected" : "")}}>COLD RHS</option>
                            <option value="HOT RHS" {{($seriousConcern->PROCESS_ROUTE == "HOT RHS" ? "selected" : "")}}>HOT RHS</option>
                            <option value="HOT CHS" {{($seriousConcern->PROCESS_ROUTE == "HOT CHS" ? "selected" : "")}}>HOT CHS</option>
                            <option value="PRESSURE PIPE" {{($seriousConcern->PROCESS_ROUTE == "PRESSURE PIPE" ? "selected" : "")}}>PRESSURE PIPE</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pipes">PIPES:</label>
                        <input type="text" class="form-control" name="pipes"
                               value="{{$seriousConcern->PIPES}}"/>
                    </div>

                    <div class="form-group">
                        <label for="comments">COMMENTS:</label>
                        <input type="text" class="form-control" name="comments"
                               value="{{$seriousConcern->COMMENTS}}"/>
                    </div>

                    <input type="hidden" id="user" name="user" value="{{$seriousConcern->user->id}}">



                    <div class="form-group">
                    <label>Person Consulted</label>
                        <input type="text" class="form-control" name="personConsulted"
                               value="{{$seriousConcern->REPORTED_TO_USER}}"/>

            </div>

                    <div class="form-group">
                        <label>Complete</label>
                        <select class="form-control" name="complete">
                            <option {{($seriousConcern->COMPLETE_STATUS == "Y" ? "selected" : "")}} value="Y">Y</option>
                            <option {{($seriousConcern->COMPLETE_STATUS == "N" ? "selected" : "")}} value="N">N</option>
                        </select>
                    </div>


                    @if ($seriousConcern["IMAGE"] !== "")
                        <a class="macroImageLink" target="_blank"
                           href="{{asset('public/storage/wm-serious-concern/'.$seriousConcern["FILE_PATH"])}}"><img
                                style="width:100px; height: 50px;"
                                src="{{asset('public/storage/wm-serious-concern/'.$seriousConcern["FILE_PATH"])}}"/></a>
                    @endif

                    <input type="file" id="img" name="file" accept="image/*">

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('functionalScripts')
<script>
    /**
    * Add .00 to any numeric input
    * */
    $(':input[type="number"]').change(function(){
    this.value = parseFloat(this.value).toFixed(2);
    });
</script>
@endsection
