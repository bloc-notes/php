<?php
   /* Variables nécessaires pour les fichiers d'inclusion */
   $strTitreApplication = "Conception de la classe 'fichier'";
   $strNomFichierCSS = "index.css";
   $strNomAuteur = "Philippe Doyon";

   /* Variables nécessaires pour l'affichage "formaté" des résultats */
   $dV = "<span class=\"sGras sRouge\">"; $fV = "</span>";
   $dS = "<p class=\"sTitreSection\">";   $fS = "</p>";
   $dSS= "<p class=\"sTitreSousSection\">"; $fSS = "</p>";
   $dC = "<span style=\"font-family:consolas; font-size:16px; font-weight:bold;\">"; $fC = "</span>";
   require_once("classe-fichier-2018-03-16-Doyon.php");
   require_once("en-tete.php");
?>
   <div id="divCorps" class="" style="border:solid 1px black; padding:10px;">
<?php
   
   /*
   |-------------------------------------------------------------------------------------|
   | Module directeur
   |-------------------------------------------------------------------------------------|
   */
   
   /* Nom des fichiers qui seront utilisés dans cette application */
   $strNomFichierInexistant = "fichier-absent.txt";
   $strNomFichierVide = "fichier-vide.txt";
   $strNomFichierExistant = $strNomFichierUtilisateurs = "liste_utilisateurs.txt";
   $strNomFichierRapportUtilisateurs = "rapport_utilisateurs.txt";
   
   /* Manipulations sur un fichier inexistant */
   $fichierInexistant = new fichier($strNomFichierInexistant);
   $fichierInexistant->compteLignes();
   echo $dS . "Scénario 1 : Fichier inexistant" . $fS;
   echo "Nom du fichier : " . $dV . $fichierInexistant->strNom . $fV . "<br />";
   echo "Fichier est présent : " . $dV . ($fichierInexistant->existe() ? "Oui" : "Non") . $fV . "<br />";
   echo "Nombre de lignes : " . $dV . ($fichierInexistant->intNbLignes != -1 ? $fichierInexistant->intNbLignes : "N/A") . $fV . "<br />";
   echo $dSS . "Objet" . $fSS;
   var_dump($fichierInexistant);
   
   /* Manipulation sur un fichier existant, mais vide */
   $fichierVide = new fichier($strNomFichierVide);
   $fichierVide->compteLignes();
   echo $dS . "Scénario 2 : Fichier existant VIDE" . $fS;
   echo "Nom du fichier : " . $dV . $fichierVide->strNom . $fV . "<br />";
   echo "Fichier est présent : " . $dV . ($fichierVide->existe() ? "Oui" : "Non") . $fV . "<br />";
   echo "Nombre de lignes : " . $dV . ($fichierVide->intNbLignes != -1 ? $fichierVide->intNbLignes : "N/A") . $fV . "<br />";
   echo $dSS . "Objet" . $fSS;
   var_dump($fichierVide);
   
   /* Manipulation sur un fichier existant */
   $fichierExistant = new fichier($strNomFichierExistant);
   $fichierExistant->compteLignes();
   echo $dS . "Scénario 3 : Fichier existant" . $fS;
   echo "Nom du fichier : " . $dV . $fichierExistant->strNom . $fV . "<br />";
   echo "Fichier est présent : " . $dV . ($fichierExistant->existe() ? "Oui" : "Non") . $fV . "<br />";
   echo "Nombre de lignes : " . $dV . ($fichierExistant->intNbLignes != -1 ? $fichierExistant->intNbLignes : "N/A") . $fV . "<br />";
   echo $dSS . "Objet" . $fSS;
   var_dump($fichierExistant);

   /* Chargement d'un fichier en mémoire */
   $fichierUtilisateurs = new fichier($strNomFichierUtilisateurs);
   $fichierUtilisateurs->chargeEnMemoire();
   
   echo $dS . "Chargement du fichier '$strNomFichierUtilisateurs'" . $fS;
   echo $dSS . "Informations" . $fSS;
   echo "Nom du fichier : " . $dV . $fichierUtilisateurs->strNom . $fV. "<br />";
   echo "Taille du fichier : " . $dV . $fichierUtilisateurs->intTaille . " caractères" . $fV. "<br />";
   echo "Nombre de lignes : " . $dV . ($intNbLignes = $fichierUtilisateurs->intNbLignes) . $fV;
   
   echo $dSS. "Contenu brut du tableau 'tContenu'" . $fSS;
   echo $dC;
   for ($i=0; $i<$intNbLignes; $i++) {
      echo $dV . "[$i]" . $fV . $fichierUtilisateurs->tContenu[$i];
   }
   echo $fC;
   
   echo $dSS . "Contenu de la chaîne 'strContenu'" . $fSS;
   echo $dC;
   echo $fichierUtilisateurs->strContenu;
   echo $fC;
   
   echo $dSS . "Contenu de la chaîne 'strContenuHTML'" . $fSS;
   echo $dC;
   echo $fichierUtilisateurs->strContenuHTML;
   echo $fC;
   echo $dSS . "Objet" . $fSS;
   var_dump($fichierUtilisateurs);
   
   /* Lecture du contenu d'un fichier */
   $fichierUtilisateurs = new fichier($strNomFichierUtilisateurs);
   echo $dS . "Lecture du fichier '$strNomFichierUtilisateurs'" . $fS;
   echo $dSS . "Objet" . $fSS;
   var_dump($fichierUtilisateurs);

   echo $dSS . "Lecture du fichier 'ligne par ligne'" . $fSS;
   echo $dC;
   $fichierUtilisateurs->ouvre();
   while (!$fichierUtilisateurs->detecteFin()) {
      echo $fichierUtilisateurs->litLigne() . "<br />";
   }
   echo $fC;
   $fichierUtilisateurs->ferme();
   echo $dSS . "Objet" . $fSS;
   var_dump($fichierUtilisateurs);
   
   echo $dSS . "Lecture du fichier 'champ par champ'" . $fSS;
   $tValeurs = array();
   $i=0;
   echo $dC;
   echo "<table>";
   $fichierUtilisateurs->ouvre();
   while (!$fichierUtilisateurs->detecteFin()) {
      $fichierUtilisateurs->litDonneesLigne($tValeurs, ";", "NomUtilisateur", "Matricule", "MotDePasse", "NomEtPrenom", "NomDossierWeb");
      echo "<tr>";
      echo "<td>" . (++$i) . ".</td>";
      echo "<td>" . $tValeurs["NomUtilisateur"] . "</td>";
      echo "<td>" . $tValeurs["Matricule"] . "</td>";
      echo "<td>" . $tValeurs["MotDePasse"] . "</td>";
      echo "<td>" . $tValeurs["NomEtPrenom"] . "</td>";
      echo "<td>" . $tValeurs["NomDossierWeb"] . "</td>";
      echo "</tr>";
   }
   echo "</table>";
   echo $fC;
   $fichierUtilisateurs->ferme();
   echo $dSS . "Objet" . $fSS;
   var_dump($fichierUtilisateurs);
   
   /* Lecture du contenu d'un fichier et écriture de ce dernier dans un nouveau fichier */
   $fichierRapportUtilisateurs = new fichier($strNomFichierRapportUtilisateurs);
   echo $dS . "Lecture du fichier '$strNomFichierUtilisateurs'<br />" .
              "Écriture dans le fichier '$strNomFichierRapportUtilisateurs'". $fS;
   echo $dSS . "Objet" . $fSS;
   var_dump($fichierRapportUtilisateurs);

   echo $dSS . "Lecture du fichier 'champ par champ', entreposage dans un tableau<br />" .
               "à double dimension, puis enregistrement dans un fichier". $fSS;
   $tValeurs = array();
   $i=0;
   $fichierUtilisateurs->ouvre();
   while (!$fichierUtilisateurs->detecteFin()) {
      $fichierUtilisateurs->litDonneesLigne($tValeurs[$i++], ";", "NomUtilisateur", "Matricule", "MotDePasse", "NomEtPrenom", "NomDossierWeb");
   }
   $fichierUtilisateurs->ferme();

   $fichierRapportUtilisateurs->ouvre("E");
   echo $dC;
   echo "<table>";
   for ($i=count($tValeurs)-1; $i>=0; $i--) {
      echo "<tr>";
      echo "<td>" . ($i+1) . ".</td>";
      echo "<td>" . $tValeurs[$i]["NomDossierWeb"] . "</td>";
      echo "<td>" . $tValeurs[$i]["NomEtPrenom"] . "</td>";
      echo "<td>" . $tValeurs[$i]["MotDePasse"] . "</td>";
      echo "<td>" . $tValeurs[$i]["Matricule"] . "</td>";
      echo "<td>" . $tValeurs[$i]["NomUtilisateur"] . "</td>";
      echo "</tr>";
      
      $fichierRapportUtilisateurs->ecritLigne($tValeurs[$i]["NomDossierWeb"] . ";");
      $fichierRapportUtilisateurs->ecritLigne($tValeurs[$i]["NomEtPrenom"] . ";");
      $fichierRapportUtilisateurs->ecritLigne($tValeurs[$i]["MotDePasse"] . ";");
      $fichierRapportUtilisateurs->ecritLigne($tValeurs[$i]["Matricule"] . ";");
      $fichierRapportUtilisateurs->ecritLigne($tValeurs[$i]["NomUtilisateur"], $i != 0 ? true : false);
   }
   echo "</table>";
   echo $fC;
   $fichierRapportUtilisateurs->ferme();
   
   echo $dSS . "Lecture du fichier de rapport 'ligne par ligne'" . $fSS;
   echo $dC;
   $fichierRapportUtilisateurs->ouvre();
   while (!$fichierRapportUtilisateurs->detecteFin()) {
      echo $fichierRapportUtilisateurs->litLigne() . "<br />";
   }
   echo $fC;
   $fichierRapportUtilisateurs->ferme();
?>
   </div>
<?php
   require_once("pied-page.php");
?>