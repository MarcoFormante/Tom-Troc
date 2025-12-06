<?php 

 $errors = $_SESSION["errors"] ?? [];
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
                    <input  hidden name="bookImage" id="bookImage" type="file"  accept="image/jpeg, image/png, image/webp"/>
                    <input required hidden name="lastBookImage" id="lastBookImage" value="<?= htmlspecialchars($book->getImage()) ?>"/>
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
                 <input class="form-input__gray  <?= isset($errors['title']) ? "error-input-focus" : "" ?>"  maxlength="60" required type="text" name="title" id="title" value="<?= htmlspecialchars($book->getTitle()) ?>"/>
            </div>
            <div class="form-input-container" data-error="<?= isset($errors['author']) ? htmlspecialchars($errors['author']) : "" ?>">
                 <label for="author">Auteur</label>
                 <input class="form-input__gray  <?= isset($errors['author']) ? "error-input-focus" : "" ?>"  maxlength="60" required type="text" name="author" id="author" value="<?= htmlspecialchars($book->getAuthor()) ?>"/>
            </div>
            <div class="form-input-container" data-error="<?= isset($errors['desc']) ? htmlspecialchars($errors['desc']) : "" ?>">
                 <label for="desc">Commentaire</label>
                 <textarea class="form-input__gray  <?= isset($errors['desc']) ? "error-input-focus" : "" ?>"  maxlength="850" required name="desc" id="desc" ><?= htmlspecialchars($book->getDescription()) ?></textarea>
            </div>
            <div class="form-input-container" data-error="<?= isset($errors['status']) ? htmlspecialchars($errors['status']) : "" ?>">
                <label for="status">Disponibilité</label>
                <select class="form-input__gray  <?= isset($errors['status']) ? "error-input-focus" : "" ?>"  required name="status" id="status">
                    <option <?=$book->getStatus() == 1 ? "selected" : null ?> value="available">disponible</option>
                    <option <?=$book->getStatus() == 0 ? "selected" : null ?> value="unavailable">non disponible</option>
                </select>           
            </div>   
             <input required hidden name="route" value="/updateBook">
             <input required hidden name="sold_by" value="<?= htmlspecialchars($book->getSoldBy()) ?>">
             <input required hidden name="book_id" value="<?= htmlspecialchars($book->getId()) ?>">
             <input required hidden name="csrfToken" value="<?= htmlspecialchars($csrf) ?>">
             <button class="btn-primary" type="submit" name="isSubmitted" value="true">Valider</button>          
        </div>
           
</form>

</div>


<?php 
unset($_SESSION["errors"]);
?>
