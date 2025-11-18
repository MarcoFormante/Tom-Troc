<?php 

class HomeController extends AbstractController{

    public function index(){
        $bookManager = new BookManager();
        $books = $bookManager->getBooksByOrderAndLimit(["created_at","DESC"],[0,4]);
        
        $this->render("home",['books' => $books]);
    }
}