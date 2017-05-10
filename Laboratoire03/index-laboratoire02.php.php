 <?php
    //Philippe Doyon

    echo "Laboratoire 3<br />";
    
    require_once "librairie-date.php";
    require_once "librairie-general.php";
    
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
    
    
    
    $intJour3 = convertirSousChaineEnEntier($strDate, 0, 2);
    $intMois3 = convertirSousChaineEnEntier($strDate, 3, 2);
    $intAnnee3 = convertirSousChaineEnEntier($strDate, 6, 4);
    
    //Affichage date
    echo "Nous sommes le $intJour3-$intMois3-$intAnnee3.<br /><br />";
    
    
    
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
    
    
    
    for($i=0;$i<=13;$i++){
        echo moisEnLitteral($i) . ", " . moisEnLitteral($i, false) . ", " .
        moisEnLitteral($i, true) . "<br />";
    }
    
    
    
    for($i=0; $i<=8; $i++){
        echo jourSemaineEnLitteral($i) . ", " .
        jourSemaineEnLitteral($i, false) .  ", " .
        jourSemaineEnLitteral( $i, true) . "<br />";
    }
    
    
    
    echo "<br />";
    echo er(1) . ", ";
    echo er(1,false) . ", ";
    echo er(1, true) . "<br />";
    echo er(31) . ", ";
    echo er(31, false) . ", ";
    echo er(31, true) . "<br />";
    
    
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
