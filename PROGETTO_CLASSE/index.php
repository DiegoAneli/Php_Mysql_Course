<?php include 'header.php'; ?>

<div class="text-center py-4">
  <h1 class="display-5">Benvenuto nell'Agenzia Viaggi</h1>
  <p class="lead">Esplora le nostre destinazioni, gestisci i clienti e monitora le prenotazioni!</p>
</div>

<!-- Sezione immagini -->
<div class="d-flex justify-content-center align-items-center mb-5 flex-wrap gap-4">
  <img src="donna.png" alt="Donna Viaggiatrice" class="img-fluid" style="max-height: 300px; transform: scaleX(-1);">
  <img src="uomo.png" alt="Uomo Viaggiatore" class="img-fluid" style="max-height: 300px;">
</div>

<!-- Sezione card -->
<div class="row justify-content-center mb-5">
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body text-center">
        <h5 class="card-title">Clienti</h5>
        <p class="card-text">Gestisci le informazioni dei tuoi clienti.</p>
        <a href="clienti.php" class="btn btn-primary">Vai a Clienti</a>
      </div>
    </div>
  </div>

  <div class="col-md-4 mt-3 mt-md-0">
    <div class="card shadow-sm">
      <div class="card-body text-center">
        <h5 class="card-title">Destinazioni</h5>
        <p class="card-text">Consulta o aggiungi nuove mete turistiche.</p>
        <a href="destinazioni.php" class="btn btn-success">Vai a Destinazioni</a>
      </div>
    </div>
  </div>

  <div class="col-md-4 mt-3 mt-md-0">
    <div class="card shadow-sm">
      <div class="card-body text-center">
        <h5 class="card-title">Prenotazioni</h5>
        <p class="card-text">Visualizza e registra le prenotazioni dei tuoi clienti.</p>
        <a href="prenotazioni.php" class="btn btn-warning">Vai a Prenotazioni</a>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
