<?php  

//avviare la sessione per accedere ai dati salvati in $_SESSION
session_start();

//Includere il file di connessione al db
include 'db.php';


//controllare se nella sessione esistono i dati csv oppure l anno selezionato 
//e se uno dei due non è presente termina con messaggio di errore
if(!isset($_SESSION['csv']) || !isset($_SESSION['anno'])) die("Errore: dati CSV o Anno non disponibili");


//recuperiamo i dati CSV dalla sessione
$csv = $_SESSION['csv'];

//recupero l anno selezionato
$anno = (int)$_SESSION['anno'];


foreach( $csv as $r ){

    //query che verifica se esiste già nel DB un record per quel mese e anno
    $stmt = $conn->prepare("SELECT COUNT(*) FROM dati WHERE mese = ? AND anno = ?");
    $stmt->bind_param("si", $r['mese'], $anno);
    $stmt->execute();
    $stmt->bind_result($count); //leghiamo la colonna di risultato alla variabile $count
    $stmt->fetch();
    $stmt->close();

    //se il record esiste già (cioè esiste già quel mese in quell anno, entriamo nell IF )
    //quindi se non esiste non fa nulla per quel mese quindi nessun INSERT
    if ($count > 0) {

        //Aggiorna il campo valore del record esistente (mese + anno)
        $stmt = $conn->prepare("UPDATE dati SET valore = ? WHERE mese = ? AND anno = ?");
        $stmt->bind_param("isi", $r['valore'], $r['mese'], $anno);
        $stmt->execute();
        $stmt->close();


        $cron = $conn->prepare("INSERT INTO cronologia (mese, valore, anno, origine) VALUES (?, ?, ?, 'CSV')");
        $cron->bind_param("sii", $r['mese'], $r['valore'], $anno);
        $cron->execute();
        $cron->close();
    }
}

$conn->close();
echo "<h3> Solo i mesi esistenti aggiornati per l anno $anno </h3><a href='index.php'>Torna alla home page</a>";

?>