<?php

echo '<table>' .
    '<thead>' .
    '<th>Section</th>' .
    '<th>Shift</th>' .
    '<th>Date</th>' .
    '<th>Defect</th>' .
    '<th>Action</th>' .
    '<th>Thickness</th>' .
    '<th>Size1</th>' .
    '<th>Size2</th>' .
    '<th>Comments</th>' .
    '</thead>';

echo '<tbody>';

foreach ($data as $row) {
    echo "<tr>";
    echo "<td>".$row["section_no"]."</td>" .
        "<td>".$row["shift"]."</td>" .
        "<td>".$row["created_at"]."</td>" .
        "<td>".$row["temp_defect"]."</td>" .
        "<td>".$row["action"]."</td>" .
        "<td>".$row["thickness"]."</td>" .
        "<td>".$row["size1"]."</td>" .
        "<td>".$row["size2"]."</td>" .
        "<td>".$row["comments"]."</td>";
    echo "</tr>";
}

echo "</tbody>
</table>";


