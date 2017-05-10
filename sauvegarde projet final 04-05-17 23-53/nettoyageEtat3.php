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

.sDisabled 
{
    color: #999;
}

input [type=submit]
{
    color: #999;
}

</style>
<meta charset="UTF-8">
<script>
</script>
<body>
<table>
             <tr>
             </tr>
             <br/>
             
         
              
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
   
   $oBD->selectionneEnregistrements($strTableAnnonces,"C=ETAT=3");
   
   if($oBD->_nbEnregistrements == 0)
   {
       "</br>";
       "</br>";
       echo "Aucune annonces à supprimer!";
?>
         
<table>
<form></form>
<form action="http://424w.cgodin.qc.ca/qwerty/nettoyageSucces3.php">
<input id="nettoyageSuccess" name="nettoyageSuccess" type="submit" class="btn" disabled="true" style="color:#999" value="Confirmer">
</form>

<form action="http://424w.cgodin.qc.ca/qwerty/nettoyageBaseDonnee.php">
<input id="nettoyageBaseDonnee" name="nettoyageBaseDonnee" type="submit" class="btn" style="font-weight:bold" value="Annuler">
</form>
</table>
             
<?php 
   }
   
   else
   {
?>
             
              <tr style="font-weight:bold">
            <td rowspan="1" colspan="6" class="sTitre"><?php echo "Données Annonces" ?></td>
            </tr>  
            <div align="center">
              <tr class="sTitreSection">
               <td rowspan="1" ><?php echo "No. Annonce" ?></td>
               <td rowspan="1" ><?php echo "No. Utilisateur" ?></td>
               <td rowspan="1"><?php echo "Parution" ?></td>
                <td rowspan="1"><?php echo "Catégorie" ?></td>
                <td rowspan="1"><?php echo "Description Abrégée" ?></td>
               <td rowspan="1"><?php echo "Prix" ?></td>
              </tr>
<?php
        for($i=0; $i<$oBD->_nbEnregistrements ; $i++)
        {
             $intNoAnnonce = $oBD->contenuChamp($i, 'NoAnnonce');
             $intUtilisateur = $oBD->contenuChamp($i, 'NoUtilisateur');
             $strParution = $oBD->contenuChamp($i, 'Parution');
             $intCategorie = $oBD->contenuChamp($i, 'Categorie');
             $strDescriptionAbregee = $oBD->contenuChamp($i, 'DescriptionAbregee');
             $intPrix =$oBD->contenuChamp($i, 'Prix');

 ?>
              
    <div align="center">
             <tr class="sTitreSection">
               <td rowspan="1" ><?php echo $intNoAnnonce  ?></td>
               <td rowspan="1"><?php echo $intUtilisateur ?></td>
                 <td rowspan="1"><?php echo $strParution ?></td>
                <td rowspan="1"><?php echo $intCategorie ?></td>
                <td rowspan="1"><?php echo $strDescriptionAbregee ?></td>
               <td rowspan="1"><?php echo $intPrix ?></td>
               
              </tr>
<?php
        }
?>
              
 <table>
<form></form>
<form action="http://424w.cgodin.qc.ca/qwerty/nettoyageSucces3.php">
<input id="nettoyageSuccess" name="nettoyageSuccess" type="submit" class="btn" style="font-weight:bold" value="Confirmer">
</form>
<form action="http://424w.cgodin.qc.ca/qwerty/nettoyageBaseDonnee.php">
<input id="nettoyageBaseDonnee" name="nettoyageBaseDonnee" type="submit" class="btn" style="font-weight:bold" value="Annuler">
</form>
</table>
              
<?php
    }
?>
	</table>
      <?php require_once("footer.php"); ?>
</div>
</body>
</html>