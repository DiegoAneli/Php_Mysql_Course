<?php

if(isset($_GET['tentativo'])){

    //generare tramite la funzione di php random un numero randomico tra 1 e 10

    $casuale = random_int(1,10);

    //numero scelto dall utente

    $utente = $_GET['tentativo']; // numero scelto dall utente


    echo "<p> Numero estratto: $casuale</p>";


    //controllare se l utente ha indovinato

    if($utente == $casuale){

        echo "<p> Complimenti hai indovinato! </p>";
    }else {
        echo "<p> Ritenta! </p>";
    }
}
?>


<form method="get">
    Indovina un numero tra 1 e 10: <input type="number" name="tentativo" min="1" max="10">
    <input type="submit" value="Prova">
</form>