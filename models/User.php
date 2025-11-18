<?php 

class User extends AbstractEntity{
    private string $email;
    private string $password;
    private string $pseudo;
    private DateTime $signup_date;
    private string $profile_image;

    
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
     * Get the value of profile_image
     */ 
    public function getProfile_image()
    {
        return $this->profile_image;
    }

    /**
     * Set the value of profile_image
     *
     * @return  self
     */ 
    public function setProfile_image($profile_image)
    {
        $this->profile_image = $profile_image;

        return $this;
    }
}

