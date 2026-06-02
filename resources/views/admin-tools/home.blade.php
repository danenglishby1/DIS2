@extends('layouts.app')

@section('pageTitle', 'Home')
@section('pageName', 'Home')
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

    <script src="https://spotfire-next.cloud.tibco.com/spotfire/js-api/loader.js"></script>


    <script>
        var app;
        var doc;
        var webPlayerServerRootUrl = "http://ijmbicspfsrvp00.edis.tatasteel.com:8075/spotfire/wp/";
        var customizationInfo;
        var analysisPath = "/REPORTS/TS-TUBES_UK_HP/Test/OrderTracking";
        var parameters = '';
        var reloadInstances = true;
        var apiVersion = "7.14";

        spotfire.webPlayer.createApplication(
            webPlayerServerRootUrl,
            customizationInfo,
            analysisPath,
            parameters,
            reloadInstances,
            apiVersion,
            onReadyCallback,
            onCreateLoginElement
        );

        function onReadyCallback(response, newApp)
        {
            app = newApp;
            if(response.status === "OK")
            {
                // The application is ready, meaning that the api is loaded and that
                // the analysis path is validated for the current session
                // (anonymous or logged in user)
                console.log("OK received. Opening document to page 0 in element renderAnalysis")
                doc = app.openDocument("spotfireContainer", 0);
            }
            else
            {
                console.log("Status not OK. " + response.status + ": " + response.message)
            }
        }

        function onError(error)
        {
            console.log("Error: " + error);
        }

        function onCreateLoginElement()
        {
            console.log("Creating the login element");

            // Optionally create and return a div to host the login button
            return null;
        }
    </script>



    <div class="simpleflex">
        <div>
            <div style="height: 100vh; width: 90vw;" id="spotfireContainer"></div>
        </div>



    </div>



    <?php



    ?>



@endsection
