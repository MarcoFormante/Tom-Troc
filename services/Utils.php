<?php 

class Utils{
    
    public static function request(string $requestValue,string $defaultValue = ""){
        return trim($_REQUEST[$requestValue] ?? $defaultValue) ;
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
        ($interval->d === 1  ? " 1 jour " : " ") . 
        ($interval->d === 0 && $interval->s > 0  ? "aujourd'hui" : "" ) ;
    }


 /** Check post Method */
    public static function checkPostMethod(){
         if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            throw new Exception("Cette page n'existe pas", 404);
        }
    }



    public static function getEnvValue(string $name)
    {
        $env = parse_ini_file("../.env");

        if (!$env || !isset($env[$name])) {
           throw new Exception("Error Processing Request during LOGIN", 500);
        }

        return $env[$name];
    }



    public static function createJWT(array $payload){
        $secret = self::getEnvValue('APP_SECRET');

        $encodedData = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256',$encodedData,$secret);

        return "$encodedData.$signature";
      
    }



    public static function validateJWT()
    {
        if(!isset($_SESSION['auth_token'])){
            return null;
        }

        $sessionToken = $_SESSION['auth_token'];

        if (!count(explode(".",$sessionToken)) === 2) {
            return null;
        }

        list($payload,$signature) = explode(".",$sessionToken);

        $secret = self::getEnvValue('APP_SECRET');

        $check = hash_hmac('sha256',$payload,$secret);
        
        if (!hash_equals($check,$signature)) {
            return null;
        }

        return json_decode(base64_decode($payload),true);
    }


    public static function generateCSRF(string $nameOfCSRF){
        $csrf = bin2hex(random_bytes(16));
        $_SESSION[$nameOfCSRF] = $csrf;

        return $csrf;
    }



    public static function checkCSRF(string $csrf_name,$csrf = null)
    {
        if (!isset($_SESSION[$csrf_name])){
            return false;
        }

        if ($_SESSION[$csrf_name] !== $csrf) {
            return false;
        }

        return true;
    }



    public static function checkUser(int|null $userId = null)
    {
        $decodedUser = self::validateJWT();
        if (!$decodedUser) {
            return false;
        }
        
        if ($userId !== null) {
            if ($decodedUser['id'] !== $userId) {
                return false;
            }
        }


        $userManager = new UserManager();
        $user = $userManager->getUser($decodedUser['id']);

        if (!$user) {
            return false;
        }
        
        return $decodedUser['id'];
    }



    public static function formatDateTime($date){
        $formattedDate = new DateTime($date);

        return $formattedDate->format("H:i");
    }


    public static function sendAlert(string $message)
    {
        $_SESSION['alert'] = $message;
    }
}   


