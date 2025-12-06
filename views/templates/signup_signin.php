
<?php
$errors =  $_SESSION['form_errors'] ?? [];
$lastInputs = $errors['lastInputs'] ?? [];
?>

<div id="userForm">
    <div id="userForm-container">
        <form class="form-base form-base-col" method="post">
            <h1><?= $title ?></h1>
            <?php if (!$isConnectionPage):?>
                <div class="form-input-container" data-error="<?= isset($errors['pseudo']) ? htmlspecialchars($errors['pseudo']) : "" ?>">
                    <label for="pseudo">Pseudo</label>
                    <input required type="text" name="pseudo" id="pseudo" class="<?= isset($errors['pseudo']) ? "error-input-focus" : "" ?>" value="<?= htmlspecialchars($lastInputs['pseudo'] ?? "")  ?>"/>
                 </div>
            <?php endif ?>


            <div class="form-input-container"  data-error="<?= isset($errors['email']) ? htmlspecialchars($errors['email']) : "" ?>">
                <label for="email">Adresse email</label>
                <input required autocomplete="email" type="email" name="email" id="email" class="<?= isset($errors['email']) ? "error-input-focus" : "" ?>" value="<?= htmlspecialchars($lastInputs['email'] ?? "")  ?>"/>
            </div>
        
            <div class="form-input-container" data-error="<?= isset($errors['password']) ? htmlspecialchars($errors['password']) : "" ?>">
                <label for="password">Mot de passe</label>
                <input required autocomplete="new-password" type="password" name="password" id="password" class="<?= isset($errors['password']) ? "error-input-focus" : "" ?>" value="<?= htmlspecialchars($lastInputs['password'] ?? "")  ?>"/>
            </div>
            
            <input hidden required name="route" value="<?= $isConnectionPage ? "/connection" : "/register" ?>">
            <input hidden  name="csrf" value="<?= $csrf ?>">
            
            <?php if(isset($errors['user-error'])): ?>
                <div class="user-error">
                    <p><?= htmlspecialchars($errors['user-error'])?></p>
                </div>
            <?php endif ?>       

            <button class="btn-primary" name="submited" value="true" type="submit"> <?= $isConnectionPage ? "Entrer" : "S’inscrire" ?></button>

            <p class="switcher-link"><?= $isConnectionPage ? "Pas de compte ? " : "Déjà inscrit ? " ?><a href="index.php?route=/<?= $isConnectionPage ? "register" : "connection" ?>"><?= $isConnectionPage ? "Inscrivez-vous" : " Connectez-vous" ?></a></p>
        </form>
        <div id="userForm-img-container">
            <img src="<?= IMAGES_PATH . "statics/registration_img.webp" ?>" alt="">
        </div>
        
    </div>
    
</div>


<?php 

unset($_SESSION['form_errors']);