@extends('layouts.app')

@section('pageTitle', 'Home')
@section('pageName', 'Data Exports')
@section('dataExportsActiveLink', 'active activeUnderline')
@section('css')
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



    <div class="simpleflex">
        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('weld-mill-stoppage-data-exporter') }}">
                <h4 class="text-center mt-2">Weld Mill Stoppages</h4>

            </a>
            <sub style="font-size:13px;">Data going back to 13/08/18</sub>
        </div>

<div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('slitter-stoppage-data-exporter') }}">
                <h4 class="text-center mt-2">Slitter Stoppages</h4>

            </a>
        </div>


        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('other-stoppages-data-exporter') }}">
                <h4 class="text-center mt-2">Other Stoppages</h4>
            </a>
            <sub style="font-size:13px;">Data going back to 27/02/20</sub>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('rhs-straightness-data-exporter') }}">
                <h4 class="text-center mt-2">RHS Straightness</h4>
            </a>
            <sub style="font-size:13px;">Data going back to 21/05/08</sub>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('zumbach-laser-data-exporter') }}">
                <h4 class="text-center mt-2">RHS Zumbach</h4>
            </a>
            <sub style="font-size:13px;">Data going back to 06/01/19</sub>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('onsite-report-data-exporter') }}">
                <h4 class="text-center mt-2">Onsite Report</h4>
            </a>

        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('linehist-report-data-exporter') }}">
                <h4 class="text-center mt-2">Linehist Report</h4>
            </a>

        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('blockf-exporter') }}">
                <h4 class="text-center mt-2">BLOCKF Report</h4>
            </a>

        </div>

    </div>

@endsection
@section('functionalScripts')



@endsection
