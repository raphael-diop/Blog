<?php

// ---------cette page à 2 roles afficher le formulaire et de traiter le formulaire
require_once 'config.php'; 
include 'header.php';
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
$id_droits="";
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
       
       $_SESSION['message'] = "utilisateurs ajouter";

       Header('location: index.php');
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