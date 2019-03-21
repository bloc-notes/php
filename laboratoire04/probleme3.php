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
    $strClass= "class=\"sGras sBleu\"";
?>
    <div id="divContenuBrut">
        <p class="sTitreSection">
            Contenu brut du fichier '<?php echo $strNomFichierTexte;?>'
        </p>
<?php
    /* Ouverture du fichier texte en lecture*/
    $fp = fopen($strNomFichierTexte, "r");
?>
        <table class="sTableau">
            <tr>
                <td class="sEntete">No</td>
                <td class="sEntete">Matricule</td>
                <td class="sEntete">Nom complet</td>
                <td class="sEntete">Programme</td>
            </tr>
        
<?php
    /* Parcours du fichier*/
    while (!feof($fp)) {
        $intLigne++;
        list($strMatricule, $strNom, $strPrenom, $strNoProgramme) =
            explode(";", str_replace("\n", "", str_replace("\r", "", fgets($fp))));
?>
            <tr>
                <td class=""><?php echo ajouteZero($intLigne, 2);?></td>
                <td class="sGras sBleu"><?php echo $strMatricule;?></td>
                <td class="sGras sBleu"><?php echo "$strPrenom $strNom";?></td>
                <td class="sGras sBleu"><?php echo $strNoProgramme;?></td>
            </tr>
<?php
    }
?>
        </table>
<?php
    /* Fermeture du fichier*/
    fclose($fp);
?>
    </div>
<?php 
    require_once "pied-page.php";
?>
