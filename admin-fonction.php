<?php

class Admin{
    protected $bdd;
        private $id;
        public $login;
        public $email;
        protected $password;
        private $id_droits;


        public function __construct()
        {
            $this->bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
        }

        public function verificationAdmin($login, $id_droits){
         if(!empty($_SESSION['login']['user'])){

             $requete="SELECT *FROM utilisateurs WHERE login= $this->login AND id_droits = $this->$id_droits";
             $reponse=$this->bdd->prepare($requete);
             $reponse->execute();
             $resultat=$reponse->rowCount();
             
             $admin = 1337;
             $modo = 42;
             $utilisateur = 1;
             if($_SESSION['submit']){
                if($admin === 1337){
                    header('location:admin.php');
                   if($modo === 42){
                        header('location:profil.php');
                       if($utilisateur === 1){
                           header('location:profil.php');
                       }
                    }
                }
             }
             
         }

        }
}

?>