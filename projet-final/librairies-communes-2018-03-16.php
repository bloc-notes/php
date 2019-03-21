<?php
function AAAAMMJJ() {
    $intJourSemaine;
    $intJour;
    $intMois;
    $intAnnee;
    
    if (func_num_args() == 1) {
        $strDate = explode("-", func_get_arg(0));
        $intAnnee = (strlen($strDate[2]) == 2) ?
                    (($strDate[2] <= 20 and $strDate[2] >= 0) ? 2000 + $strDate[2] : /*$strDate[2] <= 99 ?*/ 1900 + $strDate[2]) : 
                    $strDate[2];
        
        $strDate = $strDate[0]."-".$strDate[1]."-".$intAnnee;
        extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $strDate);
        
        echo $intAnnee,"-",$intMois,"-",$intJour;
    }
    else if (func_num_args() == 3) {
        $intJour = func_get_arg(0);
        $intMois = func_get_arg(1);
        $intAnnee = (strlen(func_get_arg(2)) == 2) ?
                    ((func_get_arg(2) <= 20 and func_get_arg(2) >= 0) ? 2000 + func_get_arg(2) : /*$strDate[2] <= 99 ?*/ 1900 + func_get_arg(2)) : 
                    func_get_arg(2);
        
        echo $intAnnee,"-",$intMois,"-",$intJour;
    }
}
function AAAAMMJJSansTiret($strDate) {
    $intJour;
    $intMois;
    $intAnnee;
    
    $strDate = explode("-", func_get_arg(0));
    $strDate = $strDate[0]."-".$strDate[1]."-".$strDate[2];
    
    extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $strDate);
    
    echo $intAnnee, ajouteZeros($intMois, 2),ajouteZeros($intJour, 2);
}
function annee($strDate) {
    return ltrim(date("Y", strtotime($strDate)), "0");
}
function aujourdhui($binAAAAMMJJ=true) {
    if (!$binAAAAMMJJ) {
        return date("d-m-Y");
    }
    else {
        return date("Y-m-d");
    }
}

// j'avais du mal a trouve la solution, donc j'ai pris de ce site https://davidwalsh.name/checking-for-leap-year-using-php
function bissextile($intAnnee) {
    return ((($intAnnee % 4) == 0) && ((($intAnnee % 100) != 0) || (($intAnnee % 400) == 0))) ? true : false ;
}

function convertitSousChaineEnEntier($strChaine, $intDepart, $intLongueur) {
    $intEntier = intval(substr($strChaine, $intDepart, $intLongueur));
    return $intEntier;
}

/*
   |----------------------------------------------------------------------------------|
   | chargeFichierEnMemoire() (2018-03-13)
   | Réf.: http://php.net/manual/fr/function.count.php
   |       http://ca.php.net/manual/fr/function.file.php
   |       http://php.net/manual/fr/function.file-get-contents.php
   |       http://ca.php.net/manual/fr/function.str-replace.php
   |       http://php.net/manual/fr/function.strlen.php
   |----------------------------------------------------------------------------------|
   */
function chargeFichierEnMemoire($strNomFichier,
                                &$tContenu, &$intNbLignes,
                                &$strContenu, &$intTaille,
                                &$strContenuHTML) {
   /* Récupère toutes les lignes et les entrepose dans un tableau
      Retrait de tous les CR et LF
      Récupère le nombre de lignes */
   $tContenu = file($strNomFichier);
   $tContenu = str_replace("\n", "", str_replace("\r", "", $tContenu));
   $intNbLignes = count($tContenu);

   /* Récupère toutes les lignes et les entrepose dans une chaîne */
   $strContenu = file_get_contents($strNomFichier);
   $intTaille = strlen($strContenu);

   /* Entrepose la chaîne résultante dans une autre après l'avoir XHTMLisé ! */
   $strContenuHTML = str_replace("\n\r", "<br />", str_replace("\r\n", "<br />", $strContenu));
}
/*
|----------------------------------------------------------------------------------|
| compteLignesFichier() (2018-03-13)
| Réf.: http://ca.php.net/manual/fr/function.count.php
|       http://ca.php.net/manual/fr/function.file.php
|----------------------------------------------------------------------------------|
*/
function compteLignesFichier($strNomFichier) {
   $intNbLignes = -1;
   if (fichierExiste($strNomFichier)) {
      $intNbLignes = count(file($strNomFichier));
   }
   return $intNbLignes;
}

