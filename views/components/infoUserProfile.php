 <?php 
    $errors = $_SESSION['form_errors'] ?? [];
    $lastInputs = $errors['lastInputs'] ?? [];
 ?>
 
 
 <form class="form-base"  method="post" enctype="multipart/form-data">
    <div class="user-box-container user-box-container-left">
        <div>
            <div id="user-profile-img-container">
                <img  id="userImg" src="<?= IMAGES_PATH . "users/" . htmlspecialchars($user->getProfileImage()) ?>" alt="Photo utilisateur">
                <label for="profileImage">modifier</label>
                <input aria-label="hidden" hidden name="profileImage" id="profileImage" type="file"  accept="image/jpeg, image/png, image/webp"/>
                <input type="hidden" aria-label="hidden" hidden name="lastProfileImage" id="lastProfileImage" value="<?= htmlspecialchars($user->getProfileImage()) ?>"/>
            </div>
            <?php if (isset($errors['image']) && !empty($errors['image'])):?>
                <ul class="error-list-container">
                    <?php foreach ($errors['image'] as $error):?>
                        <li class="error-list-item"><?= htmlspecialchars($error) ?></li>
                     <?php endforeach ?>
                </ul>
           <?php endif ?>
            <hr>
            <div id="user-profile-account-info">
                <h2 id="user-profile-pseudo"><?= htmlspecialchars($user->getPseudo())?></h2>
                <p id="user-profile-account-info-createdAt">Membre depuis <?= Utils::calculateSignupDate($user->getSignupDate()) ?></p>
                <div>
                    <h3 id="user-profile-account-info-biblio">BIBLIOTHEQUE</h3>
                    <div class="flex-c-c">
                        <div class="book-draw-container">
                            <span aria-hidden="true" class="book-draw"></span> 
                            <span aria-hidden="true" class="book-draw book-draw-right"></span> 
                        </div>
                        <p id="user-profile-account-info-bookCount"><?= count($books) == 1 ? "1 livre" : count($books) . " livres"?> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="user-box-container user-box-container-right">
       
            <h4>Vos informations personnelles</h4>
            <div class="form-input-container" data-error="<?= isset($errors['email']) ? htmlspecialchars($errors['email']) : "" ?>">
                <label for="email">Adresse email</label>
                <input maxlength="60"  required  autocomplete="email" class="form-input__gray  <?= isset($errors['email']) ? "error-input-focus" : "" ?>"  type="email" name="email" id="email" value="<?= htmlspecialchars($lastInputs['email'] ?? $user->getEmail()) ?>"/>
            </div>
            <div class="form-input-container"  data-error="<?= isset($errors['password']) ? htmlspecialchars($errors['password']) : "" ?>">
                <label for="password">Mot de passe</label>
                <input maxlength="60" autocomplete="current-password" class="form-input__gray  <?= isset($errors['password']) ? "error-input-focus" : "" ?>" type="password" name="password" id="password" value=""/>
            </div>
            <div class="form-input-container" data-error="<?= isset($errors['pseudo']) ? htmlspecialchars($errors['pseudo']) : "" ?>">
                <label for="pseudo">Pseudo</label>
                <input maxlength="60" required class="form-input__gray  <?= isset($errors['pseudo']) ? "error-input-focus" : "" ?>"  type="text" name="pseudo" id="pseudo" value="<?= htmlspecialchars($lastInputs['pseudo'] ?? $user->getPseudo()) ?>"/>
            </div>
            <input type="hidden" aria-label="hidden" hidden name="userId" value="<?= htmlspecialchars($user->getId()) ?>">
            <input type="hidden" aria-label="hidden" hidden name="route" value="/updateUser">
            <input type="hidden" aria-label="hidden" hidden name="csrf" value="<?= htmlspecialchars($csrf) ?>">
            
            <?php if ($isOwner): ?>
                   <button class="btn-secondary" type="submit" value="submit">Enregistrer</button>
            <?php endif ?>
    </div>
</form>


<?php 

unset($_SESSION['form_errors']);