<?php
/*Philippe Doyon 21-03-17*/
    
    /*
     * ajouteZero (02-02-2017)
     * ($numValeur, $intLargeur)
     */
    function ajouteZero($numValeur, $intLargeur){
        return sprintf("%'.0$intLargeur" ."d", $numValeur);
    }
    
    /*aujourdhui(03-02-2017)
     * ($binAAAAMMJJ=true)
     * retourne la date actuel faux = jj-mm-aaaa
     */
    function aujourdhui($binAAAAMMJJ=true){
        return $binAAAAMMJJ ? date("Y-m-d"):date("d-m-Y");
    }
    
    /*bissextile (03-02-2017)
     * ($intAnnee)
     * vrai = année bissextile
     */
    function bissextile($intAnnee){
        return date("L",  mktime(0,0,0,1,1,$intAnnee));
    }
    
    /*
   |----------------------------------------------------------------------------------|
   | chargeFichierEnMemoire() (2017-03-11)
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
   | compteLignesFichier() (2017-03-11)
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
   
    /*
     * convertitSousChaineEnEntier (2017-01-27)
     */
    function convertirSousChaineEnEntier($strChaine,$intDepart,$intLongueur){
        $intEntier = intval(substr($strChaine,$intDepart,$intLongueur));
        return $intEntier;
    }
    
    /*
     * dateValide (08-02-2017)
     * ($strDate)
     * permet jj-mm-aaaa ou aaaa-mm-jj
     */
    function dateValide($strDate){
        $intJourSemaine;
        $intJour;
        $intMois;
        $intAnnee;
        extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee,$strDate);
        return checkdate($intMois, $intJour, $intAnnee);
    }
    
    /*
     * dansIntervalle (15-02-2017)
     * ($numValeur,$intMin,$intMax)
     */
    function dansIntervalle($numValeur,$intMin,$intMax){
        return ($numValeur >= $intMin) && ($numValeur <= $intMax) ?TRUE:FALSE;
    }

    /*
     * decomposeURL (13-02-2017)
     * ($strURL,&$strChemin,&$strNom,&$strSuffixe)
     * retourne nom du chemin, (nom du fichier ou de la page) et le suffixe
     */
     function decomposeURL($strURL,&$strChemin,&$strNom,&$strSuffixe){
         $pathURL = pathinfo($strURL);
         
         $strChemin = $pathURL['dirname'];
         $strNom = $pathURL['filename'];
         $strSuffixe = $pathURL['extension'];
    }
    
    /*
   |----------------------------------------------------------------------------------|
   | detecteFinFichier() (2017-03-11)
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
     * doite (10-02-2017)
     * ($strChaine, $intLargeur)
     * Caractère a partir de la droite (si nombre plus grand que le nombre de caractere, affiche tout)
     */
    function droite($strChaine, $intLargeur){
	$intNbCaractere = strlen($strChaine);
	return $intLargeur>=$intNbCaractere?$strChaine:substr($strChaine,$intNbCaractere - $intLargeur);
    }
    
    /*
     * ecrit (08-02-2017)
     * ($strChaine, $intNbBR=0)
     * Structure pour les echo
     */
    function ecrit ($strChaine, $intNbBR=0){
        $strLigne = $strChaine;
        for($intx = 0;$intNbBR!=0 && $intx<$intNbBR;$intx++){
           $strLigne.="<br />";
        }
        echo $strLigne;
    }
    
    /*
   |----------------------------------------------------------------------------------|
   | ecritLigneDansFichier() (2017-03-11)
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
     * encadre (10-02-2017)
     * ($strChaine,$strCaracteres)
     * Encadre du ou des deux caractère voulue (symbole)
     */
    function encadre($strChaine,$strCaracteres){
        return strlen($strCaracteres) == 1? $strCaracteres.$strChaine.$strCaracteres:gauche($strCaracteres, 1).$strChaine.droite($strCaracteres, 1);
    }
    
    /*
     * er (30-01-17)
     *      er($intEntier)
     *      er($intEntier, $binExposant=true)
     */
    function er($intEntier, $binExposant = true){
        return $intEntier . ($intEntier == 1 ? ($binExposant ? "<sup>er</sup>"
            : "er") : "");
    }
    
    /*
     * estNumerique (10-02-2017)
     * ($strValeur)
     * true = numérique
     */
    function estNumerique($strValeur){
        return is_numeric($strValeur);
    }

    /*
     * etatCivilValide (10-02-2017)
     * ($chrEtat, $chrSexe, &$strEtatCivil)
     * true = etat valide (c,f,m,s,d,v)
     */
    function etatCivilValide($chrEtat, $chrSexe, &$strEtatCivil){
        $booValide = true;
        switch (majuscules($chrEtat)) {
            case 'M':
                $strEtatCivil = majuscules($chrSexe)=='H'?'Marié':'Mariée';
                break;
            case 'C':
                $strEtatCivil = 'Célibataire';
                break;
            case 'F':
                $strEtatCivil = majuscules($chrSexe)=='H'?'Conjoint de fait':'Conjointe de fait';
                break;
            case 'S':
                $strEtatCivil = majuscules($chrSexe)=='H'?'Séparé':'Séparée';
                break;
            case 'D':
                $strEtatCivil = majuscules($chrSexe)=='H'?'Divorcé':'Divorcée';
                break;
            case 'V':
                $strEtatCivil = majuscules($chrSexe)=='H'?'Veuf':'Veuve';
                break;
            default:
                $booValide = false;
                break;
        }
        return $booValide;
    }
    
    /*
     * extraitJJMMAAAA (2017-01-27)
     * Scénarios: extraitJJMMAAAA($intJour,$intMois,$intAnnee)        => date()
     *            extraitJJMMAAAA($intJour,$intMois,$intAnnee,strDate)=> strDate
     */
    function extraitJJMMAAAA(&$intJour,&$intMois, &$intAnnee){
        /*d'habitude 4 argument = date*/
        if(func_num_args()==3){
            /*récupération date courante*/
            $strDate = date("d-m-Y");
        }
        else{
            /*récupération 4e argument*/
            $strDate = func_get_arg(3);
        }
        
        $intJour = intval(substr($strDate, 0,2));
        $intMois = intval(substr($strDate, 3,2));
        $intAnnee = intval(substr($strDate ,6,4)); 
    }
    
    /*
     * extraitJSJJMMAAAA (30-01-17)
     *      extraitJSJJMMAAAA($intNoJours,$intJour,$intMois,$intAnnee)
     *      (amélioration de extraitJJMMAAAA)
      */
    function extraitJSJJMMAAAA(&$intNoJour,&$intJour,&$intMois,&$intAnnee){
        /*d'habitude 4 argument = date*/
        if(func_num_args()==4){
            /*récupération date courante*/
            $strDate = date("d-m-Y");
            /*Jours semaine*/
            $intNoJour = date("N");
        }
        else{
            /*récupération 4e argument*/
            $strDate = func_get_arg(4);
            
            /*Conversion date en timestamp unix pour avoir jours de la semaine*/
            $intNoJour = date("N", strtotime($strDate));
        }
        
        $intJour = intval(substr($strDate, 0,2));
        $intMois = intval(substr($strDate, 3,2));
        $intAnnee = intval(substr($strDate ,6,4));      
    }
    
    /*
     * extraitJSJJMMAAAAv2
     * (&$intJourSemaine,&$intJour,&$intMois,&$intAnnee)
     * Permet jj-mm-aaaa ou aaaa-mm-jj
     */
    function extraitJSJJMMAAAAv2(&$intJourSemaine,&$intJour,&$intMois,&$intAnnee){
        /*d'habitude 4 argument = date*/
        if(func_num_args()==4){
            /*récupération date courante*/
            $strDate = date("d-m-Y");
            /*Jours semaine*/
            $intJourSemaine = date("N");
        }
        else{
            /*récupération 4e argument*/
            $strDate = func_get_arg(4);
            
            /*Conversion date en timestamp unix pour avoir jours de la semaine*/
            /*$intJourSemaine = date("N", strtotime(date("d-m-Y",strtotime($strDate))));*/
            $intJourSemaine = date("N", strtotime($strDate));
        }
        
        if(substr($strDate, 2, 1) == "-"){
            $intJour = intval(substr($strDate, 0,2));
            $intMois = intval(substr($strDate, 3,2));
            $intAnnee = intval(substr($strDate ,6,4)); 
        }
        else{
            $intJour = intval(substr($strDate, 8,2));
            $intMois = intval(substr($strDate, 5,2));
            $intAnnee = intval(substr($strDate, 0,4));
        }     
    }
    
    /*
   |----------------------------------------------------------------------------------|
   | fermeFichier() (2017-03-11)
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
   | fichierExiste() (2017-03-11)
   | Réf.: http://ca.php.net/manual/fr/function.file-exists.php
   |----------------------------------------------------------------------------------|
   */
   function fichierExiste($strNomFichier) {
      return file_exists($strNomFichier);
   }
    
    /*
     * gauche (10-02-2017)
     * ($strChaine, $intLargeur)
     * Caractère a partir de la gauche (si nombre plus grand que le nombre de caractere, affiche tout)
     */
    function gauche($strChaine, $intLargeur){
	$intNbCaractere = strlen($strChaine);
	return $intLargeur>=$intNbCaractere?$strChaine:substr($strChaine,0,$intLargeur);
    }

	/*
	* genereNombre (28-02-17) LMB
	* ($Maximum)
	*/
	function genereNombre($Maximum){
		list($usec,$sec) = explode(' ',microtime());
		$dblGerme = (float) $sec + ((float) $usec * 100000);
		srand($dblGerme);
		return floor(rand()%$Maximum+1);
	}
    
    /*
    * get (15-02-2017)
    * ($strNomParametre) valeur parametre ou null
    */
    function get($strNomParametre){
        return isset($_GET[$strNomParametre]) ? $_GET[$strNomParametre] : null;
    }
    
    /*
     * JJMMAAAA (02-02-2017)
     * ($intJour,$intMois,$intAnnee)
     * si l'année a 2 chiffre (0 a 20 == 2000 a 2020 et 21 a 99 == 1921 a 1999)
     */
    function JJMMAAAA($intJour,$intMois,$intAnnee){
        $intAnnee = $intAnnee <= 20 ? 2000 + $intAnnee : 
                ($intAnnee <= 99 ? 1900 + $intAnnee: $intAnnee);
        
        /*format date 0J-0M-AAAA */
        
        return ajouteZero($intJour, 2) . "-" .
            ajouteZero($intMois, 2) . "-" .
            ajouteZero($intAnnee, 4);    
    }
    
    /*
     * joursSemaineEnLitteral (30-01-17)
     * Scénarios:joursSemaineEnLitteral($intNoJour) => Première lettre minuscule
     *    :joursSemaineEnLitteral($intNoJour,$binMajuscule)=>En fonction de $bin
     */
    function jourSemaineEnLitteral($intNoJour, $binMajuscule=false){
        $strJourSe = "N/A";
        switch ($intNoJour) {
            case 1: $strJourSe = "lundi";break;
            case 2: $strJourSe = "mardi";break;
            case 3: $strJourSe = "mercredi";break;
            case 4: $strJourSe = "jeudi";break;
            case 5: $strJourSe = "vendredi";break;
            case 6: $strJourSe = "samedi";break;
            case 7: $strJourSe = "dimanche";break;
        }
        
        $strJourSe = $binMajuscule ? ucfirst($strJourSe) : $strJourSe;
	return $strJourSe;
    }
    
    /*
   |----------------------------------------------------------------------------------|
   | litLigneDansFichier() (2017-03-11)
   | Réf.: http://ca.php.net/manual/fr/function.fgets.php
   |       http://ca.php.net/manual/fr/function.str-replace.php
   |----------------------------------------------------------------------------------|
   */
   function litLigneDansFichier($fp) {
      return str_replace("\n", "", str_replace("\r", "", fgets($fp)));
   }
    
    /*
     * majuscules (10-02-2017)
     * ($strChaine)
     * met en majuscule (surprice)
     */
    function majuscules($strChaine){
        return strtoupper($strChaine);
    }
    
    /*
     * minuscule (10-02-2017)
     * ($strChaine)
     * met en minuscule (surprice)
     */
    function  minuscules($strChaine){
        return strtolower($strChaine);
    }  
    
    /*
     * MoisEnLitteral (27-01-2017)
     * Scénarios : moisEnLitteral($intMois) => Première lettre minuscule
     *           : moisEnLitteral($intMois, $binMajuscule)=>En fonction de $bin 
     */
    function moisEnLitteral($intMois, $binMajuscule = false){
        /* par default, c'est minuscule*/
        $strMois = "N/A";
        switch ($intMois) {
            case 1: $strMois = "janvier";break;
            case 2: $strMois = "février";break;
            case 3: $strMois = "mars";break;
            case 4: $strMois = "avril";break;
            case 5: $strMois = "mai";break;
            case 6: $strMois = "juin";break;
            case 7: $strMois = "juillet";break;
            case 8: $strMois = "août";break;
            case 9: $strMois = "septembre";break;
            case 10: $strMois = "octobre";break;
            case 11: $strMois = "novembre";break;
            case 12: $strMois = "décembre";break;
        }
        
        /*
        if ($binMajuscule){
            $strMois = ucfirst($strMois);
        }
         * */
         
        $strMois = $binMajuscule ? ucfirst($strMois) : $strMois;
          
        return $strMois;
    }
    
    /*
     * nombreJoursAnnee (03-02-2017)
     * ($intAnnee)
     * retourne 365 ou 366
     */
    function nombreJoursAnnee($intAnnee){
        return bissextile($intAnnee)?366:365;
    }
    
    /*
     * nombreJoursMois (03-02-2017)
     * ($intMois,$intAnnee)
     * retourne entre 28 a 31
     */
    function nombreJoursMois($intMois,$intAnnee){
        return date("t",  mktime(0,0,0,$intMois,1,$intAnnee));
    }
    
    /*
     * nombreJoursEntreDeuxDates (03-02-2017)
     * ($strDate1, $strDate2)
     * minimum = 14 décembre 1901 / format libre
     */
    function nombreJoursEntreDeuxDates($strDate1, $strDate2){
        return abs(round((date("U",  strtotime($strDate1)) - date("U", strtotime($strDate2))) / 86400));
    }
    
    /*
   |----------------------------------------------------------------------------------|
   | ouvreFichier() (2017-03-11)
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
    
    /*
    * post (15-02-2017)
    * ($strNomParametre) valeur parametre ou null
    */
    function post($strNomParametre){
       return isset($_POST[$strNomParametre]) ? $_POST[$strNomParametre] : null;
    }
?>
