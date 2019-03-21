<?php
    session_start();
    
    require_once "librairies-communes-2018-03-29-Doyon.php";
    require_once "classe-mysql-2018-03-30-Doyon.php";
    require_once "fonctions-specifiques-projet02.php";
    
    //Déconnexion
    if (request("Deconnexion")) {
        $_SESSION["InfosEtudiant"] = NULL;
        session_destroy();
        header("Location: index.php");
        
        die();
    }
    
    /* Détermination du fichier "InfosSensibles" à utiliser */
    $strMonIP = "";
    $strIPServeur = "";
    $strNomServeur = "";
    $strInfosSensibles = "";
    detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);

    /* --- Initialisation des variables de travail --- */
    $strNomBD = "bdh18_doyon";
    $strLocalHost = "localhost";
    
    $strNomTableEtudiants = "prj2_etudiants";
    $strNomTableRoles = "prj2_roles";
    $strNomTableEquipes = "prj2_equipes";
    $strNomTableMembres = "prj2_membres";
    
    $strNomFichierEtudiants = "etudiants.txt";
    $strNomFichierRoles = "roles.txt";
    $strNomFichierEquipes = "equipes.txt";
    $strNomFichierMembres = "membres.txt";
    
    $strNomRelationMembreEtudiant = "fk_Membres_Etudiants";
    $strNomrelationMembreRoles = "fk_Membres_Roles";
    $strNomRelationMembreEquipe = "fk_Membres_Equipes";
    
    
    // Gestion des tables avant le lancement de la page
    $BDProjet02 = new mysql($strNomBD, $strInfosSensibles);
    
    //Supprime table
    if (request("Reinitialisation")) {
        $_SESSION["InfosEtudiant"] = NULL;
        session_destroy();
        
        $BDProjet02->supprimeTable($strNomTableMembres);
        $BDProjet02->supprimeTable($strNomTableEtudiants);
        $BDProjet02->supprimeTable($strNomTableRoles);
        $BDProjet02->supprimeTable($strNomTableEquipes);
        
        header("Location: index.php");
        
        die();
    }
    
    //Table Étudiant
    
    if (!$BDProjet02->tableExiste($strNomTableEtudiants)) {
        creeTableEtudiants($BDProjet02, $strNomTableEtudiants);
        remplitTableEtudinants($BDProjet02, $strNomTableEtudiants, $strNomFichierEtudiants);
    }
    
    if (!$BDProjet02->tableExiste($strNomTableRoles)) {
        creeTableRoles($BDProjet02, $strNomTableRoles);
        remplitTableRoles($BDProjet02, $strNomTableRoles, $strNomFichierRoles);
    }
    
    if (!$BDProjet02->tableExiste($strNomTableEquipes)) {
        creeTableEquipes($BDProjet02, $strNomTableEquipes);
    }
    
    if (!$BDProjet02->tableExiste($strNomTableMembres)) {
        creeTableMembres($BDProjet02, $strNomTableMembres);
    }
    
    if (!$BDProjet02->relationEntreTableExiste($strNomRelationMembreEtudiant)) {
        $BDProjet02->etablitRelation($strNomTableEtudiants, "etudiant_DA", $strNomTableMembres, "membre_DA", $strNomRelationMembreEtudiant);
    }
    
    if (!$BDProjet02->relationEntreTableExiste($strNomrelationMembreRoles)) {
        $BDProjet02->etablitRelation($strNomTableRoles, "role_No", $strNomTableMembres, "membre_Role", $strNomrelationMembreRoles);
    }
    
    if (!$BDProjet02->relationEntreTableExiste($strNomRelationMembreEquipe)) {
        $BDProjet02->etablitRelation($strNomTableEquipes, "nom_equipe_No_jeton", $strNomTableMembres, "membre_No_jeton", $strNomRelationMembreEquipe);
    }
    
    $strConsigne = "Composé de 7 chiffres";
    $strMessageJeton1 = "10000 à 99999";
    $strMessageJeton2 = "10000 à 99999";
    $strMessageEquipe = "Composé de 5 à 15 caractères; Lettres minuscules et caractère de soulignement seulement; Débute par une lettre";
    
    $intEtat = 0;
    $tabMembreEquipe = array();
    $intNbMembre = 0;
    
    //Autentification
    if (request("btnValider")) {
        if (request("tbDA") && preg_match("/^\d{7}$/", request("tbDA"))&& authentifieEtudiant($BDProjet02, $strNomTableEtudiants, request("tbDA"))) {
            recupereInfosEquipe($BDProjet02, $strNomTableEquipes, $strNomTableMembres, $_SESSION["InfosEtudiant"]["DA"], 
                    $_SESSION["InfosEtudiant"]["NoJeton"], $_SESSION["InfosEtudiant"]["NomEquipe"]);
        }
        else {
            $strConsigne = typeErreur(1);
        }
    }//Créer
    else if (request("Action") && (request("Action") == "Créer")) {
        if (gestionErreur($BDProjet02, 'e', request("tbNomEquipeCreer"), $_SESSION["InfosEtudiant"]["NomEquipe"], $strNomTableEquipes, $strMessageEquipe)) {
            creeEquipe($BDProjet02, $strNomTableEquipes, $strNomTableMembres, request("tbNomEquipeCreer"));
        }    
    }//Joindre
    else if (request("Action") && (request("Action") == "Joindre")) {
        if (gestionErreur($BDProjet02, 'j', request("tbNoJetonJoindre"), $_SESSION["InfosEtudiant"]["NoJeton"], $strNomTableEquipes, $strMessageJeton1, $strNomTableMembres)) {
            jointEquipe($BDProjet02, $strNomTableMembres, $strNomTableEquipes, request("tbNoJetonJoindre"));
            $intNbMembre = recupereMembresEquipe($BDProjet02, $strNomTableEtudiants, $strNomTableMembres, $_SESSION["InfosEtudiant"]["NoJeton"], $tabMembreEquipe);
        }
    }//Renommer
    else if (request("Action") && (request("Action") == "Renommer")) {
        $booValideJeton = gestionErreur($BDProjet02, 'j', request("tbNoJetonRenommer"), $_SESSION["InfosEtudiant"]["NoJeton"], $strNomTableEquipes, $strMessageJeton1);
        $booValideEquipe = gestionErreur($BDProjet02, 'e', request("tbNouveauNomEquipe"), $_SESSION["InfosEtudiant"]["NomEquipe"], $strNomTableEquipes,  $strMessageEquipe);
        
        if ($booValideJeton && $booValideEquipe) {
            renommeEquipe($BDProjet02, $strNomTableEquipes, request("tbNoJetonRenommer"), request("tbNouveauNomEquipe"));
        }
        
    }//Retirer
    else if (request("Action") && (request("Action") == "Retirer")) {
        if (gestionErreur($BDProjet02, 'j', request("tbNoJetonRetirer"), $_SESSION["InfosEtudiant"]["NoJeton"], $strNomTableEquipes, $strMessageJeton2)) {
            retireEquipe($BDProjet02, $strNomTableEquipes, $strNomTableMembres, request("tbNoJetonRetirer"), $_SESSION["InfosEtudiant"]["DA"]);
        }
    }
    
    //État d'affichage
    if (isset($_SESSION["InfosEtudiant"])) {
        if (empty($_SESSION["InfosEtudiant"]["NoJeton"])) {
                $intEtat = 1;
        }
        else {
            $intEtat = 2;
            $intNbMembre = recupereMembresEquipe($BDProjet02, $strNomTableEtudiants, $strNomTableMembres, $_SESSION["InfosEtudiant"]["NoJeton"], $tabMembreEquipe);
        }
    }
    
    require_once "en-tete.php";
    
    if ($intEtat > 0) {
?>
        <div id="divIdentification" class="">
            <p class="sTitreSection">
                Confirmation de l'identité
            </p>
            <p>
                Bonjour <span class="sMembreEquipe"><?php echo $_SESSION["InfosEtudiant"]["NomComplet"];?></span> !
            </p>
            <p>
                Selon nos dossiers
<?php
        if (empty($_SESSION["InfosEtudiant"]["NoJeton"])) {
?>
                vous ne faites pas partie d'une équipe.
<?php
        }
        else {
?>
                vous êtes membre de l'équipe <span class="sMembreEquipe"><?php echo $_SESSION["InfosEtudiant"]["NomEquipe"];?></span>
                et le numéro de jeton assigné est 
                <input type="checkbox" onclick="document.getElementById('lblNoJeton').innerHTML = this.checked ? '<?php echo $_SESSION["InfosEtudiant"]["NoJeton"];?>' : '*****';" />
                <span id="lblNoJeton" class="sMembreEquipeJeton">*****</span>.
                <br /><br />
                Votre équipe est composée de <?php echo $intNbMembre;?> membre<?php echo ($intNbMembre > 1 ? "s":"");?> soit
<?php
            for ($intIndex = 0; $intIndex < $intNbMembre; $intIndex++) {
?>
                <span class="sMembreEquipe"><?php echo $tabMembreEquipe[$intIndex] . (($intIndex + 1) != $intNbMembre ? "," : "."); ?></span>
<?php
            }
        }
?>
            </p>
        </div>
<?php
    }
    
    switch ($intEtat) {
        case 0:
?>
        <div id="divPresentation" class="">
            <p class="sTitreSection">
                Présentation
            </p>
            <p>
                Le but de cette application est de permettre de créer les équipes pour le projet final de 420-4W5.
            </p>
        </div>

        <div id="divSaisieDA" class="">
            <hr />
            <p class="sTitreSection">
                Identification
            </p>
            <table>
                <tr>
                    <td>Entrez votre numéro de DA : </td>
                    <td>
                        <input id="tbDA" name="tbDA" type="text" class="sDA" maxlength="7" value=""/>
                        <input id="btnValider" name="btnValider" type="submit" class="" value="Valider" />
                        <span class="sConsigne sGras"><?php echo $strConsigne;?></span>
                    </td>
                </tr>
            </table>
        </div>
<?php
            break;
        case 1:
?>
        <div id="divEnEquipe" class="">
            <hr />
            <p class="sTitreSection">
                Désirez-vous...
            </p>
            <p class="sTitreSousSection">
                1. créer une équipe ?
            </p>
            <table>
                <tr>
                    <td>Nom de l'équipe :</td>
                    <td>
                        <input id="tbNomEquipeCreer" name="tbNomEquipeCreer" type="text" maxlength="15" class="sNomEquipe" value=""/>
                        <input id="Action" name="Action" type="submit" value="Créer" />
                        <span id="lblMessageCreer" class="sConsigne sGras"><?php echo $strMessageEquipe; ?></span>
                    </td>
                </tr>
            </table>
            <p class="sTitreSousSection">
                2. joindre une équipe ?
            </p>
            <table>
                <tr>
                    <td>Numéro du jeton :</td>
                    <td>
                        <input id="tbNoJetonJoindre" name="tbNoJetonJoindre" type="text" maxlength="5" class="sNoJeton" value="" />
                        <input id="Action" name="Action" type="submit" value="Joindre" />
                        <span id="lblMessageJoindre" class="sConsigne sGras"><?php echo $strMessageJeton1;?></span>
                    </td>
                </tr>
            </table>
        </div>
<?php
            break;
        case 2:
?>
        <div id="divEnEquipe" class="">
            <hr />
            <p class="sTitreSection">
                Désirez-vous...
            </p>
            <p class="sTitreSousSection">
                1. changer le nom de votre équipe ?
            </p>
            <table>
                <tr>
                    <td>Numéro du jeton :</td>
                    <td>
                        <input id="tbNoJetonRenommer" name="tbNoJetonRenommer" type="text" maxlength="5" class="sNoJeton" value="" />
                    </td>
                    <td>
                        <span id="lblMessageRenommerJeton" class="sConsigne sGras"><?php echo $strMessageJeton1;?></span>
                    </td>
                </tr>
                <tr>
                    <td>Nouveau nom :</td>
                    <td>
                        <input id="tbNouveauNomEquipe" name="tbNouveauNomEquipe" type="text" maxlength="15" class="sNomEquipe" value="" />
                    </td>
                    <td>
                        <span id="lblMessageRenommerNom" class="sConsigne sGras"><?php echo $strMessageEquipe;?></span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input id="Action" name="Action" type="submit" value="Renommer" />
                    </td>
                </tr>
            </table>
            <p class="sTitreSousSection">
               2. vous retirer de l'équipe ?
            </p>
            <table>
                <tr>
                    <td>Numéro du jeton :</td>
                    <td>
                        <input id="tbNoJetonRetirer" name="tbNoJetonRetirer" type="text" maxlength="5" class="sNoJeton" value="" />
                        <input id="Action" name="Action" type="submit" value="Retirer" />
                        <span id="lblMessageRetirer" class="sConsigne sGras"><?php echo $strMessageJeton2;?></span>
                    </td>
                </tr>
            </table>
        </div>
<?php
            break;
    }
?>
<script type="text/javascript">
    //Affichage des erreurs en rouge
    var listMessage = document.getElementsByClassName("sConsigne");
    var i;
    for (i = 0; i < listMessage.length; i++) {
        if (listMessage[i].textContent.substr(0,6) == 'Erreur') {
            listMessage[i].classList.add('sMessageErreur');
        }
    }
</script>
<?php
    require_once "pied-page.php";