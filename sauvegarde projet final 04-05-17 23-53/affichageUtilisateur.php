<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<style>
td {overflow:hidden; white-space:nowrap}
</style>
<meta charset="UTF-8">
<script>
</script>
<body>
<?php require_once("Doyon.php"); require_once("header.php");?>
<table border="1">
             <tr>
             </tr>
               <tr style="font-weight:bold">
                 <td rowspan="1" colspan="10" class="sTitre"><?php echo "Données personelles" ?></td>
                 <td rowspan="1" colspan="6" class="sTitre"><?php echo "Données Connexion" ?></td>
                 <td rowspan="1" colspan="3" class="sTitre"><?php echo "Données annonces" ?></td>
                 <td rowspan="1" colspan="2" class="sTitre"><?php echo "Modification" ?></td>
                 <td rowspan="1" colspan="1" class="sTitre"><?php echo "Autres" ?></td>
             </tr>
                <div align="center">
  
              <tr class="sTitreSection">
              <td rowspan="1" class="sTitre" ><?php echo "Nb." ?></td>
               <td rowspan="1"  class="sTitre"><?php echo "Nom" ?></td>
               <td rowspan="1" class="sTitre"><?php echo "Prénom" ?></td>
                <td rowspan="1" class="sTitre"><?php echo "No. Utilisateur" ?></td>
                <td rowspan="1" class="sTitre"><?php echo "Courriel" ?></td>
               <td rowspan="1" class="sTitre"><?php echo "Date de Création" ?></td>
                <td rowspan="1" class="sTitre"><?php echo "Statut" ?></td>
               <td rowspan="1" class="sTitre"><?php echo "NoEmployé" ?></td>
               <td rowspan="1" class="sTitre"><?php echo "Téléphone Maison" ?></td>
               <td rowspan="1" class="sTitre"><?php echo "Téléphone Travail" ?></td>
               <td rowspan="1" class="sTitre"><?php echo "Téléphone Cellulaire" ?></td>
               <td rowspan="1" class="sTitre"><?php echo "Nb Connexions" ?></td>
               <td rowspan="1" class="sTitre "><?php echo "Connexion Plus Recent, Date et heure" ?></td>
               <td rowspan="1"  class="sTitre"><?php echo "Connexion, Date et heure" ?></td>
               <td rowspan="1"  class="sTitre"><?php echo "Connexion, Date et heure" ?></td>
               <td rowspan="1"  class="sTitre"><?php echo "Connexion, Date et heure" ?></td>
               <td rowspan="1"  class="sTitre"><?php echo "Connexion Moins Recent, Date et heure" ?></td>
               <td rowspan="1"  class="sTitre"><?php echo "Nombre d'annonces actives" ?></td>
               <td rowspan="1"  class="sTitre"><?php echo "Nombre d'annonces inactives" ?></td>
               <td rowspan="1"  class="sTitre"><?php echo "Nombre d'annonces supprimés" ?></td>
               <td rowspan="1" class="sTitre"><?php echo "Modification" ?></td>
               <td rowspan="1" class="sTitre"><?php echo "Autre Infos" ?></td>
              </tr>
<?php 
for($i = 1; $i<=75; $i++)
{
    ?>
	
              <tr class="sTitreSection">
              <td rowspan="1" ><?php echo "00001" ?></td>
               <td rowspan="1" ><?php echo "Roy" ?></td>
               <td rowspan="1"><?php echo "Gabriel" ?></td>
                <td rowspan="1"><?php echo "50343" ?></td>
                <td rowspan="1"><?php echo "justwoww@hotmail.com" ?></td>
               <td rowspan="1"><?php echo "2017/04/10" ?></td>
                <td rowspan="1"><?php echo "Actif" ?></td>
               <td rowspan="1"><?php echo "1921063" ?></td>
               <td rowspan="1"><?php echo "514-624-8042" ?></td>
               <td rowspan="1"><?php echo "514-624-8042" ?></td>
               <td rowspan="1"><?php echo "514-624-8042" ?></td>
               <td rowspan="1"><?php echo "378" ?></td>
               <td rowspan="1" class="sTitreSection"><?php echo "Connexion Plus Recent, Date et heure" ?></td>
               <td rowspan="1"  class="sTitreSection"><?php echo "Connexion, Date et heure" ?></td>
               <td rowspan="1"  class="sTitreSection"><?php echo "Connexion, Date et heure" ?></td>
               <td rowspan="1"  class="sTitreSection"><?php echo "Connexion, Date et heure" ?></td>
               <td rowspan="1"  class="sTitreSection"><?php echo "Connexion Moins Recent, Date et heure" ?></td>
               <td rowspan="1"  class="sTitreSection"><?php echo "Nombre d'annonces actives" ?></td>
               <td rowspan="1"  class="sTitreSection"><?php echo "Nombre d'annonces inactives" ?></td>
               <td rowspan="1"  class="sTitreSection"><?php echo "Nombre d'annonces supprimés" ?></td>
               <td rowspan="1"><?php echo "2017/03/10" ?></td>
               <td rowspan="1"><?php echo "N/A" ?></td>
              </tr>
<?php
}
?>
	</table>
</div>
<?php require_once("footer.php"); ?>
</body>
</html>