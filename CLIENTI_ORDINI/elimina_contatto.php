<?php

require 'db.php';

//recupero l id
$id = intval($_GET['id']);

//query di eliminazione
mysqli_query($conn, "DELETE FROM contatti WHERE id=$id");

header("Location: index.php"); //ritorna ad index



?>