<?php
require_once "librairies-communes-2018-05-04-Doyon.php";

class validation {

    public static function valid_nomUtilisateurTest($strNomUtil, $strNomCompet) {
        $booValide = false;
        
        if (genereNomUtilisateur($strNomCompet) === $strNomUtil) {
            $booValide = true;
        }
        
        return $booValide;
    }
    
    public static function valid_NomUtilisateur($strNomUtil) {
        $booValide = false;
        $strReg = "/^[a-z]{1,2}[.][a-z]+$/";
        
        if (preg_match($strReg, $strNomUtil) && (strlen($strNomUtil) <= 25)) {
            $booValide = true;
        }
        
        return $booValide;
    }

    public static function valid_MDP($strDonnee) {
        $strRegMDP = "/^[\w]{3,15}$/mu";
        $booValide = preg_match($strRegMDP, $strDonnee);

        return $booValide;
    }

    public static function valid_NomComplet($strDonnee) {
        $booValide = false;
        
        if ($strDonnee != "") {
            $tabPrenomNom = explode(",", $strDonnee);
            $strNom = $tabPrenomNom[0];
            $strPrenom = trim($tabPrenomNom[1]);
            $strRegPrenomNom = "/^[\p{Lu}](([\'\- ][\p{Ll}])|[\p{Ll}])+$/mu"; //echo iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $string); http://stackoverflow.com/questions/10152894/php-replacing-special-characters-like-a-a-e-e?answertab=votes#tab-top

            if (preg_match($strRegPrenomNom, $strNom) && preg_match($strRegPrenomNom, $strPrenom) && preg_match("/, /", $strDonnee) && preg_match("/^.{5,30}$/m", $strDonnee)) {
                $booValide = true;
            }
        }
        return $booValide;
    }

    public static function valid_Courriel($strDonnee) {
        $booValide = false;
        $strRegCourriel = "/^.{10,50}$/m";

        if (filter_var($strDonnee, FILTER_VALIDATE_EMAIL) && preg_match($strRegCourriel, $strDonnee)) {
            $booValide = true;
        }

        return $booValide;
    }
    
    public static function valid_ChiffreLettreNbCarac($strDonnee, $intMin, $intMax) {
        $strReg = "/^[\w]{" . $intMin . "," . $intMax . "}$/mu";
        
        $booValide = preg_match($strReg, $strDonnee);
        
        return $booValide;
    }
    
    public static function valid_Sigle($strDonnee) {
        $strReg = "/^[\d]{3}-[\w]{3}$/m";
        $strRegAdm = "/^[A][D][M][-][\w]{3}$/m";
        $booValide = (preg_match($strReg, $strDonnee) || preg_match($strRegAdm, $strDonnee));
        
        return $booValide;
    }
}
