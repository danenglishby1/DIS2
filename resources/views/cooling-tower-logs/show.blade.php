@extends('layouts.app')

@section('pageTitle', 'Macro Details')
@section('pageName', 'Macro Details')
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

                <dl class="row">

                    <dt class="col-sm-2">Cooling Tower</dt>
                    <dd class="col-sm-2">{{ $coolingTowerLogs->cooling_tower_identifier }}</dd>
                    <dt class="col-sm-2">Is online and in production</dt>
                    <dd class="col-sm-2">{{ $coolingTowerLogs->online }}</dd>
                    <dt class="col-sm-2">Is water in CT sump fresh and clear</dt>
                    <dd class="col-sm-2">{{ $coolingTowerLogs->fresh }}</dd>
                    <dt class="col-sm-2">Is the system operating as normal</dt>
                    <dd class="col-sm-2">{{ $coolingTowerLogs->operating_normal }}</dd>


            </div>
            <br />
            <h4>Comments</h4>
            <textarea style="width:100%;" readonly>
{{ $coolingTowerLogs->comments }}


                    </textarea>
        </div>
    </div>

@endsection
