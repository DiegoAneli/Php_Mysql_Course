<?php

echo "questa funzione serve per stampare a schermo";

/*

Questo è un commento su piu' righe

*/

// questo è un commento su una riga

?>


<?php

//Verifico il nome in input e stampo un messaggio di benvenuto

//dichiaro una variabile
$nome = "Mario";


if($nome){

    //echo "Ciao, $nome!";
    var_dump($nome);

}

?>


<?php

//Variabili

$nome = "luca"; // string
$eta = 25; // int

echo "Ciao $nome, hai $eta anni";

?>


<?php

//costanti

define("PI", 3.14);
echo PI;


?>


<?php

//condizioni IF-ELSE

$numero = -5;

if ($numero > 0) {
    echo "positivo";
}else {
    echo "negativo o zero";
}

?>


<?php

//Switch-case (default) simile all IF-ELSE ma più leggibile. ( richiede il default )

$colore = "rosso";

switch ($colore) {

    case "rosso" :
        echo "hai scelto rosso";
    case "blu" :
        echo "hai scelto blu";
    case "verde" : 
        echo "hai scelto verde";
    default :
        echo "colore non riconosciuto";
}

?>


<?php

//ciclo for

// javascript :  for(let i = 0; i < 0; i++){};


for($i = 1; $i <= 5; $i++){

    echo "numero: $i <br>";
}


?>


<?php

//ciclo while devo pensare : "fintanto che" 

$i = 1;

while ($i <= 3 ){

    echo "valore : $i <br>";
    $i++;

}

?>


<?php

//CICLO FOREACH

$nomi = ["Anna","Luca","Marco"];

foreach($nomi as $nome){

    echo "$nome <br>";
}

?>





<?php

//FUNZIONI


function saluta($nome){
    return "Ciao, $nome!";
}


echo saluta("Giulia");
echo saluta("Marco");

?>