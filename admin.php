<?php
require_once 'config.php'; 
include 'header.php';
// ---------------Afficher les utilisateurs ---------------------------------------//
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

?>
*/


<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="style.css">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="admin.php" method="get">
  <button name="element" type="submit" value="users">Utilisateurs</button>
  <button name="element" type="submit" value="commentaires">Commentaires</button>
  <button name="element" type="submit" value="articles">Articles</button>
  <button name="element" type="submit" value="droits">Droits</button>
  <button name="element" type="submit" value="categories">Catégories</button>
  <button name="element" type="submit" value="moderateurs">Modérateurs</button>
</form>
<?php
$id_droits = $_SESSION['user']['0']['id_droits'];

if(isset($_SESSION) && $id_droits == 1337) {

if(isset($_GET['element']) && $_GET['element'] == 'articles' )
 {
    $sql = 'SELECT *FROM `articles`';
    $query = $bdd->prepare($sql);
    $query->execute();
    $article = $query->fetchAll(PDO::FETCH_ASSOC);
    $titre ="Liste des articles";
    
    ?>
    <body>
    <h1><?php echo $titre ?></h1>
                <table>
                  <thead>
                      <th>id</th>
                      <th>article</th>
                      <th>id_utilisateur</th>
                      <th>id_categorie</th>
                      <th>date</th>
                      <th>nombre de commentaires</th>
                      <th>action</th>
                  </thead>
                  <tbody>
                      <?php
                      foreach($article as $articles){
                      ?>
                      <tr>
                          <td data-label="Date"><?=$articles['id'];
                          $sql = 'SELECT COUNT(*) AS nb FROM `commentaires` WHERE id_article = "'.$articles['id'].'"';

                          $query = $bdd->prepare($sql);
                          $query->execute();
                          $result = $query->fetch();
                          $com_from_art = $result['nb'];
                          ?>        
                        
                        </td>
                          <td data-label="Date"><?=$articles['article'] ?></td>
                          <td data-label="Date"><?=$articles['id_utilisateur'] ?></td>
                          <td data-label="Date"><?=$articles['id_categorie'] ?></td>
                          <td data-label="Date"><?=$articles['date'] ?></td>
                          <td data-label="Date"><?=$com_from_art ?></td>
                          <td> <a href="./admin.php?element=articles&amp;modif=<?= $articles['id']; ?>">modification</a></td> 
                      </tr>

                      <?php
                      }
                      ?>
                      <?php
                      if($_GET['modif'] !== 0 && !empty($_GET['modif'])){
                          $id = $_GET['modif'];
                          //recupération des données users
                          $query = "SELECT *FROM `articles` WHERE id='$id'";
                          $query = $bdd->prepare($query);
                          $query->execute();
                          $recup = $query->fetchAll(PDO::FETCH_ASSOC);

                          //modification des données utilisateurs
                          if(isset($_POST['article']) && $_POST['id_categorie']){
                          $id = $_GET['modif'];
                          $article = htmlspecialchars($_POST['article']);
                          $id_categorie = htmlspecialchars($_POST['id_categorie']);
                          $query = "UPDATE articles SET  `article` = '$article', `id_categorie` = '$id_categorie' WHERE id = $id";
                          $query = $bdd->prepare($query);
                          $query->execute();
                          $modif = $query->fetchAll(PDO::FETCH_ASSOC);
                          var_dump($query);
                          var_dump($modif);
                        }
                        ?>
                          
                           <form method="POST">
                      
                                    <label for="article">Article</label>
                                    <input type="text" id="article" name="article" class="form-control" value="<?=$recup[0]['article'] ?>">
                         
                         
                                    <label for="id_categorie">Categorie</label>
                                    <input type="text" id="id_categorie" name="id_categorie"  class="form-control" value="<?= $recup[0]['id_categorie'] ?>">
                        
                                    <input type="submit" name="modifier" value="Modifier">
                            </form>

                    <?php  
                      }
                    ?>
                      
                      

                      </body>
<?php
    
}
else if(isset($_GET['element']) && $_GET['element'] == 'users') {
    $sql = 'SELECT *FROM `utilisateurs`';
    $query = $bdd->prepare($sql);
    $query->execute();
    $user = $query->fetchAll(PDO::FETCH_ASSOC);
  
    $titre ="Liste des utilisateurs";
    //var_dump($user[0]['login']);
    ?>
    <body>
    <h1><?php echo $titre ?></h1>
                <table>
                  <thead>
                      <th>id</th>
                      <th>login</th>
                      <th>password</th>
                      <th>email</th>
                      <th>nombre de commentaires</th>
                      <th>action</th>

                  </thead>
                  <tbody>
                      <?php
                      foreach($user as $users){
                      ?>
                      <tr>
                          <td data-label="Date"><?=$users['id']; 
                          $sql = 'SELECT COUNT(*) AS nb FROM `commentaires` WHERE commentaires.id_utilisateur = "'.$users['id'].'"';

                          $query = $bdd->prepare($sql);
                          $query->execute();
                          $result = $query->fetch();
                          $art_from_user = $result['nb'];
                          ?>        
    
                          </td>
                          <td data-label="Date"><?=$users['login'] ?></td>
                          <td data-label="Date"><?=$users['password'] ?></td>
                          <td data-label="Date"><?=$users['email'] ?></td>
                          <td data-label="Date"><?=$art_from_user ?></td>
                          <td> <a href="./admin.php?element=users&amp;modif=<?= $users['id']; ?>">modification</a>
                      </tr>


                          <td><?php
                      }
                      ?>

<?php
                      if(isset($_GET['modif']) && !empty($_GET['modif'])){
                          $id = $_GET['modif'];
                          //recupération des données users
                          $query = "SELECT *FROM `utilisateurs` WHERE id='$id'";
                          $query = $bdd->prepare($query);
                          $query->execute();
                          $recup = $query->fetchAll(PDO::FETCH_ASSOC);

                          //modification des données utilisateurs
                          if(isset($_POST['login']) && $_POST['email'] && $_POST['id_droits']){
                          $id = $_GET['modif'];
                          $login = htmlspecialchars($_POST['login']);
                          $email = htmlspecialchars($_POST['email']);
                          $id_droits = htmlspecialchars($_POST['id_droits']);
                          $query = "UPDATE utilisateurs SET  `login` = '$login', `email` = '$email' , `id_droits` = '$id_droits'  WHERE id = $id";
                          $query = $bdd->prepare($query);
                          $query->execute();
                          $modif = $query->fetchAll(PDO::FETCH_ASSOC);
                          var_dump($query);
                          var_dump($modif);
                        }

                        if(isset($_POST['supprimer'])){
                            $query = "DELETE FROM `utilisateurs` WHERE `id`=$id";
                            $query = $bdd->prepare($query);
                            $query->execute();
                        }
                        ?>
                          
                           <form method="POST">
                      
                                    <label for="login">Login</label>
                                    <input type="text" id="login" name="login" class="form-control" value="<?=$recup[0]['login'] ?>">
                         
                         
                                    <label for="email">email</label>
                                    <input type="text" id="email" name="email"  class="form-control" value="<?= $recup[0]['email'] ?>">
                        
                                    <label for="id_droits">id_droits</label>
                                    <input type="text" id="id_droits" name="id_droits"  class="form-control" value="<?= $recup[0]['id_droits'] ?>">
                 
                                    <input type="submit" name="modifier" value="Modifier">
                                    <input  type="submit" name="supprimer" value="supprimer" method="POST"></td> 

                            </form>

                    <?php  
                      }
                    ?>
                      
                      

                      </body>
<?php

}

else if(isset($_GET['element']) && $_GET['element'] == 'moderateurs') {

    $sql = 'SELECT * FROM `utilisateurs` WHERE `id_droits` = 42';
    $query = $bdd->prepare($sql);
    $query->execute();
    $modo = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $titre ="Liste des modérateurs";

    ?>
    <body>
    <h1><?php echo $titre ?></h1>
                <table>
                  <thead>
                      <th>id</th>
                      <th>login</th>
                      <th>password</th>
                      <th>email</th>
                      <th>nombre d'article</th>
                      <th>action</th>
                  </thead>
                  <tbody>
                      <?php
                      foreach($modo as $modos){
                      ?>
                      <tr>
                      <td data-label="Date"><?=$modos['id']; 
                      
                      $sql = 'SELECT COUNT(*) AS nb FROM `articles` WHERE id_utilisateur = "'.$modos['id'].'"';

                          $query = $bdd->prepare($sql);
                          $query->execute();
                          $result = $query->fetch();
                          $art_from_modo = $result['nb'];
                          ?>        </td>

                      <td data-label="Date"><?=$modos['login'] ?></td>
                      <td data-label="Date"><?=$modos['password'] ?></td>
                      <td data-label="Date"><?=$modos['email'] ?></td>
                      <td data-label="Date"><?=$art_from_modo ?></td>
                      <td> <a href="./admin.php?element=moderateurs&amp;modif=<?= $modos['id']; ?>">modification</a></td> 


                      </tr>

                      <?php
                      }
                      ?>

                      <?php
                      if(isset($_GET['modif']) && !empty($_GET['modif'])){
                          $id = $_GET['modif'];
                          //recupération des données users
                          $query = "SELECT *FROM `utilisateurs` WHERE id='$id'";
                          $query = $bdd->prepare($query);
                          $query->execute();
                          $recup = $query->fetchAll(PDO::FETCH_ASSOC);

                          //modification des données utilisateurs
                          if(isset($_POST['login']) && $_POST['email'] && $_POST['id_droits']){
                          $id = $_GET['modif'];
                          $login = htmlspecialchars($_POST['login']);
                          $email = htmlspecialchars($_POST['email']);
                          $id_droits = htmlspecialchars($_POST['id_droits']);
                          $query = "UPDATE utilisateurs SET  `login` = '$login', `email` = '$email' , `id_droits` = '$id_droits'  WHERE id = $id";
                          $query = $bdd->prepare($query);
                          $query->execute();
                          $modif = $query->fetchAll(PDO::FETCH_ASSOC);
                          var_dump($query);
                          var_dump($modif);
                        }

                        if(isset($_POST['supprimer'])){
                            $query = "DELETE FROM `utilisateurs` WHERE `id`=$id";
                            $query = $bdd->prepare($query);
                            $query->execute();
                        }
                        ?>
                          
                           <form method="POST">
                      
                                    <label for="login">Login</label>
                                    <input type="text" id="login" name="login" class="form-control" value="<?=$recup[0]['login'] ?>">
                         
                         
                                    <label for="email">email</label>
                                    <input type="text" id="email" name="email"  class="form-control" value="<?= $recup[0]['email'] ?>">
                        
                                    <label for="id_droits">id_droits</label>
                                    <input type="text" id="id_droits" name="id_droits"  class="form-control" value="<?= $recup[0]['id_droits'] ?>">
                 
                                    <input type="submit" name="modifier" value="Modifier">
                                    <input  type="submit" name="supprimer" value="supprimer" method="POST"></td> 

                            </form>
                            <?php  
                      }
                    ?>

                      </body>
                      
<?php

}
else if(isset($_GET['element']) && $_GET['element'] == 'commentaires') {

    $sql = 'SELECT *FROM `commentaires`';
    $query = $bdd->prepare($sql);
    $query->execute();
    $commentaire = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $titre ="Liste des commentaires";

    ?>
    <body>
    <h1><?php echo $titre ?></h1>
                <table>
                  <thead>
                      <th>id</th>
                      <th>commentaire</th>
                      <th>id_utilisateur</th>
                      <th>id_article</th>
                      <th>date</th>
                      <th>action</th>
                      
                  </thead>
                  <tbody>
                      <?php
                      foreach($commentaire as $commentaires){
                      ?>
                      <tr>
                      <td data-label="Date"><?=$commentaires['id'] ?></td>
                          <td data-label="Date"><?=$commentaires['commentaire'] ?></td>
                          <td data-label="Date"><?=$commentaires['id_utilisateur'] ?></td>
                          <td data-label="Date"><?=$commentaires['id_article'] ?></td>
                          <td data-label="Date"><?=$commentaires['date'] ?></td>
                          <td> <a href="./admin.php?element=commentaires&amp;modif=<?= $commentaires['id']; ?>">modification</a></td> 

                      </tr>

                      <?php
                      }
                      ?>

<?php
                      if(isset($_GET['modif']) && !empty($_GET['modif'])){
                          $id = $_GET['modif'];
                          //recupération des données users
                          $query = "SELECT *FROM `commentaires` WHERE id='$id'";
                          $query = $bdd->prepare($query);
                          $query->execute();
                          $recup = $query->fetchAll(PDO::FETCH_ASSOC);

                          //modification des données utilisateurs
                          if(isset($_POST['commentaire']) && $_POST['id_article']){
                          $id = $_GET['modif'];
                          $commentaire = htmlspecialchars($_POST['commentaire']);
                          $id_article = htmlspecialchars($_POST['id_article']);
                          $query = "UPDATE commentaires SET  `commentaire` = '$commentaire', `id_article` = '$id_article' WHERE id = $id";
                          $query = $bdd->prepare($query);
                          $query->execute();
                          $modif = $query->fetchAll(PDO::FETCH_ASSOC);
                          var_dump($query);
                          var_dump($modif);
                        }
                        if(isset($_POST['supprimer'])){
                            $query = "DELETE FROM `commentaires` WHERE `id`=$id";
                            $query = $bdd->prepare($query);
                            $query->execute();
                        }
                        ?>
                          
                           <form method="POST">
                      
                                    <label for="article">Commentaires</label>
                                    <input type="text" id="commentaire" name="commentaire" class="form-control" value="<?=$recup[0]['commentaire'] ?>">
                         
                         
                                    <label for="id_categorie">Categorie</label>
                                    <input type="text" id="id_article" name="id_article"  class="form-control" value="<?= $recup[0]['id_article'] ?>">
                        
                                    <input type="submit" name="modifier" value="Modifier">
                                    <input  type="submit" name="supprimer" value="supprimer" method="POST"></td> 

                            </form>

                    <?php  
                      }
                    ?>
                      
                      

                      </body>
<?php


}

else if(isset($_GET['element']) && $_GET['element'] == 'categories') {
    $sql = 'SELECT *FROM `categories`';
    $query = $bdd->prepare($sql);
    $query->execute();
    $categorie = $query->fetchAll(PDO::FETCH_ASSOC);
   
    $titre ="Liste des catégories";

    ?>
    <body>
    <h1><?php echo $titre ?></h1>
                <table>
                  <thead>
                      <th>id</th>
                      <th>nom</th>
                      <th>action</th>
 
                  </thead>
                  <tbody>
                      <?php
                      foreach($categorie as $categories){
                      ?>
                      <tr>
                      <td data-label="Date"><?=$categories['id'] ?></td>
                          <td data-label="Date"><?=$categories['nom'] ?></td>
                          <td> <a href="./admin.php?element=categories&amp;modif=<?= $categories['id']; ?>">modification</a></td> 

                      </tr>                      

                      <?php
                      }
                      ?>


                      
<?php


                          //modification des données utilisateurs
                          if(isset($_POST['nom'])){
                          $nom = htmlspecialchars($_POST['nom']);
                          $query = "INSERT INTO `categories`( `nom`) VALUES ( '$nom')";
                          $query = $bdd->prepare($query);
                          $query->execute();
                          $modif = $query->fetchAll(PDO::FETCH_ASSOC);
                          var_dump($query);
                          var_dump($modif);
                        }

                        if(isset($_POST['supprimer'])){
                            $query = 'DELETE FROM `categories` WHERE `nom`= "'.$nom.'"';
                            $query = $bdd->prepare($query);
                            $query->execute();
                        }
                        ?>
                           <form method="POST">
                      
                                    <label for="nom">Catégorie</label>
                                    <input type="text" id="nom" name="nom" class="form-control" value="">
                        
                                    <input type="submit" name="modifier" value="Ajouter">
                                    <input  type="submit" name="supprimer" value="supprimer" method="POST"></td> 

                            </form>

                      </body>
<?php

}
else if(isset($_GET['element']) && $_GET['element'] == 'droits') {
    $sql = 'SELECT *FROM `droits`';
    $query = $bdd->prepare($sql);
    $query->execute();
    $droit = $query->fetchAll(PDO::FETCH_ASSOC);
   
    $titre ="Liste des droits";

    ?>
    <body>
    <h1><?php echo $titre ?></h1>
                <table>
                  <thead>
                      <th>id</th>
                      <th>nom</th>
                      <th>action</th>
 
                  </thead>
                  <tbody>
                      <?php
                      foreach($droit as $droits){
                      ?>
                      <tr>
                      <td data-label="Date"><?=$droits['id'] ?></td>
                          <td data-label="Date"><?=$droits['nom'] ?></td>
                      </tr>

                      <?php
                      }
                      ?>
                      </body>
<?php

}
}

else {
    header("Location:./index.php");
}


?>



</body>
</html>