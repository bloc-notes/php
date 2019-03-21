<?php

require_once './librairies-communes-2018-03-16.php';
require_once './classe-mysql-2018-03-16.php';

//debug_to_console(post("hidEtat"));

session_start();
$strNomUtilisateur = $_SESSION["nomComplet"];
require_once "en-tete.php";

$intEtat = post("hidEtat");
switch ($intEtat) {
    case 0:
        //ouverture de la BD
        $strMonIP = "";
        $strIPServeur = "";
        $strNomServeur = "";
        $strInfosSensibles = "";
        detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);

        /* --- Initialisation des variables de travail --- */
        $strNomBD="pjf_microvox";
        $strLocalHost = "localhost";

        /* --- Création de l'instance, connexion avec mySQL et sélection de la base de données --- */
        $BDOption1 = new mysql($strNomBD, $strInfosSensibles);

        $strTableCoursSession = "CoursSession";
        $strRequeteCoursSessionCount = "count(*)";
        $arrNbTotalCoursSessionCount = $BDOption1->retourneSelect($strTableCoursSession, $strRequeteCoursSessionCount);

        $strTableDocument = "Document";
        $strRequeteDocument = "count(*)";
        $arrNbTotalDocument = $BDOption1->retourneSelect($strTableDocument, $strRequeteDocument);
        
        $strRequeteCoursSessionValue = "sessionCoursSession";
        $arrNbTotalCoursSessionValue = $BDOption1->retourneSelect($strTableCoursSession, $strRequeteCoursSessionValue);
        $BDOption1->deconnexion();
        
        //debug_to_console("bug inexplicable. "); //echo sans raison ???????????????????????????????????????????????????????
        //debug_to_console($arrNbTotalCoursSessionCount[0]." cours-sessions, ".$arrNbTotalDocument[0]." documents");
        
        $strBtnSelection = "btnSelection";
        $strBtnRetour = "btnRetour";

        if (isset($_POST[$strBtnRetour])) {
            header("Location: menuAdmin.php");
            exit();
        }
        /*else if (isset ($_POST[$strBtnSelection])) {
            ?>
                <script>
                    
                </script>
            <?php
        }*/
?>

        <div>
            <h1 class="sCentre">
                Mettre à jour la liste des documents
            </h1>
            <ul class="sCentre sMenu">
                <li>
                    Nombre total de cours-session enregistrés:
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php echo $arrNbTotalCoursSessionCount[0]; ?>
                    <br/><br/>
                </li>
                <li>
                    Nombre total de documents enregistrés:
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php echo $arrNbTotalDocument[0]; ?>
                    <br/><br/>
                </li>
                <li>
                    <select>
                        <option value="Test">Test</option>
                        <option value="Livre">Livre</option>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php echo $arrNbTotalDocument[0]; ?>
                    <br/><br/>
                </li>
                <li class="sOption">         
                    <button id="<?php echo $strBtnRetour; ?>" type="submit" name="<?php echo $strBtnRetour; ?>"><strong>Retour</strong></button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button id="<?php echo $strBtnSelection; ?>" type="button" name="<?php echo $strBtnSelection; ?>" onclick="soumettrePageEtat(1,'option1.php');"><strong>Sélection</strong></button><br/>
                </li>
            </ul>
        </div>

