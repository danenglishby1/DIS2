@extends('layouts.app')

@section('pageTitle', 'Add QR WM715')
@section('pageName', 'Add QR WM715')
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
                <form method="post" action="{{ route('weld-head-scrap.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="d-flex flex-wrap justify-content-center" style="margin-top: -70px;">

                        <div class="form-group m-1">
                            <label for="area">Area</label>
                            <select class="form-control" name="area">
                                <option value="Slitter">Slitter</option>
                                <option value="Annealer">Annealer</option>
                                <option value="Coil Joiner">Coil Joiner</option>
                            </select>
                        </div>

                        <div class="form-group m-1">
                            <label for="coil_no">Coil No</label>
                            <input type="text" class="form-control" name="coil_no"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="quality">Quality</label>
                            <input type="text" class="form-control" name="quality"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="front_end_scrap">Front End Scrap</label>
                            <input type="text" class="form-control" name="front_end_scrap"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="rear_end_scrap">Rear End Scrap</label>
                            <input type="text" class="form-control" name="rear_end_scrap"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="front_end_comments">Front End Comment</label>
                            <input type="text" class="form-control" name="front_end_comments"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="rear_end_comments">Rear End Comment</label>
                            <input type="text" class="form-control" name="rear_end_comments"/>
                        </div>
{{--    <input type="hidden" name="DEBUG_TRIGGER" value="1">--}}

                    </div>

                    <button type="submit" class="btn btn-primary">Add Log</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('functionalScripts')
    <script>

    </script>


@endsection
