
    <div class="user-box-container user-box-container-left user-box-container-left-public">
        <div>
            <div id="user-profile-img-container">
                <img  src="<?= IMAGES_PATH . "users/" . htmlspecialchars($user->getProfileImage()) ?>" alt="Image utilisateur">
            </div>
            <hr>
            <div id="user-profile-account-info">
                <h2 id="user-profile-pseudo"><?= htmlspecialchars($user->getPseudo())?></h2>
                <p id="user-profile-account-info-createdAt">Membre depuis 1 an</p>
                <div>
                    <h3 id="user-profile-account-info-biblio">BIBLIOTHEQUE</h3>
                    <div class="flex-c-c">
                        <div class="book-draw-container">
                            <span aria-hidden="true" class="book-draw"></span> 
                            <span aria-hidden="true" class="book-draw book-draw-right"></span> 
                        </div>
                        <p id="user-profile-account-info-bookCount"><?= count($books)?> livres</p>
                    </div>
                    <a class="btn-secondary pt-45" href="?route=/messagerie&toUser=<?= htmlspecialchars($user->getId())?>">Écrire un message</a>
                </div>
            </div>
        </div>
    </div>
