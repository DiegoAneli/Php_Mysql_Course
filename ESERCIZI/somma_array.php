<?php

// definisco un array di numeri

$numeri = [10, 5, 8, 3, 7];

// inizializzo la variabile somma a 0

$somma = 0;

// ciclo per ogni numero e lo aggiungo alla somma

foreach($numeri as $num){

    $somma += $num;
}

// mostro il risultato

echo "La somma dei numeri è : $somma";

?>