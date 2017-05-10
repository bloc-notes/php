<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<body>


<header>
   <form id="frmSaisie" method="" action="">
      <div id="divEntete" class="sEntete">
         <p class="sTitreApplication" >
            QWERTY
         </p>
                  <p class=" rainbow" >
            L
         </p>
      </div>
           </header>

<div align="center">
	<table>
	  <tr>
	    <td colspan="1"><br><span style="font-weight:bold">Changement du mot de passe</span><br></td>
	  </tr>
	  <tr>
	   <td><input type="password" class="textbox" placeholder="Courriel"><br></td> 
	  </tr>
	  <tr>
	    <td><input type="password" class="textbox" placeholder="Nouveau de passe"><br></td>
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
