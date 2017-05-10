<?php
    /*
     * decomposeURL (13-02-2017)
     * ($strURL,&$strChemin,&$strNom,&$strSuffixe)
     * retourne nom du chemin, (nom du fichier ou de la page) et le suffixe
     */
     function decomposeURL($strURL,&$strChemin,&$strNom,&$strSuffixe){
         $pathURL = pathinfo($strURL);
         
         $strChemin = $pathURL['dirname'];
         $strNom = $pathURL['filename'];
         $strSuffixe = $pathURL['extension'];
    }

    /*
     * doite (10-02-2017)
     * ($strChaine, $intLargeur)
     * Caractère a partir de la droite (si nombre plus grand que le nombre de caractere, affiche tout)
     */
    function droite($strChaine, $intLargeur){
	$intNbCaractere = strlen($strChaine);
	return $intLargeur>=$intNbCaractere?$strChaine:substr($strChaine,$intNbCaractere - $intLargeur);
    }
    
    /*
     * ecrit (08-02-2017)
     * ($strChaine, $intNbBR=0)
     * Structure pour les echo
     */
    function ecrit ($strChaine, $intNbBR=0){
        $strLigne = $strChaine;
        for($intx = 0;$intNbBR!=0 && $intx<$intNbBR;$intx++){
           $strLigne.="<br />";
        }
        echo $strLigne;
    }
    /*
     * encadre (10-02-2017)
     * ($strChaine,$strCaracteres)
     * Encadre du ou des deux caractère voulue (symbole)
     */
    function encadre($strChaine,$strCaracteres){
        return strlen($strCaracteres) == 1? $strCaracteres.$strChaine.$strCaracteres:gauche($strCaracteres, 1).$strChaine.droite($strCaracteres, 1);
    }
    
    /*
     * estNumerique (10-02-2017)
     * ($strValeur)
     * true = numérique
     */
    function estNumerique($strValeur){
        return is_numeric($strValeur);
    }

    /*
     * etatCivilValide (10-02-2017)
     * ($chrEtat, $chrSexe, &$strEtatCivil)
     * true = etat valide (c,f,m,s,d,v)
     */
    function etatCivilValide($chrEtat, $chrSexe, &$strEtatCivil){
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
     * gauche (10-02-2017)
     * ($strChaine, $intLargeur)
     * Caractère a partir de la gauche (si nombre plus grand que le nombre de caractere, affiche tout)
     */
    function gauche($strChaine, $intLargeur){
	$intNbCaractere = strlen($strChaine);
	return $intLargeur>=$intNbCaractere?$strChaine:substr($strChaine,0,$intLargeur);
    }
    
    /*
     * majuscules (10-02-2017)
     * ($strChaine)
     * met en majuscule (surprice)
     */
    function majuscules($strChaine){
        return strtoupper($strChaine);
    }
    
    /*
     * minuscule (10-02-2017)
     * ($strChaine)
     * met en minuscule (surprice)
     */
    function  minuscules($strChaine){
        return strtolower($strChaine);
    }  
?>