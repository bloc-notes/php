<?php
    require_once("Librairie-G Doyon.php");
    require_once("Classe-fichier.php");
    
    /* Variables nécessaires pour les fichiers d'inclusion */
    $strTitreApplication = "Gestion des appartements (LÉSi)";
    $strNomFichierCSS = "index.css";
    $strNomAuteur = "Philippe Doyon";
    
    require_once("en-tete.php");

    $fchAppartement = new fichier("liste_appartements.txt");
    $fchAppartement->chargeEnMemoire();
    
    $intNbLignes = $fchAppartement->intNbLignes;
    $fchAppartement->ferme();
    
    $tValeurs = array();
    $i=0;
    $intSommeNoCivique = 0;
    $intSommeNoAppartement = 0;
    $intSommeloyer = 0;
    $intNbPiece = 0;
    $intNbMeuble = 0;
    $intNbChauffe =0;
    $intNbHomme = 0;
    $intNbFemme = 0;
    $intNbDisponible = 0;
    $intNbAnnuel = 0;
    $intNbMensuel = 0;
    $intNbHebdomadaire = 0;
    $intVacant = 0;
    $intSommeDate = 0;
    
    $fchAppartement->ouvre();
    
    while (!$fchAppartement->detecteFin()) {
      $fchAppartement->litDonneesLigne($tValeurs[$i], ";", "NoCivique", "RueEtAppartement", "Ville", "CodePostal",
              "PrenomC", "NomC", "NoTelephoneC", "No", "Sexe" ,"PrenomL","NomL","NoTelephoneL","NoCellulaireL","TypeLoyer",
              "MontantLoyer","NbPiece" , "Meumbler","Chauffer","DateSignatureBail");
      
      $intSommeNoCivique += $tValeurs[$i]["NoCivique"];
      $intSommeNoAppartement += $tValeurs[$i]["No"];
      $intNbFemme += $tValeurs[$i]["Sexe"] == "F" ? 1:0;
      $intNbHomme += $tValeurs[$i]["Sexe"] == "H" ? 1:0;
      $intVacant += $tValeurs[$i]["DateSignatureBail"] == "" ? 1:0;
      $intNbAnnuel += $tValeurs[$i]["TypeLoyer"] == "A" ? 1:0;
      $intNbMensuel += $tValeurs[$i]["TypeLoyer"] == "M" ? 1:0;
      $intNbHebdomadaire += $tValeurs[$i]["TypeLoyer"] == "H" ? 1:0;
      $intSommeloyer += $tValeurs[$i]["MontantLoyer"];
      $intNbMeuble += $tValeurs[$i]["Meumbler"] == "oui" ? 1:0;
      $NoPieceTempo = str_replace(",", ".", $tValeurs[$i]["NbPiece"]);
      $intNbPiece += $NoPieceTempo;
      $intNbChauffe += $tValeurs[$i]["Chauffer"] == "oui" ? 1:0;
      
      if(!empty($tValeurs[$i]["DateSignatureBail"])){
          $intSommeDate += nombreJoursEntreDeuxDates("2000-01-01",$tValeurs[$i]["DateSignatureBail"]);
      }
      
      $i++;
   }
   
   
   $fchAppartement->ferme();
