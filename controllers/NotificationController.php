<?php 

class NotificationController extends AbstractController
{
    /**
     * Retrieve all notifications for the authenticated user.
     * Validates JWT token and fetches notifications from database.
     * @return array|null The notifications array or null if JWT validation fails.
     */
    public function getNotifications(): ?array
    {
        $decodedUser = Utils::validateJWT();

        if (!$decodedUser) {
            return null;
        }

        $notificationManager = new NotificationManager();
        $notifications = $notificationManager->getNotifications($decodedUser['id']);
        $_SESSION['notifications'] = $notifications;
        return $notifications;
        
    }


    /**
     * Delete the notification associated with a chatroom for the authenticated user.
     * @param string $chatroomId ID of the chatroom whose notification should be removed.
     * @param int $userId ID of the user who owns the notification.
     * @return bool|null Returns true if the notification was deleted successfully,
     *                   'false' if no notification was deleted or deletion failed,
     *                   'null' if the provided parameters are invalid.
     */
    public function deleteNotification(string $chatroomId,int $userId): bool|null
    {
        if ($chatroomId && $userId) {
            $notifManager = new NotificationManager();
            $response = $notifManager->deleteNotification($chatroomId,$userId);
            return $response;
        }else{
            return null;
        }
    }


    /**
     * Send a notification after a message is sent.
     * Creates and persists a notification record.
     * @param int $messageId ID of the message being sent.
     * @param int $userId ID of the user sending the message.
     * @param int $otherUserId ID of the user receiving the notification.
     * @param string $chatroomId ID of the chatroom where the message was sent.
     * @return void
    */
    
    public function sendNotification(int $messageId,int $userId,int $otherUserId, $chatroomId){
        $notificationManager = new NotificationManager();
        
        $notification = new Notification([
            'id_message' => $messageId,
            'from_user_id' => $userId,
            'to_user_id' => $otherUserId,
            'chatroom_id' => $chatroomId
        ]);

        $notificationManager->sentNotification($notification);
    }
}