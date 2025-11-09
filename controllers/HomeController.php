<?php 

class HomeController extends AbstractController{

    public function index(){
        return $this->render("home",['testtitle2' => 'TEST']);
    }
}