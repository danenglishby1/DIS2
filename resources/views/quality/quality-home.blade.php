@extends('layouts.app')

@section('pageTitle', 'Quality Home')
@section('pageName', 'Quality Home')
@section('rhsActiveLink', 'active activeUnderline')
@section('content')
    <!-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
        <div class="alert alert-success" role="alert">
{{ session('status') }}
            </div>
@endif

        You are logged in!
    </div>
</div>
</div>
</div> -->
    <!-- Content Row -->

    <div class="simpleflex">
        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('usr.index')}}">
                <h4 class="text-center mt-2">Ultrasonic Reject Database</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('wm-macros.index') }}">
                <h4 class="text-center mt-2">Macro Data Records (QR LAB 701)</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('nrft-daily') }}">
                <h4 class="text-center mt-2">NRFT Daily</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="https://tsx.sharepoint.com/sites/DMS/Tubes-UK/publdocs/Forms/Alldocuments.aspx?FilterField1=User%5Fx0020%5FGroup&FilterValue1=Laboratory&FilterType1=Lookup&FilterDisplay1=Laboratory&viewid=c8922197%2D4e46%2D4a4a%2Dab39%2Db99059a28118">
                <h4 class="text-center mt-2">Lab Quality Docs</h4>
            </a>
        </div>


        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('pipe-quality-tracker') }}">
                <h4 class="text-center mt-2">Pipe Quality Tracker</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('pipe-quality-logs.index') }}">
                <h4 class="text-center mt-2">Pipe Quality Logs</h4>
            </a>
        </div>


        <div  class="fl1-300">
            <a class="flex-text-button-fill" target="_blank" href="http://ijmrdtappl00.edis.tatasteel.com:8080/knime/webportal/space/Beta/Applications/RHS_RFT_Demo?exec&pm:user=&embed&knime:access_token=eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0b29sYm94Iiwicm9sZXMiOlsiYXV0aCB0b2tlbiIsInRvb2xib3giXSwic2FsdCI6ImJhMzg1YWRlN2UyMDZkMzIiLCJ3b3JrZmxvd1BhdGgiOiIvQmV0YS9BcHBsaWNhdGlvbnMvUkhTX1JGVF9EZW1vIiwidG9rZW5UeXBlIjoid29ya2Zsb3dUb2tlbiIsInVzYWdlVHlwZSI6ImxpbmsiLCJ0b2tlbklkIjoiYjEzNTRiNDAtOGNmZC00MTZlLThiMzMtYWQyZGNhN2EzMGQzIn0.i8vSnmQltEL2TrOk_e4kSrcw_OuY-h7Tt-hPb76VukI">
                <h4 class="text-center mt-2">NRFT Monitor</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('weld-head-scrap.index') }}">
                <h4 class="text-center mt-2">QR WM715</h4>
            </a>
        </div>


    </div>




@endsection
