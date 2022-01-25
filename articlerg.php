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
    
var_dump($result);    

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
    <main>
        <article class=rgarticle>

            <div class=articleshadow>    <p class="articledate"><?= $article['date'] ?></p>
                <p><?= $article['article'] ?></p> 
                <a href="./article.php?id_articles=<?= $article['id'] ?>" ><img class="commentaire-icone"
                src="https://www.zupimages.net/up/22/04/tlzm.png"
                alt="Commentaires" ></a>
            </div>
            
        </article>
    </main>

    </body>

</html>