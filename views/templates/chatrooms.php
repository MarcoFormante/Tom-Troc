
<?php 
    $connectingUser = $_SESSION['connectingWithUser'] ?? null ;

    $isValidConnectingUser = $connectingUser && Utils::request("connectingId") == $connectingUser['id'];
?>

<div id="messagerie"> 
    <div class="main-container">
        <div class="chats-box">
            <div>
                <h1><?= htmlspecialchars($title) ?></h1>
            </div>
           <ul class="chatrooms" aria-label="Liste de messages">
                <?php foreach($chatrooms as $chatroom): ?>
                    <li class="<?= Utils::request("chatroom",-1) == htmlspecialchars($chatroom['id'])? "selected" : "" ?>">
                        <a href="index.php?route=/messages&chatroom=<?= htmlspecialchars($chatroom['id']) ?>&other_user_id=<?=  htmlspecialchars($chatroom['other_user_id']) ?>" >
                            <div class="message-info">
                                <img class="user-img" src="<?= IMAGES_PATH . "users/" . htmlspecialchars($chatroom['other_user_image']) ?>" alt="<?= htmlspecialchars($chatroom['other_user_pseudo']) ?>, utilisateur du site TomTroc">
                                <div class="user-info">
                                    <div class="color-dark-grey">
                                        <span class="user-pseudo"><?= htmlspecialchars($chatroom['other_user_pseudo']) ?></span> 
                                        <time datetime="<?= date("c",strtotime(htmlspecialchars($chatroom['sent_at'])))?>"><?= date("H:i",date_create(htmlspecialchars($chatroom['sent_at']))->getTimestamp())?></time>
                                    </div>
                                    <p class="last-message"><?= htmlspecialchars($chatroom['last_message']) ?></p>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach ?>

                <?php if($connectingUser):?>
                    <li class="selected">
                        <a href="index.php?route=/messages&connectingId=<?=  htmlspecialchars($connectingUser['id']) ?>"  >
                            <div class="message-info">
                                <img class="user-img" src="<?= IMAGES_PATH . "users/" . htmlspecialchars($connectingUser['profile_image']) ?>" alt="<?= htmlspecialchars($connectingUser['pseudo']) ?>, utilisateur du site TomTroc">
                                <div class="user-info">
                                    <div class="color-dark-grey">
                                        <span class="user-pseudo"><?= htmlspecialchars($connectingUser['pseudo'])   ?></span> 
                                        <time></time>
                                    </div>
                                    <p class="last-message"></p>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endif ?>
           </ul>
        </div>
            <?php if(isset($otherUser) && $otherUser->getId() && !$isValidConnectingUser):?>
        <div class="message-container">
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
                        <input required type="text" id="message" name="message" placeholder="Tapez votre message ici"/>
                        <input hidden required name="route" value="/sendMessage"/>
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
              
            </div>
            <div class="message-input-container">
                <form method="post">
                    <div class="message-input">
                        <label hidden for="message">Message</label>
                        <input required type="text" id="message" name="message" placeholder="Tapez votre message ici"/>
                        <input hidden required name="connecting" value="true"/>
                        <input hidden required name="route" value="/sendMessage"/>
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

