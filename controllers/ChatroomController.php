<?php

class ChatroomController extends AbstractController
{
    public function showChatrooms(){
        $userId = Utils::checkUser();

        if (!$userId) {
            $this->redirect("index.php?route=/connection");
        }

        $chatroomManager = new ChatroomManager();
        $chatrooms = $chatroomManager->getUserChatrooms($userId);

        $otherUserId = Utils::request("other_user_id",-1);
        $chatroomId = Utils::request("chatroom","");

        if (($otherUserId && is_numeric($otherUserId)) && $chatroomId) {
            $messageController = new MessageController();
            return $messageController->showMessages($chatrooms,$chatroomId,$otherUserId,$userId);
        }
        
        $this->render("chatrooms",['title' => "Messagerie","chatrooms" => $chatrooms,"userId" => $userId],"Messagerie");
    }




    public function verifyChatroom(bool $isConnecting)
    {
        $otherUserId = Utils::request("other_user_id",-1);
        $otherUserPseudo = Utils::request("pseudo","");

        if (!$otherUserId || !is_numeric($otherUserId) || !$otherUserPseudo) {
            throw new Exception("Error Processing Request", 404);
        }
        $userManager = new UserManager();
        $user = $userManager->checkExistingUser($otherUserId,$otherUserPseudo);

        if (!$user) {
            throw new Exception("Error Processing Request", 404);
        }
        if ($isConnecting) {
            if($chatId = $this->checkExistingChatroomByUsers($otherUserId)){
                unset($_SESSION['connectingWithUser']);
                $this->redirect("index.php?route=/messages&chatroom=" . $chatId . "&other_user_id=" . $otherUserId);
            }else{
                $_SESSION['connectingWithUser'] = $user;
                $this->redirect("index.php?route=/messages&connectingId=" . $user['id']);
            }
        }else{
            return true;
        }
    }




    private function checkExistingChatroomByUsers(int $otherUserId){
        $userId = Utils::checkUser();

        $chatroomManager = new ChatroomManager();
        return $chatroomManager->checkExistingChatroomByUsers($userId,$otherUserId);
    }
}