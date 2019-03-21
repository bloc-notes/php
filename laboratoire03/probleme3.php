<?php
    require_once "librairie-generale-doyon.php";
    require_once "librairie-date-doyon.php";
    
    $strTitreApplication = "Dates de réunion";
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
    
    /**/
    for($i=1;$i<=12;$i++){
        $strDate = JJMMAAAA(1, $i, 2018);
        
        $intJourSemainee = date("N", strtotime($strDate));
        $intPremierSamediMois = date("d", strtotime("first saturday 2018-$i"));
        /*Si premier samedi est 1, il retournait le deuxième, donc correction...*/
        $intPremierSamediMois = ($intPremierSamediMois == 8 ? 1 : $intPremierSamediMois);
        
?>    
    <div id="divCorps<?php echo moisEnLitteralSansAccent($i,true);?>" class="">
        Réunion no <?php echo ajouteZero($i,2);?> : <span class="sGras">
        <?php
            echo er(ajouteZero($intPremierSamediMois,1)) . " " 
                    . moisEnLitteral($i) . " 2018"; 
        ?>
        </span>
        <br /><br />
    </div>
<?php
    }
    require_once "pied-page.php";  
?>