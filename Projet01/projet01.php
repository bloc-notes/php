<?php
require_once "Librairie-G Doyon.php";

$strNomGroupe = post("tbNomGroupe");
$strNomResponsable = post("ddlNomResponsable");
$strNumTelephone = post("tbNoTelephoneResponsable");
$strDate = post("tbDateTirage");

/*
 * Redirection automatique
 */
if(empty($strNomGroupe) || empty($strNomResponsable) || empty($strNumTelephone)){
    echo "Salut";
    echo "<script>alert('Cette application ne peut pas être exécutée directement!');"
    . "location.href='http://424w.cgodin.qc.ca/pdoyon/projet01/index.htm';</script>";
}

$fltLots7 = post("tbLot6sur6");
$fltLots6 = post("tbLot5sur6Plus");
$fltLots5 = post("tbLot5sur6");
$fltLots4 = post("tbLot4sur6");
$fltLots3 = post("tbLot3sur6");
$fltLots2 = post("tbLot2sur6Plus");
$fltLots1 = post("tbLot2sur6");

$intNumGagnant7 = post("ddlNoGagnantC");
//$intNumGagnant = array();

for ($i = 1; $i != 7; $i++) {
    ${"intNumGagnant" . $i} = empty(post("ddlNoGagnant" . $i)) ? "00" : post("ddlNoGagnant" . $i);
    /* Remplace le point par une virgule et met le bon format */
    ${"strLots" . $i} = number_format((!empty(${"fltLots" . $i}) ? ${"fltLots" . $i} : 0), 2, ",", " ") . " $";
}

$strLots7 = number_format((!empty($fltLots7) ? $fltLots7 : 0), 2, ",", " ") . " $";

/* Change date en format long */
$strDateLong = "N/A";
if ($strDate != null) {
    $intJourSemaine = 0;
    $intJour = 0;
    $intMois = 0;
    $intAnnee = 0;

    extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $strDate);

    $strDateLong = jourSemaineEnLitteral($intJourSemaine, true) . " " . er($intJour, true) . " " . moisEnLitteral($intMois) . " " . $intAnnee;
}

