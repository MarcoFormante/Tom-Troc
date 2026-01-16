<?php 

class Router
{
    /**
     * Handle routes or throw error if route not found
     * @param string $route 
     * @return void
    */
     public static function handleRoute($route):void
     {

        try {
        switch($route){
            case "/":
                $homeController = new HomeController();
                $homeController->index();
            break;

        /** BOOKS */
            case "/nos-livre-a-lechange":
                $searchValue = htmlspecialchars(Utils::request("searchValue"));
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


            case "/deleteBook":
                Utils::checkPostMethod();
                $bookController = new BookController();
                $bookController->deleteBook();
            break;

            case "/editBook":
                $bookController = new BookController();
                $bookController->editBook();
            break;

            case "/updateBook":
                Utils::checkPostMethod();
                $bookController = new BookController();
                $bookController->updateBook();
            break;

            case "/newBook":
                $bookController = new BookController();
                $bookController->newBook();
            break;

            case "/createBook":
                Utils::checkPostMethod();
                $bookController = new BookController();
                $bookController->createBook();
            break;

            /** USER */
            case "/mon-compte":
                $userController = new UserController();
                $userController->userProfile(true);
            break;


            case "/profile":
                $userController = new UserController();
                $userController->userProfile(false);
            break;


            case "/updateUser":
                Utils::checkPostMethod();
                $userController = new UserController();
                $userController->createOrUpdateUser();
            break;


            case "/connection":
                
                $userController = new UserController();
                $userController->login();
            break;


            case "/register":
                $userController = new UserController();
                $userController->register();
            break;

            case "/logout":
                Utils::checkPostMethod();
                $userController = new UserController();
                $userController->logout();
            break;


            //**Messages */

            case "/messages":
                $chatController = new ChatroomController();
                $chatController->showChatrooms();
            break;

            case "/openMessage":
                $chatController = new ChatroomController();
                $chatController->verifyChatroom(true);
            break;


            case "/sendMessage":
                Utils::checkPostMethod();
                $messageController = new MessageController();
                $messageController->sendMessage();
            break;

             case "/deleteDraft":
                Utils::checkPostMethod();
                $messageController = new MessageController();
                $messageController->deleteDraft();
            break;

            /*ERROR */
                
            case "/error":
                $errorController = new ErrorController();
                $errorController->handleError($_SESSION["catched"] ?? null);
            break;

            default :
                throw new Exception("La page demandée d'existe pas", 404);
            break;
        }

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(),$th->getCode());
        }
    }
}