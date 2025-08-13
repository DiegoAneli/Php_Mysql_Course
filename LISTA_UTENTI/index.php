<?php

require_once 'functions.php'; // importo il codice del file function perchè SERVONO LE FUNZIONI

// Inizializziamo la rubrica con la sessione 
session_start();

if (!isset($_SESSION['rubrica'])) {

    $_SESSION['rubrica'] = []; // prima volta : rubrica nella sessione

}

//creo riferimento all array della sessione con &
$rubrica = &$_SESSION['rubrica'];

//Gestione invio form x aggiungere contatto
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {

    $name = trim($_POST['name']); // prende il nome dal form
    $phone = trim($_POST['phone']); // prendo il numero dal form

    if ($name && $phone) {

        addContact($rubrica, $name, $phone); //aggiunge il contatto alla rubrica
        
        $message ="Contatto aggiunto!";

    }else {

        $message = "Inserisci nome e numero";
    }
}

//Gestione di ricerca 

$searchResult = null;

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])){

    $searchName = trim($_POST['search_name']); // prende il nome da cercare
    $searchResult = searchContact($rubrica, $searchName); // esegue la ricerca
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rubrica contatti PHP</title>
</head>
<body>

    <h1>Rubrica Contatti</h1>

    <h2>Aggiungi contatto</h2>
    <form method="POST">
        Nome : <input type="text" name="name">
        Telefono : <input type="text" name="phone">
        <button type="submit" name="add">Aggiungi</button>
    </form><br>
    

    <h2>Ricerca contatto</h2>
    <form method="POST">
        Nome : <input type="text" name="search_name">
        <button type="submit" name="search">Cerca</button>
    </form>



    <?php if(isset($message)) echo "<p>$message</p>" ?>
    


    <?php   
    //campo ricerca, mostrare risultato
    if ($searchResult !== null ) {

        echo "Risultato" . $searchResult->getInfo();

    }elseif (isset($_POST['search'])) {

        echo "Contatto non trovato";
    }
    ?>



    <h2>Elenco Contatti</h2>
    <?php   printContacts($rubrica);     ?>

    <h2>Debug Sezione</h2>
    <pre> <?php  print_r($_SESSION);    ?> </pre>

</body>
</html>