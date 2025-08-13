<?php

//Classe genitore
class Forma {

    public function area() {

        return 0; // valore default

    }

    public function descrizione(){

        return "Forma generica";

    }
}




//Cerchio
class Cerchio extends Forma {

 public $raggio;

            //costruttore perchè abbiamo l attributo $raggio
            public function __construct($raggio) {

                $this->raggio = $raggio;
            }

    public function area(){

        return round(pi() * pow($this->raggio, 2), 2);
    }


    public function descrizione(){

        return "Cerchio di raggio {$this->raggio}";
    }


}


//Rettangolo
class Rettangolo extends Forma {

 public $base;
 public $altezza;

            //costruttore perchè abbiamo l attributo $raggio
            public function __construct($base, $altezza) {

                $this->base = $base;
                $this->altezza = $altezza;
            }

    public function area(){

        return $this->base * $this->altezza;
    }


    public function descrizione(){

        return "Rettangolo {$this->base}x{$this->altezza}";
    }


}



//Funzioni polimorfe

function mostraArea(Forma $forma){

    echo $forma->descrizione() . "<br>";
    echo "Area: " . $forma->area() . " cm2 <br><br>";

}


//Utilizzo del polimorfismo

$forme = [

    new Cerchio(5),
    new Rettangolo(4, 5)
    

];


foreach($forme as $forma){

    mostraArea($forma);

}

?>