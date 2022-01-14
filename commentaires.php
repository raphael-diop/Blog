<?php
require_once 'config.php';


//récuperer l'id en get le stoquer dans id_article.
if(isset($_GET['id_articles']) && !empty($_GET['id_articles'])){
    $id_article = $_GET['id_articles'];
    $Article = new Article();
    $com = $Article->article_com($id_article);

    var_dump($com);
}


//Ajouter un commentaire 
 if (isset($_POST['commentaire'])) {
    $commentaire = htmlspecialchars($_POST['commentaire']);
    $insert = $Article->insert_com($commentaire, $id_article);
    var_dump($insert);
 }








//Ajouter des nouveaux commentaires 



?>

<body>
        <div>
             

            <form action="" method="POST">
               
                 <h1>
                    ARTICLE:
                </h1> 
                <P>
                    <?php 
                        $article = $com['0']['article'];
                        echo $article;
                      ?>
                 </P>

                <h1>
                    COMMENTAIRE: 
                 </h1>
                <P> 
                     <?php foreach($com as $i){ 
                         echo '<br>' .$i['commentaire']. '</br>';
                     } ?>
                </P>

                <h1>
                      POSTER VOTRE COMMENTAIRE:
                </h1>
                    
                <textarea name="commentaire" cols="52" rows="5"></textarea>

                <input type="submit" id='submit' name="envoyer" value='Envoyer'>
            </form>
        </div>
    </body>



