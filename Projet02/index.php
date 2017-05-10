<?php
    //Philippe Doyon
    require_once("Librairie-G Doyon.php");
    require_once("Classe-mysql.php");
    require_once("fonctions-specifiques-projet02.php");
    /*
   |-------------------------------------------------------------------------------------|
   | Initialisation des variables globales
   |-------------------------------------------------------------------------------------|
   */
   $dblTauxTPS = 0.05;
   $dblTauxTVQ = 0.09975;
   
   $strDateCourante = isset($_GET["dateDateCourante"]) ? $_GET["dateDateCourante"] : date("Y-m-d");
   $strDateCouranteReelle = date("Y-m-d");
   $strHeureCourante = date("H:i:s");

   $strLocalHost = "localhost";
   $strNomBD = "bdh17_doyon";
   
   $strNomTableTypesLivraison        = "prj2_types_livraison";
   $strNomFichierTypesLivraison      =      "types_livraison.txt";
   $strNomTableCommandes             = "prj2_commandes";
   $strNomFichierCommandes           =      "commandes.txt";
   $strNomTableHistoriqueCommandes   = "prj2_historique_commandes";
   $strNomFichierHistoriqueCommandes =      "historique_commandes.txt";
   
    /*
   |-------------------------------------------------------------------------------------|
   | Gestion des tables sql
   |-------------------------------------------------------------------------------------|
   */
   
   $strMonIP = "";
   $strIPServeur = "";
   $strNomServeur = "";
   $strInfosSensibles = "";
   detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);
   
   $BDProjet2 = new mysql($strNomBD, $strInfosSensibles);
   
   if(!$BDProjet2->tableExiste($strNomTableTypesLivraison )){
       //crée et remplie la table
       creeTableTypesLivraison($BDProjet2, $strNomTableTypesLivraison);
       remplitTableTypesLivraison($BDProjet2, $strNomTableTypesLivraison,
               $strNomFichierTypesLivraison);
   }
   
   if (!$BDProjet2->tableExiste($strNomTableCommandes )){
       //crée et remplie la table
       creeTableCommandes($BDProjet2, $strNomTableCommandes);
       remplitTableCommandes($BDProjet2, $strNomTableCommandes,
               $strNomFichierCommandes);
   }
   
   if (!$BDProjet2->tableExiste($strNomTableHistoriqueCommandes)){
       //crée table
       creeTableHistoriqueCommandes($BDProjet2, $strNomTableHistoriqueCommandes);
   }
   
   if(!is_null(get('subReconstructionTables'))){
       //supprime et reconstruit table
       $BDProjet2->supprimeEnregistrements($strNomTableCommandes);
       $BDProjet2->supprimeEnregistrements($strNomTableHistoriqueCommandes);
       
       remplitTableCommandes($BDProjet2, $strNomTableCommandes,
               $strNomFichierCommandes);
       
   }
   
   if(!is_null(get('subSuppressionTables'))){
       //Supprime table
       
       $BDProjet2->supprimeEnregistrements($strNomTableCommandes);
       $BDProjet2->supprimeEnregistrements($strNomTableHistoriqueCommandes);    
   }
   
   
   //Tableau Type enregistrement
   $intNbEnregistrement = $BDProjet2->selectionneEnregistrements($strNomTableTypesLivraison,"T=NoTypeLivraison ASC");
   $tabType = array();
   for($d=0;$d<$intNbEnregistrement;$d++){
       $tabType[$d+1] = mysqli_fetch_array($BDProjet2->_listeEnregistrements);
   }
   
   //Action
   
   $BtnAction = get('hidOperation');
   $intNoCommandeATraiter = get('hidNoCommande');
   
   switch ($BtnAction) {
    case "btnAjoutCommande":
        ajouteCommande($BDProjet2, $strNomTableCommandes);
        break;
    case "btnLivraisonCommande":
        livreCommande($BDProjet2, $strNomTableCommandes, $intNoCommandeATraiter);
        break;
    case "btnAnnulationLivraisonCommande":
        annuleLivraisonCommande($BDProjet2, $strNomTableCommandes,$intNoCommandeATraiter);
        break;
    case "btnAnnulationCommande":
        annuleCommande($BDProjet2, $strNomTableCommandes, $intNoCommandeATraiter);
        break;
    case "btnReactivationCommande":
        reactiveCommande($BDProjet2, $strNomTableCommandes, $intNoCommandeATraiter);
        break;
    case "btnSuppressionCommande":
        supprimeCommande($BDProjet2, $strNomTableCommandes, $intNoCommandeATraiter);
        break;
    case "btnArchivageCommande":
        echo "voila7";
        archiveCommande($BDProjet2, $strNomTableCommandes, $strNomTableHistoriqueCommandes, $intNoCommandeATraiter);
        break;  
}   
?>
<!DOCTYPE html>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <title>Projet 2</title>
   <link rel="stylesheet" type="text/css" href="reset.css" />
   <style type="text/css">
      BODY, INPUT, SELECT { font-family:verdana; font-size:14px; }
      BODY { padding-left:15px; padding-top:15px; }
      TD { border:solid 1px black; padding:3px; height:25px; vertical-align:middle; }
      .sTitreApplication { font-size:28px; line-height:26px; font-weight:bold; margin-top:0px; }
      .sTitreSection { font-size:18px; line-height:18px; font-weight:bold; }

      .sActualiser { font-size:12px;vertical-align:3px; color:black; }
      .sBouton { width:100px; }
      .sDroite { text-align:right; }
      .sDroits { font-size:12px; } 
      .sEnteteNouvelle { background-color:#ffff00; }
      .sEnteteALivrer { background-color:#00ff00; }
      .sEnteteLivree { background-color:#00ffff; }
      .sEnteteAnnulee { background-color:#ff0000; }
      .sEnteteArchivee { background-color:#ff00ff; }
      .sErreur { background-color:#CCCCCC; }
      .sGras { font-weight:bold; }
      .sSansFormat { border:none; background-color:#FFFFFF; }
      .sNonGras { font-weight:normal; }
      .sRouge { color:red; }
      
      .sTDCoutLivraison { width:90px; }
      .sTDDate { width:110px; } .sDateCommande { width:100px; text-align:right; }
      .sTDMontantAvTaxes, .sTDMontantRedevances, .sTDMontantFraisLESi { width:100px; } .sMontantAvTaxes { width:75px; text-align:right; }
      .sTDNoAutorisation { width:75px; }
      .sTDNoClient { width:60px; }  .sNoClient { width:50px; text-align:right; }
      .sTDNoCommande, .sTDNoHistorique { width:85px; }
      .sTDNoVendeur { width:65px; } .sNoVendeur { width:25px; text-align:right; }
      .sTDStatut { width:65px; }
      .sTDTPS { width:90px; }
      .sTDTVQ { width:90px; }
      .sTDTypeLivraison { width:230px; }
   </style>
   
   <script type="text/javascript" src="librairie-generale.js"></script>
   
   <script type="text/javascript">
      /*
      |----------------------------------------------------------------------------------------|
      | completeRESET
      |----------------------------------------------------------------------------------------|
      */
      function completeRESET() {
         /* Réinitialisation de tous les styles */
         s('tbNoClient', 'sNoClient');
         s('tbNoVendeur', 'sNoVendeur');
         s('tbDateCommande', 'sDateCommande');
         s('tbMontantAvTaxes', 'sMontantAvTaxes');
         s('ddlTypesLivraison', '');
         /* Réinitialisation du coût de livraison, de la TPS et de la TVQ */
         initialiseZones('CoutLivraison');
         initialiseZones('TPS');
         initialiseZones('TVQ');
      }
      /*
      |----------------------------------------------------------------------------------|
      | effectueCalculsSelonTypeLivraison
      |----------------------------------------------------------------------------------|
      */
      function effectueCalculsSelonTypeLivraison(strTypeLivraison) {
         var dblCoutLivraison, dblTPS, dblTVQ;
         /* Récupération du choix sélectionné */
         if (strTypeLivraison.split(';')[0] == 0) {
            /* Si aucun choix effectué, réinitialisation du coût de livraison, TPS et TVQ */
            initialiseZones('CoutLivraison');
            initialiseZones('TPS');
            initialiseZones('TVQ');
         }
         else {
            /* Détermination du taux de taxes */
            dblTauxTPS = <?php echo $dblTauxTPS; ?>;
            dblTauxTVQ = <?php echo $dblTauxTVQ; ?>;
            /* Récupération du coût de livraison */
            dblCoutLivraison = parseFloat(strTypeLivraison.split(';')[1], 10);
            /* Entreposage, puis affichage du coût de livraison */
            initialiseZones('CoutLivraison', arronditEtFormate(dblCoutLivraison, 2));
            /* Calcul du montant sur lequel sera calculé la TPS et la TVQ en autant que le montant avant taxes est numérique */
            if (estNumerique(document.getElementById('tbMontantAvTaxes').value)) {
               var dblMontantAvecLivraison = parseFloat(document.getElementById('tbMontantAvTaxes').value, 10) + parseFloat(dblCoutLivraison, 10);
               /* Calcul, entreposage, puis affichage de la TPS */
               var dblTPS = dblMontantAvecLivraison * dblTauxTPS;
               initialiseZones('TPS', arronditEtFormate(dblTPS, 2));
               /* Calcul, entreposage, puis affichage de la TVQ */
               var dblTVQ = dblMontantAvecLivraison * dblTauxTVQ;
               initialiseZones('TVQ', arronditEtFormate(dblTVQ, 2));
            }
            else {
               /* Réinitialisation de la TPS et de la TVQ */
               initialiseZones('TPS');
               initialiseZones('TVQ');
            }
         }  
      }
      /*
      |----------------------------------------------------------------------------------|
      | initialiseZones
      |----------------------------------------------------------------------------------|
      */
      function initialiseZones(strIDPartiel, strValeur) {
         document.getElementById('hid' + strIDPartiel).value = strValeur;
         document.getElementById('lbl' + strIDPartiel).innerHTML = strValeur == null ? '&lt;calculé&gt;' : strValeur;
      }
      /*
      |----------------------------------------------------------------------------------|
      | soumetFormulaireCommandes
      |----------------------------------------------------------------------------------|
      */
      function soumetFormulaireCommande(strID, intNo) {
         var binPoursuit = true;
         if (strID == 'btnSuppressionCommande') {
            if (!confirm('Cliquez sur OK pour confirmer la suppression de la commande no ' + intNo + '; autrement cliquez sur ANNULER.')) {
               binPoursuit = false;
            }
         }
         else if (strID == 'btnArchivageCommande') {
            if (!confirm('Cliquez sur OK pour confirmer l\'archivage de la commande no ' + intNo + '; autrement cliquez sur ANNULER.')) {
               binPoursuit = false;
            }
         }
         if (binPoursuit) {
            b('hidOperation', strID);
            b('hidNoCommande', intNo);
            b('hidDateCourante', b('dateDateCourante'));
            document.getElementById('frmSaisie').submit();
         }
      }
      /*
      |----------------------------------------------------------------------------------|
      | valideToutesLesZonesSaisies
      |----------------------------------------------------------------------------------|
      */
      function valideToutesLesZonesSaisies() {
         /* Récupération du contenu des zones de saisie */
         var strNoClient = b('tbNoClient');
         var strNoVendeur = b('tbNoVendeur');
         var strDateCommande = b('tbDateCommande');
         var strMontantAvTaxes = b('tbMontantAvTaxes');
         var strTypeLivraisonSelectionne = b('ddlTypesLivraison');
         /* Validation desdites zones de saisie */
         var binNoClientValide = estNumerique(strNoClient) && parseInt(strNoClient, 10).dansIntervalle(10000, 99999);
         var binNoVendeurValide = estNumerique(strNoVendeur) && parseInt(strNoVendeur, 10).dansIntervalle(10, 99);
         var binDateCommandeValide = valideDateMinimalement(strDateCommande);
         var binMontantAvTaxesValide = estNumerique(strMontantAvTaxes) && parseFloat(strMontantAvTaxes, 10) >= 1 && parseFloat(strMontantAvTaxes, 10) < 100000;
         var binTypeLivraisonSelectionne = strTypeLivraisonSelectionne != 0;
         /* Ajustement du style */
         s('tbNoClient', 'sNoClient ' + (binNoClientValide ? '' : 'sErreur'));
         s('tbNoVendeur', 'sNoVendeur ' + (binNoVendeurValide ? '' : 'sErreur'));
         s('tbDateCommande', 'sDateCommande ' + (binDateCommandeValide ? '' : 'sErreur'));
         s('tbMontantAvTaxes', 'sMontantAvTaxes ' + (binMontantAvTaxesValide ? '' : 'sErreur'));
         s('ddlTypesLivraison', binTypeLivraisonSelectionne ? '' : 'sErreur');
         /* Retourne le verdict */
         return binNoClientValide && binNoVendeurValide && binDateCommandeValide && binMontantAvTaxesValide && binTypeLivraisonSelectionne;
      }
      /*
      |----------------------------------------------------------------------------------|
      | validePuisSoumetFormulaire
      |----------------------------------------------------------------------------------|
      */
      function validePuisSoumetFormulaire(strID) {
         if (valideToutesLesZonesSaisies()) {
            b('hidOperation', strID);
            document.getElementById('frmSaisie').submit();
         }
      }
</script>
</head>
<body>
   <form id="frmSaisie" method="get" action="">
      <input id="hidOperation" name="hidOperation" type="hidden" />
      <input id="hidNoCommande" name="hidNoCommande" type="hidden" />
      <input id="hidDateCourante" name="hidDateCourante" type="hidden" />
      <div id="divEntete">
         <p class="sTitreApplication">
            Projet 2<br />
            <span class="sTitreSection">
               <span class="sNonGras">par</span><span class="sRouge"> Philippe Doyon</span>
            </span>
            <input id="btnActualiser" name="btnActualiser" type="button" value="Actualiser" class="sActualiser" onclick="document.location=document.location.pathname"; />
         </p>
         <p>
            <br />
            Dernier chargement de la page : <span class="sGras"><?php echo "$strDateCouranteReelle</span> à <span class=\"sGras\">$strHeureCourante"; ?></span><br /><br />
            Date du jour :
            <input id="dateDateCourante" name="dateDateCourante" type="Date" class="sGras" value="<?php echo $strDateCourante; ?>" onchange="b('tbDateCommande', this.value);"/><br /><br />
         </p>
      </div>

      <div id="divInscriptionNouvelleCommande">
         <p class="sTitreSection">
            <br />
            Enregistrement d'une nouvelle commande
            <br /><br />
         </p>
         <table>
            <tr class="sDroite sEnteteNouvelle">
               <td class="sTDNoCommande">No<br/>Commande</td>
               <td class="sTDNoClient">No<br />Client</td>
               <td class="sTDNoVendeur">No<br />Vendeur</td>
               <td class="sTDDate">Date<br />Commande</td>
               <td class="sTDMontantAvTaxes">Montant<br />avant taxes</td>
               <td class="sTDCoutLivraison">Coût<br />livraison</td>
               <td class="sTDTPS"><br />TPS</td>
               <td class="sTDTVQ"><br />TVQ</td>
               <td class="sTDTypeLivraison">Type de<br />livraison</td>
               <td class="sTDStatut"><br />Statut</td>
               <td class="sTDNoAutorisation">No<br />Autorisation</td>
               <td class="sSansFormat"></td>
            </tr>
<?php
   /*
   |-------------------------------------------------------------------------------------|
   | Initialisation des zones de texte (input)
   |-------------------------------------------------------------------------------------|
   */
   $tbDateCommande = $strDateCourante;
?>   
            <tr class="sDroite">
               <td>
                  &lt;calculé&gt;
               </td>
               <td>
                  <input id="tbNoClient" name="tbNoClient" type="text" class="sNoClient" maxlength="5" onblur="valideToutesLesZonesSaisies();" />
               </td>
               <td>
                  <input id="tbNoVendeur" name="tbNoVendeur" type="text" class="sNoVendeur" maxlength="2" onblur="valideToutesLesZonesSaisies();" />
               </td>
               <td>
                  <input id="tbDateCommande" name="tbDateCommande" type="text" value="<?php echo $tbDateCommande; ?>" class="sDateCommande" maxlength="10" onblur="valideToutesLesZonesSaisies();" />
               </td>
               <td>
                  <input id="tbMontantAvTaxes" name="tbMontantAvTaxes" type="text" class="sMontantAvTaxes" maxlength="8" onblur="valideToutesLesZonesSaisies(); effectueCalculsSelonTypeLivraison(document.getElementById('ddlTypesLivraison').value);" /> $
               </td>
               <td>
                  <span id="lblCoutLivraison">
                     &lt;calculé&gt;
                  </span> $
                  <input id="hidCoutLivraison" name="hidCoutLivraison" type="hidden" />
               </td>
               <td>
                  <span id="lblTPS">
                     &lt;calculé&gt;
                  </span> $
                  <input id="hidTPS" name="hidTPS" type="hidden" />
               </td>
               <td>
                  <span id="lblTVQ">
                     &lt;calculé&gt;
                  </span> $
                  <input id="hidTVQ" name="hidTVQ" type="hidden" />
               </td>
               <td>
                  <select id="ddlTypesLivraison" name="ddlTypesLivraison" onchange="valideToutesLesZonesSaisies();effectueCalculsSelonTypeLivraison(this.value);">
                     <!-- Aux fins de la démonstration seulement -->
                     <option value="0">Choisir</option>
                     <option value="1;3.95">Poste régulière (96 heures)</option>
                     <option value="2;9.95">Poste prioritaire (48 heures)</option>
                     <option value="3;14.95">Purolator (24 heures)</option>
                     <option value="4;17.95">UPS (18 heures)</option>
                     <option value="5;24.95">Dicom (12 heures)</option>
                  </select>
               </td>
               <td>
                  À livrer
               </td>
               <td>
                  <span id="lblNoAutorisation"></span>
                  <input id="hidNoAutorisation" name="hidNoAutorisation" type="hidden" />
                  <script type="text/javascript">
                     initialiseZones('NoAutorisation', genereNombre(10000000, 99999999));
                  </script>
               </td>
               <td class="sSansFormat">
                  <input id="btnAjoutCommande" name="btnAjoutCommande" type="button" value="Soumettre" class="sBouton" onclick="validePuisSoumetFormulaire(this.id);" />
                  <input id="resetReinitialiser" name="resetReinitialiser" type="reset" value="Réinitialiser" class="sBouton" onclick="completeRESET();" />
               </td>
            </tr>
         </table>
      </div>
   
      <div id="divListeCommandesALivrer">
<?php
    $intNbCommandes = $BDProjet2->selectionneEnregistrements($strNomTableCommandes,
                                "C=Statut=1 AND DateAnnulation='0000-00-00'", 
                                "T=DateCommande ASC, MontantAvTaxes DESC");
?>
         <p class="sTitreSection">
            <br />
            <?php echo $intNbCommandes;?> commande<?php echo $intNbCommandes > 1? "s":"";?> à livrer
            <input id="subReconstructionTables" name="subReconstructionTables" type="submit" value="Reconstruction des tables" />
            <input id="subSuppressionTables" name="subSuppressionTables" type="submit" value="Suppression des tables" />
            <br /><br />
         </p>
         <table>
            <tr class="sDroite sEnteteALivrer">
               <td class="sTDNoCommande">No<br/>Commande</td>
               <td class="sTDNoClient">No<br />Client</td>
               <td class="sTDNoVendeur">No<br />Vendeur</td>
               <td class="sTDDate">Date<br />Commande</td>
               <td class="sTDMontantAvTaxes">Montant<br />avant taxes</td>
               <td class="sTDCoutLivraison">Coût<br />livraison</td>
               <td class="sTDTPS"><br />TPS</td>
               <td class="sTDTVQ"><br />TVQ</td>
               <td class="sTDTypeLivraison">Type de<br />livraison</td>
               <td class="sTDStatut"><br />Statut</td>
               <td class="sTDNoAutorisation">No<br />Autorisation</td>
               <td class="sTDDate">Date<br />Livraison</td>
               <td class="sTDDate">Date<br />Annulation</td>
               <td class="sSansFormat"></td>
            </tr>
<?php
    for($i=0;$i<$intNbCommandes;$i++){
        $intTypeLivraison = $BDProjet2->contenuChamp($i, "TypeLivraison");
        $intNoComm = $BDProjet2->contenuChamp($i, "NoCommande");
?>
            <tr class="sDroite">
               <td>
                   <?php echo ajouteZero($BDProjet2->contenuChamp($i, "NoCommande"), 4) . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($i, "NoClient") . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($i, "NoVendeur") . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($i, "DateCommande") . "\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($i, "MontantAvTaxes"))  . " $\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($i, "CoutLivraison")) . " $\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($i, "CoutTPS")) . " $\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($i, "CoutTVQ")) . " $\n";?>
               </td>
               <td>
                   <?php echo $tabType[$intTypeLivraison]['DescriptionFournisseurLivraison'] . "(" . $tabType[$intTypeLivraison]['DelaiLivraison'] . " Heure". ($tabType[$intTypeLivraison]['DelaiLivraison']>1?"s":"") .")\n";?>
               </td>
               <td>
                  À livrer
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($i, "NoAutorisation") . "\n";?>
               </td>
               <td>
                  N/A
               </td>
               <td>
                  N/A
               </td>
               <td class="sSansFormat">
                  <input id="btnLivraisonCommande" name="btnLivraisonCommande" type="button" value="Livrer" class="sBouton" onclick="soumetFormulaireCommande(this.id,<?php echo $intNoComm;?>)" />
                  <input id="btnAnnulationCommande" name="btnAnnulationCommande" type="button" value="Annuler" class="sBouton" onclick="soumetFormulaireCommande(this.id,<?php echo $intNoComm;?>)" />
               </td>
            </tr>
<?php
    }
?>
         </table>
      </div>

      <div id="divListeCommandesLivreesEtArchivees">
<?php
    $intNbLivraisonEtArchiver = $BDProjet2->selectionneEnregistrements($strNomTableCommandes,
                                "C=Statut=2 OR Statut=3", 
                                "T=Statut ASC, NoVendeur ASC, DateCommande ASC");
    $chrPluriel = $intNbCommandes > 1 ? "s":"";
?>
         <p class="sTitreSection">
            <br />
            <?php echo $intNbLivraisonEtArchiver;?> commande<?php echo $chrPluriel;?> livrée<?php echo $chrPluriel;?> et <span style="color:gray;">archivée<?php echo $chrPluriel;?></span>
            <input id="subReconstructionTables" name="subReconstructionTables" type="submit" value="Reconstruction des tables" />
            <input id="subSuppressionTables" name="subSuppressionTables" type="submit" value="Suppression des tables" />
            <br /><br />
         </p>
         <table>
            <tr class="sDroite sEnteteLivree">
               <td class="sTDNoCommande">No<br/>Commande</td>
               <td class="sTDNoClient">No<br />Client</td>
               <td class="sTDNoVendeur">No<br />Vendeur</td>
               <td class="sTDDate">Date<br />Commande</td>
               <td class="sTDMontantAvTaxes">Montant<br />avant taxes</td>
               <td class="sTDCoutLivraison">Coût<br />livraison</td>
               <td class="sTDTPS"><br />TPS</td>
               <td class="sTDTVQ"><br />TVQ</td>
               <td class="sTDTypeLivraison">Type de<br />livraison</td>
               <td class="sTDStatut"><br />Statut</td>
               <td class="sTDNoAutorisation">No<br />Autorisation</td>
               <td class="sTDDate">Date<br />Livraison</td>
               <td class="sTDDate">Date<br />Annulation</td>
               <td class="sSansFormat"></td>
            </tr>
<?php
    for($j=0;$j<$intNbLivraisonEtArchiver;$j++){
        $intTypeLivraison = $BDProjet2->contenuChamp($j, "TypeLivraison");
        $intNoComm = $BDProjet2->contenuChamp($j, "NoCommande");
?>
            <tr class="sDroite" <?php echo $BDProjet2->contenuChamp($j, "Statut") == 3 ? "style=\"color:gray;\"":"";?> >
               <td>
                   <?php echo ajouteZero($BDProjet2->contenuChamp($j, "NoCommande"), 4) . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($j, "NoClient") . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($j, "NoVendeur") . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($j, "DateCommande") . "\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($j, "MontantAvTaxes"))  . " $\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($j, "CoutLivraison")) . " $\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($j, "CoutTPS")) . " $\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($j, "CoutTVQ")) . " $\n";?>
               </td>
               <td>
                   <?php echo $tabType[$intTypeLivraison]['DescriptionFournisseurLivraison'] . "(" . $tabType[$intTypeLivraison]['DelaiLivraison'] . " Heure". ($tabType[$intTypeLivraison]['DelaiLivraison']>1?"s":"") .")\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($j, "Statut") == 2 ? "Livrée":"Archivée" . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($j, "NoAutorisation") . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($j, "DateLivraison") . "\n";?>
               </td>
               <td>
                  N/A
               </td>
<?php
    if($BDProjet2->contenuChamp($j, "Statut") == 2){
?>
               <td class="sSansFormat">
                  <input id="btnAnnulationLivraisonCommande" name="btnAnnulationLivraisonCommande" type="button" value="Annuler" class="sBouton" onclick="soumetFormulaireCommande(this.id,<?php echo $intNoComm;?>)" />
                  <input id="btnArchivageCommande" name="btnArchivageCommande" type="button" value="Archiver" class="sBouton" onclick="soumetFormulaireCommande(this.id,<?php echo $intNoComm;?>)" />
               </td>
<?php
    }
?>
            </tr>
<?php
    }
?>
         </table>
      </div>
<?php
    $intNbAnnuler = $BDProjet2->selectionneEnregistrements($strNomTableCommandes,
                                "C=DateAnnulation!='0000-00-00'", 
                                "T=NoVendeur ASC, DateCommande ASC");
    $chrPlurielAnnuler = $intNbAnnuler > 1 ? "s":"";
?>
      <div id="divListeCommandesAnnulees">

         <p class="sTitreSection">
            <br />
            <?php echo $intNbAnnuler;?> commande<?php echo $chrPlurielAnnuler;?> temporairement annulée<?php echo $chrPlurielAnnuler;?>
            <input id="subReconstructionTables" name="subReconstructionTables" type="submit" value="Reconstruction des tables" />
            <input id="subSuppressionTables" name="subSuppressionTables" type="submit" value="Suppression des tables" />
            <br /><br />
         </p>
         <table>
            <tr class="sDroite sEnteteAnnulee">
               <td class="sTDNoCommande">No<br/>Commande</td>
               <td class="sTDNoClient">No<br />Client</td>
               <td class="sTDNoVendeur">No<br />Vendeur</td>
               <td class="sTDDate">Date<br />Commande</td>
               <td class="sTDMontantAvTaxes">Montant<br />avant taxes</td>
               <td class="sTDCoutLivraison">Coût<br />livraison</td>
               <td class="sTDTPS"><br />TPS</td>
               <td class="sTDTVQ"><br />TVQ</td>
               <td class="sTDTypeLivraison">Type de<br />livraison</td>
               <td class="sTDStatut"><br />Statut</td>
               <td class="sTDNoAutorisation">No<br />Autorisation</td>
               <td class="sTDDate">Date<br />Livraison</td>
               <td class="sTDDate">Date<br />Annulation</td>
               <td class="sSansFormat"></td>
            </tr>
<?php
    for($k=0;$k<$intNbAnnuler;$k++){
        $intTypeLivraison = $BDProjet2->contenuChamp($k, "TypeLivraison");
        $intNoComm = $BDProjet2->contenuChamp($k, "NoCommande");
?>
            <tr class="sDroite">
               <td>
                   <?php echo ajouteZero($BDProjet2->contenuChamp($k, "NoCommande"), 4) . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($k, "NoClient") . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($k, "NoVendeur") . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($k, "DateCommande") . "\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($k, "MontantAvTaxes"))  . " $\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($k, "CoutLivraison")) . " $\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($k, "CoutTPS")) . " $\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($k, "CoutTVQ")) . " $\n";?>
               </td>
               <td>
                   <?php echo $tabType[$intTypeLivraison]['DescriptionFournisseurLivraison'] . " (" . $tabType[$intTypeLivraison]['DelaiLivraison'] . " heure". ($tabType[$intTypeLivraison]['DelaiLivraison']>1?"s":"") .")\n";?>
               </td>
               <td>
                  N/A
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($k, "NoAutorisation") . "\n";?>
               </td>
               <td>
                  N/A
               </td>
               <td>
                  <?php echo $BDProjet2->contenuChamp($k, "DateAnnulation") ."\n";?>
               </td>
               <td class="sSansFormat">
                  <input id="btnReactivationCommande" name="btnReactivationCommande" type="button" value="Réactiver" class="sBouton" onclick="soumetFormulaireCommande(this.id,<?php echo $intNoComm;?>)" />
                  <input id="btnSuppressionCommande" name="btnSuppressionCommande" type="button" value="Supprimer" class="sBouton" onclick="soumetFormulaireCommande(this.id,<?php echo $intNoComm;?>)" />
               </td>
            </tr>
<?php
    }
?>
         </table>
      </div>
   
      <div id="divListeCommandesArchivees">
<?php
    $intNbArchiver = $BDProjet2->selectionneEnregistrements($strNomTableHistoriqueCommandes, 
                                "T=NoVendeur ASC, DateVente ASC");
    $chrPlurielArchiver = $intNbArchiver > 1 ? "s":"";
?>
         <p class="sTitreSection">
            <br />
            <?php echo $intNbArchiver;?> commande<?php echo $chrPlurielArchiver;?> archivée<?php echo $chrPlurielArchiver;?>
            <input id="subReconstructionTables" name="subReconstructionTables" type="submit" value="Reconstruction des tables" />
            <input id="subSuppressionTables" name="subSuppressionTables" type="submit" value="Suppression des tables" />
            <br /><br />
         </p>
         <table>
            <tr class="sDroite sEnteteArchivee">
               <td class="sTDNoHistorique">No<br/>Historique</td>
               <td class="sTDDate">Date<br />Archivage</td>
               <td class="sTDNoVendeur">No<br />Vendeur</td>
               <td class="sTDNoClient">No<br />Client</td>
               <td class="sTDNoCommande">No<br/>Commande</td>
               <td class="sTDNoAutorisation">No<br />Autorisation</td>
               <td class="sTDDate">Date<br />Vente</td>
               <td class="sTDMontantAvTaxes">Montant<br />avant taxes</td>
               <td class="sTDCoutLivraison">Frais<br />livraison</td>
               <td class="sTDTPS">Frais<br />TPS</td>
               <td class="sTDTVQ">Frais<br />TVQ</td>
               <td class="sTDMontantRedevances">Montant<br />Redevances</td>
               <td class="sTDMontantFraisLESi"><br />Frais LÉSi</td>
            </tr>
<?php
    for($l=0;$l<$intNbArchiver;$l++){
        $intTypeLivraison = $BDProjet2->contenuChamp($l, "TypeLivraison");
        $intNoComm = $BDProjet2->contenuChamp($l, "NoCommande");
?>
            <tr class="sDroite">
               <td>
                   <?php echo ajouteZero($BDProjet2->contenuChamp($l, "NoHistorique"), 4) . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($l, "DateArchivage") . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($l, "NoVendeur") . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($l, "NoClient") . "\n";?>
               </td>
               <td>
                   <?php echo ajouteZero($BDProjet2->contenuChamp($l, "NoCommande"), 4) . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($l, "NoAutorisation") . "\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($l, "DateVente") . "\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($l, "MontantAvTaxes"))  . " $\n";?>
               </td>
               <td>
                   <?php echo $BDProjet2->contenuChamp($l, "FraisLivraison") . "\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($l, "FraisTPS")) . " $\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($l, "FraisTVQ")) . " $\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($l, "Redevances")) . " $\n";?>
               </td>
               <td>
                   <?php echo str_replace(".", ",",$BDProjet2->contenuChamp($l, "FraisLESI")) . " $\n";?>
               </td>
            </tr>
<?php
    }   
?>
         </table>
      </div>

      <div id="divPiedPage">
         <p class="sDroits">
            <br />
            &copy; Département d'informatique G.-G.
         </p>
      </div>
   </form>
</body>
</html>