<?php 

class BookManager extends AbstractEntityManager{

    /**
     * Get a Book by id
     * @param int $id
     * @return Book|false
     */
    public function getBook(int $id):Book|false
    {
        $sql = " SELECT b.id, b.image, b.description, b.status FROM books b
                 JOIN authors a ON a.id = b.author_id
                 WHERE b.id = :id
               ";

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
    public function getBooks(int $id):array|false
    {
        $sql = " SELECT b.id, b.image, b.description, b.status FROM books b
                 JOIN authors a ON a.id = b.author_id
                 WHERE id >= :id
               ";

        $stmt = $this->db->query($sql,['id' => 0]);

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
     * @return bool $stmt->rowCount()
     */
     public function createOrUpdateBook(Book $book,?Author $author):bool
    {
        $params = [
            'title'    => $book->getTitle(),
            'image' => $book->getImage(),
            'description'  => $book->getDescription(),
            'status'  => $book->getStatus(),
        ];

        if ($book->getId() !== -1) {
            $sql = "UPDATE books SET title = :title, image = :image, description = :description, status = :status WHERE id = :id";
            $params['id'] = $book->getId();
        }else{
            $sql = "INSERT INTO books(title,author_id,image,description,status) VALUES(:title,:author_id,:image,:description,:status)";

            $authorManager = new AuthorManager();
            $authorManager->createOrUpdateAuthor($author);

            $author_id = $authorManager->db->getPDO()->lastInsertId();
            $params['author_id'] = $author_id;
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

        $sql = "SELECT b.id, b.title, b.image, a.name, a.pseudo FROM books b
                JOIN authors a ON a.id = b.author_id
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
    
    
}

   