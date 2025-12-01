<?php 

class UserController extends AbstractController
{
    public function userProfile(bool $isOwner,?array $errors = [])
    {
        // $env = parse_ini_file("../.env");
        // var_dump($env['APP_SECRET']);
       
        $userManager = new UserManager(); 
        $userId = Utils::request('userId', 0);

        /**VERIFICARE l'USER */
            if ($isOwner === true) {
                $userId = 151;
            }

            if (!$userId) {
                throw new Exception("Ce Profile n'existe pas", 404);
            }

            $user = $userManager->getUserInfo($userId);
            $books = $user->getBooks();

            $title = $isOwner ? "Mon Compte" : "Compte de " . $user->getPseudo();

            $this->render("profile", ['user' => $user, 'books' => $books, 'isOwner' => $isOwner,'errors' => $errors], $title);
    }



    public function updateUser()
    {   

        $userId = Utils::request('userId',-1);
        $email = Utils::request('email');
        $password = Utils::request('password',"");
        $pseudo = Utils::request('pseudo');
        $image =  $_FILES['profileImage'];
        $lastImage =  Utils::request('lastProfileImage');
          
        $errors = [];
        if (!filter_var($email,FILTER_VALIDATE_EMAIL) || !$email ||strlen($email) > 60) {
            $errors['email'] = "Veuillez entrer une adresse email valide, max 60 caractères";
        }

        if ($password && (strlen($password) < 5 || strlen($password) > 60) ) {
            $errors['password'] = "Le mot de passe doit contenir au moins 5 caractères et max 60, une lettre majuscule, un chiffre et un caractère spécial";

        }else if($password && (strlen($password) >= 5 && strlen($password) <= 60)){
            
            if ($password && (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password))) {
                $errors['password'] = "Le mot de passe doit contenir au moins une lettre majuscule, un chiffre et un caractère spécial";
            }
        }

        if (!$pseudo || strlen($pseudo) < 3 || (!preg_match('/^[a-zA-Z][a-zA-Z0-9]*$/', $pseudo))) {
             $errors['pseudo'] = "Le pseudo doit contenir au moins 3 caractères et ne doit contenir que des lettres et des chiffres.";
        }

        if ($image['name']) {
            $imageErrors = Utils::checkImage($image);
            if(!empty($imageErrors)){
                $errors['image'] = $imageErrors;
            }
        }
       

        $userData = [
            'id' => $userId,
            'email' => $email,
            'password' => $password,
            'pseudo' => $pseudo,
            'newImage' => $image,
            'lastProfileImage' =>$lastImage
        ];

        if (!empty($errors)) {
            return $this->userProfile(true,$errors);
        }else{
            $userManager = new UserManager(); 
            $userManager->createOrUpdateUser($userData);
        }
       
        $this->redirect("index.php?route=/mon-compte");
       
    }
}