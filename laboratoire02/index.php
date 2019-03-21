<?php
    $strDate = date("d-m-Y");
    echo "Nous sommes le $strDate.<br /><br />";
    
    /* 1er technique : Récupération du jour, mois et année à partir de la fonction date(). */
    $strJour = date("d");var_dump($strJour);
    $strMois = date("m");var_dump($strMois);
    $strAnnee = date("Y");var_dump($strAnnee);
    /* Conversion de chaque variable chaîne en entier*/
    $intJour = intval($strJour);var_dump($intJour);
    $intMois = intval($strMois);var_dump($intMois);
    $intAnnee = intval($strAnnee);var_dump($intAnnee);
    
    /* Affichage de la date*/
    echo "Nous sommes le $strJour-$strMois-$strAnnee.<br />";
    echo "Nous sommes le $intJour-$intMois-$intAnnee.<br /><br />";
    
    /* 2e technique : Extraction du jour, mois et année à partir de $strDate*/
    $intJour2 = intval(substr($strDate, 0,2));
    $intMois2 = intval(substr($strDate, 3,2));
    $intAnnee2 = intval(substr($strDate, 6, 4));
    
    /* Affichage de la date */
    echo "Nous sommes le $intJour2-$intMois2-$intAnnee2.<br /><br />";
    
    /*
     * ---------------------------------------
     * convertitSousChaineEnEntier (29-01-2018)
     * ---------------------------------------
     */
    function convertitSousChaineEnEntier($strChaine, $intDepart, $intLongueur){
        $intEntier = intval(substr($strChaine, $intDepart,$intLongueur));
        return $intEntier;
    }
    
    $intJour3 = convertitSousChaineEnEntier($strDate, 0, 2);
    $intMois3 = convertitSousChaineEnEntier($strDate, 3, 2);
    $intAnnee3 = convertitSousChaineEnEntier($strDate, 6, 4);
    
    /* Affichage de la date*/
    echo "Nous sommes le $intJour3-$intMois3-$intAnnee3.<br /><br />";
    
    /*
     * ----------------------------------------------------------------
     * extraitJJMMAAAA (29-01-2018)
     * Scénario : ($intJour, $intMois, $intAnnee)           <= date()
     *            ($intJour, $intMois, $intAnnee, $strDate) <= $strDate
     * ----------------------------------------------------------------
     */
    function extraitJJMMAAAA(&$intJour, &$intMois, &$intAnnee){
        /* Par défaut, l'extraction s'effectue à partir de la date courante
         * autrement elle s'effectue à partir du 4e argument spécifié à l'appel
         */
        if(func_num_args() == 3){
            /* Récupération de la date courante*/
            $strDate = date("d-m-Y");
        }
        else {
            /* Récupération du 4e argument*/
            $strDate = func_get_arg(3);
        }
        $intJour = intval(substr($strDate, 0, 2));
        $intMois = intval(substr($strDate, 3,2));
        $intAnnee = intval(substr($strDate, 6,4));
    }
    
    $intJour4;
    $intMois4;
    $intAnnee4;
    /* Extraction à partir de la date courante*/
    extraitJJMMAAAA($intJour4, $intMois4, $intAnnee4);
    echo "Nous sommes le $intJour4-$intMois4-$intAnnee4.<br /><br />";
    
    $intJour5;
    $intMois5;
    $intAnnee5;
    $strDate = "31-12-2018";
    /* Extraction à partir de la date spécifiée*/
    extraitJJMMAAAA($intJour5, $intMois5, $intAnnee5,$strDate);
    echo "Nous sommes le $intJour5-$intMois5-$intAnnee5.<br /><br />";
    
    /*
     * --------------------------------------------------------------------
     * moisEnLitteral (29-01-2018)
     * Scénario : ($intMois)                => Première lettre en miniscule
     *            ($intMois, $binMajuscule) => En fonction de $binMajuscule
     * --------------------------------------------------------------------
     */
    function moisEnLitteral($intMois, $binMajuscule=false){
        /* Par défault, la première lettre du mois s'affiche en minuscule ($binMajuscule=false)
         * Si un deuxième argument est saisi, il déterminera si la première lettre doit
         * s'afficher en majuscule ou non
         */
        $strMois = "N/A";
        switch ($intMois){
            case 1 : $strMois = "janvier";break;
            case 2 : $strMois = "f&eacute;vrier";break;
            case 3 : $strMois = "mars";break;
            case 4 : $strMois = "avril";break;
            case 5 : $strMois = "mai";break;
            case 6 : $strMois = "juin";break;
            case 7 : $strMois = "juillet";break;
            case 8 : $strMois = "ao&ucirc;t";break;
            case 9 : $strMois = "septembre";break;
            case 10: $strMois = "octobre";break;
            case 11: $strMois = "novembre";break;
            case 12: $strMois = "d&eacute;cembre";break;
        }
        /*
         * if ($binMajuscule)
         *    $strMois = ucfist($strMois);
         */
        $strMois = $binMajuscule ? ucfirst($strMois) : $strMois;
        return $strMois;
    }
    
    for($i=0; $i<=13; $i++){
        echo moisEnLitteral($i) . ", " . moisEnLitteral($i,FALSE) . ", " .
        moisEnLitteral($i, TRUE) . "<br />";
    }
    
    /*-----------------------------------------------------------------------
     * jourSemaineEnLitteral (29-01-18)
     * Scénario : ($intNoJour)                => Première lettre en miniscule
     *            ($intNoJour, $binMajuscule) => En fonction de $binMajuscule
     * ----------------------------------------------------------------------
     */
    function jourSemaineEnLitteral($intNoJour, $binMajuscule=FALSE){
        $strJour = "N/A";
        switch ($intNoJour){
            case 1 : $strJour = "lundi";break;
            case 2 : $strJour = "mardi";break;
            case 3 : $strJour = "mercredi";break;
            case 4 : $strJour = "jeudi";break;
            case 5 : $strJour = "vendredi";break;
            case 6 : $strJour = "samedi";break;
            case 7 : $strJour = "dimanche";break;
        }
        
        $strJour = $binMajuscule ? ucfirst($strJour) : $strJour;
        return $strJour;
    }
    
    echo "<br />";
    
    for($i=0; $i<=8; $i++){
        echo jourSemaineEnLitteral($i) . ", " . 
        jourSemaineEnLitteral($i, FALSE) . ", " .
        jourSemaineEnLitteral($i,TRUE) . "<br />";
    }
    
    /*---------------------------------------------------------------------
     * er (29-01-18)
     * Scénario : ($intEntier)                => Er en exposant
     *            ($intEntier, $binExposant) => En fonction de $binExposant
     * --------------------------------------------------------------------
     */
    function er($intEntier, $binExposant=TRUE){
        return $intEntier . ($intEntier == 1 ? ($binExposant ? "<sup>er</sup>"
                : "er" ) : "");
    }
    
    echo "<br />";
    echo er(1) . ", ";
    echo er(1, FALSE) . ", ";
    echo er(1, TRUE) . "<br />";
    echo er(31) . ", ";
    echo er(31, FALSE) . ", ";
    echo er(31, true) . "<br />";
    
    /*----------------------------------------------------------------------------------
     * extraitJSJJMMAAAA (30-01-18)
     * Scénario : ($intJourSemaine, $intJour, $intMois, $intAnnee)           <= date()
     *            ($intJourSemaine, $intJour, $intMois, $intAnnee, $strDate) <= $strDate
     * 
     * Mise à jours de extraitJJMMAAAA avec le jour de la semaine
     * ---------------------------------------------------------------------------------
     */
    function extraitJSJJMMAAAA(&$intJourSemaine, &$intJour, &$intMois, &$intAnnee){
        if(func_num_args() == 4){
            /* Récupération de la date courante*/
            $strDate = date("d-m-Y");
            $intJourSemaine = date("N");
        }
        else {
            /* Récupération du 5e argument*/
            $strDate = func_get_arg(4);
            $intJourSemaine = date("N", strtotime($strDate));
        }
        $intJour = intval(substr($strDate, 0, 2));
        $intMois = intval(substr($strDate, 3,2));
        $intAnnee = intval(substr($strDate, 6,4));
        
    }
    
    $strDate = "3-2-2018"; var_dump($strDate);
    $intDate = strtotime($strDate); var_dump($intDate);
    $strJourSemaine = date("N",$intDate); var_dump($strJourSemaine);
    
    $intJour6;
    $intMois6;
    $intAnnee6;
    $intJourSemaine6;
    /* Extraction à partir de la date courante*/
    echo "<br />";
    extraitJSJJMMAAAA($intJourSemaine6, $intJour6, $intMois6, $intAnnee6);
    echo "Nous sommes le " . jourSemaineEnLitteral($intJourSemaine6) . " " . er($intJour6)
            . " " . moisEnLitteral($intMois6) . " $intAnnee6.<br /><br />";
    
    $intJour7;
    $intMois7;
    $intAnnee7;
    $intJourSemaine7;
    /* Extraction à partir de la date spécifiée*/
    for($i=1; $i<=31; $i++){
        extraitJSJJMMAAAA($intJourSemaine7, $intJour7, $intMois7, $intAnnee7,
                ($i < 10 ? "0" : "") . "$i-01-2018");
        echo "Nous sommes le " . jourSemaineEnLitteral($intJourSemaine7) . " " .
            er($intJour7) . " " . moisEnLitteral($intMois7) . " $intAnnee7.<br />";
    }
    
?>