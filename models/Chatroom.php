<?php 

class Chatroom extends AbstractEntity{
    private string $main_user_id;
    private string $second_user_id;

    /**
     * Get the value of main_user_id
     */ 
    public function getMain_user_id()
    {
        return $this->main_user_id;
    }

    /**
     * Set the value of main_user_id
     *
     * @return  self
     */ 
    public function setMain_user_id($main_user_id)
    {
        $this->main_user_id = $main_user_id;

        return $this;
    }

    /**
     * Get the value of second_user_id
     */ 
    public function getSecond_user_id()
    {
        return $this->second_user_id;
    }

    /**
     * Set the value of second_user_id
     *
     * @return  self
     */ 
    public function setSecond_user_id($second_user_id)
    {
        $this->second_user_id = $second_user_id;

        return $this;
    }
}