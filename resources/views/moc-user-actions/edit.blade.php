@extends('layouts.app')

@section('pageTitle', 'Edit MoC Action')
@section('pageName', 'Edit MoC Action')
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
                <form method="post" action="{{ route('moc-user-action.update', $mocAction->id) }}">
                    @method('PATCH')
                    @csrf


                    <div class="form-group m-1">
                        <label for="action">Action:</label>
                        <span>{{$mocAction->action}}</span>
                    </div>

                    <div class="form-group m-1">
                        <label for="complete_by_date">Complete By Date:</label>
                        <span>{{$mocAction->complete_by_date}}</span>
                    </div>

                    <div class="form-group m-1">
                        <label for="actionee_comments">Action Comments:</label>
                        <textarea name="actionee_comments" style="width:100%;" rows="10">{{$mocAction->actionee_comment}}</textarea>
                    </div>

                    <div class="form-group m-1">
                        <label for="complete_status">Is Complete?:</label>
                        <select name="complete_status" required class="form-control">
                            <option value="">Please Select..</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    @if($userId == $mocAction->user_id)
                    <button type="submit" class="btn btn-primary mt-5">Complete/Update</button>
                    @endif
                </form>

            </div>
        </div>
    </div>
@endsection
@section('functionalScripts')



@endsection
