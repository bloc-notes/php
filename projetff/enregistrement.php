<?php
require_once("Librairie-G Doyon.php");
require_once("Classe-mysql.php");
require_once("Doyon.php");
$binCourrier = false;
$binCourrierConfm = false;
$binMDP = false;
$binMDPConfm = false;

$strTransmisionDonnee = post( "btnSoumettre" ) ? "post":"";

$strCourriel = $strTransmisionDonnee == "" ? "" : post("tbCourriel");
$strCourrielConfm = $strTransmisionDonnee == "" ? "" : post("tbCourrielConfm");
$strMDP = $strTransmisionDonnee == "" ? "" : post("tbMDP");
$strMDPConfm = $strTransmisionDonnee == "" ? "" : post("tbMDPConfm");

//Véfification des informations coté client
if($strTransmisionDonnee != ""){
    if($strCourriel == "" || $strCourrielConfm == "" || $strMDP == "" || $strMDPConfm == ""){
        echo "<script>alert(\"Vous devez remplir tous les champs !\")</script>";
    }
    else if($strCourriel != $strCourrielConfm){
        echo "<script>alert(\"L'adresse courriel et l'adresse de confirmation doivent être identique!\")</script>";
    }
    else if($strMDP != $strMDPConfm){
        echo "<script>alert(\"Le mot de passe et le mot de passe de confirmation doivent être identique !\")</script>";
    }
    else if(strlen($strCourriel) > 50 || strlen($strMDP) > 50){
        echo "<script>alert(\"Les champs doivent avoir moins de 50 caractères\")</script>";
    }
    //Source https://openclassrooms.com/forum/sujet/ma-regex-pour-verifier-les-adresses-email-45393
    else if(preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$/", $strCourriel) == 0){
        echo "<script>alert(\"L'adresse courriel avoir un format valide!\")</script>";
    }
    else if(preg_match("/^[a-zA-Z0-9]{8,}/",$strMDP) == 0){
        echo "<script>alert(\"Le mot de passe doit avoit au minimum 8 carcatères et avoir des chiffres ou des lettres!\")</script>";
    }
    else{
        //vérification dans base de donné
        $strLocalHost = "localhost";
        $strNomBD = "annonces_qwerty";
        
        $strMonIP = "";
        $strIPServeur = "";
        $strNomServeur = "";
        $strInfosSensibles = "";
        detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);
        
        $BDAnnonce = new mysql($strNomBD, $strInfosSensibles);
        
        $intNombreResultat = $BDAnnonce->selectionneEnregistrements("utilisateurs","C=Courriel='" . $strCourriel . "'");
        
        //courriel déjà utilisé
        if($intNombreResultat == 1){
            echo "<script>alert(\"L'adresse courriel fourni est déjà utilisée par un compte du site!\")</script>";
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        else{
            $date = new DateTime();
            $date = date_format($date,"Y-m-j H:i:s");
            $BDAnnonce->insereEnregistrement("utilisateurs",
                    0,
                    $strCourriel,
                    $strMDP,
                    $date,
                    0,
                    0,
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    $date, //fais juste mettre date au lieu de ""
                    "");
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
            $binCourrier = true;
            $binCourrierConfm = true;
            $binMDP = true;
            $binMDPConfm = true;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<script type="text/javascript">
<?php
$binSoumetFormulaire = false;
if($binCourrier && $binCourrierConfm && $binMDP && $binMDPConfm){
    $binSoumetFormulaire = true;
}
?>
</script>
<body onload="<?php echo $binSoumetFormulaire ? "soumetFormulaire('PleaseValidate.php', 'frmSaisie');": "";?>">
<?php require_once("En-tete.php"); ?>
<div align="center" style="padding-top:40px">
    <form id="frmSaisie" method="post" action="">
    <table>
        <tr>
            <td rowspan="6">	
                <br><span style="font-weight:bold">Bienvenue dans la création de votre compte Qwerty</span><br><br> 
                <span style="font-weight:bold">Accédez à vos achats</span><br>
                Et affichez l'historique de vos commandes<br><br>
                    
                <span style="font-weight:bold">Gérer les produits de votre entreprise</span><br>
                Et les distribuer aux utilisateurs finaux
            </td>
            <td colspan="2"><br><span style="font-weight:bold">Inscrivez-vous sur QWERTY</span><br></td> <td rowspan="6"></td>
        </tr>
        <tr>
            <td><input type="text" name="tbCourriel" class="textbox" placeholder="Courriel" value="<?php echo $strCourriel;?>"><br></td> 
        </tr>
        <tr>
            <td><input type="text" name="tbCourrielConfm" class="textbox" placeholder="Confirmez votre courriel" value="<?php echo $strCourrielConfm;?>"><br></td> 
        </tr>
        <tr>
            <td><input type="password" name="tbMDP" class="textbox" placeholder="Mot de passe" value="<?php echo $strMDP;?>"><br></td>
        </tr>
        <tr>
            <td><input type="password" name="tbMDPConfm" class="textbox" placeholder="Confirmez votre mot de passe" value="<?php echo $strMDPConfm;?>"><br></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="btnSoumettre" style="font-weight:bold" class="btn" value="Soumettre">&nbsp;&nbsp;&nbsp;<br></td>
        </tr> 
    </table>
    </from>
</div>
<?php require_once("footer.php"); ?>
</body>
</html>
