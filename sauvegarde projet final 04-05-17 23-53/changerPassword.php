<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<body>
<?php require_once("Doyon.php");require_once("header.php"); ?>
<div align="center" style="padding-top:40px">
	<table>
	  <tr>
	    <td colspan="1"><br><span style="font-weight:bold">Changement du mot de passe</span><br></td>
	  </tr>
	  <tr>
	   <td><input type="password" class="textbox" placeholder="Ancient mot de passe"><br></td> 
	  </tr>
	  <tr>
	    <td><input type="password" class="textbox" placeholder="Nouveau mot de passe"><br></td>
	  </tr>
	  <tr>
	    <td><input type="password" class="textbox" placeholder="Confirmez votre nouveau mot de passe"><br></td>
	  </tr>
	    <tr>
	    <td colspan="1"><input type="button" style="font-weight:bold" class="btn" value="Confirmer" onClick="changePage('PleaseValidate.php')">&nbsp;&nbsp;&nbsp;<input type="button" style="font-weight:bold" class="btn" value="Annuler" onClick="changePage('index.php')"><br></td>
	  </tr> 

	</table>
</div>
<?php require_once("footer.php"); ?>
</body>
</html>
