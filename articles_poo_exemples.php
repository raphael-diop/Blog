//version full POO

<?php

class DataPager {

private $_fieldindex = 1;

private $_pagesize;
private $_totalrowcount;

//Premiere page
public function firstPage(){
//Si derniere page egale 0
if( $this->lastPage() == 0)
return 0;

return 1;
}

//Page precedente
public function previousPage(){
//Si derniere page egale 0
if( $this->lastPage() == 0)
return 0;

if($this->_fieldindex == 1)
return $this->_fieldindex;

$prev = $this->_fieldindex;
return $prev - 1;
}

public function nextPage(){
if($this->_fieldindex >= ceil($this->_totalrowcount/$this->_pagesize))
return ceil($this->_totalrowcount/$this->_pagesize);

$next = $this->_fieldindex;
return $next + 1;
}

//Derniere page
public function lastPage(){
return ceil($this->_totalrowcount/$this->_pagesize);
}

//Obtient ou définit le nombre d'enregistrements affichés pour chaque page de données.
public function pageSize($value = ""){

if(strlen(trim($value)) == 0)
return (int)$this->_pagesize;

$this->_pagesize = (int)$value;
}

//Obtient la page en cours affiché dans une page de données.
public function pageField(){
if( $this->lastPage() == 0)
return 0;

return $this->_fieldindex;
}

//Obtient ou definit le nombre total des enregistrements extraits par l'objet
//de source de données sous-jacent référencé par le contrôle lié aux données associé.
public function TotalRowCount($value = ""){
if(strlen(trim($value)) == 0)
return (int)$this->_totalrowcount;

if(!is_numeric($value))
throw new exception("Format incorrect.");

$this->_totalrowcount = (int)$value;
}

//Obtient l'index du premier enregistrement affiché dans une page de données.
public function StartRowIndex(){
//On multiplie page en court par nombre de page moins monbre de page
return $this->_fieldindex * $this->_pagesize - $this->_pagesize;
}

function __construct($value){
if($value > 1)
$this->_fieldindex = $value;
}

}

?>

pour l'utilisation c'est simple
instance du pager
$pager = new DataPager($page);

nombre page
$pager->pageSize(10);

object ou requete pour comptage des ligne
$pager->TotalRowCount($contact->dbCount());

instantation de la class de gestion SQL et utilisation des methodes $pager->StartRowIndex(), $pager->pageSize() dans la clause sql LIMIT

Méthode de pagination
[{$_SERVER['PHP_SELF']}?page= firstPage().">Premier]
[{$_SERVER['PHP_SELF']}?page= previousPage().">Precedent]
nextPage().">Suivant
lastPage().">Dernier

------------------------------------------------------------------------------------------------
//version static

<?php
//*** CREE PAR MOUNIR R'QUIBA (MOON AIR) (cosmoswarez@msn.com) ********
//          31/08/2009 !! COPYRIGHT !!
//--------A utiliser sans moderation :D -------------------------------

//  Class qui met automatiquement en forme la pagination


class Page{  
 static function pagination($nbFields,$pos=1,$nbCount=10,$path){
       $cPage = ceil($nbFields/$nbCount);
       $cBy = 0;
       $cStart = ($pos < 3 and $pos > 1)? $pos-1 : $pos-2;
       if($pos == 1){$cStart = 1;}
       if($pos == $cPage){$cStart = $pos - 4;}
       if($pos == $cPage-1){$cStart = $pos - 3;}
       $posPlus = $pos+1;
       $posMoins = $pos-1;
       if($cPage > 5){
          $link = ($pos < 4)? "" : " <a href=\"".$path."1\" ><<</a> |";
       }
       $linkp = ($pos < 2)? "" : " <a href=\"$path$posMoins\" ><</a> |";
       $link .= $linkp;
         for($i=$cStart;$i<=$cPage;$i++){
           $cBy++;
           if($cBy > 0 and $cBy < 6){ 
             if($pos == $i){
               $link .= " <font color=\"red\">$i/$cPage</font> |";  
             }else{
              if($i >= 1){
               $link .= " <a href=\"$path$i\" >$i</a> |";
               }
             }
           }
         }
       
       
       $link = substr($link,0,-1);
       $vlink = ($pos > ($cPage-1))? "" : " | <a href=\"$path$posPlus\" >></a>";
       if($cPage > 5){
          $flink = ($pos > ($cPage-3))? "" : " | <a href=\"$path$cPage\" >>></a>";
       }
       $link .= $vlink;
       $link .= $flink;
       return $link;
    
    }
}

/*

 Affichage du système de pagination
/


$nbFields = 1000;
$nbCount = 10;
$nbPage = $nbFields / $nbCount;
$path = "./?pos=";
 
if(isset($_GET['pos'])){ 
   $pos = trim(htmlentities($_GET['pos'], ENT_QUOTES)); 
   if($pos > $nbPage or $pos <= 0 ){ $pos = 1; } 
}else{ $pos = 1; }

$print_page = Page::pagination($nbFields,$pos,$nbCount,$path);
echo $print_page;
?>