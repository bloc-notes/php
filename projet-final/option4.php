<?php
require_once "librairies-communes-2018-05-04-Doyon.php";
require_once "classe-mysql-2018-03-30-Doyon.php";
require_once "classe-fichier-08-05-2018-Doyon.php";
require_once "classe-validation-projetfinal-15-05-2018-Doyon.php";

const etat_Initial = 0;
const etat_ValidationGeneral = 1;
const etat_ValidationSigleSession = 2;
const etat_AjoutDansBD = 3;

session_start();
$strNomUtilisateur = $_SESSION["nomComplet"];

$strSessionSelect = post("ddlSession");
$intEtat = post("hdEtat") ?? etat_Initial;
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

$strNomTableUtilisateur = "utilisateur";
$strNomTableCours = "cours";
$strNomTableSession = "pf_session";
$strNomTableCoursSession = "courssession";
$strNomTablePrivilege = "privilege";

$booValidationComplete = FALSE;

$BDProjetMicrovox = new mysql($strNomBD, $strInfosSensibles);
$strNomFichier = "";
$booFichierExistant = TRUE;
if ($intEtat != etat_Initial) {
    //Lecture Fichier
    $strNomFichier = post("tbFichierCSV") ?? post("hdNomFichier") ?? "";
    $strCheminFichier = "donnee/csv/" . $strNomFichier . ".csv";
    $tabNomChampsFichier = array("NomUtilisateur", "MotDePasse", "NomComplet", "Courriel", "Sigle1", "Sigle2", "Sigle3", "Sigle4", "Sigle5");

    $fchListeEtudiants = new fichier($strCheminFichier);

    if (!$fchListeEtudiants->existe()) {
        $intEtat = etat_Initial;
        $booFichierExistant = FALSE;
    } else {
        $fchListeEtudiants->ouvre();
        //Saute la première ligne
        $fchListeEtudiants->litLigne();

        $tabContenueFichierOption4 = array();

        while (!$fchListeEtudiants->detecteFin()) {
            $tabLigneTraiter = array();

            $fchListeEtudiants->litDonneesLigne($tabLigneTraiter, ";", $tabNomChampsFichier[0], $tabNomChampsFichier[1], $tabNomChampsFichier[2], $tabNomChampsFichier[3], $tabNomChampsFichier[4], $tabNomChampsFichier[5], $tabNomChampsFichier[6], $tabNomChampsFichier[7], $tabNomChampsFichier[8]);

            $tabValidation = array();
            if ($intEtat == etat_ValidationGeneral) {
                //Validation
                $tabValidation = array_fill(0, 9, FALSE);

                //Nom complet
                if (array_key_exists($tabNomChampsFichier[2], $tabLigneTraiter)) {
                    $tabValidation[2] = validation::valid_NomComplet($tabLigneTraiter[$tabNomChampsFichier[2]]);
                }

                //Nom utilisateur
                if (array_key_exists($tabNomChampsFichier[0], $tabLigneTraiter)) {

                    //valide si n'est pas déjà utilisé
                    if (validation::valid_NomUtilisateur($tabLigneTraiter[$tabNomChampsFichier[0]])) {
                        $strValeurValidation = $tabLigneTraiter[$tabNomChampsFichier[0]];
                        $BDProjetMicrovox->selectionneEnregistrements($strNomTableUtilisateur, "C=nomUtil='$strValeurValidation'");
                        if ($BDProjetMicrovox->nbEnregistrements < 1) {
                            $tabValidation[0] = TRUE;
                        }
                    }
                }

                //Mot de passe
                if (array_key_exists($tabNomChampsFichier[1], $tabLigneTraiter)) {
                    $tabValidation[1] = validation::valid_MDP($tabLigneTraiter[$tabNomChampsFichier[1]]);
                }

                //Courriel
                if (array_key_exists($tabNomChampsFichier[3], $tabLigneTraiter) && ($tabLigneTraiter[$tabNomChampsFichier[3]] !== "")) {
                    $tabValidation[3] = validation::valid_Courriel($tabLigneTraiter[$tabNomChampsFichier[3]]);
                }
                //Vide
                else {
                    $tabValidation[3] = TRUE;
                }

                //Sigle 1 à 5
                //Doublons
                $tabDoublons = array_count_values(array_slice($tabLigneTraiter, 4));

                //Existe
                for ($i = 4; $i <= 8; $i++) {
                    $strValeurSigle = $tabLigneTraiter[$tabNomChampsFichier[$i]];
                    if ($strValeurSigle !== "") {
                        //Pas en doublons
                        if ($tabDoublons[$strValeurSigle] === 1) {
                            $BDProjetMicrovox->selectionneEnregistrements($strNomTableCours, "C=sigleCours='$strValeurSigle'");
                            //Valide si sigle existe
                            if ($BDProjetMicrovox->nbEnregistrements == 1) {
                                $tabValidation[$i] = TRUE;
                            }
                        }
                    }
                    //Vide
                    else {
                        $tabValidation[$i] = TRUE;
                    }
                }
            } else if ($intEtat == etat_ValidationSigleSession) {
                $tabValidation = array_merge(array_fill(0, 4, TRUE), array_fill(0, 5, FALSE));
                //Sigle 1 à 5 validation est dans la session sélectionnée
                for ($i = 4; $i <= 8; $i++) {
                    $strValeurSigle = $tabLigneTraiter[$tabNomChampsFichier[$i]];
                    if ($strValeurSigle !== "") {
                        $BDProjetMicrovox->selectionneEnregistrements($strNomTableCoursSession, "C=sessionCoursSession='$strSessionSelect' AND sigleCoursSession='$strValeurSigle'");
                        //Cours disponible pour la session sélectionné?
                        if ($BDProjetMicrovox->nbEnregistrements == 1) {
                            $tabValidation[$i] = TRUE;
                        }
                    }
                    //Vide
                    else {
                        $tabValidation[$i] = TRUE;
                    }
                }
            } else if ($intEtat == etat_AjoutDansBD) {
                //Ajoute le nouveau utilisateur
                $BDProjetMicrovox->insereEnregistrement($strNomTableUtilisateur, current($tabLigneTraiter), next($tabLigneTraiter), 0, next($tabLigneTraiter), next($tabLigneTraiter));

                //Ajoute les privilèges à utilisateur

                $tabSigleUniquement = array_filter(array_slice($tabLigneTraiter, 4));
                $intDimensionTabSigleUni = count($tabSigleUniquement);
                for ($i = 0; $i < $intDimensionTabSigleUni; $i++) {
                    $BDProjetMicrovox->insereEnregistrement($strNomTablePrivilege, $strSessionSelect, current($tabSigleUniquement), $tabLigneTraiter[$tabNomChampsFichier[0]]);
                    next($tabSigleUniquement);
                }
            }

            //ajoute un tableau de l'état du champs
            array_push($tabLigneTraiter, $tabValidation);

            array_push($tabContenueFichierOption4, $tabLigneTraiter);
        }
    }
}
require_once "en-tete.php";
?>
<section class="sCentre sComprime12">
    <header>
        <h1>Assigner un groupe d'utilisateurs à un cours-session</h1>
    </header>
