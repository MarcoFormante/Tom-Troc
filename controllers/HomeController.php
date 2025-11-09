<?php 

class HomeController extends AbstractController{

    public function index(){
        $this->render("home",['testtitle2' => 'TEST']);
    }
}