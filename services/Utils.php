<?php 

class Utils{
    
    public static function request(string $requestValue,string $defaultValue = ""){
        return $_REQUEST[$requestValue] ?? $defaultValue;
    }


    /**
     * Handle Routes
     * @param string $route 
     * @return void
     */
     public static function handleRoute(string $route):void{
        switch($route){
            
            case "/":
                $homeController = new HomeController();
                $homeController->index();
            break;

/** BOOKS */
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


            case "/deleteBook":
                self::checkPostMethod();
                $bookController = new BookController();
                $bookController->deleteBook();
            break;

            case "/editBook":
 //**CHECK CSRF */
                $bookController = new BookController();
                $bookController->editBook();
            break;

            case "/updateBook":
                $bookController = new BookController();
                $bookController->updateBook();
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
                self::checkPostMethod();
                /**VERIFICARE POST REQUEST */
                $userController = new UserController();
                $userController->updateUser();
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



    /**
     * Check if image is correct
     * @param array $image
     * @return array $errors
     */
    public static function checkImage(array $image):array
    {
        $errors = [];

        if($image['error'] !== UPLOAD_ERR_OK){
            $errors['img-error'] = "Erreur pendant le chargement de l'image";
        }

        if(!is_uploaded_file($image['tmp_name'])){
            $errors['not-uploaded'] = "L'Image n'est pas valide";
        }

        if ($image['size'] / (1024 * 1024) > 3) {
            $errors['size'] = "L'image doit etre moins de 3 MB";
        }

        if (!in_array($image['type'],['image/jpeg',"image/png","image/webp"])){
            $errors['type'] = "Les types d'image acceptés sont: jpeg, png, webp";
        }

       

        return $errors;
    }



    /**
     * Calculate sign_up date for user Profile
     * @param Datetime|string $date
     * @return string
     */
    public static function calculateSignupDate(DateTime|string $date):String
    {
        $now = new DateTime();

        if (!$date) {
            return "pas mal de temps";
        }

        // check if $date is instance of Datetime and create a new Datetime()
        if (!($date instanceof Datetime) ) {
            if (!(date_create($date) instanceof DateTime) ) {
                return "pas mal de temps";
            }else{
                $date = new DateTime($date);
            }
        }

        // calculate the difference
        $interval = $date->diff($now); 
        
        // Add "," if years, months and days are > 0 
        $checkYearMonthDay = ($interval->y > 0 && $interval->m > 0 && $interval->d > 0 ) ? "," : "";

        // add "et" if only years and months are > 0
        $checkYearMonth = ($interval->y > 0 && $interval->m > 0 && $interval->d === 0 ) ? " et "  : ""; 

        // add "et" if only years and days are > 0
        $checkYearDay = ($interval->y > 0 && $interval->d > 0 && $interval->m < 1) ? "et" : " "; 

         // add "et" if only months and days are > 0
        $checkMonthDay = ($interval->m > 0 && $interval->d > 0 ) ? "et" : "";


        // exemple: 2 ans, 1 mois et 2 jours
        return 
        ($interval->y > 1 ? $interval->y . " ans " : "") .  
        ($interval->y === 1 ? " 1 an " : "") . 
        "$checkYearMonthDay" . " $checkYearDay " . " $checkYearMonth " . 
        ($interval->m > 0 ? $interval->m . " mois " : "") . 
        " $checkMonthDay ". ($interval->d > 1 ? $interval->d . " jours " : "  ") . 
        ($interval->d === 1 ? " 1 jour " : " ") . 
        ($interval->d === 0 && $interval->m === 0 && $interval->y === 0 ? "aujourd'hui" : "");
    }


 /** Check post Method */
    public static function checkPostMethod(){
         if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            throw new Exception("Cette page n'existe pas", 404);
        }
    }
}   


