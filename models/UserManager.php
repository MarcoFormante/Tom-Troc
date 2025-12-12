<?php 

class UserManager extends AbstractEntityManager{

    /**
     * Get User by ID
     * @param int $id
     * @return Author|bool
    */
    public function getUser(int $id):User|false
    {
        $sql = "SELECT id, email, password, pseudo, profile_image FROM users WHERE id = :id";

        $stmt = $this->db->query($sql,['id' => $id]);
        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }
        return new User($user);
    }
    
    /**
    * Create or Update a User
    * @param User
    * @return bool stmt->rowCount()
    */  
    public function createOrUpdateUser(User $user, string $lastImage = "", array $image = [])
    {
        $params = [
            'email'   => $user->getEmail(),
            'pseudo'  => $user->getPseudo(),
        ];

        $sameValueErrors = [
            'email' => false,
            'pseudo' => false
        ];

        /**CHECK Email */
        $sql = "SELECT id FROM users WHERE email = :email AND id != :userId";
        $stmt = $this->db->query($sql,['email' => $params['email'],'userId' => $user->getId()]);
        $existingEmail = $stmt->fetch();
        if ($existingEmail) {
            $sameValueErrors['email'] = true;
        }

         /**CHECK Pseudo */
        $sql = "SELECT id FROM users WHERE pseudo = :pseudo AND  id != :userId";
        $stmt = $this->db->query($sql,['pseudo' => $params['pseudo'],'userId' => $user->getId()]);
        $existingPseudo= $stmt->fetch();
        if ($existingPseudo) {
            $sameValueErrors['pseudo'] = true;
        }
        if ($existingEmail || $existingPseudo) {
            return $sameValueErrors;
        }

        $sql = "UPDATE users SET email = :email, pseudo = :pseudo";
       
        if($password = $user->getPassword()) {
            $params['password'] = password_hash($password,PASSWORD_BCRYPT, ['cost' => 13]);
            $sql .= ", password = :password";
        }
        
        if ($image['error'] === UPLOAD_ERR_OK ) {
            $sql .= ', profile_image = :image';
            $tmp_name = $image['tmp_name'];
            $imgName = uniqid("user-") . ".jpg";
            $params['image'] = $imgName;

            if(move_uploaded_file($tmp_name,IMAGES_PATH . "users/$imgName")){
                if ($lastImage) {
                    $lastImagePath = IMAGES_PATH . "users/$lastImage";
                    if (file_exists($lastImagePath) && $lastImage !== "userDefault.webp") {
                        unlink($lastImagePath);
                    }
                }
            }
        }

        // Check if it isn't a new Users
        if ($user->getId() != -1) {  
            $params['id'] = $user->getId();
            $sql .= " WHERE id = :id";
        }else{
            $params['image'] = "userDefault.webp";
            $sql = "INSERT INTO users(email,password,pseudo,profile_image) VALUES(:email,:password,:pseudo,:image)";
        }

        $stmt = $this->db->query($sql,$params);
        
        return ['success' => true];
       
    }




    public function getUserInfo(int $id):User|false
    {
        $sql = "SELECT id, email, password, pseudo, profile_image, signup_date FROM users WHERE id = :id";
        $stmt = $this->db->query($sql,['id' => $id]);

        $userData = $stmt->fetch();
        if (!$userData) {
            return false;
        }
        $user = new User($userData);

        return $user;
    }



    public function login(string $email,string $password)
    {
        $sql = "SELECT id, email, password, pseudo FROM users WHERE email = :email";

        $stmt = $this->db->query($sql,['email' => $email]);

        $userData = $stmt->fetch();

        if (!$userData){
            return ['token' => false ,'user-error' => "L'email ou le mot de passe est incorrect"];
        }
        

        if(!password_verify($password,$userData['password'])){
            return ['token' => false ,'user-error' => "L'email ou le mot de passe est incorrect"];
        }

        $payload = [
            'id' => $userData['id'],
        ];

        $authToken = Utils::createJWT($payload);

        if (!$authToken) {
            return ['token' => false ,'user-error' => "L'email ou le mot de passe est incorrect"];
        }

        return ['token' => $authToken,'user-error' => false];

    }

    public function checkExistingUser(int $id, string $pseudo){
        $sql = "SELECT id,pseudo,profile_image FROM users WHERE id = :id AND pseudo = :pseudo";
        $stmt = $this->db->query($sql,['id' => $id, 'pseudo' => $pseudo]);

        $user = $stmt->fetch();
        if (!$user) {
            return false;
        }

        return $user;
    }

}