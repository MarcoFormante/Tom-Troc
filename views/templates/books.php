
<div id="books">
     <div id="books-heading-container" class="flex-sb-c">
        <h1>Nos livres à l’échange</h1>
            <form id="search-book" action="index.php?route=/nos-livre-a-lechange" method="POST">
                <label for="search">Rechercher un livre</label>
                <button type="submit" aria-label="Rechercher"></button>
                <input  type="search" maxlength="60" name="searchValue" id="search" placeholder="Rechercher un livre" value="<?= html_entity_decode(htmlspecialchars($value ?? ""), ENT_QUOTES | ENT_HTML5, 'UTF-8')  ?>"/>
            </form>
     </div>

    <?php if(isset($error)): ?>
        <div>
            <p class="error-text"><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif?>
     
     <?php if(!empty($books)): ?>
        <ul class="book-list-container">
            <?php foreach ($books as $book){ ?>
                <?php include COMPONENTS_PATH . "book.php"?>
            <?php } ?>
        </ul>
      
    <?php endif?>
        <?php if(empty($books) && !isset($error)): ?>
            <div><p class="text-lg line-h-20">Il n’y a pas encore de livres. <br/> Inscrivez-vous et créez votre bibliothèque.</p></div>
        <?php endif?>
</div>