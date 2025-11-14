<?php 

class Message extends AbstractEntity{
    private string $chatroom_id;
    private string $user_one_id;
    private string $user_two_id;
    private string $content;
    private DateTime $sent_at;

    /**
     * Get the value of chatroom_id
     */ 
    public function getChatroom_id()
    {
        return $this->chatroom_id;
    }

    /**
     * Set the value of chatroom_id
     *
     * @return  self
     */ 
    public function setChatroom_id($chatroom_id)
    {
        $this->chatroom_id = $chatroom_id;

        return $this;
    }

    /**
     * Get the value of user_one_id
     */ 
    public function getUser_one_id()
    {
        return $this->user_one_id;
    }

    /**
     * Set the value of user_one_id
     *
     * @return  self
     */ 
    public function setUser_one_id($user_one_id)
    {
        $this->user_one_id = $user_one_id;

        return $this;
    }

    /**
     * Get the value of user_two_id
     */ 
    public function getUser_two_id()
    {
        return $this->user_two_id;
    }

    /**
     * Set the value of user_two_id
     *
     * @return  self
     */ 
    public function setUser_two_id($user_two_id)
    {
        $this->user_two_id = $user_two_id;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of sent_at
     */ 
    public function getSent_at()
    {
        return $this->sent_at;
    }

    /**
     * Set the value of sent_at
     *
     * @return  self
     */ 
    public function setSent_at($sent_at)
    {
        $this->sent_at = $sent_at;

        return $this;
    }
}