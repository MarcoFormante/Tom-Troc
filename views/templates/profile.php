
<?php 
    $redirect = Utils::request("redirect","");
    $redirectBookId = Utils::request("bookId","");
    $retourHref = "index.php?route=" . $redirect . "&id=" .$redirectBookId;
?>

<?php if(!$isOwner && ($redirect && $redirectBookId)): ?>
    <a class="retour m-20 block pl-150" href="<?= $retourHref ?>"><- retour</a>
<?php endif ?>

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
                        <th scope="col">PHOTO</th>
                        <th scope="col">TITRE</th>
                        <th scope="col">AUTEUR</th>
                        <th scope="col">DESCRIPTION</th>
                    <?php if($isOwner):?>  
                        <th  scope="col">DISPONIBILITE</th>
                        <th scope="col">ACTION</th>
                    <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($books as $book):?>
                        <tr>
                            <td>
                                <img width="78" height="78" src="<?= IMAGES_PATH . 'books/' . htmlspecialchars($book->getImage()) ?>" alt="<?= htmlspecialchars($book->getTitle()) . " de " . htmlspecialchars($book->getAuthor())?>">
                            </td>
                            <td>
                                <?= htmlspecialchars($book->getTitle()) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($book->getAuthor()) ?>
                            </td>
                            <td>
                                <p><?= htmlspecialchars(substr_replace($book->getDescription(),"...",70)) ?></p>
                            </td>

                            <?php if($isOwner):?>    
                                <td class="w-81 ">
                                    <div class="book-status <?= $book->getStatus() ? "book-status__green" : "book-status__red"  ?>">
                                        <?= $book->getStatus() ? "disponible" : "non dispo." ?>
                                    </div>
                                </td>
                                <td>
                                    <a href="?route=/editBook&book_id=<?= htmlspecialchars($book->getId()) ?>&sold_by=<?= htmlspecialchars($book->getSoldBy()) ?>">Éditer</a>
                                </td>
                                <td class="pl-28    ">
                                   <form class="table-form" method="post">
                                        <input type="hidden"  aria-hidden="true" hidden name="route" value="/deleteBook"/>
                                        <input type="hidden"  aria-hidden="true" hidden type="text" name="bookId" value="<?= htmlspecialchars($book->getId()) ?>"/>
                                        <input type="hidden"  aria-hidden="true" hidden type="text" name="soldBy" value="<?= htmlspecialchars($book->getSoldBy()) ?>"/>
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
                                       <img  width="79" height="79" src="<?= IMAGES_PATH . 'books/' . htmlspecialchars($book->getImage()) ?>" alt="<?= htmlspecialchars($book->getTitle()) . " de " . htmlspecialchars($book->getAuthor())?>">
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
                                    <input type="hidden" aria-hidden="true" hidden name="route" value="/deleteBook"/>
                                    <input type="hidden"  aria-hidden="true" hidden name="bookId" value="<?= htmlspecialchars($book->getId()) ?>"/>
                                    <input type="hidden"  aria-hidden="true" hidden name="soldBy" value="<?= htmlspecialchars($book->getSoldBy()) ?>"/>
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