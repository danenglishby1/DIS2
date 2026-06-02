
<h2>You have due or overdue actions</h2>

<p>View them <a href="{{$mocActionsUrl}}">Online</a> </p>

<br />

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

foreach($mocActions as $action) {
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