<?php
        break;
        
    case 1:
        $strIDDateCours = "";
        $strIDNoSequence = "";
        $strIDDateAccesDebut = "";
        $strIDDateAccesFin = "";
        $strIDTitre = "";
        $strIDDescription = "";
        $strIDNbPages= "";
        $strIDCategorie = "";
        $strIDNoVersion = "";
        $strIDDateVersion = "";
        $strIDHyperLien = "";
        ?>
                
        <div class="sCentre">
            <h1 class="sCentre">
                Mettre à jour la liste des documents
            </h1
            <br /><br />
            <ul>
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td>
                            DateCours:
                        </td>
                        <td>
                            <input id="<?php echo $strIDDateCours; ?>" name="<?php echo $strIDDateCours; ?>" class="" type="text" pattern=".{3,25}" title="3 à 25 charactères" value="<?php echo post($strIDDateCours); ?>" required autofocus/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NoSequence:
                        </td>
                        <td>
                            <select>
                                <?php
                                    for ($i=1; $i<21; $i++) {
                                ?>
                                    <option value="<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </option>
                                <?php
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <!--add input for adminStatus ???????-->
                    <tr>
                        <td>
                            DateAccèsDebut:
                        </td>
                        <td>
                            <input id="<?php echo $strIDDateAccesDebut; ?>" name="<?php echo $strIDDateAccesDebut; ?>" class="" type="text" pattern=".{3,30}" title="3 à 30 charactères" value="<?php echo post($strIDDateAccesDebut); ?>" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            DateAccèsFin:
                        </td>
                        <td>
                            <input id="<?php echo $strIDDateAccesFin; ?>" name="<?php echo $strIDDateAccesFin; ?>" class="" type="text" pattern=".{3,50}" title="3 à 50 charactères" value="<?php echo post($strIDDateAccesFin); ?>" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Titre:
                        </td>
                        <td>
                            <input id="<?php echo $strIDTitre; ?>" name="<?php echo $strIDTitre; ?>" class="" type="text" pattern=".{5,100}" title="5 à 100 charactères" value="<?php echo post($strIDTitre); ?>" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Description:
                        </td>
                        <td>
                            <input id="<?php echo $strIDDescription; ?>" name="<?php echo $strIDDescription; ?>" class="" type="text" pattern=".{5,255}" title="5 à 255 charactères" value="<?php echo post($strIDDescription); ?>" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NbPages:
                        </td>
                        <td>
                            <input id="<?php echo $strIDNbPages; ?>" name="<?php echo $strIDNbPages; ?>" class="" type="text" pattern=".{1,999}" title="1 à 999 charactères" value="<?php echo post($strIDNbPages); ?>" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Catégorie:
                        </td>
                        <td>
                            <input id="<?php echo $strIDCategorie; ?>" name="<?php echo $strIDCategorie; ?>" class="" type="text" pattern=".{3,15}" title="3 à 15 charactères" value="<?php echo post($strIDCategorie); ?>" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NoVersion:
                        </td>
                        <td>
                            <input id="<?php echo $strIDNoVersion; ?>" name="<?php echo $strIDNoVersion; ?>" class="" type="text" pattern=".{1,99}" title="1 à 99 charactères" value="<?php echo post($strIDNoVersion); ?>" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            DateVersion:
                        </td>
                        <td>
                            <input id="<?php echo $strIDDateVersion; ?>" name="<?php echo $strIDDateVersion; ?>" class="" type="text" pattern=".{3,50}" title="3 à 50 charactères" value="<?php echo post($strIDDateVersion); ?>" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            HyperLien:
                        </td>
                        <td>
                            <input id="<?php echo $strIDHyperLien; ?>" name="<?php echo $strIDHyperLien; ?>" class="" type="text" pattern=".{5,255}" title="5 à 255 charactères" value="<?php echo post($strIDHyperLien); ?>" required/>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td> 
                            <input id ="btnSoumettre" name="btnSoumettre" type="submit" class="" value="Soumettre"/><br/><br/>
                        </td>
                    </tr>
                </table>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td>
                            Session:
                        </td>
                        <td>
                            H-2017
                        </td>
                    </tr>
                    <tr>
                        <td>
                            SigleCours:
                        </td>
                        <td>
                            424-4W5
                        </td>
                    </tr>
                    <tr>
                        <td>
                            DateCours:
                        </td>
                        <td>
                            2017-11-15
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NoSequence:
                        </td>
                        <td>
                            20
                        </td>
                    </tr>
                    <tr>
                        <td>
                            DateAccèsDebut:
                        </td>
                        <td>
                            2018-01-14
                        </td>
                    </tr>
                    <tr>
                        <td>
                            DateAccèsFin:
                        </td>
                        <td>
                            2018-05-30
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Titre:
                        </td>
                        <td>
                            Fichiers à copier sur le lecteur P
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Description:
                        </td>
                        <td>
                            Description du document
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NbPages:
                        </td>
                        <td>
                            144
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Catégorie:
                        </td>
                        <td>
                            Catégorie
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NoVersion:
                        </td>
                        <td>
                            1.1.0
                        </td>
                    </tr>
                    <tr>
                        <td>
                            DateVersion:
                        </td>
                        <td>
                            2017-10-30
                        </td>
                    </tr>
                    <tr>
                        <td>
                            HyperLien:
                        </td>
                        <td>
                            <a onclick="soumettrePageEtat(0,'option1.php');">Lien</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            AjoutePar:
                        </td>
                        <td>
                            <?php echo $_SESSION["nomComplet"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <tr>
                        <td></td>
                        <td> 
                            <input id ="btnModifier" name="btnModifier" type="submit" value="Modifier les données"/><br/><br/>
                        </td>
                    </tr>
                    </tr>
                </table>
            </ul>
            <br /><br />
        </div>
                
        <?php
        break;
}

require_once "pied-page.php";
