<?php 

class Notification extends AbstractEntity{
    private int $id_message;
    private int $from_user_id;
    private int $to_user_id;
    private string $chatroom_id;

    /**
     * Get the value of id_message
     */ 
    public function getIdMessage()
    {
        return $this->id_message;
    }

    /**
     * Set the value of id_message
     *
     * @return  self
     */ 
    public function setIdMessage($id_message)
    {
        $this->id_message = $id_message;

        return $this;
    }

    /**
     * Get the value of from_user_id
     */ 
    public function getFromUserId()
    {
        return $this->from_user_id;
    }

    /**
     * Set the value of from_user_id
     *
     * @return  self
     */ 
    public function setFromUserId($from_user_id)
    {
        $this->from_user_id = $from_user_id;

        return $this;
    }

    /**
     * Get the value of to_user_id
     */ 
    public function getToUserId()
    {
        return $this->to_user_id;
    }

    /**
     * Set the value of to_user_id
     *
     * @return  self
     */ 
    public function setToUserId($to_user_id)
    {
        $this->to_user_id = $to_user_id;

        return $this;
    }

 
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
}

