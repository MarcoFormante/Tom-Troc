<?php

class NotificationManager extends AbstractEntityManager
{
    /**
     * Sent a notification
     * @param Notification &notification
     * @return bool $stmt->rowCount()
     */
    public function sentNotification(Notification $notification):bool
    {
        $sql ="INSERT INTO notifications(id_message,from_user_id,to_user_id,chatroom_id) 
               VALUES(:id_message,:from_user_id,:to_user_id,:chatroom_id)";

               $stmt = $this->db->query($sql,[
                "id_message" => $notification->getIdMessage(),
                 "from_user_id" => $notification->getFromUserId(),
                 "to_user_id" => $notification->getToUserId(),
                 "chatroom_id" => $notification->getChatroomId()
               ]);

               return $stmt->rowCount();

    }


    /**
     * Get all User Notifications
     * @param int $id ID of the authenticated user
     * @return array $notifications
     */
    public function getNotifications(int $id): ?array
    {
        $sql = "SELECT id, id_message, from_user_id, to_user_id,chatroom_id 
                FROM notifications
                WHERE to_user_id = :to_user_to
                GROUP BY chatroom_id
              ";

        $stmt = $this->db->query($sql,[
            'to_user_to' => $id
        ]);

        $notifications = [];

        while($notification = $stmt->fetch()){
            $notifications[] = $notification;
        }
        
        return $notifications;
    }


    /**
    * Delete notifications for a user in a specific chatroom after viewing messages
     * @param string $chatroomId ID of the current Chatroom
     * @param int $userId  ID of the authenticated User
     * @return bool $rowCount
     */
    public function deleteNotification(string $chatroomId,int $userId):bool
    {
        $sql = "DELETE FROM notifications  WHERE chatroom_id = :id AND to_user_id = :userId";

        $stmt = $this->db->query($sql,['id' => $chatroomId,'userId' => $userId]);

        return $stmt->rowCount();
    }
}