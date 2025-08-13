<?php

class Book {

    public string $title;
    public string $author;


    public function __construct(string $title, string $author){

        $this->title = $title;
        $this->author = $author;
    }

    public function getInfo(): string {

        return "Titolo : {$this->title} - Autore: {$this->author}";
    }

}
?>