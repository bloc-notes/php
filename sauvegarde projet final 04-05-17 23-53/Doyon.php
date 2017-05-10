<?php
session_start();
//Si la personne n'a pas le doit d'être sur cette page
if(!(basename($_SERVER['SCRIPT_NAME']) == "index.php" || basename($_SERVER['SCRIPT_NAME']) == "enregistrement.php"  
        || basename($_SERVER['SCRIPT_NAME']) == "PleaseValidate.php" || basename($_SERVER['SCRIPT_NAME']) == "emailValidate.php" 
        || basename($_SERVER['SCRIPT_NAME']) == 'changerPasswordAnonyme.php') && (isset($_SESSION["NoUtilisateur"]) != 1)){
?>
<script>location.href = 'index.php';</script>
<?php
}

/*
//require_once("classe-mysql-2017-mm-jj.php");
$strInfosSensibles="424w-cgodin-qc-ca.php";
$testmySQL = new mysql($strNomBD, $strInfosSensibles); 
$testmySQL->selectQuery("SELECT * FROM utilisateurs where NoUtilisateur = '$strUtilisateur'");
$_SESSION["Nom"]=$testmySQL->contenuChamp(0 , "Nom");
$_SESSION["Prenom"]=$testmySQL->contenuChamp(0 , "Prenom");
*/

/*
require_once("424w-cgodin-qc-ca.php");

$mysqli = new mysqli($strNomHost, $strNomAdmin, $strMotPasseAdmin, $strNomBD);
$myArray = array();
if ($result = $mysqli->query("SELECT * FROM utilisateurs where NoUtilisateur = '$strUtilisateur'")) 
{
$_SESSION["Nom"]=$testmySQL->contenuChamp(0 , "Nom");
$_SESSION["Prenom"]=$testmySQL->contenuChamp(0 , "Prenom");
}
$mysqli->close();
*/


//Si manque prénom ou nom

if(basename($_SERVER['SCRIPT_NAME']) == "modifierUtilisateur.php" ){
    echo "<script>alert(\"Vous devez inscrire un prénom et un nom obligatoirement!\")</script>";
}

if((isset($_SESSION["NoUtilisateur"]) == true ) && ($_SESSION["Prenon"] == "" || $_SESSION["Nom"] == "") 
        && !((basename($_SERVER['SCRIPT_NAME']) == "modifierUtilisateur.php" || basename($_SERVER['SCRIPT_NAME']) == "deconnexion.php"))){  
?>
<script>location.href = 'modifierUtilisateur.php';</script>
<?php
}