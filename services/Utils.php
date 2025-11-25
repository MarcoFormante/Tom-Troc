<?php 

class Utils{
    
    public static function request(string $requestValue,string $defaultValue = ""){
        return $_REQUEST[$requestValue] ?? $defaultValue;
    }


     public static function handleRoute(string $route):void{
        switch($route){
            
            case "/":
                $homeController = new HomeController();
                $homeController->index();
            break;


            case "/nos-livre-a-lechange":
                $searchValue = htmlspecialchars(self::request("searchValue"));
                $booksController = new BookController();

                if ($searchValue !== "" && $_SERVER['REQUEST_METHOD'] === "POST") {
                    $booksController->searchBooks($searchValue);
                }else{
                    $booksController->index();
                }
            break;


            case "/detail":
                $bookController = new BookController();
                $bookController->detail();
            break;


            default :
                throw new Exception("La page demandée d'existe pas", 404);
            break;
        }
    }

    /**
    * Check active Route and add className to nav item
    * @param string $route
    * @return string $className
    */
    public static function checkActiveRoute(string $route){
        $request = self::request("route");
        return $request === $route ? "active" : "";
    }
   
}


