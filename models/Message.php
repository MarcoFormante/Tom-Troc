<?php 

class Message extends AbstractEntity{
    private string $chatroom_id;
    private string $content = "";
    private int $sent_by_user_id;
    private DateTime $sent_at;

    /**
     * Get the value of chatroom_id
     */     
    public function getChatroomId()
    {
        return $this->chatroom_id;
    }

    /**
     * Set the value of chatroom_id
     *
     * @return  self
     */ 
    public function setChatroomId($chatroom_id)
    {
        $this->chatroom_id = $chatroom_id;

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
    public function getSentAt()
    {
        return $this->sent_at;
    }

    /**
     * Set the value of sent_at
     *
     * @return  self
     */ 
    public function setSentAt($sent_at )
    {
        $this->sent_at = new DateTime($sent_at);

        return $this;
    }

    /**
     * Get the value of sent_by_user_id
     */ 
    public function getSentByUserId()
    {
        return $this->sent_by_user_id;
    }

    /**
     * Set the value of sent_by_user_id
     *
     * @return  self
     */ 
    public function setSentByUserId($sent_by_user_id)
    {
        $this->sent_by_user_id = $sent_by_user_id;

        return $this;
    }
}