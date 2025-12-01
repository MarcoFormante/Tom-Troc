<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href=<?=PUBLIC_PATH ."assets/css/main.css"?>>
    <title><?=$title?></title>
</head>
<body>
    <?php include COMPONENTS_PATH . "header.php"?>
    <main class="playfair-display-600">
        <?=$content?>
    </main>
    <?php include COMPONENTS_PATH . "footer.php"?>
    <script src="../public/assets/js/index.js"></script>
</body>
</html>