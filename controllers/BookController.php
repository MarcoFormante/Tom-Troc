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
        $bookId = Utils::request('id',-1); 

        $bookManager = new BookManager();
        $book = $bookManager->detail($bookId);

        $this->render("detail", ['book' => $book], $book->getTitle());
    }


    public function deleteBook()
    {

        $book_id = Utils::request('bookId',-1);
        $sold_by = Utils::request('soldBy',-1);

        /**Verification de l'USER */
        $isValidUser = $this->checkUserBookValidAction($sold_by,$book_id);
        if (!$isValidUser) {
            throw new Exception("Error Processing Request", 500);
        }
       
        $bookManager = new BookManager();
        $bookManager->deleteBook($book_id);

        $this->redirect("index.php?route=/mon-compte");
        
    }


    public function editBook(?array $errors = [])
    {

        $sold_by = Utils::request("sold_by","");
        $book_id = Utils::request('book_id',"");

        $csrf = Utils::generateCSRF("edit-book");

        if (!is_numeric($sold_by) || !is_numeric($book_id)) {
           $this->redirect("?route=/mon-compte");
        }

        $userDataDecoded = Utils::validateJWT();

        if ($id = $userDataDecoded['id']) {
            if ($id != $sold_by || !$this->checkUserBookValidAction($id,$book_id)) {
                throw new Exception("Error Processing Requesadt", 500);
            }
        }

        $bookManager = new BookManager();
        $book = $bookManager->getBook($book_id);
        
        $this->render("editBook",['book' => $book, 'errors' => $errors, 'csrf' => $csrf],"Modifier les informations");
    }


    public function updateBook()
    {
        
        $formIsvalid = Utils::request("isSubmitted","");
        
        /**CHECK if submitted */
        if ((bool)$formIsvalid !== true) {
            throw new Exception("Error Processing Request", 500);
        }


        $form = [];

        $bookImage = $_FILES['bookImage']['name'] ? $_FILES['bookImage'] : null;
        $lastBookImage = Utils::request("lastBookImage","");
        $title = Utils::request("title","");
        $author = Utils::request("author","");
        $desc = Utils::request("desc","");
        $status = Utils::request("status","");
        $sold_by =  Utils::request("sold_by","");
        $book_id =  Utils::request("book_id","");
        $csrf = Utils::request("csrfToken","");

         /**---- CHECK CSRF ---- */
        if(!Utils::checkCSRF("edit-book",$csrf)){
            throw new Exception("Error Processing Request", 500);
        }
        /**-------------------- */


        /**---- CHECK USER ---- */
        $isValidUser = $this->checkUserBookValidAction($sold_by,$book_id);
        if (!$isValidUser) {
            throw new Exception("Error Processing Request", 500);
        }
        /**------------------ */


        if ($bookImage !== null) {
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
            $errors['status'] = "Le status est obligatoire";
        }
        $form['status'] = $status;
        
        $form['sold_by'] = $sold_by;
        $form['book_id'] = $book_id;
        

        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $this->redirect("?route=/editBook&book_id=$book_id&sold_by=$sold_by");
        }

        $bookManager = new BookManager();
        $bookManager->updateBook($form);
     
        $this->redirect("?route=/editBook&book_id=$book_id&sold_by=$sold_by");

    }


    private function checkUserBookValidAction($sold_by, $book_id)
    {
        if (!is_numeric($sold_by) || !is_numeric($book_id)) {
            return false;
        }

        $userId = Utils::checkUser($sold_by);

        if (!$userId) {
           return false;
        }

        $bookManager = new BookManager();
        $isValid = $bookManager->checkUserBookAction($userId,$book_id);

        return $isValid;
        
    }
}