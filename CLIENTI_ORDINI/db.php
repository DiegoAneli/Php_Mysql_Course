<?php

//connessione al database Mysql utilizzando MySQLi

//parametri di connessione al db
$host = "localhost";   // host del db
$user = "root";        // utente
$password = "";
$database = "contatti_ordini"; // nome del db in phpmyadmin

//creiamo la connessione al db
$conn = mysqli_connect($host, $user, $password, $database);  

//verifica della connessione

if(!$conn){
    //se la connessione fallisce stampa un messaggio di errore e termina lo script
    die("Connessione fallita: " . mysqli_connect());
}

?>