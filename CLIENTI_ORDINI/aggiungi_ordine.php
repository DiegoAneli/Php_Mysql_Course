<?php

require 'db.php';

//prendere l id del contatto a cui legare l ordine

$contatto_id = $_GET['id'];

if($_SERVER["REQUEST_METHOD"] == "POST") {

    //Recuperiamo i dati inviati dal form

    $prodotto = $_POST['prodotto'];
    $quantita = $_POST['quantita'];
    $data = $_POST['data'];


    //query

    $sql = "INSERT INTO ordini (contatto_id, prodotto, quantita, data_ordine) VALUES ( '$contatto_id','$prodotto','$quantita','$data')";

    //eseguo la query
    mysqli_query($conn, $sql);


    //reindirizziamo utente alla home page post inserimento

    header("Location: ordini.php?id=$contatto_id");



}
?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Ordine</title>
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
</head>
<body>


    <div class="container">

        <h2>Aggiungi Ordine</h2>

        <form method="post">

            Prodotto: <input name="prodotto" required> <br>

            Quantità: <input name="quantita" required> <br>

            Data Ordine: <input type="date" name="data" required> <br>

            <button type="submit">Aggiungi Ordine</button>

        </form>

        <a href="ordini.php?id= <?= $contatto_id ?>" class="button">Torna agli ordini</a>



    </div>
</body>
</html>