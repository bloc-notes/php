<?php
$Adresse= "test@hotmail.com";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
   <title>Valider le compte</title>
   <script type="text/javascript">

    </script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

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
  <td colspan="2" style="text-align:center"><br><span style="font-weight:bold;font-size: 30px;">Validation du nouveau compte QWERTY </td>
  </tr>
  <tr>
    <td colspan="2">Vous devez confirmer votre courrier électronique avant d'avoir accès à notre service.</td>
  </tr>
  <tr>
          <td colspan="1"><input id="btnRetour" name="btnCalculer" type="button" value="Retour à la page de connexion" onClick="changePage('index.php')" class="btn"/></td>
     <td colspan="1"> <input id="btnEnvoi" name="btnEnvoi" type="button" value="Envoyer un nouveau courriel" onClick="changePage('emailValidate.php')" class="btn"/></td> 
  </tr>
  </table>
        </div>
        <?php require_once("footer.php"); ?>
</body>        
</html>