function dateEnLitteral() {
    $intJourSemaine;
    $intJour;
    $intMois;
    $intAnnee;
    
    if (func_num_args() == 0) {
        extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee);
        
        echo er($intJour)," ", moisEnLitteral($intMois), " ", $intAnnee;
    }
    else if (func_num_args() == 1) {
        if (strcasecmp(func_get_arg(0), "c") == 0) {
            extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee);
        
            echo jourSemaineEnLitteral($intJourSemaine, true)," ",er($intJour)," ", moisEnLitteral($intMois), " ", $intAnnee;
        }
        else {
            extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, func_get_arg(0));
        
            echo er($intJour)," ", moisEnLitteral($intMois), " ", $intAnnee;
        }
    }
    else if (func_num_args() == 2) {
        if (strcasecmp(func_get_arg(0), "c") == 0) {
            extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, func_get_arg(1));
        
            echo jourSemaineEnLitteral($intJourSemaine, true)," ",er($intJour)," ", moisEnLitteral($intMois), " ", $intAnnee;
        }
        else {
            extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, func_get_arg(0));
        
            echo jourSemaineEnLitteral($intJourSemaine, true)," ",er($intJour)," ", moisEnLitteral($intMois), " ", $intAnnee;
        }
    }
}
function dateValide($strDate) {
    $intJourSemaine = "";
    $intJour = "";
    $intMois = "";
    $intAnnee = "";
    
    extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $strDate);
    
    return checkdate($intMois, $intJour, $intAnnee) ? true : false;
}

function decomposeURL($strURL, &$strCHemin, &$strNom, &$strSuffixe) {
    
}

/*
|----------------------------------------------------------------------------------|
| detecteFinFichier() (2018-03-13)
| Réf.: http://php.net/manual/fr/function.feof.php
|----------------------------------------------------------------------------------|
*/
function detecteFinFichier($fp) {
   $binVerdict = true;
   if ($fp) {
      $binVerdict = feof($fp);
   }
   return $binVerdict;
}

/*
|-------------------------------------------------------------------------------------|
| detecteServeur (2017-03-18)
|-------------------------------------------------------------------------------------|
*/
function detecteServeur(&$strMonIP, &$strIPServeur, &$strNomServeur, &$strInfosSensibles) {
  $strMonIP = $_SERVER["REMOTE_ADDR"];
  $strIPServeur = $_SERVER["SERVER_ADDR"];
  $strNomServeur = $_SERVER["SERVER_NAME"];
  $strInfosSensibles = str_replace(".", "-", $strNomServeur) . ".php";
}

function dollar($intNombre, $intNbDecimal=2) {
    echo number_format($intNombre, $intNbDecimal, ",", " ")," $";
}
function dollarParentheses($intNombre, $intNbDecimal=2) {
    if ($intNombre == abs($intNombre)) {
        return number_format($intNombre, $intNbDecimal, ",", " ")." $"; // +
    }
    else {
        return "(".number_format(abs($intNombre), $intNbDecimal, ",", " ").") $"; // -
    }
}

/*
|----------------------------------------------------------------------------------|
| ecritLigneDansFichier() (2018-03-13)
| Réf.: http://php.net/manual/fr/function.fputs.php
|       http://php.net/manual/fr/function.gettype.php
|----------------------------------------------------------------------------------|
*/
function ecritLigneDansFichier($fp, $strLigneCourante, $binSaut_intNbLignesSaut = false) {
   $binVerdict = fputs($fp, $strLigneCourante);
   if ($binVerdict) {
      switch (gettype($binSaut_intNbLignesSaut)) {
         case "integer" :
            for ($i=1; $i<=$binSaut_intNbLignesSaut && $binVerdict; $i++) {
               $binVerdict = fputs($fp, "\r\n");
            }
            break;
         case "boolean" :
            if ($binSaut_intNbLignesSaut) {
               $binVerdict = fputs($fp, "\r\n");
            }
      }
   }
   return $binVerdict;
}
/*
|----------------------------------------------------------------------------------|
| fermeFichier() (2018-03-13)
| Réf.: http://ca.php.net/manual/fr/function.fclose.php
|----------------------------------------------------------------------------------|
*/
function fermeFichier($fp) {
   $binVerdict = false;
     if ($fp) {
        $binVerdict = fclose($fp);
     }
   return $binVerdict;
}
/*
|----------------------------------------------------------------------------------|
| fichierExiste() (2018-03-13)
| Réf.: http://ca.php.net/manual/fr/function.file-exists.php
|----------------------------------------------------------------------------------|
*/
function fichierExiste($strNomFichier) {
   return file_exists($strNomFichier);
}
/*
|----------------------------------------------------------------------------------|
| litLigneDansFichier() (2018-03-13)
| Réf.: http://ca.php.net/manual/fr/function.fgets.php
|       http://ca.php.net/manual/fr/function.str-replace.php
|----------------------------------------------------------------------------------|
*/
function litLigneDansFichier($fp) {
   return str_replace("\n", "", str_replace("\r", "", fgets($fp)));
}
/*
|----------------------------------------------------------------------------------|
| ouvreFichier() (2018-03-13)
| Réf.: http://ca.php.net/manual/fr/function.fopen.php
|       http://ca.php.net/manual/fr/function.strtoupper.php
|----------------------------------------------------------------------------------|
*/
function ouvreFichier($strNomFichier, $strMode="L") {
   switch (strtoupper($strMode)) {
      case "A" :
      case "A" :
         $strMode = "a";
         break;
      case "E" :
      case "W" :
         $strMode = "w";
         break;
      case "L" :
      case "R" :
         $strMode = "r";
         break;
   }
   $fp = fopen($strNomFichier, $strMode);
   return $fp;
}

