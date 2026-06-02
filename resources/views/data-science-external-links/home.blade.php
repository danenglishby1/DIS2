@extends('layouts.app')

@section('pageTitle', 'Data Science External Links')
@section('pageName', 'Data Science External Links')
@section('homeActiveLink', 'active activeUnderline')
@section('css')
    <style>
        .global-back-button {
            display: none;
        }
    </style>
@endsection
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

    <div class="simpleflex" style="justify-content: space-evenly">
        <div class="home-image-button-flex">
            <a target="_blank" href="http://ijmrdtappl00.edis.tatasteel.com:8080/knime/webportal/space/Independent%20Projects/Hartlepool%20TPR%20Apps/Hartlepool_pipe_hm_trends?exec&pm:user=&embed&knime:access_token=eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0b29sYm94Iiwicm9sZXMiOlsiYXV0aCB0b2tlbiIsInRvb2xib3giXSwic2FsdCI6ImRjNTRkZDU2NDI5M2FkM2MiLCJ3b3JrZmxvd1BhdGgiOiIvSW5kZXBlbmRlbnQgUHJvamVjdHMvSGFydGxlcG9vbCBUUFIgQXBwcy9IYXJ0bGVwb29sX3BpcGVfaG1fdHJlbmRzIiwidG9rZW5UeXBlIjoid29ya2Zsb3dUb2tlbiIsInVzYWdlVHlwZSI6ImxpbmsiLCJ0b2tlbklkIjoiZGZiYWM4NmQtYTY3Zi00MTUwLTg5ZmQtMzg1Y2Q0ZmI2NDhjIn0.m6aR_wRsF-aobP94_3y2ZTCGOhtdpqkMwF2fb-JX-k0">
                <img class="img-thumbnail" src="{{ asset('/public/images/datascience-banner.png') }}"/>
                <h4 class="text-center mt-2">Hot Mill Trend Plots</h4>
            </a>
        </div>
        <div class="home-image-button-flex">
            <a target="_blank" href="http://ijmrdtappl00.edis.tatasteel.com:8080/knime/webportal/space/Beta/Applications/RHS_RFT_Demo?exec&pm:user=&embed&knime:access_token=eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0b29sYm94Iiwicm9sZXMiOlsiYXV0aCB0b2tlbiIsInRvb2xib3giXSwic2FsdCI6ImJhMzg1YWRlN2UyMDZkMzIiLCJ3b3JrZmxvd1BhdGgiOiIvQmV0YS9BcHBsaWNhdGlvbnMvUkhTX1JGVF9EZW1vIiwidG9rZW5UeXBlIjoid29ya2Zsb3dUb2tlbiIsInVzYWdlVHlwZSI6ImxpbmsiLCJ0b2tlbklkIjoiYjEzNTRiNDAtOGNmZC00MTZlLThiMzMtYWQyZGNhN2EzMGQzIn0.i8vSnmQltEL2TrOk_e4kSrcw_OuY-h7Tt-hPb76VukI">
                <img class="img-thumbnail" src="{{ asset('/public/images/datascience-nrft.png') }}"/>
                <h4 class="text-center mt-2">NRFT Monitor</h4>
            </a>
        </div>
        <div class="home-image-button-flex">
            <a target="_blank" href="http://ijmrdtappl00.edis.tatasteel.com:8080/knime/webportal/space/Beta/Applications/H20_Weld_API_charpss?exec&pm:user=%22.$user.%22&embed&knime:access_token=eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0b29sYm94Iiwicm9sZXMiOlsiYXV0aCB0b2tlbiIsInRvb2xib3giXSwic2FsdCI6IjIzZjBjYTc0NWNiN2VkOGEiLCJ3b3JrZmxvd1BhdGgiOiIvQmV0YS9BcHBsaWNhdGlvbnMvSDIwX1dlbGRfQVBJX2NoYXJwc3MiLCJ0b2tlblR5cGUiOiJ3b3JrZmxvd1Rva2VuIiwidXNhZ2VUeXBlIjoibGluayIsInRva2VuSWQiOiI3YzRmZTY2ZS0xOGFhLTQ0MGItOWViMi1mMWQwNGJjYzliMzMifQ.VAQq9yBPO8Hpa2f4xTYNdNnOrGUH4aM75JpgsrSNCvg">
                <img class="img-thumbnail" src="{{ asset('/public/images/datascience-weld-impact.png') }}"/>
                <h4 class="text-center mt-2">Weld Impact Data</h4>
            </a>
        </div>
        <div class="home-image-button-flex">
            <a target="_blank" href="http://ijmrdtappl00.edis.tatasteel.com:8080/knime/webportal/space/Beta/Applications/H20_XIRIS_Navigator?exec&pm:user=&embed&knime:access_token=eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0b29sYm94Iiwicm9sZXMiOlsiYXV0aCB0b2tlbiIsInRvb2xib3giXSwic2FsdCI6ImIwZTBjZjZmYmQwMmUxZDciLCJ3b3JrZmxvd1BhdGgiOiIvQmV0YS9BcHBsaWNhdGlvbnMvSDIwX1hJUklTX05hdmlnYXRvciIsInRva2VuVHlwZSI6IndvcmtmbG93VG9rZW4iLCJ1c2FnZVR5cGUiOiJsaW5rIiwidG9rZW5JZCI6IjFmYjM1NDMyLTNmNmUtNDA5ZC05MDliLTc4NTgyMWJiZDY2MyJ9._XnmNj9wum3Jub12eUh4ohrMygfaNrUHZqWVqCnGSro">
                <img class="img-thumbnail" src="{{ asset('/public/images/datascience-xiris.png') }}"/>
                <h4 class="text-center mt-2">Xiris Data</h4>
            </a>
        </div>
        <div class="home-image-button-flex">
            <a target="_blank" href="http://ijmrdtappl00.edis.tatasteel.com:8080/knime/webportal/space/Beta/Applications/H20_Zumbach?exec&pm:user=%22.$user.%22&embed&knime:access_token=eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ0b29sYm94Iiwicm9sZXMiOlsiYXV0aCB0b2tlbiIsInRvb2xib3giXSwic2FsdCI6ImE2OTI4NmZhMzg1MGVjYjEiLCJ3b3JrZmxvd1BhdGgiOiIvQmV0YS9BcHBsaWNhdGlvbnMvSDIwX1p1bWJhY2giLCJ0b2tlblR5cGUiOiJ3b3JrZmxvd1Rva2VuIiwidXNhZ2VUeXBlIjoibGluayIsInRva2VuSWQiOiI2NjRkNDY0Yi1kMDMzLTQ1NTYtOTEzZC1hZTU1ZThkZjMwYzcifQ.uaM0byDNgu-Upc1L_auFs7KUbmkEZR_vAeR0xbWj8Gw">
                <img class="img-thumbnail" src="{{ asset('/public/images/datascience-zumbach.png') }}"/>
                <h4 class="text-center mt-2">Zumbach Data</h4>
            </a>
        </div>



    </div>


@endsection
