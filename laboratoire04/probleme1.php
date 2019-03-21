<?php
    require_once "librairie-date-doyon.php";
    require_once "librairie-generale-doyon.php";
    
    $strTitreApplication = "Lecture d'un fichier texte";
    $strNomFichierCSS = "index.css";
    $strNomAuteur = "Philippe Doyon";
    
    require_once "en-tete.php";
    
    /* Initialisation des variable de travail*/
    $strNomFichierTexte = "liste-eleves.txt";
    $intLigne = 0;
    $strStyle = "style=\"font-family:consolas; font-size:16px;\"";
    $strClass= "class=\"sGras\"";
?>
    <div id="divContenuBrut">
        <p class="sTitreSection">
            Contenu brut du fichier '<?php echo $strNomFichierTexte;?>'
        </p>
        <p>
<?php
    /* Ouverture du fichier texte en lecture*/
    $fp = fopen($strNomFichierTexte, "r");
    /* Parcours du fichier*/
    while (!feof($fp)) {
        $intLigne++;
        $strLigne = str_replace("\n", "", str_replace("\r", "", fgets($fp)));
        echo "<span $strStyle>" . ajouteZero($intLigne, 2) . ": ";
        echo "<span $strClass>$strLigne<br /></span>";
    }
    /* Fermeture du fichier*/
    fclose($fp);
?>
        </p>
    </div>
<?php 
    require_once "pied-page.php";
?>