function er($intEntier, $binExposant=true) {
    return $intEntier == 1 ? ($binExposant ? $intEntier."<sup>er</sup>" : $intEntier."er") : $intEntier;
}

function ajouteZeros($numValeur, $intLargeur) {
    // Ma solution, marche presque pas
    /*$strRetour = "";
    
    for ($i=0; $i<$intLargeur-$numValeur; $i++) {
        if (strlen($intLargeur)>=strlen($numValeur)) $strRetour .= "0";
    }
    
    $strRetour .= $numValeur;
    
    return $strRetour;*/
    
    $strRetour = "%0".$intLargeur."d";
    return sprintf($strRetour, $numValeur);
}
function extraitJJMMAAAA(&$intJour, &$intMois, &$intAnnee) {
    if (func_num_args() == 3) {
        $strDate = date("d-m-Y");
    }
    else {
        $strDate = func_get_arg(3);
    }
    
    $intJour = intval(substr($strDate, 0, 2));
    $intMois = intval(substr($strDate, 3, 2));
    $intAnnee = intval(substr($strDate, 6, 4));
}

function extraitJSJJMMAAAA(&$intJourSemaine, &$intJour, &$intMois, &$intAnnee) {
    if (func_num_args() == 4) {
        $strDate = date("d-m-Y");
        
        $intJourSemaine = date("N");
    }
    else {
        $strDate = func_get_arg(4);
        
        $intJourSemaine = date("N", strtotime($strDate));
    }
    
    $intJour = intval(substr($strDate, 0, 2));
    $intMois = intval(substr($strDate, 3, 2));
    $intAnnee = intval(substr($strDate, 6, 4));
}

function input($strID, $strCLASS, $strMAXLENGTH, $strVALUE, $binECHO=false) {
    if (!$binECHO){
        echo "<input id=\"$strID\" name=\"$strID\" class=\"$strCLASS\" type=\"text\" maxlength=\"$strMAXLENGTH\" value=\"$strVALUE\"/>";
    }
    else {
        return "<input id=\"".$strID."\" name=\"".$strID."\" class=\"".$strCLASS."\" type=\"text\" maxlength=\"".$strMAXLENGTH."\" value=\"".$strVALUE."\"/>";
    }
}

function jourSemaineEnLitteral($intNoJour, $binMajuscule=FALSE) {
    $strNoJour = "N/A";
    switch ($intNoJour) {
        case 1: $strNoJour = "lundi";            break;
        case 2: $strNoJour = "mardi";            break;
        case 3: $strNoJour = "mercredi";            break;
        case 4: $strNoJour = "jeudi";            break;
        case 5: $strNoJour = "vendredi";            break;
        case 6: $strNoJour = "samedi";            break;
        case 7: $strNoJour = "dimanche";            break;
    }
    
    $intNoJour = $binMajuscule ? ucfirst($strNoJour) : $strNoJour;
    
    return $intNoJour;
}

function JJMMAAAA($intJour, $intMois, $intAnnee) {
    $intAnnee = ($intAnnee <= 20 and $intAnnee >= 0) ? 2000 + $intAnnee : ($intAnnee <= 99 ? 1900 + $intAnnee : $intAnnee);
    
    return ajouteZeros($intJour, 2)."-".ajouteZeros($intMois, 2)."-".$intAnnee;
}

function mois($strDate){
    return ltrim(date("m", strtotime($strDate)), "0");
}

