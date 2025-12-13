<header aria-label="main navigation">
    <nav id="main-nav" aria-label="main navigation">
        <div class="flex-c-c">
            <a id="header-logo" href="index.php?route=/" aria-label="homepage">
                <div id="header-logo-container">
                    <div id="header-logo-img"></div>
                </div>
                <span>Tom Troc</span>
            </a>
            <ul class="nav-list__left">
                <li>
                    <a class="<?= UTILS::checkActiveRoute("/") . UTILS::checkActiveRoute("")  ?>" href="index.php?route=/">Accueil</a>
                </li>
                <li>
                    <a class="<?= UTILS::checkActiveRoute("/nos-livre-a-lechange") ?>" href="index.php?route=/nos-livre-a-lechange">Nos livres à l’échange</a>
                </li>
            </ul>
        </div>
    
        <ul class="nav-list__right">
            <li id="message-list-item">
                <span id="message-logo" aria-hidden="true"></span>
                <a class="<?= UTILS::checkActiveRoute("/messages") ?>" href="index.php?route=/messages">Messagerie</a>

                <!-- NOTIFICATIONS -->
                <?php if(isset($_SESSION['notifications']) && count($_SESSION['notifications']) > 0): ?>
                    <span id="notif-icon"><?= count($_SESSION['notifications']) ?></span> 
                <?php endif ?>

            </li>
            <li><a class="<?= UTILS::checkActiveRoute("/mon-compte") ?>" href="index.php?route=/mon-compte">Mon compte</a></li>
            <li><a class="<?= UTILS::checkActiveRoute("/connection") ?>" href="index.php?route=/connection">Connexion</a></li>
        </ul>
    </nav>
</header>