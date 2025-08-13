<?php
include 'db.php';
include 'header.php';

$anno = $_GET['anno'] ?? date('Y');
$destinazione = $_GET['destinazione'] ?? '';

// Anni disponibili
$anni = [];
$res = $conn->query("SELECT DISTINCT YEAR(data_prenotazione) AS anno FROM prenotazioni ORDER BY anno DESC");
while ($row = $res->fetch_assoc()) $anni[] = $row['anno'];

// Destinazioni disponibili
$destinazioni = [];
$res2 = $conn->query("SELECT DISTINCT citta FROM destinazioni ORDER BY citta");
while ($row = $res2->fetch_assoc()) $destinazioni[] = $row['citta'];

// Dati mensili
$mesi = [];
$valori = [];
$entrate = [];

for ($m = 1; $m <= 12; $m++) {
  $mesi[] = date('M', mktime(0,0,0,$m,1));
  $sql = "
    SELECT COUNT(*) AS tot, SUM(d.prezzo * p.num_persone) AS incasso
    FROM prenotazioni p
    JOIN destinazioni d ON p.id_destinazione = d.id
    WHERE MONTH(p.data_prenotazione)=? AND YEAR(p.data_prenotazione)=?
  ";
  $types = "ii"; $params = [$m, intval($anno)];
  if ($destinazione !== '') {
    $sql .= " AND d.citta = ?";
    $types .= "s"; $params[] = $destinazione;
  }
  $stmt = $conn->prepare($sql);
  $stmt->bind_param($types, ...$params);
  $stmt->execute();
  $r = $stmt->get_result()->fetch_assoc();
  $valori[] = (int)($r['tot'] ?? 0);
  $entrate[] = round(floatval($r['incasso'] ?? 0), 2);
}

// Esportazione CSV
if (isset($_GET['action']) && $_GET['action'] === 'export_csv') {
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="statistiche_'.$anno.'.csv"');
  $f = fopen('php://output', 'w');
  fputcsv($f, ['Mese', "Prenotazioni ($anno)", "Entrate (€)"]);
  for ($i = 0; $i < 12; $i++) {
    fputcsv($f, [$mesi[$i], $valori[$i], $entrate[$i]]);
  }
  exit;
}
?>

<h2 class="mb-4">Statistiche Avanzate</h2>

<form method="GET" class="row g-3 mb-4">
  <div class="col-md-3">
    <label>Anno</label>
    <select name="anno" class="form-select">
      <?php foreach ($anni as $a): ?>
        <option value="<?= $a ?>" <?= $a == $anno ? 'selected' : '' ?>><?= $a ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-3">
    <label>Destinazione</label>
    <select name="destinazione" class="form-select">
      <option value="">Tutte</option>
      <?php foreach ($destinazioni as $d): ?>
        <option value="<?= htmlspecialchars($d) ?>" <?= $d == $destinazione ? 'selected' : '' ?>><?= htmlspecialchars($d) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-3 d-flex align-items-end">
    <button class="btn btn-primary">Aggiorna</button>
  </div>
  <div class="col-md-3 d-flex align-items-end justify-content-end">
    <a href="statistiche.php?<?= http_build_query(array_merge($_GET, ['action'=>'export_csv'])) ?>" class="btn btn-outline-success">
      Esporta Dati CSV
    </a>
  </div>
</form>

<div class="row">
  <div class="col-md-6 mb-4">
    <div class="card p-3">
      <h5 class="text-center">📈 Prenotazioni per mese (<?= $anno ?>)</h5>
      <canvas id="lineaPrenotazioni"></canvas>
      <button onclick="downloadChart('lineaPrenotazioni', 'prenotazioni_<?= $anno ?>.png')" class="btn btn-sm btn-outline-secondary mt-3">
        Scarica PNG
      </button>
    </div>
  </div>
  <div class="col-md-6 mb-4">
    <div class="card p-3">
      <h5 class="text-center">💰 Entrate mensili (<?= $anno ?>)</h5>
      <canvas id="barEntrate"></canvas>
      <button onclick="downloadChart('barEntrate', 'entrate_<?= $anno ?>.png')" class="btn btn-sm btn-outline-secondary mt-3">
        Scarica PNG
      </button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const mesi = <?= json_encode($mesi) ?>;
const pren = <?= json_encode($valori) ?>;
const entr = <?= json_encode($entrate) ?>;

new Chart(document.getElementById("lineaPrenotazioni"), {
  type: "line",
  data: {
    labels: mesi,
    datasets: [{
      label: "Prenotazioni",
      data: pren,
      borderColor: "rgba(75,192,192,1)",
      backgroundColor: "rgba(75,192,192,0.2)",
      fill: true,
      tension: 0.3
    }]
  },
  options: { responsive: true }
});

new Chart(document.getElementById("barEntrate"), {
  type: "bar",
  data: {
    labels: mesi,
    datasets: [{
      label: "Entrate (€)",
      data: entr,
      backgroundColor: "rgba(255,159,64,0.6)",
      borderColor: "rgba(255,159,64,1)",
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: { beginAtZero: true }
    }
  }
});

// Funzione per scaricare grafico come PNG
function downloadChart(canvasId, filename) {
  const canvas = document.getElementById(canvasId);
  const link = document.createElement("a");
  link.href = canvas.toDataURL("image/png");
  link.download = filename;
  link.click();
}
</script>

<?php include 'footer.php'; ?>
