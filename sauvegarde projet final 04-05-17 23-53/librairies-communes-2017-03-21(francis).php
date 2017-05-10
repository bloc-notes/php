<?php
function ajouteZeros($numValeur, $intLargeur)
{
    $strFormat=("%0". $intLargeur ."d");
    return sprintf($strFormat,$numValeur);
}

function aujourdhui($binAAAAMMJJ=true)
{
    if($binAAAAMMJJ==true)
    {
        return (date('Y')."-".date('m')."-".date('d'));
    }
    else
    {
        return (date('d')."-".date('m')."-".date('Y'));
    }
}

function bissextile($intAnnee)
{
    if(date('L', strtotime("$intAnnee-1-1"))==1)
                return true;
    else
                return false;
}

function convertitSousChaineEnEntier($strChaine, $intDepart, $intLongueur){
    $intEntier = intVal(substr($strChaine, $intDepart,$intLongueur));
    return $intEntier;
}

function dansIntervalle($numValeur,$intMin,$intMax)
    {
    return($numValeur<$intMin || $numValeur>$intMax);
    }
    
function dateValide($strDate)
{
   extraitJSJJMMAAAAv2($intJourSemaine,$intJour,$intMois,$intAnnee,$strDate);
   return checkdate($intMois,$intJour,$intAnnee);
}

function decomposeURL($strURL,&$strChemin,&$strNom,&$strSuffixe)
    {
    $path_parts = pathinfo($strURL);
    $strSuffixe =$path_parts['extension'];
    $strChemin=$path_parts['dirname'];
    $strNom = $path_parts['filename'];
    }

    function droite($strChaine,$intLargeur)
    {
    $intLongueur = strlen($strChaine);
    return substr($strChaine , $intLongueur-$intLargeur,$intLargeur);
    }

function ecrit($strChaine, $intNbBR=0){
    $strTexte = $strChaine;
    for($i=0;$i<$intNbBR;$i++)
    {
        $strTexte = $strTexte. "<br />";
    }
    echo $strTexte;
}

function encadre($strChaine,$strCaracteres)
    {
    if(strlen($strCaracteres)==2)
        return substr($strCaracteres ,0,1).$strChaine.substr($strCaracteres ,1);
    else
        return  $strCaracteres.$strChaine.$strCaracteres;
    }

    function er($intEntier, $binExposant=true){
    if($intEntier == 1)
        {
        if($binExposant)
            return ($intEntier . "<sup>er</sup>");
        else
            return ($intEntier . "er");
        }
    else
        {
            return($intEntier);
        }
}

 function estNumerique($strValeur)
  {
      return is_numeric($strValeur);
  }
  
  function etatCivilValide($chrEtat,$chrSexe,&$strEtatCivil)
  {
      $booleanBonEtat = true;
      switch (majuscules($chrEtat)) {
    case 'C':
            $strEtatCivil="Célibataire";
        break;
    case 'F':
       if(majuscules($chrSexe)=="F")
           $strEtatCivil = "Conjointe de fait";
       else
           $strEtatCivil = "Conjoint de fait";
        break;
    case 'M':
       if(majuscules($chrSexe)=="F")
           $strEtatCivil = "Mariée";
       else
           $strEtatCivil = "Marié";
        break;
    case 'S':
       if(majuscules($chrSexe)=="F")
           $strEtatCivil = "Séparée";
       else
           $strEtatCivil = "Séparé";
        break;
    case 'D':
      if(majuscules($chrSexe)=="F")
           $strEtatCivil = "Divorcée";
       else
           $strEtatCivil = "Divorcé";
        break;
    case 'V':
            if(majuscules($chrSexe)=="F")
           $strEtatCivil = "Veuve";
       else
           $strEtatCivil = "Veuf";
        break;
    default :
        $booleanBonEtat =false;
        break;
}
return $booleanBonEtat;
  }
  
function extraitJJMMAAAA(&$intJour,&$intMois,&$intAnnee){
    if(func_num_args()==3){
        $strDate=date("d-m-Y");
    }
    else{
        $strDate = func_get_arg(3);
    }
    $intJour=  intval(substr($strDate, 0,2));
    $intMois=  intval(substr($strDate, 3,2));
    $intAnnee=  intval(substr($strDate, 6,4));
}

function s($int){
    if($int>1)
        {
        return "s";
        }
}


function extraitJSJJMMAAAA(&$intJourSemaine,&$intJour,&$intMois,&$intAnnee){
    if(func_num_args()==4)
    {
        $strDate= date("d-m-Y");
        $intJourSemaine = date("N");
    }
 else 
     {
        $strDate = func_get_arg(4);
        $intJourSemaine=date("N",  strtotime($strDate));
    }
    $intJour=  intval(substr($strDate, 0,2));
    $intMois= intval(substr($strDate,3, 2));
    $intAnnee = intval(substr($strDate,6, 4));
}

