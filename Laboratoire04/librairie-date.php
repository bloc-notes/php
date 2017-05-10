<?php

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
?>
