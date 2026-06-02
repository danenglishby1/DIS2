<?php
echo '<table style="border: 1px solid;">' .
    '<thead>' .
    '<th style="border: 1px solid;">Section</th>' .
    '<th style="border: 1px solid;">DateTime</th>' .
    '</thead>';

echo '<tbody>';

foreach ($data as $row) {
    echo '<tr style="border: 1px solid;">';
    echo '<td style="border: 1px solid;">'.$row["section"].'</td>'.
        '<td style="border: 1px solid;">'.$row["dateTime"].'</td>' .
     "</tr>";
}

echo '</tbody>
</table>';


