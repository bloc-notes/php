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
    $tabPaiementEmprunt = array();
    $tabInteretEtPaiementParAnnee = array(); //Les données pour lblFluxInteretsEtPaiements
    
    //Lecture données de base du prêt
    list($strDateDuJour, $strDateDeDepart, $strDateDeFin, $fltSoldeDebut, $fltTauxInteretAnnuel) =
            explode(";", str_replace("\n", "", str_replace("\r", "", fgets($fp))));
    
    $strDateDuJour = ($strDateDuJour == "aujourdhui") ? aujourdhui() : $strDateDuJour;
    $fltSoldeDebut = str_replace(',','.',$fltSoldeDebut);
    $fltTauxInteretAnnuel = str_replace(',','.',$fltTauxInteretAnnuel);
    $fltTauxInteretQuotidien = ($fltTauxInteretAnnuel /100) / 365;
    
    while (!feof($fp)) {
        list ($strCle, $strValeur) = explode(";", str_replace("\n", "", str_replace("\r", "", fgets($fp))));
        
        $tabPaiementEmprunt[$strCle] = $strValeur;
    }

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
    
    $strDateHier = hierOuDemain($strDateDuJour, false);
    $fltSoldeApresPaiement = $fltSoldeDebut;
    //Chaque jour en tableau
    for($intIndex = 0; $intIndex < $intNbJoursPret;$intIndex++) {
        
        //Journée du prêt
        if($intIndex == 0) {
?>
                <tr<?php echo ($strDateDuJour == $strDateTravaille) ? " class=\"sFondBleu\"" : ((jour($strDateTravaille) == "01") ? " class=\"sFondVert\"" : "");?>>            
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
            $fltPaiementEmprunt = isset($tabPaiementEmprunt[$strDateTravaille]) ? str_replace(',','.',$tabPaiementEmprunt[$strDateTravaille]) : 0;
            
            $fltInteretQuotidien = round($fltSoldeApresPaiement * ($fltTauxInteretAnnuel / 100) / 365,2);
            $fltSoldeAvantPaiement = $fltSoldeApresPaiement + $fltInteretQuotidien;
            $fltSoldeApresPaiement = $fltSoldeAvantPaiement - $fltPaiementEmprunt ;
            
            $strAnneeEnVigueur = ((mois($strDateTravaille) == "01") && (jour($strDateTravaille) == "01")) ? annee($strDateTravaille) - 1 : annee($strDateTravaille);
            //Si non instancier
            if(!isset($tabInteretEtPaiementParAnnee[$strAnneeEnVigueur]["Interet"])) {
                $tabInteretEtPaiementParAnnee[$strAnneeEnVigueur]["Interet"] = $fltInteretQuotidien;
            }
            else {
                $tabInteretEtPaiementParAnnee[$strAnneeEnVigueur]["Interet"] += $fltInteretQuotidien;
            }
            
            //Si non instancier
            if(!isset($tabInteretEtPaiementParAnnee[$strAnneeEnVigueur]["Paiement"])) {
                $tabInteretEtPaiementParAnnee[$strAnneeEnVigueur]["Paiement"] = $fltPaiementEmprunt;
            }
            else {
                $tabInteretEtPaiementParAnnee[$strAnneeEnVigueur]["Paiement"] += $fltPaiementEmprunt;
            }
            
?>
                <tr<?php echo ($strDateDuJour == $strDateTravaille) ? " class=\"sFondBleu\"" : ((jour($strDateTravaille) == "01") ? " class=\"sFondVert\"" : "");?>>            
                    <td class="sDroite">
                       <a id="<?php echo str_replace('-','', $strDateTravaille);?>"></a>
                       <?php echo ($intIndex + 1) . PHP_EOL;?>
                    </td>
                    <td><?php echo jourSemaineEnLitteralDate($strDateTravaille);?></td>
                    <td><span id="<?php echo "Date" . ($intIndex + 1);?>"><?php echo $strDateTravaille;?></span></td>
                    <td class="sDroite"><?php echo dollar($fltInteretQuotidien);?></td>
                    <td class="sDroite"><?php echo dollar($fltSoldeAvantPaiement);?></td>
                    <td class="sGras sDroite">
                        <?php 
            echo ($strDateHier == $strDateTravaille) ? "<a id=\"AccesDirectDateJour\"></a>" : "";
            echo (nombreJoursEntreDeuxDates($strDateDuJour, $strDateTravaille) < 0) ? 
                    "<span id=\"Paiement\"" . ($intIndex + 1) . "\">" . (($fltPaiementEmprunt != 0) ? dollarParentheses($fltPaiementEmprunt) : "" ) . "</span>" :
                    input("Paiement" . ($intIndex + 1), "sPaiement", 8, (($fltPaiementEmprunt != 0) ? str_replace('.',',',$fltPaiementEmprunt) : "" )); 
            echo PHP_EOL;
?>
                    </td>
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
    $fltTotalInteret = array_sum(array_column($tabInteretEtPaiementParAnnee,"Interet" ));
    $fltTotalPaiement = array_sum(array_column($tabInteretEtPaiementParAnnee,"Paiement" ));
?>
                <tr>
                    <td class="sDroite" colspan="3">&sum; Intérêts : </td>
                    <td class="sGras sDroite"><?php echo dollarParentheses(array_sum(array_column($tabInteretEtPaiementParAnnee,"Interet" )));?></td>
                    <td class="sDroite">&sum; Paiements : </td>
                    <td class="sGras sDroite"><?php echo dollarParentheses(array_sum(array_column($tabInteretEtPaiementParAnnee,"Paiement" )));?></td>
                    <td class="sGras sDroite"><?php echo dollarParentheses($fltSoldeApresPaiement);?></td>
                    <td class="sGras sDroite"><?php echo abs((floatval($fltSoldeDebut) + $fltTotalInteret  - $fltTotalPaiement) - (round($fltSoldeApresPaiement,2))) < 0.00000001 ? "Ok":"Erreur" ;?></td>
                </tr>
            </table>
        </div>
<?php
    //génère lblFluxInteretsEtPaiements
    $intNbAnnee = count($tabInteretEtPaiementParAnnee);

    $strFluxInteretsEtPaiements = "<table><tr><td class=\"sEntete sDroite\">Année : </td>";
    
    for($intIndex = 0; $intIndex< $intNbAnnee;$intIndex++) {
        $strFluxInteretsEtPaiements .= "<td class=\"sDroite\" style=\"width:100px;\"><img src=\"images/pointeur.png\" style=\"vertical-align:-1px;\" />" . 
                                            key($tabInteretEtPaiementParAnnee) ."</td>";
        next($tabInteretEtPaiementParAnnee);
    }
    reset($tabInteretEtPaiementParAnnee);
    
    $strFluxInteretsEtPaiements .="<td class=\"sEntete sDroite\">Total</td></tr>";
    
    for($intIndex = 0; $intIndex< 2;$intIndex++) {
        $strFluxInteretsEtPaiements .= "<tr><td class=\"sEntete sDroite\">" . ($intIndex == 0 ? "Intérêts : " : "Paiements : ") . "</td>";
        
        for($intIndex2 = 0; $intIndex2< $intNbAnnee;$intIndex2++) { 
            $strFluxInteretsEtPaiements .= "<td class=\"sDroite\">" . dollarParentheses(current(current($tabInteretEtPaiementParAnnee))) . "</td>";
            next($tabInteretEtPaiementParAnnee[key($tabInteretEtPaiementParAnnee)]);
            next($tabInteretEtPaiementParAnnee);
        }
        $strFluxInteretsEtPaiements .= "<td class=\"sGras sDroite\">" . 
                                            dollarParentheses(($intIndex == 0 ? $fltTotalInteret: $fltTotalPaiement)) .
                                            "</td></tr>";
        reset($tabInteretEtPaiementParAnnee);
    }
    $strFluxInteretsEtPaiements .= "</table>";
    
    require_once "pied-page.php";
?>

<script type="text/javascript">
    document.getElementById('lblFluxInteretsEtPaiements').innerHTML = '<?php echo $strFluxInteretsEtPaiements;?>';
</script>