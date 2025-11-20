<?php 

class BookManager extends AbstractEntityManager{

    /**
     * Get a Book by id
     * @param int $id
     * @return Book|false
     */
    public function getBook(int $id):Book|false
    {
        $sql = " SELECT id, author, image, description, sold_by, status, FROM books 
                 WHERE id = :id
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
        $sql = " SELECT id, author, image, description, status FROM books 
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
     public function createOrUpdateBook(Book $book):bool
    {
        $params = [
            'title'    => $book->getTitle(),
            'author' => $book->getAuthor(),
            'image' => $book->getImage(),
            'description'  => $book->getDescription(),
            'sold_by' => $book->getSold_by(),
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

        $sql = "SELECT id, author, title, image, sold_by, pseudo FROM books 
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
            $books[] = $book;
        }

        return $books;
    }
    
    
}

   