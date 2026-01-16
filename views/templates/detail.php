
<?php 

$title = htmlspecialchars($book->getTitle());
$bookImage = htmlspecialchars($book->getImage());
$author = htmlspecialchars($book->getAuthor());
$description = htmlspecialchars($book->getDescription());

$user = $book->getUser();
$userId = htmlspecialchars($user->getId());
$profileImage = htmlspecialchars($user->getProfileImage());
$pseudo = htmlspecialchars($user->getPseudo());
$isUserBook = $authenticatedUserId == $userId;

$requestId = Utils::request('id',"")
?>

<div class="breadcrumbs" >
    <a href="?/nos-livre-a-lechange">Nos livres</a> > <?= $title ?>
</div>

<h1 id="book-info-title" class="out-screen">Informations sur le livre</h1>

<article id="book-detail">
    <div id="book-detail-container">
        <figure>
            <img id="book-detail-container-image" src="<?= IMAGES_PATH . 'books/' . $bookImage ?>" alt="<?= $title ?> de <?= $author?> vendu par <?= $pseudo ?>">
        </figure>

        <section id="book-detail-info">
            <h2 class="book-title"><?=$title?></h2>
            <p id="book-detail-info-author-container">par <span id="book-detail-info-author"><?=$author?></span></p>
            <hr>
            <h2>DESCRIPTION</h2>
            <p id="book-detail-info-description"><?= nl2br($description) ?></p>
            <div>
                <h3>PROPRIÉTAIRE</h3>
                <a href="?route=/profile&userId=<?= $userId ?>&redirect=/detail&bookId=<?= htmlspecialchars($requestId) ?>" id="book-detail-info-sold_by">
                    <div id="book-detail-info-sold_by-container">
                        <div class="user-img-container">
                            <img src="<?= IMAGES_PATH . 'users/' . $profileImage ?>" alt="Photo profile de <?= $pseudo ?>">
                        </div>
                        <span id="book-detail-info-sold_by-pseudo"><?= $pseudo ?></span>
                    </div>
                </a>
            </div>
            <?php if(!$isUserBook): ?>
                <div id="book-detail-info-cta">
                    <?php if($_SESSION['auth_token']):?>
                        <a href="?route=/openMessage&other_user_id=<?= $userId ?>&pseudo=<?= $pseudo ?>" class="btn-primary text-center">Envoyer un message</a>
                    <?php else: ?>
                        <a href="?route=/openMessage&other_user_id=<?= $userId ?>&pseudo=<?= $pseudo ?>&redirect=/detail&id=<?= htmlspecialchars($requestId) ?>" class="btn-primary text-center">Envoyer un message</a>
                    <?php endif ?>
                    </div>
            <?php endif ?>
        </section>
    </div>
</article>