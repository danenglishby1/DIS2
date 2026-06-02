<?php
echo '<table>' .
    '<thead>' .
    '<th>Section</th>' .
    '<th>Con No</th>' .
    '<th>Size1</th>' .
    '<th>Thick</th>' .
    '<th>Process Route</th>' .
    '<th>DateTime</th>' .
//    '<th>View Chart ></th>' .
    '</thead>';

echo '<tbody>';


foreach ($data as $row) {
    echo "<tr>";
    echo "<td>".$row["SECTION_NO"]."</td>" .
        "<td>".$row["CON_NO"]."</td>" .
        "<td>".$row["PIPE_SIZE1"]."</td>" .
        "<td>".$row["PIPE_THICK"]."</td>" .
        "<td>".$row["TIME_STAMP"]."</td>";

    echo "</tr>";
}

echo "</tbody>
</table>";


//        "<td><a href='http://h20-dis.edis.tatasteel.com/DIS/rhs/section-cooling-trace?sectionNo=".$row["SECTION_NO"]."'>View Chart ></td>";
