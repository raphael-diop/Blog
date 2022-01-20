<?php
    require 'config.php';
    $article = new article();
    $art = $article->recuperationArticles();
    //requete pour récupérer les 3 premier articles et les commentaires
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
</head>
<body>
    <header>
        <?php require 'header.php'; ?>
    </header>
    <main>
        <div class='slider'>
            <img class='active' src="https://zupimages.net/up/22/03/9b3q.jpg" alt="jul" />
            <img src="https://www.reead.com/fr/wp-content/uploads/2019/09/claquettes-chaussettes-off-white.webp" alt="claquette chaussette" />
            <img src="https://static.lexpress.fr/medias_11182/w_1000,h_563,c_fill,g_north/v1476370079/lopez-du-63_5725391.jpg" alt="Lopez" />
            <img src="https://i.ytimg.com/vi/4vtAcnxJDAk/maxresdefault.jpg" alt="Scooter" />
            <div class="container-btn">
                <div class="btn-nav left">◄</div>
                <div class="btn-nav right">►</div>
                <script src="app.js"></script>
            </div>
        </div>
            <div class="articles">
                <?php foreach($art as $i){ 
                    echo '<div class="article">' .$i['article']. '</div>';
                } ?>
            </div>
    </main>
    

</body>