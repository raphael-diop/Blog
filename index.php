<?php
require_once 'config.php'; 
include 'header.php';
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
$sql = 'SELECT *FROM `utilisateurs`';
// on prepare requete
$query = $bdd->prepare($sql);
// on éxecute la requete
$query->execute();
// on stock les resultats dans un tableau
$result = $query->fetchAll(PDO::FETCH_ASSOC);
// var_dump($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
    <body>
        <main class="container">
            <div class="row">
                <section class="col-12">
                    <?php
                    if(!empty($_SESSION['erreur'])) {
                        echo '<div class="alert alert-danger" role="alert">'. $_SESSION['erreur'].'
                        </div>';
                        $_SESSION['erreur'] = "";
                    }
                    ?>
                    <?php
                    if(!empty($_SESSION['message'])) {
                        echo '<div class="alert alert-success" role="alert">'. $_SESSION['erreur'].'
                        </div>';
                        $_SESSION['erreur'] = "";
                    }
                    ?>
                    <h1>LISTE des utilisateurs</h1>
                <table class="table">
                  <thead>
                      <th>id</th>
                      <th>login</th>
                      <th>password</th>
                      <th>email</th>
                      <th>action</th>
                  </thead>
                  <tbody>
                      <?php
                      foreach($result as $utilisateurs){
                    
                      ?>
                      <tr>
                         
                          <td><?=$utilisateurs['id'] ?></td>
                          <td><?=$utilisateurs['login'] ?></td>
                          <td><?=$utilisateurs['password'] ?></td>
                          <td><?=$utilisateurs['email'] ?></td>
                          <td><a href="details.php?id=<?= $utilisateurs['id'] ?>">Voir </a> <a href="modifier-user.php?id=<?= $utilisateurs['id'] ?>"> Modifier </a> <a href="bannir.php?id=<?= $utilisateurs['id'] ?>"> Suprimer</a></td>
                      </tr>
                      <?php
                      }
                      ?>
                  </tbody>
                </table>
                <a class="button" href="ajouter-utilisateur.php">Ajouter utilisateur</a>
                </section>
            </div>    
        </main>
    </body>

  
</body>
</html>