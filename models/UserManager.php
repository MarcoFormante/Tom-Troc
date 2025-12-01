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
    public function createOrUpdateUser(array $userData)
    {
            $sql = "UPDATE users SET email = :email, pseudo = :pseudo";

            $params = [
                'email'   => $userData['email'],
                'pseudo'  => $userData['pseudo'],
            ];

            if($password = $userData['password']) {
                $params['password'] = password_hash($password,PASSWORD_BCRYPT, ['cost' => 13]);
                $sql .= ", password = :password";
            }
            
            if ($userData['newImage']['name']) {
                $sql .= ', profile_image = :image';
                $tmp_name = $userData['newImage']['tmp_name'];
                $imgName = uniqid("user-") . ".jpg";
                $params['image'] = $imgName;

                if(move_uploaded_file($tmp_name,IMAGES_PATH . "/users/$imgName")){
                    
                    if ($userData['lastProfileImage']) {
                       
                        $lastImagePath = IMAGES_PATH . "/users/" . $userData['lastProfileImage'];

                        if (file_exists($lastImagePath)) {
                            unlink($lastImagePath);
                        }
                    }
                }
            }

            if ($userData['id'] !== -1) {  // Check if it isn't a new Users
                $params['id'] = $userData['id'];
                $sql .= " WHERE id = :id";
            }else{
                $sql = "INSERT INTO users(email,password,pseudo) VALUES(:email,:password,:pseudo)";
            }
          

            $stmt = $this->db->query($sql,$params);
            
            return $stmt->rowCount();
       
    }




    public function getUserInfo(int $id){
        $sql = "SELECT id, email, password, pseudo, profile_image, signup_date FROM users WHERE id = :id";
        $stmt = $this->db->query($sql,['id' => $id]);

        $userData = $stmt->fetch();
        $user = new User($userData);

        return $user;
    }




}