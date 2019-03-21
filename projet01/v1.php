<?php
    require_once "utilitaires-projet01.php";

    $strTitreApplication = "État de compte (Projet 1)";
    $strNomFichierCSS = "index.css";
    $strNomAuteur = "Philippe Doyon";
    $strModeTransmission = "get";
    
    /* Initialisation des variables de travail */
    $strNomFichierTexte = "donnees/etat-compte.txt";
    $fp = null; /* Pointeur sur le fichier 'etat-compte.txt' */
    
    //Lecture fichier etat-compte.txt et entrepose donnée
    
    /* Ouverture du fichier texte en lecture*/
    $fp = fopen($strNomFichierTexte, "r");
    
    $strDateDuJour = "";
    $strDateDeDepart = "";
    $strDateDeFin = "";
    $fltSoldeDebut = 0;
    $fltTauxInteretAnnuel = 0;
    
    //Lecture données de base du prêt
    list($strDateDuJour, $strDateDeDepart, $strDateDeFin, $fltSoldeDebut, $fltTauxInteretAnnuel) =
            explode(";", str_replace("\n", "", str_replace("\r", "", fgets($fp))));
    
    $strDateDuJour = ($strDateDuJour == "aujourdhui") ? aujourdhui() : $strDateDuJour;
    $fltSoldeDebut = str_replace(',','.',$fltSoldeDebut);
    $fltTauxInteretAnnuel = str_replace(',','.',$fltTauxInteretAnnuel);
    $fltTauxInteretQuotidien = ($fltTauxInteretAnnuel /100) / 365;

    /* Fermeture du fichier*/
    fclose($fp);

    $intNbJoursPret = nombreJoursEntreDeuxDates($strDateDeDepart, $strDateDeFin) + 1;
    
    require_once "en-tete.php";
?>
        <div id="divDonneesLues" class="">
            <p class="sTitreSection">
                Données de base sur le prêt
            </p>
            <table>
                <tr>
                    <td>Date du jour : </td>
                    <td class="sGras">
                        <a href="#AccesDirectDateJour"><span id="DateDuJour"><?php echo $strDateDuJour;?></span></a>
                    </td>
                </tr>
                <tr>
                    <td>Date de départ : </td>
                    <td class="sGras"><span id="DateDepart"><?php echo $strDateDeDepart;?></span></td>
                </tr>
                <tr>
                    <td>Date de fin : </td>
                    <td class="sGras"><span id="DateFin"><?php echo $strDateDeFin;?></span></td>
                </tr>
                <tr>
                    <td>Solde de début : </td>
                    <td class="sGras sDroite"><span id="SoldeDebut"><?php echo dollar($fltSoldeDebut);?></span></td>
                </tr>
                <tr>
                    <td>Taux intérêt annuel : </td>
                    <td class="sGras sDroite"><span id="TauxInteretAnnuel"><?php echo pourcent($fltTauxInteretAnnuel / 100);?></span></td>
                    <td class="sDroite"><span class="sGras">pourcent($fltTauxInteretQuotidien, 15)</span> par jour</td>
                </tr>
            </table>
        </div>
        <div id="divStatistiques" class="">
            <p class="sTitreSection">
                Intérêts cumulés et paiements effectués
            </p>
            <p id="lblFluxInteretsEtPaiements"></p>
        </div>
        <div id="divEtatCompte" class="">
            <p class="sTitreSection">
                État de compte au quotidien
            </p>
            <table>
                <tr>
                    <td class="sEntete sDroite">No</td>
                    <td class="sEntete">Journée</td>
                    <td class="sEntete">Date</td>
                    <td class="sEntete sDroite">Intérêts<br />quotidien</td>
                    <td class="sEntete sDroite">Solde avant<br />paiement</td>
                    <td class="sEntete sDroite">Paiement<br />courant</td>
                    <td class="sEntete sDroite">Solde après<br />paiement</td>
                </tr>
<?php
    //Date pour la boucle
    $strDateTravaille = $strDateDeDepart;
    
    $fltSoldeApresPaiement = $fltSoldeDebut;
    //Chaque jour en tableau
    for($intIndex = 0; $intIndex < $intNbJoursPret;$intIndex++) {
        
        //Journée du prêt
        if($intIndex == 0) {
?>
                <tr class="<?php echo ($strDateDuJour == $strDateTravaille) ? "sFondBleu" : ((jour($strDateTravaille) == "01") ? "sFondVert" : "");?>">             
                    <td class="sDroite">
                        <?php echo $intIndex + 1;?>
                    </td>
                    <td><?php echo jourSemaineEnLitteralDate($strDateTravaille);?></td>
                    <td><span id="<?php echo "Date" . ($intIndex + 1);?>"><?php echo $strDateTravaille;?></span></td>
                    <td class="sDroite">N/A</td>
                    <td class="sDroite">N/A</td>
                    <td class="sDroite"><?php echo (hierOuDemain($strDateDuJour, false) == $strDateTravaille) ? "<a id=\"AccesDirectDateJour\"></a>" : "";?>N/A</td>
                    <td class="sDroite"><?php echo dollar($fltSoldeApresPaiement);?></td>
                    <td class="sSansStyle">
<?php
        }
        //Toutes les autres journées
        else {
            $fltInteretQuotidien = round($fltSoldeApresPaiement * ($fltTauxInteretAnnuel / 100) / 365,2);
            $fltSoldeAvantPaiement = $fltSoldeApresPaiement + $fltInteretQuotidien;
            $fltSoldeApresPaiement = $fltSoldeAvantPaiement;
?>
                <tr class="<?php echo ($strDateDuJour == $strDateTravaille) ? "sFondBleu" : ((jour($strDateTravaille) == "01") ? "sFondVert" : "");?>">            
                    <td class="sDroite">
                       <a id="<?php echo str_replace('-','', $strDateTravaille);?>"></a>
                           <?php echo $intIndex + 1;?>
                    </td>
                    <td><?php echo jourSemaineEnLitteralDate($strDateTravaille);?></td>
                    <td><span id="<?php echo "Date" . ($intIndex + 1);?>"><?php echo $strDateTravaille;?></span></td>
                    <td class="sDroite"><?php echo dollar($fltInteretQuotidien);?></td>
                    <td class="sDroite"><?php echo dollar($fltSoldeAvantPaiement);?></td>
                    <td class="sGras sDroite"><?php echo (hierOuDemain($strDateDuJour, false) == $strDateTravaille) ? "<a id=\"AccesDirectDateJour\"></a>" : "";?><span id="<?php echo "Paiement" . ($intIndex + 1)?>"></span></td>
                    <td class="sDroite"><?php echo dollar($fltSoldeApresPaiement);?></span></td>
                    <td class="sSansStyle">
<?php
        }
        
        //Ajoute lien de déplacement
        if($intIndex % 7 == 0){
?>
                        <img src="images/vide.png" /> 
                        <a href="#AccesDebutPage" class="sNonSouligne">
                            <img src="images/haut.png" />
                        </a>
                        <a href="#AccesDirectDateJour" class="sNonSouligne">
                            <img src="images/courant.png" />
                        </a>
                        <a href="#AccesBasPage" class="sNonSouligne">
                            <img src="images/bas.png" />
                        </a>
<?php
        }
?>
                    </td>
                </tr>
<?php
        $strDateTravaille = hierOuDemain($strDateTravaille);
    }
?>
            </table>
        </div>
<?php
    require_once "pied-page.php";
    
    