<?php
   require_once "librairie-date-doyon.php";
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
        <div id="divBottinTelephonique" style="display:none">
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
    //Problème 2
    //Récupère date en paramètre de url
    $strDateTempo = get("DateDuJour");
    $strDateDuJour = dateValide($strDateTempo)? $strDateTempo : aujourdhui();
    
    $strDateDuJour = (substr($strDateDuJour, 2, 1) == "-") ?
                AAAAMMJJ($strDateDuJour) : $strDateDuJour;
    
    //Anniversaire avec $strDateDuJour
    //print_r(array_map('substr' ,$tDatesNaissances, array_fill(0,$intNbAmis,5)));
    //print_r(array_map('call_user_func_array' ,$tDatesNaissances, array(5))); pas bon
    
    //Trouve les dates pareils dans le tableau en enlevant les années
    $tIndicesAnniversaires = array_keys(array_map('substr' ,$tDatesNaissances, array_fill(0,$intNbAmis,5)), substr($strDateDuJour,5));
    
    $intNbAnniversaires = count($tIndicesAnniversaires);
?>  
        <div id="divListeAnniversaires" style="display:none">
            <p class="sTitreSection">
                Problème 2 : Les anniversaires du jour (<?php echo dateEnLitteral($strDateDuJour, 'C');?>)
            </p>
<?php
    
    if($intNbAnniversaires > 0){
?>
            <table class="sTableau">
                <tr>
                    <td class="sEntete">No</td>
                    <td class="sEntete">Nom complet</td>
                    <td class="sEntete">Âge (Date)</td>
                    <td class="sEntete">Téléphone</td>
                    <td class="sEntete sDroite">#</td>
                </tr>
<?php
        for($intIndex =0;$intIndex < $intNbAnniversaires;$intIndex++){
?>
                <tr>
                    <td class="sDroite"><?php echo $intIndex + 1;?></td>
                    <td class="sGras sBleu"><?php echo $tPrenoms[$tIndicesAnniversaires[$intIndex]] . " " . $tNoms[$tIndicesAnniversaires[$intIndex]]; ?></td>
                    <td class="sGras sBleu"><?php echo (annee(aujourdhui()) - annee($tDatesNaissances[$tIndicesAnniversaires[$intIndex]])) 
                                                        . " ans (" . annee($tDatesNaissances[$tIndicesAnniversaires[$intIndex]]) . ")";?></td>
                    <td class="sGras sBleu"><?php echo $tTelephones[$tIndicesAnniversaires[$intIndex]];?></td>
                    <td class="sDroite"><?php echo $tIndicesAnniversaires[$intIndex];?></td>
                </tr>
<?php
        }
?>
            </table>
<?php
    }
    else{
?>
            <p class="sGras">Aucun anniversaire aujourd'hui :-(</p>
<?php
    }
?>
        </div>
<?php
    //Problème 3
    //Récupère mois en paramètre de url
    $strMoisCourant = get("MoisCourant");
    
    //Trouve les dates avec mois pareils dans le tableau
    $tIndicesAnniversairesMois = array_keys(array_map('mois' ,$tDatesNaissances), ajouteZeros($strMoisCourant,2));
    
    $intNbAnniversairesMois = count($tIndicesAnniversairesMois);
    
    //Nombre d'anniversaire pour chaque mois
    for($intIndex = 1;$intIndex<13;$intIndex++){
        $tDecompteAnniversairesParMois[$intIndex - 1] = count(array_keys(array_map('mois' ,$tDatesNaissances), ajouteZeros($intIndex,2)));
    }
    
    ?>  
        <div id="DivListeAnniversairesMois">
            <p class="sTitreSection">
                Problème 3 : Les anniversaires du mois de <?php echo is_null($strMoisCourant) ? "..." : moisEnLitteral($strMoisCourant);?>
            </p>
<?php
    
    if($intNbAnniversairesMois > 0){
?>
            <table class="sTableau">
                <tr>
                    <td class="sEntete">No</td>
                    <td class="sEntete">Nom complet</td>
                    <td class="sEntete">Âge (Date)</td>
                    <td class="sEntete">Téléphone</td>
                    <td class="sEntete sDroite">#</td>
                </tr>
<?php
        for($intIndex =0;$intIndex < $intNbAnniversairesMois;$intIndex++){
?>
                <tr>
                    <td class="sDroite"><?php echo $intIndex + 1;?></td>
                    <td class="sGras sBleu"><?php echo $tPrenoms[$tIndicesAnniversairesMois[$intIndex]] .
                                                    " " . $tNoms[$tIndicesAnniversairesMois[$intIndex]]; ?></td>
                    <td class="sGras sBleu"><?php echo (annee(aujourdhui()) - annee($tDatesNaissances[$tIndicesAnniversairesMois[$intIndex]])) 
                                                        . " ans (" . $tDatesNaissances[$tIndicesAnniversairesMois[$intIndex]] . ")";?></td>
                    <td class="sGras sBleu"><?php echo $tTelephones[$tIndicesAnniversairesMois[$intIndex]];?></td>
                    <td class="sDroite"><?php echo $tIndicesAnniversairesMois[$intIndex];?></td>
                </tr>
<?php
        }
?>
            </table>
<?php
    }
    else{
?>
            <p class="sGras"><?php echo is_null($strMoisCourant) ? 
                                        "Aucun mois sélectionné !" : "Aucun anniversaire en " .
                                        moisEnLitteral($strMoisCourant) . "!"; ?></p>
<?php
    }
?>
        </div>
<?php
    require_once "pied-page.php";