<h5 style="margin: 1em 0;">Significant Management Of Change Summary</h5>

<p>View this MofC <a href="{{$mocUrl}}">Online</a> </p>
<div style="display:inline-block">
    <div style="margin:1em;">
        <span style="font-weight:bold">MofC No:</span>
        <span>{{ $moc[0]["moc_id"] }}</span>
    </div>
    <div style="margin:1em;">
        <span style="font-weight:bold">Title:</span>
        <span>{{ $moc[0]["moc"]["change_title"] }}</span>
    </div>
    <div style="margin:1em;">
        <span style="font-weight:bold">Risk Rating:</span>
        <span>{{ $moc[0]["moc"]["risk_rating"] }}</span>
    </div>
    <div style="margin:1em;">
        <span style="font-weight:bold">Raised By:</span>
        <span>{{ $moc[0]["user"]["name"] }}</span>
    </div>
    <div>
        <h5 style="margin: 1em 0;">Description</h5>
        <div>{{ $moc[0]["description"] }}</div>
    </div>

    <div>
        <h5 style="margin: 1em 0;">Actions</h5>
        <div>
            <table style="border:1px solid #ccc;">
                <thead>
                <th colspan="4">Agreed Action Plan (Following discussion)</th>
                </thead>
                <tr>
                    <td>Action</td>
                    <td>Responsibility</td>
                    <td>To Be Completed By</td>
                    <td>Completed</td>
                </tr>

                @foreach($actions as $userAction)
                    <tr>
                        <td style="border:1px solid #ccc; padding:2px;">{{$userAction["action"]}}</td>
                        <td style="border:1px solid #ccc; padding:2px;">{{$userAction["user"]["name"]}}</td>
                        <td style="border:1px solid #ccc; padding:2px;">{{date('d-m-Y', strtotime($userAction["complete_by_date"]))}}</td>
                        <td style="border:1px solid #ccc; padding:2px;">{{$userAction["complete_status"]}}</td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>

</div>
