<?php 

class UserManager extends AbstractEntityManager{
    
    public function createUser(User $user){
        $sql = "INSERT INTO users(email,password,pseudo) VALUES(:email,:password,:pseudo)";
        $password = password_hash($user->getPassword(),PASSWORD_BCRYPT, ['cost' => 13]);
        $this->db->query($sql,
            [
                'email' => $user->getEmail(),
                'password' => $password ,
                'pseudo' => $user->getPseudo()
            ]
        );
    }

}