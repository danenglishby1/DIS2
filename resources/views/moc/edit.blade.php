@extends('layouts.app')

@section('pageTitle', 'Edit MoC')
@section('pageName', 'Edit MoC')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/select2/select2.min.css')}}"/>
@endsection
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
                    </div>
                    <br/>
                @endif
                <form method="post" action="{{ route('moc.update', $moc->id) }}">
                    @method('PATCH')
                    @csrf
                    <div
                        style="font-size: 16px;display: flex; justify-content: space-around; margin-bottom: 30px;font-weight: bold;">


                        <div>Complete
                            Status: {{($moc->MocCompleteStatus->status == "N" ? "Incomplete" : "Complete")}}</div>

                        <div>Authorised
                            Status: {{($moc->MocAuthorisedStatus->status == "N" ? "Unauthorised" : "Authorised")}}</div>


                    </div>
                    <div>
                        <dt class="col-sm-2">MoC No:</dt>
                        <dd class="col-sm-2">{{ $moc["id"] }}</dd>

                        <div class="form-group m-1">
                            <label for="change_title">MoC Change Title.</label>
                            <input type="text" class="form-control" name="change_title" value="{{$moc["change_title"]}}"
                                   required>
                        </div>
                        <div class="form-group m-1">
                            <label for="change_description">MoC Description.</label>
                            <textarea style="width:100%" rows="6" name="change_description"
                                      required>{{$moc["change_description"]}}</textarea>
                        </div>

                        <div class="form-group m-1">

                            <label for="persons_consulted">Persons Consulted.</label>
                            <select style="width:100%;" class="js-example-basic-multiple" name="persons_consulted[]"
                                    multiple="multiple" >

                                @foreach($users as $user)
                                    <option {{(in_array($user->id, $personsConsulted) ? "selected" : "")}} value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="saveAsDraft" class="form-group">
                            <label for="is_draft">Save As Draft?</label>
                            <select name="is_draft" required class="form-control">
                                <option value="">Please Select</option>
                                <option value="Y">Yes</option>
                                <option value="N">No</option>
                            </select>
                        </div>


                        <div class="m-1" style="background: #fcfcfc;border:1px solid #ccc;padding: 15px;">
                            @if($moc["user_id"] == $loggedInUserId || 5 == $loggedInUserId)
                                <div class="form-group m-1" style="display: flex">
                                    <label for="complete" style="width:100px">Complete MoC.</label>
                                    <input class="form-control" style="width:40px" name="complete"
                                           type="checkbox" {{($moc->MocCompleteStatus->status == "N" ? "" : "checked")}}>
                                </div>
                            @endif

                            @if($mocAuthoriser[0]["moc_authoriser"]["user"]["id"] == $loggedInUserId)
                                <div class="form-group m-1" style="display: flex">
                                    <label for="authorise" style="width:100px">Authorise MoC.</label>
                                    <input class="form-control" style="width:40px" name="authorise"
                                           type="checkbox" {{($moc->MocAuthorisedStatus->status == "N" ? "" : "checked")}}>
                                </div>
                            @endif

                                @if($mocAuthoriser[0]["moc_authoriser"]["user"]["id"] == $loggedInUserId || $moc->user_id == $loggedInUserId)

                                    <div class="mb-3">
                                        <h4 style="margin: 1em 0;">Authoriser Comments</h4>
                                        <div class="form-group">
                                            <textarea class="form-control" name="free_form_comments">{{$moc->free_form_comments}}</textarea>
                                        </div>
                                    </div>

                                @endif

                        </div>
                    </div>
                    @if($moc->user_id == $loggedInUserId || $mocAuthoriser[0]["moc_authoriser"]["user"]["id"] == $loggedInUserId)
                        <button type="submit" class="btn btn-primary m-1">Update</button>
                    @endif
                </form>

            </div>
        </div>
    </div>
@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/select2/select2.min.js')}}"></script>
<script>
    $(document).ready(function () {
    $('.js-example-basic-multiple').select2();
    });
</script>
@endsection
