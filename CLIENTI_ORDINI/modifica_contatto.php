<?php

require 'db.php';
//recuperare l id del contatto dela query strings

$id = intval($_GET['id']);
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM contatti WHERE id=$id"));

//form
if($_SERVER["REQUEST_METHOD"] == "POST") {

    //recupero dati
    $nome = $_POST['nome']; //nuovo nome
    $telefono = $_POST['telefono']; // nuovo tel
    $mail = $_POST['mail'];// nuova email
    //aggiornare contatto
    mysqli_query($conn, "UPDATE contatti SET nome='$nome', telefono='$telefono', mail='$mail' WHERE id=$id ");
    //reindirizzamento alla index
    header("Location: index.php");

}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Contatto</title>
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
</head>
<body>
    

    <div class="container">

        <h1>Modifica Contatto</h1>

        <form method="post">

            Nome: <input type="text" name="nome" value="   <?= $row['nome']?>   " required><br>

            Telefono: <input type="text" name="telefono" value="   <?= $row['telefono']?>   " required><br>

            Email: <input type="text" name="mail" value="   <?= $row['mail']?>   " required><br>


            <button type="submit">Aggiorna</button>

        </form>

        <a href="index.php" class="button">Torna alla lista</a>
    </div>
</body>
</html>





