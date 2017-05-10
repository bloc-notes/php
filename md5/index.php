<?php
require_once("Librairie-G Doyon.php");
require_once("Classe-mysql.php");
require_once("Doyon.php");

$strNomFichierRedirection = "affichageAnnonce.php";

$binCourrier = false;
$binMDP = false;

$strTransmisionDonnee = post( "btnConnection" ) ? "post":"";

$strCourriel = $strTransmisionDonnee == "" ? "" : post("tbCourriel");
$strMDP = $strTransmisionDonnee == "" ? "" : post("tbMDP");

//Véfification des informations coté client
if($strTransmisionDonnee != ""){   
    if($strCourriel == "" || $strMDP ==""){
        echo "<script>alert(\"Vous devez inscrire un courriel et un mot de passe!\")</script>";
    }
    else if(strlen($strCourriel) > 50 || strlen($strMDP) > 16){
        echo "<script>alert(\"Le champs courriel doit avoir moin de 50 caractères et le champs mot de passe 15!\")</script>";
    }
    //Source https://openclassrooms.com/forum/sujet/ma-regex-pour-verifier-les-adresses-email-45393
    else if(preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$/", $strCourriel) == 0){
        echo "<script>alert(\"L'adresse courriel avoir un format valide!\")</script>";
    }
    else if(preg_match("/^[a-zA-Z0-9]{5,15}/",$strMDP) == 0){
        echo "<script>alert(\"Le mot de passe doit avoir entre 5 à 15 caractères et avoir des chiffres ou des lettres!\")</script>";
    }
    else{
        //vérification dans base de donné
        $strLocalHost = "localhost";
        $strNomBD = "annonces_qwerty";
        
        $strMonIP = "";
        $strIPServeur = "";
        $strNomServeur = "";
        $strInfosSensibles = "424w-cgodin-qc-ca.php";
        detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);
        
        $BDAnnonce = new mysql($strNomBD, $strInfosSensibles);
        
        $intNombreResultat = $BDAnnonce->selectionneEnregistrements("utilisateurs","C=Courriel='" . $strCourriel . "'");
        
        //Utilisateur trouvé
        if($intNombreResultat == 1){
            $binCourrier = true;
            
            $BDAnnonce->_listeEnregistrements = mysqli_query($BDAnnonce->_cBD,"SELECT * FROM utilisateurs WHERE Courriel='".
                    $strCourriel . "'" );
            $tabInfo = mysqli_fetch_array($BDAnnonce->_listeEnregistrements);
            
            if($tabInfo['MotDePasse'] === md5($strMDP)){
                $binMDP = true;
                
                //Démarrage de la session
            
                $_SESSION["StatusUtili"] = $tabInfo['Statut'];
                $_SESSION["Prenon"] = $tabInfo['Prenom'];
                $_SESSION["Nom"] = $tabInfo['Nom'];
                $_SESSION["MDP"] = $tabInfo['MotDePasse'];
                $_SESSION["NoUtilisateur"] = $tabInfo['NoUtilisateur'];
                $_SESSION["Statut"] = $tabInfo['Statut'];
                
                //Mise à jours table connection
                $date = new DateTime();
                $date = date_format($date,"Y-m-j H:i:s");
                
                
                $BDAnnonce->insereEnregistrement("connexions",
                        0,
                        $_SESSION["NoUtilisateur"],
                        $date,
                        "");
                
                //si la personne se connecte pour la première fois
                if($_SESSION["Statut"] == 0){
                    $strNomFichierRedirection = "modifierUtilisateur.php";
                    
                    $BDAnnonce->_requete = "UPDATE `annonces_qwerty`.`utilisateurs` SET `Statut` = '9' "
                            . "WHERE `utilisateurs`.`NoUtilisateur` = 4;";
                    mysqli_query($BDAnnonce->_cBD, $BDAnnonce->_requete);
                }
            }
            else {
                echo "<script>alert(\"L'adresse courriel ou le mot de passe est invalide!\")</script>";
            }
        }
        else {
                echo "<script>alert(\"L'adresse courriel ou le mot de passe est invalide!\")</script>";
        }
    } 
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<script type="text/javascript">
<?php 
$binSoumetFormulaire = false;
if($binCourrier && $binMDP){
    $binSoumetFormulaire = true;
}
?>

function soumetFormulaire(strNomPageAction, strFormulaire){
    var frm;
    frm = document.getElementById(strFormulaire);
    frm.action = strNomPageAction;
    frm.submit();
}
</script>
<meta charset="UTF-8">
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
</head>
<body onload="<?php echo $binSoumetFormulaire ? "soumetFormulaire( '" . $strNomFichierRedirection . "','frmSaisie');": "";?>">
    <?php require_once("header.php"); ?>
<div align="center">
    <form id="frmSaisie" method="post" action="">
    <table>
        <tr>
            <td colspan="3" style="text-align:center"><br><span style="font-weight:bold;font-size: 60px;font-family:Arial Black;">QWERTY</span><br></td>
	</tr>
	<tr>
            <td colspan="2"><br><span style="font-weight:bold">Connectez-vous avec un compte existant</span><br></td> <td rowspan="6"></td>
	</tr>
	<tr>
	   <td><input id="tbCourriel" name="tbCourriel" type="text" class="textbox" placeholder="Courriel"><br></td> 
	</tr>
	<tr>
	    <td><input id="tbMDP" name="tbMDP" type="text" class="textbox" placeholder="Mot de passe"><br></td>
	</tr>
	<tr>
            <td colspan="2"><input id="btnConnection"  name="btnConnection" type="submit" style="font-weight:bold" class="btn" value="Se connecter">&nbsp;&nbsp;&nbsp;<a href="changerPasswordAnonyme.php" style="color: rgb(66,165,220);">mot de passe oublié?</a><br></td>
	</tr> 
	<tr>
	    <td colspan="2"><br>Pas enregistré?<br><span style="font-weight:bold;">Créer un compte Qwerty</span></td>
	</tr> 
	<tr>
	    <td colspan="3" style="padding-bottom: 40px;"><input id="btnCreerCompte" type="button" class="btn" style="font-weight:bold" value="Créer un compte" onClick="changePage('enregistrement.php')"></td>
	</tr> 
    </table>
    </from>
</div>
<?php require_once("footer.php"); ?>
</body>
</html>
