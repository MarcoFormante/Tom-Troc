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
        $sql ="INSERT INTO notifications(id_message,from_user_id,to_user_id,last_message_id_viewed,chatroom_id) 
               VALUES(:id_message,:from_user_id,:to_user_id,:last_message_id_viewed,:chatroom_id)";

               $stmt = $this->db->query($sql,[
                "id_message" => $notification->getId_message(),
                 "from_user_id" => $notification->getFrom_user_id(),
                 "to_user_id" => $notification->getTo_user_id(),
                 "last_message_id_viewed" => $notification->getLast_message_id_viewed(),
                 "chatroom_id" => $notification->getChatroom_id()
               ]);

               return $stmt->rowCount();

    }


    /**
     * Get all User Notifications
     * @param int $id
     * @return array $notifications
     */
    public function getNotifications(int $id):array
    {
        $sql = "SELECT id_message, from_user_id, to_user_id, last_message_id_viewed, chatroom_id 
                FROM notifications
                WHERE last_message_id_viewed <> id_message
                AND to_user_id = :to_user_to
              ";

        $stmt = $this->db->query($sql,[
            'to_user_to' => $id
        ]);

        $notifications = [];

        while($notification = $stmt->fetch()){
            $notifications[] = new Notification($notification);
        }

        return $notification;
    }


    /**
     * Update Notification
     * @param int $id_message
     * @param int $id_notification
     * @return bool $stmt->rowCount()
     */
    public function updateNotification(int $id_message,int $id_notification):bool
    {
        $sql = "UPDATE notifications SET last_message_id_viewed = :id_message
                WHERE id = :id";

        $stmt = $this->db->query($sql,['id' => $id_notification, 'id_message'=> $id_message]);

        return $stmt->rowCount();
    }
}