<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">

<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<body>
<?php
require_once("headerAdmin.php"); 
require_once "classe-mysql-2017-04-10a.php";
require_once "classe-fichier-2017-03-29a.php";
require_once "librairies-communes-2017-03-29a.php";

?>
<html>
<style>
body
{
	font-family: Arial, Helvetica, sans-serif;
	color: rgb(52,52,52);
}

tr,td,table
{
    border: 1px solid black;
    background: rgb(245,245,245);
    text-align: left;
    padding-right: 20px;
    padding-left: 20px;
    padding-top: 0px;
    padding-bottom: 10px;
}

td {overflow:hidden; white-space:nowrap}

.hideextra 
{ 
    white-space: nowrap; overflow: hidden; text-overflow:ellipsis; 
}

table
{
    border-collapse: collapse;
    border: 1px solid gray;
}

.textbox
{
   font-weight:bold;
}

.sTitreSection
{ 
   max-height: 24px;
}

.sTitre
{
    text-align: center;
}

</style>
<meta charset="UTF-8">
<script>
</script>
<body>
    <br/>
    <br/>
<table>
    <div align="center">
              
<?php 

  $strNomBD = "annonces_qwerty";
  $strInfoSensibles = "424w-cgodin-qc-ca.php";
   
  $strFichierAnnonces = "Annonces.txt";
  $strFichierCategories="Categories.txt";
  $strFichierConnexions = "Connexions.txt";
  $strFichierUtilisateurs = "Utilisateurs.txt";
  
  $strTableAnnonces ="Annonces";
  $strTableCategorie = "Categories";
  $strTableConnexions= "Connexions";
  $strTableUtilisateur = "utilisateurs";
  
  $oBD = new mysql($strNomBD, $strInfoSensibles);
   
if($oBD->selectionneEnregistrements($strTableUtilisateur,"STATUT=0 AND CREATION < DATE_ADD(NOW(),INTERVAL 30 DAY)"))
{
	echo "Les courriels ont été envoyés avec succès !";
}
else
{
	echo "L'envoie du courriel a rencontré un problème !";
}
?>
	</table>
    
</div>
             <?php require_once("footer.php"); ?>
</body>
</html>