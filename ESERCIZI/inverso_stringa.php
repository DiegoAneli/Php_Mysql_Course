<?php

    //funzione che inverte il valore di una stringa
    if(isset($_GET['testo'])){

        $originale = $_GET['testo']; // stringa originale
        $invertita = strrev($originale); //metodo php STRREV che inverte la stringa

        echo "<p> Stringa Originale $originale </p>";
        echo "<p> Stringa invertita $invertita </p>";

    }
?>


<form method="get">
    Inserisci una parola : <input type="text" name="testo">
    <input type="submit" value="inverti">
</form>