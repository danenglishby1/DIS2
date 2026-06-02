
<h2>Managment Of Change Summary</h2>
<p>View this MofC <a href="{{$mocUrl}}">Online</a> </p>
<?php
echo '<table style="border: 1px solid #ccc;
        font-size: 16px;">' .
    '<thead>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">MofC No</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Dept</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Change Title</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Created By</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Authoriser</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Risk Rating</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Status Impact</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Created At</th>' .
//    '<th>View Chart ></th>' .
    '</thead>';

echo '<tbody>';


echo "<tr>";
echo "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc["id"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc["moc_department"]["department"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc["change_title"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc["user"]["name"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc["moc_department_authoriser"]["moc_authoriser"]["user"]["name"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc["risk_rating"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc["status_impact"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc["created_at"] . "</td>";
//        "<td><a href='http://h20-dis.edis.tatasteel.com/DIS/rhs/section-cooling-trace?sectionNo=".$row["SECTION_NO"]."'>View Chart ></td>";
echo "</tr>";


echo "</tbody>
</table>";

echo "<br />";
echo "<br />";
echo "<h3>Change Description</h3>";
echo "<br />";
echo $moc["change_description"];
echo "<br />";
echo "<br />";
echo "*********Please Note: If MofC is Significant, await next email.**********"
