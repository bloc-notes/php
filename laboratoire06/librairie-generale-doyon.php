<?php
    /*librairie-generale-doyon.php   Philippe Doyon  08-02-2018*/
    
    /*----------------------
     * ajouteZeros (08-02-18)
     * ---------------------
     */
     function ajouteZeros($numValeur, $intLargeur){
         $strFormat = "%0" . $intLargeur . "d";
         return sprintf($strFormat, $numValeur);
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
?>
