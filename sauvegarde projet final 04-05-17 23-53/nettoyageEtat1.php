


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
   
  $oBD->selectionneEnregistrements($strTableUtilisateur,"C=STATUT=0 AND CREATION < DATE_ADD(NOW(),INTERVAL 30 DAY)");
  
  if($oBD->_nbEnregistrements ==0)
  {
      "</br>";
      echo "Aucun utilisateur trouvé!";
      
?>
             
<table>
<form></form>
<form action="http://424w.cgodin.qc.ca/qwerty/nettoyageSucces1.php">
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
      <td rowspan="1" colspan="10" class="sTitre"><?php echo "Données personelles" ?></td>
      </tr>
     <div align="center">
              <tr class="sTitreSection">
               <td rowspan="1" ><?php echo "Nom" ?></td>
               <td rowspan="1"><?php echo "Prénom" ?></td>
                <td rowspan="1"><?php echo "No. Utilisateur" ?></td>
                <td rowspan="1"><?php echo "Courriel" ?></td>
               <td rowspan="1"><?php echo "Creation" ?></td>
                <td rowspan="1"><?php echo "Statut" ?></td>
               <td rowspan="1"><?php echo "NoEmployé" ?></td>
               <td rowspan="1"><?php echo "Téléphone Maison" ?></td>
               <td rowspan="1"><?php echo "Téléphone Travail" ?></td>
               <td rowspan="1"><?php echo "Téléphone Cellulaire" ?></td>
              </tr>
              
   <?php
   for($i=0; $i<$oBD->_nbEnregistrements ; $i++)
   {
        
        $strNom = $oBD->contenuChamp($i, 'Nom') == null? "NULL": $oBD->contenuChamp($i, 'Nom');
        $strPrenom = $oBD->contenuChamp($i, 'Prenom') == null? "NULL": $oBD->contenuChamp($i, 'Prenom');
        $intNoUtilisateur = $oBD->contenuChamp($i, 'NoUtilisateur');
        $strCourriel = $oBD->contenuChamp($i, 'Courriel');
        $strCreation = $oBD->contenuChamp($i, 'Creation') ;
   

        switch($oBD->contenuChamp($i, 'Statut'))
        {
            case 0:
            $strStatut = "En attente";
            break;

            case 9:
            $strStatut = "Confirmé";
            break;

            case 1:
            $strStatut = "Administrateur";
            break;

            case 2:
            $strStatut = "Cadre";
            break;

            case 3:
            $strStatut = "Employé de soutien";
            break;

            case 4:
            $strStatut = "Enseignant";
            break;

            case 5:
            $strStatut = "Professionnel";
            break;
        }

        $intNoEmploye = $oBD->contenuChamp($i, 'NoEmpl') == null ? 0 : $oBD->contenuChamp($i, 'NoEmpl');
        $strTelephoneMaison = $oBD->contenuChamp($i, 'NoTelMaison')  == null ? "NULL" :  $oBD->contenuChamp($i, 'NoTelMaison');
        $strTelephoneTravail = $oBD->contenuChamp($i, 'NoTelTravail')  == null ? "NULL" :  $oBD->contenuChamp($i, 'NoTelTravail');
        $strTelephoneCellulaire = $oBD->contenuChamp($i, 'NoTelCellulaire')  == null ? "NULL" : $oBD->contenuChamp($i, 'NoTelCellulaire');
?>
              
    <div align="center">
             <tr class="sTitreSection">
               <td rowspan="1" ><?php echo $strNom  ?></td>
               <td rowspan="1"><?php echo $strPrenom ?></td>
                <td rowspan="1"><?php echo $intNoUtilisateur ?></td>
                <td rowspan="1"><?php echo $strCourriel ?></td>
               <td rowspan="1"><?php echo $strCreation ?></td>
                <td rowspan="1"><?php echo $strStatut ?></td>
               <td rowspan="1"><?php echo $intNoEmploye ?></td>
               <td rowspan="1"><?php echo $strTelephoneMaison ?></td>
               <td rowspan="1"><?php echo $strTelephoneTravail ?></td>
               <td rowspan="1"><?php echo $strTelephoneCellulaire ?></td>
              </tr>
<?php
        }
        
        ?>
<table>
<form></form>
<form action="http://424w.cgodin.qc.ca/qwerty/nettoyageSucces1.php">
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
</body>
</html>