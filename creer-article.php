<?php 
require_once 'config.php';
include 'header.php';


$user = 'root';
$pass = '';

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);
    $bdd->exec('SET NAMES "UTF8"');

}

catch (PDOException $e)
{
    print "Error: " . $e->getMessage() . "<br/>";
    die();
}
//utiliser classe getAllInfos pour récup Id user


$id = $_SESSION['user']['0']['id'];
$login = $_SESSION['user']['0']['login'];


$sql = 'SELECT droits.id FROM `droits` INNER JOIN `utilisateurs` WHERE `nom` ="'.$login.'";';
$query = $bdd->prepare($sql);
$query->execute();
$result = $query->fetch();
$id_droits = $result['id'];
var_dump($id_droits);


if(isset($_SESSION) && $id_droits == 1337 || $id_droits == 42 ) {
    if(isset($_POST['envoyer']) && isset($_POST['titre']) && isset($_POST['article']) && isset($_POST['categorie'])) {
        echo "Merci pour votre contibution";
        $id_categorie = $_POST['categorie'];
        echo $id_categorie;
        $titre = $_POST['titre'];
        $article = $_POST['article'];
        $request = "INSERT INTO `articles`( `article`, `id_utilisateur`, `id_categorie`, `date`) VALUES ( '$article','$id',  '$id_categorie', NOW())";
        $calcul = $bdd->prepare($request);
        $calcul->execute();
        $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}
else {
    header("Location:./articles.php");
}

?>

<body>
        <div>
             

            <form action="" method="POST">
               

                <h1>
                Article
                 </h1>


                 <textarea maxlength="2000" name="titre" cols="20" rows="1">Titre</textarea>

                <h1>
                </h1>
                <textarea name="article" cols="52" rows="5">Créez votre article</textarea>

                <input type="submit" id='submit' name="envoyer" value='Envoyer'>
                <h1></h1>
                
                <select name="categorie">
                    <option value="">choisissez une catégorie</option>
                    <option value="1">Life Style</option>
                    <option value="2">Street Wear</option>
                    <option value="3">Jul</option>
                    <option value="4">Road Style</option>
                </select>
            </form>
        </div>
    </body>
