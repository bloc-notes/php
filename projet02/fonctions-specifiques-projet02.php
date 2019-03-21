<?php
    require_once "classe-fichier-2018-03-16-Doyon.php";
    
    $tabChampsTableEtudiants = array("etudiant_DA", "etudiant_Nom", "etudiant_Prenom");
    $tabChampsTableRoles = array("role_No", "role_Description");
    $tabChampsTableEquipes = array("nom_equipe_No_jeton", "nom_equipe_URL");
    $tabChampsTableMembres = array("membre_No_jeton", "membre_DA", "membre_Role");
    
    /*--------------------------------------------------------------------
     * 1) creeTableEtudiants (29-03-2018)
     * 
     * But: Créer la structure de la table prj2_etudiants avec la fonction
     *      creeTableGenerique
     * -------------------------------------------------------------------
     */
    function creeTableEtudiants(mysql $BDProjet02, $strNomTableEtudiants) {
        global $tabChampsTableEtudiants;
        $strDefinitions = "F7," . $tabChampsTableEtudiants[0] . ";".
                          "V25," . $tabChampsTableEtudiants[1] . ";".
                          "V20," . $tabChampsTableEtudiants[2];
        $strCles = $tabChampsTableEtudiants[0];

        $BDProjet02->creeTableGenerique($strNomTableEtudiants, $strDefinitions, $strCles);
    }
    
    /*------------------------------------------------------------------------
     * 2) remplitTableEtudinants (29-03-2018)
     * 
     * But: Charge la table prj2_etudiants avec le fichier texte etudiants.txt
     *      avec la fonction insereEnregistrement
     * -----------------------------------------------------------------------
     */
    function remplitTableEtudinants(mysql $BDProjet02, $strNomTableEtudiants, $strNomFichierEtudiants) {
        global $tabChampsTableEtudiants;
        $fchEtudiants = new fichier($strNomFichierEtudiants);
        
        $fchEtudiants->ouvre();
        
        while(!$fchEtudiants->detecteFin()) {
            $tabValeurs = array();
            
            $fchEtudiants->litDonneesLigne($tValeurs, ";", $tabChampsTableEtudiants[0],
                                            $tabChampsTableEtudiants[1], $tabChampsTableEtudiants[2]);
            
            $BDProjet02->insereEnregistrement($strNomTableEtudiants, $tValeurs[$tabChampsTableEtudiants[0]],
                                              $tValeurs[$tabChampsTableEtudiants[1]], $tValeurs[trim($tabChampsTableEtudiants[2])]);
        }
        $fchEtudiants->ferme();
    }
    
    /*--------------------------------------------------------------------
     * 3) creeTableRoles (30-03-2018)
     * 
     * But: Créer la structure de la table prj2_roles avec la fonction
     *      creeTableGenerique
     * -------------------------------------------------------------------
     */
    function creeTableRoles(mysql $BDProjet02, $strNomTableRoles) {
        global $tabChampsTableRoles;
        $strDefinitions = "N," . $tabChampsTableRoles[0] . ";".
                          "V50," . $tabChampsTableRoles[1];
        $strCles = $tabChampsTableRoles[0];

        $BDProjet02->creeTableGenerique($strNomTableRoles, $strDefinitions, $strCles);
    }
    
    /*------------------------------------------------------------------------
     * 4) remplitTableRoles (30-03-2018)
     * 
     * But: Charge la table prj2_Roles avec le fichier texte etudiants.txt
     *      avec la fonction insereEnregistrement
     * -----------------------------------------------------------------------
     */
    function remplitTableRoles(mysql $BDProjet02, $strNomTableRoles, $strNomFichierRoles) {
        global $tabChampsTableRoles;
        $fchRoles = new fichier($strNomFichierRoles);
        
        $fchRoles->ouvre();
        
        while(!$fchRoles->detecteFin()) {
            $tabValeurs = array();
            
            $fchRoles->litDonneesLigne($tValeurs, ";", $tabChampsTableRoles[0],
                                            $tabChampsTableRoles[1]);
            
            $BDProjet02->insereEnregistrement($strNomTableRoles, $tValeurs[$tabChampsTableRoles[0]],
                                              $tValeurs[$tabChampsTableRoles[1]]);
        }
        $fchRoles->ferme();
    }
    
    /*--------------------------------------------------------------------
     * 5) creeTableEquipes (30-03-2018)
     * 
     * But: Créer la structure de la table prj2_equipe avec la fonction
     *      creeTableGenerique
     * -------------------------------------------------------------------
     */
    function creeTableEquipes(mysql $BDProjet02, $strNomTableEquipes) {
        global $tabChampsTableEquipes;
        $strDefinitions = "N," . $tabChampsTableEquipes[0] . ";".
                          "V15," . $tabChampsTableEquipes[1];
        $strCles = $tabChampsTableEquipes[0];

        $BDProjet02->creeTableGenerique($strNomTableEquipes, $strDefinitions, $strCles);
    }
    
    /*--------------------------------------------------------------------
     * 6) creeTableMembres (30-03-2018)
     * 
     * But: Créer la structure de la table prj2_membres avec la fonction
     *      creeTableGenerique
     * -------------------------------------------------------------------
     */
    function creeTableMembres(mysql $BDProjet02, $strNomTableMembres) {
        global $tabChampsTableMembres;
        $strDefinitions = "N," . $tabChampsTableMembres[0] . ";".
                          "F7," . $tabChampsTableMembres[1] . ";".
                          "E," . $tabChampsTableMembres[2];
        $strCles = $tabChampsTableMembres[0] . ", " . $tabChampsTableMembres[1];

        $BDProjet02->creeTableGenerique($strNomTableMembres, $strDefinitions, $strCles);
    }
    
    /*-------------------------------------------------------------------------
     * 7) authentifieEtudiant (15-04-2018)
     * 
     * But: Confirmer que l'étudiant est bien autorisé à se connecter. Si oui,
     *      DA, nom, prénom, et nom complet sont entreposés dans des variables
     *      de session.
     * Retour: Confirmation (bool)
     * ------------------------------------------------------------------------
     */
    function authentifieEtudiant(mysql $BDProjet02, $strNomTableEtudiants, $strDA) {
        global $tabChampsTableEtudiants;
        
        $intResult = $BDProjet02->selectionneEnregistrements($strNomTableEtudiants,"C=$tabChampsTableEtudiants[0]='$strDA'");
        
        if ($intResult == 1) {
            $tabInfoEtu = array();
            $tabInfoEtu["DA"] = $BDProjet02->contenuChamp(0, 0);
            $tabInfoEtu["Nom"] = $BDProjet02->contenuChamp(0, 1);
            $tabInfoEtu["Prenom"] = $BDProjet02->contenuChamp(0, 2);
            $tabInfoEtu["NomComplet"] = $tabInfoEtu["Prenom"] . " " . $tabInfoEtu["Nom"];
            $tabInfoEtu["NoJeton"] = NULL;
            $tabInfoEtu["NomEquipe"] = NULL;
            
            $_SESSION["InfosEtudiant"] = $tabInfoEtu;
        }
        return ($intResult === 1);
    }
    
    /*----------------------------------------------------------------------
     * 8) recupereInfosEquipe (15-04-2018)
     * 
     * But: Récupère s'il a lieu, le numéro de jeton et le nom d'une équipe 
     *      dont l'étudiant fait partie.
     * ---------------------------------------------------------------------
     */
    function recupereInfosEquipe(mysql $BDProjet02, $strNomTableEquipes, 
                $strNomTableMembres, $strDA, &$intNoJeton, &$strNomEquipe) {
        global $tabChampsTableMembres, $tabChampsTableEquipes;
        $intNbResultat = $BDProjet02->selectionneEnregistrements($strNomTableMembres, "C=$tabChampsTableMembres[1]='$strDA'");
        
        if ($intNbResultat > 0) {
            $intNoJeton = $BDProjet02->contenuChamp(0, 0);
            
            $BDProjet02->selectionneEnregistrements($strNomTableEquipes, "C=$tabChampsTableEquipes[0]='$intNoJeton'");
            
            $strNomEquipe = $BDProjet02->contenuChamp(0, 1);
        }
    }
    
    /*-----------------------------------------------------------------
     * 9) recupereMembresEquipe (15-04-2018)
     * 
     * But: Récupérer le nom complet de chaque membre de l'équipe dont 
     *      l'étudiant fait partie.
     * 
     * Retour: Nombre d'équipiers
     * ----------------------------------------------------------------
     */
    function recupereMembresEquipe(mysql $BDProjet02, $strNomTableEtudiants, 
                        $strNomTableMembres, $intNoJeton, array &$tListeEquipiers) {
        global $tabChampsTableMembres, $tabChampsTableEtudiants;
        
        $BDProjet02->selectionneEnregistrements($strNomTableMembres,"C=$tabChampsTableMembres[0]='$intNoJeton'");
        $intNbEquipier = $BDProjet02->nbEnregistrements;
        
        if ($intNbEquipier > 0) {
            $tabDAEquipier = array();
            
            for($intIndex = 0; $intIndex < $intNbEquipier; $intIndex++) {
                $tabDAEquipier[] = $BDProjet02->contenuChamp($intIndex, 1);
            }
            
            for ($intIndex = 0; $intIndex < $intNbEquipier; $intIndex++) {
                $BDProjet02->selectionneEnregistrements($strNomTableEtudiants, "C=$tabChampsTableEtudiants[0]='$tabDAEquipier[$intIndex]'");
                $tListeEquipiers[] = $BDProjet02->contenuChamp(0, 2) . " " . $BDProjet02->contenuChamp(0, 1);
            }
        }
        
        return $intNbEquipier;
    }
    
    /*------------------------------------------------------------
     * 10) creeEquipe (15-04-2018)
     * 
     * But: Permet à l'étudiant de créer une nouvelle équipe
     * 
     * Validation: Gestion des messages d'erreur pour le programme
     * -----------------------------------------------------------
     */
    function creeEquipe(mysql $BDProjet02, $strNomTableEquipes, 
                        $strNomTableMembres, $strNomEquipe) {
        global $tabChampsTableEquipes;
        
        //Vérifie si le nom de l'équipe est disponible
        if ($BDProjet02->selectionneEnregistrements($strNomTableEquipes, "C=$tabChampsTableEquipes[1]='$strNomEquipe'") == 0) {
            $intJeton;
            do {
                $intJeton = random_int(10000, 99999);
            }while ($BDProjet02->selectionneEnregistrements($strNomTableEquipes,"C=$tabChampsTableEquipes[0]='$intJeton'") > 0);

            $BDProjet02->insereEnregistrement($strNomTableEquipes, $intJeton, $strNomEquipe);
            $BDProjet02->insereEnregistrement($strNomTableMembres, $intJeton, $_SESSION["InfosEtudiant"]["DA"], 0);

            $_SESSION["InfosEtudiant"]["NoJeton"] = $intJeton;
            $_SESSION["InfosEtudiant"]["NomEquipe"] = $strNomEquipe;

            //header("Location: " . $_SERVER["REQUEST_URI"]);
        }      
    }
    
    /*------------------------------------------------------------------
     * 11) jointEquipe (15-04-2018)
     * 
     * But: Permettre à l'étudiant de se joindre à une équipe existante.
     * 
     * Validation: Gestion des messages d'erreur pour le programme
     * -----------------------------------------------------------------
     */
    function jointEquipe(mysql $BDProjet02, $strNomTableMembres, $strNomTableEquipes ,$intJeton) {
        global $tabChampsTableEquipes;


        if ($BDProjet02->selectionneEnregistrements($strNomTableEquipes,"C=$tabChampsTableEquipes[0]='$intJeton'") == 1) {
            $strNomEquipe = $BDProjet02->contenuChamp(0, 1);
            $BDProjet02->insereEnregistrement($strNomTableMembres, $intJeton, $_SESSION["InfosEtudiant"]["DA"], 0);
            
            $_SESSION["InfosEtudiant"]["NoJeton"] = $intJeton;
            $_SESSION["InfosEtudiant"]["NomEquipe"] = $strNomEquipe;
        }
    }
    
    /*-------------------------------------------------------------------------------
     * 12) renommeEquipe (16-04-2018)
     * 
     * But: Permettre à l'étudiant de changer le nom de l'équipe dont il fait partie.
     * 
     * Validation: Gestion des messages d'erreur pour le programme
     * ------------------------------------------------------------------------------
     */
    function renommeEquipe(mysql $BDProjet02, $strNomTableEquipes,$intJeton, $strNouveauNomEquipe) {
        global $tabChampsTableEquipes;
        
        //Valide que l'équipe existe et que le nom n'est pas déja pris
        if (($BDProjet02->selectionneEnregistrements($strNomTableEquipes,"C=$tabChampsTableEquipes[0]='$intJeton'") == 1) 
                && ($BDProjet02->selectionneEnregistrements($strNomTableEquipes,"C=$tabChampsTableEquipes[1]='$strNouveauNomEquipe'") < 1 )) {
            $BDProjet02->metAJourEnregistrements($strNomTableEquipes, "$tabChampsTableEquipes[1]='$strNouveauNomEquipe'", "$tabChampsTableEquipes[0]='$intJeton'");
            
            $_SESSION["InfosEtudiant"]["NomEquipe"] = $strNouveauNomEquipe;
        }
    }
    
    /*--------------------------------------------------------------------------
     * 13) retireEquipe (16-04-2018)
     * 
     * But: Permettre à l'étudiant de se retirer de l'équipe dont il fait partie
     * 
     * Validation: Gestion des messages d'erreur pour le programme
     * -------------------------------------------------------------------------
     */
    function retireEquipe(mysql $BDProjet02, $strNomTableEquipes, $strNomTableMembres, $intJeton, $strDA) {
        global $tabChampsTableMembres,$tabChampsTableEquipes;
        
        if ($BDProjet02->selectionneEnregistrements($strNomTableMembres,"C=$tabChampsTableMembres[0]='$intJeton' AND $tabChampsTableMembres[1]='$strDA'") == 1) {
            $BDProjet02->supprimeEnregistrements($strNomTableMembres, "$tabChampsTableMembres[0]='$intJeton' AND $tabChampsTableMembres[1]='$strDA'");
            
            $_SESSION["InfosEtudiant"]["NoJeton"] = NULL;
            $_SESSION["InfosEtudiant"]["NomEquipe"] = NULL;
            
            if ($BDProjet02->selectionneEnregistrements($strNomTableMembres, "C=$tabChampsTableMembres[0]='$intJeton'") < 1) {
                $BDProjet02->supprimeEnregistrements($strNomTableEquipes,"$tabChampsTableEquipes[0]='$intJeton'");
            }
        }
    }
    
    /*-----------------------------------------------------------------------
     * typeErreur (16-04-2018)
     * 
     * Retour: Le message d'erreur selon le code d'erreur envoyé en paramètre
     * ----------------------------------------------------------------------
     */
    function typeErreur(int $intCodeErreur) {
        $strMessage = "";
        switch ($intCodeErreur) {
            case 1:
                $strMessage = "01 : DA invalide ou non reconnu !";
                break;
            case 11:
                $strMessage = "11 : Aucun nom d'équipe saisie!";
                break;
            case 12:
                $strMessage = "12 : Nom d'équipe ne débute pas par une lettre "
                    . "ou n'est pas composé de 5 à 15 lettres minuscules (ou"
                    . " caractères de soulignement)!";
                break;
            case 13:
                $strMessage = "13 : Nom d'équipe déjà utilisé!";
                break;
            case 14:
                $strMessage = "14 : Nom d'équipe saisi est identique au nom actuel!";
                break;
            case 21:
                $strMessage = "21 : Aucun numéro de jeton saisi!";
                break;
            case 22:
                $strMessage = "22 : Numéro de jeton saisi n'est pas un entier"
                    . " ou dans l'intervalle 10000 à 99999!";
                break;
            case 23:
                $strMessage = "23 : Numéro de jeton saisi ne correspond pas à "
                    . "votre numéro de jeton!";
                break;
            case 24:
                $strMessage = "24 : Numéro de jeton saisi ne correspond à aucune"
                    . " équipe enregistrée!";
                break;
            case 31:
                $strMessage = "31 : L'équipe est complète!";
                break;
            default :
                break;
        }
        
        return "Erreur " . $strMessage;
    }
    
    /*-----------------------------------------------------------------
     * gestionErreur (17-04-2018) parametre a mettre optionnel...
     * 
     * Paramètre: $strNomTableMembres (optionnel)
     * But: Valide si une erreur est présent pour la donnée envoyée.
     * Retour: La validation (bool) et s'il a lieu le message d'erreur.
     * ----------------------------------------------------------------
     */
    function gestionErreur(mysql $BDProjet02 ,$chrTypeDonne, $strChamps, $strVariableSession, $strNomTable,&$strMessage) {
        global $tabChampsTableEquipes, $tabChampsTableMembres;
        $strMessageFinal = "";
        
        if ($chrTypeDonne == 'j') {
            if (!$strChamps) {
                $strMessageFinal = typeErreur(21);
            }
            else if ($strChamps && !preg_match("/^\d{5}$/", $strChamps)) {
                $strMessageFinal = typeErreur(22);
            }
            else if (!empty($strVariableSession) && ($strChamps != $strVariableSession)) {
                $strMessageFinal = typeErreur(23);
            }
            else if ($BDProjet02->selectionneEnregistrements($strNomTable,"C=$tabChampsTableEquipes[0]='$strChamps'") < 1) {
                $strMessageFinal = typeErreur(24);
            }
            else if ((func_num_args() == 7) && $BDProjet02->selectionneEnregistrements(func_get_arg(6),"C=$tabChampsTableMembres[0]='$strChamps'") == 3) {
                $strMessageFinal = typeErreur(31);
            }
        }
        else if ($chrTypeDonne == 'e') {
            if (!$strChamps) {
                $strMessageFinal = typeErreur(11);
            }
            else if ($strChamps && !preg_match("/^[a-z]{1}[a-z|_]{4,11}$/", $strChamps)) {
                $strMessageFinal = typeErreur(12);
            }
            else if ($strChamps == $strVariableSession) {
                $strMessageFinal = typeErreur(14);
            }
            else if ($BDProjet02->selectionneEnregistrements($strNomTable,"C=$tabChampsTableEquipes[1]='$strChamps'") > 0) {
                $strMessageFinal = typeErreur(13);
            }    
        }
        
        $booResultat = empty($strMessageFinal);
        $strMessage = $booResultat ? $strMessage : $strMessageFinal;
        
        return $booResultat;
    }   