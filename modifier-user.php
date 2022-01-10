<?php
require 'config.php'; 
// require 'admin-fonction.php';
// include 'admin-fonction.php';
include 'header.php';
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
// en recuper ID qui est recuperer dans url et je verifie si il est pas vide

if(isset($_GET['id']) AND !empty($_GET['id'])){
    echo"coucou3";

   $getid = $_GET['id'];
   $recupUser = $bdd->prepare('SELECT * FROM UTILISATEURS wHERE id = ?');
   $recupUser->execute(array($getid));
   if($recupUser->rowcount()> 0){
       var_dump($recupUser);
   
    
     $userInfo = $recupUser->fetch();
     $login = $userInfo['login'];
     $password = $userInfo['password'];
     $email =$userInfo['email'];
     var_dump($userInfo);
    
    if(isset($_GET['id'])){

       echo"loulou4";
    if($recupUser->rowCount()>0){
        $userInfos = $recupUser->fetch();
        
        if(isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password'])){
        $updateUser = $bdd->prepare('UPDATE `utilisateurs` SET login = $login, password= $password, email= $email WHERE id = 1');
        $recupUser->execute(array($getid));
        $login = $_POST['login'];
        $email = $_POST['email'];
        $password = $_POST['password'];
     
        header('location: membres.php');
        
    //  }else{
    //     var_dump($_GET['id']);
    //     echo "Vous n'avez pas les droits administrateur";
     }
    }
     echo"loulou2";
    }
   }else{
       echo "aucun login trouvé";
   }
 }else{
    echo "aucun login trouvé";
 }

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
        <form action="" method="POST">
        <div class="user" style="border: 1px solid black;"></div>
        <tr>
            <label><td>Non:</td><td><input type="text" name="login" value=""></label></td>
        </tr>
        <tr>
            <td>Email:</td><td><input type="text" name="email" value=""></td>
        </tr>
        <tr>
            <td>Password:</td><td><input type="password" name="password" value=""></td>
        </tr>
        <tr>
            <td> <input type=button  onClick="location.href='modifier-user.php?id='" style ="color:white;background-color: #096b66;" name="modifier" value='modifier'></td>
        </tr>
        </div>
    </table>
      
    <?php
    // }else{
    //     echo "aucun utilisateurs n'est modifier";
    //     }
    ?>
    
    
</body>
</html>
