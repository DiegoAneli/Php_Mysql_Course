<?php

    if(isset($_GET['numero'])) {

        $num = $_GET['numero']; //prende il numero

        echo "<p> Tabellina del $num : </p>";

        for($i = 1; $i <= 10; $i++){

            echo "$num x $i = " . ($num * $i) . "<br>";
        }
    }
?>


<form method="get">

    Inserisci un numero :
    <input type="number" name="numero">
    <input type="submit" value="Mostra tabellina">

</form>