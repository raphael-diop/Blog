<?php
require_once 'config.php'; 
 include 'header.php';
 if (isset($_POST['logout']))
{
  session_destroy();
  header('location:connexion.php');
  $user= new user;
  $user->disconnect();
}
$message = '';
if(isset($_POST['login']) && isset($_POST['password'])){
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);
                $user = new user();
                $user->connect($login, $password);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Connexion</title>
</head>
<body>
<main class="main">
    <?php
    if(isset($_GET['error'])){
        echo'<p id="error">NOUS ne pouvons pas vous authentifier.</p>';
    }
    else if(isset($_GET['success'])){
        echo'<p id="success">Vous etes connecter.</p>';
    }
    ?>
    <form class="formContainer" action="" method="post">
        <h1>CONNEXION</h1>
        <?php echo $message;?>
        <p><input type="text" name="login" class="zonetext" placeholder="Login..."></p>
        <p><input type="password" name="password" class="zonetext"  placeholder="Password ..."></p>
        <p><input type="submit" class="boutonvalidation" name="submit"></p>

    </form>
</main>
</body>
</html>