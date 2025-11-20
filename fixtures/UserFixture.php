<?php 

require_once('./models/AbstractEntityManager.php');
require_once('./models/DBManager.php');

class UserFixture extends AbstractEntityManager
{
    /**
     * Add new random users in DB (minimun 2, maximum 10)
     * @return void
     */
    public function addRandomUsers():void
    {
       $letters = "abcdefghilmnopqrstuvywmhò";
       $numberOfUsers = rand(2,10);
       $users = [];
       $params = [];

       $sql = "INSERT INTO users(email,pseudo,password,profile_image) VALUES(";

       for ($i=0; $i < $numberOfUsers ; $i++) { 
      
            $randomString = substr(str_shuffle($letters),rand(1,12),rand(12,25));
            $users[$i] = 
            [
                "email" =>  $randomString.'@gmail.com',
                "pseudo" => $randomString,
                "password" =>  uniqid("pass-") . $randomString,
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
        $letters = 'abcdefghilmnopqrstuvywmhj';
        $sql = "INSERT INTO users(email,pseudo,password,profile_image) VALUES(:email,:pseudo,:password,:profile_image)";

        $randomString = substr(str_shuffle($letters),rand(1,12),rand(12,25));
        
        $params["email"] = $randomString.'@gmail.com'; 
        $params["pseudo"] = $randomString; 
        $params["password"] = uniqid("pass-") . $randomString; 
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

