
<h2>Managment Of Change Summary</h2>
{{--<p>View this MofC <a href="{{$auditUrl}}">Online</a> </p>--}}
<?php
echo '<table style="border: 1px solid #ccc;
        font-size: 16px;">' .
    '<thead>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Audit No</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Dept</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Process Area</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Auditor</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Manager Responsible</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Comments</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Created At</th>' .
//    '<th>View Chart ></th>' .
    '</thead>';

echo '<tbody>';


echo "<tr>";
echo "<td style='padding:3px;border: 1px solid #ccc;'>" . $audit["id"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $audit["moc_department"]["department"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $audit["audit_process_area"]["name"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $audit["auditor_user"]["name"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $audit["manager_responsible_user"]["name"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $audit["comments"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $audit["created_at"] . "</td>";
//    "<td style='padding:3px;border: 1px solid #ccc;'>" . $audit["created_at"] . "</td>";
//        "<td><a href='http://h20-dis.edis.tatasteel.com/DIS/rhs/section-cooling-trace?sectionNo=".$row["SECTION_NO"]."'>View Chart ></td>";
echo "</tr>";


echo "</tbody>
</table>";



echo '<table style="border: 1px solid #ccc;font-size: 16px;">' .
    '<thead>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Action</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Responsibility</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Date</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Completed</th>' .
    '</thead>';

echo '<tbody>';
?>


@foreach($auditActions as $action)
        <tr>
            <td>{{$action["action"]}}</td>
            <td>{{$action["user"]["name"]}}</td>
            <td>{{$action["date_to_be_completed_by"]}}</td>
            <td>{{$action["completed"]}}</td>
        </tr>
@endforeach





