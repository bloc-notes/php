<?php
    //Philippe Doyon

    echo "Laboratoire 2<br />";
    
    //Date courante avec date()
    $strDate = date("d-m-Y");
    echo "Nous sommes le $strDate.<br /><br />";
    
    /* 1 technique Récupération J,M et A avec date()*/
    $strJour = date("d");var_dump($strJour);echo "<br />";
    $strMois = date("m");var_dump($strMois);echo "<br />";
    $strAnnee = date("Y");var_dump($strAnnee);echo "<br />";
    
    /*convertie de chaines a entier*/
    $intJour = intval($strJour);var_dump($intJour);echo "<br />";
    $intMois = intval($strMois);var_dump($intMois);echo "<br />";
    $intAnnee = intval($strAnnee);var_dump($intAnnee);echo "<br />";
    
    /*affiche date*/
    echo "Nous somme le $strJour-$strMois-$strAnnee.<br />";
    echo "Nous sommes le $intJour-$intMois-$intAnnee.<br />";
    
    /* 2e technique extraction J,M et A de $strDate*/
    $intJour2 = intval(substr($strDate, 0,2));
    $intMois2 = intval(substr($strDate, 3,2));
    $intAnnee2 = intval(substr($strDate, 6,4));
    
    /*affiche date*/
    echo "Nous sommes le $intJour2-$intMois2-$intAnnee2.<br /><br />";
    
    /*
     * convertitSousChaineEnEntier (2017-01-27)
     */
    function convertirSousChaineEnEntier($strChaine,$intDepart,$intLongueur){
        $intEntier = intval(substr($strChaine,$intDepart,$intLongueur));
        return $intEntier;
    }
    
    $intJour3 = convertirSousChaineEnEntier($strDate, 0, 2);
    $intMois3 = convertirSousChaineEnEntier($strDate, 3, 2);
    $intAnnee3 = convertirSousChaineEnEntier($strDate, 6, 4);
    
    //Affichage date
    echo "Nous sommes le $intJour3-$intMois3-$intAnnee3.<br /><br />";
    
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
    
    $intJour4;
    $intMois4;
    $intAnnee4;
    /*Extraction a partir de la date courante*/
    extraitJJMMAAAA($intJour4, $intMois4, $intAnnee4);
    echo "Nous somme le $intJour4-$intMois4-$intAnnee4.<br /><br />";
    
    $intJour5;
    $intMois5;
    $intAnnee5;
    $strDate5 = "31-12-2017";
    /*extrait a partir d'une date spécifique*/
    extraitJJMMAAAA($intJour5, $intMois5, $intAnnee5, $strDate5);
    echo "Nous ne sommes pas le $intJour5-$intMois5-$intAnnee5.<br /><br />";
    
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
    
    for($i=0;$i<=13;$i++){
        echo moisEnLitteral($i) . ", " . moisEnLitteral($i, false) . ", " .
        moisEnLitteral($i, true) . "<br />";
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
    
    for($i=0; $i<=8; $i++){
        echo jourSemaineEnLitteral($i) . ", " .
        jourSemaineEnLitteral($i, false) .  ", " .
        jourSemaineEnLitteral( $i, true) . "<br />";
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
    
    echo "<br />";
    echo er(1) . ", ";
    echo er(1,false) . ", ";
    echo er(1, true) . "<br />";
    echo er(31) . ", ";
    echo er(31, false) . ", ";
    echo er(31, true) . "<br />";
    
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
    
    $intJour6;
    $intMois6;
    $intAnnee6;
    $intJourSemaine6;
    /*Date courante*/
    echo "<br />";
    extraitJSJJMMAAAA($intJourSemaine6, $intJour6, $intMois6, $intAnnee6);
    echo "Nous sommes le " . jourSemaineEnLitteral($intJourSemaine6) . " " .
     er($intJour6) . " " . moisEnLitteral($intMois6)." $intAnnee6.<br /><br />";
    
    $intJour7;
    $intMois7;
    $intAnnee7;
    $intJourSemaine7;
    /*Date spécifique*/
    for($i=1;$i<=31; $i++){
        extraitJSJJMMAAAA($intJourSemaine7, $intJour7, $intMois7, $intAnnee7,
                ($i<10?"0":"")."$i-01-2017");
        echo "Nous somme le " . jourSemaineEnLitteral($intJourSemaine7) . " " .
        er($intJour7) . " " . moisEnLitteral($intMois7)." $intAnnee7.<br />";
    }
