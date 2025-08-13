<?php

require 'db.php';

//reupero dati inviati dal form

if($_SERVER["REQUEST_METHOD"] == "POST"){

    //recupero dati
    $nome = $_POST['nome'];
    $telefono = $_POST['telefono'];
    $mail = $_POST['mail'];

    //query in sql
    $sql = "INSERT INTO contatti (nome, telefono, mail) VALUES ('$nome', '$telefono', '$mail')";

    //esegui la query
    mysqli_query($conn, $sql);

    // reindirizza 
    header("Location: index.php");


}

?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuovo Contatto</title>
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
</head>
<body>


    <div class="container">

        <h1>Nuovo Contatto</h1>


        <form method="post">

            Nome: <input name="nome" required><br>
            Telefono: <input name="telefono" required><br>
            Mail: <input name="mail" required><br>

            <button type="submit">Salva</button>


        </form>

            <a href="index.php" class="button">Torna alla lista</a>

    </div>
</body>
</html>