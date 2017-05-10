<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">

<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<body>
<?php require_once("headerAdmin.php"); ?>
<div align="center" style="max-width: 700px;margin-left: auto;margin-right: auto;padding-top:40px">
          <table> 

                    <td style="text-align:center"><br><span style="font-weight:bold;font-size: 40px;">Option de base de données</td>
          </tr>
          <tr>
                  <tr>
            <td style="font-weight:bold;text-align:left;padding-top: 30px;" rowspan="1">
              

              Envoi d’un courriel à chaque utilisateur inscrit depuis plus d’un mois qui n’a pas encore confirmé son enregistrement. 
            </td>
            </tr>

            <td style="font-weight:bold;text-align:left;" rowspan="1"> <input type="button" class="btn" style="font-weight:bold" value="Envoi un courriel à chaque utilisateur non-inscrit "></td>
            </tr>

                <tr>
            <td style="font-weight:bold;text-align:left;padding-top: 30px;" rowspan="1">
              

              Suppression physique des utilisateurs qui se sont inscrits il y a plus de trois mois et qui n’ont pas encore confirmé leur enregistrement. Un courriel doit être envoyé systématiquement à chacun d’eux pour les avertir que leur dossier a été supprimé.
            </td>
            </tr>
            <tr>
            <td rowspan="1"> <input type="button" class="btn" style="font-weight:bold" value="Suppression physique des utilisateurs non-inscrits et inactifs"></td>
            </tr>
                           <tr>
            <td style="font-weight:bold;text-align:left;padding-top: 30px;" rowspan="1">
              

              Suppression physique des annonces supprimées
            </td>
            </tr>
            <tr style="font-weight:bold;text-align:left;">
            <td rowspan="1"> <input type="button" class="btn" style="font-weight:bold" value="Suppression physique des annonces supprimées"></td>
            </tr> 
            </div>
        </table>
        <?php require_once("footer.php"); ?>
</body>
</html>