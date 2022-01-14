<?php 
require_once 'config.php';
session_start();
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
    
        <li><a href="#home">Home</a></li>
        <li><a href="#news">News</a></li>
        <li class="dropdown">
        <a href="#" class="dropbtn">Dropdown</a>
        <div class="dropdown-content">
        <a href="#">Link 1</a>
        <a href="#">Link 2</a>
        <a href="#">Link 3</a>
          </div>
        </li>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="connexion.php">connexion</a></li>
        <li><a href="inscription.php">inscription</a></li>
        <li><a href="article.php">article</a></li>
        <li><a href="articles.php">articles</a></li>
        <li><a href="creer-article.php">créer article</a></li>
        <li><a href="admin.php">admin</a></li>
        <li><a href="profil.php">profil</a></li>


      </ul>
    </nav>
  </header>
