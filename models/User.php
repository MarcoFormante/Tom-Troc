<?php 

class User extends AbstractEntity{
    private string $email;
    private string $password;
    private string $pseudo;
    private DateTime $signup_date;
    private string $profileImage;
    private array $books;

    
    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of pseudo
     */ 
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set the value of pseudo
     *
     * @return  self
     */ 
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get the value of signup_date
     */ 
    public function getSignup_date()
    {
        return $this->signup_date;
    }

    /**
     * Set the value of signup_date
     *
     * @return  self
     */ 
    public function setSignup_date()
    {
        $this->signup_date = new DateTime('now');

        return $this;
    }


    /**
     * Get the value of profileImage
     */ 
    public function getProfileImage()
    {
        return $this->profileImage;
    }

    /**
     * Set the value of profileImage
     *
     * @return  self
     */ 
    public function setProfileImage($profileImage)
    {
        $this->profileImage = $profileImage;

        return $this;
    }

   

    /**
     * Get User Books
     * 
     * @return array BOOKS
     */ 
    public function getBooks():array
    {
        if (empty($this->books)) {
            $this->setBooks();
        }
        return $this->books;
    }


     /**
     * Set User Books
     * 
     * @return self
     */ 
    public function setBooks():self
    {
        
        $bookManager = new BookManager();
        
        $books = $bookManager->getUserBooks($this->id);

        $this->books = $books;

        return $this;
    }
}

