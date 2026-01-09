<?php 

 $errors = $_SESSION["errors"] ?? [];
 $lastInputs = $errors['lastInputs'] ?? [];

 $isNewBook = $book->getId() == -1;

?>


<div id="editBook">
    <a class="retour" href="?route=/mon-compte"><- retour</a>

    <h1>Modifier les informations</h1>

    <form id="form-editBook"  method="post" enctype="multipart/form-data">
        <div id="form-editBook-left-container">
            <div>
                <label for="bookImage">Photo</label>
                <div id="book-image-container">
                    <img  id="book-image" src="<?= IMAGES_PATH . "books/" . htmlspecialchars($book->getImage()) ?>" alt="Photo livre '<?= htmlspecialchars($book->getTitle()) ?>'">
                    <label for="bookImage" class="text-right">Modifier la photo</label>
                    <input aria-hidden="true" hidden name="bookImage" id="bookImage" type="file"  accept="image/jpeg, image/png, image/webp"/>
                    <input aria-hidden="true" type="hidden" required hidden name="lastBookImage" id="lastBookImage" value="<?= htmlspecialchars($book->getImage()) ?>"/>
                </div>
                <?php if (isset($errors['image']) && !empty($errors['image'])):?>
                    <ul class="error-list-container">
                        <?php foreach ($errors['image'] as $error):?>
                            <li class="error-list-item"><?= htmlspecialchars($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </div>
        </div>

        <div class="form-editBook-right-container">
            <div class="form-input-container" data-error="<?= isset($errors['title']) ? htmlspecialchars($errors['title']) : "" ?>">
                 <label for="title">Titre</label>
                 <input class="form-input__gray  <?= isset($errors['title']) ? "error-input-focus" : "" ?>"  maxlength="60" required type="text" name="title" id="title" value="<?= htmlspecialchars($lastInputs['title'] ?? $book->getTitle()) ?>"/>
            </div>
            <div class="form-input-container" data-error="<?= isset($errors['author']) ? htmlspecialchars($errors['author']) : "" ?>">
                 <label for="author">Auteur</label>
                 <input class="form-input__gray  <?= isset($errors['author']) ? "error-input-focus" : "" ?>"  maxlength="60" required type="text" name="author" id="author" value="<?= htmlspecialchars($lastInputs['author'] ?? $book->getAuthor()) ?>"/>
            </div>
            <div class="form-input-container" data-error="<?= isset($errors['desc']) ? htmlspecialchars($errors['desc']) : "" ?>">
                 <label for="desc">Commentaire</label>
                 <textarea class="form-input__gray  <?= isset($errors['desc']) ? "error-input-focus" : "" ?>"  maxlength="850" required name="desc" id="desc" ><?= htmlspecialchars( $lastInputs['desc'] ??  $book->getDescription()) ?></textarea>
            </div>
            <div class="form-input-container" data-error="<?= isset($errors['status']) ? htmlspecialchars($errors['status']) : "" ?>">
                <label for="status">Disponibilité</label>
                <select class="form-input__gray  <?= isset($errors['status']) ? "error-input-focus" : "" ?>"  required name="status" id="status">
                    <option <?=$book->getStatus() == 1 ? "selected" : null ?> value="available">disponible</option>
                    <option <?=$book->getStatus() == 0 ? "selected" : null ?> value="unavailable">non disponible</option>
                </select>           
            </div>   
             <input type="hidden" aria-hidden="true"  required hidden name="route" value="<?= $isNewBook ? "/createBook" : "/updateBook" ?>">
             <input type="hidden" aria-hidden="true"  required hidden name="sold_by" value="<?= htmlspecialchars($book->getSoldBy()) ?>">
             <input type="hidden" aria-hidden="true"  required hidden name="book_id" value="<?= htmlspecialchars($book->getId()) ?>">
             <input type="hidden" aria-hidden="true"  required hidden name="csrfToken" value="<?= htmlspecialchars($csrf) ?>">
             <button class="btn-primary" type="submit" name="isSubmitted" value="true">Valider</button>          
        </div>
           
</form>

</div>


<?php 
unset($_SESSION["errors"]);
?>