function trouvePersonne($strNomPersonne, $tabCombinaison) {
    $intNbJoueur = count($tabCombinaison);
    $intJoueurTrouver = 0;
    for ($intI = 1; $intI <= $intNbJoueur; $intNbJoueur++) {
        if ($tabCombinaison[1][$intI] == $strNomPersonne) {
            $intJoueurTrouver++;
        }
    }
    return $intJoueurTrouver;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Projet 1 par Philippe Doyon</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="index.css" />
    </head>
    <body>
        <div id="divEntete" class="">
            <p class="sTitreApplication">
                Projet 1 (Calcul des gains)
                <span class="sTitreSection">
                    <br />par <span class="sRouge">Philippe Doyon</span>
                </span>
            </p>
        </div>
        <div id="divInfosGroupe" class="sDivSortie">
            <p class="sTitreSection">
                Informations sur le groupe
            </p>
            <table>
                <tr>
                    <td><img src="Logo649.png" class="sLogo"></td>
                    <td>
                        <table>
                            <tr class="sHauteurLigne">
                                <td>Nom du groupe :</td>
                                <td>
                                    <span class="sSortie"><?php echo $strNomGroupe; ?></span>
                                </td>
                            </tr>
                            <tr class="sHauteurLigne">
                                <td>Nom du responsable :</td>
                                <td>
                                    <span class="sSortie"><?php echo $strNomResponsable; ?></span>
                                </td>
                            </tr>
                            <tr class="sHauteurLigne">
                                <td>No téléphone :</td>
                                <td>
                                    <span class="sSortie"><?php echo $strNumTelephone; ?></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div id="divInfosTirage" class="sDivSortie">
            <p class="sTitreSection">
                Informations sur le tirage
            </p>
            <table>
                <tr class="sHauteurLigne">
                    <td>Date du tirage :</td>
                    <td>

                        <span class="sSortie"><?php echo $strDateLong; ?></span>
                    </td>
                </tr>
                <tr class="sHauteurLigne">
                    <td>Numéros gagnants :</td>
                    <td>

                        <span class="sSortieNo"><?php echo $intNumGagnant1; ?></span>

                        <span class="sSortieNo"><?php echo $intNumGagnant2; ?></span>

                        <span class="sSortieNo"><?php echo $intNumGagnant3; ?></span>

                        <span class="sSortieNo"><?php echo $intNumGagnant4; ?></span>

                        <span class="sSortieNo"><?php echo $intNumGagnant5; ?></span>

                        <span class="sSortieNo"><?php echo $intNumGagnant6; ?></span>
                        C= <span class="sSortieNo"><?php echo $intNumGagnant7; ?></span>
                    </td>
                </tr>
                <tr class="sHauteurLigne"><td></td></tr>
                <tr>
                    <td class="sAligneVerticalHaut">Liste des lots :</td>
                    <td>
                        <table>
                            <tr>
                                <td>6 sur 6 :</td>
                                <td>
                                    <span class="sSortie"><?php echo $strLots7; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>5 sur 6 + :</td>
                                <td class="sDroite">
                                    <span class="sSortie"><?php echo $strLots6; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>5 sur 6 :</td>
                                <td class="sDroite">
                                    <span class="sSortie"><?php echo $strLots5; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>4 sur 6 :</td>
                                <td class="sDroite">
                                    <span class="sSortie"><?php echo $strLots4; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>3 sur 6 :</td>
                                <td class="sDroite">
                                    <span class="sSortie"><?php echo $strLots3; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>2 sur 6 + :</td>
                                <td class="sDroite">
                                    <span class="sSortie"><?php echo $strLots2; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>2 sur 6 :</td>
                                <td class="sDroite">
                                    <span class="sSortie"><?php echo $strLots1; ?></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div id="divListeCombinaisons" class="sDivSortie">
            <p class="sTitreSection">
                Liste des combinaisons des joueurs et verdict
            </p>
            <table>
                <?php
                $intNbBilletGratuit = 0;
                $fltTotalLots = 0;
                $intCombiGagnant = 0;
                $booFinComb = FALSE;
                $tabCombinaisons = array();
                $tabCombiJoueur = array();
                /* Liste Joueur */
                for ($intX = 1; $intX <= 32 && $booFinComb == false; $intX++) {
                    /* Liste Information */
                    $tabCombinaisons[$intX] = array();
                    $tabCombiJoueur[$intX] = post("ddlNom" . ($intX < 10 ? ajouteZero($intX, 2) : $intX));
                    $strNomJoueur = post("ddlNom" . ($intX < 10 ? ajouteZero($intX, 2) : $intX));

                    if ($strNomJoueur != "") {
                        ?>   
                        <tr class="sHauteurLigne">
                            <td class="sDroite">
                                <?php echo $intX; ?>.
                            </td>
                            <td>
                                <span class="sGras"><?php echo $strNomJoueur; ?></span>
                            </td>
                            <td>
                                <?php
                                $intLostMax = 0;
                                $booNumeroBonu = FALSE;
                                for ($intY = 1; $intY <= 6; $intY++) {
                                    $tabCombinaisons[$intX][$intY] = empty(post("ddlNo" . ($intX < 10 ? ajouteZero($intX, 2) : $intX) . "-" . $intY)) ? "00" :
                                        post("ddlNo" . ($intX < 10 ? ajouteZero($intX, 2) : $intX) . "-" . $intY);
                                    ?>
                                    <span class="sSortieNo"><?php echo $tabCombinaisons[$intX][$intY]; ?>
                                    </span>&nbsp;
                                    <?php
                                    $intBaseCombinaison = 0;

                                    for ($intW = 1; $intW <= 6; $intW++) {
                                        if (${"intNumGagnant" . $intW} == $tabCombinaisons[$intX][$intY]) {
                                            $intBaseCombinaison++;
                                        }
                                        if ($intNumGagnant7 == $tabCombinaisons[$intX][$intY]) {
                                            $booNumeroBonu = true;
                                        }
                                    }

                                    if ($intBaseCombinaison > 0) {
                                        $intLostMax++;
                                    }
                                }
                                //Verdic
                                if ($intLostMax >= 2) {
                                    $intCombiGagnant++;
                                    ?>
                                </td>
                                <td>
                                    <span class="sGagnant">:-)</span>
                                </td>
                                <td class="sDroite">
                                    <span class="sGras">
            <?php
        }
        switch ($intLostMax) {
            case 2:
                if ($booNumeroBonu) {
                    echo $strLots2;
                    $fltTotalLots = $fltTotalLots + $fltLots2;
                } else {
                    ?>Billet gratuit<?php
                            $fltTotalLots = $fltTotalLots + $fltLots1;
                            $intNbBilletGratuit++;
                        }
                        break;
                    case 3:
                        echo $strLots3;
                        $fltTotalLots = $fltTotalLots + $fltLots3;
                        break;
                    case 4:
                        echo $strLots4;
                        $fltTotalLots = $fltTotalLots + $fltLots4;
                        break;
                    case 5:
                        if ($booNumeroBonu) {
                            echo $strLots6;
                            $fltTotalLots = $fltTotalLots + $fltLots6;
                        } else {
                            echo $strLots5;
                            $fltTotalLots = $fltTotalLots + $fltLots5;
                        }
                        break;
                    case 6:
                        echo $strLots7;
                        $fltTotalLots = $fltTotalLots + $fltLots7;
                        break;
                    default:
                ?>
                                    </td>
                                    <td colspan="3"><span class="sPerdant">:-(</span></td>
                                </tr>
                                            <?php
                                            break;
                                    }
                                    if ($intLostMax >= 2) {
                                        ?>
                            </span>
                            </td>
                            <td>
                                &nbsp;<=>&nbsp;<span class="sGras">
            <?php
            echo $intLostMax . " sur 6" .
            ($booNumeroBonu && ($intLostMax == 2 || $intLostMax == 5) ? "+" : "")
            ?></span>
                            </td>
                            </tr>
                                    <?php
                                }
                            } else {
                                $booFinComb = TRUE;
                            }
                        }
                        ?>
            </table>
        </div>
        <div id="divBilan" class="sDivSortie">
            <p class="sTitreSection">
                Bilan
            </p>
            <table>
                <tr class="sHauteurLigne">
                    <td>Nombre de combinaisons : </td>
                    <td>
                        <span class="sSortie"><?php echo count($tabCombinaisons) - 1; ?></span>
                    </td>
                </tr>
                <tr class="sHauteurLigne">
                    <td>Nombre de combinaisons gagnantes : </td>
                    <td>
                        <span class="sSortie"><?php echo $intCombiGagnant; ?></span>
                    </td>
                </tr>
                <tr class="sHauteurLigne">
                    <td>Montant total des lots remportés :</td>
                    <td>

                        <span class="sSortie">
<?php echo number_format((!empty($fltTotalLots) ? $fltTotalLots : 0), 2, ",", " ")
 . " $";
?></span>
                    </td>
                </tr>
                <tr class="sHauteurLigne">
                    <td>Nombre de billets gratuits remportés :</td>
                    <td>
                        <span class="sSortie"><?php echo $intNbBilletGratuit; ?></span>
                    </td>
                </tr>
            </table>
        </div>

        <div id="divBilanParJoueur" class="sDivSortie">
            <p class="sTitreSection">
                Lot remporté par chaque joueur
            </p>
            <table>
<?php
$tabResultat = array();

for ($intN = 1; $intN <= count($tabCombiJoueur); $intN++) {
    $tabResultat[$intN] = 1;
    for ($intV = 1; $intV <= count($tabCombiJoueur); $intV++) {
        if (($tabCombiJoueur[$intN] == $tabCombiJoueur[$intV]) && ($intN != $intV) && ($tabResultat[$intN] != -1)) {
            $tabResultat[$intN] = $tabResultat[$intN] + 1;
            $tabResultat[$intV] = -1;
        }
    }
}

/* Montant par part */
$fltMontantParPart = $fltTotalLots / (count($tabCombiJoueur) - 1);
$intNo = 1;
for ($intG = 1; $intG < count($tabResultat); $intG++) {
    if ($tabResultat[$intG] != -1) {
        ?>
                        <tr>
                            <td class="sDroite">
                        <?php echo $intNo; ?>.
                            </td>
                            <td>
                                <span class="sGras"><?php echo $tabCombiJoueur[$intG]; ?></span>
                                (<span class="sGras"><?php echo $tabResultat[$intG]; ?> part<?php echo $tabResultat[$intG] > 1 ? "s" : ""; ?></span>) :
                            </td>
                            <td class="sDroite ">
                                <span class="sSortiePart"><?php echo number_format($fltMontantParPart * $tabResultat[$intG], 2, ",", " ") . " $"; ?></span>
                            </td>
                        </tr>
        <?php
        $intNo++;
    }
}
?>
                <tr>
                    <td colspan="3" class="sDroite">
                        <span class="sSortiePartTotal"><?php echo number_format((!empty($fltTotalLots) ? $fltTotalLots : 0), 2, ",", " ")
                . " $"
?></span>
                    </td>
                </tr>
            </table>
        </div>

        <div id="divPiedPage" class="">
            <p class="sDroits">
                <br />
                &copy; Département d'informatique G.-G.
            </p>
        </div>
    </body>
</html>