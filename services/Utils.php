<?php 

class Utils{
    
    public static function request(string $requestValue,string $defaultValue){
        return $_REQUEST[$requestValue] ?? $defaultValue;
    }

     public static function handleRoute(string $route):void{
        switch($route){
            case "/":
                $homeController = new HomeController();
                $homeController->index();
            break;
            default :
                throw new Exception("Error Processing Request", 1);
            break;
        }
    }
   
}