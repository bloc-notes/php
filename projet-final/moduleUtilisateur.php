<?php
require_once "librairies-communes-2018-05-04-Doyon.php";
require_once "classe-mysql-2018-03-30-Doyon.php";
session_start();
$strNomUtilisateur = $_SESSION["nomComplet"];
$strVraiNomUtil = "p.doyon";

//BD
/* Détermination du fichier "InfosSensibles" à utiliser */
$strMonIP = "";
$strIPServeur = "";
$strNomServeur = "";
$strInfosSensibles = "";
detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);

/* --- Initialisation des variables de travail pour la BD --- */
$strNomBD = "pjf_microvox";
$strLocalHost = "localhost";

$strNomTableCoursSession = "courssession";
$strNomTableCours = "cours";
$strNomTablePrivilege = "privilege";
$strNomTableUtilisateur = "utilisateur";
$strNomTableDocument = "document";

$tabNomChampsAffichageDoc = array("titre", "description","doc_Categorie","dateCours", "noSequence",  "nbPages", "dateVersion");

$BDProjetMicrovox = new mysql($strNomBD, $strInfosSensibles);

$BDProjetMicrovox->selectionneEnregistrements($strNomTablePrivilege, "C=nomUtilPrivilege='$strVraiNomUtil'");
$intNbCoursSession = $BDProjetMicrovox->nbEnregistrements;
$tabCoursSessionDispo = array();
if ($intNbCoursSession > 0) {
    for ($i = 0; $i < $intNbCoursSession; $i++) {
        $tabCoursSessionDispo[$i] = $BDProjetMicrovox->contenuChamp($i, 1) . " (" . $BDProjetMicrovox->contenuChamp($i, 0) . ")";
    }
}

$strCoursSession = post("ddlCoursSession") == "vide" ? "" : post("ddlCoursSession");
$strSigle = "";
$strSession = "";
$strTitreCours = "";
$strNomProf = "";
$strDateActuel = aujourdhui();
$intNbDoc = 0;
if ($strCoursSession != "") {
    $strSigle = gauche($strCoursSession, 7);
    $strSession = trim(str_replace(")", "", explode("(", $strCoursSession)[1]));
    
    $BDProjetMicrovox->selectionneEnregistrements($strNomTableCours, "C=sigleCours='$strSigle'");
    $strTitreCours = $BDProjetMicrovox->contenuChamp(0, "titre");
    
    $BDProjetMicrovox->selectionneEnregistrements($strNomTableCoursSession, "C=sessionCoursSession='$strSession' AND sigleCoursSession='$strSigle'");
    $strNomUtilProf = $BDProjetMicrovox->contenuChamp(0, "nomUtilCoursSession");
    
    $BDProjetMicrovox->selectionneEnregistrements($strNomTableUtilisateur, "C=nomUtil='$strNomUtilProf'");
    $strTabNomProf = explode(",", $BDProjetMicrovox->contenuChamp(0, "nomComplet"));
    $strNomProf = trim($strTabNomProf[1]) . " " .$strTabNomProf[0];
    
    //Trouve les documents qu'il peut avoir accès
    $BDProjetMicrovox->selectionneEnregistrements($strNomTableDocument, "C=sessionDoc='$strSession' AND sigleCoursDoc='$strSigle' AND"
            . " dateAccesDebut<='$strDateActuel' AND dateAccesFin>='$strDateActuel' AND affichage='1'");
    $intNbDoc = $BDProjetMicrovox->nbEnregistrements;
}

