@extends('layouts.app')

@section('pageTitle', 'Edit Dimensional Verification')
@section('pageName', 'Edit Dimensional Verification')
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






                {{--        <td>{{$row['POST_WELD_OOR']}}</td>--}}
                {{--        <td>{{$row['POST_WELD_PEAK']}}</td>--}}
                {{--        <td>{{$row['GRADE']}}</td>--}}
                {{--        <td>{{$row['ROUND_SQUARE']}}</td>--}}
                {{--        <td>{{$row['SIZES']}}</td>--}}
                {{--        <td>{{$row['COMMENTS']}}</td>--}}
                {{--        <td>{{$row['created_at']}}</td>--}}
                {{--        <td>{{$row['USER']}}</td>--}}

                <form method="post" action="{{ route('wm-dimensional-verification.update', $wmDimVerification->id) }}">
                    @method('PATCH')
                    @csrf
                    <div class="form-group">
                        <label for="name">Week:</label>
                        <input type="text" class="form-control" name="week" value="{{$wmDimVerification->WEEK}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">CoilNo:</label>
                        <input type="text" class="form-control" name="coilNo" value="{{$wmDimVerification->COIL}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">OD:</label>
                        <input type="text" class="form-control" name="od" value="{{$wmDimVerification->OD}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">Thickness:</label>
                        <input type="text" class="form-control" name="thickness"
                               value="{{$wmDimVerification->THICKNESS}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">PostFinsB:</label>
                        <input type="text" class="form-control" name="postFinsB"
                               value="{{$wmDimVerification->POST_FINS_B}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">PostFinsC:</label>
                        <input type="text" class="form-control" name="postFinsC"
                               value="{{$wmDimVerification->POST_FINS_C}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">PostFinsD:</label>
                        <input type="text" class="form-control" name="postFinsD"
                               value="{{$wmDimVerification->POST_FINS_D}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">PostFinsOffset:</label>
                        <input type="text" disabled class="form-control" name="postFinsOffset"
                               value="{{$wmDimVerification->POST_FINS_OFFSET}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">PostWeldA:</label>
                        <input type="text" class="form-control" name="postWeldA"
                               value="{{$wmDimVerification->POST_WELD_A}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">PostWeldB:</label>
                        <input type="text" class="form-control" name="postWeldB"
                               value="{{$wmDimVerification->POST_WELD_B}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">PostWeldC:</label>
                        <input type="text" class="form-control" name="postWeldC"
                               value="{{$wmDimVerification->POST_WELD_C}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">PostWeldD:</label>
                        <input type="text" class="form-control" name="postWeldD"
                               value="{{$wmDimVerification->POST_WELD_D}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">PostWeldOOR:</label>
                        <input type="text" disabled class="form-control" name="postWeldOOR"
                               value="{{$wmDimVerification->POST_WELD_OOR}}"/>
                    </div>


                    <div class="form-group">
                        <label for="description">PostWeldPeaking:</label>
                        <input type="text" disabled class="form-control" name="postWeldPeaking"
                               value="{{$wmDimVerification->POST_WELD_PEAK}}"/>
                    </div>


                    <div class="form-group">
                        <label>Grade</label>
                        <input type="text" class="form-control" name="grade" id="grade"
                               value="{{$wmDimVerification->GRADE}}">
                    </div>
                    <div class="form-group">
                        <label>Round/Square</label>
                        <select name="roundSquare" class="form-control">
                            <option value="Round" {{($wmDimVerification->ROUND_SQUARE == "Round" ? "selected" : "") }}>
                                Round
                            </option>
                            <option
                                value="Square" {{($wmDimVerification->ROUND_SQUARE == "Square" ? "selected" : "") }}>
                                Square
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Sizes:</label>
                        <input type="text" class="form-control" name="sizes" value="{{$wmDimVerification->SIZES}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">Comments:</label>
                        <input type="text" class="form-control" name="comments"
                               value="{{$wmDimVerification->COMMENTS}}"/>
                    </div>

                    <input type="hidden" id="user" name="user" value="{{$user}}">

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
