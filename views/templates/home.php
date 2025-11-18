
<div>
    <h1>Test Home Page</h1>
</div>

<ul>
    <?php foreach($books as $book):?>  
    <li>
        <figure>
            <img src="<?= $book['image'] ?>" alt="<?= $book['title'] ?>, de <?= $book['name'] ?>, vendu par <?= $book['pseudo'] ?>">
        </figure>
        <p><?=$book['title']?></p>
    </li>
   <?php endforeach; ?>
</ul>
