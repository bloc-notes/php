<?php
$Destinataire = "test auteur";
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
   <title>Contacter Auteur</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>


<body>
<?php require_once("Doyon.php"); require_once("header.php"); ?>
    <div align="center" style="padding-top:60px">
	<table border="0">
  <tr><td colspan="2" style="padding-top: 20px;""><span style="font-weight:bold;">Vers:</span></td></tr>
          <tr><td colspan="2"><input type="text" class="textbox" value="ITSDD10@ICAM.COM (Hubert, Saint)" placeholder="Courriel" style=" width: 600px;"></tr>
          <tr><td colspan="2"><span style="font-weight:bold">CC:</span></td></tr>
          <tr><td colspan="2"><input type="text" class="textbox" value="ProduitCC@ISO.COM (Giroux, Jean), ProduitBC@ISO.COM  (Valdor, Victoria)" placeholder="Courriel" style=" width: 600px;"></td></tr>
          <tr><td colspan="2"><span style="font-weight:bold">Message:</span></td></tr>
          <tr><td colspan="2"><textarea class="textbox" rows="10" cols="77" style="resize: none;width: 600px;" >Bonjour Monsieur,
                    </textarea></td></tr>
	  <tr>		
	  <td colspan="1"><input id="btnRetour" name="btnCalculer" type="button" value="Retour à la page des annonces" onclick="changePage('affichageAnnonce.php')" class="btn" /></td>
	  <td colspan="1"><input id="btnEnvoi" name="btnEnvoi" type="button" value="Envoyer le message courriel" onclick="EnvoiCourriel()" class="btn" /></td>
	  </tr>
          <tr><td colspan="2"><span id="MessageCourriel" style="font-weight:bold"></td></span></tr>
	</table>
    </div>
    <?php require_once("footer.php"); ?>
</body>

</html>

