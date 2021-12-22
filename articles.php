<?php


//connexion
$user = 'root';
$pass = '';

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);
    $bdd->exec('SET NAMES "UTF8"');
    /*foreach ($bdd->query('SELECT * FROM articles') as $row) 
    {
        //print_r($row);
        echo "<pre>";
        print_r ($row['article']);
        echo "<pre>";
    }*/
}

catch (PDOException $e)
{
    print "Error: " . $e->getMessage() . "<br/>";
    die();
}

//déterminer sur quel page on est par une injection get dans l'url

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








?>

<!DOCTYPE html>
<html lang="en">
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
                        <li <?= ($currentPage == 1) ? "disabled" : "" ?>>
                            <a href="./articles.php/?page=<?= $currentPage - 1 ?>" > Précédente</a>
                        </li>
                        <?php for($page = 1; $page <= $pages; $page++): ?>
                          <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                          <li <?= ($currentPage == $page) ? "active" : "" ?>>
                                <a href="./articles.php/?page=<?= $page ?>"><?= $page ?></a>
                            </li>
                        <?php endfor ?>
                          <li <?= ($currentPage == $pages) ? "disabled" : "" ?>>
                            <a href="./articles.php/?page=<?= $currentPage + 1 ?>">Suivante</a>
                        </li>
                    </ul>
                </nav>
    
</body>
</html>