<?php 

class MessageManager extends AbstractEntityManager
{
    /**
     * Get all messages of a chat
     * @param int $chatroom_id
     * @return array Message[] 
     */
    public function getChatroomMessages(string $chatroom_id):array
    {
        $sql = "SELECT c.id, c.user_one_id, c.user_two_id, m.content, m.sent_by_user_id, m.sent_at 
                FROM chatrooms c
                JOIN messages m ON m.chatroom_id = c.id
                WHERE c.id = :id
        ";
   
        $stmt = $this->db->query($sql,[
            "id" => $chatroom_id 
        ]);

        $messages = [];

        while($message = $stmt->fetch()){
            $messages[] = new Message($message);
        }

        return $messages;
    }


    /**
     * Sent a message to user
     * @param Message $message
     * @return bool $stmt->rowCount()
     */
    public function sentMessage(Message $message):bool
    {   
        $sql = "INSERT INTO messages(chatroom_id,user_one_id,user_two_id,content)
                VALUES(:chatroom_id,:user_one_id,:user_two_id,content)";

        
        $stmt = $this->db->query($sql,[
            'chatroom_id' => $message->getChatroom_id(),
            'content' => $message->getContent()
        ]);

       return $stmt->rowCount();
    }
    

}