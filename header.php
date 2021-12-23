
<?php

$errormess = '';?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="perdu" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>Document</title>
</head>

<header>
    <nav class=nav>
      <ul>
          <li><a href="index.php">Accueil</a></li>
        <?php
          if(!isset($_SESSION['user'])){
            echo ('<li><a href="inscription.php">Inscription</a></li>');
          }else{ echo "" ; }?>
        <?php
          if(!isset($_SESSION['user'])){
            echo ('<li><a href="connexion.php">Connexion</a></li>');
          }else{ echo "" ; }?>  
        <?php
          if (isset($_SESSION['user']) || isset($_SESSION['admin'])){
            echo ('<li><a href="">Déonnexion</a></li>'); 
            $user = new user();
            $user->disconnect();}?>
          <li class="dropdown">
          <a href="#" class="dropbtn">Menu</a>
          <div class="dropdown-content">
          <a href="article.php">Article</a>
          <a href="articles.php">Articles</a>
          <a href="creer-article.php">Créer article</a>
        <?php  
          if (isset($_SESSION['admin'])) {
            echo(' <a href="admin.php">Admin</a>');           
          }
        ?>
          <a href="profil.php">profil</a>
        </div>
       </li>
      </ul>
    </nav>
  </header>

  