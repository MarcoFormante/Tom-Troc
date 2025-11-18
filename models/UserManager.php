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
    public function createOrUpdateUser(User $user):bool
    {
        $password = password_hash($user->getPassword(),PASSWORD_BCRYPT, ['cost' => 13]);

        $params = [
            'email'    => $user->getEmail(),
            'password' => $password,
            'pseudo'   => $user->getPseudo(),
            'image'   => $user->getProfile_image()
        ];

        // Check if it isn't a new User
        if ($user->getId() !== -1) {
              $sql = 'UPDATE users SET email = :email, password = :password, pseudo = :pseudo, profile_image = :image WHERE id = :id';
              $params['id'] = $user->getId();
        }else{
            $sql = "INSERT INTO users(email,password,pseudo,profile_image) VALUES(:email,:password,:pseudo,:image)";
        }
        
        $stmt = $this->db->query($sql,$params);

        return $stmt->rowCount();
    }

}