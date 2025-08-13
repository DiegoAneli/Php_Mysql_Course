<?php

//Definizione della classe Contact per rappresentare ogni contatto nella lista
class Contact{

    //Attributi
    public string $name;
    public string $phone; 
    //Costruttore : inizializza nome e telefono quando si crea un oggetto
    public function __construct(string $name , string $phone){

        $this->name = $name;
        $this->phone = $phone;

    }
    //Metodo per ottenere una stringa con le info del contatto
    public function getInfo(): string { 
        return "Nome : $this->name - Telefono $this->phone";
    }
}
?>