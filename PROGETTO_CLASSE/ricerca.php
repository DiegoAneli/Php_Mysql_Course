<?php  

include 'db.php';

//paginazione

$perPagina = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPagina;



//QUERY DINAMICA DEI CAMPI DI RICERCA SUL DB(TROVO I CAMPI INDISTINTAMENTE O CON ASSOCIAZIONE DI CAMPI SELEZIONATI )

//filtri
$nome_cliente = $_GET['nome_cliente'] ?? '';
$paese = $_GET['paese'] ?? '';
$citta = $_GET['citta'] ?? '';
$prezzo_max = $_GET['prezzo_max'] ?? '';
$data = $_GET['data'] ?? '';
$persone = $_GET['num_persone'] ?? '';



//costruzione delle query
$where = "WHERE 1=1";
$params = [];
$types = '';


if($nome_cliente !== '') {
    $where .= " AND (c.nome LIKE ? OR c.cognome LIKE ?)";
    $params[] = "%$nome_cliente%";
    $params[] = "%$nome_cliente%";
    $types .= 'ss';

}
if($paese !== ''){
    $where .= " AND d.paese LIKE ?";
    $params[] = "%$paese%";
    $types .= 's';

}
if($citta !== '') {
    $where .= " AND d.citta LIKE ?";
    $params[] = "%$citta%";
    $types .= 's';
}
if($prezzo_max !== ''){
    $where .= " AND d.prezzo <= ?";
    $params[] = floatval($prezzo_max);
    $types .= 'd';
}
if($data !== '') {
    $where .= " AND p.data_prenotazione = ?";
    $params[] = $data;
    $types .= 's';

}
if($persone !== ''){
    $where .= " AND p.num_persone = ?";
    $params[] = intval($persone);
    $types .= 'i';
    
}



//conteggio totale prenotazioni clienti destinazioni


$stmt = $conn->prepare("SELECT COUNT(*) as total 
                        FROM prenotazioni p
                        JOIN clienti c ON p.id_cliente = c.id
                        JOIN destinazioni d ON p.id_destinazione = d.id
                        $where");
if ($types !== '') $stmt->bind_param($types, ...$params);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];
$totalPages = ceil($total / $perPagina);




//risultati paginati
$stmt = $conn->prepare("SELECT p.id, c.nome, c.cognome, d.citta, d.paese, d.prezzo, p.data_prenotazione, p.num_persone
                        FROM prenotazioni p
                        JOIN clienti c ON p.id_cliente = c.id
                        JOIN destinazioni d ON p.id_destinazione = d.id
                        $where ORDER BY p.id ASC LIMIT ? OFFSET ?");


$params[] = $perPagina;
$params[] = $offset;
$types .= 'ii';
$stmt->bind_param($types, ...$params);
$stmt->execute();
$results = $stmt->get_result();





?>

<?php include 'header.php';   ?>


<h2>Ricerca Prenotazioni</h2>


<form method="GET" class="row g-2 mb-4">

    <div class="col-md-2"><input type="text" name="nome_cliente" value="<?= htmlspecialchars($nome_cliente) ?>" class="form-control" placeholder="Cliente"></div>
    <div class="col-md-2"><input type="text" name="paese" value="<?= htmlspecialchars($paese) ?>" class="form-control" placeholder="Paese"></div>
    <div class="col-md-2"><input type="text" name="citta" value="<?= htmlspecialchars($citta) ?>" class="form-control" placeholder="Citta"></div>
    <div class="col-md-2"><input type="number" name="prezzo_max" value="<?= htmlspecialchars($prezzo_max) ?>" class="form-control" placeholder="Prezzo max euro"></div>
    <div class="col-md-2"><input type="date" name="data" value="<?= htmlspecialchars($data) ?>" class="form-control"></div>
    <div class="col-md-2"><input type="number" name="num_persone" value="<?= htmlspecialchars($persone) ?>" class="form-control" placeholder="N. persone"></div>

    <div class="col-12 d-flex justify-content-between mt-2">
        <button class="btn btn-primary">Cerca</button>
    </div>
</form>


<?php if ($results && $results->num_rows > 0): ?>
<table class="table table-striped">

<thead>
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Città</th>
        <th>Paese</th>
        <th>Prezzo</th>
        <th>Data</th>
        <th>Persone</th>
    </tr>
</thead>
<tbody>
    <?php while($r = $results->fetch_assoc()): ?>

        <tr>
            <td><?= $r['id'] ?></td>
            <td><?= $r['nome'] ?> <?= $r['cognome'] ?></td>
            <td><?= $r['citta'] ?></td>
            <td><?= $r['paese'] ?></td>
            <td><?= $r['prezzo'] ?></td>
            <td><?= $r['data_prenotazione'] ?></td>
            <td><?= $r['num_persone'] ?></td>
        </tr>
    <?php endwhile; ?>
</tbody>
</table>


<nav>
  <ul class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <li class="page-item <?= $i === $page ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $i ?>"    >     <?= $i ?>      </a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>

<?php else: ?>
    <p class="text-muted">Nessun risultato trovato</p>
<?php endif; ?>


<?php include 'footer.php';   ?>