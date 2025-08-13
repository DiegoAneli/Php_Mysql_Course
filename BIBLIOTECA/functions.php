<?php

require_once 'Book.php';



function addBook(array &$library, string $title, string $author): void {

    $library[] = new Book($title, $author);
}


function deleteBook(array &$library, int $index): void{
    
    if(isset($library[$index])){

        unset($library[$index]);
        $library = array_values($library); // reindicizza
    }

}

function searchBook(array $library, string $title): ?Book {

    foreach ($library as $book) {
        if (strtolower($book->title) === strtolower($title)){
            return $book;
        }
    }
}


?>