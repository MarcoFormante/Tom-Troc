

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
           </ul>
        </div>
            <?php if(isset($otherUser) && $otherUser->getId()):?>
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
                <form>
                    <div class="message-input">
                        <label hidden for="message">Message</label>
                        <input type="text" id="message" name="message" placeholder="Tapez votre message ici"/>
                    </div>
                    <div>
                        <button class="btn-primary" type="submit">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif ?>
    </div>
</div>

