<?php 
   /* Inclusion des fichiers librairie */
   require_once("librairie-date.php");
   require_once("librairie-generale.php");
   require_once("solution-exercice01.php");
   require_once("solution-exercice02.php");

   /* En-tête de la page Web */
   $strTitreApplication = "Fonctions utilitaires (2)";
   $strNomFichierCSS = "index.css";
   $strNomAuteur = "Philippe Joseph Clermont Michel Doyon";
   require_once("en-tete.php");
?>
   <div id="divValidation" class="">
      <p class="sTitreSection">
         ecrit()
      </p>
      <p style="font-family:consolas; font-size:16px;">
<?php
   ecrit("Salut");
   ecrit(" la ", 0);
   ecrit("compagnie !", 1);
   ecrit(":-)", 3);
   ecrit(":-)");
?>
      </p>
      <p class="sTitreSection">
         droite()
      </p>
      <p style="font-family:consolas; font-size:16px;">
<?php
   $strChaine = "fonction";
   ecrit($strChaine, 2);
   for ($i=1; $i <= strlen($strChaine); $i++) {
      ecrit("[" . droite($strChaine, $i). "]", 1);
   }
?>
      </p>
      <p class="sTitreSection">
         encadre()
      </p>
      <p style="font-family:consolas; font-size:16px;">
<?php
   ecrit(encadre("Salut", "'"), 1);
   ecrit(encadre("Salut", "\""), 1);
   ecrit(encadre("Salut", "[]"), 1);
?>
      </p>
      <p class="sTitreSection">
         majuscules() et minuscules()
      </p>
      <p style="font-family:consolas; font-size:16px;">
<?php
   ecrit(majuscules("Salut"), 1);
	ecrit(majuscules("propriété"), 2);
   ecrit(minuscules("SALUT"), 1);
	ecrit(minuscules("PROPRIÉTÉS"));
?>
      </p>
      <p class="sTitreSection">
         estNumerique()
      </p>
      <p style="font-family:consolas; font-size:16px;">
<?php
   $strN = "9";
   ecrit($strN . " est " . (estNumerique($strN) ? "numérique" : "non numérique"), 1);
   $strN = "9b";
   ecrit($strN . " est " . (estNumerique($strN) ? "numérique" : "non numérique"), 1);
   $strN = "9,99";
   ecrit($strN . " est " . (estNumerique($strN) ? "numérique" : "non numérique"), 1);
   $strN = "9.99";
   ecrit($strN . " est " . (estNumerique($strN) ? "numérique" : "non numérique"), 1);
?>
      </p>
      <p class="sTitreSection">
         etatCivilValide()
      </p>
      <p>
<?php
   ecrit("<table style=\"font-family:consolas; font-size:16px;\">");
   foreach(array("C", "F", "M", "S", "D", "V", "A") as $chrEtatCivil) {
      ecrit("<tr>");
      $chrSexe = "h";
      $strEtatCivil = "Non initialisé";
      $binEtatCivil = etatCivilValide($chrEtatCivil, $chrSexe, $strEtatCivil);
      ecrit("<td>" .
            $chrEtatCivil . "," . $chrSexe . " => " . ($binEtatCivil ? "Valide" : "Invalide") . ", " . $strEtatCivil .
            "</td>");
      $chrSexe = "f";
      $strEtatCivil = "Non initialisé";
      $binEtatCivil = etatCivilValide($chrEtatCivil, $chrSexe, $strEtatCivil);
      ecrit("<td>" .
            $chrEtatCivil . "," . $chrSexe . " => " . ($binEtatCivil ? "Valide" : "Invalide") . ", " . $strEtatCivil .
            "</td>");
      ecrit("</tr>");
   }
   ecrit("</table>",2);
   
   ecrit("<table style=\"font-family:consolas; font-size:16px;\">");
   $strListeEtatsATester = "cfmsdva";
   for ($i=0; $i < strlen($strListeEtatsATester); $i++) {
      $chrEtatCivil = $strListeEtatsATester[$i];
      ecrit("<tr>");
      $chrSexe = "H";
      $strEtatCivil = "Non initialisé";
      $binEtatCivil = etatCivilValide($chrEtatCivil, $chrSexe, $strEtatCivil);
      ecrit("<td>" .
            $chrEtatCivil . "," . $chrSexe . " => " . ($binEtatCivil ? "Valide" : "Invalide") . ", " . $strEtatCivil .
            "</td>");
      $chrSexe = "F";
      $strEtatCivil = "Non initialisé";
      $binEtatCivil = etatCivilValide($chrEtatCivil, $chrSexe, $strEtatCivil);
      ecrit("<td>" .
            $chrEtatCivil . "," . $chrSexe . " => " . ($binEtatCivil ? "Valide" : "Invalide") . ", " . $strEtatCivil .
            "</td>");
      ecrit("</tr>");
   }
   ecrit("</table>");
?>
      </p>
      <p class="sTitreSection">
         decomposeURL()
      </p>
      <p style="font-family:consolas; font-size:16px;">
<?php
      $strURL = "http://424w.cgodin.qc.ca/test/index.php";
      decomposeURL($strURL,
                   $strChemin, $strNom, $strSuffixe);
      ecrit("URL : <span class=\"sGras\">$strURL</span>", 2);
      ecrit("Nom du chemin : <span class=\"sGras sRouge\">$strChemin</span>", 1);
      ecrit("Nom du fichier ou de la page : <span class=\"sGras sRouge\">$strNom</span>", 1);
      ecrit("Nom du suffixe : <span class=\"sGras sRouge\">$strSuffixe</span>", 2);

      $strURL = "laboratoire02.txt";
      decomposeURL($strURL,
	                $strChemin, $strNom, $strSuffixe);
      ecrit("URL : <span class=\"sGras\">$strURL</span>", 2);
      ecrit("Nom du chemin : <span class=\"sGras sRouge\">$strChemin</span>", 1);
      ecrit("Nom du fichier ou de la page : <span class=\"sGras sRouge\">$strNom</span>", 1);
      ecrit("Nom du suffixe : <span class=\"sGras sRouge\">$strSuffixe</span>", 2);

      $strURL = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
      decomposeURL($strURL,
                   $strChemin, $strNom, $strSuffixe);
      ecrit("URL : <span class=\"sGras\">$strURL</span>", 2);
      ecrit("Nom du chemin : <span class=\"sGras sRouge\">$strChemin</span>", 1);
      ecrit("Nom du fichier ou de la page : <span class=\"sGras sRouge\">$strNom</span>", 1);
      ecrit("Nom du suffixe : <span class=\"sGras sRouge\">$strSuffixe</span>", 2);
?>
      </p>
   </div>
<?php   
   require_once("pied-page.php");
?>