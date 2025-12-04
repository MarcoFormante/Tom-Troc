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
       
       $sql = "SELECT id from users";

       $usersStmt = $this->db->query($sql);
       $users = $usersStmt->fetchAll();
       $userId = $users[rand(0,count($users) - 1)]['id'];

       $bookDescription = "J'ai récemment plongé dans les pages de 'The Kinfolk Table' et j'ai été enchanté par cette œuvre captivante. Ce livre va bien au-delà d'une simple collection de recettes ; il célèbre l'art de partager des moments authentiques autour de la table. Les photographies magnifiques et le ton chaleureux captivent dès le départ, transportant le lecteur dans un voyage à travers des recettes et des histoires qui mettent en avant la beauté de la simplicité et de la convivialité. Chaque page est une invitation à ralentir, à savourer et à créer des souvenirs durables avec les êtres chers. 'The Kinfolk Table' incarne parfaitement l'esprit de la cuisine et de la camaraderie, et il est certain que ce livre trouvera une place spéciale dans le cœur de tout amoureux de la cuisine et des rencontres inspirantes.";

                           
        $sql = "INSERT INTO books(title,image,author,description,status,sold_by) VALUES(";
        for ($i=0; $i < $numberOfBooks ; $i++) { 
      

            $books[$i] = 
            [
                "title" =>  "Olivia Brooks",
                "image" => "bookDefault.webp",
                "author" =>   "Jonathan Blake",
                "description" => $bookDescription,
                "status" => rand(0,1),
                "sold_by" => $userId
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