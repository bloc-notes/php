<?php 
   /* Inclusion des fichiers librairie */
   require_once "librairie-date.php";
   require_once "librairie-generale.php";
   require_once "solution-exercice01.php";

   /* En-tête de la page Web */
   $strTitreApplication = "Fonctions utilitaires";
   $strNomFichierCSS = "index.css";
   $strNomAuteur = "Philippe Joseph Clermont Michel Doyon";
   require_once("en-tete.php");
?>
   <div id="divValidation" class="">
      <p class="sTitreSection">
         aujourdhui()
      </p>
      <p style="font-family:consolas; font-size:16px;">
<?php
   echo aujourdhui() . "<br />";
   echo aujourdhui(true) . "<br />";
   echo aujourdhui(false);
?>
      </p>
      <p class="sTitreSection">
         bissextile() et nombreJoursAnnee()
      </p>
      <p style="font-family:consolas; font-size:16px;">
<?php
   $intAnnee = 2016;
   echo "$intAnnee => " . (bissextile($intAnnee) ? "Bissextile" : "Non bissextile") . " (" . nombreJoursAnnee($intAnnee) . ")<br />";
   $intAnnee = 2017;
   echo "$intAnnee => " . (bissextile($intAnnee) ? "Bissextile" : "Non bissextile") . " (" . nombreJoursAnnee($intAnnee) . ")<br />";
?>
      </p>
      <p class="sTitreSection">
         nombreJoursMois()
      </p>
      <p style="font-family:consolas; font-size:16px;">
<?php
   $intAnnee=2016;
   for ($intMois=1; $intMois <= 12; $intMois++) {
      echo ajouteZeros($intMois, 2) . "-" . $intAnnee . " => " . nombreJoursMois($intMois, $intAnnee) . " jours";
      echo "&nbsp;&nbsp;&nbsp;";
      echo ajouteZeros($intMois, 2) . "-" . ($intAnnee+1) . " => " . nombreJoursMois($intMois, $intAnnee+1) . " jours<br />";
   }
?>
      </p>
      <p class="sTitreSection">
         nombreJoursEntreDeuxDates()
      </p>
      <p style="font-family:consolas; font-size:16px;">
<?php
   /* Validation de 'nombreJoursEntreDeuxDates' */
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
      <p style="font-family:consolas; font-size:16px;">
<?php
   $intJour; 
   $intMois; 
   $intAnnee;
   $intJourSemaine;
   extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee);
   echo substr(jourSemaineEnLitteral($intJourSemaine), 0, 3) . "-" . ajouteZeros($intAnnee, 4) . "-" . ajouteZeros($intMois, 2) . "-" . ajouteZeros($intJour, 2) . "<br />";
   $strDate = "01-03-2017";
   extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $strDate);
   echo "$strDate => " . substr(jourSemaineEnLitteral($intJourSemaine), 0, 3) . "-" . ajouteZeros($intAnnee, 4) . "-" . ajouteZeros($intMois, 2) . "-" . ajouteZeros($intJour, 2) . "<br />";
   $strDate = "2017-12-31";
   extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $strDate);
   echo "$strDate => " . substr(jourSemaineEnLitteral($intJourSemaine), 0, 3) . "-$intAnnee-$intMois-$intJour<br />";
?>
      </p>
      <span class="sTitreSection">
         dateValide()
      </span>
      <br />
      <p style="font-family:consolas; font-size:16px; margin-right:50px; float:left;">
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
   $strDate="01-02-2017"; testeDate($strDate); $strDate="28-02-2017"; testeDate($strDate); $strDate="29-02-2017"; testeDate($strDate);
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
      <p style="font-family:consolas; font-size:16px;">
<?php      
   $strDate="jj-01-2016"; testeDate($strDate, true); $strDate="01-mm-2016"; testeDate($strDate, true); $strDate="01-01-aaaa"; testeDate($strDate, true);
   $strDate="00-01-2016"; testeDate($strDate, true); $strDate="32-01-2016"; testeDate($strDate, true);
   $strDate="01-00-2016"; testeDate($strDate, true); $strDate="01-13-2016"; testeDate($strDate, true);
   $strDate="01-01-2016"; testeDate($strDate, true); $strDate="31-01-2016"; testeDate($strDate, true);
   $strDate="01-02-2016"; testeDate($strDate, true); $strDate="29-02-2016"; testeDate($strDate, true); $strDate="30-02-2016"; testeDate($strDate, true);
   $strDate="01-02-2017"; testeDate($strDate, true); $strDate="28-02-2017"; testeDate($strDate, true); $strDate="29-02-2017"; testeDate($strDate, true);
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
   </div>
<?php   
   require_once("pied-page.php");
?>
