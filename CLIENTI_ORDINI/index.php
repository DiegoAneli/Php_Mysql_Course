<?php

require 'db.php';

$result = mysqli_query($conn, "SELECT * FROM contatti" );

?>


<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contatti_ordini</title>
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
</head>
<body>
    <div class="container">
        <h2>Contatti</h2>
        <a href="aggiungi_contatto.php" class="button">➕ Aggiungi Contatto</a>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Telefono</th>
                    <th>Mail</th>
                    <th>Actions</th>
                </tr>
            </thead>
     


        <tbody>

            <?php  
            
                while ($row = mysqli_fetch_assoc($result)): ?>

                <tr>
                    <td><?= htmlspecialchars($row['nome'])    ?></td><!-- mostra nome -->
                    <td><?= htmlspecialchars($row['telefono'])    ?></td><!-- mostra telefono -->
                    <td><?= htmlspecialchars($row['mail'])    ?></td><!-- mostra email -->
                    <td class="actions">

                        <a href="modifica_contatto.php?id=<?= $row['id']  ?>">🖊️</a><!-- link di modifica -->
                        <a href="elimina_contatto.php?id=<?= $row['id']  ?>">🗑️</a><!-- link di elimina -->
                        <a href="ordini.php?id=<?= $row['id']  ?>">📦</a><!-- link ordini del contatto -->
                        
                    </td><!-- mostra azioni -->
                </tr>
            
                <?php endwhile; ?>

        </tbody>
        </table>
    </div>
</body>
</html>