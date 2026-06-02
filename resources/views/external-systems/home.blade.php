@extends('layouts.app')

@section('pageTitle', 'External Systems')
@section('pageName', 'External Systems')
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
            <a target="_blank" href="https://tsx.sharepoint.com/sites/DMS/Tubes-UK/publdocs/Forms/Alldocuments.aspx?viewid=c8922197-4e46-4a4a-ab39-b99059a28118">
                <img class="img-thumbnail" src="{{ asset('/public/images/document-management-screenshot.PNG') }}"/>
                <h4 class="text-center mt-2">Document Management</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a target="_blank" href="http://ijmtubeweb00r.edis.tatasteel.com/ibi_apps/">
                <img class="img-thumbnail" src="{{ asset('/public/images/web-focus-screenshot.png') }}"/>
                <h4 class="text-center mt-2">Web Focus</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a target="_blank" href="https://tsx.sharepoint.com/sites/theIntranet">
                <img class="img-thumbnail" src="{{ asset('/public/images/intranet-screenshot.png') }}"/>
                <h4 class="text-center mt-2">Intranet</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a target="_blank" href="https://ijmbicspfsrvp00.edis.tatasteel.com/spotfire/wp/OpenAnalysis?file=80116ded-8890-4cb9-a342-10bd29a3b897">
                <img class="img-thumbnail" src="{{ asset('/public/images/commercial-spotfire.png') }}"/>
                <h4 class="text-center mt-2">Commercial Spotfire Dashboards</h4>
                <p>Note: Authentication Required, see D.Englishby for more info.</p>
            </a>
        </div>


        <div class="home-image-button-flex">
            <a target="_blank" href="https://tsx.sharepoint.com/sites/HealthSafetyEnvironmentIntranetDevelopment/SitePages/Incident-Classification-%26-Reporting.aspx">
                <img class="img-thumbnail" src="{{ asset('/public/images/submit-incident.jpg') }}"/>
                <h4 class="text-center mt-2">Submit Incident</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a target="_blank" href="https://tsx.sharepoint.com/sites/UKServices/SitePages/Red-Stripes.aspx">
                <img class="img-thumbnail" src="{{ asset('/public/images/red-stripes.jpg') }}"/>
                <h4 class="text-center mt-2">RED Stripes</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a target="_blank" href="https://tsx.sharepoint.com/sites/UKServices/SitePages/Health-and-Safety-Management-System.aspx">
                <img class="img-thumbnail" src="{{ asset('/public/images/health_and_safety_system.jpg') }}"/>
                <h4 class="text-center mt-2">Health & Safety Management System</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a target="_blank" href="https://cloud.havspro.com/">
                <img class="img-thumbnail" src="{{ asset('/public/images/havs-monitoring-system.jpg') }}"/>
                <h4 class="text-center mt-2">HAVS Monitoring System</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a target="_blank" href="https://app.q9elements.com/signin?redirect=https:%2F%2Fdiagram.q9elements.com%2Fdiagram%2F68bef3734559c075c1dbf18e%3Ftype%3Dupn%26v%3Dmaster">
                <img class="img-thumbnail" src="{{ asset('/public/images/element.jpg') }}"/>
                <h4 class="text-center mt-2">Elements</h4>
            </a>
        </div>

    </div>


@endsection
