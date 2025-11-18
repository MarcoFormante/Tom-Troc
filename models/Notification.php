<?php 

class Notification extends AbstractEntity{
    private int $id_message;
    private int $from_user_id;
    private int $to_user_id;
    private int $last_message_id_viewed;
    private int $chatroom_id;

    /**
     * Get the value of id_message
     */ 
    public function getId_message()
    {
        return $this->id_message;
    }

    /**
     * Set the value of id_message
     *
     * @return  self
     */ 
    public function setId_message($id_message)
    {
        $this->id_message = $id_message;

        return $this;
    }

    /**
     * Get the value of from_user_id
     */ 
    public function getFrom_user_id()
    {
        return $this->from_user_id;
    }

    /**
     * Set the value of from_user_id
     *
     * @return  self
     */ 
    public function setFrom_user_id($from_user_id)
    {
        $this->from_user_id = $from_user_id;

        return $this;
    }

    /**
     * Get the value of to_user_id
     */ 
    public function getTo_user_id()
    {
        return $this->to_user_id;
    }

    /**
     * Set the value of to_user_id
     *
     * @return  self
     */ 
    public function setTo_user_id($to_user_id)
    {
        $this->to_user_id = $to_user_id;

        return $this;
    }

    /**
     * Get the value of last_message_id_viewed
     */ 
    public function getLast_message_id_viewed()
    {
        return $this->last_message_id_viewed;
    }

    /**
     * Set the value of last_message_id_viewed
     *
     * @return  self
     */ 
    public function setLast_message_id_viewed($last_message_id_viewed)
    {
        $this->last_message_id_viewed = $last_message_id_viewed;

        return $this;
    }

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
}

