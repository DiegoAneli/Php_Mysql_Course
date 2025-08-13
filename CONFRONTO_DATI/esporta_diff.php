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

//creiamo una mappa associatiiva del csv dove la chiave è il mese e il valore è il numero corrispondente
$csvMap= [];

foreach($csv as $r){

    // esempio : $csvMap = ['Gennaio' => 120, 'Febbraio' => 100, ...] 
    $csvMap[$r['mese']] = $r['valore'];

}

//preparazione della query per ottenere i dati dal DB e i valori relativi all anno selezionato

$stmt = $conn->prepare("SELECT mese, valore FROM dati WHERE anno = ?");
$stmt->bind_param("i", $anno);
$stmt->execute();

//ottenere il risultato della query get_Result()
$result = $stmt->get_result();


//array dove verranno memorizzati le differenze tra CSV e DB
$diff = [];

// CICLO PER OGNI RIGA DEL RISULTATO DELLA QUERY
while ($row = $result->fetch_assoc()){
    $mese = $row['mese'];
    $dbVal = (int)$row['valore'];
    $csvVal = $csvMap[$mese] ?? 0;
    $diff[] = [$mese, $dbVal, $csvVal, $csvVal - $dbVal];
}

//impostiamo l intestazione HTTP per dire al browser che sto restituendo un file CSV
header('Content-Type: text/csv ');


//impostiamo il nome del file da scaricare
header('Content-Disposition: attachment; filename="differenze_' . $anno . '.csv"');

// apriamo lo stream di output per scrivere nel file scaricato
$output = fopen('php://output', 'w');

// scriviamo la riga di intestazione nel file csv
fputcsv($output, ['Mese','Valore DB', 'Valore CSV', 'Differenza']);

// scriviamo ogni riga delle differenze nel file csv
foreach($diff as $r) fputcsv($output, $r);

//chiudiamo lo stream 
fclose($output);

//terminiamo lo script

exit;


?>