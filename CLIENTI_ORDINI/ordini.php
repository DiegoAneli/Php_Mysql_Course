<?php

require 'db.php';

$contatto_id = $_GET['id']; // recupero l id del contatto

$contatto = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM contatti WHERE id=$contatto_id")); //dati del contatto
$ordini = mysqli_query($conn, "SELECT * FROM ordini WHERE contatto_id = $contatto_id");// ordini del contatto

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordini di <?= $contatto['nome'] ?></title>
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
</head>
<body>


    <div class="container">

    <h2>Ordini per <?= $contatto['nome'] ?></h2>

    <a href="aggiungi_ordine.php?id= <?= $contatto_id ?>" class="button">Nuovo Ordine</a>

    <table>
        <tr>
            <th>Prodotto</th>
            <th>Quantità</th>
            <th>Data</th>
        </tr>


        <?php while ($o = mysqli_fetch_assoc($ordini)):    ?>


        <tr>
            <td><?= $o['prodotto']   ?></td>
            <td><?= $o['quantita']   ?></td>
            <td><?= $o['data_ordine']   ?></td>
        </tr>

        <?php endwhile; ?>
    </table>

        <a href="index.php" class="button">Indietro</a>

    </div>    
</body>
</html>