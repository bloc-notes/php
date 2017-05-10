<?php
    require_once "librairie-date.php";
    require_once "librairie-general.php";
    
    $strTitreApplication = "Affichage de la date courante";
    $strNomFichierCSS = "index.css";
    $strNomAuteur = "Philippe Joseph Clermont Michel Doyon";
    
    require_once("en-tete.php");
?>
<div id="divCorps" class="">
     <?php  
        function reunion($intMois){
            $strDate = $intMois < 11 ? JJMMAAAA(1, $intMois, 2017): "01-".$intMois . "-2017";

            $intNoJour = date("N", strtotime($strDate));

            $intPremierSamediMois = $intNoJour == 7? 7:1 + (6- $intNoJour);

            return $intPremierSamediMois;
            /*test*/
        }

        for($i=1;$i<=12;$i++){
            $NoRéunion = $i < 11 ? ajouteZero($i, 2):$i;
            echo "Réunion no $NoRéunion  : "  . "<span class=\"sGras\">" . er(reunion($i)) . " " 
                    . moisEnLitteral($i). " 2017</span><br /><br />";
        }
    ?>
</div>
<?php
    require_once("pied-page.php");
?>