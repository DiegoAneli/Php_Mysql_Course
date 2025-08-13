<?php

//verifico che la parola inserita sia o meno un palindromo (es. : ANNA , OTTO, OSSO)
//aNNA NON è palindromo
//Anna NON è palindromo
//ANNA SI
//anna SI

//utilizzare "strrev"  e "strtolower"

if(isset($_GET['parola'])) {

    $parola = strtolower($_GET['parola']); //converto in minuscolo

    $invertita = strrev($parola); // inversione della stringa 

    //confronto

    if($parola == $invertita){

        echo "<p> $parola è palidroma </p>";

    }else {
        echo "<p> $parola non è palindroma </p>";
    }
}

?>

