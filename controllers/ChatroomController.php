<?php

class ChatroomController extends AbstractController
{
    public function showChatrooms(){
        $userId = Utils::checkUser();
        $messages = [];
        $otherUser = -1;

        if (!$userId) {
            $this->redirect("index.php?route=/connection");
        }
        
        $chatroomManager = new ChatroomManager();
        $chatrooms = $chatroomManager->getUserChatrooms($userId);

       
        $otherUserId = Utils::request("other_user_id",-1);
        $chatroomId = Utils::request("chatroom","");

        if (($otherUserId && is_numeric($otherUserId)) && $chatroomId) {
            $userManager = new UserManager();
            $otherUser = $userManager->getUser($otherUserId);
            $messages = $this->getChatroomMessages($chatroomId);
            return $this->render("chatrooms",['title' => "Messagerie","chatrooms" => $chatrooms,'messages' =>$messages,"userId" => $userId,"otherUser" => $otherUser],"Messagerie");
        }
        
        $this->render("chatrooms",['title' => "Messagerie","chatrooms" => $chatrooms,"userId" => $userId],"Messagerie");
    }


    public function getChatroomMessages()
    {
        $chatroom_id = Utils::request("chatroom",-1);

        if (!$chatroom_id) {
            throw new Exception("Error Processing Request", 404);
        }

        $messageManager = new MessageManager();
        $messages = $messageManager->getChatroomMessages($chatroom_id);
        return $messages;
    }
}