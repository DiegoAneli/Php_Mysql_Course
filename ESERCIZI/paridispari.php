<?php

if(isset($_GET['numero'])) {
    
    $num = $_GET['numero'];
    
    if($num % 2 == 0) {

        echo "<p>$num è pari </p>";
    }else {

        echo "<p>$num è dispari </p>";
    }
}

?>


<form method="get">
    
    Inserisci un numero : 
    <input type="number" name="numero">
    <input type="submit" value="Verifica">

</form>