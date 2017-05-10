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
?>