?>
    <div id="divVerification">
      <p class="sTitreSection">
         Sommes de vérification
      </p>
      <table>
         <tr>
            <td class="sAucuneBordure">Somme totale des numéros civiques : </td>      
            <td class="sAucuneBordure sDroite">
            <span id="lblSommeNoCiv" class="sVerification"></span>
            </td>
         </tr>
         <tr>
            <td class="sAucuneBordure">Somme totale des numéros d'appartement : </td>
            <td class="sAucuneBordure sDroite">
               <span id="lblSommeNoApp" class="sVerification"></span>
            </td>
         </tr>
         <tr>
            <td class="sAucuneBordure">Décompte des femmes / hommes / VACANT = TOTAL : </td>
            <td class="sAucuneBordure sDroite">
               <span id="lblCompteSexeNbFemme" class="sVerification"></span> /
               <span id="lblCompteSexeNbHomme" class="sVerification"></span> /
               <span id="lblCompteSexeNbVacant" class="sVerification"></span> =
               <span id="lblCompteSexeNbTotal" class="sVerification"></span>
            </td>
         </tr>
         <tr>
            <td class="sAucuneBordure">Décompte des baux annuels / mensuels / hebdos / VACANT = TOTAL : </td>
            <td class="sAucuneBordure sDroite">
               <span id="lblCompteBailNbAnnuel" class="sVerification"></span> /
               <span id="lblCompteBailNbMensuel" class="sVerification"></span> /
               <span id="lblCompteBailNbHebdo" class="sVerification"></span> /
               <span id="lblCompteBailNbVacant" class="sVerification"></span> =
               <span id="lblCompteBailNbTotal" class="sVerification"></span>
            </td>
         </tr>
         <tr>
            <td class="sAucuneBordure">Somme totale des montants de loyers : </td>
            <td class="sAucuneBordure sDroite">
               <span id="lblSommeLoyer" class="sVerification"></span>
            </td>
         </tr>
         <tr>
            <td class="sAucuneBordure">Décompte total du nombre de pièces : </td>
            <td class="sAucuneBordure sDroite">
               <span id="lblDecompteNbPieces" class="sVerification"></span>
            </td>
         </tr>
         <tr>
            <td class="sAucuneBordure">Décompte du nombre d'appartements meublés / chauffés : </td>
            <td class="sAucuneBordure sDroite">
               <span id="lblCompteNbMeuble" class="sVerification"></span> /
               <span id="lblCompteNbChauffe" class="sVerification"></span>
            </td>
         </tr>
         <tr>
            <td class="sAucuneBordure">Somme totale de l'écart en jours de chaque date de signature avec le 1er janvier 2000 : </td>
            <td class="sAucuneBordure sDroite">
               <span id="lblSommeNbJoursDateSignature" class="sVerification"></span>
            </td>
         </tr>
         
      </table>
    </div>  
    <div id="divCorps" class="">
        <p class="sTitreSection">
         Données lues dans le fichier 'liste_appartements.txt'
        </p>
        <table style="width:3000px;">
            <tr>
                <td class="sEntete1 sCentre" colspan="2">Données sur l'immeuble</td>
                <td class="sEntete1 sCentre" colspan="4">Données sur l'appartement</td>
                <td class="sEntete1 sCentre" colspan="4">Données sur le locataire</td>
                <td class="sEntete1 sCentre" colspan="3">Données sur le bail courant</td>
            </tr>
            <tr>
               <td class="sEntete2 sGauche" style="width:430px;">Adresse complète</td>
               <td class="sEntete2 sGauche" style="width:280px;">Personne contact</td>

               <td class="sEntete2 sDroite" style="width:50px;">No</td>
               <td class="sEntete2 sDroite" style="width:80px;">Nb pièces</td>
               <td class="sEntete2 sCentre" style="width:70px;">Meublé?</td>
               <td class="sEntete2 sCentre" style="width:70px;">Chauffé?</td>

               <td class="sEntete2 sGauche" style="width:180px;">Nom complet</td>
               <td class="sEntete2 sCentre" style="width:60px;">Sexe</td>
               <td class="sEntete2 sDroite" style="width:120px;">Téléphone</td>
               <td class="sEntete2 sDroite" style="width:120px;">Cellulaire</td>

               <td class="sEntete2 sCentre" style="width:80px;">TypeBail</td>
               <td class="sEntete2 sDroite" style="width:60px;">Loyer</td>
               <td class="sEntete2 sDroite" style="width:110px;">DateSignature</td>
               <td class="sAucuneBordure"></td>
            </tr>
