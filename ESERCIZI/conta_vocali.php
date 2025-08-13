<?php

// Contare quante vocali ci sono in una stringa 

if(isset($_GET['frase'])) {

    $frase = strtolower($_GET['frase']); // converte in minuscolo

    //definire le vocali come array
    $vocali = ['a', 'e', 'i', 'o', 'u']; 

    $conta = 0;

    // Scorre ogni carattere della frase

    for($i = 0; $i < strlen($frase); $i++){ // METODO STRLEN

        if(in_array($frase[$i], $vocali)){
            
            $conta++;
        }
    }

    echo "<p> La frase contiene $conta vocali </p>";
    //var_dump($conta);
}

?>



<form method="get">

    Inserisci una frase : <input type="text" name="frase">
    <input type="submit" value="Conta vocali">

</form>