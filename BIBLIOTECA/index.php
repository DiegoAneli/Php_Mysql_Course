<?php
require_once 'functions.php';

session_start();


//inizializza la libreria

if(!isset($_SESSION['library'])){

    $_SESSION['library'] = [];

}

$library = &$_SESSION['library'];


//cancellazione di un libro

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {

    $indexToDelete = (int)$_POST['index'];
    deleteBook($library, $indexToDelete);
    $messagge = "Libro rimosso";
    
}


//aggiunta libro

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])){

    $title= trim($_POST['title']);
    $author= trim($_POST['author']);
    
    if($title && $author){

        addBook($library, $title, $author);
        $message = "Libro aggiunto";

    }else {

        $message = "Inserisci titolo e autore";
    }
}

//ricerca di un libro

$searcResult = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {

    $searchTitle = trim($_POST['search_title']);
    $searchResult = searchBook($library, $searchTitle);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<body>

 <?php include 'header.php' ?>
    

    <h3>Aggiungi Libro</h3>
    <form method="POST" class="row g-3 mb-4">

        <div class="col-md-5">
            <input type="text" name="title" class="form-control" placeholder="Titolo">
        </div>
        <div class="col-md-5">
            <input type="text" name="author" class="form-control" placeholder="Autore">
        </div>
        <div class="col-md-2">
            <button type="submit" name="add" class="btn btn-primary w-100">Aggiungi</button>
        </div>

    </form>

    <h3>Cerca Libro</h3>
    <form method="POST" class="row g-3 mb-4">

        <div class="col-md-10">
            <input type="text" name="search_title" class="form-control" placeholder="Titolo da cercare">
        </div>
        <div class="col-md-2">
            <button type="submit" name="search" class="btn btn-primary w-100">Cerca</button>
        </div>
    </form>


    <h3>Elenco Libri</h3>

    <?php if (empty($library)): ?>
        <p class="text-muted">Nessun Libro presente</p>
    <?php else: ?>
        <ul class="list-group mb-4">

            <?php foreach($library as $index => $book): ?>

            <li class="list-group-item d-flex justify-content-between align-items-center">

            <?= $book->getInfo()  ?>

            <form method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare?')">
                <input type="hidden" name="index" value="<?= $index ?>">
                <button type="submit" name="delete" class="btn btn-sm btn-danger">Cancella</button>
            </form>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2 class="text-muted">Debug Session</h2>
    <pre class="bg-light p-3 border rounded"><?php print_r($_SESSION) ?> </pre>
 
 <?php include 'footer.php' ?>