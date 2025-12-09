<?php 

class Chatroom extends AbstractEntity
{
    private string $user_one_id;
    private string $user_two_id;
    private DateTime $created_at; 
   
    /**
     * Get the value of user_one_id
     */ 
    public function getUserOneId()
    {
        return $this->user_one_id;
    }

    /**
     * Set the value of user_one_id
     *
     * @return  self
     */ 
    public function setUserOneId($user_one_id)
    {
        $this->user_one_id = $user_one_id;

        return $this;
    }

    /**
     * Get the value of user_two_id
     */ 
    public function getUserTwoId()
    {
        return $this->user_two_id;
    }

    /**
     * Set the value of user_two_id
     *
     * @return  self
     */ 
    public function setUserTwoId($user_two_id)
    {
        $this->user_two_id = $user_two_id;

        return $this;
    }


     /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }


     /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

}