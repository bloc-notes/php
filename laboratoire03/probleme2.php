<?php
    require_once "librairie-date-doyon.php";
    require_once "librairie-generale-doyon.php";
    
    $strTitreApplication = "Affichage de la date courante";
    $strNomFichierCSS = "index.css";
    $strNomAuteur = "Philippe Doyon";
    
    require_once "en-tete.php";
    
    /* Déclaration des variables nécessaires au traitement */
    $intJourSemaine;
    $intJour;
    $intMois;
    $intAnnee;
    $strDate = "01-02-2018";
    
    /* Extraction du jour de la semaine, du jour, du mois et de l'année de la 
     * date courante. (entre guillemet)
     */
    
    extraitJSJJMMAAAA($intJourSemaine, $intJour, $intMois, $intAnnee, $strDate);
?>    
    <div id="divCorps" class="">
        <!-- Affichage de la date courante en utilisant l'approche mixte XHTML/PHP-->
        Nous sommes le
        <?php
            echo jourSemaineEnLitteral($intJourSemaine) . " ";
            echo er($intJour) . " ";
            echo moisEnLitteral($intMois) . " ";
            echo $intAnnee . ".";
        ?>
        <br /><br />
    </div>
<?php  
    require_once "pied-page.php";  
?>