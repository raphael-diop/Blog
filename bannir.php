<?php

include 'header.php';
require 'config.php'; 

$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
$id = "";
if(!isset($_SESSION['admin'])){
        header('location: index.php');
    }
// je recupére identifiant qui a étais rentrer en paramétre dans l'url, en crée une condition pour vérifier si ID a bien etais recuperer
// en crée une méthode get parce que on transfaire les donées par l'url et pouvoir excuter du code sinon en met une erreur l'identifiant n'a pas etais récuperer
if(isset($_GET['id']) AND !empty($_GET['id'])){
    // je crée la variable get id qui va recuperer le GET['id]
      $getid = $_GET['id'];
      $recupUser = $bdd->prepare('SELECT id_droits FROM utilisateurs WHERE id = ?');
      $recupUser->execute(array($getid));
      var_dump($_GET['id']);
    //   si recupUser n'est pas vide rowcount superieur à 0 en va executer le code
      if($recupUser->rowCount()>0){
        //   on crée le sisteme pour bannir l'utilisateur
        // on recupere tous les donéé qui existe pour donée l'autorisation de suprimé ou de modifier
        $userInfos = $recupUser->fetch();
        // si id droits est declarée
        if($userInfos['id_droits'] == $_SESSION['admin'] ){
        //  je créer une requete pour delete utilisateur
        $bannirUser = $bdd->prepare('DELETE FROM utilisateurs WHERE id = ?');
        // on execute cette requete bannirUser execute ptableau array et en paramtre en met $getid et rediriger l'utilisayeur vers notre page de membre
        $bannirUser->execute(array($getid));
         header('location: details.php');
        }else{
            var_dump($_GET['id']);
            echo "Vous n'avez pas les droits administrateur";
        }
}
}else{
    
    echo "L'identifiant n'a pas etais récuperer";
}
?>