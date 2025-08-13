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


foreach( $csv as $r ){

    //query 
    $stmt = $conn->prepare("SELECT valore FROM dati WHERE mese = ? AND anno = ?");
    $stmt->bind_param("si", $r['mese'], $anno);
    $stmt->execute();
    $stmt->bind_result($val); //leghiamo la colonna di risultato alla variabile $val


   
    if ($stmt->fetch()) {

        $stmt->close();
       
        $nuovo = $val + $r['valore'];

        $upd = $conn->prepare("UPDATE dati SET valore = ? WHERE mese = ? AND anno = ?");
        $upd->bind_param("isi", $nuovo, $r['mese'], $anno );
        $upd->execute();
        $upd->close();
      


    }else {
        
        $stmt->close();
        //ins -> inserimento
        $ins = $conn->prepare("INSERT INTO dati (mese, valore, anno) VALUES (?, ?, ?)");
        $ins->bind_param("sii", $r['mese'],$r['valore'], $anno );
        $ins->execute();
        $ins->close();

    }
    $cron = $conn->prepare("INSERT INTO cronologia (mese, valore, anno, origine) VALUES (?, ?, ?, 'CSV')");
    $cron->bind_param("sii", $r['mese'], $r['valore'], $anno);
    $cron->execute();
    $cron->close();
}

$conn->close();
echo "<h3> Valori sommati per l anno $anno </h3><a href='index.php'>Torna alla home page</a>";

?>



        