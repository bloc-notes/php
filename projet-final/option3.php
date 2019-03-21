<?php
session_start();
$strNomUtilisateur = $_SESSION["nomComplet"];

require_once "en-tete.php";
require_once "classe-mysql-2018-03-30-Doyon.php";
require_once "librairies-communes-2018-03-20-Doyon.php";
$strBtnRetour = "btnRetour";
$strBtnEnregistrement = "btnEnregistrer";
$arNoms = [];
$arSessions = [];
$arSigle = [];

$binSess = false;
if (isset($_POST[$strBtnRetour])) {
    header("Location: menuAdmin.php");
    exit();
}

if(isset($_POST[$strBtnEnregistrement])){
    $binSess = true;

    }
    

    
$strNomBD = "pjf_microvox";
$strMonIP = "";
$strIPServeur = "";
$strNomServeur = "";
$strInfosSensibles = "";
detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);
$BD = new mysql($strNomBD, $strInfosSensibles);
?>
<script language="JavaScript">
function cochecolonne(source,nom) {
  cases = document.getElementsByName(nom);
  for(var i=0, n=cases.length;i<n;i++) {
    cases[i].checked = source.checked;
  }
}
</script>
<section id="PrivilegeProf" class="sCentre sComprime35">
    <header>
        <h1>Assigner les privilèges d'accès aux documents</h1>
        <?php if($binSess){
         
         for($j=0;$j < $BD->selectionneEnregistrements("utilisateur","C=statutAdmin=0");$j++){
             array_push($arNoms,$BD->contenuChamp($j, "nomUtil"));
         }
        for ($i = 0; $i < ($BD->selectionneEnregistrements("courssession")); $i++){
            array_push($arSessions, $BD->contenuChamp($i, "sessionCoursSession"));
            array_push($arSigle, $BD->contenuChamp($i, "sigleCoursSession"));
        }
    for($i=0;$i<count($arSessions);$i++){
        $index =0;
        for($j=0;$j<count($arNoms);$j++){
        if(isset($_POST['cb'.($i+1)])){
            if($index<count($_POST['cb'.($i+1)]))
            if($_POST['cb'.($i+1)][$index] == 'cb'.($i+1).'_'.($j+1)){
                
                echo "<script> console.log( '".$_POST['cb'.($i+1)][$index]."' );</script>";
                if($BD->selectionneEnregistrements('privilege',"C=sessionPrivilege='$arSessions[$i]' AND siglePrivilege='$arSigle[$i]' AND nomUtilPrivilege='$arNoms[$j]'")==0){
                    $BD->insereEnregistrement('privilege',$arSessions[$i],$arSigle[$i],$arNoms[$j]);
                }
                
                $index++;
                //echo $index;
            }
        }
        else
            $BD->supprimeEnregistrements('privilege',"sessionPrivilege='$arSessions[$i]' AND siglePrivilege='$arSigle[$i]' AND nomUtilPrivilege='$arNoms[$j]'");
        }
    }

            } ?>
    </header>
    <?php if (($BD->selectionneEnregistrements("courssession") > 0)&&($BD->selectionneEnregistrements("utilisateur","C=statutAdmin=0") > 0)) {

        ?>
        <form id="frmSaisie" method="post" action="">
        <article class="sCompact">
        
            <table>
                <tr>
                    <th>Nom d'utilisateur /Cours session</th>
                    <?php for ($i = 0; $i < ($BD->selectionneEnregistrements("courssession")); $i++) { ?>
                        <th><?php echo $BD->contenuChamp($i, "sessionCoursSession") . "</br>";
                                  echo $BD->contenuChamp($i, "sigleCoursSession") ."</br>";
                            array_push($arSessions, $BD->contenuChamp($i, "sessionCoursSession"));
                            array_push($arSigle, $BD->contenuChamp($i, "sigleCoursSession"));
                        ?>
                        <input type="checkbox" name="<?php echo "cbt".($i+1); ?>" value="<?php echo "cbt".($i+1); ?>" onclick="cochecolonne(this,'<?php echo "cb".($i+1); ?>[]')"></th>
                        <?php } ?>
                    </tr>
                    <?php for($j=0;$j < $BD->selectionneEnregistrements("utilisateur","C=statutAdmin=0");$j++){ ?>
                    <tr>
                        <td class="sTextGauche"><?php echo $BD->contenuChamp($j, "nomUtil");
                        array_push($arNoms,$BD->contenuChamp($j, "nomUtil"));
                        ?></td>
                        <?php for($k=0;$k<$BD->selectionneEnregistrements("courssession");$k++){?>
                        <td><input type="checkbox" name="<?php echo "cb".($k+1)?>[]" value="<?php echo "cb".($k+1)."_".($j+1); ?>"
                                   <?php if($BD->selectionneEnregistrements("privilege","C=sessionPrivilege='$arSessions[$k]' AND siglePrivilege='$arSigle[$k]' AND  nomUtilPrivilege='$arNoms[$j]'")>0){ ?>
                                   checked
                                       <?php } ?>
                        >
                        </td>
                        <?php } ?>
                    </tr>
                    <?php
                    
                    $BD->selectionneEnregistrements("utilisateur");
                    
                    } ?>
                    
                </table>
            </article>
            <footer>
                <button id="<?php echo $strBtnEnregistrement; ?>" type="submit" name="<?php echo $strBtnEnregistrement; ?>" value="<?php echo $strBtnEnregistrement; ?>">Enregistrement</button>
                <button id="<?php echo $strBtnRetour; ?>" type="submit" name="<?php echo $strBtnRetour; ?>">Retour</button>
            </footer>
        </form>    
        <?php
        }
        else {
            ?><h1>Hein? Il n'y a pas de sessions ni d'utilisateurs!</h1> <?php
        }
        ?>

    </section>

    <?php
    require_once "pied-page.php";
    