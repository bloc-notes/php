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
    
    /* récupératoin du paramètre à partir de la barre d'adresse du navigateur */
    $strNoProgrammeRecherche = isset($_POST["ddlNoProgrammeRecherche"]) ? 
            $_POST["ddlNoProgrammeRecherche"] : "Tous";
?>
    <div id="divSaisieProgramme">
        <p class="sTitreSection">
            Saisie du programme de l'élève
        </p>
        Sélectionnez le nom du programme<br />
        <select id="ddlNoProgrammeRecherche" name="ddlNoProgrammeRecherche"
                onchange="document.getElementById('frmSaisie').submit();">
            <option value="Tous">Tous les programmes</option>
            <option value="180.A0">Soin infirmiers</option>
            <option value="235.C0">Technologie de la production pharmaceutique</option>
            <option value="243.A0">Électronique programmable et robotique</option>
            <option value="322.A0">Technique d'éducation à l'enfance</option>
            <option value="410.B0">Technique de comptabilité et de gestion</option>
            <option value="420.AA">Technique de l'informatique</option>
        </select>
    </div>
    <div id="divContenuFormate">
        <p class="sTitreSection">
            Liste des étudiants
<?php
    if ($strNoProgrammeRecherche == "Tous") {
?>
            de tous les programmes
<?php
    }
    else {
?>
            de "<span id="lblNomProgramme"></span>"
            (<?php echo $strNoProgrammeRecherche; ?>)
<?php
    }
?>
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
<?php
    /* Affichage de la dernière colonne lorsque nécessaire seulement*/
    if ($strNoProgrammeRecherche == "Tous") {
?>
                <td class="sEntete">Programme</td>
<?php
    }
?>
            </tr>
        
<?php
    /* Parcours du fichier*/
    while (!feof($fp)) {
        
        list($strMatricule, $strNom, $strPrenom, $strNoProgramme) =
            explode(";", str_replace("\n", "", str_replace("\r", "", fgets($fp))));
        
        /* La variable '$strProgramme' doit être initialisée lorsque nécessaire seulement */
        if ($strNoProgrammeRecherche == "Tous" || $intLigne == 0){
            switch ($strNoProgramme){
                case "180.A0" : $strProgramme = "Soins infirmiers"; break;
                case "235.C0" : $strProgramme = "Technologie de la production pharmaceutique"; break;
                case "243.A0" : $strProgramme = "Électronique programmable et robotique"; break;
                case "322.A0" : $strProgramme = "Technique d'éducation à l'enfance"; break;
                case "410.B0" : $strProgramme = "Technique de comptabilité et de gestion"; break;
                case "420.AA" : $strProgramme = "Technique de l'informatique"; break;
            }
        }
        
        /* Affichage des données de l'élève lorsque nécessaire seulement */
        if ($strNoProgramme == $strNoProgrammeRecherche || 
                $strNoProgrammeRecherche == "Tous") {
            $intLigne++;
?>
            <tr>
                <td class=""><?php echo ajouteZero($intLigne, 2);?></td>
                <td class="sGras sBleu"><?php echo $strMatricule;?></td>
                <td class="sGras sBleu"><?php echo "$strPrenom $strNom";?></td>
<?php
            /* Affichage de la dernière colonne lorsque nécessaire seulement */
            if ($strNoProgrammeRecherche == "Tous") {
?>
                <td class="sGras sBleu"><?php echo "$strProgramme ($strNoProgramme)";?></td>
<?php
            }
?>
            </tr>
<?php
        }
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

<script type="text/javascript">
    if (document.getElementById('ddlNoProgrammeRecherche'))
        document.getElementById('ddlNoProgrammeRecherche').value = 
            '<?php echo $strNoProgrammeRecherche; ?>';
    
    if (document.getElementById('lblNomProgramme'))
        document.getElementById('lblNomProgramme').innerHTML = 
            "<?php echo $strProgramme; ?>";
</script>