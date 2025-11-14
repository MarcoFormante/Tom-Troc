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
                throw new Exception("La page demandée d'existe pas", 404);
            break;
        }
    }
   
}


