<?php 

class MessageController extends AbstractController
{
    public function sendMessage()
    {
        $otherUserId = Utils::request("other_user_id",-1);
        $chatroomId = Utils::request("chatroom","");
        $userId = Utils::checkUser();
        $sentMessage = Utils::request("message","");

        $newConnection = Utils::request("connecting","") == "true" && $sentMessage && $_SESSION['connectingWithUser'] && Utils::request("submit","") == "true" && !$chatroomId;

        if (!$sentMessage) {
            $this->redirect("index.php?route=/messages&chatroom=" . $chatroomId);
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
        $messageManager->sentMessage($newMessage);

        if ($newConnection) {
            unset($_SESSION['connectingWithUser']);
        }

        $this->redirect("index.php?route=/messages&chatroom=" . $chatroomId . "&other_user_id=" . $otherUserId);
    }



    public function showMessages(array $chatrooms,string $chatroomId,int $otherUserId,int $userId)
    {
        $userManager = new UserManager();
        $otherUser = $userManager->getUser($otherUserId);
        $messages = $this->getChatroomMessages($chatroomId,$otherUserId,$userId);

        return $this->render("chatrooms", ['title' => "Messagerie", "chatrooms" => $chatrooms, 'messages' => $messages, "userId" => $userId, "otherUser" => $otherUser], "Messagerie");
    }


    private function getChatroomMessages($chatroomId,$otherUserId,$userId)
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

}

