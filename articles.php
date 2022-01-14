<?php
require 'config.php'; 
include 'header.php';
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher tous les articles</title>
</head>
<body>
    <?php
    // en fait une requete query (et non preparer) pour selectionner tous les articles ,o n fait une boucle avec une variable article qui va recuperer tous les donné qui ont etais récuperer
    $recupArticles = $bdd->query('SELECT * FROM articles');
    while($article = $recupArticles->fetch()){
        ?>
        <div class="article" style="border: 1px solid black;">
        <!--on affiche les description de l'article et o n spécifie la description et pour bien les article des autre en stylise  -->
            <h1><?= $article['titre']; ?></h1>
            <!-- on va afficheé tous les articles dans déscription -->
            <p><?= $article['description']; ?></p>
            <!-- créer un bouton pour suprimé l'article -->
            <!-- en cr&e une balise <a> pour rediriger le bouton vers suprimeer l'article  et au niveau de l'identifiant je passe en paramettre article ID -->
            <a href="suprimer-article.php.php?id=<?= $article['id'];?>";>
            <button style="color:white; background-color: grey; padding-bottom: 10px;" >Suprimerl'article</button>
            </a>
        </div>
        <br/>
    <?php    
    }
    ?>
</body>
</html>
