<?php
    
    require_once "librairie-date-doyon.php";
    require_once "librairie-generale-doyon.php";

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
    
    $intJour3 = convertitSousChaineEnEntier($strDate, 0, 2);
    $intMois3 = convertitSousChaineEnEntier($strDate, 3, 2);
    $intAnnee3 = convertitSousChaineEnEntier($strDate, 6, 4);
    
    /* Affichage de la date*/
    echo "Nous sommes le $intJour3-$intMois3-$intAnnee3.<br /><br />";
    
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
    
    for($i=0; $i<=13; $i++){
        echo moisEnLitteral($i) . ", " . moisEnLitteral($i,FALSE) . ", " .
        moisEnLitteral($i, TRUE) . "<br />";
    }
    
    echo "<br />";
    
    for($i=0; $i<=8; $i++){
        echo jourSemaineEnLitteral($i) . ", " . 
        jourSemaineEnLitteral($i, FALSE) . ", " .
        jourSemaineEnLitteral($i,TRUE) . "<br />";
    }
    
    echo "<br />";
    echo er(1) . ", ";
    echo er(1, FALSE) . ", ";
    echo er(1, TRUE) . "<br />";
    echo er(31) . ", ";
    echo er(31, FALSE) . ", ";
    echo er(31, true) . "<br />";
    
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