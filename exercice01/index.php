<?php 
   require_once("librairie-date-doyon.php");
   require_once("librairie-generale-doyon.php");
   require_once("librairie-exercice01.php");
   
   /* En-tête de la page Web */
   $strTitreApplication = "Validation de la librairie 'librairie-exercice01.php'";
   $strNomFichierCSS = "index.css";
   $strNomAuteur = "Philippe Doyon";
   require_once("en-tete.php");
?>
   <div id="divValidation" class="">
      
   <div id="divValidation" class="">
      
      <p class="sTitreSection">
         aujourdhui()
      </p>
      <p>
<?php
   echo aujourdhui() . "<br />";
   echo aujourdhui(true) . "<br />";
   echo aujourdhui(false);
?>
      </p>
      
      <p class="sTitreSection">
         bissextile() et nombreJoursAnnee()
      </p>
      <p>
<?php
   $intAnnee = 2016;
   echo "$intAnnee => " . (bissextile($intAnnee) ? "Bissextile" : "Non bissextile") . " (" . nombreJoursAnnee($intAnnee) . ")<br />";
   $intAnnee = 2018;
   echo "$intAnnee => " . (bissextile($intAnnee) ? "Bissextile" : "Non bissextile") . " (" . nombreJoursAnnee($intAnnee) . ")<br />";
?>
      </p>
      
      <p class="sTitreSection">
         nombreJoursMois()
      </p>
      <p>
<?php
   $intAnnee=2016;
   for ($intMois=1; $intMois <= 12; $intMois++) {
      echo ajouteZeros($intMois, 2) . "-" . $intAnnee . " => " . nombreJoursMois($intMois, $intAnnee) . " jours";
      echo "&nbsp;&nbsp;&nbsp;";
      echo ajouteZeros($intMois, 2) . "-" . ($intAnnee+2) . " => " . nombreJoursMois($intMois, $intAnnee+2) . " jours<br />";
   }
?>
      </p>
      
      <p class="sTitreSection">
         nombreJoursEntreDeuxDates()
      </p>
      <p>
<?php
   $strDate1 = "13-12-1901"; $strDate2 = aujourdhui(false);
   echo "Nombre de jours entre $strDate1 et $strDate2 : " . nombreJoursEntreDeuxDates($strDate1, $strDate2) . " ($strDate1 hors intervalle)<br />";
   $strDate1 = "14-12-1901"; $strDate2 = aujourdhui(false);
   echo "Nombre de jours entre $strDate1 et $strDate2 : " . nombreJoursEntreDeuxDates($strDate1, $strDate2) . "<br />";
   $strDate1 = "1901-12-14"; $strDate2 = aujourdhui();
   echo "Nombre de jours entre $strDate1 et $strDate2 : " . nombreJoursEntreDeuxDates($strDate1, $strDate2) . "<br />";
?>      
      </p>
      
      <p class="sTitreSection">
         extraitJSJJMMAAAAv2()
      </p>
      <p>
<?php
   $intJour; 
   $intMois; 
   $intAnnee;
   $intJourSemaine;
   extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee);
   echo substr(jourSemaineEnLitteral($intJourSemaine, true), 0, 3) . "-" . ajouteZeros($intAnnee, 4) . "-" . ajouteZeros($intMois, 2) . "-" . ajouteZeros($intJour, 2) . "<br />";
   $strDate = "01-03-2018";
   extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $strDate);
   echo "$strDate => " . substr(jourSemaineEnLitteral($intJourSemaine, true), 0, 3) . "-" . ajouteZeros($intAnnee, 4) . "-" . ajouteZeros($intMois, 2) . "-" . ajouteZeros($intJour, 2) . "<br />";
   $strDate = "2018-12-31";
   extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $strDate);
   echo "$strDate => " . substr(jourSemaineEnLitteral($intJourSemaine,true), 0, 3) . "-$intAnnee-$intMois-$intJour<br />";
?>
      </p>
      
      <span class="sTitreSection">
         dateValide()
      </span>
      <br />
      <p style="margin-right:50px; float:left;">
