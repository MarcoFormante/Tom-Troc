<?php 

class MessageController extends AbstractController
{
    /**
     * Send Message: handle new message for existing chatroom and for new chatroom;
     * Send notification after sending message
     * @return void
     */
    public function sendMessage()
    {
        $otherUserId = Utils::request("other_user_id",-1);
        $chatroomId = Utils::request("chatroom","");
        $userId = Utils::checkUser();
        $sentMessage = Utils::request("message","");

        $newConnection = Utils::request("connecting","") == "true" && $sentMessage && $_SESSION['connectingWithUser'] && Utils::request("submit","") == "true" && !$chatroomId;

        if (!$sentMessage) {
              $this->redirect("index.php?route=/messages&chatroom=" . $chatroomId . "&other_user_id=" . $otherUserId);
        }

        $newMessage = new Message();
        $newMessage->setContent($sentMessage);
        $newMessage->setSentByUserId($userId);
      
        if (($otherUserId && is_numeric($otherUserId)) && $chatroomId) {
            $newMessage->setChatroomId($chatroomId);
        }
  
        /**Create Chatroom if new Connecction */
        if($newConnection){
            $chatroomManager = new ChatroomManager();
            $chatroomId = $chatroomManager->createChatroom($userId,$_SESSION['connectingWithUser']['id']);
            $otherUserId = $_SESSION['connectingWithUser']['id'];

            if ($chatroomId) {
                $newMessage->setChatroomId($chatroomId);
            }
        }

        $messageManager = new MessageManager();
        $messageId = $messageManager->sentMessage($newMessage);

        if ($newConnection) {
            unset($_SESSION['connectingWithUser']);
        }

        $notifController = new NotificationController();
        $notifController->sendNotification($messageId,$userId,$otherUserId,$chatroomId);

        $this->redirect("index.php?route=/messages&chatroom=" . $chatroomId . "&other_user_id=" . $otherUserId);
    }


    /**
    * Retrieve messages for a specific chatroom, clear notifications once they are read, and render the chat view;
    * Re-fetch notifications and store them in the session variable for further use.
    *
    * @param array $chatrooms An array containing all chatrooms associated with the user.
    * @param string $chatroomId The current chatroom id to show
    * @param int $otherUserId The ID of the other user in the chatroom
    * @param int $userId The ID of the current user
    * @return void
    */
    public function showMessages(array $chatrooms,string $chatroomId,int $otherUserId,int $userId)
    {
        $userManager = new UserManager();
        $otherUser = $userManager->getUser($otherUserId);
        $messages = $this->getChatroomMessages($chatroomId,$otherUserId,$userId);

        if ($notifications = $_SESSION['notifications']) {
            foreach ($notifications as $notif) {
                if ($notif['chatroom_id'] == $chatroomId) {
                    $notifController = new NotificationController();
                    $notifController->deleteNotification($chatroomId,$userId);
                    $notifController->getNotifications();
                }
            }
        }

        return $this->render("chatrooms", ['title' => "Messagerie", "chatrooms" => $chatrooms, 'messages' => $messages, "userId" => $userId, "otherUser" => $otherUser], "Messagerie");
    }

    /**
     * Get all messages of a chatroom;
     * Check if chatroom exists and retrieve all messages for the given users
     * @param string $chatroomId Current chatroom id 
     * @param int $otherUserId The ID of the other user in the chatroom 
     * @param int $userId The ID of the current user
     * @return array $messages
    */
    private function getChatroomMessages(string $chatroomId, int $otherUserId, int $userId)
    {

        if (!$chatroomId || !$otherUserId) {
            throw new Exception("Error Processing Request", 404);
        }
                
        $chatroomManager = new ChatroomManager();
        if (!$chatroomManager->checkExistingChatroomByIds($chatroomId,$otherUserId,$userId)) {
            throw new Exception("Error Processing Request", 404);
        }

        $messageManager = new MessageManager();
        $messages = $messageManager->getChatroomMessages($chatroomId);
        return $messages;
    }

    public function deleteDraft()
    {
        unset($_SESSION['connectingWithUser']);
        $this->redirect("index.php?route=/messages");
    }

}

