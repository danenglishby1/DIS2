@extends('layouts.app')

@section('pageTitle', 'Login Activity')
@section('pageName', 'Login Activity')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>User</td>
                    <td>IP</td>
                    <td>User Agent</td>
                    <td>DateTime</td>
                </tr>
            </thead>
            <tbody>
                @foreach($activity as $logonActivity)
                <tr>
                    <td>{{$logonActivity->name}}</td>
                    <td>{{$logonActivity->ip_address}}</td>
                    <td>{{$logonActivity->user_agent}}</td>
                    <td>{{$logonActivity->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
        </div>
    </div>
    @endsection
    @section('functionalScripts')
  
    @endsection