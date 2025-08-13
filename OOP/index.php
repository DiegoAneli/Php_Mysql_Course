<?php
//Classe GENITORE

//Dichiaro la classe
class Animale {

    public $nome; //attributi
    public $specie; //attributi
    public $peso; //attributi
    public $habitat; //attributi

    //costruttore della classe 
    public function __construct($nome, $specie, $peso, $habitat){

        $this->nome = $nome;
        $this->specie = $specie;
        $this->peso = $peso;
        $this->habitat = $habitat;

    }

    public function verso(){
         return "";
    }

}


//Classe figlio/a con verso cane

class Cane extends Animale {

    public function verso() {

        return "Abbaia";

    }
}


//Classe figlio/a con verso gatto

class Gatto extends Animale {

    public function verso(){

        return "Miagola";
    }
}


//Utilizzo : creare due oggetti di tipo cane e gatto con attributi 

$cane = new Cane(nome: "Fido", specie: "Labrador", peso: 25, habitat: "Giardino");

$cane2 = new Cane(nome: "Nakamoto", specie: "Shiba", peso: 45, habitat: "Salotto");

$gatto = new Gatto(nome: "Micio", specie: "Maincoon", peso: 13, habitat: "Divano");


//Stampa a schermo gli attributi dell oggetto creato Cane
echo "Nome: " . $cane->nome . "<br>";
echo "Specie: " . $cane->specie . "<br>";
echo "Peso: " . $cane->peso . "<br>";
echo "Habitat: " . $cane->habitat . "<br>";
//prendo la funzione
echo "Verso :" .$cane->verso() . "<br>";


//Stampa a schermo gli attributi dell oggetto creato Gatto
echo "Nome: " . $gatto->nome . "<br>";
echo "Specie: " . $gatto->specie . "<br>";
echo "Peso: " . $gatto->peso . "<br>";
echo "Habitat: " . $gatto->habitat . "<br>";
//prendo la funzione
echo "Verso :" .$gatto->verso() . "<br>";

//Stampa a schermo gli attributi dell oggetto creato Cane
echo "Nome: " . $cane2->nome . "<br>";
echo "Specie: " . $cane2->specie . "<br>";
echo "Peso: " . $cane2->peso . "<br>";
echo "Habitat: " . $cane2->habitat . "<br>";
//prendo la funzione
echo "Verso :" .$cane2->verso() . "<br>";

?>
