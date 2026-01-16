<?php 

class BookManager extends AbstractEntityManager{

    /**
     * Get a Book by id
     * @param int $id
     * @return Book|false
     */
    public function getBook(int $id):Book|false
    {
        $sql = " SELECT id, title, author, image, description, sold_by, status FROM books WHERE id = :id";

        $stmt = $this->db->query($sql,['id' => $id]);

        $book = $stmt->fetch();

        if (!$book) {
            return false;
        }

        return new Book($book);
    }


    /**
     * Get Books 
     * @param int $id
     * @return Book|false
    */
    public function getBooks():array|false
    {
        $sql = " SELECT b.id, b.title, b.author, b.image, u.pseudo FROM books b
                 JOIN users u ON b.sold_by = u.id
                 WHERE status = :status
               ";

        $stmt = $this->db->query($sql,['status' => 1]);

        $books = [];

        while($book = $stmt->fetch()){
            if ($book) {
                $books[] = new Book($book); 
            }
        }

        if (empty($books)) {
            return false;
        }

        return $books;
    }



    /**
     * Create or modify a Book
     * @param Book $book
     * @param ?Author $author
     * @return int
     */
     public function createOrUpdateBook(Book $book):bool
    {
        $params = [
            'title'    => $book->getTitle(),
            'author' => $book->getAuthor(),
            'image' => $book->getImage(),
            'description'  => $book->getDescription(),
            'sold_by' => $book->getSoldBy(),
            'status'  => $book->getStatus(),
        ];

        if ($book->getId() !== -1) {
            $sql = "UPDATE books SET title = :title, author = :author, image = :image, description = :description, status = :status, sold_by = :sold_by  WHERE id = :id";
            $params['id'] = $book->getId();
        }else{
            $sql = "INSERT INTO books(title, author, image, description, sold_by, status) VALUES(:title, :author, :image, :description, :sold_by, :status)";
        }

        $stmt = $this->db->query($sql,$params);
        
        return $stmt->rowCount();
    }



    /**
     * Delete a book by id
     * @param int $id
     * @return bool
     */
    public function deleteBook(int $id):bool
    {
        $imgSql = "SELECT image FROM books WHERE id = :id";

        $stmtImage = $this->db->query($imgSql,['id' => $id]);

        $data = $stmtImage->fetch();

        if (file_exists(IMAGES_PATH . "books/" . $data['image'] )) {
            if ($data['image'] != "bookDefault.webp") {
                unlink(IMAGES_PATH . "books/" . $data['image']);
            }
          
        }

        $sql = "DELETE FROM books WHERE id = :id";

        $stmt = $this->db->query($sql,['id' => $id]);
        return $stmt->rowCount();
    }


    /**
     * Get Books with orderby and limit props
     * @param array[string,string] $orderBy = [column name, ASC|DESC]
     * @param array[int,int] exemple $limit =  [0,4]
     */
    public function getBooksByOrderAndLimit(array $orderBy, array $limit):array
    {
        if(!is_int($limit[0]) || !is_int($limit[1]) ){
            throw new Exception("Int number Error",400);
        }

        $sql = "SELECT b.id, b.author, b.title, b.image, b.sold_by, u.pseudo FROM books b
                JOIN users u ON b.sold_by = u.id
                WHERE status = :status
                ORDER BY :order :orderType
                LIMIT $limit[0] , $limit[1]
                ";

        $stmt = $this->db->query($sql,[
            'status' => 1,
            'order' => $orderBy[0],
            'orderType' => $orderBy[1],
        ]);

        $books = [];

        while($book = $stmt->fetch()){
            $books[] = new Book($book);
        }

        return $books;
    }
    


    public function searchBooks(string $value)
    {
        $sql = "SELECT b.id, b.author, b.title, b.image, b.sold_by, u.pseudo FROM books b
                JOIN users u ON b.sold_by = u.id
                WHERE (status = :status)
                AND (b.title LIKE :value OR b.author LIKE :value)
                ORDER BY b.created_at DESC
                ";

        $stmt = $this->db->query($sql,[
            'status' => 1,
            'value' => "%" . $value . "%"
        ]);
        $error  = "";
        $books = [];
        $rowCount = $stmt->rowCount();
        
        if (!$rowCount == 0) {

            while($book = $stmt->fetch()){
                $books[] = new Book($book);
            }

        }else{
            $error = "Aucun livre trouvé avec le mot ' $value '";
        }
        
        return ["books" => $books, "error" => $error];
    }


