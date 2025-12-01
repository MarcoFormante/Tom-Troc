<?php 

class User extends AbstractEntity{
    private string $email;
    private string $password;
    private string $pseudo;
    private DateTime $signupDate;
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
    public function getSignupDate()
    {
        return $this->signupDate;
    }

    /**
     * Set the value of signup_date
     *
     * @return  self
     */ 
    public function setSignupDate(DateTime|string $date)
    {
        if ($date instanceof DateTime) {
            $this->signupDate = $date ;
        }else{
               $this->signupDate = new DateTime(htmlspecialchars($date));
        }

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

