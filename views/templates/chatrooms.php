
<?php 
    /** check if main user wants text to other user */
    $connectingUser = $_SESSION['connectingWithUser'] ?? null ;
    /**Check if is the same user id of the query parameter  */
    $isValidConnectingUser = $connectingUser && Utils::request("connectingId") == $connectingUser['id'];
    $notifications = $_SESSION['notifications'] ?? null;
    $chatIdsNotifications = [];

    /**Get only chatroom ids and put them in array (chatIdsNotifications) */
    if ($notifications) {
        foreach ($notifications as $key => $notif) {
           $chatIdsNotifications[] =  $notif['chatroom_id'];
        }
    }
?>

<div id="messagerie"> 
    <div class="main-container">
        <div class="chats-box">
            <div>
                <h1><?= htmlspecialchars($title) ?></h1>
            </div>
           <ul class="chatrooms" aria-label="Liste de messages">
                <?php foreach($chatrooms as $key => $chatroom): ?>
                      <!-- Add class 'notificated' if user has some notication from this chatroom-->     
                    <li <?= in_array($chatroom['id'],$chatIdsNotifications) ? "aria-label= Nouveau message" : "" ?> class="<?= Utils::request("chatroom",-1) == htmlspecialchars($chatroom['id'])? "selected " : "" ?> <?= in_array($chatroom['id'],$chatIdsNotifications)   ? "notificated" : "" ?>">
                        <a href="index.php?route=/messages&chatroom=<?= htmlspecialchars($chatroom['id']) ?>&other_user_id=<?=  htmlspecialchars($chatroom['other_user_id']) ?>" >
                            <div class="message-info">
                                <img class="user-img" src="<?= IMAGES_PATH . "users/" . htmlspecialchars($chatroom['other_user_image']) ?>" alt="<?= htmlspecialchars($chatroom['other_user_pseudo']) ?>, utilisateur du site TomTroc">
                                <div class="user-info">
                                    <div class="color-dark-grey">
                                        <span class="user-pseudo"><?= htmlspecialchars($chatroom['other_user_pseudo']) ?></span> 
                                        <time datetime="<?= date("c",strtotime(htmlspecialchars($chatroom['sent_at'])))?>"><?= Utils::formatDateTime(htmlspecialchars($chatroom['sent_at']))?></time>
                                    </div>
                                    <p class="last-message"><?= htmlspecialchars($chatroom['last_message']) ?></p>
                                </div>
                            </div>
                            <?php if(in_array($chatroom['id'],$chatIdsNotifications)): ?>
                                <div class="new-message-container">
                                    <p id="new-message">Nouveau message</p>
                                </div>
                            <?php endif ?>
                        </a>
                    </li>
                <?php endforeach ?>
  <!--Show message if user has no messages -->
          
                <?php if($connectingUser):?>
                    <li class="selected selected__draft">
                        <a href="index.php?route=/messages&connectingId=<?=  htmlspecialchars($connectingUser['id']) ?>"  >
                            <div class="message-info">
                                <img class="user-img" src="<?= IMAGES_PATH . "users/" . htmlspecialchars($connectingUser['profile_image']) ?>" alt="<?= htmlspecialchars($connectingUser['pseudo']) ?>, utilisateur du site TomTroc">
                                <div class="user-info self-center">
                                    <div class="color-dark-grey">
                                        <span class="user-pseudo"><?= htmlspecialchars($connectingUser['pseudo'])   ?></span> 
                                        <time></time>
                                    </div>
                                    <p class="last-message"></p>
                                </div>
                            </div>
                            <p class="new-message">Brouillon</p>
                        </a>
                    </li>
                <?php endif ?>
           </ul>
        </div>
          

          
        <div class="message-container">
            <?php if(!$chatrooms && !$connectingUser ): ?>
                <p>Vous n’avez aucun message pour le moment</p>
             <?php endif ?>
            <?php if(isset($otherUser) && $otherUser->getId() && !$isValidConnectingUser):?>
            <div class="message-user-detail-container">
                <a href="index.php?route=/profile&userId=<?= htmlspecialchars($otherUser->getId()) ?>">
                    <img class="user-img" src="<?= IMAGES_PATH . "users/" . htmlspecialchars($otherUser->getProfileImage()); ?>" alt="<?= htmlspecialchars($otherUser->getPseudo()) ?>, utilisateur du site TomTroc">
                    <span class="user-pseudo"><?= htmlspecialchars($otherUser->getPseudo()) ?></span>
                </a>
            </div>
            <div class="messages-container">
                <?php foreach($messages as $message):?>
                    <div class="user-message <?=htmlspecialchars($message->getSentByUserId()) != $userId ? "second-user-message" : ""?>">
                        <div class="message-info-container">
                            <img src="<?= IMAGES_PATH . "users/" . htmlspecialchars($otherUser->getProfileImage()) ?>" alt="<?=htmlspecialchars($otherUser->getPseudo()) ?>, utilisateur du site TomTroc">
                            <span class="time"><?= htmlspecialchars($message->getSentAt()->format("d.m   H:i")) ?></span>
                        </div>
                        <div class="message-content-container <?=$message->getSentByUserId() == $otherUser->getId() ? "second-user-message-content" : ""?>">
                            <p><?= htmlspecialchars($message->getContent())?></p>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
            <div class="message-input-container">
                <form method="post">
                    <div class="message-input">
                        <label hidden for="message">Message</label>
                        <input maxlength="255" required type="text" id="message" name="message" placeholder="Tapez votre message ici"/>
                        <input hidden required name="route" value="/sendMessage"/>
                        <input hidden required name="csrf-message" value="<?= htmlspecialchars($csrf)?>"/>
                    </div>
                    <div>
                        <button class="btn-primary" name="submit" value="true" type="submit">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif ?>
        
        <?php if($isValidConnectingUser):?>
            <div class="message-container">
                <div class="message-user-detail-container">
                    <a href="index.php?route=/profile&userId=<?= htmlspecialchars($connectingUser['id']) ?>">
                        <img class="user-img" src="<?= IMAGES_PATH . "users/" .htmlspecialchars($connectingUser['profile_image']) ?>" alt="<?= htmlspecialchars($connectingUser['pseudo']) ?>, utilisateur du site TomTroc">
                        <span class="user-pseudo"><?= htmlspecialchars($connectingUser['pseudo']) ?></span>
                    </a>
                </div>
                <div class="messages-container">
                <form class="draft-form" method="post">
                    <input hidden name="route" value="/deleteDraft"/>
                    <input hidden required name="csrf-message" value="<?= htmlspecialchars($_SESSION['csrf-message'] ?? "")?>"/>
                    <button type="submit">Supprimer ce Brouillon</button>
                </form>
                </div>
                <div class="message-input-container">
                    <form method="post">
                        <div class="message-input">
                            <label hidden for="message">Message</label>
                            <input maxlength="255" required type="text" id="message" name="message" placeholder="Tapez votre message ici" />
                            <input hidden required name="connecting" value="true"/>
                            <input hidden required name="route" value="/sendMessage"/>
                            <input hidden required name="csrf-message" value="<?= htmlspecialchars($_SESSION['csrf-message'] ?? "")?>"/>
                        </div>
                        <div>
                            <button class="btn-primary" name="submit" value="true" type="submit">Envoyer</button>
                        </div>
                    </form>
                </div>
        </div>
         <?php endif ?>
    </div>
</div>