function moisEnLitteral($intMois, $binMajuscule=false) {
    $strMois = "N/A";
    switch ($intMois) {
        case 1: $strMois = "janvier";            break;
        case 2: $strMois = "f&eacute;vrier";            break;
        case 3: $strMois = "mars";            break;
        case 4: $strMois = "avril";            break;
        case 5: $strMois = "mai";            break;
        case 6: $strMois = "juin";            break;
        case 7: $strMois = "juillet";            break;
        case 8: $strMois = "ao&ucirc;t";            break;
        case 9: $strMois = "septembre";            break;
        case 10: $strMois = "octobre";            break;
        case 11: $strMois = "novembre";            break;
        case 12: $strMois = "d&eacute;cembre";            break;
    }
    
    $strMois = $binMajuscule ? ucfirst($strMois) : $strMois;
    
    return $strMois;
}

function nombreJoursAnnee($intAnnee) {
    return bissextile($intAnnee) ? 366 : 365;
}

function nombreJoursEntreDeuxDates($strDate1, $strDate2) {
    return round(abs(strtotime($strDate1) - strtotime($strDate2)) / (60 * 60 * 24));
    
    /*$intNoSerie1 = strtotime($strDate1) / 86400;
      $intNoSerie2 = strtotime($strDate2) / 86400;
      return round(abs($intNoSerie2 - $intNoSerie1));*/
}

function nombreJoursMois($intMois, $intAnnee) {
    return cal_days_in_month(CAL_GREGORIAN, $intMois, $intAnnee);
}

function extraitJSJJMMAAAAv2(&$intJourSemaine, &$intJour, &$intMois, &$intAnnee) {
    if (func_num_args() == 4) {
        $strDate = date("d-m-Y", strtotime(aujourdhui()));
        
        $intJourSemaine = date("N");
    }
    else {
        $strDate = (strtotime(func_get_arg(4)) != null) ? 
                    ((substr(func_get_arg(4), 4, 1) == "-") ? 
                        implode('-', array_reverse(explode('-', func_get_arg(4)))) : 
                        func_get_arg(4)) /*date("d-m-Y", strtotime(func_get_arg(4)))*/ 
                    : null;
        
        $intJourSemaine = date("N", strtotime($strDate));
    }
    
    $intJour = intval(substr($strDate, 0, 2));
    $intMois = intval(substr($strDate, 3, 2));
    $intAnnee = intval(substr($strDate, 6, 4));
}

function get($strNomParametre) {
    return isset($_GET[$strNomParametre]) ? $_GET[$strNomParametre] : null;
}

function post($strNomParametre) {
    return isset($_POST[$strNomParametre]) ? $_POST[$strNomParametre] : null;
}

function jour($strDate){
    return ltrim(date("d", strtotime($strDate)), "0");
}

function hierOuDemain($strDate, $blnDemain=true) {
    if ($blnDemain) {
        return date('Y-m-d', strtotime($strDate."+1 days"));
    }
    else {
        return date('Y-m-d', strtotime("-1 days", strtotime($strDate)));
    }
}

function periode($intJ, $intM, $intA) {
    /*$intJourSemaine = "";
    $intJour = "";
    $intMois = "";
    $intAnnee = "";
    
    extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $strDate);*/
    
    return ($intA)."-".  ajouteZeros($intM, 2)."-".  ajouteZeros($intJ, 2);
}

function pourcent($intNombre, $intNbDecimal=2) {
    echo number_format($intNombre, $intNbDecimal, ",", " ")," %";
}


// https://stackoverflow.com/questions/6369887/alternative-to-money-format-function-in-php-on-windows-platform
/*function formatNombres($strNombre, $strFormat){
    if ($strFormat == "$") {
        $fmt = new NumberFormatter('fr_CA', NumberFormatter::CURRENCY);
        
        if ($strNombre == abs($strNombre)) {
            echo $fmt->formatCurrency($strNombre, "CAD");
        }
        else {
            echo "(",$fmt->formatCurrency(abs($strNombre), "CAD"),")";
        }
    }
    else {
        echo number_format($strNombre, $strFormat, ",", "")," %";
    }
}*/

function retourneMontant($arrMontant){
    if (func_num_args() == 2) {
        foreach ($arrMontant as $strDate => $strMontant) {
            if (func_get_arg(1) == $strDate) { 
                return str_replace(",", ".", $strMontant);
            }
        }
    }
    else {
        return str_replace(",", ".", $arrMontant);
    }
}

/*function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = explode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}*/