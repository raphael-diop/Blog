<?php
// -------------------read: ------------ lire---------------read------------
require_once 'config.php'; 
include 'header.php';
if (isset($_POST['logout']))
{
  session_destroy();
  header('location:connexion.php');
  $user= new user;
  $user->disconnect();
}
$utilisateurs="";
// est-ce que l'id existe et n'est pas vide dans l'url
if(isset($_GET['id']) && !empty($_GET['id'])){
    require('connect.php');

    // on ettoie id envoyé ;on enleve toute les balise html
    $id=strip_tags($_GET['id']);
    
    $sql = 'SELECT * FROM utilisateurs WHERE `id` = :id';
    // on prepare la requete
    $query =$bdd->prepare($sql);
    // on acroche id avec un bindvalue
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    // on execute la requete
    $query->execute();
    // et on recupere l'utilisateur
    $utilisateurs = $query->fetch();
    // on verifie si l'utilisateur existe
    if(!$utilisateurs){
        $_SESSION['erreur'] = "cet id n'existe pas";
        header('location: index.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <main class="container">
      <div class="row">
          <section class="col-12">
              <h1>Détails utilisateurs <?= $utilisateurs['login']?></h1>
              <p>ID : <?= $utilisateurs['id']?></p>
              <p>login : <?= $utilisateurs['login']?></p>
              <p>email: <?= $utilisateurs['email']?></p>
              <p>password : <?= $utilisateurs['password']?></p>
              <p><a href="index.php">Retour</a> <a href="modifier-user.php">Modifier</a></p>
          </section>
      </div>
  </main>  
</body>
</html>