<?php
   //require_once "librairie-date-doyon.php";
   require_once "librairie-generale-doyon.php";
   require_once "librairie-exercice01.php";
   
   $strTitreApplication = "Petit bottin téléphonique";
   $strNomFichierCSS = "index.css";
   $strNomAuteur = "Philippe Doyon";

   /* Initialisation des variables de travail */
   $strNomFichierTexte = "bottin.txt";
   $fp = null; /* Pointeur sur le fichier 'bottin.txt' */
   
   /* Tableaux à une dimension contenant les données sur chaque ami */
   $tNoms = array();
   $tPrenoms = array();
   $tTelephones = array();
   $tDatesNaissances = array();
   $intNbAmis = 0;
   
   /* Tableaux à une dimension contenant la position des amis remplissant les conditions demandées */
   $tIndicesAnniversaires = array();
   $intNbAnniversaires = 0;
   
   $tIndicesAnniversairesMois = array();
   $intNbAnniversairesMois = 0;
   
   /* Tableau à une dimension contenant pour chaque mois de l'année, le nombre d'amis dont c'est l'anniversaire */
   $tDecompteAnniversairesParMois = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
   
   require_once "en-tete.php";
?>
        <div id="divBottinTelephonique">
            <p class="sTitreSection">
                Problème 1 : Bottin téléphonique
            </p>
            <table class="sTableau">
                <tr>
                    <td class="sEntete">No</td>
                    <td class="sEntete">Nom complet</td>
                    <td class="sEntete">Téléphone</td>
                    <td class="sEntete">Date de naissance</td>
                    <td class="sEntete sDroite">#</td>
                </tr>
            
<?php
    //Lecture fichier bottin.txt et entrepose donnée dans tableau
   
   /* Initialisation des variable de travail*/
    $strNomFichierTexte = "bottin.txt";
    //$intLigne = 0;
    
    /* Ouverture du fichier texte en lecture*/
    $fp = fopen($strNomFichierTexte, "r");
    
    /* Parcours du fichier*/
    while (!feof($fp)) {
        
        list($tNoms[$intNbAmis], $tPrenoms[$intNbAmis], $tTelephones[$intNbAmis], $strDateAnniversaire) =
            explode(";", str_replace("\n", "", str_replace("\r", "", fgets($fp))));
        
        $tDatesNaissances[$intNbAmis] = (substr($strDateAnniversaire, 2, 1) == "-") ?
                AAAAMMJJ($strDateAnniversaire) : $strDateAnniversaire;
        
?>
                <tr>
                    <td class="sDroite"><?php echo $intNbAmis + 1;?></td>
                    <td class="sGras sBleu"><?php echo $tPrenoms[$intNbAmis] . " " . $tNoms[$intNbAmis]; ?></td>
                    <td class="sGras sBleu"><?php echo $tTelephones[$intNbAmis];?></td>
                    <td class="sGras sBleu"><?php echo $tDatesNaissances[$intNbAmis];?></td>
                    <td class="sDroite"><?php echo $intNbAmis;?></td>
                </tr>
<?php  
         $intNbAmis++;
    }
    
    /* Fermeture du fichier*/
    fclose($fp);
?>
            </table>
        </div>
<?php
   require_once "pied-page.php";
?>