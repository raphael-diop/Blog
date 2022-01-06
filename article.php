<?php
require_once 'config.php';
var_dump($_SESSION);


$user = new user($_SESSION['user']);
var_dump($user);
/*if($user->isConnected()) {
    echo "Bienvenue, vous avez les autorisations pour publier un article";

    
}
else {
    echo "Vous n'êtes pas censé être ici";
}*/



?>

<body>
        <div>
            <!--<h3 ><?php echo $e; ?></h3>-->

            <form action="" method="POST">
                <h1>Article</h1>
                <textarea name="commentaire" cols="52" rows="5">Chaussette claquette, Casquette survette, raclette et tartiflette, tous les sujets lifestyle qui vous interessent</textarea>

                <input type="submit" id='submit' name="envoyer" value='Envoyer'>
            </form>
        </div>
    </body>