<?php 

class UserFixture extends AbstractFixture
{
    /**
     * Add new random users in DB (minimun 2, maximum 10)
     * @return void
     */
    public function addRandomUsers():void
    {
      
       $numberOfUsers = $this->createRandomCount();

       $sql = "INSERT INTO users(email,pseudo,password,profile_image) VALUES(";

       for ($i=0; $i < $numberOfUsers ; $i++) { 
      
            $users[$i] = 
            [
                "email" => $this->createRandomString().'@gmail.com',
                "pseudo" =>$this->createRandomString(),
                "password" =>  uniqid("pass-") . $this->createRandomString(),
                "profile_image" => uniqid("img-") . "jpg"
            ];

            $sql .= ":email$i,:pseudo$i,:password$i,:profile_image$i)";

            if ($i < $numberOfUsers - 1) {
                $sql .= ",(";
            }

            $params["email$i"] = $users[$i]['email']; 
            $params["pseudo$i"] = $users[$i]['pseudo']; 
            $params["password$i"] = $users[$i]['password']; 
            $params["profile_image$i"] = $users[$i]['profile_image']; 
       }


        try {
            $stmt = $this->db->query($sql,$params);
            $numberOfUsers = $stmt->rowCount();

            $response = "$numberOfUsers USERS ont été ajoutés à la Base de donnés";
        } catch (\Throwable $err) {
           $response = $err->getMessage();
        }

        print_r($response . " \n");
    }


    /**
     * Add new Random User
     * @return void
     */
    public function addUser():void
    {
     
        $sql = "INSERT INTO users(email,pseudo,password,profile_image) VALUES(:email,:pseudo,:password,:profile_image)";

        $params["email"] = $this->createRandomString() . '@gmail.com'; 
        $params["pseudo"] = $this->createRandomString(); 
        $params["password"] = uniqid("pass-") . $this->createRandomString(); 
        $params["profile_image"] = uniqid("img-") . ".jpg";

        $response = "Un USER a été ajouté à la Base de Donnés";

        try {
            $this->db->query($sql,$params);
        } catch (\Throwable $err) {
            $response =  $err->getMessage();
        }

        print_r($response . " \n");
    }


     /**
     * Delete all Users
     * @return void
     */
    public function deleteAllUsers():void
    {
        $sql = "DELETE FROM users";
        $response = "Tous les USERS ont été supprimés";

        try {
            $this->db->query($sql);
        } catch (\Throwable $err) {
            $response =  $err->getMessage();
        }

        print_r($response . " \n");
    }

}

