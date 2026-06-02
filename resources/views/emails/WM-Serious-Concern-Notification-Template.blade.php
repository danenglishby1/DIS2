
<h3>Weld Mill Serious Concern Notification</h3>



<p>Serious concern created, please check <a href="{{$url}}">DIS</a> for details.</p>



<h2>If this is your department, then please accept acknowledgement with the following link  <a href="{{$url}}?accept=y">Accept</a></h2>

<body class="body">
<ul class="glist" style="margin:0; margin-left: 25px; padding:0; color:#495055; font-size:16px; line-height:22px;" align="left" type="disc">
    <li style="font-weigh:bold;font-size:20px;">
        WEEK
    <ul>
        <li>{{ $seriousConcern[0]["WEEK"] }}</li>
    </ul>
    </li>

    <li style="font-weigh:bold;font-size:20px;">
        COIL
        <ul>
            <li>{{ $seriousConcern[0]["COIL"] }}</li>
        </ul>
    </li>

    <li style="font-weigh:bold;font-size:20px;">
        OD
        <ul>
            <li>{{ $seriousConcern[0]["OD"] }}</li>
        </ul>
    </li>

    <li style="font-weigh:bold;font-size:20px;">
        GRADE
        <ul>
            <li>{{ $seriousConcern[0]["GRADE"] }}</li>
        </ul>
    </li>

    <li style="font-weigh:bold;font-size:20px;">
        THICKNESS
        <ul>
            <li>{{ $seriousConcern[0]["THICKNESS"] }}</li>
        </ul>
    </li>

    <li style="font-weigh:bold;font-size:20px;">
        REASON
        <ul>
            <li>{{ $seriousConcern[0]["REASON"] }}</li>
        </ul>
    </li>

    <li style="font-weigh:bold;font-size:20px;">
        PROCESS_ROUTE
        <ul>
            <li>{{ $seriousConcern[0]["PROCESS_ROUTE"] }}</li>
        </ul>
    </li>

    <li style="font-weigh:bold;font-size:20px;">
        COMMENTS
        <ul>
            <li>{{ $seriousConcern[0]["COMMENTS"] }}</li>
        </ul>
    </li>

    @php
    $pipeArray = [];
    $pipeList = $seriousConcern[0]["PIPES"];
    $pipeArray = explode(";", $pipeList);



    @endphp



    <li style="font-weigh:bold;font-size:20px;">
        PIPES
        <ul>
            @foreach($pipeArray as $p)
            <li>{{$p}}</li>
            @endforeach
        </ul>
    </li>



</ul>

</body>
