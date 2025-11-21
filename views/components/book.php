<li>
    <a class="book-card" href="?route=/detail&id=<?= htmlspecialchars($book['id']) ?>">
        <div class="book-card-white-container">
            <div class="flex-col-gap-16">
                <img width="200" height="200" src="<?= IMAGES_PATH . htmlspecialchars($book['image']) ?>" alt="<?=  htmlspecialchars($book['title']) ?>">
                <h4 class="book-card-title"><?= htmlspecialchars($book['title']) ?></h4>
                <span class="book-card-author"><?= htmlspecialchars($book['author'])?></span>
            </div>
            <p class="book-card-soldby">Vendu par : <?= htmlspecialchars($book['pseudo'])?></p>
        </div>
    </a>
</li>