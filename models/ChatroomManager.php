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
       
        $sql = "SELECT c.id, 

                CASE
                    WHEN c.user_one_id = :user_id
                        THEN u2.id
                    ELSE u1.id
                END AS other_user_id,

                CASE
                    WHEN c.user_one_id = :user_id
                        THEN u2.profile_image
                    ELSE u1.profile_image
                END AS other_user_image,

                 CASE
                    WHEN c.user_one_id = :user_id
                        THEN u2.pseudo
                    ELSE u1.pseudo
                END AS other_user_pseudo,

                m.content AS last_message,
                m.sent_at AS sent_at

                FROM chatrooms c

                JOIN users u1 ON u1.id = c.user_one_id
                JOIN users u2 ON u2.id = c.user_two_id

                LEFT JOIN messages m ON m.id = (
                    SELECT id
                    FROM messages 
                    WHERE chatroom_id = c.id
                    ORDER BY sent_at DESC LIMIT 1
                )

                WHERE c.user_one_id = :user_id 
                OR c.user_two_id = :user_id";

        $stmt = $this->db->query($sql,[
            'user_id' => $user_id
        ]); 
        
        $rooms = [];

        while($room = $stmt->fetch()){
            $rooms[] = $room;
        }

        return $rooms;

    }
}