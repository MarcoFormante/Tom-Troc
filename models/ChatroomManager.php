<?php 

class ChatroomManager extends AbstractEntityManager
{
    
    public function createChatroom(int $user_one_id,int $user_two_id):bool
    {
        $now =  new DateTime();
        $chatroom_id = uniqid("ROOM-") . $now->getTimestamp();

        $sql = "INSERT INTO chatrooms(id,user_one_id,user_two_id) VALUE(:room_id,:user_one_id,:user_two_id)";

        $stmt = $this->db->query($sql,[
            'room_id' => $chatroom_id,
            'user_one_id' => $user_one_id,
            'user_two_id' => $user_two_id,
        ]);

        return $stmt->rowCount();
    }


    public function getUserChatrooms(int $user_id):array
    {
        $sql = "SELECT c.id,  c.user_one_id, c.user_two_id, m.content, m.sent_at
                FROM chatrooms c
                JOIN messages m ON m.chatroom_id = id
                WHERE (c.user_one_id = :user_id OR c.user_two_id = :user_id)
                AND m.id IN (
                    SELECT MAX(id)
                    FROM messages
                    WHERE c.id = m.chatroom_id
                    GROUP BY c.id
                )
                ORDER BY m.sent_at DESC";

        $stmt = $this->db->query($sql,[
            'user_id' => $user_id
        ]);
        
        $messages = [];
        while($message = $stmt->fetch()){
             $messages[] = new Message($message);
        }
        
        return $messages;

    }
}