<?php
    /*librairie-date-doyon.php  Philippe Doyon  31-01-2018*/
    
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
    
    /*--------------------------------------------------------------------------
     * JJMMAAAA (01-02-18)
     * Scénario : ($intJour, $intMois, $intAnnee) => "jj-mm-aaaa"
     *             Si $intAnnee a deux chiffres
     *                Si $intAnnee <= 20 => 2000 à 2020 autrement => 1921 à 1999
     * ------------------------------------------------------------------------- 
     */
    function JJMMAAAA($intJour,$intMois,$intAnnee){     
        $intAnnee = $intAnnee <= 20 ? 2000 + $intAnnee : 
                ($intAnnee <= 99 ? 1900 + $intAnnee : $intAnnee);
        return ajouteZero($intJour, 2) . "-" . ajouteZero($intMois, 2) . "-" .
        ajouteZero($intAnnee, 4);
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
    
    /*
     * --------------------------------------------------------------------
     * moisEnLitteralSansAccent (01-02-2018)
     * Scénario : ($intMois)                => Première lettre en miniscule
     *            ($intMois, $binMajuscule) => En fonction de $binMajuscule
     * --------------------------------------------------------------------
     */
    function moisEnLitteralSansAccent($intMois, $binMajuscule=false){
        /* Par défault, la première lettre du mois s'affiche en minuscule ($binMajuscule=false)
         * Si un deuxième argument est saisi, il déterminera si la première lettre doit
         * s'afficher en majuscule ou non
         */
        $strMois = "N/A";
        switch ($intMois){
            case 1 : $strMois = "janvier";break;
            case 2 : $strMois = "fevrier";break;
            case 3 : $strMois = "mars";break;
            case 4 : $strMois = "avril";break;
            case 5 : $strMois = "mai";break;
            case 6 : $strMois = "juin";break;
            case 7 : $strMois = "juillet";break;
            case 8 : $strMois = "aout";break;
            case 9 : $strMois = "septembre";break;
            case 10: $strMois = "octobre";break;
            case 11: $strMois = "novembre";break;
            case 12: $strMois = "decembre";break;
        }
        $strMois = $binMajuscule ? ucfirst($strMois) : $strMois;
        return $strMois;
    }
?>