<?php 
$data = null;
if (isset($_POST['index'])) {
   $data = $_POST['index'];
   $Nom = $_POST['Nom'];
   $Prenom = $_POST['Prenom'];
   $NoTelMaison = $_POST['NoTelMaison'];
   $NoTelTravail = $_POST['NoTelTravail'];
   $NoTelCellulaire = $_POST['NoTelCellulaire'];
   $NoEmpl = $_POST['index'];
}
require_once("424w-cgodin-qc-ca.php");

$mysqli = new mysqli($strNomHost, $strNomAdmin, $strMotPasseAdmin, $strNomBD);
$myArray = array();
if ($result = $mysqli->query("UPDATE `utilisateurs` SET `Nom`='$Nom', `Prenom`='$Prenom',`NoTelMaison`='$NoTelMaison',`NoTelTravail`='$NoTelTravail',`NoTelCellulaire`='$NoTelCellulaire',`NoEmpl`='$NoEmpl' WHERE `NoUtilisateur`= '$data'")) 
{
	echo "Votre profil a été modifié avec succès !";
}
else
{
	echo "La modification a rencontré un problème !";
}


session_start();
$_SESSION["Nom"]=$Nom;
$_SESSION["Prenom"]=$Prenom;

$mysqli->close();
?>
