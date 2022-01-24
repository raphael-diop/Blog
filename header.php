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
$categories = $result;
$id = $_SESSION['user']['0']['id'];
$login = $_SESSION['user']['0']['login'];
//var_dump($login);

$sql = 'SELECT droits.id FROM `droits` INNER JOIN `utilisateurs` WHERE `nom` ="'.$login.'";';
$query = $bdd->prepare($sql);
$query->execute();
$result = $query->fetch();
$id_droits = $result['id'];
var_dump($id_droits);




            //foreach($categories as $categorie) { echo $categorie['nom'];}
            
        

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
    <li><a href='./index.php'>Accueil</a></li>

    <li><a class='dropdown-arrow' href='./articles.php'>Articles</a>
        <ul class='sub-menus'>
        <li>      <?php foreach($categories as $categorie) {?>
        <a href="articles.php?categorie=<?=$categorie['nom']?>"><?=$categorie['nom']?></a></li>
        <?php }?>
      </ul>
    </li>

    <?php if (empty($_SESSION)) { echo 
    "<li><a href='./inscription.php'>Inscription</a></li>
    <li><a href='./connexion.php'>Connexion</a></li>";}
    else 
         {echo  "<li><a href='./modifier-user.php'>Modification de profil</a></li>";
         echo "<li><a href='.deconnexion.php'>Déconnexion</a></li>";}?>

    <?php if($id_droits == 1337 || $id_droits == 42 ) {
echo "<li><a href='./creer-article.php'>Création d'article</a></li>
<li><a href='./admin.php'>Administration</a></li>";    
} ?>




</nav>
    
</body>


</html>




