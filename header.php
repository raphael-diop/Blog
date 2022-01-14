<?php
$errormess = '';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="perdu" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>Document</title>
</head>

<header>
    <nav class=nav>
      <ul>
          <li><a href="index.php">Accueil</a></li>
          <?php
          if(isset($_SESSION['user'])){ 
          echo ('<li class="items"><a class="lien", href="inscription.php">inscription</a></li>');
          }else{ echo "";
          }?>
            <?php
            if(isset($_SESSION['user'])){ 
              echo ('<li class="items"><a class="lien", href="connexion.php">connexion</a></li>');
            }else{ echo "";}?>
              <?php
                if(isset($_SESSION['user'])){
                  echo ('<li class="items"><a class="lien", href="profil.php">profil</a></li>');
                }else{ echo "";}
                  if(isset($_SESSION['admin'])){
                    echo ('<li class="items"><a class="lien", href="profil.php">profil</a></li>');
                  }else{ echo "";}
                  ?>
                  <?php
                    if (isset($_SESSION['admin']))
                    {
                      echo ('<li class="items"><a class="lien", href="admin.php">admin</a></li>');
                    }
                    ?>
                    <?php
                      if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])){
                        echo ('<li><a href="inscription.php">Inscription</a></li>');
                      }else{ echo "" ; }
                      ?>
                      <?php
                          if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])){
                            echo ('<li><a href="connexion.php">Connexion</a></li>');
                          }else{ echo "" ; }?>  
          
                            <li class="dropdown">
                            <a href="#" class="dropbtn">Menu</a>
                            <div class="dropdown-content">
                            <a href="article.php">Article</a>
                            <a href="articles.php">Articles</a>
                            <a href="creer-article.php">Créer article</a>
                           <?php  
                            if (isset($_SESSION['user']) && isset($_SESSION['admin']))
                              {
                                echo ('<li class="items"><a class="lien", href="profil.php">Profil</a></li>');
                              }else{
                                echo "";
                              }
                              ?>
                            <?php
                            if (isset($_SESSION['user']) || isset($_SESSION['admin'] )){
                            echo ('<li><a class="deconnexion" href="logout"><form action="" method="post"><input type="submit" name="logout" value="Se déconnecter"></form></a></li>');
                            $user = new user();
                            $user->disconnect();
                            }?>
          </div>
        </div>
       </li>
      </ul>
    </nav>
  </header>

  