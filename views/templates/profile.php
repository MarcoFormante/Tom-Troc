
<div id="user-profile"  class="<?= !$isOwner ? "user-profile-public" : "" ?>">
    <h1 class="playfair-display-400">Mon compte</h1>
    <div id="user-profile-flex-container" class="<?= !$isOwner ? "flex-row" : "" ?>">
        <section id="user-profile-info-section">
            <div class="user-box-container user-box-container-left <?= !$isOwner ? "user-box-container-left-public" : "" ?>">
                <div>
                    <div id="user-profile-img-container">
                        <img src="<?= IMAGES_PATH . "users/" . htmlspecialchars($user->getProfileImage()) ?>" alt="Image utilisateur">
                        <?php if($isOwner):?>
                            <a href="?route=/modifier-image">modifier</a>
                        <?php endif ?>
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
                            <?php if(!$isOwner):?>
                                  <a class="btn-secondary pt-45" href="?route=/messagerie&toUser=<?= htmlspecialchars($user->getId())?>">Écrire un message</a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if($isOwner):?>
                <div class="user-box-container user-box-container-right">
                    <form class="form-base"  method="post">
                        <h4>Vos informations personnelles</h4>
                        <div class="form-input-container" data-error="<?= isset($errors['email']) ? $errors['email'] : "" ?>">
                            <label for="email">Adresse email</label>
                            <input  required  autocomplete="email" class="form-input__gray  <?= isset($errors['email']) ? "error-input-focus" : "" ?>"  type="email" name="email" id="email" value="<?= htmlspecialchars($user->getEmail()) ?>"/>
                        </div>

                        <div class="form-input-container"  data-error="<?= isset($errors['password']) ? $errors['password'] : "" ?>">
                            <label for="password">Mot de passe</label>
                            <input autocomplete="current-password" class="form-input__gray   <?= isset($errors['password']) ? "error-input-focus" : "" ?>" type="password" name="password" id="password" value=""/>
                        </div>

                        <div class="form-input-container" data-error="<?= isset($errors['pseudo']) ? $errors['pseudo'] : "" ?>">
                            <label for="pseudo">Pseudo</label>
                            <input required class="form-input__gray  <?= isset($errors['pseudo']) ? "error-input-focus" : "" ?>"  type="text" name="pseudo" id="pseudo" value="<?= htmlspecialchars($user->getPseudo()) ?>"/>
                        </div>

                        <input hidden name="userId" value="<?= htmlspecialchars($user->getId()) ?>">
                        <input hidden name="image" value="<?= htmlspecialchars($user->getProfileImage()) ?>">
                        <input hidden name="route" value="/updateUser">

                        <button class="btn-secondary" type="submit" value="submit">Enregistrer</button>
                    </form>
                </div>
            <?php endif ?>
        </section>

        <section id="user-books-table" class="<?= !$isOwner ? "w-100 no-margin-bottom" : "" ?>">
            <table>
                <thead>
                    <tr>
                        <th class="th-spacing"></th>
                        <th scope="col">PHOTO</th>
                        <th scope="col" class="p-left">TITRE</th>
                        <th scope="col" class="p-left">AUTEUR</th>
                        <th scope="col" class="desc-spacing">DESCRIPTION</th>
                        <?php if($isOwner):?>  
                            <th scope="col" class="p-left">DISPONIBILITE</th>
                            <th scope="col" class="edit-spacing" class="p-left">ACTION</th>
                            <th scope="col"></th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <tr class="body-spacing"><td></td></tr>
                    <?php foreach($books as $book):?>
                        <tr>
                            <td></td>
                            <td class="w-127">
                                <img width="78px" height="78px" src="<?= IMAGES_PATH . 'books/' . htmlspecialchars($book->getImage()) ?>" alt="<?= htmlspecialchars($book->getTitle()) . " de " . htmlspecialchars($book->getAuthor())?>">
                            </td>
                            <td class="w-155 p-left">
                                <?= htmlspecialchars($book->getTitle()) ?>
                            </td>
                            <td class="w-138 p-left">
                                <?= htmlspecialchars($book->getAuthor()) ?>
                            </td>
                            <td class="w-146 desc-spacing p-left">
                                <p><?= htmlspecialchars(substr_replace($book->getDescription(),"...",70)) ?></p>
                            </td>

                            <?php if($isOwner):?>    
                                <td class="w-81 p-left">
                                    <div class="book-status <?= $book->getStatus() ? "book-status__green" : "book-status__red"  ?>">
                                        <?= $book->getStatus() ? "disponible" : "non dispo." ?>
                                    </div>
                                </td>
                                <td >
                                    <a href="?route=/editer&bookid=<?= htmlspecialchars($book->getId()) ?>&sold_by=<?= htmlspecialchars($book->getSoldBy()) ?>">Éditer</a>
                                </td>
                                <td class="w-127">
                                   <form class="table-form" method="post">
                                        <input hidden name="route" value="/deleteBook"/>
                                        <input hidden type="text" name="bookId" value="<?= htmlspecialchars($book->getId()) ?>"/>
                                        <input hidden type="text" name="soldBy" value="<?= htmlspecialchars($book->getSoldBy()) ?>"/>
                                        <button class="btn-text" type="submit" name="submit" value="submited">Supprimer</button>
                                    </form>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </section>
    </div>
</div>