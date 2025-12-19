
<div id="user-profile"  class="<?= !$isOwner ? "user-profile-public" : "" ?>">
    <h1 class="playfair-display-400"> <?=!$isOwner ?"Compte de " . htmlspecialchars($user->getPseudo()) : "Mon compte" ?> </h1>
    <div id="user-profile-flex-container" class="<?= !$isOwner ? "flex-row" : "" ?>">
        <section id="user-profile-info-section">
            <?php if($isOwner): ?>  
                <?php require("../views/components/infoUserProfile.php")?>
            <?php else: ?>
                <?php require("../views/components/infoPublicProfile.php") ?>
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
                                <img  width="78px" height="78px" src="<?= IMAGES_PATH . 'books/' . htmlspecialchars($book->getImage()) ?>" alt="<?= htmlspecialchars($book->getTitle()) . " de " . htmlspecialchars($book->getAuthor())?>">
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
                                    <a href="?route=/editBook&book_id=<?= htmlspecialchars($book->getId()) ?>&sold_by=<?= htmlspecialchars($book->getSoldBy()) ?>">Éditer</a>
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
            <?php if($isOwner): ?>
                <p class="text-center mt-10 pb-10 add-book"> 
                    <a href="?route=/newBook">Ajouter un livre</a>
                </p>
            <?php endif ?>
        </section>
  
        <section class="hide-tablet" id="user-books-mobile-container">
                <ul aria-label="list des livres">
                    <?php foreach($books as $book):?>
                        <li class="<?= $isOwner ? "book-card-user" : "book-card-public" ?>">
                            <div class="book-info-top">
                                <div class="book-info-top-container">
                                    <picture>
                                       <img  width="79px" height="79px" src="<?= IMAGES_PATH . 'books/' . htmlspecialchars($book->getImage()) ?>" alt="<?= htmlspecialchars($book->getTitle()) . " de " . htmlspecialchars($book->getAuthor())?>">
                                    </picture>
                                    <div class="book-info-top-text">
                                        <span class="book-info-title"> <?= htmlspecialchars($book->getTitle()) ?></span>
                                        <span class="book-info-author"> <?= htmlspecialchars($book->getAuthor()) ?></span>
                                        <div class="book-status <?= $book->getStatus() ? "book-status__green" : "book-status__red"  ?>">
                                            <?= $book->getStatus() ? "disponible" : "non dispo." ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="book-info-bottom">
                                <p><?= htmlspecialchars(substr_replace($book->getDescription(),"...",70)) ?></p>
                            </div>
                        <?php if($isOwner): ?>
                            <div class="book-card-user-btns">
                                <a href="?route=/editBook&book_id=<?= htmlspecialchars($book->getId()) ?>&sold_by=<?= htmlspecialchars($book->getSoldBy()) ?>">Éditer</a>
                                <form class="table-form" method="post">
                                    <input hidden name="route" value="/deleteBook"/>
                                    <input hidden type="text" name="bookId" value="<?= htmlspecialchars($book->getId()) ?>"/>
                                    <input hidden type="text" name="soldBy" value="<?= htmlspecialchars($book->getSoldBy()) ?>"/>
                                    <button class="btn-text" type="submit" name="submit" value="submited">Supprimer</button>
                                </form>
                            </div>
                        <?php endif ?>
                        </li>  
                    <?php endforeach ?>
                </ul>
                  <?php if($isOwner): ?>
                <p class="text-center mt-10 pb-10 addBook"> 
                    <a href="?route=/newBook">Ajouter un livre</a>
                </p>
            <?php endif ?>
        </section>
        
    </div>
</div>