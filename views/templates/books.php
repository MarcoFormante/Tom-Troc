
<div id="books">
     <div id="books-heading-container" class="flex-sb-c">
        <h1>Nos livres à l’échange</h1>
        <form id="search-book" action="index.php?route=/nos-livre-a-lechange" method="POST">
            <label for="search">Rechercher un livre</label>
            <button type="submit"></button>
            <input  type="search" maxlength="60" name="searchValue" id="search" placeholder="Rechercher un livre" value="<?= htmlspecialchars($value ?? "")  ?>"/>
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
    
</div>