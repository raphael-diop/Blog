<?php
require_once 'config.php';

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

$sql = 'SELECT `nom` FROM `categories`';
$query = $bdd->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$categories = $result;c
var_dump($categories);


            foreach($categories as $categorie) { 
                echo $categorie['nom'];
            }
        

?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="navbar.css">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap');
    </style>
</head>
<body>
<nav id='menu'>
  <input type='checkbox' id='responsive-menu'><label></label>
  <ul>
    <li><a href='http://'>Accueil</a></li>
    <li><a href='http://'>Inscription</a></li>
    <li><a href='http://'>Connexion</a></li>
    <li><a class='dropdown-arrow' href='http://'>Articles</a>
      

        <ul class='sub-menus'>
        <li>      <?php foreach($categories as $categorie) {?>
        <a href='http://'><?=$categorie['nom']?></a></li>
        <?php }?>
      </ul>

      
    </li>
    <li><a href='http://'>Modification de profil</a></li>
    <li><a href='http://'>Création d'article</a></li>
    <li><a href='http://'>Administration</a></li>


</nav>
    
</body>


</html>