function extraitJSJJMMAAAAv2(&$intJourSemaine,&$intJour,&$intMois,&$intAnnee)
    {
    if(func_num_args()==4)
    {
        $strDate= date("d-m-Y");
        $intJourSemaine = date("N");
    }
 else 
    {
        $strDate = func_get_arg(4);   
        if(strpos($strDate, "-")==4)
        {
            $intJour=  substr($strDate, 8,2);
            $intMois= substr($strDate,5, 2);
            $intAnnee = substr($strDate,0, 4);
            $strDate = $intJour."-".$intMois."-".$intAnnee;
        }
        $intJourSemaine=date("N",  strtotime($strDate));         
    }
    $intJour=  intval(substr($strDate, 0,2));
    $intMois= intval(substr($strDate,3, 2));
    $intAnnee = intval(substr($strDate,6, 4));

    }
    
function get($strNomParametre){
     return isset($_GET[$strNomParametre]) ? $_GET[$strNomParametre] : null;
 }
 
function JJMMAAAA($intJour,$intMois,$intAnnee){
 if($intAnnee<=20)
    {
     $intAnnee = 2000+$intAnnee;
    }
   else if($intAnnee<=99)
   {
       $intAnnee = 1900+$intAnnee;
   }
   return(ajouteZeros($intJour, 2) . "-" . ajouteZeros($intMois,2))
        ."-".  ajouteZeros($intAnnee, 4);
}

function jourSemaineEnLitteral($intNoJour,$binMajuscule=false){
    $strNoJour = "N/A";
    switch($intNoJour){
        case 1 : $strNoJour = "lundi";break;
        case 2 : $strNoJour = "mardi";break;
        case 3 : $strNoJour = "mercredi";break;
        case 4 : $strNoJour = "jeudi";break;
        case 5 : $strNoJour = "vendredi";break;
        case 6 : $strNoJour = "samedi";break;
        case 7 : $strNoJour = "dimanche";break;
    }
    $strNoJour = $binMajuscule ? ucfirst($strNoJour) : $strNoJour;
    
    return $strNoJour;
}

function majuscules($strChaine)
  {
      return strtoupper($strChaine);
  }
  
  function minuscules($strChaine)
  {
      return strtolower($strChaine);
  }

  function moisEnLitteral($intMois,$binMajuscule=false){
    $strMois = "N/A";
    switch($intMois){
        case 1 : $strMois = "janvier";break;
        case 2 : $strMois = "f&eacute;vrier";break;
        case 3 : $strMois = "mars";break;
        case 4 : $strMois = "avril";break;
        case 5 : $strMois = "mai";break;
        case 6 : $strMois = "juin";break;
        case 7 : $strMois = "juillet";break;
        case 8 : $strMois = "ao&ucirc;t";break;
        case 9 : $strMois = "septembre";break;
        case 10 : $strMois = "octobre";break;
        case 11 : $strMois = "novembre";break;
        case 12 : $strMois = "d&eacute;cembre";break;
    }
    $strMois = $binMajuscule ? ucfirst($strMois) : $strMois;
    
    return $strMois;
  }
  
  function nombreJoursAnnee($intAnnee)
{
    if(bissextile($intAnnee)==true)
        {
        return 366;
        }
 else   {
        return 365;
        }
}
function dollar($dblNombre) {
return number_format($dblNombre, 0, ",", " ") . " $";
}
function millier($dblNombre) {
return number_format($dblNombre, 0, ",", " ");
}


function nombreJoursEntreDeuxDates($strDate1,$strDate2)
         {
            return round( abs(strtotime($strDate2) - strtotime($strDate1))/86400);
         }
         
