<?php
echo '<table>' .
    '<thead>' .
    '<th>Section</th>' .
    '<th>SIZE1</th>' .
    '<th>SIZE2</th>' .
    '<th>THICK</th>' .
    '<th>TIMESTAMP</th>' .
    '<th>View Chart ></th>' .
    '</thead>';

echo '<tbody>';

foreach ($data as $row) {
    echo "<tr>";
    echo "<td>".$row["SECTION_NO"]."</td>" .
        "<td>".$row["SIZE1"]."</td>" .
        "<td>".$row["SIZE2"]."</td>" .
        "<td>".$row["THICK"]."</td>" .
        "<td>".$row["TIME_STAMP"]."</td>" .
        "<td><a href='http://h20-dis.edis.tatasteel.com/DIS/rhs/section-cooling-trace?sectionNo=".$row["SECTION_NO"]."'>View Chart ></td>";
    echo "</tr>";
}

echo "</tbody>
</table>";


