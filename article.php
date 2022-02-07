<?php

require_once 'config.php'; 
include 'header.php';

$user = 'root';
$pass = '';

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);
    $bdd->exec('SET NAMES "UTF8"');

}

catch (PDOException $e)
{
    print "Error: " . $e->getMessage() . "<br/>";
    die();
}

if(!empty($_GET['id_articles']) && isset($_GET['id_articles'])) {
    $id_articles = $_GET['id_articles'];
    $sql = 'SELECT * FROM `articles` WHERE `id`="'.$id_articles.'";';
    $query = $bdd->prepare($sql);
    $query->execute();
    $result = $query->fetch();
    $article = $result;
    //var_dump($result);

    $request = 'SELECT * FROM `articles` INNER JOIN `commentaires` ON articles.id = commentaires.id_article WHERE commentaires.id_article = "'.$id_articles.'" ORDER BY commentaires.date DESC;';
    $calcul = $bdd->prepare($request);
    $calcul->execute();
    $result = $calcul->fetchAll(PDO::FETCH_ASSOC); 
    $coms = $result; 
    //var_dump($result);
}

if (isset($_POST['commentaire']) && strlen($_POST['commentaire']) > 0) {
    $id_articles = $_GET['id_articles'];
    $id_utilisateur = $_SESSION['user']['0']['id'];
    $commentaire = htmlspecialchars($_POST['commentaire']);
    $request = "INSERT INTO `commentaires`( `commentaire`, `id_article`, `id_utilisateur`, `date`) VALUES ( '$commentaire','$id_articles',  '$id_utilisateur', NOW())";
    $calcul = $bdd->prepare($request);
    $calcul->execute();
    $result2 = $calcul->fetchAll(PDO::FETCH_ASSOC);

 }

?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="style.css">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital@0;1&display=swap');
</style>
    <title>Document</title>
</head>
<body>
    <main class="main">

        <article class=rgarticle>

            <div class=articleshadow>    <p class="articledate"><?= $article['date'] ?></p>
                <p><?= $article['article'] ?></p> 
                <a href="#ancre" ><img class="commentaire-icone"
                src="https://www.zupimages.net/up/22/04/tlzm.png"
                alt="Commentaires" ></a>
            </div>

        </article>
                    <?php
            foreach($coms as $com) {
            ?>
            <div class=commentaireshadow>    <p class="commentairedate"><?= $com['date'] ?></p>
                <p class="commentairestyle"><?= $com['commentaire'] ?></p> 
                <a href="#ancre" ><img class="commentaire-icone"
                src="https://www.zupimages.net/up/22/04/tlzm.png"
                alt="Commentaires" ></a>
            </div>

            <?php
            }
            ?>
        

            <div id="ancre">
            <form class="formcom" action="" method="POST">
                                <textarea name="commentaire" cols="120" rows="5" placeholder="Merci d'exprimer votre point de vue dans le respect de la convention de genève"></textarea>
                <input class="bouton1" type="submit" id='submit' name="envoyer" value='Envoyer'>
            </form>
            </div>

    </main>

    </body>

</html>