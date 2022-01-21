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
        <!-- <div class="imageFond">
            <img src="https://zupimages.net/up/22/03/69cq.jpg" alt="image tatane">
        </div> -->
            <div class="containerPresentation">
                <div class="articles">
                    <h1>ARTICLES:</h1>
                    <?php foreach($art as $i){ 
                        echo '<div class="article">' .$i['article']. '</div>';
                    } ?>
                    <a class="article" href="articles.php">LIENS VERS LES ARTICLES</a>
                </div>
                <!-- <div class="textPresentation">
                    <p>
                       Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi praesentium animi maiores vero earum eos voluptatum pariatur officiis aliquid, sit fuga. 
                       Consequatur error reiciendis expedita architecto in vitae ab eos.
                    </p>
                </div> -->
            </div>
            <div class="containerSponsor">
                <h1>NOS SPONSORS:</h1>
                <div class="sponsors">
                        <img src="https://static1.pureshopping.com/brands//5/89/35/@/8935-logo-5697da9ad52fd-290x180-1.png" alt="rivaldi">
                        <img src="https://static.mensup.fr/photo_article/447039/175195/1200-L-amsterdam-maximator-la-plus-puissante-des-bires-de-caractre.jpg" alt="maximator">
                        <img src="https://m.media-amazon.com/images/I/81UgbDnYARL._AC_SL1500_.jpg" alt="scorpio">
                </div>
            </div>
    </main>
    <footer>
        <?php require 'footer.php'; ?> 
    </footer>
    

</body>