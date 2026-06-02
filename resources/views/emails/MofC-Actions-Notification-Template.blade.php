
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
echo "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc[0]["moc_id"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc[0]["moc"]["moc_department"]["department"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc[0]["moc"]["change_title"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc[0]["user"]["name"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc[0]["moc"]["moc_department_authoriser"]["moc_authoriser"]["user"]["name"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc[0]["moc"]["risk_rating"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc[0]["moc"]["status_impact"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $moc[0]["created_at"] . "</td>";
//        "<td><a href='http://h20-dis.edis.tatasteel.com/DIS/rhs/section-cooling-trace?sectionNo=".$row["SECTION_NO"]."'>View Chart ></td>";
echo "</tr>";


echo "</tbody>
</table>";

echo "<br />";
echo "<br />";
echo "<h3>Description</h3>";
echo "<br />";
echo $moc[0]["description"];
?>

<h2>Your Actions</h2>

<?php

echo '<table style="border: 1px solid #ccc;
        font-size: 16px;">' .
    '<thead>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Action</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">To Be Completed By</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">Already Completed?</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">View</th>' .

    '</thead>';

echo '<tbody>';

foreach($actions as $action) {
    echo "<tr>" . "<td style='padding:3px;border: 1px solid #ccc;'>"
        . $action["action"] . "</td>"
        . "<td style='padding:3px;border: 1px solid #ccc;'>"
        . date('d-m-Y', strtotime($action["complete_by_date"])) . "</td>"
        . "<td style='padding:3px;border: 1px solid #ccc;'>" . $action["complete_status"] . "</td>"
        . "<td style='padding:3px;border: 1px solid #ccc;'>" . '<a href="'. route('moc-user-action.edit',$action["id"]) .'">View</a>' . "</tr>";
    }
echo '</tbody>';
echo '</table>';
?>
