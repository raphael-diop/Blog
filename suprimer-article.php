<?php
require 'config.php'; 
include 'header.php';
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
// il faut verifier pour voir si l'identifiant et entré dans l'url en parametre por cela en fait un if isset $_get car la methode get c'est pour les données passé dans url   
// et en verifie si le id n'est pas vide si aucune ID  ou identifitian en echo message
if(isset($_GET['id']) AND !empty($_GET['id'])){
    // on stock cette id dans une nouvelle variable qu'on appele $getid
    $getid = $_GET['id'];
    // ensuite en verifie dans la base de donnée si un article posséde bien l'identifiant qui est entrer en parametre
    $recupArticle = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $recupArticle->execute((array($getid)));//on l'execute et on rentre en paramettre $getid car ici en selection l'article qui corespond a l'identifiant dans les paramettre
    // si cette article existe, si on a trouver plus de zero article c'est d'executer le code
    if($recupArticle->rowCount()>0){
        // en suite en effectue la requete pour delete l'article
        $deleteArticle = $bdd->prepare('DELETE FROM articles where id = ?');
        

    }else{
        echo "Aucun article trouvé";
    }
}else{
    echo "Aucun identifiant trouvé";
}






?>