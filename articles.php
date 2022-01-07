<?php
require_once 'config.php'; 
var_dump($_SESSION);

//connexion
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

if(empty($_GET['categorie'])) {
    if(isset($_GET['page']) && !empty($_GET['page'])){
        $currentPage = (int) strip_tags($_GET['page']);
    }else{
        $currentPage = 1;
    }
    
    $sql = 'SELECT COUNT(*) AS nb_articles FROM `articles`;';
    
    $query = $bdd->prepare($sql);
    $query->execute();
    $result = $query->fetch();
    
    $nbArticles = (int) $result['nb_articles'];
    $parPage = 5;
    //ceil nous permet d'arrondir à l'entier supérieur. Et ainsi avoir tjrs suffisament de pages pour afficher les articles.
    $pages = ceil($nbArticles / $parPage);
    echo $pages;
    //déterminer le premier article qui doit apparaïtre sur chacune des pages
    $premier = ($currentPage * $parPage) - $parPage;
    
    
    // nouvelle requête pour  avoir les articles par 5. En commençant par le $premier article qui doit être sur la page 
    // il faut faire un calcul pour déterminer le premier article : pageactuelle * nombre d'article par page - nombre d'articles par page
    $sql = "SELECT * FROM `articles` ORDER BY `date` DESC LIMIT :premier, :parpage;";
    $query = $bdd->prepare($sql);
    
    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
    $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    
    $query->execute();
    $articles = $query->fetchAll(PDO::FETCH_ASSOC);
    //print_r($articles);
}

if(!empty($_GET['categorie'])) {
    if(isset($_GET['page']) && !empty($_GET['page']) && isset($_GET['categorie']) && !empty($_GET['categorie']) ){
        $currentPage = (int) strip_tags($_GET['page']);
    }else{
        $currentPage = 1;
    }
    $nomcat = $_GET['categorie'];

    $sql = 'SELECT `id` FROM `categories` WHERE `nom`="'.$nomcat.'";';
    $query = $bdd->prepare($sql);
    $query->execute();
    $result = $query->fetch();
    
    $cat_id = $result['id'];

    
    $sql = 'SELECT COUNT(*) AS nb_articles FROM `articles` WHERE `id_categorie`="'.$cat_id.'";';

    $query = $bdd->prepare($sql);
    $query->execute();
    $result = $query->fetch();
    
    $nbArticles = (int) $result['nb_articles'];
    var_dump($nbArticles);
    $parPage = 5;
    $pages = ceil($nbArticles / $parPage);
    echo $pages;
    $premier = ($currentPage * $parPage) - $parPage;
    
    
$sql = "SELECT * FROM `articles` WHERE `id_categorie`= $cat_id ORDER BY `date` DESC LIMIT :premier, :parpage;";
    $query = $bdd->prepare($sql);
    
    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
    $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    
    $query->execute();
    $articles = $query->fetchAll(PDO::FETCH_ASSOC);

    $urlcat = "?categorie=";


    
}












?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="articles_css.css">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <th>ID</th>
            <th>Article</th>
            <th>Date</th>
        </thead>
        <tbody>
            <?php
            foreach($articles as $article) {
            ?>

            <tr>
                <td><?= $article['id'] ?></td>
                <td><?= $article['article'] ?></td>
                <td><?= $article['date'] ?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    

    <nav>
                    <ul>
                        <li class="<?php if($currentPage == '1') {echo "disabled"; } ?>"> 
                            <a href="./articles.php/?page=<?= $currentPage - 1 ?>" > Précédente</a>
                        </li>
                        <?php for($page = 1; $page <= $pages; $page++): ?>
                          <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) https://www.youtube.com/watch?v=dH4xHMFfS6c 28:00-->
                          <li <?= ($currentPage == $page) ? "active" : "" ?>>
                                <a href="./articles.php/<?php if(!empty($_GET['categorie'])) {echo $urlcat; echo $nomcat;}?>?page=<?= $page ?>"><?= $page ?></a>
                            </li>
                        <?php endfor ?>
                          <li class="<?php if($currentPage == $pages) {echo "disabled"; } ?>">
                            <a href="./articles.php/?page=<?php if($currentPage != $pages) { echo $currentPage + 1;} ?>">Suivante</a>
                        </li>
                    </ul>
                </nav>

                <form method="GET">
    <a href="./articles.php/?categorie=life">
        <input type="button" value="life">
    </a>
    <a href="./articles.php/?categorie=street">
        <input type="button" value="street">
    </a>
    <a href="./articles.php/?categorie=jul">
        <input type="button" value="jul">
    </a>
    <a href="./articles.php/?categorie=road">
        <input type="button" value="road">
    </a>
    </form>
    
</body>
</html>