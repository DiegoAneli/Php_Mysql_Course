<?php

require_once 'Contact.php';

//funzione per aggiungere oggetto contact alla rubrica
function addContact(array &$rubrica, string $name, string $phone) : void {

    // devo creare un nuovo oggetto contatto che si aggiunge all array
    $rubrica[] = new Contact($name, $phone);


}

//funzione che stampa tutti i contatti
function printContacts(array $rubrica): void {

    foreach ($rubrica as $contatto){

        echo $contatto->getInfo() . "<br>"; // vado a recuperare il metodo getInfo() della classe
    }

}

//ricerca un contatto per nome, restituisco l oggetto o null
function searchContact(array $rubrica, string $name): ?Contact {

    foreach ($rubrica as $contatto) {

        if(strtolower($contatto->name) === strtolower($name)){

            return $contatto;
        }
    }
    return null; // nessun contatto trovato
}

?>