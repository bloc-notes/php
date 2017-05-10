<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">

<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<body>
<?php require_once("headerAdmin.php"); 
    require_once("classe-fichier-2017-03-29a.php");
                require_once("classe-mysql-2017-04-10a.php");
                require_once("librairies-communes-2017-03-29a.php");
                ?>
<div align="center" style="max-width: 700px;margin-left: auto;margin-right: auto;padding-top:40px">
          <table> 

                    <td style="text-align:center"><br><span style="font-weight:bold;font-size: 40px;">Option de base de données</td>
          <tr>
            <td style="font-weight:bold;text-align:left;padding-top: 30px;" rowspan="1">
              Envoi d’un courriel à chaque utilisateur inscrit depuis plus d’un mois qui n’a pas encore confirmé son enregistrement. 
            </td>
            </tr>
            
        <tr>
           <td rowspan="1">
                <form>
               </form>
               
               <form action="http://424w.cgodin.qc.ca/qwerty/nettoyageEtat1.php">
                   <input id="nettoyageEtat2" name="nettoyageEtat2" type="submit" class="btn" style="font-weight:bold" value="Envoye courriel chaque utilisateur">
               </form>
           </td>
            </tr>
                <tr>
            <td style="font-weight:bold;text-align:left;padding-top: 30px;" rowspan="1">
              Suppression physique des utilisateurs qui se sont inscrits il y a plus de trois mois et qui n’ont pas encore confirmé leur enregistrement. Un courriel doit être envoyé systématiquement à chacun d’eux pour les avertir que leur dossier a été supprimé.
            </td>
            </tr>
            
            <tr>
            <td rowspan="1">
                <form action="http://424w.cgodin.qc.ca/qwerty/nettoyageEtat2.php">
                    <input id="nettoyageEtat2" name="nettoyageEtat2" type="submit" class="btn" style="font-weight:bold" value="Suppresion physique des utilisateurs inactifs">
                </form>
            </td>
            </tr>
                           <tr>
            <td style="font-weight:bold;text-align:left;padding-top: 30px;" rowspan="1">
              Suppression physique des annonces supprimées
            </td>
            </tr>
            <tr style="font-weight:bold;text-align:left;">
          <td rowspan="1">
              <form action="http://424w.cgodin.qc.ca/qwerty/nettoyageEtat3.php">
                  <input type="submit" class="btn" style="font-weight:bold" value="Supprimer physique des annonces">
              </form>
          </td>
            </tr> 
            </div>
        </table>
        <?php require_once("footer.php"); ?>
</body>
</html>