<?php
   function testeDate(&$strDate, $binInverse=false) {
      if ($binInverse) {
         $strDate = substr($strDate, 6, 4) . "-" . substr($strDate, 3, 2) . "-" . substr($strDate, 0, 2);
      }
      echo "$strDate => <span style=\"font-weight:bold;\">" . (dateValide($strDate) ? "Valide" : "Invalide") . "</span><br />";
   }
  
   $strDate="jj-01-2016"; testeDate($strDate); $strDate="01-mm-2016"; testeDate($strDate); $strDate="01-01-aaaa"; testeDate($strDate);
   $strDate="00-01-2016"; testeDate($strDate); $strDate="32-01-2016"; testeDate($strDate);
   $strDate="01-00-2016"; testeDate($strDate); $strDate="01-13-2016"; testeDate($strDate);
   $strDate="01-01-2016"; testeDate($strDate); $strDate="31-01-2016"; testeDate($strDate);
   $strDate="01-02-2016"; testeDate($strDate); $strDate="29-02-2016"; testeDate($strDate); $strDate="30-02-2016"; testeDate($strDate);
   $strDate="01-02-2018"; testeDate($strDate); $strDate="28-02-2018"; testeDate($strDate); $strDate="29-02-2018"; testeDate($strDate);
   $strDate="01-03-2016"; testeDate($strDate); $strDate="31-03-2016"; testeDate($strDate);
   $strDate="01-04-2016"; testeDate($strDate); $strDate="30-04-2016"; testeDate($strDate); $strDate="31-04-2016"; testeDate($strDate);
   $strDate="01-05-2016"; testeDate($strDate); $strDate="31-05-2016"; testeDate($strDate);
   $strDate="01-06-2016"; testeDate($strDate); $strDate="30-06-2016"; testeDate($strDate); $strDate="31-06-2016"; testeDate($strDate);
   $strDate="01-07-2016"; testeDate($strDate); $strDate="31-07-2016"; testeDate($strDate);
   $strDate="01-08-2016"; testeDate($strDate); $strDate="31-08-2016"; testeDate($strDate);
   $strDate="01-09-2016"; testeDate($strDate); $strDate="30-09-2016"; testeDate($strDate); $strDate="31-09-2016"; testeDate($strDate);
   $strDate="01-10-2016"; testeDate($strDate); $strDate="31-10-2016"; testeDate($strDate);
   $strDate="01-11-2016"; testeDate($strDate); $strDate="30-11-2016"; testeDate($strDate); $strDate="31-11-2016"; testeDate($strDate);
   $strDate="01-12-2016"; testeDate($strDate); $strDate="31-12-2016"; testeDate($strDate);
?>
      </p>
      <p>
<?php      
   $strDate="jj-01-2016"; testeDate($strDate, true); $strDate="01-mm-2016"; testeDate($strDate, true); $strDate="01-01-aaaa"; testeDate($strDate, true);
   $strDate="00-01-2016"; testeDate($strDate, true); $strDate="32-01-2016"; testeDate($strDate, true);
   $strDate="01-00-2016"; testeDate($strDate, true); $strDate="01-13-2016"; testeDate($strDate, true);
   $strDate="01-01-2016"; testeDate($strDate, true); $strDate="31-01-2016"; testeDate($strDate, true);
   $strDate="01-02-2016"; testeDate($strDate, true); $strDate="29-02-2016"; testeDate($strDate, true); $strDate="30-02-2016"; testeDate($strDate, true);
   $strDate="01-02-2018"; testeDate($strDate, true); $strDate="28-02-2018"; testeDate($strDate, true); $strDate="29-02-2018"; testeDate($strDate, true);
   $strDate="01-03-2016"; testeDate($strDate, true); $strDate="31-03-2016"; testeDate($strDate, true);
   $strDate="01-04-2016"; testeDate($strDate, true); $strDate="30-04-2016"; testeDate($strDate, true); $strDate="31-04-2016"; testeDate($strDate, true);
   $strDate="01-05-2016"; testeDate($strDate, true); $strDate="31-05-2016"; testeDate($strDate, true);
   $strDate="01-06-2016"; testeDate($strDate, true); $strDate="30-06-2016"; testeDate($strDate, true); $strDate="31-06-2016"; testeDate($strDate, true);
   $strDate="01-07-2016"; testeDate($strDate, true); $strDate="31-07-2016"; testeDate($strDate, true);
   $strDate="01-08-2016"; testeDate($strDate, true); $strDate="31-08-2016"; testeDate($strDate, true);
   $strDate="01-09-2016"; testeDate($strDate, true); $strDate="30-09-2016"; testeDate($strDate, true); $strDate="31-09-2016"; testeDate($strDate, true);
   $strDate="01-10-2016"; testeDate($strDate, true); $strDate="31-10-2016"; testeDate($strDate, true);
   $strDate="01-11-2016"; testeDate($strDate, true); $strDate="30-11-2016"; testeDate($strDate, true); $strDate="31-11-2016"; testeDate($strDate, true);
   $strDate="01-12-2016"; testeDate($strDate, true); $strDate="31-12-2016"; testeDate($strDate, true);
