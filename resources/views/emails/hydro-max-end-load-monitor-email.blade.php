
<h2>Hydrotester High Pressure or Endload Monitor</h2>

<?php
echo '<table style="border: 1px solid #ccc;
        font-size: 16px;">' .
    '<thead>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">ROLL WEEK</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">BLOCK</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">PR</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">GRADE</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">OD</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">PRESSURE</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">FORCE LB</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">END LOAD</th>' .
    '<th style="padding: 5px; border: 1px solid #ccc;">CAPACITY</th>' .
    '</thead>';

echo '<tbody>';

foreach ($data as $r) {
echo "<tr>";
echo "<td style='padding:3px;border: 1px solid #ccc;'>" .$r["ROLL_WEEK"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $r["BLOCK_NO"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $r["PROCESS_ROUTE"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $r["BLOCK_GRADE"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $r["BLOCK_OD"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $r["HT_PRESSURE_MIN"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $r["FORCE_LB"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $r["END_LOAD"] . "</td>" .
    "<td style='padding:3px;border: 1px solid #ccc;'>" . $r["CAPACITY"] . "%</td>";
echo "</tr>";
}

echo "</tbody>
</table>";

echo '<br />'
echo 'For END LOADS above 85% consideration should be given to confirming the actual test pressure and confirming alignment of heads and clamps';
echo '<br />'
echo 'For TEST PRESSURES above 4750psi consideration should be given to testing HP intensifiers and testing all equipment using seamless pipe to full pressure.'
echo '<br />'
echo 'For ALL high end loads or high test pressures highlighted above consideration should be given to a review of the number of pipe seals for heads, dimensional condition of heads themselves and any outstanding issues currently being accepted (e.g. leaking intensifiers, bogie wheel issues, clamp pad condition, clamp cylinder leaks etc)';


?>