function nombreJoursMois($intMois, $intAnnee)
    {
    return date('t', strtotime("$intAnnee-$intMois-1"));
    }
    
    function post($strNomParametre){
     return isset($_POST[$strNomParametre]) ? $_POST[$strNomParametre] : null;
 }
 
 function __construct($strNomFichier) {
          $this->strNom=$strNomFichier;
      }
      /*
      |----------------------------------------------------------------------------------|
      | chargeEnMemoire() (2017-03-11)
      | Réf.: http://php.net/manual/fr/function.count.php
      |       http://ca.php.net/manual/fr/function.file.php
      |       http://php.net/manual/fr/function.file-get-contents.php
      |       http://ca.php.net/manual/fr/function.str-replace.php
      |       http://php.net/manual/fr/function.strlen.php
      |----------------------------------------------------------------------------------|
      */
     function  chargeEnMemoire(){
         $this->tContenu = file($this->strNom);
         $this->tContenu = str_replace("\n","", str_replace("\r","",  $this->tContenu));
         $this->intNbLignes = count($this->tContenu);
         
         $this->strContenu = file_get_contents($this->strNom);
         $this->intTaille = strlen($this->strContenu);
         
         $this->strContenuHTML = str_replace("\n\r", "<br />",
                                 str_replace("\r\n","<br />",  $this->strContenu ));
     }
     /*
      |----------------------------------------------------------------------------------|
      | compteLignes() (2017-03-11)
      | Réf.: http://ca.php.net/manual/fr/function.count.php
      |       http://ca.php.net/manual/fr/function.file.php
      |----------------------------------------------------------------------------------|
      */
      function compteLignes() {
          $this->intNbLignes=-1;
          if($this->existe()){
              $this->intNbLignes = count(file($this->strNom));
          }
          return $this->intNbLignes;
      }
      /*
      |----------------------------------------------------------------------------------|
      | detecteFin() (2017-03-11)
      | Réf.: http://php.net/manual/fr/function.feof.php
      |----------------------------------------------------------------------------------|
      */
      function detecteFin(){
          $binVerdict = true;
          if($this->fp)
          {
              $binVerdict = feof($this->fp);
          }
          return $binVerdict;
      }
      /*
      |----------------------------------------------------------------------------------|
      | ecritLigne() (2017-03-11)
      | Réf.: http://php.net/manual/fr/function.fputs.php
      |       http://php.net/manual/fr/function.gettype.php
      |----------------------------------------------------------------------------------|
      */
      function ecritLigne($strLigneCourante,$binSaut_intNbLigneSaut = false){
          $binVerdict = fputs($this->fp,$strLigneCourante);
          if($binVerdict){
              switch(gettype($binSaut_intNbLigneSaut)){
                case "integer" :
                    for($i=1;$i<=$binSaut_intNbLigneSaut && $binVerdict;$i++){
                        $binVerdict = fputs($this->fp,"\r\n");
                    }
                    break;
                case "boolean" :
                    if($binSaut_intNbLigneSaut){
                        $binVerdict=  fputs($this->fp, "\r\n");
                    }
              }
          }
          return $binVerdict;
      }
      /*
      |----------------------------------------------------------------------------------|
      | existe() (2017-03-11)
      | Réf.: http://ca.php.net/manual/fr/function.file-exists.php
      |----------------------------------------------------------------------------------|
      */
     function existe(){
         return file_exists($this->strNom);
     }
     /*
      |----------------------------------------------------------------------------------|
      | ferme() (2017-03-11)
      | Réf.: http://ca.php.net/manual/fr/function.fclose.php
      |----------------------------------------------------------------------------------|
      */
      function ferme(){ 
      $binVerdict = false;
      if($this->fp)
        {
          $binVerdict = fclose($this->fp);
        }
      return $binVerdict;
      }
      /*
      |----------------------------------------------------------------------------------|
      | litDonneesLigne() (2017-03-11)
      | Ref. : http://php.net/manual/fr/function.array-combine.php
      |        http://php.net/manual/fr/function.func-get-arg.php
      |        http://php.net/manual/fr/function.func-num-args.php
      |        http://stackoverflow.com/questions/6814760/php-using-explode-function-to-assign-values-to-an-associative-array
      |----------------------------------------------------------------------------------|
      */
      function litDonneesLigne(&$tValeurs,$strSeparateur){
         for($i=2;$i<=func_num_args()-1;$i++)
         {
             $tValeurs[func_get_arg($i)] = func_get_arg($i);
         }
         $tValeurs = array_combine($tValeurs, explode($strSeparateur, $this->litLigne()));
      }
      /*
      |----------------------------------------------------------------------------------|
      | litLigne() (2017-03-11)
      | Réf.: http://ca.php.net/manual/fr/function.fgets.php
      |       http://ca.php.net/manual/fr/function.str-replace.php
      |----------------------------------------------------------------------------------|
      */
     function litLigne(){
         $this->strLigneCourante = str_replace("\n", "", 
                                   str_replace("\r", "", fgets($this->fp)));
         return $this->strLigneCourante;
     }
     /*
      |----------------------------------------------------------------------------------|
      | ouvre() (2017-03-11)
      | Réf.: http://ca.php.net/manual/fr/function.fopen.php
      |       http://ca.php.net/manual/fr/function.strtoupper.php
      |----------------------------------------------------------------------------------|
      */
      function ouvre($strMode="L"){
          switch(strtoupper($strMode)) {
              case "A" :
              case "A" :
                  $strMode = "a";
                  break;
              case "E":
              case "W":
                  $strMode = "w";
                  break;
              case "L":
              case "R":
                  $strMode = "r";
                  break;
          }
          $this->fp = fopen($this->strNom,$strMode);
          return $this->fp;
      }
?>
