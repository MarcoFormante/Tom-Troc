
    <div class="user-box-container user-box-container-left user-box-container-left-public">
        <div>
            <div id="user-profile-img-container">
                <img  src="<?= IMAGES_PATH . "users/" . htmlspecialchars($user->getProfileImage()) ?>" alt="Image utilisateur">
            </div>
            <hr>
            <div id="user-profile-account-info">
                <h2 id="user-profile-pseudo"><?= htmlspecialchars($user->getPseudo())?></h2>
                    <?php if($isUserProfile): ?>
                        <div>
                            <p class="mt-10 inter-600">( TOI )</p>
                        </div>
                    <?php endif ?>
                <p id="user-profile-account-info-createdAt">Membre depuis <?= Utils::calculateSignupDate($user->getSignupDate()) ?></p>
                <div>
                    <h3 id="user-profile-account-info-biblio">BIBLIOTHEQUE</h3>
                    <div class="flex-c-c">
                        <div class="book-draw-container">
                            <span aria-hidden="true" class="book-draw"></span> 
                            <span aria-hidden="true" class="book-draw book-draw-right"></span> 
                        </div>
                        <p id="user-profile-account-info-bookCount"><?= count($books) == 1 ? "livre" : "livres"?></p>
                    </div>
                    <?php if(!$isUserProfile): ?>
                        <a class="btn-secondary pt-45" href="?route=/openMessage&other_user_id=<?= htmlspecialchars($user->getId())?>&pseudo=<?= htmlspecialchars($user->getPseudo())?>">Écrire un message</a>
                    <?php endif ?>
                </div>  
            </div>
        </div>
    </div>
