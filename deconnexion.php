<?php
    require_once 'config.php';
    $user = new User();
    $user->disconnect();
    header('Location: connexion.php');
?>