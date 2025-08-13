<?php

//avviare la sessione per accedere ai dati salvati in $_SESSION
session_start();

//Includere il file di connessione al db
include 'db.php';


//controllare se nella sessione esistono i dati csv oppure l anno selezionato 
//e se uno dei due non è presente termina con messaggio di errore
if(!isset($_SESSION['csv']) || !isset($_SESSION['anno'])){
    die("Errore: dati CSV o Anno non disponibili");
}



//recuperiamo i dati CSV dalla sessione
$csv = $_SESSION['csv'];

//recupero l anno selezionato
$anno = (int)$_SESSION['anno'];



$stmt = $conn->prepare("INSERT INTO cronologia (mese, valore, anno, origine) VALUES (?, ?, ?, 'CSV')");

foreach($csv as $r ){

    $stmt->bind_param("sii", $r['mese'], $r['valore'], $anno);
    $stmt->execute();

}

$stmt->close();
$conn->close();


echo "<h3> Salvati in cronologia per l anno $anno </h3><a href='index.php'>Torna alla home page</a>";



?>