<?php
include 'db.php';
include 'header.php';

// Paginazione
$perPagina = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPagina;

// Aggiunta
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['aggiungi'])) {
  $stmt = $conn->prepare("INSERT INTO clienti (nome, cognome, email, telefono) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['telefono']);
  $stmt->execute();
  echo "<div class='alert alert-success'>Cliente aggiunto!</div>";
}

// Eliminazione
if (isset($_GET['elimina'])) {
  $id = intval($_GET['elimina']);
  $conn->query("DELETE FROM clienti WHERE id = $id");
  echo "<div class='alert alert-danger'>Cliente eliminato.</div>";
}

// Modifica
$cliente_modifica = null;
if (isset($_GET['modifica'])) {
  $res = $conn->query("SELECT * FROM clienti WHERE id = " . intval($_GET['modifica']));
  $cliente_modifica = $res->fetch_assoc();
}

// Salvataggio modifica
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['salva_modifica'])) {
  $stmt = $conn->prepare("UPDATE clienti SET nome=?, cognome=?, email=?, telefono=? WHERE id=?");
  $stmt->bind_param("ssssi", $_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['telefono'], $_POST['id']);
  $stmt->execute();
  echo "<div class='alert alert-info'>Cliente aggiornato!</div>";
}
?>

<h2>Clienti</h2>

<div class="card mb-4">
  <div class="card-body">
    <form method="POST">
      <?php if ($cliente_modifica): ?>
        <input type="hidden" name="id" value="<?= $cliente_modifica['id'] ?>">
      <?php endif; ?>
      <div class="row g-2">
        <div class="col"><input type="text" name="nome" class="form-control" placeholder="Nome" value="<?= $cliente_modifica['nome'] ?? '' ?>" required></div>
        <div class="col"><input type="text" name="cognome" class="form-control" placeholder="Cognome" value="<?= $cliente_modifica['cognome'] ?? '' ?>" required></div>
        <div class="col"><input type="email" name="email" class="form-control" placeholder="Email" value="<?= $cliente_modifica['email'] ?? '' ?>" required></div>
        <div class="col"><input type="text" name="telefono" class="form-control" placeholder="Telefono" value="<?= $cliente_modifica['telefono'] ?? '' ?>" required></div>
        <div class="col">
          <button type="submit" name="<?= $cliente_modifica ? 'salva_modifica' : 'aggiungi' ?>" class="btn btn-<?= $cliente_modifica ? 'warning' : 'success' ?>">
            <?= $cliente_modifica ? 'Salva' : 'Aggiungi' ?>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php
$total = $conn->query("SELECT COUNT(*) as t FROM clienti")->fetch_assoc()['t'];
$totalPages = ceil($total / $perPagina);
$result = $conn->query("SELECT * FROM clienti ORDER BY id ASC LIMIT $perPagina OFFSET $offset");
?>

<table class="table table-striped">
  <thead>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Email</th>
        <th>Telefono</th>
        <th>Azioni</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['nome'] ?></td>
      <td><?= $row['cognome'] ?></td>
      <td><?= $row['email'] ?></td>
      <td><?= $row['telefono'] ?></td>
      <td>
        <a href="?modifica=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Modifica</a>
        <a href="?elimina=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Sicuro?')">Elimina</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<!-- Paginazione -->
<nav>
  <ul class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <li class="page-item <?= $i == $page ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>

<?php include 'footer.php'; ?>