     public function detail(int $bookId)
    {
        $sql = "SELECT b.id, b.title, b.description, b.image, b.author, u.profile_image, u.pseudo, u.id  FROM books b
                JOIN users u ON u.id = b.sold_by
                WHERE b.id = :bookId AND status = :status
                ";

        $stmt = $this->db->query($sql,["bookId" => $bookId,'status' => 1]);
        $data = $stmt->fetch();

        if (empty($data)) {
            throw new Exception("Ce livre n'existe pas ou n'est pas disponible", 404);
        }

        $book = new Book($data);
        
        return $book;
        
    }


    public function getUserBooks(int $userId, bool $isOwner)
    {
        $sql = "SELECT id, title, description, image, author, status, sold_by  
                FROM books WHERE sold_by = :userId";
        
        $params = ['userId' => $userId];

        if (!$isOwner) {
            $sql .= " AND status = :status";
            $params['status'] = 1;
        }
        

        $stmt = $this->db->query($sql,$params);

        $books = [];

        while($book = $stmt->fetch()){
            $books[] = new Book($book);
        }

        return $books;
    }


    public function updateBook(array $form)
    {
        $sql = "UPDATE books SET title = :title, author = :author, description = :desc, status = :status, image = :image WHERE id = :id AND sold_by = :sold_by";
        
        if ($form['bookImage']) {
            $tmp_name = $form['bookImage']['tmp_name'];
            $imgName = uniqid("book-") . ".jpg";
             
            if(move_uploaded_file($tmp_name,IMAGES_PATH . "books/$imgName")){
                    $form['bookImage'] = $imgName;
                if ($form['lastBookImage']) {
                    $lastImagePath = IMAGES_PATH . "books/" . $form['lastBookImage'];

                    if (file_exists($lastImagePath) && $form['lastBookImage'] !== "bookDefault.webp") {
                        unlink($lastImagePath);
                    }
                }
            }
        }else{
            $form['bookImage'] =  $form['lastBookImage'];
        }

        
        $stmt = $this->db->query($sql,[
            'title'  => $form['title'],
            'author' => $form['author'],
            'desc'  => $form['desc'],
            'status'  => $form['status'] === "available" ? 1 : 0,
            'image'  => $form['bookImage'],
            'id'  => $form['book_id'],
            'sold_by'  => $form['sold_by']
        ]);

        return $stmt->rowCount();
    }


     public function createBook(array $form)
    {
        $sql = "INSERT INTO books(title,author,description,status,image,sold_by) VALUES (:title,:author,:desc,:status,:image,:sold_by)";
        
        if ($form['bookImage']) {
            $tmp_name = $form['bookImage']['tmp_name'];
            $imgName = uniqid("book-") . ".jpg";
             
            if(move_uploaded_file($tmp_name,IMAGES_PATH . "books/$imgName")){
                $form['bookImage'] = $imgName;
            }else{
                $form['bookImage'] =  "bookDefault.webp";
            }
        }else{
            $form['bookImage'] =  "bookDefault.webp";
        }

        $stmt = $this->db->query($sql,[
            'title'  => $form['title'],
            'author' => $form['author'],
            'desc'  => $form['desc'],
            'status'  => $form['status'] === "available" ? 1 : 0,
            'image'  => $form['bookImage'],
            'sold_by'  => $form['sold_by']
        ]);

        return $stmt->rowCount();
    }



    public function checkUserBookAction(int $userId, int $book_id){
        $sql = "SELECT id FROM books WHERE id = :book_id AND sold_by = :sold_by ";

        $stmt = $this->db->query($sql,['book_id' => $book_id,'sold_by' => $userId]);

        $data = $stmt->fetch();

        if (!$data) {
            return false;
        }

        return true;
    }
    
}

   