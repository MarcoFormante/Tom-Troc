<?php

class BookController extends AbstractController
{
    public function index()
    {   
        $bookManager = new BookManager();
        $books = $bookManager->getBooks();

        $this->render("books",['books' => $books],"Nos livres à l’échange");
    }


    public function searchBooks($searchValue){
        
        $bookManager = new BookManager();
        $data = $bookManager->searchBooks($searchValue);

        $params = [
            'books' =>$data['books'],
            'error' => $data['error'],
            'value' => $searchValue 
        ];
        
        $this->render("books",$params,"Nos livres à l’échange");
    }


    public function detail()
    {
        $bookId = Utils::request('id') ?? -1; 

        $bookManager = new BookManager();
        $book = $bookManager->detail($bookId);

        $this->render("detail", ['book' => $book], $book->getTitle());
    }
}