<?php

/* -----------------------------------
 * aujourdhui (08-02-2018)
 * Scénario: () ou True => aaaa-mm-jj
 *           False => jj-mm-aaaa
 * ----------------------------------
 */

function aujourdhui($binAAAAMMJJ = TRUE) {
    return $binAAAAMMJJ ? date("Y-m-d") : date("d-m-Y");
}

/* ----------------------------------------
 * bissextile (08-02-2018)
 * Scénario: Année bissextile => True
 *           Année non Bissextile => False
 * ---------------------------------------
 */

function bissextile($intAnnee) {
    return date("L", mktime(0, 0, 0, 1, 1, $intAnnee)) == 1 ? true : false;
}

/* --------------------------------
 * nombreJoursAnnee (08-02-2018)
 * Scénario: Bissextile => 366
 *           Non bissextile => 365
 * -------------------------------
 */

function nombreJoursAnnee($intAnnee) {
    return bissextile($intAnnee) ? 366 : 365;
}

/* -----------------------------
 * nombreJoursMois (08-02-2018)
 * retour possible : 28 à 31
 * ----------------------------
 */

function nombreJoursMois($intMois, $intAnnee) {
    return date("t", mktime(0, 0, 0, $intMois, 1, $intAnnee));
}

/* ---------------------------------------
 * nombreJoursEntreDeuxDates (08-02-2018)
 * Retour : Date2 - Date1 => En jours
 * Date minimale = 14-12-1901
 * -Les dates doivent être dans le même format.-
 * --------------------------------------
 */

function nombreJoursEntreDeuxDates($strDate1, $strDate2) {
    //$strDate = ///explode - strtotime - datediff
    // $dtDate1 = new DateTime(strtotime())
    return abs((date("U", strtotime($strDate1)) - date("U", strtotime($strDate2))) / 86400);
}

/* ----------------------------------------------
 * extraitJSJJMMAAAAv2 (12-02-2018)
 * $strDate -> Paramètre optionnel
 * Mise à jours : date peut être dans les 2 sens
 * ---------------------------------------------
 */

function extraitJSJJMMAAAAv2(&$intJourSemaine, &$intJour, &$intMois, &$intAnnee) {
    if (func_num_args() == 4) {
        /* Récupération de la date courante */
        $strDate = date("d-m-Y");
        $intJourSemaine = date("N");
    } else {
        /* Récupération du 5e argument */
        $strDate = func_get_arg(4);
        $intJourSemaine = date("N", strtotime($strDate));
    }

    if (substr($strDate, 2, 1) == "-") {
        $intJour = intval(substr($strDate, 0, 2));
        $intMois = intval(substr($strDate, 3, 2));
        $intAnnee = intval(substr($strDate, 6, 4));
    } else {
        $intJour = intval(substr($strDate, 8, 2));
        $intMois = intval(substr($strDate, 5, 2));
        $intAnnee = intval(substr($strDate, 0, 4));
    }
}

/* ------------------------------------------
 * dateValide (12-02-2018)
 * Retour: Retourne TRUE si la date fournie est valide, FALSE sinon
 * -La date peut être dans les deux sens.-
 * -----------------------------------------
 */

function dateValide($strDate) {
    $intJour = 0;
    $intMois = 0;
    $intAnnee = 0;
    $intJourSemaine = 0;

    extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $strDate);
    return checkdate($intMois, $intJour, $intAnnee);
}

/* -----------------------------------------------------------
 * dateEnLitteral (12-02-2018)
 * Scénario: () => date jour sans semaine
 *           ($strDate) => date en argument sans semaine
 *           ("C") => date jour avec semaine
 *           ($strDate, "C") => date en argument avec semaine
 *           ("C", $strDate) => date en argument avec semaine
 * 
 * -Paramètre optionnel et pas d'ordre-
 * -----------------------------------------------------------
 */

