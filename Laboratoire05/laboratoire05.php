<?php
require_once "Librairie-G Doyon.php";
$strTitreApplication = "Traitement des données transmises par la page Web";
$strNomFichierCSS = "laboratoire05.css";
$strNomAuteur = "Philippe Joseph Clermont Michel Doyon";


/*Méthode de transmission de donnée*/
$strMethode = get("btnEnvoiGET") ? "get":(post("btnEnvoiPOST") ? "post":"");
$strMethodeMajus = strtoupper($strMethode);

/*Récupération des paramètres*/
$strMatricule = $strMethode == "" ? "N/A":$strMethode("tbMatricule$strMethodeMajus");
$strNom=$strMethode == "" ? "N/A":$strMethode("tbNom$strMethodeMajus");
$strPrenom=$strMethode == "" ? "N/A":$strMethode("tbPrenom$strMethodeMajus");
$chrSexe=$strMethode == "" ? "N/A":$strMethode("Sexe$strMethodeMajus");
$chrEtatCivil=$strMethode == "" ? "N/A":$strMethode("ddlEtatCivil$strMethodeMajus");
$strDateNaissance=$strMethode == "" ? "N/A":$strMethode("tbDateNaissance$strMethodeMajus");
$strFrancais=$strMethode == "" ? "N/A":$strMethode("cbFrancais$strMethodeMajus");
$strAnglais=$strMethode == "" ? "N/A":$strMethode("cbAnglais$strMethodeMajus");
$strEspagnol=$strMethode == "" ? "N/A":$strMethode("cbEspagnol$strMethodeMajus");

/*
 * Redirection automatique
 */
if($chrSexe == "N/A"){
    echo "Salut";
    echo "<script>alert('Cette application ne peut pas être exécutée directement!');"
    . "location.href='http://424w.cgodin.qc.ca/pdoyon/Laboratoire05/index.php';</script>";
}


require_once("en-tete.php");
?>


<div id="divTransmission" class="">
    <p class="sTitreSection">
        Récupération des données
    </p>
    <p>
        Matricule : 
            <?php 
                if($strMatricule ==""){
                    echo "<span class='sRouge sGras'> (Absent) </span>";
                }
                else if(!estNumerique($strMatricule)){
                    echo "<span class='sRouge sGras'> (Non numérique) </span>";
                }
                else if(!dansIntervalle($strMatricule, 10000, 9999999)){
                    echo "<span class='sRouge sGras'> (Hors plage) </span>";
                }
                else{
                    $strMatricule = ajouteZero($strMatricule, 7 - strlen($strMatricule));
                    echo "<span class='sValide'>" . $strMatricule . "</span>";
                }
            ?><br />
        Nom: 
            <?php
            if($strNom == ""){
                echo "<span class='sRouge sGras'> (Absent) </span>";
            }
            else{
                echo "<span class='sValide'>".$strNom."</span>";
            }
            ?><br />
        Prénom: 
            <?php
            if($strPrenom == ""){
                echo "<span class='sRouge sGras'> (Absent) </span>";
            }
            else{
                echo "<span class='sValide'>".$strPrenom."</span>";
            }
            ?><br />
        Sexe: 
            <?php
            if($chrSexe == 'F'){
                echo "<span class='sValide'> Femme </span>";
            }
             else if($chrSexe == 'H'){
                 echo "<span class='sValide'> Homme </span>";
             }
             else{
                 echo "<span class='sValide'> Non spécifié </span>";
             }
            ?><br />
        État civil: 
            <?php 
            $strEtatCivil = "";
            if(etatCivilValide($chrEtatCivil, $chrSexe, $strEtatCivil)){
                echo "<span class='sValide'>".$strEtatCivil."</span>";
            }
            else{
                echo "<span class='sRouge sGras'> (Absent) </span>";
            }            
            ?><br />
        Date naissance: 
            <?php
            if($strDateNaissance == ""){
                echo "<span class='sValide'> Non spécifiée </span>";
            }
            else if(!dateValide($strDateNaissance)){
                echo "<span class='sRouge sGras'> Invalide </span>";
            }
            else {
                $intJourSemaine = -1;
                $intJour = -1;
                $intMois = -1;
                $intAnnee = -1;
                extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee,$strDateNaissance);
                
                echo "<span class='sValide'>".  jourSemaineEnLitteral($intJourSemaine, true). " ".  er($intJour, true). " ".  moisEnLitteral($intMois). " " . $intAnnee."</span>";
            }
            ?><br />
        Français parlé: <?php echo "<span class='sValide'>". ($strFrancais == "on"?"Oui":"Non")."</span>"; ?><br />
        Anglais parlé: <?php echo "<span class='sValide'>". ($strAnglais == "on"?"Oui":"Non")."</span>"; ?><br />
        Espagñol habla: <?php echo "<span class='sValide'>". ($strEspagnol == "on"?"Oui":"Non")."</span>"; ?><br />
    </p>
</div>

<?php
require_once("pied-page.php");
?>
