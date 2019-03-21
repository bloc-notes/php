<?php
    //Philippe Doyon (20-03-2018)
    
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
    
    /*----------------------
     * ajouteZeros (08-02-18)
     * ---------------------
     */
     function ajouteZeros($numValeur, $intLargeur){
         $strFormat = "%0" . $intLargeur . "d";
         return sprintf($strFormat, $numValeur);
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

    /*
     * ---------------------------------------
     * convertitSousChaineEnEntier (29-01-2018)
     * ---------------------------------------
     */
    function convertitSousChaineEnEntier($strChaine, $intDepart, $intLongueur){
        $intEntier = intval(substr($strChaine, $intDepart,$intLongueur));
        return $intEntier;
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

    /* ------------------------------------------
     * dateValide v2 (15-02-2018)
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
        return (dateValideComplet($strDate) && checkdate($intMois, $intJour, $intAnnee));
    }

    /*---------------------------------------------------------------------------------------------
     * dateValideComplet (15-02-2018)
     * 
     * Fonctionne en jj-mm-aaaa ou aaaa-mm-jj
     * https://stackoverflow.com/questions/13194322/php-regex-to-check-date-is-in-yyyy-mm-dd-format
     * --------------------------------------------------------------------------------------------
     */
    function dateValideComplet($strDate){
        if(substr($strDate, 2, 1) == "-"){
            $dt = DateTime::createFromFormat("d-m-Y", $strDate);
        }
        else{
            $dt = DateTime::createFromFormat("Y-m-d", $strDate);
        }
        return ($dt !== false && !array_sum($dt->getLastErrors()));
    }
    
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
    
    function detecteServeur(&$strMonIP, &$strIPServeur, &$strNomServeur, &$strInfosSensibles) {
        $strMonIP = $_SERVER["REMOTE_ADDR"];
        $strIPServeur = $_SERVER["SERVER_ADDR"];
        $strNomServeur = $_SERVER["SERVER_NAME"];
        $strInfosSensibles = str_replace(".", "-", $strNomServeur) . ".php";
    }
    
    /*------------------------------------------------------------------------
     * dollar (24-02-2018) Projet1
     * Mise à jour de formatNombre avec le choix du nombre de décimal
     * Scénario : par défaut, le nombre de chiffre après la virgule sera de 2
     * 
     * Retour: Nombre en format monétaire.
     * Exemple: 1250 -> 1 250
     * -----------------------------------------------------------------------
     */
    function dollar($fltValeur, $intNbChiffreApresDecimal = 2) {
        return number_format(floatval($fltValeur), $intNbChiffreApresDecimal, ",", " ") . " $";
    }
    
    /*-----------------------------------------------------------------------***
     * dollarParentheses (24-02-2018) Projet 1
     * Scénario : par défaut, le nombre de chiffre après la virgule sera de 2
     * 
     * Retour: Nombre en format monétaire. Si négatif, il va être 
     *         encadré de parenthèses.
     * Exemple: -1250 -> (1 250)
     * ----------------------------------------------------------------------***
     */
    function dollarParentheses($fltValeur, $intNbChiffreApresDecimal = 2){
        $strRetour = "";
        if($fltValeur < 0) {
            $strRetour = "(" . number_format(floatval(-$fltValeur), $intNbChiffreApresDecimal, ",", " ") . ") $";
        }
        else {
            $strRetour = number_format(floatval($fltValeur), $intNbChiffreApresDecimal, ",", " ") . " $";
        }
        return $strRetour;
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
    
    /*---------------------------------------------------
     * encadre (10-02-2017)
     * ($strChaine,$strCaracteres)
     * Encadre du ou des deux caractère voulue (symbole)
     * --------------------------------------------------
     */
    function encadre($strChaine,$strCaracteres){
        return strlen($strCaracteres) == 1? $strCaracteres.$strChaine.$strCaracteres:gauche($strCaracteres, 1).$strChaine.droite($strCaracteres, 1);
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
    
    /*-------------------------------------------------------------------******
     * formateNombre (23-20-2018) projet 1
     * 
     * Applique le format d'affichage standard des nombres avec un espace 
     * dépassé la centaine
     * exemple : 1 250 au lieu de 1250
     * ------------------------------------------------------------------******
     */
    function formateNombre($fltValeur) {
        return number_format(floatval($fltValeur), 2, ",", " ");
    }
    
    /*------------------------------------------------------------------------
    * genereNomUtilisateur (02-05-2018)
    * 
    * But: À partir d'un nom complet (Nom, Prénom), le nom d'utilisateur est 
    *      former selon le format (p.nom)
    * -----------------------------------------------------------------------
    */
    function genereNomUtilisateur($strNomcomplet) {
        list($strNom, $strPrenom) = explode(",", $strNomcomplet);
        $strPrenom = trim($strPrenom);

        $tabPrenom = multiexplode(array("-", "'", " "), $strPrenom);

        $strNomUtilisateur = (count($tabPrenom) == 1) ? gauche($tabPrenom[0], 1) : minuscules(gauche($tabPrenom[0], 1)) . minuscules(gauche($tabPrenom[1], 1));
        $strNomUtilisateur .= "." . minuscules($strNom);

        var_dump($strNomUtilisateur);
        return $strNomUtilisateur;
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

    /*------------------------------------
     * get (12-02-2018)
     * Retour: Valeur du paramètre ou null
     * -----------------------------------
     */
    function get($strNomParametre){
        return $_GET[$strNomParametre] ?? null;
    }
    
    /*------------------------------------------------------------------
     * hierOuDemain (24-02-2018) projet 1
     * 
     * Scénario: Demain est la date par défaut qui sera retournée
     * Retour: La date d'hier ou demain selon la date passer en argument
     * -----------------------------------------------------------------
     */
    function hierOuDemain($strDate, $booDemain = true) {
        $dtDate = new DateTime($strDate);
        return date_format($dtDate->{($booDemain ? 'add':'sub')}(new DateInterval('P1D')), 'Y-m-d');
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
        return ajouteZeros($intJour, 2) . "-" . ajouteZeros($intMois, 2) . "-" .
        ajouteZeros($intAnnee, 4);
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
    
    /*--------------------------------------------------------------------******
     * jourSemaineEnLitteralDate (24-02-2018) projet 1
     * 
     * Paramètre : String
     * retour: le jour en littéral en Majuscule selon la date fournie
     * -------------------------------------------------------------------******
     */
    function jourSemaineEnLitteralDate($strDate){
        $intNoJour = date("N", strtotime($strDate));
        return jourSemaineEnLitteral($intNoJour, true);
    }
    
    /*--------------------------------------------------------------------******
     * jourSemaineEnLitteralDateTime (23-02-2018) projet 1 ...
     * 
     * Paramètre : objet datetime
     * retour: le jour en littéral en Majuscule selon la date fournie
     * Exception: Le paramètre doit oblifatoirement être un objet DateTime
     * -------------------------------------------------------------------******
     */
    function jourSemaineEnLitteralDateTime(DateTime $dtDate){
        $intNoJour = date("N", strtotime(date_format($dtDate,'Y-m-d')));
        return jourSemaineEnLitteral($intNoJour, true);
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
    
    /*--------------------------------------------------------------
     * mois (12-02-2018)
     * Extrait le mois d'une date en format jj-mm-aaaa ou aaaa-mm-jj
     * -------------------------------------------------------------
     */
    function mois($strDate){
        return (substr($strDate, 2, 1) == "-") ? intval(substr($strDate, 3, 2)) :
                intval(substr($strDate, 5, 2));
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
    
    /*--------------------------------------------------------------
     * multiexplode (04-05-2018)
     * 
     * Source: http://php.net/manual/fr/function.explode.php#111307
     * 
     * Paramètre: Les délimiteurs doivent être dans un array
     * But: Permet d'utiliser plusieur séparateur différent
     * Retour: Un tableau divisé selon les séparateurs
     * -------------------------------------------------------------
     */
    function multiexplode(array $separateur, $donnee) {
        $donneSeparateurHarmonisee = str_replace($separateur, $separateur[0], $donnee);
        $donneeDivise = explode($separateur[0], $donneSeparateurHarmonisee);
        
        return $donneeDivise;
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

    /* ---------------------------------------
     * nombreJoursEntreDeuxDates (08-02-2018) (24-02-2018) gestion négatif
     * Retour : Date2 - Date1 => En jours
     * Date minimale = 14-12-1901
     * -Les dates doivent être dans le même format.-
     * --------------------------------------
     */
    function nombreJoursEntreDeuxDates($strDate1, $strDate2) {
        $intNoSerie1 = strtotime($strDate1) / 86400;
        $intNoSerie2 = strtotime($strDate2) / 86400;
        return round($intNoSerie2 - $intNoSerie1);
    }

    /* -----------------------------
     * nombreJoursMois (08-02-2018)
     * retour possible : 28 à 31
     * ----------------------------
     */
    function nombreJoursMois($intMois, $intAnnee) {
        return date("t", mktime(0, 0, 0, $intMois, 1, $intAnnee));
    }

    /*------------------------------------
     * post (12-02-2018)
     * Retour: Valeur du paramètre ou null
     * -----------------------------------
     */
    function post($strNomParametre){
        return  $_POST[$strNomParametre] ?? NULL;
    }
    
    /*------------------------------------------------------------------------
     * pourcent (28-02-2018)
     * Scénario: la nombre de décimal après la virgule par défaut est de deux.
     * 
     * Retour: Le nombre en format de pourcentage
     * -----------------------------------------------------------------------
     */
    function pourcent($fltValeur, $intNbDecimal = 2) {
	return number_format(floatval($fltValeur) * 100, $intNbDecimal, ",", " ") . " %";
    }
    
    /*-----------------------------------------------------------------
     * request (29-03-2018)
     * Retour: Valeur du paramètre (qu'il soit de Get ou Post) ou null
     * ----------------------------------------------------------------
     */
    function request($strNomParametre) {
        return $_REQUEST[$strNomParametre] ?? NULL;
    }