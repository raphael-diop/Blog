<?php
require_once 'config.php'; 
include 'header.php';
// ---------------Afficher les utilisateurs ---------------------------------------//
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
                <table>
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
                          <td data-label="Date"><?=$utilisateurs['id'] ?></td>
                          <td data-label="Date"><?=$utilisateurs['login'] ?></td>
                          <td data-label="Date"><?=$utilisateurs['password'] ?></td>
                          <td data-label="Date"><?=$utilisateurs['email'] ?></td>
                          <td><a href="details/admin1.php?id=<?= $utilisateurs['id'] ?>">Voir </a> <a href="modifier-user.php?id=<?= $utilisateurs['id'] ?>"> Modifier </a> <a href="bannir.php?id=<?= $utilisateurs['id'] ?>"> Suprimer</a></td>
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
<?php
// ---------cette page à 2 roles afficher le formulaire et de traiter le formulaire

$id_droits="";
$password_retype="";
if(isset($_POST)){
    if(isset($_POST['login']) && !empty($_POST['login'])
    && isset($_POST['email']) && !empty($_POST['email'])
    && isset($_POST['password']) && !empty($_POST['password'])
    && isset($_POST['id_droits']) && !empty($_POST['id_droits'])){
       var_dump($_POST);
        // on ettoie les donées envoyé ;on enleve toute les balise html
       $login = strip_tags($_POST['login']);
       $email = strip_tags($_POST['email']);
       $password=strip_tags($_POST['password']);
       $id_droits=strip_tags($_POST['id_droits']);
       
      $password=password_hash($password, PASSWORD_BCRYPT);
      //    on insert l'utilisateur
      $sql = 'INSERT INTO `utilisateurs` (`login`, `password`, `email`,`id_droits`) VALUES (:login, :password, :email, :id_droits = 1);';
      $query = $bdd->prepare($sql);

      $query->bindValue(':login', $login, PDO::PARAM_STR);
      $query->bindValue(':password', $password, PDO::PARAM_INT);
      $query->bindValue(':email', $email, PDO::PARAM_STR);
      $query->bindValue(':id_droits',$id_droits, PDO::PARAM_INT);
      
      $query->execute();
      
      $_session['message'] = "utilisateurs ajouter";

   //    Header('location: index.php');



    }else{
        $_SESSION['erreur'] = "le formulaire est incomplet";
    }
   }   
   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Ajouter utilisateurs</title>
    <body>
        <main class="container">
            <div class="row">
                <section class="col-12">
                    <h1>Ajouter utilisateurs</h1>
                    <?php
                    if(!empty($_SESSION['erreur'])) {
                        echo '<div class="alert alert-danger" role="alert">'. $_SESSION['erreur'].'
                        </div>';
                        $_SESSION['erreur'] = "";
                    }
                    ?>
                    <form method="POST">
                        <div class="form-group">
                         <label for="login">Login</label>
                         <input type="text" id="login" name="login" class="form-control">
                        </div>
                        <div class="form-group">
                         <label for="email">email</label>
                         <input type="text" id="email" name="email"  class="form-control">
                        </div>
                        <div class="form-group">
                         <label for="password">password</label>
                         <input type="password" id="password" name="password"  class="form-control">
                        </div>
                        <div class="form-group">
                         <label for="password_retype">password_retype</label>
                         <input type="password" id="$password_retype" name="$password_retype"  class="form-control">
                        </div>
                        <div class="form-group">
                         <label for="id_droits">id_droits</label>
                         <input type="text" id="id_droits" name="id_droits"  class="form-control">
                        </div>
                        <button class="btn btn-primary">Envoyer</button>
                    </form>
                </section>
            </div>    
        </main>
    </body>

  
</body>
</html>