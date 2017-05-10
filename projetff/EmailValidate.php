<?php
$adresseEmail = "test@hotmail.com";
?>

<!DOCTYPE html>
<html>
<head>
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
        
      </div>
           </header>


   <div align="center">


  <table>
  <tr>
  <td colspan="2" style="text-align:center"><br><span style="font-weight:bold;font-size: 30px;">Validation du nouveau compte QWERTY </td>
  </tr>
  <tr>
    <td colspan="2">Votre e-mail a été confirmé. Vous avez maintenant accès à nos produits!</td>
  </tr>
  <tr>

     <td colspan="2"> <input id="btnRetour" name="btnCalculer" type="button" value="Revenir à la page de connexion" onClick="changePage('index.php')" class="btn"/></td> 
  </tr>
  </table>
</div>
        <?php require_once("footer.php"); ?>
</body>
</html>

