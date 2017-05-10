<?php
    require_once "librairie-date.php";
    require_once "librairie-general.php";
    
    $strTitreApplication = "Dates de réunion";
    $strNomFichierCSS = "index.css";
    $strNomAuteur = "Philippe Joseph Clermont Michel Doyon";
    
    require_once("en-tete.php");
    
    /*Déclaration des variables nécessaire au traitement */
    $intJourSemaine;
    $intJour;
    $intMois;
    $intAnnee;
    $strDate = "02-02-2017";
    
    /*Extraction date courante */
    extraitJSJJMMAAAA($intJourSemaine, $intJour, $intMois, $intAnnee,$strDate);
?>
<div id="divCorps" class="">
    <!-- Affichage date par approche mixte XHTML/PHP -->
    Nous sommes le
    <?php echo jourSemaineEnLitteral($intJourSemaine);?>
    <?php echo er($intJour);?>
    <?php echo moisEnLitteral($intMois);?>
    <?php echo $intAnnee;?>.
    <br /><br />
    
   
</div>
<?php
    require_once("pied-page.php");
?>