function dateEnLitteral() {
    $intNombreArgument = func_num_args();
    $strDateTraitee = "";
    $booJourSemaine = true;
    $intJour = 0;
    $intMois = 0;
    $intAnnee = 0;
    $intJourSemaine = 0;

    if ($intNombreArgument == 0) {
        $strDateTraitee = aujourdhui(FALSE);
        $booJourSemaine = false;
    } else if ($intNombreArgument == 1) {
        if (strlen(func_get_arg(0)) == 1) {
            $strDateTraitee = aujourdhui(FALSE);
        } else {
            $strDateTraitee = func_get_arg(0);
            $booJourSemaine = FALSE;
        }
    } else {
        $strDateTraitee = (strlen(func_get_arg(0)) == 1) ? func_get_arg(1) : func_get_arg(0);
    }

    extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $strDateTraitee);

    return ($booJourSemaine ? (jourSemaineEnLitteral($intJourSemaine, true) . " ") : "") .
            er($intJour, true) . " " . moisEnLitteral($intMois) . " " . $intAnnee;
}

/*---------------------------------------------------------------------------
 * AAAAMMJJ (12-02-2018)
 * Scénario : ($intJour, $intMois, $intAnnee)
 *            ($strDate) => jj-mm-aaaa ou jj-mm-aa
 *             Si $intAnnee ou l'annee a deux chiffres
 *                Si $intAnnee <= 20 => 2000 à 2020 autrement => 1921 à 1999
 * --------------------------------------------------------------------------
 */
function AAAAMMJJ($strDate){
    $intJour = 0;
    $intMois = 0;
    $intAnnee = 0;
    
    if(func_num_args() == 1){
        list($intJour,$intMois,$intAnnee) = explode("-", $strDate);
    }
    else{
        $intJour = func_get_arg(0);
        $intMois = func_get_arg(1);
        $intAnnee = func_get_arg(2);
    }
    
    $intAnnee = $intAnnee <= 20 ? 2000 + $intAnnee : 
                ($intAnnee <= 99 ? 1900 + $intAnnee : $intAnnee);
    
    return ajouteZeros($intAnnee, 4) . "-" . ajouteZeros($intMois, 2) . "-" . 
            ajouteZeros($intJour, 2);
}

/*------------------------------------
 * get (12-02-2018)
 * Retour: Valeur du paramètre ou null
 * -----------------------------------
 */
function get($strNomParametre){
    return isset($_GET[$strNomParametre]) ? 
            $_GET[$strNomParametre] : NULL;
}

/*------------------------------------
 * post (12-02-2018)
 * Retour: Valeur du paramètre ou null
 * -----------------------------------
 */
function post($strNomParametre){
    return isset($_POST[$strNomParametre]) ? 
            $_POST[$strNomParametre] : NULL;
}

/*--------------------------------------------------------------
 * input (12-02-2018)
 * Génère une balise input <input type="text">
 * $binECHO = true -> N'est pas appeler depuis une fonction ECHO
 * -------------------------------------------------------------
 */
function input($strID, $strCLASS, $strMAXLENGHT, $strVALUE, $binECHO=false){
    $strCode = "<input id=\"" . $strID . "\" name=\"" . $strID . "\" class=\"" .
            $strCLASS . "\" type=\"text\" maxlength=\"" . $strMAXLENGHT . 
            "\" value=\"" . $strVALUE . "\" />";
    
    if(func_num_args() == 5){
        if(func_get_arg(4) == true){
            echo $strCode;
        }
        else{
            return $strCode;
        }
    }
    else{
        return $strCode;
    }
}

/*--------------------------------------------------------------
 * annee (12-02-2018)
 * Extrait l'année d'une date en format jj-mm-aaaa ou aaaa-mm-jj
 * -------------------------------------------------------------
 */
function annee($strDate){
    return (substr($strDate, 2, 1) == "-") ? substr($strDate, 6, 4) :
        substr($strDate, 0, 4);
}

/*--------------------------------------------------------------
 * mois (12-02-2018)
 * Extrait le mois d'une date en format jj-mm-aaaa ou aaaa-mm-jj
 * -------------------------------------------------------------
 */
function mois($strDate){
    return (substr($strDate, 2, 1) == "-") ? intval(substr($strDate, 3, 2)) :
            intval(substr($strDate, 5, 2));
}

/*--------------------------------------------------------------
 * jour (12-02-2018)
 * Extrait le jour d'une date en format jj-mm-aaaa ou aaaa-mm-jj
 * -------------------------------------------------------------
 */
function jour($strDate){
    return (substr($strDate, 2, 1) == "-") ? intval(substr($strDate, 0, 2)) :
            intval(substr($strDate, 8, 2));
}