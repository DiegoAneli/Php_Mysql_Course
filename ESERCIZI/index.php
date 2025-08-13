<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index per esercizi con Include</title>
</head>
<body>


<h1>Controlla se una parola è palindroma</h1>


<form method="get">

    Inserisci una parola : <input type="text" name="parola">
    <input type="submit" value="verifica">

</form>


<?php

    include 'palindromo.php';
?>

    
</body>
</html>