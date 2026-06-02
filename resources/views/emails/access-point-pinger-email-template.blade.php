
<?php
echo "The following access points have been detected as offline.... please arrange for the relevant department to power up/down.";
    echo "<ul>";
    foreach($data as $key => $value) {
        echo "<li>" . $key . " - $value";
        echo "</li>";
    }
    echo "</ul>";

?>


<img src="{{ $message->embed("D:\\xampp\\htdocs\\DIS\\public\\images\\AccessPoints.png") }}">


