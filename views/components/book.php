<li>
    <a class="book-card" href="?route=/detail&id=<?= htmlspecialchars($book->getId()) ?>">
        <div class="book-card-white-container">
            <div class="flex-col-gap-16">
                <img width="200" height="200" src="<?= IMAGES_PATH . 'books/' . htmlspecialchars($book->getImage()) ?>" alt="<?=  htmlspecialchars($book->getTitle()) ?>">
                <h4 class="book-card-title"><?= htmlspecialchars($book->getTitle()) ?></h4>
                <span class="book-card-author"><?= htmlspecialchars($book->getAuthor())?></span>
            </div>
            <p class="book-card-soldby">Vendu par : <?= htmlspecialchars($book->getUser()->getPseudo())?></p>
        </div>
    </a>
</li>