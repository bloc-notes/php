<?php
/*Philippe Doyon*/
    
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
     * Falide (08-02-2017)
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
     * encadre (10-02-2017)
     * ($strChaine,$strCaracteres)
     * Encadre du ou des deux caractère voulue (symbole)
     */
    function encadre($strChaine,$strCaracteres){
        return strlen($strCaracteres) == 1? $strCaracteres.$strChaine.$strCaracteres:gauche($strCaracteres, 1).$strChaine.droite($strCaracteres, 1);
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
     * gauche (10-02-2017)
     * ($strChaine, $intLargeur)
     * Caractère a partir de la gauche (si nombre plus grand que le nombre de caractere, affiche tout)
     */
    function gauche($strChaine, $intLargeur){
	$intNbCaractere = strlen($strChaine);
	return $intLargeur>=$intNbCaractere?$strChaine:substr($strChaine,0,$intLargeur);
    }
    
    /*
    * get (15-02-2017)
    * ($strNomParametre) valeur parametre ou null
    */
    function get($strNomParametre){
        return isset($_GET[$strNomParametre]) ? $_GET[$strNomParametre] : null;
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
     * minimum = 14 décembre 1901
     */
    function nombreJoursEntreDeuxDates($strDate1, $strDate2){
        return abs((date("U",  strtotime($strDate1)) - date("U", strtotime($strDate2))) / 86400);
    }
    
    /*
    * post (15-02-2017)
    * ($strNomParametre) valeur parametre ou null
    */
    function post($strNomParametre){
       return isset($_POST[$strNomParametre]) ? $_POST[$strNomParametre] : null;
    }
?>
