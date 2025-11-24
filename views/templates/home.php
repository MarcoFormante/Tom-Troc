
<section id="home-hero" class="bg__light-gray">
    <div id="home-hero-container" class="flex-c-c">
        <div id="hero-left-container">
            <div class="flex-c-c-col" id="hero-left-text-container">
                <h1 class="t-black playfair-display-400 align-self-start">Rejoignez nos <br/> lecteurs passionnés</h1>
                <p class="t-black inter-300">Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres. </p>
            </div>
            <div class="btn-container align-self-start" >
                <a role="button" href="?route=/nos-livre-a-lechange" class="btn-primary">Découvrir</a>
            </div>
        </div>

        <div id="hero-right-container">
            <figure>
                <img width="404" height="539" src="<?= IMAGES_PATH . "statics/hero_img.webp"  ?>" alt="Hamza">
                <figcaption class="inter-italic-400">Hamza</figcaption>
            </figure>
        </div>
    </div>
</section> 

<section id="home-last-books">
    <h2>Les derniers livres ajoutés</h2>

    <ul class="book-list-container">
        <?php foreach ($books as $book){ ?>
            <?php include COMPONENTS_PATH . "book.php"?>
        <?php }  ?>
    </ul>

    <div class="btn-container">
        <a role="button" href="?route=/nos-livre-a-lechange" class="btn-primary">Voir tous les livres</a>
    </div>
</section>

<section id="home-how-it-works" class="bg__light-gray">
    <h2>Comment ça marche ?</h2>

    <p class="paragraphe">Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</p>

    <ul id="home-how-it-works-list">
        <li>
            <p>Inscrivez-vous gratuitement sur notre plateforme.</p>
        </li>
        <li>
            <p>Ajoutez les livres que vous souhaitez échanger à votre profil.</p>
        </li>
        <li>
            <p>Parcourez les livres disponibles chez d'autres membres.</p>
        </li>
        <li>
            <p>Proposez un échange et discutez avec d'autres passionnés de lecture.</p>
        </li>
    </ul>

    <div class="btn-container">
        <a role="button" href="?route=/nos-livre-a-lechange" class="btn-secondary">Voir tous les livres</a>
    </div>
</section>
<img src="<?= IMAGES_PATH . "statics/home_biblio_img.webp" ?>" width="100%" alt="">

<section id="home-values" class="bg__light-gray">
    <div id="home-values-container">
        <div id="home-values-desc">
            <h2>Nos valeurs</h3> 
            <p class="paragraphe">
                Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. 
                Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. 
                Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.
            </p> 

            <br/> 
            <br/>

            <p class="paragraphe">Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé. </p>

            <br/> 
            <br/>

            <p class="paragraphe">
                Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, 
                de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.
            </p>
        </div>

        <div id="home-values-salutations-container">
            <p id="home-values-salutations-text">L’équipe Tom Troc</p>
            <svg id="heart-img" role="img" aria-hidden="true" width="122" height="104" viewBox="0 0 122 104" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 96.2239C2.29696 95.8231 6.2879 96.4857 7.64535 96.4799C34.2391 96.3671 77.2911 74.6938 96.4064 56.0077C109.127 40.7678 119.928 7.80676 85.8057 2.24498C65.0283 -1.14163 50.1873 26.798 62.0601 33.1479C66.0177 35.2646 78.258 25.6127 65.0283 12.4049C51.7986 -0.802991 39.7279 0.128338 35.3463 2.24498C15.417 7.74826 2.27208 42.7152 71.8127 87.7573C96.4064 103.687 121 102.997 121 102.997" stroke="#00AC66" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
    </div>
</section>