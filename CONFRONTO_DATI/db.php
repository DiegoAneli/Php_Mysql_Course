<?php   

$conn = new mysqli(

    'localhost',
    'root',
    '',
    'confronto'
);


if ($conn->connect_error){

    die("Connessione fallita: " . $conn->connect_error);
}

?>