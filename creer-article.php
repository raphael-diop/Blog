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


if(isset($_SESSION) && $id_droits == 1337 || $id_droits == 42 && strlen($article) <= 30000) {
    if(isset($_POST['envoyer']) && isset($_POST['article']) && isset($_POST['categorie'])) {
        echo "Merci pour votre contibution";
        $id_categorie = $_POST['categorie'];
        echo $id_categorie;
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

                <h1>
                </h1>
                <textarea name="article" cols="52" rows="5" maxlength="30000" >Créez votre article</textarea>

                <input type="submit" id='submit' name="envoyer" value='Envoyer'>
                <h1></h1>
                <?php $sql = 'SELECT `nom`, `id`  FROM `categories`';
$query = $bdd->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$categories = $result; 
?>
                
                <select name="categorie">
                <?php foreach($categories as $categorie) {?>
                    <option value="<?=$categorie['id']?>"><?=$categorie['nom']?></option>
                    <?php }?>
                </select>
            </form>
        </div>
    </body>
