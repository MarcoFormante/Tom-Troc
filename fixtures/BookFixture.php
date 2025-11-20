<?php 

class BookFixture extends AbstractFixture
{
    
    /**
     * Add new random users in DB (minimun 2, maximum 10)
     * @return void
     */
     public function addRandomBooks():void
    {
       
       $numberOfBooks = $this->createRandomCount();
       
       $sql = "INSERT INTO books(title,image,author,description,status,sold_by) VALUES(";

       for ($i=0; $i < $numberOfBooks ; $i++) { 
      
            $randomString = $this->createRandomString();
            $books[$i] = 
            [
                "title" =>  $randomString,
                "image" => uniqid("img-") . ".jpg",
                "author" =>   "author-". $randomString,
                "description" => uniqid("desc-") .  $randomString,
                "status" => rand(0,1),
                "sold_by" => rand(1,255)
            ];

            $sql .= ":title$i,:image$i,:author$i,:description$i,:status$i,:sold_by$i)";

            if ($i < $numberOfBooks - 1) {
                $sql .= ",(";
            }

            $params["title$i"] = $books[$i]['title']; 
            $params["image$i"] = $books[$i]['image']; 
            $params["author$i"] = $books[$i]['author']; 
            $params["description$i"] = $books[$i]['description']; 
            $params["status$i"] = $books[$i]['status']; 
            $params["sold_by$i"] = $books[$i]['sold_by']; 
       }


        try {
            $stmt = $this->db->query($sql,$params);
            $numbOfBooks = $stmt->rowCount();

            $response = "$numbOfBooks BOOKS ont été ajoutés à la Base de donnés";
        } catch (\Throwable $err) {
           $response = $err->getMessage();
        }

        print_r($response . " \n");
    }


    /**
     * Add new Random Book
     * @return void
     */
    public function addBook():void
    {
       
        $sql = "INSERT INTO books(title,image,author,description,status,sold_by) 
                 VALUES(:title,:image,:author,:description,:status,:sold_by)
                ";

        $params = [
                "title" =>  $this->createRandomString(),
                "image" => uniqid("img-") . ".jpg",
                "author" =>   "author-". $this->createRandomString(),
                "description" => uniqid("desc-") . $this->createRandomString(),
                "status" => rand(0,1),
                "sold_by" => rand(1,255)
            ];

        $response = "Un BOOK a été ajouté à la Base de Donnés";

        try {
            $this->db->query($sql,$params);
        } catch (\Throwable $err) {
            $response =  $err->getMessage();
        }

        print_r($response . " \n");
    }


      /**
     * Delete all Books
     * @return void
     */
    public function deleteAllBooks():void
    {
        $sql = "DELETE FROM books";

        $response = "Tous les BOOKS ont été supprimés";

        try {
            $this->db->query($sql);
        } catch (\Throwable $err) {
            $response =  $err->getMessage();
        }

        print_r($response . " \n");
    }
}