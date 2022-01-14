<?php
// ------------------------------- modifier utilisateur---------------------------
require_once 'config.php'; 
include 'header.php';
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
if (isset($_POST['logout']))
{
  session_destroy();
  header('location:connexion.php');
  $user= new user;
  $user->disconnect();
}
// $_SESSION['user']['id'] = ;
var_dump($_GET['id']);

if(isset($_POST['envoyer'])){
     if(isset($_POST['login']) && !empty($_POST['login'])
    && isset($_POST['email']) && !empty($_POST['email'])
    && isset($_POST['id_droits']) && !empty($_POST['id_droits'])){
    
        // on ettoie les donées envoyé ;on enleve toute les balise html
       $id = $_GET['id'];
    //    $id = strip_tags($_POST['id']);
       $login = strip_tags($_POST['login']);
       $email = strip_tags($_POST['email']);
       $id_droits=strip_tags($_POST['id_droits']);

       //    on insert l'utilisateur
       $sql = 'UPDATE `utilisateurs` SET `login`=:login , `email`=:email ,`id_droits`=:id_droits WHERE `id`=:id;';
       $query = $bdd->prepare($sql);

       

       $query->bindValue(':id', $id, PDO::PARAM_INT);
       $query->bindValue(':login', $login, PDO::PARAM_STR);
       $query->bindValue(':email', $email, PDO::PARAM_STR);
       $query->bindValue(':id_droits',$id_droits, PDO::PARAM_INT);
       $query->execute();
      
        }else{
            $_SESSION['erreur'] = "le formulaire est incomplet";
            }
           
    // est-ce que l'id existe et n'est pas vide dans l'url
    if(isset($_GET['id']) && !empty($_GET['id'])){

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
                var_dump($_SESSION);
            }
    }else{
        $_SESSION['erreur'] = "URL invalide";
        header('location: index.php');

        }
    } 

    $id= $_GET['id'];
    $sql = "SELECT *FROM `utilisateurs` WHERE id='$id'";
    // on prepare requete
    $query = $bdd->prepare($sql);
    // on éxecute la requete
    $query->execute();
    // on stock les resultats dans un tableau
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier utilisateur</title>
   
</head>
<body>
<main class="container">
            <div class="row">
                <section class="col-12">
                    <h1>Modifier utilisateurs</h1>
                    <?php
                      foreach($result as $utilisateurs){
                    
                      ?>
                    <form method="POST">
                        <div class="form-group">
                         <label for="login">Login</label>
                         <input type="text" id="login" name="login" class="form-control" value="<?=$utilisateurs['login'] ?>">
                        </div>
                        <div class="form-group">
                         <label for="email">email</label>
                         <input type="text" id="email" name="email"  class="form-control" value="<?= $utilisateurs['email'] ?>">
                        </div>
                        <div class="form-group">
                         <label for="id_droits">id_droits</label>
                         <input type="text" id="id_droits" name="id_droits"  class="form-control" value="<?= $utilisateurs['id_droits'] ?>">
                        </div>
                        <div class="form-group">
                         <input type="hidden" value="<?= $utilisateurs['id']?>" name="id">
                        </div>
                        <?php }?>
                        <input type="submit" name="envoyer" value="Envoyer">
                        <p><a href="index.php" class="btn btn-primary" >Retour</a> </p>
                    </form>
                </section>
            </div>    
        </main>
    </body>

  
</body>
</html>