<?php
session_start();

    class user{
        protected $bdd;
        private $id;
        public $login;
        public $email;
        protected $password;
        private $id_droits;
        
        
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
            var_dump($_SESSION);
            // Création variable récupération décryptage password
            $check_password = $result2;
            var_dump($check_password);


            //Vérification que le login existe bien 
            if(($result) == 1){
                if ($login == 'admin'){//si mdp admin ok alors alors direction admin
                            $_SESSION['admin'] = $result;
                            header('location: admin.php');
                            var_dump($_SESSION);
                        }            
                //vérification du password
                if(password_verify($password, $check_password)){
                    // Si le password est vérifié alors on récupère toutes les infos user et on les met dans la session
                    $request3 = "SELECT*FROM `utilisateurs` WHERE login = '$this->login'";
                    $calcul3 = $this->bdd->prepare($request3);
                    $calcul3 -> execute();
                    $result3 = $calcul3-> fetchAll(PDO::FETCH_ASSOC);
                    $_SESSION['user'] = $result3;
                      if($_SESSION['user'] = $result){
                           //si mdp user ok direction user
var_dump($_SESSION);
                        //    header('location: profil.php');
                      }
                    // $_SESSION['admin'] = $result3;
                    // header('Location: admin.php');
                }else{
                    echo 'connexion échouer';
                }  
            }else{
                   echo 'Login inexistant';}
        }

        public function disconnect(){
            if (isset($_POST['logout']))
                {
                session_destroy();
                header('location:index.php');
                }
                            
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

        public function update($id,$login, $email, $password, $id_droits){
            $this->login = $login;
            $this->email = $email;
            $this->password = $password;
            $this->id = $id;
            $this->id_droits= $id_droits;
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

            $request2 = "SELECT*FROM utilisateurs WHERE login = '$this->login'";
            $calcul2 = $this->bdd->prepare($request2);
            $calcul2 -> execute();
            $result2 = $calcul2->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result2);

            //rajouté dans session donc recupérable sur profil
            $_SESSION['user'] = $result2;
        }
    

        
    
        public function isConnected(){
            if(isset($_SESSION['user'])){
                echo 'Utilisateur Connecté';
            }else{echo 'Utilisateur non connecté';}
        }

        public function getAllInfos(){
            // $this->id = $_SESSION['user']['0']['id'];
            // $request = "SELECT*FROM utilisateurs WHERE id = '$this->id' ";
            // $calcul =$this->bdd->prepare($request);
            // $calcul->execute();
            // $result = $calcul->fetchAll(PDO::FETCH_ASSOC);
            
            echo $this->id .'<br/>';
            echo $this->login .'<br/>';
            echo $this->email  .'<br/';
            // var_dump($result);
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

        // public function administrateur($id, $password){
        //     $this->id = $_SESSION['user']['0']['id'];
        //     $request = "INSERT INTO `droit` WHERE administrateur login = 'admin' && password = '1337'";
        // }


        
    }

?>