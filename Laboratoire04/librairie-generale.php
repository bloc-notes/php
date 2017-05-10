<?php
    /*
     * ajouteZero (02-02-2017)
     * ($numValeur, $intLargeur)
     */
    function ajouteZero($numValeur, $intLargeur){
        return sprintf("%'.0$intLargeur" ."d", $numValeur);
    }

    /*
     * convertitSousChaineEnEntier (2017-01-27)
     */
    function convertirSousChaineEnEntier($strChaine,$intDepart,$intLongueur){
        $intEntier = intval(substr($strChaine,$intDepart,$intLongueur));
        return $intEntier;
    }
    
    /*
     * er (30-01-17)
     *      er($intEntier)
     *      er($intEntier, $binExposant=true)
     */
    function er($intEntier, $binExposant = true){
        return $intEntier . ($intEntier == 1 ? ($binExposant ? "<sup>er</sup>"
            : "er") : "");
    }
?>
