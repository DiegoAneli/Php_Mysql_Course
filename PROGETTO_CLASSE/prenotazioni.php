<?php
include 'db.php';
include 'header.php';

// Inserimento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aggiungi'])) {
  $stmt = $conn->prepare("INSERT INTO prenotazioni (id_cliente, id_destinazione, data_prenotazione, num_persone) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("iisi", $_POST['id_cliente'], $_POST['id_destinazione'], $_POST['data_prenotazione'], $_POST['num_persone']);
  $stmt->execute();
  echo "<div class='alert alert-success'>Prenotazione aggiunta!</div>";
}

// Eliminazione
if (isset($_GET['elimina'])) {
  $id = intval($_GET['elimina']);
  $conn->query("DELETE FROM prenotazioni WHERE id = $id");
  echo "<div class='alert alert-danger'>Prenotazione eliminata.</div>";
}

// Dropdown
$clienti = $conn->query("SELECT id, nome, cognome FROM clienti");
$destinazioni = $conn->query("SELECT id, citta, paese FROM destinazioni");

// Paginazione
$perPagina = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPagina;
$total = $conn->query("SELECT COUNT(*) as tot FROM prenotazioni")->fetch_assoc()['tot'];
$totalPages = ceil($total / $perPagina);

$stmt = $conn->prepare("
  SELECT p.id, c.nome, c.cognome, d.citta, d.paese, p.data_prenotazione, p.num_persone
  FROM prenotazioni p
  JOIN clienti c ON p.id_cliente = c.id
  JOIN destinazioni d ON p.id_destinazione = d.id
  ORDER BY p.id ASC LIMIT ? OFFSET ?
");
$stmt->bind_param("ii", $perPagina, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Prenotazioni</h2>

<!-- FORM INSERIMENTO -->
<form method="POST" class="mb-4 row g-2">
  <div class="col-md-3">
    <select name="id_cliente" class="form-select" required>
      <option value="">Seleziona cliente</option>
      <?php while($c = $clienti->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>"><?= $c['nome'] ?> <?= $c['cognome'] ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="col-md-3">
    <select name="id_destinazione" class="form-select" required>
      <option value="">Seleziona destinazione</option>
      <?php while($d = $destinazioni->fetch_assoc()): ?>
        <option value="<?= $d['id'] ?>"><?= $d['citta'] ?> (<?= $d['paese'] ?>)</option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="col-md-2">
    <input type="date" name="data_prenotazione" class="form-control" required>
  </div>
  <div class="col-md-2">
    <input type="number" name="num_persone" class="form-control" placeholder="N. persone" required>
  </div>
  <div class="col-md-2">
    <button name="aggiungi" class="btn btn-success w-100">Aggiungi</button>
  </div>
</form>

<!-- ELENCO -->
<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Cliente</th>
      <th>Destinazione</th>
      <th>Data</th>
      <th>Persone</th>
      <th>Azioni</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['nome'] ?> <?= $row['cognome'] ?></td>
      <td><?= $row['citta'] ?> (<?= $row['paese'] ?>)</td>
      <td><?= $row['data_prenotazione'] ?></td>
      <td><?= $row['num_persone'] ?></td>
      <td>
        <a href="?elimina=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Sei sicuro?')">Elimina</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<!-- PAGINAZIONE -->
<nav>
  <ul class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <li class="page-item <?= $i === $page ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>

<?php include 'footer.php'; ?>
