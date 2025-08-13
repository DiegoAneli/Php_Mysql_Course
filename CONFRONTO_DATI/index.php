<?php  

session_start();
include 'db.php';


//  <a href="index.php?reset=1" class="btn btn-danger">Ripristina confronto</a>
// quando clicchiamo su ripristina confronto, il parametro reset=1 viene intercettato
// viene cancellato $_SESSION['csv'], quindi vedremo solamente i dati del DB

if(isset($_GET['reset']) && $_GET['reset'] == 1){

    unset($_SESSION['csv']); //rimuove i dati del CSV CARICATO
    header("Location:index.php");
    exit;
}


//imposta e aggiorna l anno selezionato

if (isset($_POST['anno_scelto'])){

    $_SESSION['anno'] = (int)$_POST['anno_scelto'];
    header("Location:index.php");
    exit;
}

//anno corrente come default
$annoCorrente = date('Y');
$annoSelezionato = $_SESSION['anno'] ?? $annoCorrente;

//caricamento dati db per l anno selezionato
$stmt = $conn->prepare("SELECT mese, valore FROM dati 
                        WHERE anno = ? 
                        ORDER BY FIELD(mese, 'Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre')");

$stmt->bind_param("i", $annoSelezionato);
$stmt->execute();
$res = $stmt->get_result();
$dbRows = $res->fetch_all(MYSQLI_ASSOC);


$mesi = [];
$valoriDb = [];

foreach ($dbRows as $r){

    $mesi[]= $r['mese'];
    $valoriDb[] = (int)$r['valore'];

}

//gestione csv

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {

    $file = $_FILES['csv_file']['tmp_name'];
    $csv = [];

    if (($handle = fopen($file, "r")) !== false) {

        //salto la prima riga perchè contiene le intestazioni
        $first = true;
        
        //se è la prima riga la salta e passa alla successiva, poi, impostiamo $first su false per non saltare le righe successive
        //aggiungere ogni riga all array $csv creando una struttura
        //chiudere il file una volta letto tutto
        //salvare tutto l array di dati csv nella session utente
        //recuperare i dati se presenti nella session

        //ciclo while che legge ogni riga del file csv e la trasforma in array($data) separando i campi con la virgola
        while (($data = fgetcsv($handle, 1000, "," )) !== false){

            //se è la prima riga la salta e passa alla successiva, poi, impostiamo $first su false per non saltare le righe successive
            if($first) {
                $first = false;
                continue;
            }
             //aggiungere ogni riga all array $csv creando una struttura
            $csv[] = ['mese' => $data[0], 'valore' => (int)$data[1]];
        }

        //chiudere il file una volta letto tutto
        fclose($handle);
    }

    //recuperare i dati se presenti nella session
    $_SESSION['csv'] = $csv;

}

$csv = $_SESSION['csv'] ?? null;



//PREPARO IL DATI CSV PER IL GRAFICO

//$valoriCsv[] = array_fill(0, 12, 0);
$valoriCsv = array_fill(0, 12, 0);

if($csv) {

    foreach ($csv as $r){
        $idx = array_search($r['mese'], $mesi);
        if ($idx !== false) $valoriCsv[$idx] = $r['valore'];
    }
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confronto tra DB e CSV</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
   
</head>
<body class="bg-light">

    <div class="container py-5">

        <!--Selezione anno -->
        <form method="POST" class="mb-4 d-flex align-items-center gap-3">

            <label for="anno_scelto" class="form-label mb-0">Anno</label>
            <select name="anno_scelto" id="anno_scelto" class="form-select w-auto">
            <?php for ($y = $annoCorrente - 5; $y <= $annoCorrente + 1; $y++ ): ?>

                <option value="<?= $y ?>"<?= ($y == $annoSelezionato) ? 'selected' : '' ?>><?= $y ?></option>
            
            <?php endfor; ?>
            </select>
            <button type="submit" class="btn btn-outline-secondary">Cambia anno</button>
        </form>


        <!-- dati db -->

        <h2 class="mb-4">Dati attuali del database (<?= $annoSelezionato ?>)</h2>

        <!-- Tabella dati db -->
        
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Mese</th>
                        <th>Valore</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($dbRows as $r):   ?>

                    <tr>
                        <td><?= htmlspecialchars($r['mese']) ?></td>
                        <td><?= $r['valore']?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
        </div>


        <!-- Grafico -->

        <div class="card mb-4 shadow-sm p-4" style="min-height: 550px;">
            <h5 class="text-center mb-4">Grafico database <?= $csv ? "+ CSV" : "" ?>(<?= $annoSelezionato ?>)</h5>
            <div class="position-relative" style="width: 100%; height: 400px;">
                <canvas id="graficoDb" style="position: absolute; left: 0; top: 0; width: 100% !important; height: 100% !important;"></canvas>
            </div>
        </div>

        <!-- Form Upload csv -->

        <h4 class="mb-3">Carica un file CSV per il confronto</h4>
        <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm mb-5">
            <div class="mb-3">
                <label class="form-label">Scegli file CSV</label>
                <input type="file" name="csv_file" accept=".csv" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Carica e confronta</button>
        </form>

        <!-- Bottoni di salvataggio -->

        <?php if ($csv): ?>
            <div class="card p-4 shadow-sm">
                <h5 class="mb-3">CSV caricato correttamente ; operazioni disponibili : </h5>
                <div class="d-flex gap-3 flex-wrap">
                    <form action="salva.php" method="POST"> 
                        <button type="submit" class="btn btn-success">Salva CSV nel DB</button>
                    </form>
                    <form action="esporta_diff.php" method="POST"> 
                        <button type="submit" class="btn btn-outline-primary">Esporta Differenze</button>
                    </form>
                    <a href="index.php?reset=1" class="btn btn-danger">Ripristina confronto</a>
                </div>
            </div>

            <!-- Bottoni avanzati -->
            
            <div class="card p-4 shadow-sm mt-4">
                <h5 class="mb-3">Altre modalità di salvataggio</h5>
                <div class="d-flex gap-3 flex-wrap">
                    <form action="salva_aggiorna.php" method="POST"> <button type="submit" class="btn btn-warning">Salva Aggiorna</form></button>
                    <form action="salva_unisci.php" method="POST"> <button type="submit" class="btn btn-info">Solo nuovi mesi</form></button>
                    <form action="salva_somma.php" method="POST"> <button type="submit" class="btn btn-secondary">Somma Valori</form></button>
                    <form action="salva_cronologia.php" method="POST"> <button type="submit" class="btn btn-dark">Solo in cronologia</form></button>
                </div>
            </div>
            <?php endif; ?>
    </div>
    

    <!-- Chart -->

    <script>

    const labels = <?= json_encode($mesi) ?>;
    const datiDb = <?= json_encode($valoriDb) ?>;

    <?php if ($csv): ?>
    const datiCsv = <?= json_encode($valoriCsv) ?>;
    <?php endif; ?>

    const datasets = [

        {
            label: "Dati Database",
            data: datiDb,
            borderColor: "green",
            backgroundColor: "rgba(0, 0, 255, 0.1)",
            tension: 0.3
        }
    ];


    //fare il push del csv dentro la chart

    <?php if ($csv): ?>
        datasets.push({
            label: "Dati Csv",
            data: datiCsv,
            borderColor: "blue",
            backgroundColor: "rgba(0, 0, 255, 0.1)",
            tension: 0.3
        })
    <?php endif; ?>


    new Chart(document.getElementById('graficoDb'), {

        type: "line",
        data: { labels: labels, datasets: datasets },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: 1000,
                    ticks: { stepSize: 50 }
                }
            }
        }
    });

    </script>
</body>
</html>