<?php 

class AuthorManager extends AbstractEntityManager{

    /**
     * Get Author by ID
     * @param int $id
     * @return Author|bool
    */
    public function getAuthor(int $id):Author|false
    {
        $sql = "SELECT id, name, pseudo FROM authors WHERE id = :id";

        $stmt = $this->db->query($sql,['id' => $id]);
        $author = $stmt->fetch();

        if (!$author) {
            return false;
        }
        return new Author($author);
    }


    /**
     *Create or Update an Author
     *@param Author
     *@return bool stmt->rowCount()
    */
    public function createOrUpdateAuthor(Author $author):bool
    {
        $params = [
            'name'    => $author->getName(),
            'pseudo'  => $author->getPseudo()
        ];

        if ($author->getId() !== -1) {
            $sql = "UPDATE authors SET name = :name, pseudo = :pseudo WHERE id = :id";
            $params['id'] = $author->getId();
        }else{
            $sql = "INSERT INTO authors(name,surname,pseudo) VALUES(:name,:surname,:pseudo)";
        }

        $stmt = $this->db->query($sql,$params);
        
        return $stmt->rowCount();
    }
}