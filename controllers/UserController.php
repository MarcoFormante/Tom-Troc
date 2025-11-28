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
                $userId = 126;
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
        $image = Utils::request('image');
        $errors = [];

        if (!filter_var($email,FILTER_VALIDATE_EMAIL) || !$email) {
            $errors['email'] = "Le mail n'est pas correcte";
        }

        if ($password && strlen($password) < 5) {
             $errors['password'] = "Le mot de passe doit contenir au moins 5 caracters";
        }

         if (!$pseudo || strlen($pseudo) < 3) {
             $errors['pseudo'] = "Le pseudo doit contenir au moins 3 caracters";
        }
        

        $userData = [
            'id' => $userId,
            'email' => $email,
            'password' => $password,
            'pseudo' => $pseudo,
            'profile_image' => $image,
        ];

        $user = new User($userData);
        $books = $user->getBooks();

        if (!empty($errors)) {
            return $this->userProfile(true,$errors);
        }else{
            $userManager = new UserManager(); 
            $userManager->createOrUpdateUser($user);
        }
       return $this->render("profile", ['user' => $user, 'books' => $books, 'isOwner' => true],  "Mon Compte");
       
    }
}