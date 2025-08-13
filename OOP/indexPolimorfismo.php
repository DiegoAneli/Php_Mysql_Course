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

$gatto = new Gatto(nome: "Micio", specie: "Maincoon", peso: 13, habitat: "Divano");


function faiParlare(Animale $animale){

    echo "{$animale->nome} ({$animale->specie}) dice: " . $animale->verso() . "<br>";
    echo "Peso : {$animale->peso} kg, Habitat: {$animale->habitat}<br><br>";
    
}


faiParlare(animale: $gatto);
faiParlare(animale: $cane);



?>
