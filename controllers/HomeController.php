<?php 

class HomeController extends AbstractController{

    /**
     * Get latest 4 books and show home page
     * @return void
     */
    public function index(){
        $bookManager = new BookManager();
        $books = $bookManager->getBooksByOrderAndLimit(["created_at","DESC"],[0,4]);
        
        $this->render("home",['books' => $books],"Acceuil");
    }
}