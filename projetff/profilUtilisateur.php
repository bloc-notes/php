<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<body>
<?php require_once("header.php"); ?>
<div align="center" style="padding-top:40px" >
	<table>
	  <tr>

	    <td colspan="3" style="text-align:center"><br><span style="font-weight:bold;font-size: 60px;">Votre profil</span><br></td><td rowspan="10"></td>
	  </tr>
	    <tr>
	    <td style="font-weight:bold;text-align:left;padding-top: 40px;">Courriel: </td>
	   <td style="text-align:left;padding-top: 40px;">Justwoww@hotmail.com</td> 
	  </tr>
	   <tr>
	    <td style="font-weight:bold;text-align:left;">Prénom: </td>
	   <td style="text-align:left">Gabriel</td> 
	  </tr>
	   <tr>
	    <td style="font-weight:bold;text-align:left;">Nom de famille: </td>
	   <td style="text-align:left">Roy</td> 
	  </tr>
	   <tr>
	    <td style="font-weight:bold;text-align:left;">Téléphone à domicile: </td>
	   <td style="text-align:left">(123) 456-7890</td> 
	  </tr>
	   <tr>
	    <td style="font-weight:bold;text-align:left;">Téléphone de travail: </td>
	   <td style="text-align:left">(123) 456-7890</td> 
	  </tr>
	  <td style="font-weight:bold;text-align:left;">Téléphone portable: </td>
	   <td style="text-align:left">(123) 456-7890</td> 
	  </tr>
	  <td style="font-weight:bold;text-align:left;">Date de création: </td>
	   <td style="text-align:left">2017-03-31</td> 
	  </tr>
	  <td style="font-weight:bold;text-align:left;">Date de modification: </td>
	   <td style="text-align:left">2017-04-31</td> 
	  </tr>
	  </tr>
	  <td colspan="1" style="font-weight:bold;text-align:left;padding: 40px;"><input type="button" style="font-weight:bold" class="btn" value="Modifier votre informations" onClick="changePage('modifierUtilisateur.php')"></td>
	  <td colspan="2" style="font-weight:bold;text-align:right;padding: 40px;"><input type="button" style="font-weight:bold" class="btn" value="Modifier votre mot de passe" onClick="changePage('changerPassword.php')"></td>
	  </tr>

	</table>
</div>
<?php require_once("footer.php"); ?>
</body>
</html>
