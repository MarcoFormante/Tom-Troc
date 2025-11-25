
<?php 

$title = htmlspecialchars($book->getTitle());
$bookImage = htmlspecialchars($book->getImage());
$author = htmlspecialchars($book->getAuthor());
$description = htmlspecialchars($book->getDescription());
$profileImage = htmlspecialchars($book->getUser()->getProfileImage());
$pseudo = htmlspecialchars($book->getUser()->getPseudo());

?>

<div class="breadcrumbs" >
    <a href="?/nos-livre-a-lechange">Nos livres</a> > <?= $title ?>
</div>

<article id="book-detail">
    <div id="book-detail-container">
        <figure>
            <img id="book-detail-container-image" src="<?= IMAGES_PATH . $bookImage ?>" alt="<?= $title ?> de <?= $author?> vendu par <?= $pseudo ?>">
        </figure>

        <section id="book-detail-info">
            <h1><?=$title?></h1>
            <p id="book-detail-info-author-container">par <span id="book-detail-info-author"><?=$author?></span></p>
            <hr>
            <h2>DESCRIPTION</h2>
            <p id="book-detail-info-description"><?= nl2br($description) ?></p>
            <div>
                <h3>PROPRIÉTAIRE</h3>
                <div id="book-detail-info-sold_by">
                    <div id="book-detail-info-sold_by-container">
                        <div class="user-img-container">
                            <img src="<?= IMAGES_PATH . 'users/' . $profileImage ?>" alt="Photo profile de <?= $pseudo ?>">
                        </div>
                        <span id="book-detail-info-sold_by-pseudo"><?= $pseudo ?></span>
                    </div>
                </div>
            </div>
            <div id="book-detail-info-cta">
                <a href="?route=/messagerie" class="btn-primary text-center">Envoyer un message</a>
            </div>
        </section>
    </div>
</article>