require_once "en-tete.php";
?>
<script language="JavaScript">
    //https://www.w3schools.com/howto/howto_js_sort_table.asp
    function triTable(n) {
        var table, rangees, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("tableDocs");
        switching = true;
        //Met la direction en ascendant
        dir = "asc";
        /*Crée une loop qui continue jusqu'à ce que aucun tri n'est fait:*/
        while (switching) {
            //commence en disant qu'aucun tri n'est fait:
            switching = false;
            rangees = table.getElementsByTagName("TBODY");
            /*Loop À travers toutes les rangées sauf les premières:*/
            for (i = 0; i < (rangees.length - 1); i++) {
                //commence en disant qu'il ne doit pas avoir de tri:
                shouldSwitch = false;
                /*Reçoit les 2 éléments à comparer :
                 * Un de la première rangée, l'autre de la seconde*/
                x = rangees[i].getElementsByTagName("TR")[0].getElementsByTagName("TD")[n];
                y = rangees[i + 1].getElementsByTagName("TR")[0].getElementsByTagName("TD")[n];
                /*vérifie si les 2 colonnes doivent s'échanger de place:*/
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        //si oui
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        //si oui:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch
                 and mark that a switch has been done:*/
                rangees[i].parentNode.insertBefore(rangees[i + 1], rangees[i]);
                switching = true;
                //Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /*If no switching has been done AND the direction is "asc",
                 set the direction to "desc" and run the while loop again.*/
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
    
    function accordeon(intNoLigne) {
        document.getElementById('tr' + intNoLigne).classList.toggle('sCacher');
        
        if (document.getElementById('btnDesc' + intNoLigne).textContent == "↓") {
            document.getElementById('btnDesc' + intNoLigne).textContent = "↑";
        }
        else {
            document.getElementById('btnDesc' + intNoLigne).textContent = "↓";
        }
    }

</script>
<section class="sComprime12 sCentre">
    <header>
        <h1>Menu utilisateur</h1>
    </header>
    <article class="sCompact">
        <p>
        <label for="ddlCoursSession">Cours-Session</label>
        <select id="ddlCoursSession" name="ddlCoursSession" onchange="soumettrePage('moduleUtilisateur.php', 'frmSaisie');" >
            <option value="vide"></option>
<?php
for ($i = 0; $i < $intNbCoursSession; $i++) {
?>
            <option value="<?php echo $tabCoursSessionDispo[$i];?>"><?php echo $tabCoursSessionDispo[$i];?></option>
<?php
}
?>
        </select>
        </p>
<?php
if ($strCoursSession != "") {
?>
        <p>
        <h3>Information sur le cours-session</h3>
            <span>Sigle: <?php echo $strSigle;?></span>
            <span>Titre du cours: <?php echo $strTitreCours;?></span>
            <span>Session: <?php echo $strSession;?></span>
            <span>Nom du professeur(e): <?php echo $strNomProf;?></span>
        </p>
<?php
}
if ($intNbDoc > 0) {
?>
        <h3>Document(s)</h3>
        <table id="tableDocs">
            <thead>
                <tr>
                    <th>
                        No
                    </th>
                    <th onclick="triTable(1)" style="cursor: pointer;">
                        Titre ↨
                    </th>
                    <th>
                        Description
                    </th>
                    <th  onclick="triTable(3)" style="cursor: pointer;">
                        Catégorie ↨
                    </th>
                    <th onclick="triTable(4)" style="cursor: pointer;">
                        Date du cours ↨
                    </th>
                    <th>
                        No de séquence
                    </th>
                    <th>
                        Nb de pages
                    </th>
                    <th>
                        Mise à jour
                    </th>
                    <th>
                        Jours restants
                    </th>
                </tr>
            </thead>
<?php
    for ($i = 0; $i < $intNbDoc; $i++) {
        $intNbJoursRestant = nombreJoursEntreDeuxDates($strDateActuel, $BDProjetMicrovox->contenuChamp($i, "dateAccesFin"));
        $tempo = "http://424w.cgodin.qc.ca/pdoyon/projetFinal/donnee/documents/"; //...
?>
            <tbody>
                <tr>
                    <td><?php echo ($i + 1);?></td>
                    <td><a href="<?php echo $BDProjetMicrovox->contenuChamp($i, "hyperLien");?>"><?php echo $BDProjetMicrovox->contenuChamp($i, $tabNomChampsAffichageDoc[0]);?></a></td>
                    <td><button id="btnDesc<?php echo ($i + 1);?>" name="btnDesc<?php echo ($i + 1);?>"  class="sboutonAccordeon" type="button" onclick="accordeon(<?php echo ($i + 1);?>);">↓</td>
<?php
        for ($j = 2; $j < count($tabNomChampsAffichageDoc); $j++) {
?>
                    <td><?php echo $BDProjetMicrovox->contenuChamp($i, $tabNomChampsAffichageDoc[$j]);?></td>
<?php              
        }
?>
                    <td><?php echo $intNbJoursRestant;?></td>
                </tr>
                <tr id="tr<?php echo ($i + 1);?>" class="sCacher" style="text-align: left;">
                    
                    <td colspan="9"><?php echo $BDProjetMicrovox->contenuChamp($i, $tabNomChampsAffichageDoc[1]);?></td>
                </tr>
            </tbody>
<?php
    }
?>
        </table>
<?php
}
else if ($strCoursSession != "") {
?>
        <span>Aucun document pour ce cours-session!</span>
<?php
}
?>
    </article>
</section>
<script type="text/javascript">
document.getElementById('ddlCoursSession').value = '<?php echo $strCoursSession;?>';
</script>
<?php
$BDProjetMicrovox->deconnexion();
require_once "pied-page.php";