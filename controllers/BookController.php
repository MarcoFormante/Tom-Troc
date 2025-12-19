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

        $userId = Utils::checkUser();

        $this->render("detail", ['book' => $book,'authenticatedUserId' => $userId], $book->getTitle());
    }


    public function deleteBook()
    {

        $book_id = Utils::request('bookId',-1);
        $sold_by = Utils::request('soldBy',-1);

        /**Verification de l'USER */
        $isValidUser = $this->checkUserBookValidAction($sold_by,$book_id);
        if (!$isValidUser) {
            throw new Exception("Action non autorisée", 403);
        }
       
        $bookManager = new BookManager();
        $bookManager->deleteBook($book_id);

        Utils::sendAlert("Le livre a été supprimé avec succès");
        $this->redirect("index.php?route=/mon-compte");
        
    }


    public function newBook(?array $errors = [])
    {

        $csrf = Utils::generateCSRF("edit-book");

        $userDataDecoded = Utils::validateJWT();

        if (!$userDataDecoded['id']) {
            throw new Exception("Action non autorisée", 403);
        }

        $book = new Book();
        $book->setSoldBy($userDataDecoded['id']);

        $this->render("editBook",['book' => $book, 'errors' => $errors, 'csrf' => $csrf],"Modifier les informations");
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
                throw new Exception("Action non autorisée", 403);
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
            throw new Exception("Action non autorisée", 403);
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
            throw new Exception("Action non autorisée", 403);
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

        Utils::sendAlert("Mise à jour effectuée avec succès");

        $this->redirect("?route=/editBook&book_id=$book_id&sold_by=$sold_by");

    }



    public function createBook()
    {
        Utils::checkPostMethod();

        $formIsvalid = Utils::request("isSubmitted","");
        
        /**CHECK if submitted */
        if ((bool)$formIsvalid !== true) {
            throw new Exception("Action non autorisée", 403);
        }

        $form = [];

        $bookImage = $_FILES['bookImage']['name'] ? $_FILES['bookImage'] : null;
        $lastBookImage = Utils::request("lastBookImage","");
        $title = Utils::request("title","");
        $author = Utils::request("author","");
        $desc = Utils::request("desc","");
        $status = Utils::request("status","");
        $csrf = Utils::request("csrfToken","");
        $sold_by = Utils::request("sold_by","");

         /**---- CHECK CSRF ---- */
        if(!Utils::checkCSRF("edit-book",$csrf)){
            throw new Exception("Action non autorisée", 403);
        }
        /**-------------------- */


         /**---- CHECK USER ---- */
        $userId = Utils::checkUser($sold_by);
        if (!$userId) {
            throw new Exception( "Accès non autorisé. Veuillez vous connecter.", 403);
        }
        $form['sold_by'] = $userId;
        /**------------------ */

        /**Handle Image */
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

        /**Handle Input Errors */

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

        if (!empty($errors)) {
            $errors['lastInputs'] = [
                'title' => $title,
                'author' =>$author,
                'desc' => $desc,
                'status' => $status
            ];

            $_SESSION["errors"] = $errors;
            $this->redirect("?route=/newBook");
        }

        $bookManager = new BookManager();
        $bookManager->createBook($form);
        
        Utils::sendAlert("Le livre a été créé avec succès");
        $this->redirect("?route=/mon-compte");

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