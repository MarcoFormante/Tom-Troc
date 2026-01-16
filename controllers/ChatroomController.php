<?php

class ChatroomController extends AbstractController
{
    /**
     * Show chatrooms of the authenticated user
     * @return void
     */
    public function showChatrooms(){
        $userId = Utils::checkUser();
        $redirect = Utils::request("redirect");

        if (!$userId) {
            $this->redirect("index.php?route=/connection&redirect=$redirect");
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



    /**
     * Check if the chatroom is valid
     * If is new connection, verify if user has messages with this other user
     * @param bool $isConnecting
     * @return bool|void
     */
    public function verifyChatroom(bool $isConnecting)
    {
        $otherUserId = Utils::request("other_user_id",-1);
        $otherUserPseudo = Utils::request("pseudo","");

        if (!$otherUserId || !is_numeric($otherUserId) || !$otherUserPseudo) {
            throw new Exception("Utilisateur non trouvé", 404);
        }
        $userManager = new UserManager();
        $user = $userManager->checkExistingUser($otherUserId,$otherUserPseudo);

        if (!$user) {
            throw new Exception( "L'utilisateur n'existe pas", 404);
        }

        $requestRedirect = Utils::request("redirect","");
        $requestBookId = Utils::request("id","");
        if ($isConnecting) {
            if($chatId = $this->checkExistingChatroomByUsers($otherUserId)){
                unset($_SESSION['connectingWithUser']);
                Utils::generateCSRF("csrf-message");
                $this->redirect("index.php?route=/messages&chatroom=" . $chatId . "&other_user_id=" . $otherUserId . ($requestRedirect ? "&redirect=". $requestRedirect . "||id=" . $requestBookId : ""));
            }else{
                $_SESSION['connectingWithUser'] = $user;
                Utils::generateCSRF("csrf-message");
                $this->redirect("index.php?route=/messages&connectingId=" . $user['id'] .( $requestRedirect ? "&redirect=". $requestRedirect . "||id=" . $requestBookId : ""));
            }
        }else{
            return true;
        }
    }



    /**
     * Check valid chatrooms by users id
     * @param int $otherUserId
     * @return int $chatroomId or @return false
     */
    private function checkExistingChatroomByUsers(int $otherUserId){
        $userId = Utils::checkUser();
        $chatroomManager = new ChatroomManager();
        return $chatroomManager->checkExistingChatroomByUsers($userId,$otherUserId);
    }
}