?>
      </p>
      <p style="clear:both"></p>
      
      <p class="sTitreSection">
         dateEnLitteral()
      </p>
      <p>
<?php
   /* Date SANS le jour de la semaine */
   echo dateEnLitteral() . "<br />";
   echo dateEnLitteral("01-01-2019") . "<br />";
   echo dateEnLitteral("2019-01-01") . "<br />";
   echo "<br />";
   
   /* Date AVEC le jour de la semaine */
   echo dateEnLitteral("C") . "<br />";
   echo dateEnLitteral("c") . "<br />";
   echo dateEnLitteral("31-12-2018", "C") . "<br />";
   echo dateEnLitteral("2019-02-05", "c") . "<br />";
   echo dateEnLitteral("C", "06-03-2019") . "<br />";
   echo dateEnLitteral("c", "2019-04-11") . "<br />";
?>
      </p>

      <p class="sTitreSection">
         AAAAMMJJ()
      </p>
      <p>
<?php
   echo AAAAMMJJ("31-12-2018") . "<br />";
   echo AAAAMMJJ("31-12-18") . "<br />";
   echo AAAAMMJJ(31, 12, 2018) . "<br />";
   echo AAAAMMJJ(31, 12, 18);
?>
      </p>
      
      <p class="sTitreSection">
         get() et input()
      </p>
      Nom : <input id="tbNom" name="tbNom" type="text" maxlength="20" value="Legendre" />
      Prénom : <input id="tbPrenom" name="tbPrenom" type="text" maxlength="15" value="Pierre" />
      <p>
         tbNom = <?php echo get("tbNom"); ?>
         <br />
         tbPrenom = <?php echo get("tbPrenom"); ?>
      </p>

      Ville : <?php echo input("tbVille", "sVille", "20", "Montréal"); ?>
      Province : <?php echo input("tbProvince", "sProvince", "2", "Qc", false); ?>
      Code postal : <?php input("tbCodePostal", "sCodePostal", "7", "H4G 1Y1", true); ?>
      Téléphone : <?php input("tbTelephone", "sTelephone", "12", "", true); ?>
      <input type="submit" value="Recharger" />
      <p>
         tbVille = <?php echo get("tbVille"); ?>
         <br />
         tbProvince = <?php echo get("tbProvince"); ?>
         <br />
         tbCodePostal = <?php echo get("tbCodePostal"); ?>
         <br />
         tbTelephone = <?php echo get("tbTelephone"); ?>
      </p>
      
      <p class="sTitreSection">
         annee(), mois() et jour()
      </p>
      <p>
      Date : <?php echo $strDate = aujourdhui(true); ?><br />
      Jour : <?php echo jour($strDate); ?><br />
      Mois : <?php echo mois($strDate); ?><br />
      Année: <?php echo annee($strDate); ?><br />
      <br />
      Date : <?php echo $strDate = aujourdhui(false); ?><br />
      Jour : <?php echo jour($strDate); ?><br />
      Mois : <?php echo mois($strDate); ?><br />
      Année: <?php echo annee($strDate); ?><br />
      
   </div>

<?php   
   require_once("pied-page.php");
?>