<?php
if ($intEtat != etat_AjoutDansBD) {
    ?>
        <article class="sCompact">
        <?php
        if ($intEtat == etat_Initial) {
            ?>
                <p>
                    <label for="tbFichierCSV">Nom du fichier CSV</label>
                    <input id="tbFichierCSV" name="tbFichierCSV" type="text" />
                    <button id="btnEnvoyeCSV" name="btnEnvoyeCSV" type="button"  onclick="soumettrePageEtatLocal(1, 'option4.php')">Envoyer</button>
                </p>
        <?php
        if (!$booFichierExistant) {
            ?>
                    <span id="spErreurFichier" name="spErreurFichier" class="sRouge">Un nom de fichier valide doit être inscrit. Attention, vous devez mettre seulement le nom (pas l'extension)!</span>
                    <?php
                }
            } else {
                ?>
                <table id="tabCacher" class="">
                    <tr>
                        <th>
                            Nom d'utilisateur
                        </th>
                        <th>
                            Mot de passe
                        </th>
                        <th>
                            Nom complet
                        </th>
                        <th>
                            Courriel
                        </th>
                        <th>
                            Sigle 1
                        </th>
                        <th>
                            Sigle 2
                        </th>
                        <th>
                            Sigle 3
                        </th>
                        <th>
                            Sigle 4
                        </th>
                        <th>
                            Sigle 5
                        </th>
                        <th>
                            Verdict
                        </th>
                    </tr>
        <?php
        $booValidationComplete = TRUE;
        for ($i = 0; $i < count($tabContenueFichierOption4); $i++) {
            $tabLigne = $tabContenueFichierOption4[$i];
            ?>
                        <tr>
                        <?php
                        $intDimensionTab = count($tabLigne);
                        for ($j = 0; $j < $intDimensionTab - 1; $j++) {
                            ?>
                                <td<?php echo (!($tabLigne[0][$j])) ? " class=\"sErreurTableau\"" : ""; ?>>
                                <?php
                                echo $tabLigne[$tabNomChampsFichier[$j]];
                                ?>
                                </td>
                                <?php
                            }
                            ?>
                            <td>
                                <?php
                                echo in_array(FALSE, $tabLigne[0]) ? "PAS OK" : "OK";
                                $booValidationComplete = (in_array(FALSE, $tabLigne[0])) ? FALSE : $booValidationComplete;
                                ?>
                            </td>
                        </tr>
                                <?php
                            }
                            ?>
                </table>
                <p>
                    <span id='spErreurDonnee' name='spErreurDonnee' class="sCacher sRouge">Une erreur est détecté. Vous pouvez [1] corriger les données dans le fichier excel, [2] saisir une nouvelle session et/ou [3] définir un nouveau cours-session.</span>
                </p>       
                    <?php
                    if (($strSessionSelect != "") || $booValidationComplete) {
                        $BDProjetMicrovox->selectionneEnregistrements($strNomTableSession);
                        ?>
                    <p id="pListeSession" class="">
                        <label for="ddlSession">Liste des sessions</label>
                        <select id="ddlSession" name="ddlSession">
                    <?php
                    for ($i = 0; $i < $BDProjetMicrovox->nbEnregistrements; $i++) {
                        $strSession = $BDProjetMicrovox->contenuChamp($i, "session");
                        echo "<option value=\"" . $strSession . "\">" . $strSession . "</option>";
                    }
                    ?>
                        </select>
                        <button id="btnConfirmSession" name="btnConfirmSession" type="button" onclick="soumettrePageEtatLocal(2, 'option4.php');">Confirmer</button>
                        <button id="btnAnnuleSession" name="btnAnnuleSession" type="button" onclick="soumettrePageEtatLocal(1, 'option4.php');" disabled="true">Annuler Sélection</button>
                    </p>
                            <?php
                        }
                        ?>
            </article>
            <footer id="piedPageCacher" class="">
                <?php
                if (($intEtat == etat_ValidationSigleSession) && ($strSessionSelect != "") && $booValidationComplete) {
                    ?>
                    <span>Voulez-vous vraiment assigner les privilèges?</span>
                    <button id="btnConfirmation" name="btnConfirmation" type="button" onclick="soumettrePageLocalInactif(3, 'option4.php', false);">Confirmer</button>
                    <button id="btnRetour" name="btnRetour" type="button" onclick="">Annuler</button>
                    <?php
                }
                ?>
                <button id="btnDepart" name="btnDepart" type="button" onclick="soumettrePageLocalInactif(0, 'option4.php', true);">Changer de fichier</button>
            </footer>
                <?php
            }
        }
        ?>
</section>
<input id="hdEtat" name="hdEtat" type="hidden" />
<input id='hdIdElement' name ='hdIdElement' type="hidden" />
<input id='hdNomFichier' name ='hdNomFichier' type="hidden" />
<script type="text/javascript">
    function confirmer() {
        alert('Les privilèges ont été apliqués!');
        window.location.href = "option3.php";
    }

    function soumettrePageLocalInactif(intEtat, strNomPageDestination, booVideFichier) {
        if (booVideFichier) {
            document.getElementById('hdNomFichier').value = "";
        }

        document.getElementById('hdEtat').value = intEtat;
        document.getElementById('hdIdElement').value = intAncienneColonneSelectionne;
        document.querySelectorAll('select').forEach(i => i.disabled = false);
        var frm;
        frm = document.getElementById('frmSaisie');
        frm.action = strNomPageDestination;
        frm.submit();
    }

    function soumettrePageEtatLocal(intEtat, strNomPageDestination) {
        document.getElementById('hdEtat').value = intEtat;
        document.getElementById('hdIdElement').value = intAncienneColonneSelectionne;
        var frm;
        frm = document.getElementById('frmSaisie');
        frm.action = strNomPageDestination;
        frm.submit();
    }

<?php
if ($intEtat == etat_AjoutDansBD) {
    ?>
        confirmer();
    <?php
}

if ((!$booValidationComplete) && ($intEtat != etat_Initial)) {
    ?>
        document.getElementById('spErreurDonnee').classList.remove('sCacher');
    <?php
}

if ($intEtat != etat_Initial) {
    ?>
        document.getElementById('hdNomFichier').value = '<?php echo $strNomFichier; ?>';
    <?php
}

if (($intEtat == etat_ValidationSigleSession) && ($strSessionSelect != "") && $booValidationComplete) {
    ?>
        document.getElementById('ddlSession').disabled = true;
        document.getElementById('btnConfirmSession').disabled = true;
        document.getElementById('btnAnnuleSession').disabled = false;
        document.getElementById('ddlSession').value = '<?php echo $strSessionSelect; ?>';
    <?php
}
?>
</script>
<?php
$BDProjetMicrovox->deconnexion();
require_once "pied-page.php";