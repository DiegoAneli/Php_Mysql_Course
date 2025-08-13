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

//query per inserire o aggiornare i dati nella tabella "dati"
//REPLACE funziona come un INSERT ma sovrascrive la riga se esiste già con la stessa chiave primaria
$stmt = $conn->prepare("REPLACE INTO dati (mese, valore, anno) VALUES (?, ?, ?)");

//query per salvare anche una copia in cronologia
//in questo caso è un INSERT per mantere traccia di ogni modifica
$cron = $conn->prepare("INSERT INTO cronologia (mese, valore, anno, origine) VALUES (?, ?, ?, 'CSV')");


//cicla su tutte le righe del file CSV
foreach ($csv as $r){

    //colleghiamo i parametri alla query 'REPLACE INTO dati'
    //"sii" indica i tipi dei valori stringa(mese) intero (valore) intero(anno)
    $stmt->bind_param("sii", $r['mese'], $r['valore'], $anno);

    //esecuzione delle query
    $stmt->execute();

    //collego i parametri anche per la cronologia

    $cron->bind_param("sii", $r['mese'], $r['valore'], $anno);

    //esecuzione delle query cronologia
    $cron->execute();

}

//chiudiamo le query 
$stmt->close();
$cron->close();

//chiudiamo la sessione

$conn->close();

//mostriamo un messaggio di conferma e un link per tornare alla home page(index)

echo "<h3> Dati salvati nel DB per l anno di riferimento $anno</h3><a href='index.php'>Torna alla HomePage</a>";
?>