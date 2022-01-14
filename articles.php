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

//je commence par récupérer les articles par catégorie, mais le if et le else me semble interchangeable, la condition consiste à demander si l'url prend cette forme : article.php?categorie=quelquechose c'est la syntaxe pour généré un tableau association dans get il me semble.
if(!empty($_GET['categorie']) && isset($_GET['categorie'])) {
    //la deuxième info injecté dans l'url (donc dans $get) peut être la page sur laquelle l'user se trouve. ici je détermine : si je suis sur une page et laquelle c'est, en forçant la récupération d'un entier avec (int)
    if(isset($_GET['page']) && !empty($_GET['page'])){
        $currentPage = (int) strip_tags($_GET['page']);
    // mais si aucune page n'est selectionné en url la page actuelle est la première
    }else{
        $currentPage = 1;
    }
//je suis dans mon if de categorie, je peux donc charger en variable le nom de cette catégorie en demandant à récupérer la valeur de catégorie. IMPORTANT : articles.php?categorie=machinmachin voila comment est généré le tableau associatif de get.
    $nomcat = $_GET['categorie'];
//je commence la récupèration des articles que l'user à demander à voir en selectionnant une catégorie, j'ai besoin d'obtenir les id des articles correspondant et j'utilise ce qui a été renseigné en url(donc dans get) et chargé dans la variable $nomcat pour récup l'id des articles qui m'interessent.
    $sql = 'SELECT `id` FROM `categories` WHERE `nom`="'.$nomcat.'";';
    $query = $bdd->prepare($sql);
    $query->execute();
    $result = $query->fetch();
    
    $cat_id = $result['id'];

//maintenant que j'ai mes id je dois les compter pour la pagination qui nécessite le nombre total d'article entre autres.    
    $sql = 'SELECT COUNT(*) AS nb_articles FROM `articles` WHERE `id_categorie`="'.$cat_id.'";';

    $query = $bdd->prepare($sql);
    $query->execute();
    $result = $query->fetch();
//je charge le nombre total d'article en variable    
    $nbArticles = (int) $result['nb_articles'];
    var_dump($nbArticles);
//je détermine le nombre d'article par page:5 et demande un entier en utilisant ceil(qui force la réception d'un entier) pour avoir le bon nombre de page (si 6 articles avec 5 articles par page, je dois avoir deux pages, pas 1,1)
    $parPage = 5;
//par division de mon nombre d'article et du nombre d'article par page j'obtient l'entier correspondant au nombre de pageS total
    $pages = ceil($nbArticles / $parPage);
    //echo $pages;
//vous croyez qu'on peut se détendre ? ET NON c'est l'enfer du cul ce code. Maintenant qu'on peut indiquer la page sur laquelle l'user se trouve, le nombre d'article par page il faut utiliser la commande sql DESC LIMIT pour récupérer les articles par tranche de 5, en commençant l'article qu'on veut avec la variable $premier ce calcul est moins intuitif que les autres, pour le comprendre il faut le poser et tester.
    $premier = ($currentPage * $parPage) - $parPage;
    
    
$sql = "SELECT * FROM `articles` WHERE `id_categorie`= $cat_id ORDER BY `date` DESC LIMIT :premier, :parpage;";
print_r($cat_id);
    $query = $bdd->prepare($sql);
    
    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
    $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    
    $query->execute();
    $articles = $query->fetchAll(PDO::FETCH_ASSOC);
    //print_r($premier);

    $getajout = "&amp;";

    
}
// même chose mais avec tous les articles sans les déterminer par ce qui est renseigné en get
else {
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
    //echo $pages;
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
    print_r($premier);

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
    <ul>                 <!-- dans cette boucle et cette pagination j'utilise l'appel d'un css par une condition php pour désactiver le bouton suivant et précédent
                        avec l'echo disabled, j'utilise aussi des condition pour générer mon url qui devra prendre la forme suivante : articles.php?page=1 si aucune catégorie n'est selectionné
                        et la forme suivante articles.php?categorie=jul&amp;page=1 si une catégorie est selectionné, si il y a deux infos dans get on utilise &amp; pour les mettre à la suite
                        le echo : "?" me permet d'afficher ce foutu point d'interrogation de l'enfer du cul qui ne doit être présent avant "page=" QUE si il n'y a pas de catégorie selectionné car il ne doit être présent qu'une fois dans l'url après articles.php-->
                        <li class="<?php if($currentPage == '1') {echo "disabled"; } ?>"> 
                            <a href="./articles.php<?php if(isset($_GET['categorie']) && !empty($_GET['categorie'])) {echo "?categorie=" . $nomcat . $getajout ;} else {echo "?"; }?>page=<?= $currentPage - 1 ?>" > Précédente</a>
                        </li>
                        <?php for($page = 1; $page <= $pages; $page++): ?>
                          <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) https://www.youtube.com/watch?v=dH4xHMFfS6c 28:00-->
                          <li <?= ($currentPage == $page) ? "active" : "" ?>>
                                <a href="./articles.php<?php if(isset($_GET['categorie']) && !empty($_GET['categorie'])) {echo "?categorie=" . $nomcat . $getajout ;} else {echo "?"; }?>page=<?= $page ?>"><?= $page ?></a>
                            </li>
                        <?php endfor ?>
                          <li class="<?php if($currentPage == $pages) {echo "disabled"; } ?>">
                            <a href="./articles.php<?php if(isset($_GET['categorie']) && !empty($_GET['categorie'])) {echo "?categorie=" . $nomcat . $getajout ;} else {echo "?"; }?>page=<?php if($currentPage != $pages) { echo $currentPage + 1;} ?>">Suivante</a>
                        </li>
                    </ul>
                </nav>

                <form method="GET">
    <a href="./articles.php?categorie=life">
        <input type="button" value="life">
    </a>
    <a href="./articles.php?categorie=street">
        <input type="button" value="street">
    </a>
    <a href="./articles.php?categorie=jul">
        <input type="button" value="jul">
    </a>
    <a href="./articles.php?categorie=road">
        <input type="button" value="road">
    </a>
    </form>
    
</body>
</html>