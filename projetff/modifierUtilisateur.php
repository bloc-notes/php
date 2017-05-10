<?php require_once("Doyon.php"); ?>
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<body>
<?php require_once("En-tete.php"); ?>
<div align="center" style="padding-top:40px">	
    <table>
	  <tr>

		    <td colspan="3" style="text-align:center"><br><span style="font-weight:bold;font-size: 60px;">Votre profil</span><br></td><td rowspan="10"></td>
	  </tr>
	    <tr>
	    <td style="vertical-align:middle;font-weight:bold;padding-top: 40px;">Courriel: </td>
	   <td style="padding-top: 40px;"> <input type="text" class="textbox" disabled valign="bottom"placeholder="Courriel"><br></td> 
	  </tr>
	   <tr>
	    <td style="vertical-align:middle;font-weight:bold;">Prénom: </td>
	   <td><input type="text" class="textbox" placeholder="Prénom"><br></td> 
	  </tr>
	   <tr>
	    <td style="vertical-align:middle;font-weight:bold;">Nom de famille: </td>
	   <td><input type="text" class="textbox" placeholder="Nom de famille"><br></td> 
	  </tr>
	   <tr>
	    <td style="vertical-align:middle;font-weight:bold;">Téléphone à domicile: </td>
	   <td><input type="text" class="textbox" placeholder="Téléphone à domicile"><br></td> 
	  </tr>
	   <tr>
	    <td style="vertical-align:middle;font-weight:bold;">Téléphone de travail: </td>
	   <td><input type="text" class="textbox" placeholder="Téléphone de travail"><br></td> 
	  </tr>
	  <td style="vertical-align:middle;font-weight:bold;">Téléphone portable: </td>
	   <td><input type="text" class="textbox" placeholder="Téléphone portable"><br></td> 
	  </tr>
	  <td style="vertical-align:middle;font-weight:bold;">Status employé: </td>
	   <td><input type="text" class="textbox" placeholder="Status Employé"><br></td> 
	  </tr>
	  <td style="vertical-align:middle;font-weight:bold;">Numéro employé: </td>
	   <td><input type="text" class="textbox" placeholder="Numéro employé"><br></td> 
	  </tr>

	  <tr>
	  <td colspan="3" style="padding: 40px;"><input type="button" align="center"style="font-weight:bold;margin-right:80px;" class="btn" value="
J'accepte les modifications" onClick="changePage('profilUtilisateur.php')">
<input type="button" align="center"style="font-weight:bold" class="btn" value="
Annuler les modifications" onClick="changePage('profilUtilisateur.php')"></td>
	  </tr>
	</table>
</div>
<?php require_once("footer.php"); ?>
</body>
</html>
