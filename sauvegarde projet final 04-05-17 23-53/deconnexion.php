<?php
require_once("Classe-mysql.php");
//Détruit infomation lors de déconnection
session_start();
session_unset();
session_destroy();

//vérification dans base de donné
    $strLocalHost = "localhost";
    $strNomBD = "annonces_qwerty";
        
    $strMonIP = "";
    $strIPServeur = "";
    $strNomServeur = "";
    $strInfosSensibles = "";
    detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);
        
    $BDAnnonce = new mysql($strNomBD, $strInfosSensibles);
    
    $BDAnnonce->_listeEnregistrements = mysqli_query($BDAnnonce->_cBD,"SELECT MAX(NoConnexion) AS valmax FROM " 
            . 'connexions');
    $tabresultat = mysqli_fetch_array($BDAnnonce->_listeEnregistrements);
 
    $NoConnexion = $tabresultat['valmax'];
    
    
    $date = new DateTime();
    $date = date_format($date,"Y-m-j H:i:s");
    
    $BDAnnonce->_requete = "UPDATE `annonces_qwerty`.`connexions` SET `Deconnexion` = $date "
                            . "WHERE `connexions`.`NoConnexion` = $NoConnexion;";
    mysqli_query($BDAnnonce->_cBD, $BDAnnonce->_requete);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<meta charset="UTF-8">
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
</head>
<body>
    <?php require_once("Doyon.php");  require_once("header.php");?>
<div align="center" style="padding-top:230px">
    <table>
        <tr>
            <td>
                <p style="font-family:Arial Black; font-size: 20px">         
                    Vous êtes déconnecté de QWERTY 
                </p>
            </td>    
        
	</tr>
        <tr>
            <td>
                <input name="btnConnection" type="button" style="font-weight:bold" class="btn" value="Retour à la page de connection" onClick="changePage('index.php')">
            </td>
        </tr>
    </table>
</div>
<?php require_once("footer.php"); ?>
</body>
</html>