<?php
    
    
    
    for ($j=0; $j<$intNbLignes; $j++) {
        $strSexe = "";
        $strLoyer = "";
        $strMontant = "";
        if($tValeurs[$j]["DateSignatureBail"] != ""){
            $strSexe = $tValeurs[$j]["Sexe"] == "H" ? "Homme" : "Femme";
            $strLoyer = $tValeurs[$j]["TypeLoyer"] == "A" ? "Annuel" : ($tValeurs[$j]["TypeLoyer"] == "M" ? "Mensuel" : "Hebdomadaire");
            
            $strMontant= $tValeurs[$j]["MontantLoyer"] . " $";
?>
            <tr class="">
<?php
        }
        else{
?>
            <tr class="sVacant">
<?php
        }
?>        
                <td><?php echo $tValeurs[$j]["NoCivique"] ." " .$tValeurs[$j]["RueEtAppartement"] . ", ". 
                $tValeurs[$j]["Ville"]. " (Québec), " . $tValeurs[$j]["CodePostal"];?></td> 
                
                <td><?php echo $tValeurs[$j]["PrenomC"] . " " . $tValeurs[$j]["NomC"] . ", " .$tValeurs[$j]["NoTelephoneC"];?></td>
                
                <td class="sDroite"><?php echo $tValeurs[$j]["No"];?></td>
                <td class="sDroite"><?php echo $tValeurs[$j]["NbPiece"];?></td>
                <td class="sCentre"><?php echo $tValeurs[$j]["Meumbler"];?></td>
                <td class="sCentre"><?php echo $tValeurs[$j]["Chauffer"];?></td>
                
                <td class="sGauche"><?php echo $tValeurs[$j]["PrenomL"] ." " . $tValeurs[$j]["NomL"];?></td>
                <td class="sCentre"><?php echo $strSexe;?></td>
                <td class="sDroite"><?php echo $tValeurs[$j]["NoTelephoneL"];?></td>
                <td class="sDroite"><?php echo $tValeurs[$j]["NoCellulaireL"];?></td>
                
                <td class="sCentre"><?php echo $strLoyer;?></td>
                <td class="sDroite"><?php echo $strMontant;?></td>
                <td class="sDroite"><?php echo $tValeurs[$j]["DateSignatureBail"];?></td>     
  
<?php                
    }
?>        
            </tr>
       </table>
   </div>
   <script type="text/javascript">
      document.getElementById('lblSommeNoCiv').innerHTML = '<?php echo $intSommeNoCivique; ?>';
      document.getElementById('lblSommeNoApp').innerHTML = '<?php echo $intSommeNoAppartement;?>';
      document.getElementById('lblCompteSexeNbFemme').innerHTML = '<?php echo $intNbFemme;?>';
      document.getElementById('lblCompteSexeNbHomme').innerHTML = '<?php echo $intNbHomme;?>';
      document.getElementById('lblCompteSexeNbVacant').innerHTML = '<?php echo $intVacant;?>';
      document.getElementById('lblCompteSexeNbTotal').innerHTML = '<?php echo $intNbFemme + $intNbHomme + $intVacant;?>';
      document.getElementById('lblCompteBailNbAnnuel').innerHTML = '<?php echo $intNbAnnuel;?>';
      document.getElementById('lblCompteBailNbMensuel').innerHTML = '<?php echo $intNbMensuel;?>';
      document.getElementById('lblCompteBailNbHebdo').innerHTML = '<?php echo $intNbHebdomadaire;?>';
      document.getElementById('lblCompteBailNbVacant').innerHTML = '<?php echo $intVacant;?>';
      document.getElementById('lblCompteBailNbTotal').innerHTML = '<?php echo $intNbAnnuel + $intNbMensuel + $intNbHebdomadaire + $intVacant;?>';
      document.getElementById('lblSommeLoyer').innerHTML = '<?php echo $intSommeloyer;?>$';
      document.getElementById('lblDecompteNbPieces').innerHTML = '<?php echo $intNbPiece;?>';
      document.getElementById('lblCompteNbMeuble').innerHTML = '<?php echo $intNbMeuble;?>';
      document.getElementById('lblCompteNbChauffe').innerHTML = '<?php echo $intNbChauffe;?>';
      document.getElementById('lblSommeNbJoursDateSignature').innerHTML = '<?php echo $intSommeDate;?>';
   </script>
      <div id="divPiedPage">
         <p class="sDroits">
            &copy; Département d'informatique G.-G.
         </p>
      </div>
   </form>
</html>