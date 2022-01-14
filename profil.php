<?php
require_once 'config.php'; 
include 'header.php';
//si il ya une session de conexion je met le tableau
$email= "email";
$login="login";
$password="password";
if(isset($_SESSION['user'])){
    $user=new User;
    $user->connect($login, $password).'<br/>';
    $user->isConnected();
    $user->getAllInfos();
    $user->getEmail();
    $user->getLogin();
?>
<div id="login">
   <h3 class="tex-center text-white pt-5"> Profil</h3>
<div id="login-row" class="row justify-content-center  align-items-center"> 
<div id="login-column" class="col-md-6">
<div id="login-box" class="col-md-12">
    <table>
        <tr><td>nom d'utilisateur:</td><td><?=$_SESSION['login'] ?> </td></tr>
        <tr><td>Adresse email:</td><td><?=$_SESSION['email'] ?> </td></tr>
    </table>
</div>
</div>
</div>
</div>
<?php
}
?>




