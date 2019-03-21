<?php

    $strTitreApplication = "Exercice 3";
    $strNomFichierCSS = "index.css";
    $strNomAuteur = "Philippe Doyon";
    $strModeTransmission = isset($_GET["Mode"]) ? $_GET["Mode"] : "get";
    
    
    /*---------------------------------------------------------------------------------
     * decomposeURL (16-03-2018)
     * 
     * But: Décompose une adresse en chemin, nom et suffixe.
     *      Les 3 derniers paramètres doivent être déclaré avant l'appel de la fonction,
     *      mais pas instanciés.
     * ---------------------------------------------------------------------------------
     */
    function decomposeURL($strURL, &$strChemin, &$strNom, &$strSuffixe) {
        $tabURL = pathinfo($strURL);
         
        $strChemin = $tabURL['dirname'];
        $strNom = $tabURL['filename'];
        $strSuffixe = $tabURL['extension'];
    }
    
    /*--------------------------------------------------------------------
     * droite (16-03-2018)
     * 
     * But: Retourne le nombre de caractère demandé à partir de la droite.
     * -------------------------------------------------------------------
     */
    function droite($strChaine, $intLargeur) {
        return strrev(substr(strrev($strChaine), 0 ,$intLargeur));
    }
    
    /*--------------------------------------------------------------------
     * ecrit (16-03-2018)
     * 
     * Scénario: Le deuxième paramètre est optionnel et par défaut = 0
     * 
     * But: ajoute des "<br />" x fois a la fin de la chaîne de caractère.
     * -------------------------------------------------------------------
     */
    function ecrit($strChaine, $intNbBr=0) {
        echo $strChaine . str_repeat("<br />", $intNbBr);
    }
    
    /*--------------------------------------------------------
     * estNumerique (16-03-2018)
     * 
     * Remarque: aucune distinction entre virgule et un point
     * -------------------------------------------------------
     */
    function estNumerique($strValeur) {
        return is_numeric(str_replace(",", ".", $strValeur));
    }
    
    /*--------------------------------------------------------------------------
     * etatCivilValide (20-03-2018)
     * 
     * But: valide État civi (c/f/m/s/d ou v)
     *      Sexe (h ou f)
     *      Autant majuscule que minuscule pour etat ou sexe
     * retour: État civil sous forme littéral et un booléen pour la validation
     * Paramètre: Le troisième paramètre doit être déclarer avant l'appel de la
     *            fonction.
     * -------------------------------------------------------------------------
     */
    function etatCivilValide($chrEtat, $chrSexe, &$strEtatCivil) {
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
    
    /*--------------------------------------------------------------------
     * gauche (20-03-2018)
     * 
     * But: Retourne le nombre de caractère demandé à partir de la gauche.
     * -------------------------------------------------------------------
     */
    function gauche($strChaine, $intLargeur) {
        return substr($strChaine, 0 ,$intLargeur);
    }
    
    /*-------------------------------------------
     * majuscules (20-03-2018)
     * 
     * retour: la chaine en paramètre en majuscule
     * -------------------------------------------
     */
    function majuscules($strChaine) {
        return mb_strtoupper($strChaine,"UTF-8");
    }
    
    /*-------------------------------------------
     * minuscules (20-03-2018)
     * 
     * retour: la chaine en paramètre en minuscule
     * -------------------------------------------
     */
    function minuscules($strChaine) {
        return mb_strtolower($strChaine, "UTF-8");
    }
    
    require_once "en-tete.php";
    
    //1) decomposeURL
    $strChemin;
    $strNom;
    $strSuffixe;
    
    $strTest = "http://424w.cgodin.qc.ca/test/index.php";
    $strTest2 = "laboratoire02.txt";
    
    decomposeURL($strTest2, $strChemin, $strNom, $strSuffixe);
    
    echo $strChemin . " " . $strNom ." " . $strSuffixe . "<br />";
    
    //2) droite
    echo droite("index.php", 3) . "<br />";
    echo droite("03-02-2018", 7) . "<br />";
    
    //3) ecrit
    ecrit("Salut");
    ecrit("Salut", 1);
    ecrit("Salut", 2);
    
    //4) estNumerique
    var_dump(estNumerique("9"));
    var_dump(estNumerique("9b"));
    var_dump(estNumerique("9,99"));
    var_dump(estNumerique("9.99"));
    
    //5) etatCivilValide
    $strEtat;
    
    echo etatCivilValide("M", "F", $strEtat) . " : " . $strEtat . "<br />";
    echo etatCivilValide("S", "h", $strEtat) . " : " . $strEtat . "<br />";
    echo etatCivilValide("A", "h", $strEtat) . " : " . $strEtat . "<br />";
    
    //6) gauche
    echo gauche("index.php", 3) . "<br />";
    echo gauche("03-02-2018", 5) . "<br />";
    
    //7) majuscules
    
    echo majuscules("Salut") . "<br />";
    echo majuscules("propriété") . "<br />";
    
    //8) minuscules
    
    echo minuscules("SALUT") . "<br />";
    echo minuscules("PROPRIÉTÉ") . "<br />";
    
    //echo mb_strtoupper("a-z àâäá","UTF-8");
    
    require_once "pied-page.php";
