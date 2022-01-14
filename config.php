<?php
session_start();

// Faire une classe erreur 

    class user{
        protected $bdd;
        private $id;
        public $login;
        public $email;
        protected $password;
        private $id_droit;
        
        
        public function __construct(){
           $this->bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
            
        }
    

        public function register($login, $email, $password){
            $this->login = $login;
            $this->email = $email;
            $this->password = $password;

           
            //connexion à la base de données pour verifier si le login existe deja 
            $requetesql2 = "SELECT login FROM utilisateurs WHERE login = '$this->login'";
            $calcul2 = $this->bdd->prepare($requetesql2);
            $calcul2 -> execute();
            // rowCount permet de compter le nombre d'utilisateur avec ce login
            $result2 = $calcul2->rowCount();

            // Si aucun utilisateur n'a ce login alors je le rentre ne base 
            if(($result2) == 0){
                $requetesql1 = "INSERT INTO `utilisateurs` (`login`, `email`, `password`,`id_droits`) VALUES ('$this->login', '$this->email', '$this->password', 1)";
                $calcul1 = $this->bdd->prepare($requetesql1);
                $calcul1 -> execute();
                echo 'Inscription reussie';
            }else{echo 'Login deja existant';}

            //var_dump($result2);
        }

        // Essai de try/catch 
        // try{
        //     this->bdd->= new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
        // }
        // catch(PDOException $e){
        //     require getMessage();
        // }
    
        public function connect($login, $password){
            $this->login = $login;
            $this->password = $password;

            //recupération du login dans BDD
            $request = "SELECT login FROM `utilisateurs` WHERE login = '$this->login'";
            $calcul = $this->bdd->prepare($request);
            $calcul -> execute();
            $result = $calcul->rowCount();
            var_dump($result);

             //recupération du password dans BDD
            $request2 = "SELECT password FROM `utilisateurs` WHERE login = '$this->login'";
            $calcul2 = $this->bdd->prepare($request2);
            $calcul2 -> execute();
            // On utilise fetchColumn car la fonction password_verify a besoin d'un résultat sous forme de string
            $result2 = $calcul2-> fetchColumn();
            var_dump($result2);

            // Création variable récupération décryptage password
            $check_password = $result2;
            var_dump($check_password); 


            //Vérification que le login existe bien 
            if(($result) == 1){
                //vérification du password
                if(password_verify($password, $check_password)){
                    // Si le password est vérifié alors on récupère toutes les infos user et on les met dans la session
                    $request3 = "SELECT*FROM `utilisateurs` WHERE login = '$this->login'";
                    $calcul3 = $this->bdd->prepare($request3);
                    $calcul3 -> execute();
                    $result3 = $calcul3-> fetchAll(PDO::FETCH_ASSOC);
                    $_SESSION['user'] = $result3;
                    echo 'Connexion reussie';
                    // A rejouter : header('location:')
                    var_dump($_SESSION['user']);
                }else{echo "Password incorrect";}
            }else{echo 'Login inexistant';}
        }

        public function disconnect(){
            session_destroy();
        }

        public function delete(){
            $this->id = $_SESSION['user']['0']['id'];
            $request = "DELETE FROM `utilisateurs` WHERE id = '$this->id' ";
            $calcul = $this->bdd->prepare($request);
            $calcul -> execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            session_destroy();
            var_dump($result);
        }

        public function update($login, $email, $password){
            $this->login = $login;
            $this->email = $email;
            $this->password = $password;

            // reécupération des informations en fonction de la session
            $this->id = $_SESSION['user']['0']['id'];
            $request = "UPDATE utilisateurs SET  login = '$this->login', email = '$this->email', password = '$this->password' WHERE id = $this->id";
            $calcul = $this->bdd->prepare($request);
            $calcul -> execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);

            if($request == true) { // vérifier si on doit signaler que c'est true ou donner une valeur numerique 
                echo 'Modifications enregistrées';
            }else{echo "Erreur d'enregistrement";}
            var_dump($request);

            //On recupere les modification de l'utilisateur (probleme = portee des variable vers la page profil)

            $request2 = "SELECT*FROM `utilisateurs` WHERE login = '$this->login'";
            $calcul2 = $this->bdd->prepare($request2);
            $calcul2 -> execute();
            $result2 = $calcul2->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result2);

            //rajouté dans session donc recupérable sur profil
            $_SESSION['user'] = $result2;
        }


        // commandes de la page admin ou modo 
        public function isConnected(){
            if(isset($_SESSION['user'])){
                echo 'Utilisateur Connecté';
            }else{echo 'Utilisateur non connecté';}
        }

        public function getAllInfos(){
            $this->id = $_SESSION['user']['0']['id'];
            $request = "SELECT*FROM utilisateurs WHERE id = '$this->id' ";
            $calcul =$this->bdd->prepare($request);
            $calcul->execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result);
        }

        public function getLogin(){
            $this->id = $_SESSION['user']['0']['id'];
            $request = "SELECT login FROM utilisateurs WHERE id = '$this->id'";
            $calcul = $this->bdd->prepare($request);
            $calcul-> execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result);
        }

        public function getEmail(){
            $this->id = $_SESSION['user']['0']['id'];
            $request = "SELECT email FROM utilisateurs WHERE id = '$this->id'";
            $calcul = $this->bdd->prepare($request);
            $calcul-> execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result);
        }

        public function getFirstName(){
            $this->id = $_SESSION['user']['0']['id'];
            $request = "SELECT firstname FROM utilisateurs WHERE id = '$this->id'";
            $calcul = $this->bdd->prepare($request);
            $calcul-> execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result);
        }

        public function getLastname(){
            $this->id = $_SESSION['user']['0']['id'];
            $request = "SELECT lastname FROM utilisateurs WHERE id = '$this->id'";
            $calcul = $this->bdd->prepare($request);
            $calcul-> execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result);
        }

        
    }

    class article{
        protected $bdd;
        private $id;
        private $id_droit;
        private $id_article;
        private $commentaire;
        
        
        public function __construct(){
           $this->bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
            
        }

        public function article_com($id_article){
            // recupération des articles et commentaire associés
            $this->id_article = $id_article;
            $request = 'SELECT `article`, `commentaire` FROM `articles` INNER JOIN `commentaires` ON articles.id = commentaires.id_article WHERE commentaires.id_article = "'.$this->id_article.'";';
            $calcul = $this->bdd->prepare($request);
            $calcul->execute();
            $result = $calcul->fetchAll(PDO::FETCH_ASSOC);

            
            
            return $result;
            var_dump($result);

        }

        public function insert_com($commentaire, $id_article){
            // insertion des nouveaux commentaires
            $this->id_article = $id_article;
            $this->commentaire;
            $this -> id_utilisateur = $_SESSION['user']['0']['id'];
            $this -> id = $_SESSION['user']['0']['id'];
            $request = "INSERT INTO `commentaires`(`id` = $this->id, `commentaire` = $this->commentaire,`id_utilisateur` = $this->id_utilisateur, `date` = NOW) WHERE `id_article` = $id_articles";
            $calcul = $this->bdd->prepare($request);
            $calcul->execute();
            $result2 = $calcul->fetchAll(PDO::FETCH_ASSOC);

            return $result2;
            vardump($result2);
        }

    }

?>