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


                <div class="simpleflex">

                    <dd>Week No</dd>
                    <dl>{{$annealerPreStartCheck[0]->week_no}}</dl>

                    <dd>OD</dd>
                    <dl>{{$annealerPreStartCheck[0]->od}}</dl>

                    <dd>Created By</dd>
                    <dl>{{$annealerPreStartCheck[0]->user->name}}</dl>

                    <dd>Created At</dd>
                    <dl>{{$annealerPreStartCheck[0]->created_at}}</dl>

                </div>

                    <table id="macro-table" class="table table-striped">
                        <thead>
                        <th>Week</th>
                        <th>Shift</th>
                        <th>Operator</th>
                        <th>CreatedByUser</th>
                        <th>Item</th>
                        <th>Annealer</th>
                        <th>Status/Value</th>
                        <th>Comment</th>
                        <th>Created At</th>
                        </thead>
                        <tbody>
                        @foreach($annealerPreStartCheck as $check)
                            <tr>
                                <td>{{$check->week_no}}</td>
                                <td>{{$check->shift}}</td>
                                <td>{{$check->operator}}</td>
                                <td>{{$check->user->name}}</td>
                                <td>{{$check->item}}</td>
                                <td>{{$check->annealer}}</td>
                                <td>{{$check->status}}</td>
                                <td>{{$check->comment}}</td>
                                <td>{{$check->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <th>Week</th>
                        <th>Shift</th>
                        <th>Operator</th>
                        <th>CreatedByUser</th>
                        <th>Item</th>
                        <th>Annealer</th>
                        <th>Status/Value</th>
                        <th>Comment</th>
                        <th>Created At</th>
                        </tfoot>
                    </table>


                    {{-- $userId == R.Butler || $userId == LABS || $userId == D.E --}}
{{--                    @if($userId == 47 || $userId == 56 || $userId == 4)--}}
{{--                    <a href="{{ route('wm-macros.edit',$macroDataRecord->id)}}" class="btn btn-warning mb-2 mt-2 p-2">Edit This Macro</a>--}}
{{--                        @endif--}}
            </div>
        </div>
    </div>

@endsection
