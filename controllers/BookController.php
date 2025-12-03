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


    public function deleteBook()
    {

        $bookId = Utils::request('bookId',-1);
        $soldBy = Utils::request('soldBy',-1);

        /**VERIFIER L'USER  */
        $bookManager = new BookManager();
        $bookManager->deleteBook($bookId);

        $this->redirect("index.php?route=/mon-compte#user-books-table");
        
    }


    public function editBook(?array $errors = [])
    {
        /**ADD CSRF TOKEN !!!! */

        $sold_by = Utils::request("sold_by","");
        $book_id = Utils::request('book_id',"");

        if (!$sold_by || !$book_id) {
           $this->redirect("?route=/mon-compte");
        }

        $bookManager = new BookManager();

        $book = $bookManager->getBook($book_id);
        
        
        $this->render("editBook",['book' => $book, 'errors' => $errors],"Modifier les informations");
        
    }


    public function updateBook()
    {
        
        $formIsvalid = Utils::request("isSubmitted","");
        
        /**CHECK if submitted */
        if ((bool)$formIsvalid !== true) {
            throw new Exception("Error Processing Request", 500);
        }

        $form = [];

        $bookImage = $_FILES['bookImage']['name'] ?? null;
        $lastBookImage = Utils::request("lastBookImage","");
        $title = Utils::request("title","");
        $author = Utils::request("author","");
        $desc = Utils::request("desc","");
        $status = Utils::request("status","");
        $sold_by =  Utils::request("sold_by","");
        $book_id =  Utils::request("book_id","");

        if ($bookImage) {
            if($imageErrors = Utils::checkImage($_FILES['bookImage'])) {
               $errors['image'] = $imageErrors;
            }

            $form['bookImage'] = $_FILES['bookImage'];

            if (!$lastBookImage) {
                $errors['lastBookImage'] = "Erreur pendant la mise à jour de l'image (last book image)";
            }

        }else{
            $form['bookImage'] = null;
        }

        
        $form['lastBookImage'] = $lastBookImage;

        if (!$title || strlen($title) > 60) {
            $errors['title'] = "Le titre est requis et doit contenir moins de 60 caractères";
        }
        $form['title'] = $title;
       
        if (!$author || strlen($author) > 60) {
            $errors['author'] = "Le author est requis et doit contenir moins de 60 caractères";
        }
        $form['author'] = $author;

        if (!$desc || strlen($desc) > 850) {
            $errors['desc'] = "La description est requise et doit contenir moins de 850 caractères";
        }
        $form['desc'] = $desc;
 
        if (!$status || !in_array($status,['available','unavailable'])) {
            $errors['status'] = "La description est requise et doit contenir moins de 850 caractères";
        }
        $form['status'] = $status;
        if ((!$sold_by || !is_numeric($sold_by)) || (!$book_id || !is_numeric($book_id))) {
            throw new Exception("Error Processing Request", 500);
        }
//! CHECKUSER
        $form['sold_by'] = $sold_by;
        $form['book_id'] = $book_id;

        if (!empty($errors)) {
            $this->editBook($errors);
            exit();
        }

        $bookManager = new BookManager();
        $bookManager->updateBook($form);
     
        $this->editBook();
        exit();

    }
}