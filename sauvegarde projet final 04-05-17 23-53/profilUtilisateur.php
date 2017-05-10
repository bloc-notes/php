<?php 
//////////////////////////////////////////////////////////////////////////////////////////////////   
   require_once("classe-mysql-2017-mm-jj.php");
   require_once("librairies-communes-2017-02-17.php");
   require_once("classe-mysql-2017-mm-jj.php");
   require_once("424w-cgodin-qc-ca.php");
   require_once("Doyon.php");
////////////////////////////////////////////////////////////////////////////////////////////////// 
$strUtilisateur = $_SESSION["NoUtilisateur"];
$strCourriel = "";
$strPrenom = "";
$strNom = "";
//////////////////////////////////////////////////////////////////////////////////////////////////    
$strInfosSensibles="424w-cgodin-qc-ca.php";
$testmySQL = new mysql($strNomBD, $strInfosSensibles); 
$testmySQL->selectQuery("SELECT * FROM utilisateurs where NoUtilisateur = '$strUtilisateur'");
////////////////////////////////////////////////////////////////////////////////////////////////// 
?>
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<body>
<?php require_once("header.php");require_once("Doyon.php"); ?>
<div align="center" style="padding-top:40px" >
	<table>
	  <tr>
	  		<td colspan="3" style="text-align:center"><br><span style="font-weight:bold;font-size: 60px;">Votre profil</span><br></td>
	  		<td rowspan="10"></td>
	  </tr>
	  <tr>
	  		<td style="font-weight:bold;text-align:left;padding-top: 40px;">Courriel: </td>
	  		<td style="text-align:left;padding-top: 40px;"><?php echo $testmySQL->contenuChamp(0 , "Courriel");?></td> 
	  </tr>
	  <tr>
	  		<td style="font-weight:bold;text-align:left;">Prénom: </td>
	  		<td style="text-align:left"><?php echo $testmySQL->contenuChamp(0 , "Prenom"); ?></td> 
	  </tr>
	  <tr>
	  		<td style="font-weight:bold;text-align:left;">Nom de famille: </td>
	  		<td style="text-align:left"><?php echo $testmySQL->contenuChamp(0 , "Nom"); ?></td> 
	  </tr>
	  <tr>
	  		<td style="font-weight:bold;text-align:left;">Téléphone à domicile: </td>
	  		<td style="text-align:left"><?php echo $testmySQL->contenuChamp(0 , "NoTelMaison"); ?></td> 
	  </tr>
	  <tr>
	  		<td style="font-weight:bold;text-align:left;">Téléphone de travail: </td>
	  		<td style="text-align:left"><?php echo $testmySQL->contenuChamp(0 , "NoTelTravail"); ?></td> 
	  </tr>
	  <tr>
	  		<td style="font-weight:bold;text-align:left;">Téléphone portable: </td>
	  		<td style="text-align:left"><?php echo $testmySQL->contenuChamp(0 , "NoTelCellulaire"); ?></td> 
	  </tr>
	  <tr>
			  <td style="font-weight:bold;text-align:left;">Date de création: </td>
			  <td style="text-align:left"><?php echo $testmySQL->contenuChamp(0 , "Creation"); ?> EST</td> 
	  </tr>
			  <td style="font-weight:bold;text-align:left;">Date de modification: </td>
			  <td style="text-align:left"><?php echo $testmySQL->contenuChamp(0 , "Modification"); ?> EST</td> 
	  </tr>
	  <tr>
			  <td colspan="1" style="font-weight:bold;text-align:left;padding: 40px;"><input type="button" style="font-weight:bold" class="btn" value="Modifier votre informations" onClick="changePage('modifierUtilisateur.php')"></td>
			  <td colspan="2" style="font-weight:bold;text-align:right;padding: 40px;"><input type="button" style="font-weight:bold" class="btn" value="Modifier votre mot de passe" onClick="changePage('changerPassword.php')"></td>
	  </tr>
	</table>
</div>
<?php require_once("footer.php"); ?>
</body>
</html>
