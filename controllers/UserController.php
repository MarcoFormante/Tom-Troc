<?php 

class UserController extends AbstractController
{
    public function userProfile(bool $isOwner,?array $errors = [])
    {
        $csrf = Utils::generateCSRF("csrf-profile"); 
        $userManager = new UserManager(); 
        $userId = Utils::request('userId', -1);

            /**Verification de l'USER */
            if ($isOwner === true) {
                $decodedUserData = Utils::validateJWT();
                if (!$decodedUserData) {
                    $this->redirect("index.php?route=/connection");
                }
                $userId = $decodedUserData['id'];
            }

            $user = $userManager->getUserInfo($userId);

            if (!$user) {
                $this->redirect("index.php?route=/connection");
            }
            $books = $user->getBooks($isOwner);

            $title = $isOwner ? "Mon Compte" : "Compte de " . $user->getPseudo();

            $this->render("profile", ['user' => $user, 'books' => $books, 'isOwner' => $isOwner,'errors' => $errors, 'csrf' => $csrf], $title);
    }



    public function createOrUpdateUser()
    {   
        $userId = Utils::request('userId',-1);
        $email = Utils::request('email');
        $password = Utils::request('password',"");
        $pseudo = Utils::request('pseudo');
        $lastImage =  Utils::request('lastProfileImage',"");
        $csrf = Utils::request('csrf',"");
        $image = [];
        $errors = [];


        if (!filter_var($email,FILTER_VALIDATE_EMAIL) || !$email ||strlen($email) > 60) {
            $errors['email'] = "Veuillez entrer une adresse email valide, max 60 caractères";
        }

        if ($password && (strlen($password) < 5 || strlen($password) > 60) )  {
            $errors['password'] = "Le mot de passe doit contenir au moins 5 caractères et un max 60, une lettre majuscule, un chiffre et un caractère spécial";

        }else if($password && (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password))){
            $errors['password'] = "Le mot de passe doit contenir au moins une lettre majuscule, un chiffre et un caractère spécial";
        }

        if (!$pseudo || strlen($pseudo) < 3  || strlen($pseudo) > 60 || (!preg_match('/^[a-zA-Z]|[a-zA-Z0-9]*$/', $pseudo))) {
             $errors['pseudo'] = "Le pseudo doit contenir au moins 3 caractères et ne doit contenir que des lettres et des chiffres pour un max de 60 caractères.";
        }

        if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['profileImage'];
            $imageErrors = Utils::checkImage($image);
            if(!empty($imageErrors)){
                $errors['image'] = $imageErrors;
            }
        }

        

        $form = [
            'id' => $userId,
            'email' => $email,
            'password' => $password,
            'pseudo' => $pseudo,
        ];

        $user = new User($form);

        $isRegisterPage = $user->getId() == -1;
     
        /**Register New User */

        if ($isRegisterPage) {
              if(!empty($errors)){
                $errors['lastInputs'] = [
                    'pseudo' => $pseudo,
                    'email' => $email,
                    'password' => $password
                ];
                $_SESSION['form_errors'] = $errors;
                $this->redirect("index.php?route=/register");
            }

            $userManager = new UserManager();
            $result = $userManager->createOrUpdateUser($user);

            if($result['success'] === true) {
                unset($_SESSION["auth_token"]);
                $this->redirect("index.php?route=/connection");
            }else{
                if ($result['email']) {
                    $errors['email'] = "Ce mail existe deja";
                }

                if ($result['pseudo']) {
                    $errors['pseudo'] = "Ce pseudo existe deja";
                }
                
                if(!empty($errors)){
                    $errors['lastInputs'] = [
                    'pseudo' => $pseudo,
                    'email' => $email,
                    'password' => $password
                    ];
                    $_SESSION['form_errors'] = $errors;
                    $this->redirect("index.php?route=/register");
                }
            }

        /*Update User */

        }else{
            if(!Utils::checkCSRF("csrf-profile",$csrf)){
                throw new Exception("Error Processing Request", 500);
            }

            $isValidUser = Utils::checkUser($userId);

            if (!$isValidUser) {
                 throw new Exception("Error Processing Request", 500);
            }

            if(!empty($errors)){
                $errors['lastInputs'] = [
                    'pseudo' => $pseudo,
                    'email' => $email,
                    'password' => $password
                ];
                $_SESSION['form_errors'] = $errors;
                $this->redirect("index.php?route=/mon-compte");
            }

            $userManager = new UserManager();
            $result = $userManager->createOrUpdateUser($user,$lastImage,$image);


            if($result['success'] === true) {
                $this->redirect("index.php?route=/mon-compte");
            }else{
                if ($result['email']) {
                    $errors['email'] = "Ce mail existe deja";
                }

                if ($result['pseudo']) {
                    $errors['pseudo'] = "Ce pseudo existe deja";
                }
                
                if(!empty($errors)){
                    $errors['lastInputs'] = [
                    'pseudo' => $pseudo,
                    'email' => $email,
                    'password' => $password
                    ];
                    $_SESSION['form_errors'] = $errors;
                    $this->redirect("index.php?route=/mon-compte");
                }
            }
        }
       
        $this->redirect("index.php?route=/mon-compte");
    }



    public function login(){
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if ($_POST['submited'] === 'true') {
                $errors = [];
                $email = Utils::request("email","");
                $password = Utils::request("password","");
                $csrfToken = Utils::request("csrf","");

                if (!$email || !filter_var($email,FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = "Veuillez entrer une adresse email valide";
                }

                if (!$password) {
                    $errors['password'] = "Veuillez entrer un mot de passe";
                }

                if (!Utils::checkCSRF("login_csrf",$csrfToken)) {
                    throw new Exception("Error Processing Request", 500);
                }
            }else{
                throw new Exception("Error Processing Request", 500);
            }

            if (!empty($errors)) {
                $errors['lastInputs'] = [
                    'email' => $email,
                    'password' => $password
                ];
               $_SESSION['form_errors'] = $errors;
               return $this->redirect("?route=/connection");
            }

            $userManager = new UserManager();
            $data = $userManager->login($email,$password);

            if ($data['user-error']) {
                 $errors['lastInputs'] = [
                    'email' => $email,
                    'password' => $password
                ];
                $errors['user-error'] = $data['user-error'];
                $_SESSION['form_errors'] = $errors;
                return $this->redirect("?route=/connection");
            }

            if ($data['token']) {
                $_SESSION['auth_token'] = $data['token'];
                return $this->redirect("?route=/");
            }

            return $this->redirect("?route=/connection");
        }

        $title = "Connexion";

        $csrf = bin2hex(random_bytes(16));

        $_SESSION['login_csrf'] = $csrf;

        $this->render("signup_signin",['title' =>$title, 'csrf' => $csrf, 'isConnectionPage' => true], $title);
    }


    
    public function register(){
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            if ($_POST['submited'] === 'true') {
                $csrfToken = Utils::request("csrf","");

                if (!Utils::checkCSRF("register_csrf",$csrfToken)) {
                    throw new Exception("Error Processing Request", 500);
                }
                
                $this->createOrUpdateUser();
            }else{
                throw new Exception("Error Processing Request", 500);
            }
        }

        $csrf = Utils::generateCSRF("register_csrf");
        $title = "Inscription";
        $this->render("signup_signin", ['title' =>$title, 'csrf' => $csrf, 'isConnectionPage' => false],$title);
    }


}